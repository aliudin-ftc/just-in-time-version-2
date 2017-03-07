<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Cost_Estimate_Model extends CI_Model {

    private $cost_estimateTable = 'cost_estimate';
    private $cost_estimateColumn = 'cost_estimate_id';

    public function __construct()
    {
        parent::__construct();
    }
    
    public function insert($data)
    {
        $this->db->insert($this->cost_estimateTable, $data);
        return $this->db->insert_id();
    }

}