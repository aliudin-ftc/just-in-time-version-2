<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Branch_Model extends CI_Model {

    private $branchTable = 'branch';
    private $branchColumn = 'branch_id';

    public function __construct()
    {
        parent::__construct();
    }

    public function form_input_attributes($data, $id)
    {   
        if(isset($id) && !empty($id))
        {   
            $this->db->where($this->branchColumn, $id);
            $query = $this->db->get($this->branchTable);

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
            $this->db->where($this->branchColumn, $id);
            $query = $this->db->get($this->branchTable);

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
            $this->db->where($this->branchColumn, $id);
            $query = $this->db->get($this->branchTable);

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
        $query = $this->db->get($this->branchTable);
    
        $arr[] = array(
            '0' => 'select '.str_replace('_', ' ', $data).' here',
        );

        foreach ($query->result() as $row)
        {
            $arr[] = array(
                $row->branch_id => $row->branch_description
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
        $this->db->from($this->branchTable);  
        $this->db->where($this->branchColumn, $id);
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

    public function form_file($id)
    {   
        if(isset($id) && !empty($id))
        {
            $this->db->where($this->branchColumn, $id);
            $query = $this->db->get($this->branchTable);

            foreach ($query->result() as $row) {
                $id = $row->branch_logo;
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
        $this->db->from('branch as branch');
        $this->db->join('created as cre','branch.branch_id = cre.created_table_id');
        $this->db->where('cre.created_table','branch');    
        $this->db->where('branch.branch_id', $id);
        $query = $this->db->get();

        foreach ($query->result() as $row) {

            $arr[] = array(
                'branch_id' => $row->branch_id,
                'account_id' => $row->account_id,
                'branch_name' => $row->branch_name,
                'branch_description' => $row->branch_description
            );

        }

        return $arr;
    }

    public function insert($data)
    {
        $this->db->insert($this->branchTable, $data);
        return $this->db->insert_id();
    }

    public function modify($data, $id)
    {   
        $this->db->where($this->branchColumn, $id);
        $this->db->update($this->branchTable, $data);
        return true;
    }

    public function get_all_branch($start_from=0, $limit=0)
    {  
        $this->db->select('*');
        $this->db->from($this->branchTable.' as branch');
        $this->db->join('status as stat','branch.branch_id = stat.status_table_id');
        $this->db->where('stat.status_table', $this->branchTable);  
        $this->db->where('stat.status_code', 1);  
        $this->db->order_by('branch.'.$this->branchColumn, 'DESC');
        $query = $this->db->limit( $limit, $start_from )->get();
        return $query;
    }

    public function get_alls_branch()
    {   
        $this->db->select('*');
        $this->db->from($this->branchTable.' as branch');
        $this->db->join('status as stat','branch.branch_id = stat.status_table_id');
        $this->db->where('stat.status_table', $this->branchTable);  
        $this->db->where('stat.status_code', 1);
        $this->db->order_by('branch.'.$this->branchColumn, 'DESC');
        $query = $this->db->get();
        return $query;
    }

    public function like_branch($wildcard='', $start_from=0, $limit=0)
    {
        $this->db->select('*');
        $this->db->from($this->branchTable.' as bra');
        $this->db->join('status as stat','bra.branch_id = stat.status_table_id');
        $this->db->join('account as acc','bra.account_id = acc.account_id');
        $this->db->where('stat.status_table', $this->branchTable);  
        $this->db->where('stat.status_code', 1);  
        $this->db->group_start();
        $this->db->or_where('bra.branch_id LIKE', '%' . $wildcard . '%');
        $this->db->or_where('acc.account_name LIKE', '%' . $wildcard . '%');
        $this->db->or_where('bra.branch_name LIKE', '%' . $wildcard . '%');
        $this->db->or_where('bra.branch_description LIKE', '%' . $wildcard . '%');
        $this->db->group_end();
        $this->db->order_by('bra.'.$this->branchColumn, 'DESC');
        $query = $this->db->limit( $limit, $start_from )->get();
        return $query;   
    }

    public function likes_branch($wildcard='')
    {
        $this->db->select('*');
        $this->db->from($this->branchTable.' as bra');
        $this->db->join('status as stat','bra.branch_id = stat.status_table_id');
        $this->db->join('account as acc','bra.account_id = acc.account_id');
        $this->db->where('stat.status_table', $this->branchTable);  
        $this->db->where('stat.status_code', 1);  
        $this->db->group_start();
        $this->db->or_where('bra.branch_id LIKE', '%' . $wildcard . '%');
        $this->db->or_where('acc.account_name LIKE', '%' . $wildcard . '%');
        $this->db->or_where('bra.branch_name LIKE', '%' . $wildcard . '%');
        $this->db->or_where('bra.branch_description LIKE', '%' . $wildcard . '%');
        $this->db->group_end();
        $this->db->order_by('bra.'.$this->branchColumn, 'DESC');
        $query = $this->db->get();
        return $query; 
    }

    public function get_all_archived_branch($start_from=0, $limit=0)
    {  
        $this->db->select('*');
        $this->db->from($this->branchTable.' as cus');
        $this->db->join('status as stat','cus.branch_id = stat.status_table_id');
        $this->db->where('stat.status_table', $this->branchTable);  
        $this->db->where('stat.status_code', 0);  
        $this->db->order_by('cus.'.$this->branchColumn, 'DESC');
        $query = $this->db->limit( $limit, $start_from )->get();
        return $query;
    }

    public function get_alls_archived_branch()
    {   
        $this->db->select('*');
        $this->db->from($this->branchTable.' as cus');
        $this->db->join('status as stat','cus.branch_id = stat.status_table_id');
        $this->db->where('stat.status_table', $this->branchTable);  
        $this->db->where('stat.status_code', 0);
        $this->db->order_by('cus.'.$this->branchColumn, 'DESC');
        $query = $this->db->get();
        return $query;
    }

    public function like_archived_branch($wildcard='', $start_from=0, $limit=0)
    {
        $this->db->select('*');
        $this->db->from($this->branchTable.' as bra');
        $this->db->join('status as stat','bra.branch_id = stat.status_table_id');
        $this->db->join('account as acc','bra.account_id = acc.account_id');
        $this->db->where('stat.status_table', $this->branchTable);  
        $this->db->where('stat.status_code', 0);  
        $this->db->group_start();
        $this->db->or_where('bra.branch_id LIKE', '%' . $wildcard . '%');
        $this->db->or_where('acc.account_name LIKE', '%' . $wildcard . '%');
        $this->db->or_where('bra.branch_name LIKE', '%' . $wildcard . '%');
        $this->db->or_where('bra.branch_description LIKE', '%' . $wildcard . '%');
        $this->db->group_end();
        $this->db->order_by('bra.'.$this->branchColumn, 'DESC');
        $query = $this->db->limit( $limit, $start_from )->get();
        return $query; 
    }

    public function likes_archived_branch($wildcard='')
    {
        $this->db->select('*');
        $this->db->from($this->branchTable.' as bra');
        $this->db->join('status as stat','bra.branch_id = stat.status_table_id');
        $this->db->join('account as acc','bra.account_id = acc.account_id');
        $this->db->where('stat.status_table', $this->branchTable);  
        $this->db->where('stat.status_code', 0);  
        $this->db->group_start();
        $this->db->or_where('bra.branch_id LIKE', '%' . $wildcard . '%');
        $this->db->or_where('acc.account_name LIKE', '%' . $wildcard . '%');
        $this->db->or_where('bra.branch_name LIKE', '%' . $wildcard . '%');
        $this->db->or_where('bra.branch_description LIKE', '%' . $wildcard . '%');
        $this->db->group_end();
        $this->db->order_by('bra.'.$this->branchColumn, 'DESC');
        $query = $this->db->get();
        return $query; 
    }

    public function get_branch_by_account($id)
    {
        $this->db->where('account_id', $id);
        $query = $this->db->get($this->branchTable);

        foreach ($query->result() as $row)
        {
            $arr[] = array(
                'branch_id' => $row->branch_id,
                'branch_name' => $row->branch_name
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
            $this->db->join('branch as bra', 'acc.account_id = bra.account_id');
            $this->db->where('job.job_order_no', $id);
            $query = $this->db->get();

            $arr[] = array(
                '0' => 'select '.str_replace('_', ' ', $data).' here',
            );

            foreach ($query->result() as $row)
            {
                $arr[] = array(
                    $row->branch_id => $row->branch_name
                );
            }

            $array = array();
            foreach($arr as $arrs)
                foreach($arrs as $key => $val)
                    $array[$key] = $val;
            return $array;
        }
        else {
            $query = $this->db->get($this->branchTable);
    
            $arr[] = array(
                '0' => 'select '.str_replace('_', ' ', $data).' here',
            );

            foreach ($query->result() as $row)
            {
                $arr[] = array(
                    $row->branch_id => $row->branch_name
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
        $this->db->from($this->branchTable.' as bra'); 
        $this->db->join('job_order_branch as job_bra','bra.branch_id = job_bra.branch_id');
        $this->db->join('job_order as job','job_bra.job_order_id = job.job_order_id');
        $this->db->where('job.job_order_no', $id);

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
}