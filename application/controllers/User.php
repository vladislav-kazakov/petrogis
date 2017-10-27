<?php defined('BASEPATH') or die('No direct access allowed.');

class User extends CI_Controller {
    public function create()
    {
        // Handled from a form with inputs with names email / password
        if (!$this->user_model->logged_in()) return;
        if (!$this->user_model->admin()) return;
        $this->user_model->create($this->input->get('login'), $this->input->get('password'), $this->input->get('rights'));
    }
}