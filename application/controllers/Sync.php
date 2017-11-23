<?php defined('BASEPATH') or die('No direct access allowed.');
ini_set("display_errors", "1");
error_reporting(E_ALL);
class Sync extends CI_Controller {
    public function uuids()
    {
        $this->load->database();
        $this->db->select('uuid');
        $query = $this->db->get('petroglyphs');
        $result = $query->result_array();
//        $result = array_keys($query->execute()->as_array('uuid'));
        $data = array();
        foreach ($result as $item) {
            $data[] = $item['uuid'];
        }
        echo json_encode($data);
        //print_r($result);
        //$petroglyphs = ORM::factory('Petroglyph')->find_all()->as_array("");
    }

    public function upload()
    {
//        $petroglyph_id = $this->request->param('id');
        $post = $this->request->post();
        if ($post) {
            $petroglyph = ORM::factory('Petroglyph')->where('uuid', '=', $post['uuid'])->find();
            if ($petroglyph->loaded()) return;
            $petroglyph = new Model_Petroglyph();

            $petroglyph->uuid = $this->input->post('uuid');
            $petroglyph->name = $this->input->post('name');
            $petroglyph->lat = $this->input->post('lat');
            $petroglyph->lng = $this->input->post('lng');
          //  if (isset($post['method'])) $petroglyph->method = $post['method'];
          //  if (isset($post['culture'])) $petroglyph->culture = $post['culture'];
          //  $petroglyph->description = $post['description'];

            if ($petroglyph->save()) {
                if ($_FILES) $this->_upload($petroglyph);
            }
            else {
                print_r("petroglyph sync: failed!");
            }
        } else print_r("petroglyph sync: no post data");

    }

    public function _upload($petroglyph_id)
    {
        if ($_FILES) {
            if ($_FILES['image']['name']) {
                $this->load->model('petroglyph_model');
                $petroglyph = $this->petroglyph_model->load($petroglyph_id);

                $name = $_FILES['image']['name']; // Save file name
                $fstype = '';
                if (preg_match("/\.\w+/i", $name, $matches)) $fstype = $matches[0];

                $fsname = uniqid(/*md5(Session::instance()->get('auth_user'))*/) . $fstype;
                $dir = FCPATH . 'data' . DIRECTORY_SEPARATOR . 'petroglyph' . DIRECTORY_SEPARATOR . 'image' . DIRECTORY_SEPARATOR;

                if (!file_exists($dir)) mkdir($dir, '0777', TRUE);

                $config['upload_path'] = $dir;
                $config['file_name'] = $fsname;
                $config['allowed_types'] = 'gif|jpg|png';
                $this->load->library('upload', $config);
                $this->upload->do_upload('image');
                //echo $this->upload->display_errors(); exit;

                //remove old image file from fs
                if ($petroglyph && $petroglyph->image && file_exists($dir . $petroglyph->image)) unlink($dir . $petroglyph->image);
                $this->petroglyph_model->save($petroglyph_id, array("image" => $fsname));
            } else {
                //todo: handle file upload error
            }
        }
    }
}