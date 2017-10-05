<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth {
    public static $_instance;
    public static function instance()
    {
        if ( ! isset(Auth::$_instance))
        {
            // Create a new session instance
            Auth::$_instance = new Auth();
            //session_start();
        }
        return Auth::$_instance;
    }
    public $_users = array( 'admin' => '80ce6d7b39df1de2d15c323207fae4abd242694f6670b6e1e2c27b5752efaa25');

    public function logged_in() {
        return ($this->get_user() !== NULL);
    }

    public function get_user() {
        if (isset($_SESSION['auth_user'])) return $_SESSION['auth_user'];
        return NULL;
    }
    public function hash($str)
    {
        return hash_hmac('sha256', $str, '123');
    }

    public function login($username, $password) {
        if (is_string($password))
        {
            // Create a hashed password
            $password = $this->hash($password);
        }

        if (isset($this->_users[$username]) AND $this->_users[$username] === $password)
        {
            // Complete the login
            return $_SESSION['auth_user'] =  $username;
        }

        // Login failed
        return FALSE;
    }

    public function logout() {
        unset($_SESSION['auth_user']);
    }
}