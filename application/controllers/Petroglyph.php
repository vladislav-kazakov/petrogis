<?php defined('BASEPATH') or die('No direct access allowed.');

class Petroglyph extends CI_Controller {
    public function index()
    {
        $logged_in = $this->user_model->logged_in();
        if (!$logged_in) redirect('welcome');

        $this->load->view('header', array(
            'menu' => 'petroglyph',
            'logged_in' => $logged_in,
            'username' => $this->user_model->get_user()
        ));

        $this->load->model('petroglyph_model');
        $petroglyphs = $this->petroglyph_model->load_list();
        $this->load->view('petroglyph/list', array(
            'petroglyphs' => $petroglyphs,
            'message' => $_SERVER['REQUEST_URI']
        ));
        $_SESSION['referrer'] = $_SERVER['REQUEST_URI'];

        $this->load->view('footer');
    }
    
    public function view($id = NULL)
    {
        $logged_in = $this->user_model->logged_in();
        if (!$logged_in) redirect('welcome');

        $this->load->view('header', array(
            'menu' => 'petroglyph',
            'logged_in' => $logged_in,
            'username' => $this->user_model->get_user()
        ));

        $petroglyph_id = $id;// $this->input->get('id');
        $this->load->model('petroglyph_model');
        $petroglyph = $this->petroglyph_model->load($petroglyph_id);



        if ($petroglyph->image)
            $this->load->vars('img_src', base_url() ."petroglyph/image/" . $petroglyph->id);

        $_SESSION['referrer'] =  $_SERVER['REQUEST_URI'];

        $this->load->vars('message', $_SERVER['REQUEST_URI']);

        $this->load->view('petroglyph/view', array(
            'petroglyph' => $petroglyph));

        $this->load->view('footer');
    }
    public function image($petroglyph_id = NULL)
    {
        $this->load->helper('file');

        $logged_in = $this->user_model->logged_in();
        if (!$logged_in) redirect('welcome');

        $this->load->model('petroglyph_model');
        $petroglyph = $this->petroglyph_model->load($petroglyph_id);

        if ($petroglyph->image) {
            $filePath = "cache/petroglyph/image/" . $petroglyph->image;
            if (!file_exists($filePath)) {
                $img_src = "data/petroglyph/image/" . $petroglyph->image;


                $config['image_library'] = 'gd2';
                $config['source_image'] = $img_src;
                $config['new_image'] = $filePath;
                $config['create_thumb'] = FALSE;
                $config['maintain_ratio'] = TRUE;
                $config['width']         = 800;
                $config['height']       = 800;

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
        $logged_in = $this->user_model->logged_in();
        if (!$logged_in) redirect('welcome');

        $this->load->view('header', array(
            'menu' => 'petroglyph',
            'logged_in' => $logged_in,
            'username' => $this->user_model->get_user()
        ));

        $this->load->model('petroglyph_model');

        $data = array();
        if ($this->input->post('name')) {
            $data['name'] = $this->input->post('name');
            $data['lat'] = $this->input->post('lat');
            $data['lng'] = $this->input->post('lng');
            if ($this->input->post('method')) $data['method'] = $this->input->post('method');
            if ($this->input->post('culture')) $data['culture'] = $this->input->post('culture');
            $data['description'] = $this->input->post('description');

            $result = $this->petroglyph_model->save($petroglyph_id, $data);
            if ($result)
            {
                if ($_FILES) $this->_upload($result);
                redirect($_SESSION['referrer']? $_SESSION['referrer'] : 'petroglyph');
            }
            else {
                $this->load->vars('petroglyph', $data);
                //$this->load->vars('errors', $post->errors());
            }
        } else if ($petroglyph_id)
            $this->load->vars('petroglyph', get_object_vars($this->petroglyph_model->load($petroglyph_id)));

        $this->load->view('petroglyph/form', array(
            'title' => 'Petroglyph'));
        
        $this->load->view('footer');
    }
    public function delete($petroglyph_id)
    {
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
        $logged_in = $this->user_model->logged_in();
        if (!$logged_in) return;

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