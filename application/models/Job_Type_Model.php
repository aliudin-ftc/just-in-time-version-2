<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Job_Type_Model extends CI_Model {

    private $job_typeTable = 'job_type';
    private $job_typeColumn = 'job_type_id';

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

    public function form_select_options($data)
    {   
        $query = $this->db->get($this->job_typeTable);
        
        $arr[] = array(
            '0' => 'select '.str_replace('_', ' ', $data).' here',
        );

        foreach ($query->result() as $row)
        {
            $arr[] = array(
                $row->job_type_id => $row->job_type_name
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
        $this->db->from($this->job_typeTable.' as job_type');
        $this->db->join('job_order as job','job_type.job_type_id = job.job_type_id');    
        $this->db->where('job.job_order_id',$id);
        $query = $this->db->get();
        
        if($query->num_rows() > 0)
        {
            foreach ($query->result() as $row) {
                $id = $row->job_type_id;
            }

            return $id;
        }
        else 
        {
            return $id = '0';
        }
    } 


    public function form_select_jo_attributes($data)
    {
        $attributes = array(
            'name'          => $data,
            'id'            => $data,
            'class'         => 'selectpicker',
            'data-live-search'  => 'true'
        );

        return $attributes;
    }

    public function form_select_jo_options($data)
    {   
        $query = $this->db->get($this->job_typeTable);
        
        $arr[] = array(
            '0' => 'select '.str_replace('_', ' ', $data).' here',
        );

        foreach ($query->result() as $row)
        {
            $arr[] = array(
                $row->job_type_id => $row->job_type_name
            );
        }

        $array = array();
        foreach($arr as $arrs)
            foreach($arrs as $key => $val)
                $array[$key] = $val;
        return $array;
    }

    public function form_selected_jo_options($id)
    {   
        $job_id = $this->Job_Order_Model->find_job_id_by_job_no($id);

        $this->db->select('*');
        $this->db->from($this->job_typeTable.' as job_type');
        $this->db->join('job_order as job','job_type.job_type_id = job.job_type_id');    
        $this->db->where('job.job_order_id',$job_id);
        $query = $this->db->get();
        
        if($query->num_rows() > 0)
        {
            foreach ($query->result() as $row) {
                $id = $row->job_type_id;
            }

            return $id;
        }
        else 
        {
            return $id = '0';
        }
    }      
}