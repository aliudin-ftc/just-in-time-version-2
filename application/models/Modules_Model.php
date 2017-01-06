<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Modules_Model extends CI_Model {

    private $modulesTable = 'modules';
    private $modulesColumn = 'modules_id';

    public function __construct()
    {
        parent::__construct();
    }
    
    public function get_modules_name($id)
    {   
        $this->db->where($this->modulesColumn, $id);
        $query = $this->db->get($this->modulesTable);
        
        foreach($query->result() as $row)
        {
            $id = $row->modules_name;
        }

        return $id;
    }

    public function get_modules_slug($id)
    {   
        $this->db->where($this->modulesColumn, $id);
        $query = $this->db->get($this->modulesTable);
        
        foreach($query->result() as $row)
        {
            $id = $row->modules_slug;
        }

        return $id;
    }

    public function get_modules_icon($id)
    {   
        $this->db->where($this->modulesColumn, $id);
        $query = $this->db->get($this->modulesTable);
        
        foreach($query->result() as $row)
        {
            $id = $row->modules_icon;
        }

        return $id;
    }

    public function count_modules($id)
    {   
        $this->db->select('*');
        $this->db->from('modules_sub_modules as mod_sub');
        $this->db->join('modules as mod','mod_sub.modules_id = mod.modules_id');
        $this->db->where('mod_sub.modules_id', $id);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function get_sub_modules($modules_id, $resources_id)
    {   
        $this->db->select('*');
        $this->db->from('modules_sub_modules as mod_sub_mod');
        $this->db->join('sub_modules as sub_mod','mod_sub_mod.sub_modules_id = sub_mod.sub_modules_id');
        $this->db->where('mod_sub_mod.modules_id', $modules_id);
        $this->db->where('mod_sub_mod.resources_id', $resources_id);
        $query = $this->db->get();
        return $query->result();
    }
}