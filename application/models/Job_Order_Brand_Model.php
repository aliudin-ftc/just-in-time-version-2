<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Job_Order_Brand_Model extends CI_Model {

    private $job_order_brandTable = 'job_order_brand';
    private $job_order_brandColumn = 'job_order_brand_id';

    public function __construct()
    {
        parent::__construct();
    }

    public function insert($data)
    {
        $this->db->insert($this->job_order_brandTable, $data);
        return $this->db->insert_id();
    }

    public function modify($data, $id)
    {   
        $this->db->where($this->job_order_brandColumn, $id);
        $this->db->update($this->job_order_brandTable, $data);
        return true;
    }

    public function find($id)
    {
        $query = $this->db->where($this->job_order_brandColumn, $id)->get($this->job_order_brandTable);
        
        foreach($query->result() as $row)
        {
            $arr[] = array(
            'bill_to' => $row->customer_id,
            'billing_discount' => $row->job_order_brand_discount,
            'billing_quantity' => $row->job_order_brand_qty,
            'billing_uom' => $row->unit_of_measurement_id
            );
        }

        return $arr;
    }

    public function delete($job_order_id)
    {
        $this->db->where('job_order_id', $job_order_id);
        $this->db->delete($this->job_order_brandTable);
        return $this->db->affected_rows() > 0;
    }
}