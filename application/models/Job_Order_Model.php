<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Job_Order_Model extends CI_Model {

    private $job_orderTable = 'job_order';
    private $job_orderColumn = 'job_order_id';

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

    
    public function form_input_jo_no_attributes($data, $id)
    {
        if(isset($id) && !empty($id))
        {   
            $this->db->where('job_order_no', $id);
            $query = $this->db->get($this->job_orderTable);

            foreach ($query->result() as $row) {
                $value = $row->$data;
            }

            $attributes = array(
                'name'          => $data,
                'id'            => $data,
                'type'          => 'text',
                'value'         => $value,
                'class'         => 'form-control input-md',
                'disabled'      => 'disabled',
                'placeholder'   => 'insert '.str_replace('_', ' ', $data).' here'
            );
        } 
        else {
            $attributes = array(
                'name'          => $data,
                'id'            => $data,
                'type'          => 'text',
                'class'         => 'form-control input-md',
                'disabled'      => 'disabled',
                'placeholder'   => '**********'
            );
        }
        return $attributes;
    }

    public function form_input_jo_status_attributes($data, $id)
    {
        if(isset($id) && !empty($id))
        {   
            $this->db->where('job_order_no', $id);
            $query = $this->db->get($this->job_orderTable);

            foreach ($query->result() as $row) {
                $value = $this->Job_Status_Model->find_status_name_by_id($row->$data);
            }

            $attributes = array(
                'name'          => $data,
                'id'            => $data,
                'type'          => 'text',
                'value'         => $value,
                'class'         => 'form-control input-md',
                'disabled'      => 'disabled',
                'placeholder'   => 'insert '.str_replace('_', ' ', $data).' here'
            );
        } 
        else {
            
            $value = $this->Job_Status_Model->find_status_name_by_id(1);

            $attributes = array(
                'name'          => $data,
                'id'            => $data,
                'type'          => 'text',
                'value'         => $value,
                'class'         => 'form-control input-md',
                'disabled'      => 'disabled',
                'placeholder'   => '**********'
            );
        }
        return $attributes;
    }

    public function form_input_numeric_attributes($data, $id)
    {   
        if(isset($id) && !empty($id))
        {   
            $this->db->where($this->job_orderColumn, $id);
            $query = $this->db->get($this->job_orderTable);

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

    public function count_jo()
    {
        $this->db->select('*');
        $this->db->from($this->job_orderTable);
        $query = $this->db->get();

        if($query->num_rows() < 9)
        {
            $query = '000'.($query->num_rows()+1);
            return $query;
        }
        else if($query->num_rows() < 99)
        {
            $query = '00'.($query->num_rows()+1);
            return $query;
        }
        else if($query->num_rows() < 999)
        {
            $query = '0'.($query->num_rows()+1);
            return $query;
        } 
        else {
            $query = ($query->num_rows()+1);
            return $query;
        }  
    }   

    public function find_job_id_by_job_no($job_no)
    {
        $this->db->where('job_order_no', $job_no);
        $query = $this->db->get($this->job_orderTable);
        foreach ($query->result() as $row) {
            $job_no = $row->job_order_id;
        }
        return $job_no;
    }

    public function get_all_job($start_from=0, $limit=0)
    {  
        $this->db->select('*');
        $this->db->from($this->job_orderTable);
        $this->db->order_by($this->job_orderColumn, 'DESC');
        $query = $this->db->limit( $limit, $start_from )->get();
        return $query;
    }

    public function get_alls_job()
    {   
        $this->db->select('*');
        $this->db->from($this->job_orderTable);
        $this->db->order_by($this->job_orderColumn, 'DESC');
        $query = $this->db->get();
        return $query;
    }

    public function like_job($wildcard='', $start_from=0, $limit=0)
    {
        return $this->db->query("SELECT * FROM cite_form as cite INNER JOIN employee_information as emp ON cite.cite_reported_by = emp.emp_id INNER JOIN department_information as dep ON emp.dep_id = dep.dep_id 
            WHERE ( (cite.cite_status != 'PROCESS') AND (cite.cite_reported_by = ".$this->session->userdata('emp_id').") OR (cite.cite_status != 'DRAFT') ) AND ( (cite.cite_status != 'DELETED') AND (cite.cite_status != 'PROCESS') AND (cite.cite_status != 'DONE') ) AND ( (cite.cite_status LIKE '%".$wildcard."%') OR (cite.cite_id LIKE '%".$wildcard."%') OR (emp.emp_firstname LIKE '%".$wildcard."%') OR (emp.emp_middlename LIKE '%".$wildcard."%') OR (emp.emp_lastname LIKE '%".$wildcard."%') OR (dep.dep_name LIKE '%".$wildcard."%')) ORDER BY cite.cite_id ASC LIMIT ".$start_from.", ".$limit."");   
    }

    public function likes_job($wildcard='')
    {
        return $this->db->query("SELECT * FROM cite_form as cite INNER JOIN employee_information as emp ON cite.cite_reported_by = emp.emp_id INNER JOIN department_information as dep ON emp.dep_id = dep.dep_id WHERE ( (cite.cite_status !='PROCESS') AND (cite.cite_reported_by = ".$this->session->userdata('emp_id').") OR (cite.cite_status != 'DRAFT') ) AND ( (cite.cite_status != 'DELETED') AND (cite.cite_status != 'PROCESS') AND (cite.cite_status != 'DONE') ) AND ( (cite.cite_status LIKE '%".$wildcard."%') OR (cite.cite_id LIKE '%".$wildcard."%') OR (emp.emp_firstname LIKE '%".$wildcard."%') OR (emp.emp_middlename LIKE '%".$wildcard."%') OR (emp.emp_lastname LIKE '%".$wildcard."%') OR (dep.dep_name LIKE '%".$wildcard."%')) ORDER BY cite.cite_id ASC");
    }

    public function insert($data)
    {
        $this->db->insert($this->job_orderTable, $data);
        return $this->db->insert_id();
    }

    public function modify($data, $id)
    {   
        $this->db->where('job_order_no', $id);
        $this->db->update($this->job_orderTable, $data);
        return true;
    }

    public function form_input_jo_attributes($data, $id)
    {
        if(isset($id) && !empty($id))
        {   
            $this->db->where('job_order_no', $id);
            $query = $this->db->get($this->job_orderTable);

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
        else {
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

    public function form_input_numeric_jo_attributes($data, $id)
    {   
        if(isset($id) && !empty($id))
        {   
            $this->db->where('job_order_no', $id);
            $query = $this->db->get($this->job_orderTable);

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

    public function form_select_jo_multiple_attributes($data)
    {
        $attributes = array(
            'name'          => $data.'[]',
            'id'            => $data,
            'class'         => 'selectpicker',
            'multiple'      => 'multiple',
            'data-live-search'  => 'true'
        );

        return $attributes;
    }

    public function form_select_jo_multiple_options($data)
    {   
        $query = $this->db->get($this->job_orderTable);

        foreach ($query->result() as $row)
        {
            $arr[] = array(
                $row->job_order_id => $row->job_order_no
            );
        }

        $array = array();
        foreach($arr as $arrs)
            foreach($arrs as $key => $val)
                $array[$key] = $val;
        return $array;
    }

    public function form_selected_jo_multiple_options($id)
    {   
        $this->db->select('*');
        $this->db->from('job_order_tag as tag');  
        $this->db->join('job_order as job','tag.job_order_id = job.job_order_id');  
        $this->db->where('job.job_order_no', $id);
        $query = $this->db->get();
        
        if($query->num_rows() > 0)
        {   
            $arr = array();

            foreach ($query->result() as $row) {
                $arr[] = $row->job_order_id_tag;
            }

            return $arr;
        }
        else 
        {
            return $id = '0';
        }
    }  

    public function find_job_name_by_job_number($id)
    {
        $this->db->where('job_order_no', $id);
        $query = $this->db->get($this->job_orderTable);

        foreach ($query->result() as $row) {
            $id = $row->job_order_name;
        }

        return $id;
    }  

    public function find_job_number_by_job_id($id)
    {
        $this->db->where($this->job_orderColumn, $id);
        $query = $this->db->get($this->job_orderTable);

        foreach ($query->result() as $row) {
            $id = $row->job_order_no;
        }

        return $id;
    } 

    public function find_job_name_by_job_id($id)
    {
        $this->db->where($this->job_orderColumn, $id);
        $query = $this->db->get($this->job_orderTable);

        foreach ($query->result() as $row) {
            $id = $row->job_order_name;
        }

        return $id;
    }  

    public function find_job_order_id($id)
    {
        $this->db->where('job_order_no', $id);
        $query = $this->db->get($this->job_orderTable);

        foreach ($query->result() as $row) {
            $id = $row->job_order_id;
        }

        return $id;
    }

    public function form_textarea_jo_free_attributes($data, $id)
    {   
        if(isset($id) && !empty($id))
        {   
            $this->db->where('job_order_no', $id);
            $query = $this->db->get($this->job_orderTable);

            foreach ($query->result() as $row) {
                $value = $row->$data;
            }

            $attributes = array(
                'name'          => $data,
                'id'            => $data,
                'rows'          => '5',
                'value'         => $value,
                'class'         => 'auto-size form-control',
                'placeholder'   => 'insert '.str_replace('_', ' ', $data).' here'
            );
        } 
        else 
        {
            $attributes = array(
                'name'          => $data,
                'id'            => $data,
                'rows'          => '5',
                'class'         => 'auto-size form-control',
                'placeholder'   => 'insert '.str_replace('_', ' ', $data).' here'
            );
        }
        return $attributes;        
    }

    public function find_job_order_free_by_id($data, $id)
    {  
        if(isset($id) && !empty($id))
        {  
            $this->db->where('job_order_no', $id);
            $query = $this->db->get($this->job_orderTable);

            foreach ($query->result() as $row) {
                $value = $row->$data;
            }

            return $value;
        }
        else
        {
            return $value = '';
        }
    }

    public function find_agent_by_job_id($job_id)
    {   
        $this->db->select('*');
        $this->db->from('job_order as job');
        $this->db->join('customer as cus','job.customer_id = cus.customer_id');
        $this->db->join('resources as res','cus.resources_id = res.resources_id');
        $this->db->where($this->job_orderColumn, $job_id);
        $query = $this->db->get();
        
        foreach ($query->result() as $row) {
            $job_id = $row->resources_firstname.' '.$row->resources_lastname;
        }

        return $job_id;
    }

    public function find_customer_name_by_job_id($job_id)
    {   
        $this->db->select('*');
        $this->db->from('job_order as job');
        $this->db->join('customer as cus','job.customer_id = cus.customer_id');
        $this->db->where($this->job_orderColumn, $job_id);
        $query = $this->db->get();
        
        foreach ($query->result() as $row) {
            $job_id = $row->customer_name;
        }

        return $job_id;
    }

    public function form_input_view_jo_jobrequest_attributes($data, $id)
    {
        if(isset($id) && !empty($id))
        {   
            $this->db->select('*');
            $this->db->from('job_request_module as job');
            $this->db->join('job_order as jo','job.job_order_id = jo.job_order_id');
            $this->db->where('job.job_request_module_id', $id);
            $query = $this->db->get();

            foreach ($query->result() as $row) {
                $value = $row->$data;
            }

            $attributes = array(
                'name'          => $data,
                'id'            => $data,
                'type'          => 'text',
                'value'         => $value,
                'class'         => 'form-control input-md',
                'disabled'      => 'disabled',
                'placeholder'   => 'insert '.str_replace('_', ' ', $data).' here'
            );
        } 
        else {
            $attributes = array(
                'name'          => $data,
                'id'            => $data,
                'type'          => 'text',
                'class'         => 'form-control input-md',
                'disabled'      => 'disabled',
                'placeholder'   => '**********'
            );
        }
        return $attributes;
    }

    public function form_input_view_jo_name_jobrequest_attributes($data, $id)
    {
        if(isset($id) && !empty($id))
        {   
            $this->db->select('*');
            $this->db->from('job_request_module as job');
            $this->db->join('job_order as jo','job.job_order_id = jo.job_order_id');
            $this->db->where('job.job_request_module_id', $id);
            $query = $this->db->get();

            foreach ($query->result() as $row) {
                $value = $row->$data;
            }

            $attributes = array(
                'name'          => $data,
                'id'            => $data,
                'type'          => 'text',
                'value'         => $value,
                'class'         => 'form-control input-md',
                'disabled'      => 'disabled',
                'placeholder'   => 'insert '.str_replace('_', ' ', $data).' here'
            );
        } 
        else {
            $attributes = array(
                'name'          => $data,
                'id'            => $data,
                'type'          => 'text',
                'class'         => 'form-control input-md',
                'disabled'      => 'disabled',
                'placeholder'   => '**********'
            );
        }
        return $attributes;
    }
    
}