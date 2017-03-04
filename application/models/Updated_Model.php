<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Updated_Model extends CI_Model {

    private $updatedTable = 'updated';
    private $updatedColumn = 'updated_id';

    public function __construct()
    {
        parent::__construct();
    }
    
    public function insert($data)
    {
        $this->db->insert($this->updatedTable, $data);
        return $this->db->insert_id();
    }

}