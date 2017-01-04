<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Business_Unit_Model extends CI_Model {

    private $business_unitTable = 'business_unit';
    private $business_unitColumn = 'business_unit_id';

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
        $query = $this->db->get($this->business_unitTable);
        
        $arr[] = array(
            '0' => 'select '.str_replace('_', ' ', $data).' here',
        );

        foreach ($query->result() as $row)
        {
            $arr[] = array(
                $row->business_unit_id => $row->business_unit_description
            );
        }

        return call_user_func_array('array_merge', $arr);
    }

    public function form_selected_options($id)
    {   
        $this->db->select('*');
        $this->db->from($this->business_unitTable.' as bus');
        $this->db->join('customer as cus','bus.business_unit_id = cus.business_unit_id');    
        $this->db->where('cus.customer_id',$id);
        $query = $this->db->get();
        
        if($query->num_rows() > 0)
        {
            foreach ($query->result() as $row) {
                $id = $row->business_unit_id;
            }

            return $id;
        }
        else 
        {
            return $id = '0';
        }
    }

    public function get_business_unit_name($id)
    {
        $this->db->where($this->business_unitColumn, $id);
        $query = $this->db->get($this->business_unitTable);

        foreach ($query->result() as $row)
        {
            $id = $row->business_unit_description;      
        }
        return $id;  
    }

           
}