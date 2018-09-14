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
    public function download($petroglyph_uuid)
    {
        $this->load->database();
        //$this->db->select('uuid');
        $query = $this->db->get_where('petroglyphs', array('uuid' => $petroglyph_uuid));
        $result = $query->row();
        $data = array();
        //String 0 - id,  1 - name, 2 - String uuid, 3 - double lat, 4 - double lng, 5 - String filename
        $data[0] = $result->id;
        $data[1] = $result->name;
        $data[2] = $result->uuid;
        $data[3] = $result->lat;
        $data[4] = $result->lng;
        $data[5] = $result->image;
        $data[6] = $result->deleted;
        $data[7] = $result->orientation_x;
        $data[8] = $result->orientation_y;
        $data[9] = $result->orientation_z;

        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        //print_r($result);
        //$petroglyphs = ORM::factory('Petroglyph')->find_all()->as_array("");
    }
    public function downloadimage($petroglyph_id)
    {
        $this->load->helper('file');
        $res = 800;
        $this->load->model('petroglyph_model');
        $petroglyph = $this->petroglyph_model->load($petroglyph_id);

        if ($petroglyph->image) {
            $filePath = "cache/petroglyph/image".$res."/" . $petroglyph->image;
            if (!file_exists($filePath)) {
                $img_src = "data/petroglyph/image/" . $petroglyph->image;


                $config['image_library'] = 'gd2';
                $config['source_image'] = $img_src;
                $config['new_image'] = $filePath;
                $config['create_thumb'] = FALSE;
                $config['maintain_ratio'] = TRUE;
                $config['width']         = $res;
                $config['height']       = $res;

                $this->load->library('image_lib', $config);
                $this->image_lib->resize();

                $this->output->set_content_type(get_mime_by_extension($filePath));
                $this->output->set_output(file_get_contents($filePath));
                // Нужно задать заголовок ответа. А он зависит от типа файла.
            }
            $this->output->set_content_type(get_mime_by_extension($filePath));
            $this->output->set_output(file_get_contents($filePath));
        }
    }
    public function upload()
    {
//        $petroglyph_id = $this->request->param('id');
        //$post = $this->input->post;
        if ($this->input->post('uuid')) {
            if ($this->petroglyph_model->loadbyUuid($this->input->post('uuid'))) return;
            $data = array();

            $data['uuid'] = $this->input->post('uuid');
            $data['name'] = $this->input->post('name');
            $data['lat'] = $this->input->post('lat');
            $data['lng'] = $this->input->post('lng');
            $data['orientation_x'] = $this->input->post('orientation_x');
            $data['orientation_y'] = $this->input->post('orientation_y');
            $data['orientation_z'] = $this->input->post('orientation_z');

            $result = $this->petroglyph_model->save(null, $data);
            if ($result) {
                if ($_FILES) $this->_upload($result);
            } else {
                print_r("petroglyph sync: failed!");
            }
        }
        else print_r("petroglyph sync: no post data");
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
    public function _uploadFromFile($petroglyph_id, $filePath, $fileName)
    {
        $this->load->model('petroglyph_model');
        $petroglyph = $this->petroglyph_model->load($petroglyph_id);

        $name = $fileName; // Save file name
        $fstype = '';
        if (preg_match("/\.\w+/i", $name, $matches)) $fstype = $matches[0];

        $fsname = uniqid(/*md5(Session::instance()->get('auth_user'))*/) . strtolower($fstype);
        $dir = FCPATH . 'data' . DIRECTORY_SEPARATOR . 'petroglyph' . DIRECTORY_SEPARATOR . 'image' . DIRECTORY_SEPARATOR;

        if (!file_exists($dir)) mkdir($dir, '0777', TRUE);
        copy($filePath, $dir . $fsname);

        $this->petroglyph_model->save($petroglyph_id, array("image" => $fsname));
    }

    public function _addMaterialFromFile($petroglyph_id, $filePath, $fileName)
    {
        $data = array();
        $data['name'] = $fileName;
        $data['type'] = 'image';
        $data['description'] = $fileName;
        $data['petroglyph_id'] = $petroglyph_id;

        $result = $this->material_model->save(NULL, $data);
        if ($result) $this->_uploadMaterialFromFile($result, $filePath, $fileName);
    }
    public function _uploadMaterialFromFile($material_id, $filePath, $fileName)
    {
        $this->load->model('material_model');
        $material = $this->material_model->load($material_id);

        $name = $fileName; // Save file name
        $fstype = '';
        if (preg_match("/\.[^\.]+$/i", $name, $matches)) $fstype = $matches[0];

        $fsname = uniqid(/*md5(Session::instance()->get('auth_user'))*/) . strtolower($fstype);
        $dir = FCPATH . 'data' . DIRECTORY_SEPARATOR . 'material' . DIRECTORY_SEPARATOR . 'file' . DIRECTORY_SEPARATOR;

        if (!file_exists($dir)) mkdir($dir, '0777', TRUE);
        copy($filePath, $dir . $fsname);
        $this->material_model->save($material_id, array("file" => $fsname));
    }

    public function export_csv()
    {
        show_error("functionality closed", 404); exit;
        set_time_limit(0);
        $content = mb_convert_encoding(file_get_contents(base_url() ."temp/reestr.csv"), 'UTF-8', 'CP1251');
        //$content = preg_replace("/\"\"/", "###", $content);
        //$content = preg_replace("/\"/", "", $content);
        //$content = preg_replace("/###/", "\"", $content);
        //$content = preg_replace("/;;*/", ";", $content);
        $arr = explode("\r\n", $content);
        foreach($arr as $item){
            $fields = explode(";", $item);
            if (!isset($fields[0]) || $fields[0] == '') continue;
            if (!isset($fields[3]) || $fields[3] == '') continue;
            $data['name'] = str_replace('###', ";", $fields[3]);
            $data['lat'] = $fields[4];
            echo ($fields[0]) . PHP_EOL;
            $data['lng'] = $fields[5];
            $data['description'] = "Систематизированные фотографии \"Чаганка 2017\"<br>\r\n"
                                 . "Порядковый номер в реестре: " . $fields[0] . "<br>\r\n"
                                 . "Вид памятника: " . $fields[2] . "<br>\r\n"
                                 . "Описание памятника: " . str_replace('###', ";", $fields[3]) . "<br>\r\n"
                                 . "Высота: " . $fields[6] . "<br>\r\n"
                                 . "Датировка: " . $fields[7] . "<br>\r\n";
            $result = $this->petroglyph_model->save(null, $data);
            if ($result) {
                //searching for files
                $folder1 = "/var/www/html/petrogis/temp/РАЕ/п." . $fields[1];
                $folder2 = "/var/www/html/petrogis/temp/Чаган - систематизированные фото/п." . $fields[0];
                $filenames = [];
                $filepathes = [];
                if (is_dir($folder1)) {
                    $filenames1 = scandir($folder1);
                    foreach ($filenames1 as $filename)
                        if (strpos($filename, ".JPG")) {
                            $filenames[] = $filename;
                            $filepathes[] = $folder1 . "/" . $filename;
                        }
                }
                if (is_dir($folder2)) {
                    $filenames2 = scandir($folder2);
                    foreach ($filenames2 as $filename)
                        if (strpos($filename, ".JPG")) {
                            $filenames[] = $filename;
                            $filepathes[] = $folder2 . "/" . $filename;
                        }
                }
                print_r($filenames);
                if (isset($filenames[0]))
                    $this->_uploadFromFile($result, $filepathes[0], $filenames[0]);
                if (isset($filenames[1]))
                    for ($i = 1; $i < count($filenames); $i++) {
                        $this->_addMaterialFromFile($result, $filepathes[$i], $filenames[$i]);
                    }
                echo ("...Finished") . PHP_EOL;
            }
        }
    }
    public function cache_petroglyphs(){
        set_time_limit(0);
        $this->_cache_petroglyphs_by_res(800);
        $this->_cache_petroglyphs_by_res(1600);
        $this->_cache_materials_by_res(800);
        $this->_cache_materials_by_res(1600);
    }

    public function _cache_petroglyphs_by_res($res)
    {
        $this->load->helper('file');
        $this->load->library('image_lib');
        $this->load->model('petroglyph_model');
        $petroglyph_list = $this->petroglyph_model->load_list();

        foreach ($petroglyph_list as $petroglyph) {
            if ($petroglyph->image) {
                $filePath = "cache/petroglyph/image" . $res . "/" . $petroglyph->image;

                if (!file_exists($filePath)) {
                    $img_src = "data/petroglyph/image/" . $petroglyph->image;
                    echo $img_src . "<br>";

                    $config['image_library'] = 'gd2';
                    $config['source_image'] = $img_src;
                    $config['new_image'] = $filePath;
                    $config['create_thumb'] = FALSE;
                    $config['maintain_ratio'] = TRUE;
                    $config['width'] = $res;
                    $config['height'] = $res;

                    $this->image_lib->initialize($config);
                    $this->image_lib->resize();
                }
            }
        }
    }
    public function _cache_materials_by_res($res)
    {
        $this->load->helper('file');
        $this->load->library('image_lib');
        $this->load->model('material_model');
        $material_list = $this->material_model->load_list();

        foreach ($material_list as $material) {
            if ($material->file) {
                $filePath = "cache/material/file".$res."/" . $material->file;

                if (!file_exists($filePath)) {
                    $img_src = "data/material/file/" . $material->file;
                    echo $img_src . "<br>";

                    $config['image_library'] = 'gd2';
                    $config['source_image'] = $img_src;
                    $config['new_image'] = $filePath;
                    $config['create_thumb'] = FALSE;
                    $config['maintain_ratio'] = TRUE;
                    $config['width'] = $res;
                    $config['height'] = $res;

                    $this->image_lib->initialize($config);
                    $this->image_lib->resize();
                }
            }
        }
    }
}
