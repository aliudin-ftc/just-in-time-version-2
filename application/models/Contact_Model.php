<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Contact_Model extends CI_Model {

    private $contactTable = 'contact';
    private $contactColumn = 'contact_id';

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
        $query = $this->db->get($this->contactTable);
        
        $arr[] = array(
            '0' => 'select '.str_replace('_', ' ', $data).' here',
        );

        foreach ($query->result() as $row)
        {
            $arr[] = array(
                $row->contact_id => $row->contact_description
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
        $this->db->from($this->contactTable.' as bus');
        $this->db->join('customer as cus','bus.contact_id = cus.contact_id');    
        $this->db->where('cus.customer_id',$id);
        $query = $this->db->get();
        
        if($query->num_rows() > 0)
        {
            foreach ($query->result() as $row) {
                $id = $row->contact_id;
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
        $query = $this->db->get($this->contactTable);
        
        $arr[] = array(
            '0' => 'select '.str_replace('_', ' ', $data).' here',
            'Male' => 'Female',
            'Female' => 'Male',
        );

        foreach ($query->result() as $row)
        {
            $arr[] = array(
                $row->$row->contact_gender => $row->contact_gender
            );
        }

        return call_user_func_array('array_merge', $arr);
    }

    public function form_selected_gender_options($id)
    {   
        $this->db->select('*');
        $this->db->from($this->contactTable.' as con_per');
        $this->db->join('customer as cus','con_per.customer_id = cus.customer_id');    
        $this->db->where('cus.customer_id',$id);
        $query = $this->db->get();
        
        if($query->num_rows() > 0)
        {
            foreach ($query->result() as $row) {
                $id = $row->contact_gender;
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
            $this->db->from($this->contactTable.' as con_per');
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
            $this->db->from('contact');
            $this->db->where('contact_table', 'customer');
            $this->db->where('contact_table_id', $id);
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
        $this->db->insert($this->contactTable, $data);
        return $this->db->insert_id();
    }

    public function modify($data, $id)
    {   
        $this->db->where($this->contactColumn, $id);
        $this->db->update($this->contactTable, $data);
        return true;
    }

    public function get_all_resources_contact($start_from=0, $limit=0, $resources_id)
    {  
        $this->db->select('*');
        $this->db->from($this->contactTable. ' as con');
        $this->db->join('status as stat','con.contact_id = stat.status_table_id');
        $this->db->where('stat.status_table', $this->contactTable);  
        $this->db->where('stat.status_code', 1);
        $this->db->where('con.contact_table', 'resources');
        $this->db->where('con.contact_table_id', $resources_id);  
        $this->db->order_by('con.'.$this->contactColumn, 'DESC');
        $query = $this->db->limit( $limit, $start_from )->get();
        return $query;
    }

    public function get_alls_resources_contact($resources_id)
    {   
        $this->db->select('*');
        $this->db->from($this->contactTable. ' as con');
        $this->db->join('status as stat','con.contact_id = stat.status_table_id');
        $this->db->where('stat.status_table', $this->contactTable);  
        $this->db->where('stat.status_code', 1);
        $this->db->where('con.contact_table', 'resources');
        $this->db->where('con.contact_table_id', $resources_id);  
        $this->db->order_by('con.'.$this->contactColumn, 'DESC');
        $query = $this->db->get();
        return $query;
    }

    public function like_resources_contact($wildcard, $start_from=0, $limit=0, $resources_id)
    {  
        $this->db->select('*');
        $this->db->from($this->contactTable. ' as con');
        $this->db->join('status as stat','con.contact_id = stat.status_table_id');
        $this->db->where('stat.status_table', $this->contactTable);  
        $this->db->where('stat.status_code', 1);
        $this->db->where('con.contact_table', 'resources');
        $this->db->where('con.contact_table_id', $resources_id); 
        $this->db->group_start();
        $this->db->or_where('con.contact_id LIKE', $wildcard . '%');
        $this->db->or_where('con.contact_phone_number LIKE', $wildcard . '%');
        $this->db->or_where('con.contact_mobile_number LIKE', $wildcard . '%');
        $this->db->or_where('con.contact_fax_number LIKE', $wildcard . '%');
        $this->db->group_end();
        $this->db->order_by('con.'.$this->contactColumn, 'DESC');
        $query = $this->db->limit( $limit, $start_from )->get();
        return $query;
    }

    public function likes_resources_contact($wildcard, $resources_id)
    {   
        $this->db->select('*');
        $this->db->from($this->contactTable. ' as con');
        $this->db->join('status as stat','con.contact_id = stat.status_table_id');
        $this->db->where('stat.status_table', $this->contactTable);  
        $this->db->where('stat.status_code', 1);
        $this->db->where('con.contact_table', 'resources');
        $this->db->where('con.contact_table_id', $resources_id); 
        $this->db->group_start();
        $this->db->or_where('con.contact_id LIKE', $wildcard . '%');
        $this->db->or_where('con.contact_phone_number LIKE', $wildcard . '%');
        $this->db->or_where('con.contact_mobile_number LIKE', $wildcard . '%');
        $this->db->or_where('con.contact_fax_number LIKE', $wildcard . '%');
        $this->db->group_end();
        $this->db->order_by('con.'.$this->contactColumn, 'DESC');
        $query = $this->db->get();
        return $query;
    }

    public function form_input_numeric_resources_attributes($data, $id)
    { 
        $data_split = explode('_', $data);
        $attributes = array(
            'name'          => $data_split[1].'_'.$data_split[2],
            'id'            => $data_split[1].'_'.$data_split[2],
            'type'          => 'text',
            'class'         => 'form-control input-md numeric',
            'placeholder'   => 'insert '.str_replace('_', ' ', $data_split[1].'_'.$data_split[2]).' here'
        );
        
        return $attributes;
    } 

    public function find($id)
    {
        $query = $this->db->where($this->contactColumn, $id)->get($this->contactTable);
        
        foreach($query->result() as $row)
        {
            $arr[] = array(
                'phone_number' => $row->contact_phone_number,
                'mobile_number' => $row->contact_mobile_number,
                'fax_number' => $row->contact_fax_number,
                'contact_table' => $row->contact_table,
                'contact_table_id' => $row->contact_table_id
            );
        }

        return $arr;
    }
}