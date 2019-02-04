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

        $material = $this->material_model->load($material_id);

        $petroglyph = $this->petroglyph_model->load($material->petroglyph_id);
        if (!$petroglyph->is_public) redirect('welcome');

        if ($material->file) {
            $filePath = "cache/material/file" . $res . "/" . $material->file;
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
        redirect($_COOKIE['referrer'] ? $_COOKIE['referrer'] : 'petroglyph');
    }

    public function tomain($material_id)
    {
        if (!$this->user_model->logged_in()) redirect('welcome');
        if (!$this->user_model->admin()) redirect('welcome');

        $material = $this->material_model->load($material_id);

        if ($material) {
            $petroglyph = $this->petroglyph_model->load($material->petroglyph_id);

            if ($petroglyph) {
                $dir_material = FCPATH . 'data' . DIRECTORY_SEPARATOR . 'material' . DIRECTORY_SEPARATOR . 'file' . DIRECTORY_SEPARATOR;
                $dir_petroglyph = FCPATH . 'data' . DIRECTORY_SEPARATOR . 'petroglyph' . DIRECTORY_SEPARATOR . 'image' . DIRECTORY_SEPARATOR;

                if ($material->file && file_exists($dir_material . $material->file)) {
                    if (copy($dir_material . $material->file, $dir_petroglyph . $material->file)) {
                        $this->petroglyph_model->save($petroglyph->id, array("image" => $material->file));
                        unlink($dir_material . $material->file);
                        $this->_clearcache($material->file);
                    }
                }

                if ($petroglyph->image && file_exists($dir_petroglyph . $petroglyph->image)) {
                    if (copy($dir_petroglyph . $petroglyph->image, $dir_material . $petroglyph->image)) {
                        $this->material_model->save($material->id, array("file" => $petroglyph->image));
                        unlink($dir_petroglyph . $petroglyph->image);
                        $this->_clearcache($petroglyph->image, "cache/petroglyph/image");
                    }
                }
            }
        }
        redirect($_COOKIE['referrer'] ? $_COOKIE['referrer'] : 'petroglyph');
    }

    public function _clearcache($filename, $spec_path = false)
    {

        if (empty($filename)) return false;

        $res_arr = array(800, 1600);

        foreach ($res_arr as $res) {
            $filePath = $spec_path ? $spec_path . $res . "/" . $filename : "cache/material/file" . $res . "/" . $filename;
            if (file_exists($filePath)) unlink($filePath);
        }
    }
}