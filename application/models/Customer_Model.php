<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Customer_Model extends CI_Model {

    private $customerTable = 'customer';
    private $customerColumn = 'customer_id';

    public function __construct()
    {
        parent::__construct();
    }

    public function form_input_attributes($data, $id)
    {   
        if(isset($id) && !empty($id))
        {   
            $this->db->where($this->customerColumn, $id);
            $query = $this->db->get($this->customerTable);

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

    public function form_textarea_attributes($data, $id)
    {   
        if(isset($id) && !empty($id))
        {   
            $this->db->where($this->customerColumn, $id);
            $query = $this->db->get($this->customerTable);

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

    public function form_input_numeric_attributes($data, $id)
    {   
        if(isset($id) && !empty($id))
        {   
            $this->db->where($this->customerColumn, $id);
            $query = $this->db->get($this->customerTable);

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
        $query = $this->db->get($this->customerTable);
    
        $arr[] = array(
            '0' => 'select '.str_replace('_', ' ', $data).' here',
        );

        foreach ($query->result() as $row)
        {
            $arr[] = array(
                $row->document_type_id => $row->document_type_description
            );
        }

        return call_user_func_array('array_merge', $arr);
    }   
    
    public function form_file($id)
    {   
        if(isset($id) && !empty($id))
        {
            $this->db->where($this->customerColumn, $id);
            $query = $this->db->get($this->customerTable);

            foreach ($query->result() as $row) {
                $id = $row->customer_logo;
            }
            return $id;
        } 
        else 
        {             
            return $id = '';
        }
    }

    public function find($id)
    {   
        $this->db->select('*');
        $this->db->from('customer as cus');
        $this->db->join('created as cre','cus.customer_id = cre.created_table_id');
        $this->db->where('cre.created_table','customer');    
        $this->db->where('cus.customer_id', $id);
        $query = $this->db->get();

        foreach ($query->result() as $row) {

            if($row->customer_logo != "")
            {
                $this->db->select('*');
                $this->db->join('customer as cus','up.updated_table_id = cus.customer_id');
                $this->db->where('up.updated_table','customer');
                $this->db->order_by('updated_id','desc');
                $query1 = $this->db->get('updated as up','1');
                
                if($query1->num_rows() >0)
                {
                    foreach ($query1->result() as $row1) {
                        $arr[] = array(
                            'customer_logo' => $row->customer_logo,
                            'customer_id' => $row->customer_id
                        );
                    }
                }
                else 
                {
                    $arr[] = array(
                        'customer_logo' => $row->customer_logo,
                        'customer_id' => $row->customer_id
                    );
                }
            }
            else
            {
                    $arr[] = array(
                        'customer_logo' => '',
                        'customer_id' => $row->customer_id
                    );
            }

        }

        return $arr;
    }

    public function insert($data)
    {
        $this->db->insert($this->customerTable, $data);
        return $this->db->insert_id();
    }

    public function modify($data, $id)
    {   
        $this->db->where($this->customerColumn, $id);
        $this->db->update($this->customerTable, $data);
        return true;
    }

    public function get_all_customer($start_from=0, $limit=0)
    {  
        $this->db->select('*');
        $this->db->from($this->customerTable.' as cus');
        $this->db->join('status as stat','cus.customer_id = stat.status_table_id');
        $this->db->where('stat.status_table', $this->customerTable);  
        $this->db->where('stat.status_code', 1);  
        $this->db->order_by('cus.'.$this->customerColumn, 'DESC');
        $query = $this->db->limit( $limit, $start_from )->get();
        return $query;
    }

    public function get_alls_customer()
    {   
        $this->db->select('*');
        $this->db->from($this->customerTable.' as cus');
        $this->db->join('status as stat','cus.customer_id = stat.status_table_id');
        $this->db->where('stat.status_table', $this->customerTable);  
        $this->db->where('stat.status_code', 1);
        $this->db->order_by('cus.'.$this->customerColumn, 'DESC');
        $query = $this->db->get();
        return $query;
    }

    public function like_customer($wildcard='', $start_from=0, $limit=0)
    {
        return $this->db->query("SELECT * FROM cite_form as cite INNER JOIN employee_information as emp ON cite.cite_reported_by = emp.emp_id INNER JOIN department_information as dep ON emp.dep_id = dep.dep_id 
            WHERE ( (cite.cite_status != 'PROCESS') AND (cite.cite_reported_by = ".$this->session->userdata('emp_id').") OR (cite.cite_status != 'DRAFT') ) AND ( (cite.cite_status != 'DELETED') AND (cite.cite_status != 'PROCESS') AND (cite.cite_status != 'DONE') ) AND ( (cite.cite_status LIKE '%".$wildcard."%') OR (cite.cite_id LIKE '%".$wildcard."%') OR (emp.emp_firstname LIKE '%".$wildcard."%') OR (emp.emp_middlename LIKE '%".$wildcard."%') OR (emp.emp_lastname LIKE '%".$wildcard."%') OR (dep.dep_name LIKE '%".$wildcard."%')) ORDER BY cite.cite_id ASC LIMIT ".$start_from.", ".$limit."");   
    }

    public function likes_customer($wildcard='')
    {
        return $this->db->query("SELECT * FROM cite_form as cite INNER JOIN employee_information as emp ON cite.cite_reported_by = emp.emp_id INNER JOIN department_information as dep ON emp.dep_id = dep.dep_id WHERE ( (cite.cite_status !='PROCESS') AND (cite.cite_reported_by = ".$this->session->userdata('emp_id').") OR (cite.cite_status != 'DRAFT') ) AND ( (cite.cite_status != 'DELETED') AND (cite.cite_status != 'PROCESS') AND (cite.cite_status != 'DONE') ) AND ( (cite.cite_status LIKE '%".$wildcard."%') OR (cite.cite_id LIKE '%".$wildcard."%') OR (emp.emp_firstname LIKE '%".$wildcard."%') OR (emp.emp_middlename LIKE '%".$wildcard."%') OR (emp.emp_lastname LIKE '%".$wildcard."%') OR (dep.dep_name LIKE '%".$wildcard."%')) ORDER BY cite.cite_id ASC");
    }

    public function get_all_archived_customer($start_from=0, $limit=0)
    {  
        $this->db->select('*');
        $this->db->from($this->customerTable.' as cus');
        $this->db->join('status as stat','cus.customer_id = stat.status_table_id');
        $this->db->where('stat.status_table', $this->customerTable);  
        $this->db->where('stat.status_code', 0);  
        $this->db->order_by('cus.'.$this->customerColumn, 'DESC');
        $query = $this->db->limit( $limit, $start_from )->get();
        return $query;
    }

    public function get_alls_archived_customer()
    {   
        $this->db->select('*');
        $this->db->from($this->customerTable.' as cus');
        $this->db->join('status as stat','cus.customer_id = stat.status_table_id');
        $this->db->where('stat.status_table', $this->customerTable);  
        $this->db->where('stat.status_code', 0);
        $this->db->order_by('cus.'.$this->customerColumn, 'DESC');
        $query = $this->db->get();
        return $query;
    }

    public function like_archived_customer($wildcard='', $start_from=0, $limit=0)
    {
        return $this->db->query("SELECT * FROM cite_form as cite INNER JOIN employee_information as emp ON cite.cite_reported_by = emp.emp_id INNER JOIN department_information as dep ON emp.dep_id = dep.dep_id 
            WHERE ( (cite.cite_status != 'PROCESS') AND (cite.cite_reported_by = ".$this->session->userdata('emp_id').") OR (cite.cite_status != 'DRAFT') ) AND ( (cite.cite_status != 'DELETED') AND (cite.cite_status != 'PROCESS') AND (cite.cite_status != 'DONE') ) AND ( (cite.cite_status LIKE '%".$wildcard."%') OR (cite.cite_id LIKE '%".$wildcard."%') OR (emp.emp_firstname LIKE '%".$wildcard."%') OR (emp.emp_middlename LIKE '%".$wildcard."%') OR (emp.emp_lastname LIKE '%".$wildcard."%') OR (dep.dep_name LIKE '%".$wildcard."%')) ORDER BY cite.cite_id ASC LIMIT ".$start_from.", ".$limit."");   
    }

    public function likes_archived_customer($wildcard='')
    {
        return $this->db->query("SELECT * FROM cite_form as cite INNER JOIN employee_information as emp ON cite.cite_reported_by = emp.emp_id INNER JOIN department_information as dep ON emp.dep_id = dep.dep_id WHERE ( (cite.cite_status !='PROCESS') AND (cite.cite_reported_by = ".$this->session->userdata('emp_id').") OR (cite.cite_status != 'DRAFT') ) AND ( (cite.cite_status != 'DELETED') AND (cite.cite_status != 'PROCESS') AND (cite.cite_status != 'DONE') ) AND ( (cite.cite_status LIKE '%".$wildcard."%') OR (cite.cite_id LIKE '%".$wildcard."%') OR (emp.emp_firstname LIKE '%".$wildcard."%') OR (emp.emp_middlename LIKE '%".$wildcard."%') OR (emp.emp_lastname LIKE '%".$wildcard."%') OR (dep.dep_name LIKE '%".$wildcard."%')) ORDER BY cite.cite_id ASC");
    }

}