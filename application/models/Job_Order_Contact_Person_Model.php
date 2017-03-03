<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class job_order_contact_person_Model extends CI_Model {

    private $job_order_contact_personTable = 'job_order_contact_person';
    private $job_order_contact_personColumn = 'job_order_contact_person_id';

    public function __construct()
    {
        parent::__construct();
    }

    public function insert($data)
    {
        $this->db->insert($this->job_order_contact_personTable, $data);
        return $this->db->insert_id();
    }

    public function modify($data, $id)
    {   
        $this->db->where($this->job_order_contact_personColumn, $id);
        $this->db->update($this->job_order_contact_personTable, $data);
        return true;
    }
    
    public function delete($job_order_id)
    {
        $this->db->where('job_order_id', $job_order_id);
        $this->db->delete($this->job_order_contact_personTable);
        return $this->db->affected_rows() > 0;
    }
}