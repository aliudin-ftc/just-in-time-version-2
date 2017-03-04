<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Job_Request_Category_Model extends CI_Model {

    private $job_request_categoryTable = 'job_request_category';
    private $job_request_categoryColumn = 'job_request_category_id';

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
        $query = $this->db->get($this->job_request_categoryTable);
        
        $arr[] = array(
            '0' => 'select '.str_replace('_', ' ', $data).' here',
        );

        foreach ($query->result() as $row)
        {
            $arr[] = array(
                $row->job_request_category_id => $row->job_request_category_name
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
        $this->db->from($this->job_request_categoryTable.' as job_request_category');
        $this->db->join('job_order as job','job_request_category.job_request_category_id = job.job_request_category_id');    
        $this->db->where('job.job_order_id',$id);
        $query = $this->db->get();
        
        if($query->num_rows() > 0)
        {
            foreach ($query->result() as $row) {
                $id = $row->job_request_category_id;
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
            $this->db->from('job_request_category as req');
            $this->db->join('job_request_module as req_mod', 'req.job_request_category_id = req_mod.job_request_category_id');
            $this->db->where('job_request_module_id', $id);
            $query = $this->db->get();
            
            if($query->num_rows() > 0)
            {
                foreach ($query->result() as $row) {
                    $id = $row->job_request_category_id;
                }

                return $id;
            }
            else 
            {
                return $id = '0';
            }
        } else {
            $this->db->where($this->job_request_categoryColumn, $id);
            $query = $this->db->get($this->job_request_categoryTable);
            
            if($query->num_rows() > 0)
            {
                foreach ($query->result() as $row) {
                    $id = $row->job_request_category_id;
                }

                return $id;
            }
            else 
            {
                return $id = '0';
            }
        }
    } 

    public function get_request_category_by_job_request($id)
    {   
        $this->db->where('job_request_id', $id);
        $query = $this->db->get('job_request_job_request_category');

        if($query->num_rows() > 0)
        {
            foreach ($query->result() as $row) {
                $this->db->where($this->job_request_categoryColumn, $row->job_request_category_id);
                $query1 = $this->db->get($this->job_request_categoryTable);

                foreach ($query1->result() as $row1)
                {
                    $arr[] = array(
                        'job_request_category_id' => $row1->job_request_category_id,
                        'job_request_category_name' => $row1->job_request_category_name
                    );       
                }
            }  
        }
        else
        {
            $query = $this->db->get($this->job_request_categoryTable);

            foreach ($query->result() as $row)
            {
                $arr[] = array(
                    'job_request_category_id' => $row->job_request_category_id,
                    'job_request_category_name' => $row->job_request_category_name
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
        $query = $this->db->get($this->job_request_categoryTable);
        
        $arr[] = array(
            '0' => 'select '.str_replace('_', ' ', $data).' here',
        );

        foreach ($query->result() as $row)
        {
            $arr[] = array(
                $row->job_request_category_id => $row->job_request_category_name
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
                $id = $row->job_request_category_id;
            }

            return $id;
        }
        else 
        {
            return $id = '0';
        }
    } 
}