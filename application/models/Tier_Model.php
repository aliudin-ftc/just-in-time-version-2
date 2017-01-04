<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Tier_Model extends CI_Model {

    private $tierTable = 'tier';
    private $tierColumn = 'tier_id';

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
        $query = $this->db->get($this->tierTable);
        
        $arr[] = array(
            '0' => 'select '.str_replace('_', ' ', $data).' here',
        );

        foreach ($query->result() as $row)
        {
            $arr[] = array(
                $row->tier_id => $row->tier_description
            );
        }

        return call_user_func_array('array_merge', $arr);
    }

    public function form_selected_options($id)
    {   
        $this->db->select('*');
        $this->db->from($this->tierTable.' as tier');
        $this->db->join('customer as cus','tier.tier_id = cus.tier_id');    
        $this->db->where('cus.customer_id',$id);
        $query = $this->db->get();
        
        if($query->num_rows() > 0)
        {
            foreach ($query->result() as $row) {
                $id = $row->tier_id;
            }

            return $id;
        }
        else 
        {
            return $id = '0';
        }
    }       
}