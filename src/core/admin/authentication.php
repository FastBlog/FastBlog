<?php
/**
 * FastBlog | authentication.php
 * ACP authentication class
 * License: BSD-2-Clause
 */
namespace FastBlog\Core;

use \ORM;

class ACPAuthentication {

    private $config;
    protected $authenticated = false;

    public function __construct($config) {
        $this->config = $config;
        if(isset($_COOKIE['fb_auth_tkn'])) {
            $session = ORM::forTable('admin_sessions')->where(array(
                'session_id' => session_id(),
                'token' => $_COOKIE['fb_auth_tkn']
            ))->findOne();
            if($session) {
                if($session->get('ip') == $_SERVER['REMOTE_ADDR']) {
                    $this->authenticated = true;
                } else {
                    $session->delete();
                }
            }
        }
    }

    public function isAuthenticated() {
        return $this->authenticated;
    }

    public function comparePassword($email, $password) {
        $user = ORM::forTable('admin')->where(array('email' => $email))->findOne();
        if($user){
            return password_verify($password, $user->get('password'));
        }
        return false;
    }

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
            setcookie('fb_auth_tkn', $token, time() + (86400 * 30),"/" + $this->config["paths"]["admin"], "", $this->config["https"]);
        } else {
            setcookie('fb_auth_tkn', $token, 0,"/" + $this->config["paths"]["admin"], "", $this->config["https"]);
        }
    }

    public function logout(){
        ORM::forTable('admin_sessions')->where(array(
            'session_id' => session_id()
        ))->findOne()->delete();
    }
}