<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Contact_Person_Model extends CI_Model {

    private $contact_personTable = 'contact_person';
    private $contact_personColumn = 'contact_person_id';

    public function __construct()
    {
        parent::__construct();
    }

    public function form_input_attributes($data, $id)
    {   
        if(isset($id) && !empty($id))
        {   
            $this->db->where($this->contact_personColumn, $id);
            $query = $this->db->get($this->contact_personTable);

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

    public function form_input_date_attributes($data, $id)
    {   
        if(isset($id) && !empty($id))
        {   
            $this->db->where($this->contact_personColumn, $id);
            $query = $this->db->get($this->contact_personTable);

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
        else {
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

    public function form_select_options($data)
    {   
        $query = $this->db->get($this->contact_personTable);
    
        $arr[] = array(
            '0' => 'select '.str_replace('_', ' ', $data).' here',
        );

        foreach ($query->result() as $row)
        {
            $arr[] = array(
                $row->contact_person_id => $row->contact_person_firstname.' '.$row->contact_person_middlename.' '.$row->contact_person_lastname
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
        $this->db->from($this->contact_personTable);  
        $this->db->where($this->contact_personColumn, $id);
        $query = $this->db->get();
        
        if($query->num_rows() > 0)
        {
            foreach ($query->result() as $row) {
                $id = $row->branch_id;
            }

            return $id;
        }
        else 
        {
            return $id = '0';
        }
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
            'Male' => 'Male',
            'Female' => 'Female',
        );

        return call_user_func_array('array_merge', $arr);
    }

    public function form_selected_gender_options($id)
    {   
        $this->db->select('*');
        $this->db->from($this->contact_personTable);  
        $this->db->where($this->contact_personColumn, $id);
        $query = $this->db->get();
        
        if($query->num_rows() > 0)
        {
            foreach ($query->result() as $row) {
                $id = $row->contact_person_gender;
            }

            return $id;
        }
        else 
        {
            return $id = '0';
        }
    }  

    public function form_textarea_attributes($data, $id)
    {   
        if(isset($id) && !empty($id))
        {   
            $this->db->select('*');
            $this->db->from($this->contact_personTable);
            $this->db->where($this->contact_personColumn, $id);
            $query = $this->db->get();

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

    public function form_input_customer_attributes($data, $id)
    {   
        if(isset($id) && !empty($id))
        {   
            $this->db->select('*');
            $this->db->from('contact_person as conp');
            $this->db->join('customer as cus','conp.customer_id = cus.customer_id');
            $this->db->where('conp.customer_id', $id);
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

    public function form_input_date_customer_attributes($data,$id)
    {   
        if(isset($id) && !empty($id))
        {   
            $this->db->select('*');
            $this->db->from('contact_person as conp');
            $this->db->join('customer as cus','conp.customer_id = cus.customer_id');
            $this->db->where('conp.customer_id', $id);
            $query = $this->db->get();

            foreach ($query->result() as $row) {
                $value = $row->$data;
            }

            $attributes = array(
                'name'          => $data,
                'id'            => $data,
                'type'          => 'text',
                'value'         => date('d-M-Y',strtotime($value)),
                'class'         => 'form-control date-picker',
                'placeholder'   => 'insert '.str_replace('_', ' ', $data).' here'
            );
        } 
        else {
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

    public function insert($data)
    {
        $this->db->insert($this->contact_personTable, $data);
        return $this->db->insert_id();
    } 

    public function modify($data, $id)
    {   
        $this->db->where($this->contact_personColumn, $id);
        $this->db->update($this->contact_personTable, $data);
        return true;
    }

    public function form_input_jo_attributes($data, $id)
    {   
        if(isset($id) && !empty($id))
        {   
            $job_id = $this->Job_Order_Model->find_job_id_by_job_no($id);
        
            $this->db->select('*');
            $this->db->from($this->contact_personTable.' as con');
            $this->db->join('customer as cus','con.customer_id = cus.customer_id');
            $this->db->join('job_order as job','cus.customer_id = job.customer_id');    
            $this->db->where('job.job_order_id',$job_id);
            $query = $this->db->get();

            foreach ($query->result() as $row) {
                $value = $row->$data.' '.$row->contact_person_middlename.'. '.$row->contact_person_lastname;
            }

            $attributes = array(
                'name'          => $data,
                'id'            => $data,
                'type'          => 'text',
                'disabled'      => 'disabled',
                'value'         => $value,
                'class'         => 'form-control input-md font-13',
                'placeholder'   => 'insert '.str_replace('_', ' ', $data).' here'
            );
        } 
        else {
            $attributes = array(
                'name'          => $data,
                'id'            => $data,
                'type'          => 'text',
                'disabled'      => 'disabled',
                'class'         => 'form-control input-md font-13',
                'placeholder'   => 'insert '.str_replace('_', ' ', $data).' here'
            );
        }
        return $attributes;
    }

    public function get_all_contact_person($start_from=0, $limit=0)
    {  
        $this->db->select('*');
        $this->db->from($this->contact_personTable.' as dep');
        $this->db->join('status as stat','dep.contact_person_id = stat.status_table_id');
        $this->db->where('stat.status_table', $this->contact_personTable);  
        $this->db->where('stat.status_code', 1);  
        $this->db->order_by('dep.'.$this->contact_personColumn, 'DESC');
        $query = $this->db->limit( $limit, $start_from )->get();
        return $query;
    }

    public function get_alls_contact_person()
    {   
        $this->db->select('*');
        $this->db->from($this->contact_personTable.' as dep');
        $this->db->join('status as stat','dep.contact_person_id = stat.status_table_id');
        $this->db->where('stat.status_table', $this->contact_personTable);  
        $this->db->where('stat.status_code', 1);
        $this->db->order_by('dep.'.$this->contact_personColumn, 'DESC');
        $query = $this->db->get();
        return $query;
    }

    public function like_contact_person($wildcard='', $start_from=0, $limit=0)
    {
        $this->db->select('*');
        $this->db->from($this->contact_personTable.' as con');
        $this->db->join('status as stat','con.contact_person_id = stat.status_table_id');
        $this->db->join('customer as cus','con.customer_id = cus.customer_id');
        $this->db->where('stat.status_table', $this->contact_personTable);  
        $this->db->where('stat.status_code', 1);  
        $this->db->group_start();
        $this->db->or_where('con.contact_person_id LIKE', '%' . $wildcard . '%');
        $this->db->or_where('con.contact_person_firstname LIKE', '%' . $wildcard . '%');
        $this->db->or_where('con.contact_person_lastname LIKE', '%' . $wildcard . '%');
        $this->db->or_where('con.contact_person_gender LIKE', '%' . $wildcard . '%');
        $this->db->or_where('cus.customer_name LIKE', '%' . $wildcard . '%');
        $this->db->group_end();
        $this->db->order_by('con.'.$this->contact_personColumn, 'DESC');
        $query = $this->db->limit( $limit, $start_from )->get();
        return $query;   
    }

    public function likes_contact_person($wildcard='')
    {
        $this->db->select('*');
        $this->db->from($this->contact_personTable.' as con');
        $this->db->join('status as stat','con.contact_person_id = stat.status_table_id');
        $this->db->join('customer as cus','con.customer_id = cus.customer_id');
        $this->db->where('stat.status_table', $this->contact_personTable);  
        $this->db->where('stat.status_code', 1);  
        $this->db->group_start();
        $this->db->or_where('con.contact_person_id LIKE', '%' . $wildcard . '%');
        $this->db->or_where('con.contact_person_firstname LIKE', '%' . $wildcard . '%');
        $this->db->or_where('con.contact_person_lastname LIKE', '%' . $wildcard . '%');
        $this->db->or_where('con.contact_person_gender LIKE', '%' . $wildcard . '%');
        $this->db->or_where('cus.customer_name LIKE', '%' . $wildcard . '%');
        $this->db->group_end();
        $this->db->order_by('con.'.$this->contact_personColumn, 'DESC');
        $query = $this->db->get();
        return $query;   
    }

    public function get_all_archived_contact_person($start_from=0, $limit=0)
    {  
        $this->db->select('*');
        $this->db->from($this->contact_personTable.' as dep');
        $this->db->join('status as stat','dep.contact_person_id = stat.status_table_id');
        $this->db->where('stat.status_table', $this->contact_personTable);  
        $this->db->where('stat.status_code', 0);  
        $this->db->order_by('dep.'.$this->contact_personColumn, 'DESC');
        $query = $this->db->limit( $limit, $start_from )->get();
        return $query;
    }

    public function get_alls_archived_contact_person()
    {   
        $this->db->select('*');
        $this->db->from($this->contact_personTable.' as dep');
        $this->db->join('status as stat','dep.contact_person_id = stat.status_table_id');
        $this->db->where('stat.status_table', $this->contact_personTable);  
        $this->db->where('stat.status_code', 0);
        $this->db->order_by('dep.'.$this->contact_personColumn, 'DESC');
        $query = $this->db->get();
        return $query;
    }

    public function like_archived_contact_person($wildcard='', $start_from=0, $limit=0)
    {
        $this->db->select('*');
        $this->db->from($this->contact_personTable.' as con');
        $this->db->join('status as stat','con.contact_person_id = stat.status_table_id');
        $this->db->join('customer as cus','con.customer_id = cus.customer_id');
        $this->db->where('stat.status_table', $this->contact_personTable);  
        $this->db->where('stat.status_code', 0);  
        $this->db->group_start();
        $this->db->or_where('con.contact_person_id LIKE', '%' . $wildcard . '%');
        $this->db->or_where('con.contact_person_firstname LIKE', '%' . $wildcard . '%');
        $this->db->or_where('con.contact_person_lastname LIKE', '%' . $wildcard . '%');
        $this->db->or_where('con.contact_person_gender LIKE', '%' . $wildcard . '%');
        $this->db->or_where('cus.customer_name LIKE', '%' . $wildcard . '%');
        $this->db->group_end();
        $this->db->order_by('con.'.$this->contact_personColumn, 'DESC');
        $query = $this->db->limit( $limit, $start_from )->get();
        return $query;     
    }

    public function likes_archived_contact_person($wildcard='')
    {
        $this->db->select('*');
        $this->db->from($this->contact_personTable.' as con');
        $this->db->join('status as stat','con.contact_person_id = stat.status_table_id');
        $this->db->join('customer as cus','con.customer_id = cus.customer_id');
        $this->db->where('stat.status_table', $this->contact_personTable);  
        $this->db->where('stat.status_code', 0);  
        $this->db->group_start();
        $this->db->or_where('con.contact_person_id LIKE', '%' . $wildcard . '%');
        $this->db->or_where('con.contact_person_firstname LIKE', '%' . $wildcard . '%');
        $this->db->or_where('con.contact_person_lastname LIKE', '%' . $wildcard . '%');
        $this->db->or_where('con.contact_person_gender LIKE', '%' . $wildcard . '%');
        $this->db->or_where('cus.customer_name LIKE', '%' . $wildcard . '%');
        $this->db->group_end();
        $this->db->order_by('con.'.$this->contact_personColumn, 'DESC');
        $query = $this->db->get();
        return $query;  
    }

    public function find($id)
    {   
        $this->db->select('*');
        $this->db->from($this->contact_personTable); 
        $this->db->where($this->contact_personColumn, $id);
        $query = $this->db->get();

        foreach ($query->result() as $row) {

            $arr[] = array(
                'contact_person_id' => $row->contact_person_id,
                'customer_id' =>  $row->customer_id,
                'contact_person_firstname' => $row->contact_person_firstname,
                'contact_person_middlename' => $row->contact_person_middlename,
                'contact_person_lastname' => $row->contact_person_lastname,
                'contact_person_position' => $row->contact_person_position,
                'contact_person_gender' => $row->contact_person_gender,
                'contact_person_birthdate' => date("Y-m-d", strtotime($this->input->post('contact_person_birthdate'))),
                'contact_person_interest' => $row->contact_person_interest,
                'contact_person_remarks' => $row->contact_person_remarks
            );
        }

        return $arr;
    }

    public function get_contact_person_by_customer($id)
    {
        $this->db->where('customer_id', $id);
        $query = $this->db->get($this->contact_personTable);

        foreach ($query->result() as $row)
        {
            $arr[] = array(
                'contact_person_id' => $row->contact_person_id,
                'contact_person_firstname' => $row->contact_person_firstname,
                'contact_person_middlename' => $row->contact_person_middlename,
                'contact_person_lastname' => $row->contact_person_lastname,
            );       
        }
        return $arr;   
    }

    public function form_select_jo_options($data, $id)
    {   
        if(isset($id) && !empty($id))
        {   
            $this->db->select('*');
            $this->db->from('job_order as job');
            $this->db->join('customer as cus', 'job.customer_id = cus.customer_id');
            $this->db->join('contact_person as con', 'cus.customer_id = con.customer_id');
            $this->db->where('job.job_order_no', $id);
            $query = $this->db->get();

            $arr[] = array(
                '0' => 'select '.str_replace('_', ' ', $data).' here',
            );

            foreach ($query->result() as $row)
            {
                $arr[] = array(
                    $row->contact_person_id => $row->contact_person_firstname.' '.$row->contact_person_middlename.' '.$row->contact_person_lastname
                );
            }

            $array = array();
            foreach($arr as $arrs)
                foreach($arrs as $key => $val)
                    $array[$key] = $val;
            return $array;
        }
        else {
            $query = $this->db->get($this->contact_personTable);
    
            $arr[] = array(
                '0' => 'select '.str_replace('_', ' ', $data).' here',
            );

            foreach ($query->result() as $row)
            {
                $arr[] = array(
                     $row->contact_person_id => $row->contact_person_firstname.' '.$row->contact_person_middlename.' '.$row->contact_person_lastname
                );
            }

            $array = array();
            foreach($arr as $arrs)
                foreach($arrs as $key => $val)
                    $array[$key] = $val;
            return $array;
        }        
    }   

    public function form_selected_jo_options($id)
    {   
        $this->db->select('*');
        $this->db->from($this->contact_personTable.' as con'); 
        $this->db->join('job_order_contact_person as job_con','con.contact_person_id = job_con.contact_person_id');
        $this->db->join('job_order as job','job_con.job_order_id = job.job_order_id');
        $this->db->where('job.job_order_no', $id);

        $query = $this->db->get();
        
        if($query->num_rows() > 0)
        {
            foreach ($query->result() as $row) {
                $id = $row->contact_person_id;
            }

            return $id;
        }
        else 
        {
            return $id = '0';
        }
    }

}