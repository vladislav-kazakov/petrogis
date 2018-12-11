<?php defined('BASEPATH') or die('No direct access allowed.');

class Material extends CI_Controller
{
    public function image($material_id)
    {
        return $this->_image($material_id);
    }
    public function imagexl($material_id)
    {
        return $this->_image($material_id, 1600);
    }
    public function _image($material_id, $res = 800)
    {
        $this->load->helper('file');

        $logged_in = $this->user_model->logged_in();
        if (!$logged_in) redirect('welcome');

        $material = $this->material_model->load($material_id);

        if ($material->file) {
            $filePath = "cache/material/file".$res."/" . $material->file;
            if (!file_exists($filePath)) {
                $img_src = "data/material/file/" . $material->file;


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

    public function delete($material_id)
    {
        if (!$this->user_model->logged_in()) redirect('welcome');
        if (!$this->user_model->admin()) redirect('welcome');

        $material = $this->material_model->load($material_id);

        if ($material) {
            $dir = FCPATH . 'data' . DIRECTORY_SEPARATOR . 'material' . DIRECTORY_SEPARATOR . 'file' . DIRECTORY_SEPARATOR;
            //remove old image file from fs
            if ($material->file && file_exists($dir . $material->file))
                unlink($dir . $material->file);
            $this->material_model->delete($material_id);
        }
        redirect($_COOKIE['referrer']? $_COOKIE['referrer'] : 'petroglyph');
    }
}