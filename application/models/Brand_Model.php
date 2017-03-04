<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Brand_Model extends CI_Model {

    private $brandTable = 'brand';
    private $brandColumn = 'brand_id';

    public function __construct()
    {
        parent::__construct();
    }

    public function form_input_attributes($data, $id)
    {   
        if(isset($id) && !empty($id))
        {   
            $this->db->where($this->brandColumn, $id);
            $query = $this->db->get($this->brandTable);

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
            $this->db->where($this->brandColumn, $id);
            $query = $this->db->get($this->brandTable);

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
            $this->db->where($this->brandColumn, $id);
            $query = $this->db->get($this->brandTable);

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
        $query = $this->db->get($this->brandTable);
    
        $arr[] = array(
            '0' => 'select '.str_replace('_', ' ', $data).' here',
        );

        foreach ($query->result() as $row)
        {
            $arr[] = array(
                $row->brand_id => $row->brand_description
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
        $this->db->from($this->brandTable);  
        $this->db->where($this->brandColumn, $id);
        $query = $this->db->get();
        
        if($query->num_rows() > 0)
        {
            foreach ($query->result() as $row) {
                $id = $row->brand_id;
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
            $this->db->where($this->brandColumn, $id);
            $query = $this->db->get($this->brandTable);

            foreach ($query->result() as $row) {
                $id = $row->brand_logo;
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
        $this->db->from('brand as brand');
        $this->db->join('created as cre','brand.brand_id = cre.created_table_id');
        $this->db->where('cre.created_table','brand');    
        $this->db->where('brand.brand_id', $id);
        $query = $this->db->get();

        foreach ($query->result() as $row) {

            $arr[] = array(
                'brand_id' => $row->brand_id,
                'customer_id' => $row->customer_id,
                'brand_name' => $row->brand_name,
                'brand_description' => $row->brand_description
            );

        }

        return $arr;
    }

    public function insert($data)
    {
        $this->db->insert($this->brandTable, $data);
        return $this->db->insert_id();
    }

    public function modify($data, $id)
    {   
        $this->db->where($this->brandColumn, $id);
        $this->db->update($this->brandTable, $data);
        return true;
    }

    public function get_all_brand($start_from=0, $limit=0)
    {  
        $this->db->select('*');
        $this->db->from($this->brandTable.' as brand');
        $this->db->join('status as stat','brand.brand_id = stat.status_table_id');
        $this->db->where('stat.status_table', $this->brandTable);  
        $this->db->where('stat.status_code', 1);  
        $this->db->order_by('brand.'.$this->brandColumn, 'DESC');
        $query = $this->db->limit( $limit, $start_from )->get();
        return $query;
    }

    public function get_alls_brand()
    {   
        $this->db->select('*');
        $this->db->from($this->brandTable.' as brand');
        $this->db->join('status as stat','brand.brand_id = stat.status_table_id');
        $this->db->where('stat.status_table', $this->brandTable);  
        $this->db->where('stat.status_code', 1);
        $this->db->order_by('brand.'.$this->brandColumn, 'DESC');
        $query = $this->db->get();
        return $query;
    }

    public function like_brand($wildcard='', $start_from=0, $limit=0)
    {
        $this->db->select('*');
        $this->db->from($this->brandTable.' as bra');
        $this->db->join('status as stat','bra.brand_id = stat.status_table_id');
        $this->db->join('customer as cus','bra.customer_id = cus.customer_id');
        $this->db->where('stat.status_table', $this->brandTable);  
        $this->db->where('stat.status_code', 1);  
        $this->db->group_start();
        $this->db->or_where('bra.brand_id LIKE', '%' . $wildcard . '%');
        $this->db->or_where('cus.customer_code LIKE', '%' . $wildcard . '%');
        $this->db->or_where('bra.brand_name LIKE', '%' . $wildcard . '%');
        $this->db->or_where('bra.brand_description LIKE', '%' . $wildcard . '%');
        $this->db->group_end();
        $this->db->order_by('bra.'.$this->brandColumn, 'DESC');
        $query = $this->db->limit( $limit, $start_from )->get();
        return $query;   
    }

    public function likes_brand($wildcard='')
    {
        $this->db->select('*');
        $this->db->from($this->brandTable.' as bra');
        $this->db->join('status as stat','bra.brand_id = stat.status_table_id');
        $this->db->join('customer as cus','bra.customer_id = cus.customer_id');
        $this->db->where('stat.status_table', $this->brandTable);  
        $this->db->where('stat.status_code', 1);  
        $this->db->group_start();
        $this->db->or_where('bra.brand_id LIKE', '%' . $wildcard . '%');
        $this->db->or_where('cus.customer_code LIKE', '%' . $wildcard . '%');
        $this->db->or_where('bra.brand_name LIKE', '%' . $wildcard . '%');
        $this->db->or_where('bra.brand_description LIKE', '%' . $wildcard . '%');
        $this->db->group_end();
        $this->db->order_by('bra.'.$this->brandColumn, 'DESC');
        $query = $this->db->get();
        return $query;   
    }

    public function get_all_archived_brand($start_from=0, $limit=0)
    {  
        $this->db->select('*');
        $this->db->from($this->brandTable.' as cus');
        $this->db->join('status as stat','cus.brand_id = stat.status_table_id');
        $this->db->where('stat.status_table', $this->brandTable);  
        $this->db->where('stat.status_code', 0);  
        $this->db->order_by('cus.'.$this->brandColumn, 'DESC');
        $query = $this->db->limit( $limit, $start_from )->get();
        return $query;
    }

    public function get_alls_archived_brand()
    {   
        $this->db->select('*');
        $this->db->from($this->brandTable.' as cus');
        $this->db->join('status as stat','cus.brand_id = stat.status_table_id');
        $this->db->where('stat.status_table', $this->brandTable);  
        $this->db->where('stat.status_code', 0);
        $this->db->order_by('cus.'.$this->brandColumn, 'DESC');
        $query = $this->db->get();
        return $query;
    }

    public function like_archived_brand($wildcard='', $start_from=0, $limit=0)
    {
        $this->db->select('*');
        $this->db->from($this->brandTable.' as bra');
        $this->db->join('status as stat','bra.brand_id = stat.status_table_id');
        $this->db->join('customer as cus','bra.customer_id = cus.customer_id');
        $this->db->where('stat.status_table', $this->brandTable);  
        $this->db->where('stat.status_code', 0);  
        $this->db->group_start();
        $this->db->or_where('bra.brand_id LIKE', '%' . $wildcard . '%');
        $this->db->or_where('cus.customer_code LIKE', '%' . $wildcard . '%');
        $this->db->or_where('bra.brand_name LIKE', '%' . $wildcard . '%');
        $this->db->or_where('bra.brand_description LIKE', '%' . $wildcard . '%');
        $this->db->group_end();
        $this->db->order_by('bra.'.$this->brandColumn, 'DESC');
        $query = $this->db->limit( $limit, $start_from )->get();
        return $query;   
    }

    public function likes_archived_brand($wildcard='')
    {
        $this->db->select('*');
        $this->db->from($this->brandTable.' as bra');
        $this->db->join('status as stat','bra.brand_id = stat.status_table_id');
        $this->db->join('customer as cus','bra.customer_id = cus.customer_id');
        $this->db->where('stat.status_table', $this->brandTable);  
        $this->db->where('stat.status_code', 0);  
        $this->db->group_start();
        $this->db->or_where('bra.brand_id LIKE', '%' . $wildcard . '%');
        $this->db->or_where('cus.customer_code LIKE', '%' . $wildcard . '%');
        $this->db->or_where('bra.brand_name LIKE', '%' . $wildcard . '%');
        $this->db->or_where('bra.brand_description LIKE', '%' . $wildcard . '%');
        $this->db->group_end();
        $this->db->order_by('bra.'.$this->brandColumn, 'DESC');
        $query = $this->db->get();
        return $query;
    }

    public function get_brand_by_customer($id)
    {
        $this->db->where('customer_id', $id);
        $query = $this->db->get($this->brandTable);

        foreach ($query->result() as $row)
        {
            $arr[] = array(
                'brand_id' => $row->brand_id,
                'brand_name' => $row->brand_name
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
            $this->db->join('brand as bra', 'cus.customer_id = bra.customer_id');
            $this->db->where('job.job_order_no', $id);
            $query = $this->db->get();

            $arr[] = array(
                '0' => 'select '.str_replace('_', ' ', $data).' here',
            );

            foreach ($query->result() as $row)
            {
                $arr[] = array(
                    $row->brand_id => $row->brand_description
                );
            }

            $array = array();
            foreach($arr as $arrs)
                foreach($arrs as $key => $val)
                    $array[$key] = $val;
            return $array;
        }
        else {
            $query = $this->db->get($this->brandTable);
    
            $arr[] = array(
                '0' => 'select '.str_replace('_', ' ', $data).' here',
            );

            foreach ($query->result() as $row)
            {
                $arr[] = array(
                    $row->brand_id => $row->brand_description
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
        $this->db->from($this->brandTable.' as bra'); 
        $this->db->join('job_order_brand as job_bra','bra.brand_id = job_bra.brand_id');
        $this->db->join('job_order as job','job_bra.job_order_id = job.job_order_id');
        $this->db->where('job.job_order_no', $id);

        $query = $this->db->get();
        
        if($query->num_rows() > 0)
        {
            foreach ($query->result() as $row) {
                $id = $row->brand_id;
            }

            return $id;
        }
        else 
        {
            return $id = '0';
        }
    } 
}