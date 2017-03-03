<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Job_Order_Tags_Model extends CI_Model {

    private $job_order_tagsTable = 'job_order_tag';
    private $job_order_tagsColumn = 'job_order_tag_id';

    public function __construct()
    {
        parent::__construct();
    }

    public function insert($data)
    {
        $this->db->insert($this->job_order_tagsTable, $data);
        return $this->db->insert_id();
    }

    public function modify($data, $id)
    {   
        $this->db->where($this->job_order_tagsColumn, $id);
        $this->db->update($this->job_order_tagsTable, $data);
        return true;
    }

    public function find($id)
    {
        $query = $this->db->where($this->job_order_tagsColumn, $id)->get($this->job_order_tagsTable);
        
        foreach($query->result() as $row)
        {
            $arr[] = array(
            'bill_to' => $row->customer_id,
            'billing_discount' => $row->job_order_tags_discount,
            'billing_quantity' => $row->job_order_tags_qty,
            'billing_uom' => $row->unit_of_measurement_id
            );
        }

        return $arr;
    }

    public function check($job_order_id, $tag_id)
    {
        $this->db->where('job_order_id', $job_order_id);
        $this->db->where('job_order_id_tag', $tag_id);
        $query = $this->db->get($this->job_order_tagsTable);
        return $query->num_rows();
    }

    public function delete($job_order_id)
    {
        $this->db->where('job_order_id', $job_order_id);
        $this->db->delete($this->job_order_tagsTable);
        return $this->db->affected_rows() > 0;
    }
    
}