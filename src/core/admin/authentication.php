<?php
/**
 * FastBlog | authentication.php
 * ACP authentication class
 * License: BSD-2-Clause
 */
namespace FastBlog\Core;

use \ORM, \DateTime;

class ACPAuthentication {

    private $config;
    protected $authenticated = false;

    public function __construct($config) {
        $this->config = $config;
        if(isset($_COOKIE['fb_auth_tkn'])) {
            $session = ORM::forTable('admin_sessions')->where(array(
                'session_id' => session_id(),
                'token' => $_COOKIE['fb_auth_tkn'],
                'ip' => $_SERVER['REMOTE_ADDR']
            ))->findOne();
            if($session) {
                $interval = DateTime::createFromFormat('Y-m-d H:i:s', $session->get('start'))->diff(new DateTime('Y-m-d H:i:s'));
                if($interval->d < 30) {
                    $this->authenticated = true;
                }
            }

            if(!$this->authenticated) {
                $session->delete();
                $this->unsetCookies();
            }
        }
    }

    /**
     * Return if an user is logged or not
     * @return bool
     */
    public function isAuthenticated() {
        return $this->authenticated;
    }

    /**
     * Verify the correction of an user password upon login
     * @param $email
     * @param $password
     * @return bool
     */
    public function comparePassword($email, $password) {
        $user = ORM::forTable('admin')->where(array('email' => $email))->findOne();
        if($user){
            return password_verify($password, $user->get('password'));
        }
        return false;
    }

    /*
     * The client side session is currently detected using:
     *   - Token (stored in the 'fb_auth_tkn' cookie)
     *   - IP (implicitly detected by fb)
     *
     * The session is stored using:
     *   - Admin ID
     *   - Session ID
     *   - Starting date-time
     *   - IP (using during logon)
     *   - Token (the sme stored client side)
     */

    /**
     * Create a session given the user id (and a boolean used to remember the session client-side)
     * @param $user_id
     * @param $rememberme
     */
    public function createSession($user_id, $rememberme) {
        $token = bin2hex(openssl_random_pseudo_bytes(16));
        $now = date('Y-m-d H:i:s');
        ORM::forTable('admin_sessions')->create(array(
            'admin_id' => $user_id,
            'session_id' => session_id(),
            'start' => $now,
            'ip' => $_SERVER['REMOTE_ADDR'],
            'token' => $token
        ));

        if($rememberme) {
            setcookie('fb_auth_tkn', $token, time() + (86400 * 30),"/".$this->config["paths"]["admin"], "", $this->config["https"]);
        } else {
            setcookie('fb_auth_tkn', $token, 0,"/".$this->config["paths"]["admin"], "", $this->config["https"]);
        }

        $user = ORM::forTable('admin')->findOne($user_id);

        $_SESSION['username'] = $user->get('username');
        $_SESSION['email'] = $user->get('email');
    }

    /**
     * Completely delete a session (db entry included)
     */
    public function destroySession(){
        ORM::forTable('admin_sessions')->where(array(
            'session_id' => session_id()
        ))->findOne()->delete();
        $this->unsetCookies();
        $this->destroy();
    }

    /**
     * Unset 'session' and 'fb_auth_tkn' cookies
     */
    public function destroy(){
        unset($_COOKIE['fb_auth_tkn']);
        session_destroy();
    }
}
