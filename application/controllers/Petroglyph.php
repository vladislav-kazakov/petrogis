<?php defined('BASEPATH') or die('No direct access allowed.');

class Petroglyph extends CI_Controller
{
    public $materials;

    public function index()
    {
        $logged_in = $this->user_model->logged_in();

        $this->load->view('header', array(
            'menu' => 'petroglyph',
            'logged_in' => $logged_in,
            'username' => $logged_in ? $this->user_model->get_user() : 'Guest'
        ));

        $this->load->model('petroglyph_model');
        $petroglyphs = $this->petroglyph_model->load_list();
        $this->load->view('petroglyph/list', array(
            'petroglyphs' => $petroglyphs,
            'admin' => $this->user_model->admin(),
            'reviewer' => $this->user_model->reviewer(),
            //'message' => $_SERVER['REQUEST_URI']
        ));
        //$_SESSION['referrer'] = $_SERVER['REQUEST_URI'];

        $this->load->view('footer');
    }

    public function view($id = NULL)
    {
        $logged_in = $this->user_model->logged_in();

        $this->load->view('header', array(
            'menu' => 'petroglyph',
            'logged_in' => $logged_in,
            'username' => $this->user_model->get_user(),
            'admin' => $this->user_model->admin()
        ));

        $petroglyph_id = $id;// $this->input->get('id');
        $petroglyph = $this->petroglyph_model->load($petroglyph_id);
        $petroglyph->epoch = explode(",", $petroglyph->epoch);
        $petroglyph->method = explode(",", $petroglyph->method);
        $petroglyph->culture = explode(",", $petroglyph->culture);

        if ($petroglyph->image)
            $this->load->vars('img_src', base_url() . "petroglyph/image/" . $petroglyph->id);

        $materials = $this->material_model->load_list($petroglyph_id);
        $this->load->vars('materials', $materials);

        //$_SESSION['referrer'] =  $_SERVER['REQUEST_URI'];

        //$this->load->vars('message', $_SERVER['REQUEST_URI']);

        $this->load->view('petroglyph/view', array(
            'petroglyph' => $petroglyph));

        $this->load->view('footer');
    }

    public function image($petroglyph_id)
    {
        return $this->_image($petroglyph_id);
    }

    public function imagexl($petroglyph_id)
    {
        return $this->_image($petroglyph_id, 1600);
    }

