<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Direct_Materials_Estimate_Model extends CI_Model {

    private $direct_materials_estimateTable = 'direct_materials_estimate';
    private $direct_materials_estimateColumn = 'direct_materials_estimate_id';

    public function __construct()
    {
        parent::__construct();
    }
    
    public function insert($data)
    {
        $this->db->insert($this->direct_materials_estimateTable, $data);
        return $this->db->insert_id();
    }

}