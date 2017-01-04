<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Created_Model extends CI_Model {

    private $createdTable = 'created';
    private $createdColumn = 'created_id';

    public function __construct()
    {
        parent::__construct();
    }
    
    public function insert($data)
    {
        $this->db->insert($this->createdTable, $data);
        return $this->db->insert_id();
    }

}