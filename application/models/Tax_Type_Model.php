<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Tax_Type_Model extends CI_Model {

    private $tax_typeTable = 'tax_type';
    private $tax_typeColumn = 'tax_type_id';

    public function __construct()
    {
        parent::__construct();
    }

    public function form_input_attributes($data, $id)
    {   
        if(isset($id) && !empty($id))
        {   
            $this->db->where($this->tax_typeColumn, $id);
            $query = $this->db->get($this->tax_typeTable);

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
            $this->db->where($this->tax_typeColumn, $id);
            $query = $this->db->get($this->tax_typeTable);

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
            $this->db->where($this->tax_typeColumn, $id);
            $query = $this->db->get($this->tax_typeTable);

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
        $query = $this->db->get($this->tax_typeTable);
    
        $arr[] = array(
            '0' => 'select '.str_replace('_', ' ', $data).' here',
        );
        foreach ($query->result() as $row)
        {
            $arr[] = array(
                $row->tax_type_id => $row->tax_type_description
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
        $this->db->from($this->tax_typeTable);  
        $this->db->where($this->tax_typeColumn, $id);
        $query = $this->db->get();
        
        if($query->num_rows() > 0)
        {
            foreach ($query->result() as $row) {
                $id = $row->tax_type_id;
            }

            return $id;
        }
        else 
        {
            return $id = '0';
        }
    } 

    public function form_selected_customer_options($id)
    {   
        $this->db->select('*');
        $this->db->from($this->tax_typeTable.' as tax');
        $this->db->join('customer as cus','tax.tax_type_id = cus.tax_type_id');    
        $this->db->where('cus.customer_id',$id);
        $query = $this->db->get();
        
        if($query->num_rows() > 0)
        {
            foreach ($query->result() as $row) {
                $id = $row->tax_type_id;
            }

            return $id;
        }
        else 
        {
            return $id = '0';
        }
    }
    
    public function find($id)
    {   
        $this->db->select('*');
        $this->db->from('tax_type as dep');
        $this->db->join('created as cre','dep.tax_type_id = cre.created_table_id');
        $this->db->where('cre.created_table','tax_type');    
        $this->db->where('dep.tax_type_id', $id);
        $query = $this->db->get();

        foreach ($query->result() as $row) {

            $arr[] = array(
                'tax_type_id' => $row->tax_type_id,
                'tax_type_code' => $row->tax_type_code,
                'derpartment_name' => $row->tax_type_name,
                'tax_type_description' => $row->tax_type_description
            );

        }

        return $arr;
    }

    public function insert($data)
    {
        $this->db->insert($this->tax_typeTable, $data);
        return $this->db->insert_id();
    }

    public function modify($data, $id)
    {   
        $this->db->where($this->tax_typeColumn, $id);
        $this->db->update($this->tax_typeTable, $data);
        return true;
    }

    public function get_all_tax_type($start_from=0, $limit=0)
    {  
        $this->db->select('*');
        $this->db->from($this->tax_typeTable.' as dep');
        $this->db->join('status as stat','dep.tax_type_id = stat.status_table_id');
        $this->db->where('stat.status_table', $this->tax_typeTable);  
        $this->db->where('stat.status_code', 1);  
        $this->db->order_by('dep.'.$this->tax_typeColumn, 'DESC');
        $query = $this->db->limit( $limit, $start_from )->get();
        return $query;
    }

    public function get_alls_tax_type()
    {   
        $this->db->select('*');
        $this->db->from($this->tax_typeTable.' as dep');
        $this->db->join('status as stat','dep.tax_type_id = stat.status_table_id');
        $this->db->where('stat.status_table', $this->tax_typeTable);  
        $this->db->where('stat.status_code', 1);
        $this->db->order_by('dep.'.$this->tax_typeColumn, 'DESC');
        $query = $this->db->get();
        return $query;
    }

    public function like_tax_type($wildcard='', $start_from=0, $limit=0)
    {
        $this->db->select('*');
        $this->db->from($this->tax_typeTable.' as tax');
        $this->db->join('status as stat','tax.tax_type_id = stat.status_table_id');
        $this->db->where('stat.status_table', $this->tax_typeTable);  
        $this->db->where('stat.status_code', 1);  
        $this->db->group_start();
        $this->db->or_where('tax.tax_type_id LIKE', '%' . $wildcard . '%');
        $this->db->or_where('tax.tax_type_code LIKE', '%' . $wildcard . '%');
        $this->db->or_where('tax.tax_type_name LIKE', '%' . $wildcard . '%');
        $this->db->or_where('tax.tax_type_description LIKE', '%' . $wildcard . '%');
        $this->db->group_end();
        $this->db->order_by('tax.'.$this->tax_typeColumn, 'DESC');
        $query = $this->db->limit( $limit, $start_from )->get();
        return $query;  
    }

    public function likes_tax_type($wildcard='')
    {
        $this->db->select('*');
        $this->db->from($this->tax_typeTable.' as tax');
        $this->db->join('status as stat','tax.tax_type_id = stat.status_table_id');
        $this->db->where('stat.status_table', $this->tax_typeTable);  
        $this->db->where('stat.status_code', 1);  
        $this->db->group_start();
        $this->db->or_where('tax.tax_type_id LIKE', '%' . $wildcard . '%');
        $this->db->or_where('tax.tax_type_code LIKE', '%' . $wildcard . '%');
        $this->db->or_where('tax.tax_type_name LIKE', '%' . $wildcard . '%');
        $this->db->or_where('tax.tax_type_description LIKE', '%' . $wildcard . '%');
        $this->db->group_end();
        $this->db->order_by('tax.'.$this->tax_typeColumn, 'DESC');
        $query = $this->db->get();
        return $query;   
    }

    public function get_all_archived_tax_type($start_from=0, $limit=0)
    {  
        $this->db->select('*');
        $this->db->from($this->tax_typeTable.' as dep');
        $this->db->join('status as stat','dep.tax_type_id = stat.status_table_id');
        $this->db->where('stat.status_table', $this->tax_typeTable);  
        $this->db->where('stat.status_code', 0);  
        $this->db->order_by('dep.'.$this->tax_typeColumn, 'DESC');
        $query = $this->db->limit( $limit, $start_from )->get();
        return $query;
    }

    public function get_alls_archived_tax_type()
    {   
        $this->db->select('*');
        $this->db->from($this->tax_typeTable.' as dep');
        $this->db->join('status as stat','dep.tax_type_id = stat.status_table_id');
        $this->db->where('stat.status_table', $this->tax_typeTable);  
        $this->db->where('stat.status_code', 0);
        $this->db->order_by('dep.'.$this->tax_typeColumn, 'DESC');
        $query = $this->db->get();
        return $query;
    }

    public function like_archived_tax_type($wildcard='', $start_from=0, $limit=0)
    {
        $this->db->select('*');
        $this->db->from($this->tax_typeTable.' as tax');
        $this->db->join('status as stat','tax.tax_type_id = stat.status_table_id');
        $this->db->where('stat.status_table', $this->tax_typeTable);  
        $this->db->where('stat.status_code', 0);  
        $this->db->group_start();
        $this->db->or_where('tax.tax_type_id LIKE', '%' . $wildcard . '%');
        $this->db->or_where('tax.tax_type_code LIKE', '%' . $wildcard . '%');
        $this->db->or_where('tax.tax_type_name LIKE', '%' . $wildcard . '%');
        $this->db->or_where('tax.tax_type_description LIKE', '%' . $wildcard . '%');
        $this->db->group_end();
        $this->db->order_by('tax.'.$this->tax_typeColumn, 'DESC');
        $query = $this->db->limit( $limit, $start_from )->get();
        return $query;   
    }

    public function likes_archived_tax_type($wildcard='')
    {
        $this->db->select('*');
        $this->db->from($this->tax_typeTable.' as tax');
        $this->db->join('status as stat','tax.tax_type_id = stat.status_table_id');
        $this->db->where('stat.status_table', $this->tax_typeTable);  
        $this->db->where('stat.status_code', 0);  
        $this->db->group_start();
        $this->db->or_where('tax.tax_type_id LIKE', '%' . $wildcard . '%');
        $this->db->or_where('tax.tax_type_code LIKE', '%' . $wildcard . '%');
        $this->db->or_where('tax.tax_type_name LIKE', '%' . $wildcard . '%');
        $this->db->or_where('tax.tax_type_description LIKE', '%' . $wildcard . '%');
        $this->db->group_end();
        $this->db->order_by('tax.'.$this->tax_typeColumn, 'DESC');
        $query = $this->db->get();
        return $query;
    }

    public function get_tax_type_name_by_id($id)
    {   
        $this->db->where($this->tax_typeColumn, $id);
        $query = $this->db->get($this->tax_typeTable);

        foreach($query->result() as $row)
        {
            $id = $row->tax_type_name;
        }

        return $id;
    }        
}