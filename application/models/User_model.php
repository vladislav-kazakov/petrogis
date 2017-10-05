<?php defined('BASEPATH') or die('No direct access allowed.');

class User_model extends CI_Model
{
    public function __construct()
    {
        if (!isset($_SESSION)) session_start();
        $this->load->database();
    }

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

        $user = $this->load($username, $password);
        if ($user)
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

    public function load($login, $password)
    {
        $query = $this->db->get_where('users', array('login' => $login, 'password' => $password));
        return $query->row();
    }
/*
    public function load_list()
    {
        $this->db->where('deleted', FALSE);
        $query = $this->db->get('petroglyphs');
        return $query->result();
    }

    public function search($name)
    {
        $this->db->where('deleted', FALSE);
        $this->db->where('name LIKE', '%' . $name . '%');
        $query = $this->db->get('petroglyphs');
        return $query->result();
    }

    public function load($id)
    {
        //$query = $this->db->get('petroglyphs');
        //return $query->result();

        if($id != FALSE) {
            $query = $this->db->get_where('petroglyphs', array('id' => $id));
            return $query->row();
        }
        else {
            return FALSE;
        }

    }

    public function delete($id)
    {
        $this->db->where('id', $id);
        $data = array('deleted' => TRUE);
        $this->db->update('petroglyphs', $data);
        //if ($result) return $id;
    }

    public function save($id, $data)
    {
        $result = false;
//        $query = $this->db->get_where('petroglyphs', array('id' => $id));
//        $petroglyph = $query->row();
        if ($id)
        {
//            if (!$petroglyph->uuid) $this->db->set('uuid', 'UUID()');
            $this->db->where('id', $id);
            $result = $this->db->update('petroglyphs', $data);
            if ($result) return $id;
        }
        else
        {
            $this->db->set('uuid', 'UUID()', FALSE);
            $result = $this->db->insert('petroglyphs', $data);
            if ($result) return $this->db->insert_id();
        }
        return $result;
    }
*/
}