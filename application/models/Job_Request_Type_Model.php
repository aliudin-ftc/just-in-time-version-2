<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Job_Request_Type_Model extends CI_Model {

    private $job_request_typeTable = 'job_request_type';
    private $job_request_typeColumn = 'job_request_type_id';

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
        $query = $this->db->get($this->job_request_typeTable);
        
        $arr[] = array(
            '0' => 'select '.str_replace('_', ' ', $data).' here',
        );

        foreach ($query->result() as $row)
        {
            $arr[] = array(
                $row->job_request_type_id => $row->job_request_type_name
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
        $this->db->from($this->job_request_typeTable.' as job_request_type');
        $this->db->join('job_order as job','job_request_type.job_request_type_id = job.job_request_type_id');    
        $this->db->where('job.job_order_id',$id);
        $query = $this->db->get();
        
        if($query->num_rows() > 0)
        {
            foreach ($query->result() as $row) {
                $id = $row->job_request_type_id;
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
        if(isset($id) && !empty($id))
        {   
            $this->db->select('*');
            $this->db->from('job_request_type as req');
            $this->db->join('job_request_module as req_mod', 'req.job_request_type_id = req_mod.job_request_type_id');
            $this->db->where('job_request_module_id', $id);
            $query = $this->db->get();
            
            if($query->num_rows() > 0)
            {
                foreach ($query->result() as $row) {
                    $id = $row->job_request_type_id;
                }

                return $id;
            }
            else 
            {
                return $id = '0';
            }
        } else {     
            $this->db->where($this->job_request_typeColumn, $id);
            $query = $this->db->get($this->job_request_typeTable);
            
            if($query->num_rows() > 0)
            {
                foreach ($query->result() as $row) {
                    $id = $row->job_request_type_id;
                }

                return $id;
            }
            else 
            {
                return $id = '0';
            }
        }
    }   

    public function find_request_type_name_by_id($id)
    {
        $this->db->where($this->job_request_typeColumn, $id);
        $query = $this->db->get($this->job_request_typeTable);

        foreach ($query->result() as $row) {
            $id = $row->job_request_type_name;
        }

        return $id;
    }

    public function get_request_type_by_job_request($id)
    {   
        $this->db->where('job_request_id', $id);
        $query = $this->db->get('job_request_job_request_type');

        if($query->num_rows() > 0)
        {
            foreach ($query->result() as $row) {
                $this->db->where($this->job_request_typeColumn, $row->job_request_type_id);
                $query1 = $this->db->get($this->job_request_typeTable);

                foreach ($query1->result() as $row1)
                {
                    $arr[] = array(
                        'job_request_type_id' => $row1->job_request_type_id,
                        'job_request_type_name' => $row1->job_request_type_name
                    );       
                }
            }  
        }
        else
        {
            $query = $this->db->get($this->job_request_typeTable);

            foreach ($query->result() as $row)
            {
                $arr[] = array(
                    'job_request_type_id' => $row->job_request_type_id,
                    'job_request_type_name' => $row->job_request_type_name
                );       
            }
        }
        return $arr;  
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
        $query = $this->db->get($this->job_request_typeTable);
        
        $arr[] = array(
            '0' => 'select '.str_replace('_', ' ', $data).' here',
        );

        foreach ($query->result() as $row)
        {
            $arr[] = array(
                $row->job_request_type_id => $row->job_request_type_name
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
                $id = $row->job_request_type_id;
            }

            return $id;
        }
        else 
        {
            return $id = '0';
        }
    } 
}