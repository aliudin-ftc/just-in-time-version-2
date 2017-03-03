<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Job_Order_Po_Model extends CI_Model {

    private $job_order_poTable = 'job_order_po';
    private $job_order_poColumn = 'job_order_po_id';

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

    public function form_input_jo_attributes($data, $id)
    {   
        if(isset($id) && !empty($id))
        {   
            $job_id = $this->Job_Order_Model->find_job_id_by_job_no($id);

            $this->db->where('job_order_id', $job_id);
            $query = $this->db->get($this->job_order_poTable);

            foreach ($query->result() as $row) {
                $value = $row->$data;
            }

            $attributes = array(
                'name'          => $data,
                'id'            => $data,
                'type'          => 'text',
                'value'         => $value,
                'class'         => 'form-control input-md',
                'placeholder'   => 'insert '.str_replace('_', ' ', $data).' here'
            );
        } 
        else 
        {
            $attributes = array(
                'name'          => $data,
                'id'            => $data,
                'type'          => 'text',
                'class'         => 'form-control input-md',
                'placeholder'   => 'insert '.str_replace('_', ' ', $data).' here'
            );
        }
        return $attributes;
    }

    public function form_input_date_jo_attributes($data, $id)
    {   
        if(isset($id) && !empty($id))
        {   
            $job_id = $this->Job_Order_Model->find_job_id_by_job_no($id);

            $this->db->where('job_order_id', $job_id);
            $query = $this->db->get($this->job_order_poTable);

            foreach ($query->result() as $row) {
                $value = $row->$data;
            }

            $attributes = array(
                'name'          => $data,
                'id'            => $data,
                'type'          => 'text',
                'value'         => date("d-M-Y",strtotime($value)),
                'class'         => 'form-control date-picker',
                'placeholder'   => 'insert '.str_replace('_', ' ', $data).' here'
            );
        } 
        else 
        {
            $attributes = array(
                'name'          => $data,
                'id'            => $data,
                'type'          => 'text',
                'class'         => 'form-control date-picker',
                'placeholder'   => 'insert '.str_replace('_', ' ', $data).' here'
            );
        }

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

    public function form_select_gender_attributes($data)
    {
        $attributes = array(
            'name'          => $data,
            'id'            => $data,
            'class'         => 'selectpicker',
            'data-live-search'  => 'true'
        );

        return $attributes;
    }

    public function form_select_gender_options($data)
    {   
        $arr[] = array(
            '0' => 'select '.str_replace('_', ' ', $data).' here',
        );

        $arr[] = array(
            'Male' => 'Female',
            'Female' => 'Male',
        );

        return call_user_func_array('array_merge', $arr);
    }
    
    public function insert($data)
    {
        $this->db->insert($this->job_order_poTable, $data);
        return $this->db->insert_id();
    } 

    public function modify($data, $id)
    {   
        $this->db->where('job_order_id', $id);
        $this->db->update($this->job_order_poTable, $data);
        return true;
    }
}