<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Priviledge_Module_Model extends CI_Model {

    private $priviledge_moduleTable = 'priviledge_modules';
    private $priviledge_moduleColumn = 'priviledge_modules_id';

    public function __construct()
    {
        parent::__construct();
    }

    public function insert($data)
    {
        $this->db->insert($this->priviledge_moduleTable, $data);
        return $this->db->insert_id();
    }

    public function modify($data, $id)
    {   
        $this->db->where($this->priviledge_moduleColumn, $id);
        $this->db->update($this->priviledge_moduleTable, $data);
        return true;
    }

    public function check($module_id, $priviledge_id)
    {
        $this->db->where('priviledge_id', $priviledge_id);
        $this->db->where('modules_id', $module_id);
        $query = $this->db->get($this->priviledge_moduleTable);
        return $query->num_rows();
    }

    public function check_priviledges($priviledge_id)
    {
        $this->db->where('priviledge_id', $priviledge_id);
        $query = $this->db->get($this->priviledge_moduleTable);
        return $query->result();
    }

    public function delete($id)
    {
        $this->db->where('priviledge_id', $id);
        $this->db->delete($this->priviledge_moduleTable);
        return $this->db->affected_rows() > 0;
    }
}