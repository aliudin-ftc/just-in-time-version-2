<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Address_Model extends CI_Model {

    private $addressTable = 'address';
    private $addressColumn = 'address_id';

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

    public function form_input_disabled_attributes($data)
    {
        $attributes = array(
            'name'          => $data,
            'id'            => $data,
            'type'          => 'text',
            'disabled'      => 'disabled',
            'class'         => 'form-control input-md',
            'placeholder'   => 'insert '.str_replace('_', ' ', $data).' here'
        );

        return $attributes;
    }

    public function form_input_date_attributes($data)
    {
        $attributes = array(
            'name'          => $data,
            'id'            => $data,
            'type'          => 'text',
            'class'         => 'form-control date-picker',
            'placeholder'   => 'select '.str_replace('_', ' ', $data).' here'
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

    public function form_select_options($data)
    {   
        $query = $this->db->get($this->addressTable);
        
        $arr[] = array(
            '0' => 'select '.str_replace('_', ' ', $data).' here',
        );

        foreach ($query->result() as $row)
        {
            $arr[] = array(
                $row->address_id => $row->address_description
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
        $this->db->from($this->addressTable.' as bus');
        $this->db->join('customer as cus','bus.address_id = cus.address_id');    
        $this->db->where('cus.customer_id',$id);
        $query = $this->db->get();
        
        if($query->num_rows() > 0)
        {
            foreach ($query->result() as $row) {
                $id = $row->address_id;
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
            $this->db->from($this->addressTable.' as con_per');
            $this->db->join('customer as cus','con_per.customer_id = cus.customer_id');    
            $this->db->where('cus.customer_id',$id);
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

    public function form_input_numeric_customer_attributes($data, $id)
    {   
        if(isset($id) && !empty($id))
        {   
            $this->db->select('*');
            $this->db->from('address');
            $this->db->where('address_table', 'customer');
            $this->db->where('address_table_id', $id);
            $query = $this->db->get();

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
                'class'         => 'form-control input-md',
                'placeholder'   => 'insert '.str_replace('_', ' ', $data).' here'
            );
        }

        return $attributes;
    }   

    public function insert($data)
    {
        $this->db->insert($this->addressTable, $data);
        return $this->db->insert_id();
    }

    public function modify($data, $id)
    {   
        $this->db->where($this->addressColumn, $id);
        $this->db->update($this->addressTable, $data);
        return true;
    }

    public function get_all_resources_address($start_from=0, $limit=0, $resources_id)
    {  
        $this->db->select('*');
        $this->db->from($this->addressTable. ' as add');
        $this->db->join('status as stat','add.address_id = stat.status_table_id');
        $this->db->where('stat.status_table', $this->addressTable);  
        $this->db->where('stat.status_code', 1);
        $this->db->where('add.address_table', 'resources');
        $this->db->where('add.address_table_id', $resources_id);  
        $this->db->order_by('add.'.$this->addressColumn, 'DESC');
        $query = $this->db->limit( $limit, $start_from )->get();
        return $query;
    }

    public function get_alls_resources_address($resources_id)
    {   
        $this->db->select('*');
        $this->db->from($this->addressTable. ' as add');
        $this->db->join('status as stat','add.address_id = stat.status_table_id');
        $this->db->where('stat.status_table', $this->addressTable);  
        $this->db->where('stat.status_code', 1);
        $this->db->where('add.address_table', 'resources');
        $this->db->where('add.address_table_id', $resources_id);  
        $this->db->order_by('add.'.$this->addressColumn, 'DESC');
        $query = $this->db->get();
        return $query;
    }

    public function like_resources_address($wildcard, $start_from=0, $limit=0, $resources_id)
    {  
        $this->db->select('*');
        $this->db->from($this->addressTable. ' as add');
        $this->db->join('status as stat','add.address_id = stat.status_table_id');
        $this->db->join('province as prov','add.address_province = prov.province_id');
        $this->db->join('city as city','add.address_city = city.city_id');
        $this->db->join('barangay as brgy','add.address_barangay = brgy.barangay_id');
        $this->db->where('stat.status_table', $this->addressTable);  
        $this->db->where('stat.status_code', 1);
        $this->db->where('add.address_table', 'resources');
        $this->db->where('add.address_table_id', $resources_id); 
        $this->db->group_start();
        $this->db->or_where('add.address_id LIKE', $wildcard . '%');
        $this->db->or_where('add.address_street LIKE', $wildcard . '%');
        $this->db->or_where('brgy.barangay_name LIKE', $wildcard . '%');
        $this->db->or_where('prov.province_name LIKE', $wildcard . '%');
        $this->db->or_where('city.city_name LIKE', $wildcard . '%');
        $this->db->group_end();
        $this->db->order_by('add.'.$this->addressColumn, 'DESC');
        $query = $this->db->limit( $limit, $start_from )->get();
        return $query;
    }

    public function likes_resources_address($wildcard, $resources_id)
    {   
        $this->db->select('*');
        $this->db->from($this->addressTable. ' as add');
        $this->db->join('status as stat','add.address_id = stat.status_table_id');
        $this->db->join('province as prov','add.address_province = prov.province_id');
        $this->db->join('city as city','add.address_city = city.city_id');
        $this->db->join('barangay as brgy','add.address_barangay = brgy.barangay_id');
        $this->db->where('stat.status_table', $this->addressTable);  
        $this->db->where('stat.status_code', 1);
        $this->db->where('add.address_table', 'resources');
        $this->db->where('add.address_table_id', $resources_id); 
        $this->db->group_start();
        $this->db->or_where('add.address_id LIKE', $wildcard . '%');
        $this->db->or_where('add.address_street LIKE', $wildcard . '%');
        $this->db->or_where('brgy.barangay_name LIKE', $wildcard . '%');
        $this->db->or_where('prov.province_name LIKE', $wildcard . '%');
        $this->db->or_where('city.city_name LIKE', $wildcard . '%');
        $this->db->group_end();
        $this->db->order_by('add.'.$this->addressColumn, 'DESC');
        $query = $this->db->get();
        return $query;
    }

    public function get_city_by_province($id)
    {   
        $this->db->where('province_id', $id);
        $query = $this->db->get('city');
        
        foreach ($query->result() as $row)
        {
            $arr[] = array(
                'city_id' => $row->city_id,
                'city_name' => $row->city_name
            );       
        }
        
        return $arr;  
    }

    public function get_barangay_by_city($id)
    {   
        $this->db->where('city_id', $id);
        $query = $this->db->get('barangay');
        
        foreach ($query->result() as $row)
        {
            $arr[] = array(
                'barangay_id' => $row->barangay_id,
                'barangay_name' => $row->barangay_name
            );       
        }
        
        return $arr;  
    }


    public function form_input_resources_attributes($data)
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

    public function form_input_disabled_resources_attributes($data)
    {
        $attributes = array(
            'name'          => $data,
            'id'            => $data,
            'type'          => 'text',
            'disabled'      => 'disabled',
            'class'         => 'form-control input-md',
            'placeholder'   => 'insert '.str_replace('_', ' ', $data).' here'
        );

        return $attributes;
    }

    public function find($id)
    {
        $query = $this->db->where($this->addressColumn, $id)->get($this->addressTable);
        
        foreach($query->result() as $row)
        {
            $arr[] = array(
                'block' => $row->address_block_no,
                'street' => $row->address_street,
                'province_id' => $row->address_province,
                'city_id' => $row->address_city,
                'barangay_id' => $row->address_barangay,
                'region' => $row->address_region,
                'address_table' => $row->address_table,
                'address_table_id' => $row->address_table_id
            );
        }

        return $arr;
    }
}