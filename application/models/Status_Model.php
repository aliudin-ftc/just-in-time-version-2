<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Status_Model extends CI_Model {

    private $statusTable = 'status';
    private $statusColumn = 'status_id';

    public function __construct()
    {
        parent::__construct();
    }
    
    public function insert($data)
    {
        $this->db->insert($this->statusTable, $data);
        return $this->db->insert_id();
    }

    public function delete($data)
    { 
        $id = $data['status_table_id'];
        $table = $data['status_table'];
        $this->db->where('status_table', $table);
        $this->db->where('status_table_id', $id);
        $this->db->update($this->statusTable, $data);
        return true;
    }

    public function undo($data)
    { 
        $id = $data['status_table_id'];
        $table = $data['status_table'];
        $this->db->where('status_table', $table);
        $this->db->where('status_table_id', $id);
        $this->db->update($this->statusTable, $data);
        return true;
    }

}