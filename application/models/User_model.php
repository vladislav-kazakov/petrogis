<?php defined('BASEPATH') or die('No direct access allowed.');

class User_model extends CI_Model
{
    const RIGHTS_USER = 0;
    const RIGHTS_ADMIN = 1;
    const RIGHTS_REVIEWER = 2;

    public function __construct()
    {
        if (!isset($_SESSION)) session_start();
        $this->load->database();
    }

    public function logged_in()
    {
        return ($this->get_user() !== NULL);
    }

    public function admin()
    {
        return ($this->can(self::RIGHTS_ADMIN));
    }

    public function reviewer()
    {
        return (isset($_SESSION['auth_rights']) && $_SESSION['auth_rights'] == self::RIGHTS_REVIEWER);
    }

    public function get_user()
    {
        if (isset($_SESSION['auth_user'])) return $_SESSION['auth_user'];
        return NULL;
    }

    public function hash($str)
    {
        return hash_hmac('sha256', $str, '123');
    }

    public function login($username, $password)
    {
        if (is_string($password)) {
            // Create a hashed password
            $password = $this->hash($password);
        }

        $user = $this->load($username, $password);
        if ($user) {
            // Complete the login
//            $_SESSION['auth_rights'] = $user->rights;
            return $_SESSION['auth_user'] = $username;
        }

        // Login failed
        return FALSE;
    }

    public function logout()
    {
        unset($_SESSION['auth_rights']);
        unset($_SESSION['auth_user']);
    }

    public function create($login, $password, $rights)
    {
        $this->db->set('login', $login);
        $this->db->set('password', $this->hash($password));
        $this->db->set('rights', $rights);
        $result = $this->db->insert('users');
    }

    public function load($login, $password)
    {
        $query = $this->db->get_where('users', array('login' => $login, 'password' => $password));
        return $query->row();
    }

    public function can($role)
    {
        $query = $this->db->get_where('users', array(
            'login' => $_SESSION['auth_user'],
            'rights' => $role
        ));

        return $query->row();
    }
}