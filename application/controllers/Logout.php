<?php defined('BASEPATH') or die('No direct access allowed.');

class Logout extends CI_Controller {
    public function index()
    {
        $this->user_model->logout();
        if ($_SERVER['HTTP_REFERER'])
            redirect($_SERVER['HTTP_REFERER']);
        else
            redirect("welcome");
        exit;
    }
}