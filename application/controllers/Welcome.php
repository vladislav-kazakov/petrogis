<?php defined('BASEPATH') OR die('No Direct Script Access');
 
class Welcome extends CI_Controller
{

    public function index()
    {
        $this->load->model('Auth');
        $logged_in = $this->user_model->logged_in();

        $this->load->view('header', array(
            'menu' => 'home',
            'logged_in' => $logged_in,
            'username' => $this->user_model->get_user()
        ));
        $this->load->view('site', array(
            'message' => 'hello, world!'
        ));
        $this->load->view('footer');

    }
}