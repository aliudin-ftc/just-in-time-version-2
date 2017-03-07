<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Dir_Mat_Est_Cost_Est_Model extends CI_Model {

    private $dir_mat_est_cost_estTable = 'dir_mat_est_cost_est';
    private $dir_mat_est_cost_estColumn = 'dir_mat_est_cost_est_id';

    public function __construct()
    {
        parent::__construct();
    }
    
    public function insert($data)
    {
        $this->db->insert($this->dir_mat_est_cost_estTable, $data);
        return $this->db->insert_id();
    }

}