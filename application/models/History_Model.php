<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class History_Model extends CI_Model {

    private $historyTable = 'history';
    private $historyColumn = 'history_id';

    public function __construct()
    {
        parent::__construct();
    }
    
    public function insert($data)
    {
        $this->db->insert($this->historyTable, $data);
        return $this->db->insert_id();
    }

    public function delete($data)
    { 
        $id = $data['history_table_id'];
        $table = $data['history_table'];
        $this->db->where('history_table', $table);
        $this->db->where('history_table_id', $id);
        $this->db->update($this->historyTable, $data);
        return true;
    }

    public function undo($data)
    { 
        $id = $data['history_table_id'];
        $table = $data['history_table'];
        $this->db->where('history_table', $table);
        $this->db->where('history_table_id', $id);
        $this->db->update($this->historyTable, $data);
        return true;
    }

}