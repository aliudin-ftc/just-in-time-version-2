<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Priviledge_Model extends CI_Model {

    private $priviledgeTable = 'priviledge';
    private $priviledgeColumn = 'priviledge_id';

    public function __construct()
    {
        parent::__construct();
    }
    
    public function get_priviledge_modules($id)
    {   
        $this->db->select('*');
        $this->db->from('priviledge_modules as pri_mod');
        $this->db->join('priviledge as pri','pri_mod.priviledge_id = pri.priviledge_id');
        $this->db->where('pri_mod.priviledge_id', $id);
        $query = $this->db->get();
        return $query->result();
    }

}