<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Job_Request_Module_Status_Sent_Model extends CI_Model {

    private $job_request_module_status_sentTable = 'job_request_module_status_sent';
    private $job_request_module_status_sentColumn = 'job_request_module_status_sent_id';

    public function __construct()
    {
        parent::__construct();
    }

    public function insert($data)
    {
        $this->db->insert($this->job_request_module_status_sentTable, $data);
        return $this->db->insert_id();
    }

    public function modify($data, $id)
    {   
        $this->db->where($this->job_request_module_status_sentColumn, $id);
        $this->db->update($this->job_request_module_status_sentTable, $data);
        return true;
    }

    public function find_sent_date_by_id($id)
    {
        $this->db->where('job_request_module_id', $id);
        $query = $this->db->get($this->job_request_module_status_sentTable);
        
        foreach ($query->result() as $row) {
            $id = date("d-M-Y",strtotime($row->job_request_module_status_sent_date)).'<br/>'.date("h:i A",strtotime($row->job_request_module_status_sent_date));
        }

        return $id;
    }

}