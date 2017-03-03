<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Job_Status_Model extends CI_Model {

    private $job_statusTable = 'job_status';
    private $job_statusColumn = 'job_status_id';

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

    public function form_select_job_request_attributes($data, $id)
    {   
        if(isset($id) && !empty($id))
        {
            $attributes = array(
                'name'          => $data,
                'id'            => $data,
                'disabled'      => 'disabled',
                'class'         => 'selectpicker',
                'data-live-search'  => 'true'
            );
        } 
        else 
        {
            $attributes = array(
                'name'          => $data,
                'id'            => $data,
                'class'         => 'selectpicker',
                'data-live-search'  => 'true'
            );
        }
        return $attributes;
    }

    public function form_select_attach_job_elem_attributes($data)
    {
        $attributes = array(
            'name'          => $data,
            'id'            => $data,
            'disabled'      => 'disabled',
            'class'         => 'selectpicker',
            'data-live-search'  => 'true'
        );

        return $attributes;
    }

    public function form_select_options($data)
    {   
        $query = $this->db->get($this->job_statusTable);
        
        $arr[] = array(
            '0' => 'select '.str_replace('_', ' ', $data).' here',
        );

        foreach ($query->result() as $row)
        {
            $arr[] = array(
                $row->job_status_id => $row->job_status_name
            );
        }

        $array = array();
        foreach($arr as $arrs)
            foreach($arrs as $key => $val)
                $array[$key] = $val;
        return $array;
    }

    public function form_select_job_request_options($data, $id)
    { 
        $job_id = $this->Job_Order_Model->find_job_id_by_job_no($id);

        $this->db->select('job_status_id');
        $this->db->from('job_order');
        $this->db->where('job_order_id', $job_id);
        $query = $this->db->get();
        
        $arr[] = array(
            '0' => 'select '.str_replace('_', ' ', $data).' here',
        );

        foreach ($query->result() as $row)
        {
            $this->db->select('jobs.job_status_id_dup');
            $this->db->from('job_status_role as jobs');
            $this->db->where('jobs.job_status_id', $row->job_status_id);
            $query1 = $this->db->get();
            foreach ($query1->result() as $row1) {
                $arr[] = array(
                    $row1->job_status_id_dup => $this->find_status_name_by_id($row1->job_status_id_dup)
                );
            }
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
        $this->db->from($this->job_statusTable.' as job_status');
        $this->db->join('job_order as job','job_status.job_status_id = job.job_status_id');    
        $this->db->where('job.job_order_id',$id);
        $query = $this->db->get();
        
        if($query->num_rows() > 0)
        {
            foreach ($query->result() as $row) {
                $id = $row->job_status_id;
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
        $query = $this->db->get($this->job_statusTable);
        
        $arr[] = array(
            '0' => 'select '.str_replace('_', ' ', $data).' here',
        );

        foreach ($query->result() as $row)
        {
            $arr[] = array(
                $row->job_status_id => $row->job_status_name
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
        $this->db->from($this->job_statusTable.' as job_status');
        $this->db->join('job_order as job','job_status.job_status_id = job.job_status_id');    
        $this->db->where('job.job_order_id',$job_id);
        $query = $this->db->get();
        
        if($query->num_rows() > 0)
        {
            foreach ($query->result() as $row) {
                $id = $row->job_status_id;
            }

            return $id;
        }
        else 
        {
            return $id = '0';
        }
    }   

    public function form_selected_job_request_options($id)
    {   
        $job_id = $this->Job_Order_Model->find_job_id_by_job_no($id);

        $this->db->select('*');
        $this->db->from($this->job_statusTable.' as job_status');
        $this->db->join('job_order as job','job_status.job_status_id = job.job_status_id');    
        $this->db->where('job.job_order_id',$job_id);
        $query = $this->db->get();
        
        if($query->num_rows() > 0)
        {
            foreach ($query->result() as $row) {
                $id = $row->job_status_id;
            }

            return $id;
        }
        else 
        {
            return $id = '0';
        }
    }   

    public function find_status_name_by_id($id)
    {
        $this->db->where($this->job_statusColumn, $id);
        $query = $this->db->get($this->job_statusTable);

        foreach ($query->result() as $row) {
            $id = $row->job_status_name;
        }

        return $id;
    }

    public function form_select_view_jobrequest_attributes($data, $id)
    {   
        if(isset($id) && !empty($id))
        {
            $attributes = array(
                'name'          => $data,
                'id'            => $data,
                'disabled'      => 'disabled',
                'class'         => 'selectpicker',
                'data-live-search'  => 'true'
            );
        } 
        else 
        {
            $attributes = array(
                'name'          => $data,
                'id'            => $data,
                'class'         => 'selectpicker',
                'data-live-search'  => 'true'
            );
        }
        return $attributes;
    }

    public function form_select_view_jobrequest_options($data, $id)
    { 
        $query = $this->db->get($this->job_statusTable);
        
        $arr[] = array(
            '0' => 'select '.str_replace('_', ' ', $data).' here',
        );

        foreach ($query->result() as $row)
        {
            $arr[] = array(
                $row->job_status_id => $row->job_status_name
            );
        }

        $array = array();
        foreach($arr as $arrs)
            foreach($arrs as $key => $val)
                $array[$key] = $val;
        return $array;
    }   

    public function form_selected_view_jobrequest_options($id)
    {   
        $this->db->select('*');
        $this->db->from('job_request_module as job');
        $this->db->join('job_order as jo','job.job_order_id = jo.job_order_id');
        $this->db->where('job.job_request_module_id', $id);
        $query = $this->db->get();
        
        if($query->num_rows() > 0)
        {
            foreach ($query->result() as $row) {
                $id = $row->job_status_id;
            }

            return $id;
        }
        else 
        {
            return $id = '0';
        }
    } 

}