<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Account_Model extends CI_Model {

    private $accountTable = 'account';
    private $accountColumn = 'account_id';

    public function __construct()
    {
        parent::__construct();
    }

    public function form_input_attributes($data, $id)
    {   
        if(isset($id) && !empty($id))
        {   
            $this->db->where($this->accountColumn, $id);
            $query = $this->db->get($this->accountTable);

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
            $this->db->where($this->accountColumn, $id);
            $query = $this->db->get($this->accountTable);

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
            $this->db->where($this->accountColumn, $id);
            $query = $this->db->get($this->accountTable);

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
        $query = $this->db->get($this->accountTable);
    
        $arr[] = array(
            '0' => 'select '.str_replace('_', ' ', $data).' here',
        );

        foreach ($query->result() as $row)
        {
            $arr[] = array(
                $row->account_id => $row->account_description
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
        $this->db->from($this->accountTable);  
        $this->db->where($this->accountColumn, $id);
        $query = $this->db->get();
        
        if($query->num_rows() > 0)
        {
            foreach ($query->result() as $row) {
                $id = $row->account_id;
            }

            return $id;
        }
        else 
        {
            return $id = '0';
        }
    }         

    public function form_selected_branch_options($id)
    {   
        $this->db->select('*');
        $this->db->from($this->accountTable.' as acc');
        $this->db->join('branch as bra','acc.account_id = bra.account_id');
        $this->db->where('bra.branch_id', $id);
        $query = $this->db->get();
        
        if($query->num_rows() > 0)
        {
            foreach ($query->result() as $row) {
                $id = $row->account_id;
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
            $this->db->where($this->accountColumn, $id);
            $query = $this->db->get($this->accountTable);

            foreach ($query->result() as $row) {
                $id = $row->account_logo;
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
        $this->db->from('account as account');
        $this->db->join('created as cre','account.account_id = cre.created_table_id');
        $this->db->where('cre.created_table','account');    
        $this->db->where('account.account_id', $id);
        $query = $this->db->get();

        foreach ($query->result() as $row) {

            $arr[] = array(
                'account_id' => $row->account_id,
                'customer_id' => $row->customer_id,
                'account_name' => $row->account_name,
                'account_description' => $row->account_description
            );

        }

        return $arr;
    }

    public function insert($data)
    {
        $this->db->insert($this->accountTable, $data);
        return $this->db->insert_id();
    }

    public function modify($data, $id)
    {   
        $this->db->where($this->accountColumn, $id);
        $this->db->update($this->accountTable, $data);
        return true;
    }

    public function get_all_account($start_from=0, $limit=0)
    {  
        $this->db->select('*');
        $this->db->from($this->accountTable.' as account');
        $this->db->join('status as stat','account.account_id = stat.status_table_id');
        $this->db->where('stat.status_table', $this->accountTable);  
        $this->db->where('stat.status_code', 1);  
        $this->db->order_by('account.'.$this->accountColumn, 'DESC');
        $query = $this->db->limit( $limit, $start_from )->get();
        return $query;
    }

    public function get_alls_account()
    {   
        $this->db->select('*');
        $this->db->from($this->accountTable.' as account');
        $this->db->join('status as stat','account.account_id = stat.status_table_id');
        $this->db->where('stat.status_table', $this->accountTable);  
        $this->db->where('stat.status_code', 1);
        $this->db->order_by('account.'.$this->accountColumn, 'DESC');
        $query = $this->db->get();
        return $query;
    }

    public function like_account($wildcard='', $start_from=0, $limit=0)
    {
        $this->db->select('*');
        $this->db->from($this->accountTable.' as acc');
        $this->db->join('status as stat','acc.account_id = stat.status_table_id');
        $this->db->join('customer as cus','acc.customer_id = cus.customer_id');
        $this->db->where('stat.status_table', $this->accountTable);  
        $this->db->where('stat.status_code', 1);  
        $this->db->group_start();
        $this->db->or_where('acc.account_id LIKE', '%' . $wildcard . '%');
        $this->db->or_where('cus.customer_code LIKE', '%' . $wildcard . '%');
        $this->db->or_where('acc.account_name LIKE', '%' . $wildcard . '%');
        $this->db->or_where('acc.account_description LIKE', '%' . $wildcard . '%');
        $this->db->group_end();
        $this->db->order_by('acc.'.$this->accountColumn, 'DESC');
        $query = $this->db->limit( $limit, $start_from )->get();
        return $query;   
    }

    public function likes_account($wildcard='')
    {
        $this->db->select('*');
        $this->db->from($this->accountTable.' as acc');
        $this->db->join('status as stat','acc.account_id = stat.status_table_id');
        $this->db->join('customer as cus','acc.customer_id = cus.customer_id');
        $this->db->where('stat.status_table', $this->accountTable);  
        $this->db->where('stat.status_code', 1);  
        $this->db->group_start();
        $this->db->or_where('acc.account_id LIKE', '%' . $wildcard . '%');
        $this->db->or_where('cus.customer_code LIKE', '%' . $wildcard . '%');
        $this->db->or_where('acc.account_name LIKE', '%' . $wildcard . '%');
        $this->db->or_where('acc.account_description LIKE', '%' . $wildcard . '%');
        $this->db->group_end();
        $this->db->order_by('acc.'.$this->accountColumn, 'DESC');
        $query = $this->db->get();
        return $query;   
    }

    public function get_all_archived_account($start_from=0, $limit=0)
    {  
        $this->db->select('*');
        $this->db->from($this->accountTable.' as cus');
        $this->db->join('status as stat','cus.account_id = stat.status_table_id');
        $this->db->where('stat.status_table', $this->accountTable);  
        $this->db->where('stat.status_code', 0);  
        $this->db->order_by('cus.'.$this->accountColumn, 'DESC');
        $query = $this->db->limit( $limit, $start_from )->get();
        return $query;
    }

    public function get_alls_archived_account()
    {   
        $this->db->select('*');
        $this->db->from($this->accountTable.' as cus');
        $this->db->join('status as stat','cus.account_id = stat.status_table_id');
        $this->db->where('stat.status_table', $this->accountTable);  
        $this->db->where('stat.status_code', 0);
        $this->db->order_by('cus.'.$this->accountColumn, 'DESC');
        $query = $this->db->get();
        return $query;
    }

    public function like_archived_account($wildcard='', $start_from=0, $limit=0)
    {
        $this->db->select('*');
        $this->db->from($this->accountTable.' as acc');
        $this->db->join('status as stat','acc.account_id = stat.status_table_id');
        $this->db->join('customer as cus','acc.customer_id = cus.customer_id');
        $this->db->where('stat.status_table', $this->accountTable);  
        $this->db->where('stat.status_code', 0);  
        $this->db->group_start();
        $this->db->or_where('acc.account_id LIKE', '%' . $wildcard . '%');
        $this->db->or_where('cus.customer_code LIKE', '%' . $wildcard . '%');
        $this->db->or_where('acc.account_name LIKE', '%' . $wildcard . '%');
        $this->db->or_where('acc.account_description LIKE', '%' . $wildcard . '%');
        $this->db->group_end();
        $this->db->order_by('acc.'.$this->accountColumn, 'DESC');
        $query = $this->db->limit( $limit, $start_from )->get();
        return $query;   
    }

    public function likes_archived_account($wildcard='')
    {
        $this->db->select('*');
        $this->db->from($this->accountTable.' as acc');
        $this->db->join('status as stat','acc.account_id = stat.status_table_id');
        $this->db->join('customer as cus','acc.customer_id = cus.customer_id');
        $this->db->where('stat.status_table', $this->accountTable);  
        $this->db->where('stat.status_code', 0);  
        $this->db->group_start();
        $this->db->or_where('acc.account_id LIKE', '%' . $wildcard . '%');
        $this->db->or_where('cus.customer_code LIKE', '%' . $wildcard . '%');
        $this->db->or_where('acc.account_name LIKE', '%' . $wildcard . '%');
        $this->db->or_where('acc.account_description LIKE', '%' . $wildcard . '%');
        $this->db->group_end();
        $this->db->order_by('acc.'.$this->accountColumn, 'DESC');
        $query = $this->db->get();
        return $query;   
    }

    public function get_account_name_by_id($id)
    {   
        $this->db->where($this->accountColumn, $id);
        $query = $this->db->get($this->accountTable);

        foreach($query->result() as $row)
        {
            $id = $row->account_name;
        }

        return $id;
    }

    public function get_account_by_customer($id)
    {
        $this->db->where('customer_id', $id);
        $query = $this->db->get($this->accountTable);

        foreach ($query->result() as $row)
        {
            $arr[] = array(
                'account_id' => $row->account_id,
                'account_name' => $row->account_name
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
            $this->db->join('account as acc', 'cus.customer_id = acc.customer_id');
            $this->db->where('job.job_order_no', $id);
            $query = $this->db->get();

            $arr[] = array(
                '0' => 'select '.str_replace('_', ' ', $data).' here',
            );

            foreach ($query->result() as $row)
            {
                $arr[] = array(
                    $row->account_id => $row->account_name
                );
            }

            $array = array();
            foreach($arr as $arrs)
                foreach($arrs as $key => $val)
                    $array[$key] = $val;
            return $array;
        }
        else {
            $query = $this->db->get($this->accountTable);
    
            $arr[] = array(
                '0' => 'select '.str_replace('_', ' ', $data).' here',
            );

            foreach ($query->result() as $row)
            {
                $arr[] = array(
                    $row->account_id => $row->account_name
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
        $this->db->from($this->accountTable.' as acc'); 
        $this->db->join('job_order_account as job_acc','acc.account_id = job_acc.account_id');
        $this->db->join('job_order as job','job_acc.job_order_id = job.job_order_id');
        $this->db->where('job.job_order_no', $id);

        $query = $this->db->get();
        
        if($query->num_rows() > 0)
        {
            foreach ($query->result() as $row) {
                $id = $row->account_id;
            }

            return $id;
        }
        else 
        {
            return $id = '0';
        }
    }
}