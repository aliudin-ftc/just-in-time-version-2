<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Job_Order_Bill_Model extends CI_Model {

    private $job_order_billTable = 'job_order_bill';
    private $job_order_billColumn = 'job_order_bill_id';

    public function __construct()
    {
        parent::__construct();
    }

    public function form_input_attributes($data)
    {
        $attributes = array(
            'name'          => $data,
            'id'            => $data,
            'type'          => 'text',
            'class'         => 'form-control input-md',
            'placeholder'   => 'insert '.str_replace('_', ' ', $data).' here'
        );

        return $attributes;
    }

    public function form_select_attributes($data)
    {
        $attributes = array(
            'name'          => $data,
            'id'            => $data,
            'class'         => 'selectpicker',
            'data-live-search'  => 'true'
        );

        return $attributes;
    }

    public function form_input_numeric_attributes($data, $id)
    {   
        if(isset($id) && !empty($id))
        {   
            $this->db->where($this->unit_of_measurementColumn, $id);
            $query = $this->db->get($this->unit_of_measurementTable);

            foreach ($query->result() as $row) {
                $value = $row->$data;
            }

            $attributes = array(
                'name'          => $data,
                'id'            => $data,
                'type'          => 'text',
                'value'         => $value,
                'class'         => 'form-control input-md numeric',
                'placeholder'   => 'insert '.str_replace('_', ' ', $data).' here'
            );
        } 
        else {
            $attributes = array(
                'name'          => $data,
                'id'            => $data,
                'type'          => 'text',
                'class'         => 'form-control input-md numeric',
                'placeholder'   => 'insert '.str_replace('_', ' ', $data).' here'
            );
        }
        return $attributes;
    }

    public function form_select_options($data)
    {   
        $query = $this->db->get($this->job_orderTable);
        
        $arr[] = array(
            '0' => 'select '.str_replace('_', ' ', $data).' here',
        );

        foreach ($query->result() as $row)
        {
            $arr[] = array(
                $row->job_order_id => $row->job_order_name
            );
        }

        $array = array();
        foreach($arr as $arrs)
            foreach($arrs as $key => $val)
                $array[$key] = $val;
        return $array;
    }

    public function form_selected_options($id)
    {   
        $this->db->select('*');
        $this->db->from($this->job_orderTable.' as job_order');
        $this->db->join('job_order as job','job_order.job_order_id = job.job_order_id');    
        $this->db->where('job.job_order_id',$id);
        $query = $this->db->get();
        
        if($query->num_rows() > 0)
        {
            foreach ($query->result() as $row) {
                $id = $row->job_order_id;
            }

            return $id;
        }
        else 
        {
            return $id = '0';
        }
    }   

    public function get_all_job_bills($start_from=0, $limit=0, $job_no)
    {  
        $this->db->select('job_bill.customer_id, job_bill.job_order_bill_id, job_bill.job_order_bill_qty, job_bill.job_order_bill_discount, job_bill.unit_of_measurement_id');
        $this->db->from($this->job_order_billTable.' as job_bill');
        $this->db->join('job_order as job','job_bill.job_order_id = job.job_order_id');
        $this->db->join('status as stat',' job_bill.job_order_bill_id = stat.status_table_id');
        $this->db->where('stat.status_table', $this->job_order_billTable);  
        $this->db->where('stat.status_code', 1);  
        $this->db->where('job.job_order_no', $job_no);
        $this->db->order_by('job_bill.'.$this->job_order_billColumn, 'DESC');
        $query = $this->db->limit( $limit, $start_from )->get();
        return $query;
    }

    public function get_alls_job_bills($job_no)
    {   
        $this->db->select('job_bill.customer_id, job_bill.job_order_bill_id, job_bill.job_order_bill_qty, job_bill.job_order_bill_discount, job_bill.unit_of_measurement_id');
        $this->db->from($this->job_order_billTable.' as job_bill');
        $this->db->join('job_order as job','job_bill.job_order_id = job.job_order_id');
        $this->db->join('status as stat',' job_bill.job_order_bill_id = stat.status_table_id');
        $this->db->where('stat.status_table', $this->job_order_billTable);  
        $this->db->where('stat.status_code', 1);  
        $this->db->where('job.job_order_no', $job_no);
        $this->db->order_by('job_bill.'.$this->job_order_billColumn, 'DESC');
        $query = $this->db->get();
        return $query;
    }

    public function likes_job_bills($job_no, $start_from=0, $limit=0)
    {
        $this->db->select('job_bill.customer_id, job_bill.job_order_bill_id, job_bill.job_order_bill_qty, job_bill.job_order_bill_discount, job_bill.unit_of_measurement_id');
        $this->db->from($this->job_order_billTable.' as job_bill');
        $this->db->join('job_order as job','job_bill.job_order_id = job.job_order_id');
        $this->db->where('job.job_order_no', $job_no);
        $this->db->order_by('job_bill.'.$this->job_order_billColumn, 'DESC');
        $query = $this->db->limit( $limit, $start_from )->get();
        return $query;
    }

    public function like_job_bills($job_no)
    {
        $this->db->select('job_bill.customer_id, job_bill.job_order_bill_id, job_bill.job_order_bill_qty, job_bill.job_order_bill_discount, job_bill.unit_of_measurement_id');
        $this->db->from($this->job_order_billTable.' as job_bill');
        $this->db->join('job_order as job','job_bill.job_order_id = job.job_order_id');
        $this->db->where('job.job_order_no', $job_no);
        $this->db->order_by('job_bill.'.$this->job_order_billColumn, 'DESC');
        $query = $this->db->get();
        return $query;
    }    

    public function form_input_numeric_jo_attributes($data, $id)
    { 
        $attributes = array(
            'name'          => $data,
            'id'            => $data,
            'type'          => 'text',
            'class'         => 'form-control input-md numeric',
            'placeholder'   => 'insert '.str_replace('_', ' ', $data).' here'
        );

        return $attributes;
    }

    public function insert($data)
    {
        $this->db->insert($this->job_order_billTable, $data);
        return $this->db->insert_id();
    }

    public function modify($data, $id)
    {   
        $this->db->where('job_order_id', $id);
        $this->db->update($this->job_order_billTable, $data);

        $this->db->where('job_order_id', $id);
        $query = $this->db->get($this->job_order_billTable);

        foreach($query->result() as $row)
        {
            return $row->job_order_bill_id;
        }
    }

    public function change($data, $id)
    {   
        $this->db->where($this->job_order_billColumn, $id);
        $this->db->update($this->job_order_billTable, $data);
        return true;
    }

    public function find($id)
    {
        $query = $this->db->where($this->job_order_billColumn, $id)->get($this->job_order_billTable);
        
        foreach($query->result() as $row)
        {
            $arr[] = array(
            'bill_to' => $row->customer_id,
            'billing_discount' => $row->job_order_bill_discount,
            'billing_quantity' => $row->job_order_bill_qty,
            'billing_uom' => $row->unit_of_measurement_id
            );
        }

        return $arr;
    }

    public function check_rows($job_order_id, $customer_id, $discount, $quantity, $uom)
    {
        $this->db->select('*');
        $this->db->from('job_order_bill as job_bill');
        $this->db->join('status as stat','job_bill.job_order_bill_id = stat.status_table_id');
        $this->db->where('stat.status_table', $this->job_order_billTable);  
        $this->db->where('stat.status_code', 1);  
        $this->db->where('job_bill.job_order_id', $job_order_id);
        $query = $this->db->get();

        if($query->num_rows() > 1)
        {
            return 'many';
        } 
        else if ($query->num_rows() == 1)
        {
            $this->db->where('job_order_id', $job_order_id);
            $this->db->where('customer_id', $customer_id);
            $this->db->where('unit_of_measurement_id', $uom);
            $this->db->where('job_order_bill_qty', $quantity);
            $this->db->where('job_order_bill_discount', $discount);
            $query1 = $this->db->get($this->job_order_billTable);

            if($query1->num_rows() > 0)
            {
                return 'one';
            } else {
                return 'none';
            }

        } else {
            return 'nothing';
        }
    }

}