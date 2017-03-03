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
                $row->customer_id => $row->customer_description
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
        $this->db->from($this->customerTable);  
        $this->db->where($this->customerColumn, $id);
        $query = $this->db->get();
        
        if($query->num_rows() > 0)
        {
            foreach ($query->result() as $row) {
                $id = $row->customer_id;
            }

            return $id;
        }
        else 
        {
            return $id = '0';
        }
    }  

    public function form_selected_brand_options($id)
    {   
        $this->db->select('*');
        $this->db->from($this->customerTable.' as cus');
        $this->db->join('brand as bra','cus.customer_id = bra.customer_id');
        $this->db->where('bra.brand_id', $id);
        $query = $this->db->get();
        
        if($query->num_rows() > 0)
        {
            foreach ($query->result() as $row) {
                $id = $row->customer_id;
            }

            return $id;
        }
        else 
        {
            return $id = '0';
        }
    }  

    public function form_selected_contact_person_options($id)
    {   
        $this->db->select('*');
        $this->db->from($this->customerTable.' as cus');
        $this->db->join('contact_person as con','cus.customer_id = con.customer_id');
        $this->db->where('con.contact_person_id', $id);
        $query = $this->db->get();
        
        if($query->num_rows() > 0)
        {
            foreach ($query->result() as $row) {
                $id = $row->customer_id;
            }

            return $id;
        }
        else 
        {
            return $id = '0';
        }
    }

    public function form_selected_account_options($id)
    {   
        $this->db->select('*');
        $this->db->from($this->customerTable.' as cus');
        $this->db->join('account as acc','cus.customer_id = acc.customer_id');
        $this->db->where('acc.account_id', $id);
        $query = $this->db->get();
        
        if($query->num_rows() > 0)
        {
            foreach ($query->result() as $row) {
                $id = $row->customer_id;
            }

            return $id;
        }
        else 
        {
            return $id = '0';
        }
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
        $this->db->select('*');
        $this->db->from($this->customerTable.' as cus');
        $this->db->join('status as stat','cus.customer_id = stat.status_table_id');
        $this->db->join('business_unit as bus','cus.business_unit_id = bus.business_unit_id');
        $this->db->join('resources as res','cus.resources_id = res.resources_id');
        $this->db->join('resources_level as res_lvl','res.resources_id = res_lvl.resources_id');
        $this->db->join('level as lvl','res_lvl.level_id = lvl.level_id');
        $this->db->where('lvl.level_name','Account Executive');
        $this->db->where('stat.status_table', $this->customerTable);  
        $this->db->where('stat.status_code', 1);  
        $this->db->group_start();
        $this->db->or_where('cus.customer_id LIKE', '%' . $wildcard . '%');
        $this->db->or_where('cus.customer_name LIKE', '%' . $wildcard . '%');
        $this->db->or_where('bus.business_unit_code LIKE', '%' . $wildcard . '%');
        $this->db->or_where('res.resources_firstname LIKE', '%' . $wildcard . '%');
        $this->db->or_where('res.resources_lastname LIKE', '%' . $wildcard . '%');
        $this->db->or_where('cus.customer_credit_limit LIKE', '%' . $wildcard . '%');
        $this->db->group_end();
        $this->db->order_by('cus.'.$this->customerColumn, 'DESC');
        $query = $this->db->limit( $limit, $start_from )->get();
        return $query;
    }

    public function likes_customer($wildcard='')
    {
        $this->db->select('*');
        $this->db->from($this->customerTable.' as cus');
        $this->db->join('status as stat','cus.customer_id = stat.status_table_id');
        $this->db->join('business_unit as bus','cus.business_unit_id = bus.business_unit_id');
        $this->db->join('resources as res','cus.resources_id = res.resources_id');
        $this->db->join('resources_level as res_lvl','res.resources_id = res_lvl.resources_id');
        $this->db->join('level as lvl','res_lvl.level_id = lvl.level_id');
        $this->db->where('lvl.level_name','Account Executive');
        $this->db->where('stat.status_table', $this->customerTable);  
        $this->db->where('stat.status_code', 1);  
        $this->db->group_start();
        $this->db->or_where('cus.customer_id LIKE', '%' . $wildcard . '%');
        $this->db->or_where('cus.customer_name LIKE', '%' . $wildcard . '%');
        $this->db->or_where('bus.business_unit_code LIKE', '%' . $wildcard . '%');
        $this->db->or_where('res.resources_firstname LIKE', '%' . $wildcard . '%');
        $this->db->or_where('res.resources_lastname LIKE', '%' . $wildcard . '%');
        $this->db->or_where('cus.customer_credit_limit LIKE', '%' . $wildcard . '%');
        $this->db->group_end();
        $this->db->order_by('cus.'.$this->customerColumn, 'DESC');
        $query = $this->db->get();
        return $query;
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
        $this->db->select('*');
        $this->db->from($this->customerTable.' as cus');
        $this->db->join('status as stat','cus.customer_id = stat.status_table_id');
        $this->db->join('business_unit as bus','cus.business_unit_id = bus.business_unit_id');
        $this->db->join('resources as res','cus.resources_id = res.resources_id');
        $this->db->join('resources_level as res_lvl','res.resources_id = res_lvl.resources_id');
        $this->db->join('level as lvl','res_lvl.level_id = lvl.level_id');
        $this->db->where('lvl.level_name','Account Executive');
        $this->db->where('stat.status_table', $this->customerTable);  
        $this->db->where('stat.status_code', 0);  
        $this->db->group_start();
        $this->db->or_where('cus.customer_id LIKE', '%' . $wildcard . '%');
        $this->db->or_where('cus.customer_name LIKE', '%' . $wildcard . '%');
        $this->db->or_where('bus.business_unit_code LIKE', '%' . $wildcard . '%');
        $this->db->or_where('res.resources_firstname LIKE', '%' . $wildcard . '%');
        $this->db->or_where('res.resources_lastname LIKE', '%' . $wildcard . '%');
        $this->db->or_where('cus.customer_credit_limit LIKE', '%' . $wildcard . '%');
        $this->db->group_end();
        $this->db->order_by('cus.'.$this->customerColumn, 'DESC');
        $query = $this->db->limit( $limit, $start_from )->get();
        return $query;
    }

    public function likes_archived_customer($wildcard='')
    {
        $this->db->select('*');
        $this->db->from($this->customerTable.' as cus');
        $this->db->join('status as stat','cus.customer_id = stat.status_table_id');
        $this->db->join('business_unit as bus','cus.business_unit_id = bus.business_unit_id');
        $this->db->join('resources as res','cus.resources_id = res.resources_id');
        $this->db->join('resources_level as res_lvl','res.resources_id = res_lvl.resources_id');
        $this->db->join('level as lvl','res_lvl.level_id = lvl.level_id');
        $this->db->where('lvl.level_name','Account Executive');
        $this->db->where('stat.status_table', $this->customerTable);  
        $this->db->where('stat.status_code', 0);  
        $this->db->group_start();
        $this->db->or_where('cus.customer_id LIKE', '%' . $wildcard . '%');
        $this->db->or_where('cus.customer_name LIKE', '%' . $wildcard . '%');
        $this->db->or_where('bus.business_unit_code LIKE', '%' . $wildcard . '%');
        $this->db->or_where('res.resources_firstname LIKE', '%' . $wildcard . '%');
        $this->db->or_where('res.resources_lastname LIKE', '%' . $wildcard . '%');
        $this->db->or_where('cus.customer_credit_limit LIKE', '%' . $wildcard . '%');
        $this->db->group_end();
        $this->db->order_by('cus.'.$this->customerColumn, 'DESC');
        $query = $this->db->get();
        return $query;
    }

    public function get_customer_name_by_id($id)
    {   
        $this->db->where($this->customerColumn, $id);
        $query = $this->db->get($this->customerTable);

        foreach($query->result() as $row)
        {
            $id = $row->customer_name;
        }

        return $id;
    }

    public function get_account_executive_name_by_customer_id($id)
    {
        $this->db->select('*');
        $this->db->from('customer as cus');
        $this->db->join('resources as res','cus.resources_id = res.resources_id');
        $this->db->where('cus.customer_id', $id);
        $query = $this->db->get();

        foreach ($query->result() as $row) {
            $id = $row->resources_firstname.' '.$row->resources_middlename.' '.$row->resources_lastname;
        }

        return $id;
    }

    public function get_customer_values_by_id($id)
    {   
        $this->db->select('*');
        $this->db->from('customer as cus');
        $this->db->join('contact_person as con','cus.customer_id = con.customer_id');
        $this->db->where('cus.customer_id', $id);
        $query = $this->db->get();

        foreach($query->result() as $row)
        {
            $arr = array(
                'business_unit' => $row->business_unit_id,
                'account_executive' => $row->resources_id,
                'contact_person' => $row->contact_person_firstname.' '.$row->contact_person_middlename.'. '.$row->contact_person_lastname
            );
        }

        return $arr;
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
        $query = $this->db->get($this->customerTable);
    
        $arr[] = array(
            '0' => 'select '.str_replace('_', ' ', $data).' here',
        );
        foreach ($query->result() as $row)
        {
            $arr[] = array(
                $row->customer_id => $row->customer_description
            );
        }
        
        $array = array();
        foreach($arr as $arrs)
            foreach($arrs as $key => $val)
                $array[$key] = $val;
        return $array;
    }        

    public function form_selected_jo_cus_options($id)
    {   
        $job_id = $this->Job_Order_Model->find_job_id_by_job_no($id);
        
        $this->db->select('*');
        $this->db->from($this->customerTable.' as cus');
        $this->db->join('job_order as job','cus.customer_id = job.customer_id');    
        $this->db->where('job.job_order_id',$job_id);
        $query = $this->db->get();
        
        if($query->num_rows() > 0)
        {
            foreach ($query->result() as $row) {
                $id = $row->customer_id;
            }

            return $id;
        }
        else 
        {
            return $id = '0';
        }
    }
    
    public function form_selected_jo_options($id)
    {   
        return $id = '0';
    }
}