    public function _image($petroglyph_id, $res = 800)
    {
        $this->load->helper('file');

        $logged_in = $this->user_model->logged_in();
        if (!$logged_in) redirect('welcome');

        $this->load->model('petroglyph_model');
        $petroglyph = $this->petroglyph_model->load($petroglyph_id);

        if ($petroglyph->image) {
            $filePath = "cache/petroglyph/image" . $res . "/" . $petroglyph->image;
            if (!file_exists($filePath)) {
                $img_src = "data/petroglyph/image/" . $petroglyph->image;


                $config['image_library'] = 'gd2';
                $config['source_image'] = $img_src;
                $config['new_image'] = $filePath;
                $config['create_thumb'] = FALSE;
                $config['maintain_ratio'] = TRUE;
                $config['width'] = $res;
                $config['height'] = $res;

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

    public function admin($petroglyph_id = NULL)
    {
        if (!$this->user_model->logged_in()) redirect('welcome');
        if (!$this->user_model->admin()) redirect('welcome');

        $data = array();
        if ($this->input->post('SavePetroglyph')) {
            $data['name'] = $this->input->post('name');
            $data['lat'] = $this->input->post('lat');
            $data['lng'] = $this->input->post('lng');
            if ($this->input->post('method')) $data['method'] = implode(",", $this->input->post('method'));
            if ($this->input->post('culture')) $data['culture'] = implode(",", $this->input->post('culture'));
            if ($this->input->post('epoch')) $data['epoch'] = implode(",", $this->input->post('epoch'));
            $data['description'] = $this->input->post('description');
            $data['is_public'] = $this->input->post('is_public') ? 1 : 0;

            $result = $this->petroglyph_model->save($petroglyph_id, $data);
            if ($result) {
                if ($_FILES) $this->_upload($result);

                $rotate = $this->input->post('imageRotate');
                if ($rotate) {
                    $this->_rotateImage($petroglyph_id, ($rotate + 180) % 360);
                }

                redirect($_COOKIE['referrer'] ? $_COOKIE['referrer'] : 'petroglyph');
            } else {
                $this->load->vars('petroglyph', $data);
                //$this->load->vars('errors', $post->errors());
            }
        } else {
            $this->load->view('header', array(
                'menu' => 'petroglyph',
                'logged_in' => $this->user_model->logged_in(),
                'username' => $this->user_model->get_user()
            ));
            if ($petroglyph_id) {
                $petroglyph = $this->petroglyph_model->load($petroglyph_id);
                $petroglyph->epoch = explode(",", $petroglyph->epoch);
                $petroglyph->culture = explode(",", $petroglyph->culture);
                $petroglyph->method = explode(",", $petroglyph->method);
                if ($petroglyph->image)
                    $petroglyph->img_src = base_url() . "petroglyph/image/" . $petroglyph->id;
                $this->load->vars('petroglyph', get_object_vars($petroglyph));
            }
            $this->load->view('petroglyph/form', array(
                'title' => 'Petroglyph'));
            $this->load->view('footer');
        }
    }

    public function addfile($petroglyph_id)
    {
        if (!$this->user_model->logged_in()) redirect('welcome');
        if (!$this->user_model->admin()) redirect('welcome');

        $data = array();
        if ($this->input->post('AddMaterial') && $petroglyph_id &&
            isset($_FILES['material']['name']) && $_FILES['material']['name'] != '') {
            $data['name'] = $this->input->post('name');
            $data['type'] = 'image';
            $data['description'] = $this->input->post('description');
            $data['petroglyph_id'] = $petroglyph_id;

            $result = $this->material_model->save(NULL, $data);
            if ($result) {
                if ($_FILES) $this->_uploadMaterial($result);
                redirect($_COOKIE['referrer'] ? $_COOKIE['referrer'] : 'petroglyph');
            } else {
                $this->load->vars('petroglyph', $data);
                $this->load->vars('message', "error" . $this->material_model->error());
            }
        } else {
            $this->load->view('header', array(
                'menu' => 'petroglyph',
                'logged_in' => $this->user_model->logged_in(),
                'username' => $this->user_model->get_user()
            ));
            $this->load->view('petroglyph/addfile_form', array(
                'title' => 'Material'));
            $this->load->view('footer');
        }
    }

    public function delete($petroglyph_id)
    {
        if (!$this->user_model->logged_in()) redirect('welcome');
        if (!$this->user_model->admin()) redirect('welcome');

        $this->load->model('petroglyph_model');
        $petroglyph = $this->petroglyph_model->load($petroglyph_id);

        if ($petroglyph) {
            $dir = FCPATH . 'data' . DIRECTORY_SEPARATOR . 'petroglyph' . DIRECTORY_SEPARATOR . 'image' . DIRECTORY_SEPARATOR;
            //remove old image file from fs
            if ($petroglyph->image && file_exists($dir . $petroglyph->image))
                unlink($dir . $petroglyph->image);
            $this->petroglyph_model->delete($petroglyph_id);
        }
        redirect('petroglyph');
    }

    public function _upload($petroglyph_id)
    {
        // Check if it is already loguserged in!
        if (!$this->user_model->logged_in()) return;
        if (!$this->user_model->admin()) return;

        if ($_FILES) {
            /*  $upload = Validation::factory($_FILES)
                  ->rule('image', 'Upload::valid')
                  ->rule('image', 'Upload::not_empty')
                  ->rule('image', 'Upload::type', array(':value', array('jpg', 'png', 'gif')))
                 ->rule('image', 'Upload::size', array(':value', '20M'));
  */
            if ($_FILES['image']['name']) {
                $this->load->model('petroglyph_model');
                $petroglyph = $this->petroglyph_model->load($petroglyph_id);

                $name = $_FILES['image']['name']; // Save file name
                $fstype = '';
                if (preg_match("/\.[^\.]+$/i", $name, $matches)) $fstype = $matches[0];

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

    public function _uploadMaterial($material_id)
    {
        // Check if it is already loguserged in!
        if (!$this->user_model->logged_in()) return;
        if (!$this->user_model->admin()) return;

        if ($_FILES) {
            /*  $upload = Validation::factory($_FILES)
                  ->rule('image', 'Upload::valid')
                  ->rule('image', 'Upload::not_empty')
                  ->rule('image', 'Upload::type', array(':value', array('jpg', 'png', 'gif')))
                 ->rule('image', 'Upload::size', array(':value', '20M'));
  */
            if ($_FILES['material']['name']) {
                $this->load->model('material_model');
                $material = $this->material_model->load($material_id);

                $name = $_FILES['material']['name']; // Save file name
                $fstype = '';
                if (preg_match("/\.[^\.]+$/i", $name, $matches)) $fstype = $matches[0];

                $fsname = uniqid(/*md5(Session::instance()->get('auth_user'))*/) . $fstype;
                $dir = FCPATH . 'data' . DIRECTORY_SEPARATOR . 'material' . DIRECTORY_SEPARATOR . 'file' . DIRECTORY_SEPARATOR;

                if (!file_exists($dir)) mkdir($dir, '0777', TRUE);

                $config['upload_path'] = $dir;
                $config['file_name'] = $fsname;
                $config['allowed_types'] = 'gif|jpg|png';
                $this->load->library('upload', $config);
                $this->upload->do_upload('material');
                //echo $this->upload->display_errors(); exit;

                //remove old image file from fs
                if ($material && $material->file && file_exists($dir . $material->file)) unlink($dir . $material->file);
                $this->material_model->save($material_id, array("file" => $fsname));
            } else {
                //todo: handle file upload error
            }
        }
    }

    public function _cloneMaterial($material_id, $petroglyph_id)
    {
        if (!$this->user_model->logged_in()) return;
        if (!$this->user_model->admin()) return;

        $material_id = (int)$material_id;
        $petroglyph_id = (int)$petroglyph_id;

        if ($material_id and $petroglyph_id) {
            $this->load->model('material_model');
            $material_from = $this->material_model->load($material_id);

            $fstype = '';

            if (preg_match("/\.[^\.]+$/i", $material_from->file, $matches)) {
                $fstype = $matches[0];
            }

            $material_to = array(
                'name' => $material_from->name,
                'type' => $material_from->type,
                'file' => uniqid() . $fstype,
                'description' => $material_from->description,
                'petroglyph_id' => $petroglyph_id,
            );

            $dir = FCPATH . 'data' . DIRECTORY_SEPARATOR . 'material' . DIRECTORY_SEPARATOR . 'file' . DIRECTORY_SEPARATOR;

            if (copy($dir . $material_from->file, $dir . $material_to['file'])) {
                $this->material_model->save(null, $material_to);

                return true;
            }

            return false;
        }
    }

    public function _imageToMaterial($petroglyph_id)
    {
        if (!$this->user_model->logged_in()) return;
        if (!$this->user_model->admin()) return;

        $petroglyph_id = (int)$petroglyph_id;

        if ($petroglyph_id) {
            $this->load->model('petroglyph_model');
            $this->load->model('material_model');
            $petroglyph = $this->petroglyph_model->load($petroglyph_id);

            $fstype = '';

            if (preg_match("/\.[^\.]+$/i", $petroglyph->image, $matches)) {
                $fstype = $matches[0];
            }

            $material_to = array(
                'name' => '',
                'type' => 'image',
                'file' => uniqid() . $fstype,
                'description' => '',
                'petroglyph_id' => $petroglyph_id,
            );

            $dir_image = FCPATH . 'data' . DIRECTORY_SEPARATOR . 'petroglyph' . DIRECTORY_SEPARATOR . 'image' . DIRECTORY_SEPARATOR;
            $dir_material = FCPATH . 'data' . DIRECTORY_SEPARATOR . 'material' . DIRECTORY_SEPARATOR . 'file' . DIRECTORY_SEPARATOR;

            if (copy($dir_image . $petroglyph->image, $dir_material . $material_to['file'])) {
                $this->material_model->save(null, $material_to);

                return true;
            }

            return false;
        }
    }

    public function _cloneImage($from_petroglyph_id, $to_petroglyph_id)
    {
        if (!$this->user_model->logged_in()) return;
        if (!$this->user_model->admin()) return;

        $from_petroglyph_id = (int)$from_petroglyph_id;
        $to_petroglyph_id = (int)$to_petroglyph_id;

        if ($from_petroglyph_id and $to_petroglyph_id) {
            $this->load->model('petroglyph_model');
            $petroglyph = $this->petroglyph_model->load($from_petroglyph_id);

            $fstype = '';

            if (preg_match("/\.[^\.]+$/i", $petroglyph->image, $matches)) {
                $fstype = $matches[0];
            }

            $data = array(
                'image' => uniqid() . $fstype,
            );

            $dir = FCPATH . 'data' . DIRECTORY_SEPARATOR . 'petroglyph' . DIRECTORY_SEPARATOR . 'image' . DIRECTORY_SEPARATOR;

            if (copy($dir . $petroglyph->image, $dir . $data['image'])) {
                $this->petroglyph_model->save($to_petroglyph_id, $data);

                return true;
            }

            return false;
        }
    }

    public function _rotateImage($petroglyph_id, $degrees)
    {
        $this->load->helper('file');

        $logged_in = $this->user_model->logged_in();
        if (!$logged_in) redirect('welcome');

        $this->load->model('petroglyph_model');
        $petroglyph = $this->petroglyph_model->load($petroglyph_id);

        if ($petroglyph->image) {
            $dir = FCPATH . 'data' . DIRECTORY_SEPARATOR . 'petroglyph' . DIRECTORY_SEPARATOR . 'image' . DIRECTORY_SEPARATOR;

            $img_src = $dir . $petroglyph->image;

            $fstype = '';
            if (preg_match("/\.[^\.]+$/i", $petroglyph->image, $matches)) $fstype = $matches[0];

            $fsname = uniqid() . $fstype;
            $img_src_new = $dir . $fsname;

            if (file_exists($img_src)) {
                $type = get_mime_by_extension($img_src);
                $type_ = explode('/', $type);
                $functionName1 = 'imagecreatefrom' . $type_[1];
                $functionName2 = 'image' . $type_[1];

                if (function_exists($functionName1) and function_exists($functionName2)) {
                    $source = $functionName1($img_src);
                    $rotate = imagerotate($source, $degrees, 0);

                    if ($functionName2($rotate, $img_src_new)) {

                        $this->petroglyph_model->save($petroglyph_id, array("image" => $fsname));

                        imagedestroy($source);
                        imagedestroy($rotate);
                        unlink($img_src);

                        $this->_clearcache($petroglyph->image);
                    }
                }
            }
        }
    }

    public function _clearcache($filename, $spec_path = false)
    {
        if (empty($filename)) return false;

        $res_arr = array(800, 1600);

        foreach ($res_arr as $res) {
            $filePath = $spec_path ? $spec_path . $res . "/" . $filename : "cache/petroglyph/image" . $res . "/" . $filename;
            if (file_exists($filePath)) unlink($filePath);
        }
    }

    public function eDouble()
    {
        if (!$this->user_model->logged_in() or !$this->user_model->admin()) {
            redirect('welcome');
        }

        $this->load->model('petroglyph_model');

        $petroglyphs = array();

        foreach ($this->petroglyph_model->load_list() as $item) {
            if ($item->image) {
                $item->img_src = base_url() . "petroglyph/image/" . $item->id;
            }

            $item->materials = $this->material_model->load_list($item->id);
            if (!empty($item->materials)) {
                foreach ($item->materials as &$material) {
                    $material->img_src = base_url() . "material/image/" . $material->id;
                    $material->imgxl_src = base_url() . "material/imagexl/" . $material->id;
                }
            }

            $petroglyphs[] = $item;
        }

        if ($post = $this->input->post() and $post['save']) {
//            var_dump($post);
//            die;
            $left = $post['left'];
            $right = $post['right'];

            if (!empty($left['id']) and (int)$left['id']) {
                $this->petroglyph_model->save($left['id'], $left);

                if (isset($post['cloneMaterialFromRight']) and !empty($post['cloneMaterialFromRight'])) {
                    foreach ($post['cloneMaterialFromRight'] as $item) {
                        $material_id = substr($item, 1);
                        $response = $this->_cloneMaterial($material_id, $left['id']);
//                        todo: message
                    }
                }

                if (isset($post['imageToMaterial']) and $post['imageToMaterial'] == 'left') {
                    $response = $this->_imageToMaterial($left['id']);
                }

                if (isset($post['cloneImageFromRight']) and !empty($right['id']) and (int)$right['id']) {
                    $response = $this->_cloneImage($right['id'], $left['id']);
                }
            } elseif ($left['name'] or $left['description']) {
            }

            if (!empty($right['id']) and (int)$right['id']) {
                $this->petroglyph_model->save($right['id'], $right);

                if (isset($post['cloneMaterialFromLeft']) and !empty($post['cloneMaterialFromLeft'])) {
                    foreach ($post['cloneMaterialFromLeft'] as $item) {
                        $material_id = substr($item, 1);
                        $response = $this->_cloneMaterial($material_id, $right['id']);
//                        todo: message
                    }
                }
            } elseif ($right['name'] or $right['description']) {
            }

            if(isset($post['deleteMaterial']) and !empty($post['deleteMaterial'])) {
                foreach ($post['deleteMaterial'] as $item) {
                    $material_id = substr($item, 1);$material = $this->material_model->load($material_id);
                    $material = $this->material_model->load($material_id);
                    if ($material) {
                        $dir = FCPATH . 'data' . DIRECTORY_SEPARATOR . 'material' . DIRECTORY_SEPARATOR . 'file' . DIRECTORY_SEPARATOR;
                        //remove old image file from fs
                        if ($material->file && file_exists($dir . $material->file)) {
                            unlink($dir . $material->file);
                        }
                        $this->material_model->delete($material_id);
                    }
                }
            }


//            die;
            redirect('petroglyph/edouble');
        }

        $map_provider = 'google';

        $this->load->view('header', array(
            'menu' => 'e_double',
            'page' => 'e_double',
            'logged_in' => $this->user_model->logged_in(),
            'username' => $this->user_model->get_user(),
        ));

        $this->load->view('petroglyph/e_double', array(
            'json_petroglyphs' => json_encode($petroglyphs, JSON_UNESCAPED_UNICODE),
            'map_provider' => $map_provider
        ));

        $this->load->view('footer');
    }
}

/* Example
  public function upload() {
    // Create modelfiles object
    $modelfiles = New Model_File();

    // Check if it is already loguserged in!
    if (!$this->user_model->logged_in()) {
        // Redirect to his home page
        return $this->request->redirect(URL::site(Route::get('user')->uri(array('action' => 'login'))));
    }
    if ($_FILES) {
        $files_array = array();
        $uploaded_files = count($_FILES['file']['name'], 0);
        for ($i = 0; $i < $uploaded_files; $i++) {
        foreach ($_FILES['file'] as $key => $value) {
            $files_array['file'][$key] = $value[$i];
        }
        // Create Validation object
        $upload = Validation::factory($files_array)
            ->rule('file', 'Upload::valid')
            ->rule('file', 'Upload::not_empty')
            ->rule('file', 'Upload::type', array(':value', array('jpg', 'png', 'gif', 'pdf', 'xls', 'docx', 'xlsx', 'zip')))
            ->rule('file', 'Upload::size', array(':value', '2M'));

        if ($upload->check()) {
            // If validation is OK
            $name = $upload['file']['name']; // Save file name
            $fstype = '';
            if (preg_match("/\.\w+/i", $name, $matches)) {
            $fstype = $matches[0];
            }

            //
            $type = $upload['file']['type']; // Save file tipe: 'immage/jpeg'
            $size = $upload['file']['size']; // Save file size: 406b

            // Create uniq name for the file(solve the UTF-8 and cirillyc problem)
            // we will have file name like:
            // 21232f297a57a5a743894a0e4a801fc34e92dd9e397bc.pdf
            $fsname = uniqid(md5(Session::instance()->get('auth_user'))).$fstype;

            //
            $path = Kohana::config('fm')->get('path');

            // Store internal path
            $int_dir = date('Y').DIRECTORY_SEPARATOR.date('m').DIRECTORY_SEPARATOR.date('d').DIRECTORY_SEPARATOR;

            // Store fullpath path
            $directory = $path.$int_dir;

            if (file_exists($directory) && is_dir($directory)) {
            $filename = Upload::save($upload['file'], $fsname, $directory);
            }
            else {
            $directory = $modelfiles->_make_directory($directory, '0777', TRUE);
            $filename = Upload::save($upload['file'], $fsname, $directory);
            }
            // Get user id
            //array('id', 'name', 'path', 'user_id', 'nicename', 'mimetype', 'created', 'weight', 'category_id');
            $modeluser = New Model_User();
            $user_id = $modeluser->get(Session::instance()->get('auth_user'));

            //
            $data = array('name' => $fsname,
            'path' => $int_dir,
            'mimetype' => $type,
            'user_id' => $user_id,
            'nicename' => $name,
            'size' => $size,
            'created' => time());

            // Insert data to mysql
            $modelfiles->insert($data);

        }
        else {
            $err = $upload->errors('upload');
            $file_errors[$i] = $err['file'];
        }
        $sum_errors = array_merge($sum_errors, $file_errors);
        }
    }
    //
    $errors = array_merge($errors, $sum_errors);
    //
    $files = $modelfiles->get(Session::instance()->get('auth_user'));
    $count = count($files);

    if ($count == 0) {
        unset($files);
    }
    $this->template->content = View::factory('filemanager')
        ->bind('files', $files)
        ->bind('count', $count)
        ->bind('errors', $errors);
    }

*/