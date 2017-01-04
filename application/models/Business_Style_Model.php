<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Business_Style_Model extends CI_Model {

    private $business_styleTable = 'business_style';
    private $business_styleColumn = 'business_style_id';

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
        $query = $this->db->get($this->business_styleTable);
        
        $arr[] = array(
            '0' => 'select '.str_replace('_', ' ', $data).' here',
        );

        foreach ($query->result() as $row)
        {
            $arr[] = array(
                $row->business_style_id => $row->business_style_description
            );
        }

        return call_user_func_array('array_merge', $arr);
    }

    public function form_selected_options($id)
    {   
        $this->db->select('*');
        $this->db->from($this->business_styleTable.' as bus');
        $this->db->join('customer as cus','bus.business_style_id = cus.business_style_id');    
        $this->db->where('cus.customer_id',$id);
        $query = $this->db->get();
        
        if($query->num_rows() > 0)
        {
            foreach ($query->result() as $row) {
                $id = $row->business_style_id;
            }

            return $id;
        }
        else 
        {
            return $id = '0';
        }
    }
           
}