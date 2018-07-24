<?php defined('BASEPATH') or die('No direct access allowed.');

class Petroglyph_model extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
    }
    
    public function load_list()
    {
        $this->db->where('deleted', FALSE);
        $query = $this->db->get('petroglyphs');
        return $query->result();
    }

    public function search($name)
    {
        $this->db->where('deleted', FALSE);
        $this->db->where('name LIKE', '%' . $name . '%');
        $query = $this->db->get('petroglyphs');
        return $query->result();
    }

    public function loadByUuid($uuid)
    {
        if($uuid) {
            $query = $this->db->get_where('petroglyphs', array('uuid' => $uuid));
            return $query->row();
        }
        else {
            return FALSE;
        }
    }
    public function load($id)
    {
        //$query = $this->db->get('petroglyphs');
        //return $query->result();

        if($id != FALSE) {
            $query = $this->db->get_where('petroglyphs', array('id' => $id));
            return $query->row();
        }
        else {
            return FALSE;
        }

    }

    public function delete($id)
    {
        $this->db->where('id', $id);
        $data = array('deleted' => TRUE);
        $this->db->update('petroglyphs', $data);
        //if ($result) return $id;
    }

    public function save($id, $data)
    {
        $result = false;
//        $query = $this->db->get_where('petroglyphs', array('id' => $id));
//        $petroglyph = $query->row();
        if ($id)
        {
//            if (!$petroglyph->uuid) $this->db->set('uuid', 'UUID()');
            $this->db->where('id', $id);
            $result = $this->db->update('petroglyphs', $data);
            if ($result) return $id;
        }
        else
        {
            if (!$data['uuid']) $this->db->set('uuid', 'UUID()', FALSE);
            $result = $this->db->insert('petroglyphs', $data);
            if ($result) return $this->db->insert_id();
        }
        return $result;
    }
}