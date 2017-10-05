<?php defined('BASEPATH') or die('No direct access allowed.');

class Login extends CI_Controller {
    public function index()
    {
        // Handled from a form with inputs with names email / password

        $success =  $this->user_model->login($this->input->post('email'), $this->input->post('password'));
        if ($success) {
            // Login successful, send to app
            //print_r($this->request->referrer());exit;
            if ($_SERVER['HTTP_REFERER'])
                redirect($_SERVER['HTTP_REFERER']);
            else
                redirect("welcome");
            exit;
        } else {
            echo 'Login failed, send back to form with error message';
            // Login failed, send back to form with error message
        }
    }
}