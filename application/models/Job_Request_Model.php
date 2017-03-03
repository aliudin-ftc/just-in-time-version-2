<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Job_Request_Model extends CI_Model {

    private $job_requestTable = 'job_request';
    private $job_requestColumn = 'job_request_id';

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
        $query = $this->db->get($this->job_requestTable);
        
        $arr[] = array(
            '0' => 'select '.str_replace('_', ' ', $data).' here',
        );

        foreach ($query->result() as $row)
        {
            $arr[] = array(
                $row->job_request_id => $row->job_request_name
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
        $this->db->from($this->job_requestTable.' as job_request');
        $this->db->join('job_order as job','job_request.job_request_id = job.job_request_id');    
        $this->db->where('job.job_order_id',$id);
        $query = $this->db->get();
        
        if($query->num_rows() > 0)
        {
            foreach ($query->result() as $row) {
                $id = $row->job_request_id;
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
            $this->db->from('job_request as req');
            $this->db->join('job_request_module as req_mod', 'req.job_request_id = req_mod.job_request_id');
            $this->db->where('job_request_module_id', $id);
            $query = $this->db->get();
            
            if($query->num_rows() > 0)
            {
                foreach ($query->result() as $row) {
                    $id = $row->job_request_id;
                }

                return $id;
            }
            else 
            {
                return $id = '0';
            }
        } else {
            $this->db->where($this->job_requestColumn, $id);
            $query = $this->db->get($this->job_requestTable);
            
            if($query->num_rows() > 0)
            {
                foreach ($query->result() as $row) {
                    $id = $row->job_request_id;
                }

                return $id;
            }
            else 
            {
                return $id = '0';
            }
        }
    }   

    public function find_request_name_by_id($id)
    {
        $this->db->where($this->job_requestColumn, $id);
        $query = $this->db->get($this->job_requestTable);

        foreach ($query->result() as $row) {
            $id = $row->job_request_name;
        }

        return $id;
    }

    public function get_request_by_jobs_status($id)
    {   
        $this->db->where('job_status_id', $id);
        $query = $this->db->get('job_status_job_request');

        if($query->num_rows() > 0)
        {
            foreach ($query->result() as $row) {
                $this->db->where($this->job_requestColumn, $row->job_request_id);
                $query1 = $this->db->get($this->job_requestTable);

                foreach ($query1->result() as $row1)
                {
                    $arr[] = array(
                        'job_request_id' => $row1->job_request_id,
                        'job_request_name' => $row1->job_request_name
                    );       
                }
            }  
        }
        else
        {
            $query = $this->db->get($this->job_requestTable);

            foreach ($query->result() as $row)
            {
                $arr[] = array(
                    'job_request_id' => $row->job__id,
                    'job_request_name' => $row->job_request_name
                );       
            }
        }
        return $arr;  
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
            $this->db->select('jobs.job_request_id');
            $this->db->from('job_status_job_request as jobs');
            $this->db->where('jobs.job_status_id', $row->job_status_id);
            $query1 = $this->db->get();
            foreach ($query1->result() as $row1) {
                $arr[] = array(
                    $row1->job_request_id => $this->find_request_name_by_id($row1->job_request_id)
                );
            }
        }
        
        $array = array();
        foreach($arr as $arrs)
            foreach($arrs as $key => $val)
                $array[$key] = $val;
        return $array;
    }

    public function check_element_attach($job_id, $req_id)
    {
        $this->db->where('job_order_id', $job_id);
        $this->db->where('job_request_module_id', $req_id);
        $query = $this->db->get('job_elements');
        return $query->num_rows();
    }
    
    public function count_required($module, $job_request, $sequence)
    {
        if($job_request == 2 || $job_request == 3 || $job_request == 4 || $job_request == 5)
        {
            $count = 1;

            $this->db->where('job_request_module_id', $module);
            $this->db->where('job_request_module_approval_type', 'approved');
            $query = $this->db->get('job_request_module_approval');
            if($query->num_rows() > 0)
            {
            $count = $count - $query->num_rows();
            }

            return $count;
        }
        else if($job_request == 6)
        {   
            if($sequence >= 4) {
                $count = 2;
            } else {
                $count = 1;
            }

            $this->db->where('job_request_module_id', $module);
            $this->db->where('job_request_module_approval_type', 'approved');
            $query = $this->db->get('job_request_module_approval');
            if($query->num_rows() > 0)
            {
            $count = $count - $query->num_rows();
            }

            return $count;
        }
        else if($job_request == 7)
        {
            $count = 2;

            $this->db->where('job_request_module_id', $module);
            $this->db->where('job_request_module_approval_type', 'approved');
            $query = $this->db->get('job_request_module_approval');
            if($query->num_rows() > 0)
            {
            $count = $count - $query->num_rows();
            }

            return $count;
        }
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
        $query = $this->db->get($this->job_requestTable);
        
        $arr[] = array(
            '0' => 'select '.str_replace('_', ' ', $data).' here',
        );

        foreach ($query->result() as $row)
        {
            $arr[] = array(
                $row->job_request_id => $row->job_request_name
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
                $id = $row->job_request_id;
            }

            return $id;
        }
        else 
        {
            return $id = '0';
        }
    } 
}