<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Modules_Sub_Module_Model extends CI_Model {

    private $modules_sub_modulesTable = 'modules_sub_modules';
    private $modules_sub_modulesColumn = 'modules_sub_modules_id';

    public function __construct()
    {
        parent::__construct();
    }

    public function insert($data)
    {
        $this->db->insert($this->modules_sub_modulesTable, $data);
        return $this->db->insert_id();
    }

    public function modify($data, $id)
    {   
        $this->db->where($this->modules_sub_modulesColumn, $id);
        $this->db->update($this->modules_sub_modulesTable, $data);
        return true;
    }

    public function delete($id)
    {
        $this->db->where('priviledge_id', $id);
        $this->db->delete($this->modules_sub_modulesTable);
        return $this->db->affected_rows() > 0;
    }
}