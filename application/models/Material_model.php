<?php defined('BASEPATH') or die('No direct access allowed.');

class Material_model extends CI_Model
{
    public function error()
    {
        return $this->db->error();
    }
    public function __construct()
    {
        $this->load->database();
    }

    public function load_list($petroglyph_id = null)
    {
        if (isset($petroglyph_id))
            $this->db->where('petroglyph_id', $petroglyph_id);
        $query = $this->db->get('materials');
        return $query->result();
    }

    public function load($id = null)
    {
        //$query = $this->db->get('petroglyphs');
        //return $query->result();

        if($id != FALSE) {
            $query = $this->db->get_where('materials', array('id' => $id));
            return $query->row();
        }
        else {
            return FALSE;
        }

    }

    public function delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('materials');
    }

    public function save($id, $data)
    {
        $result = false;
        if ($id)
        {
            $this->db->where('id', $id);
            $result = $this->db->update('materials', $data);
            if ($result) return $id;
        }
        else
        {
            $result = $this->db->insert('materials', $data);
            if ($result) return $this->db->insert_id();
        }
        return $result;
    }
}