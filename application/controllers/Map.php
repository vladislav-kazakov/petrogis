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
            array_push($json_petroglyphs, array('name' => $petroglyph->name,
                                                'lat' => $petroglyph->lat,
                                                'lng' => $petroglyph->lng,
                                                'image' => $image
                ));
        }

        $json_petroglyphs = json_encode ($json_petroglyphs, JSON_UNESCAPED_UNICODE);
        $this->load->view('map', array('json_petroglyphs' => $json_petroglyphs));

        $this->load->view('footer');
    }
}