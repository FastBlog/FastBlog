<?php
/**
 * FastBlog | authentication.php
 * //File description
 * License: BSD-2-Clause
 */

use \ORM;

class Authentication {

    protected $authenticated = false;

    public function __construct() {
        if((isset($_SESSION['TIME']) && $_SESSION['TIME'] > time() - (7 * 24 * 60 * 60)) && isset($_COOKIE['fb_auth_tkn']) && ORM::forTable('admin_sessions')->where(array(
            'ip' => $_SERVER['REMOTE_ADDR'],
            'token' => $_COOKIE['fb_auth_tkn']
            ))->findOne()) {
                $this->authenticated = true;
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

    public function authenticateUser($user_id) {
        $token = bin2hex(openssl_random_pseudo_bytes(16));
        ORM::forTable('admin_sessions')->create(array(
            'admin_id' => $user_id,
            'ip' => $_SERVER['REMOTE_ADDR'],
            'token' => $token
        ));

        $_SESSION['TIME'] = time();
        $_COOKIE['fb_auth_tkn'] = $token;
    }
}