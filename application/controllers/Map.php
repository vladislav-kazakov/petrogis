<?php defined('BASEPATH') or die('No direct access allowed.');

class Map extends CI_Controller {
    public function index()
    {
        $logged_in = $this->user_model->logged_in();
        if (!$logged_in) redirect('welcome');

        $this->load->view('header', array(
            'menu' => 'map',
            'logged_in' => $logged_in,
            'username' => $this->user_model->get_user()
        ));


        $this->load->model('petroglyph_model');

        if ($this->input->post('name')) 
            $petroglyphs =$this->petroglyph_model->search($this->input->post('name'));
        else $petroglyphs = $this->petroglyph_model->load_list();
        $json_petroglyphs = array();
        foreach($petroglyphs as $petroglyph) {
            $image = $petroglyph->image != null ? base_url() ."petroglyph/image/" . $petroglyph->id : null;
            array_push($json_petroglyphs, array('id' => $petroglyph->id ,
                                                'name' => $petroglyph->name,
                                                'lat' => $petroglyph->lat,
                                                'lng' => $petroglyph->lng,
                                                'image' => $image
                ));
        }
        $map_provider = 'google';
        if (isset($_GET['map_provider']))
        {
            setcookie('map_provider', $_GET['map_provider'], time()+60*60*24*30 , "/");
            $map_provider = $_GET['map_provider'];
        }
        else if (isset($_COOKIE['map_provider']) && $_COOKIE['map_provider'] == 'yandex') $map_provider = 'yandex';
        $json_petroglyphs = json_encode ($json_petroglyphs, JSON_UNESCAPED_UNICODE);
        $this->load->view('map', array('json_petroglyphs' => $json_petroglyphs, 'map_provider' => $map_provider));

        $this->load->view('footer');
    }
}