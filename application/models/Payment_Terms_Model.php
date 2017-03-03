<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Payment_Terms_Model extends CI_Model {

    private $payment_termsTable = 'payment_terms';
    private $payment_termsColumn = 'payment_terms_id';

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
        $query = $this->db->get($this->payment_termsTable);
        
        $arr[] = array(
            '0' => 'select '.str_replace('_', ' ', $data).' here',
        );

        foreach ($query->result() as $row)
        {
            $arr[] = array(
                $row->payment_terms_id => $row->payment_terms_name
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
        $this->db->from($this->payment_termsTable.' as payment_terms');
        $this->db->join('customer as cus','payment_terms.payment_terms_id = cus.payment_terms_id');    
        $this->db->where('cus.customer_id',$id);
        $query = $this->db->get();
        
        if($query->num_rows() > 0)
        {
            foreach ($query->result() as $row) {
                $id = $row->payment_terms_id;
            }

            return $id;
        }
        else 
        {
            return $id = '0';
        }
    }   

    public function form_selected_resources_options($id)
    {   
        $this->db->select('*');
        $this->db->from('payment_terms_resources as pay');
        $this->db->join('resources as res','pay.resources_id = res.resources_id');    
        $this->db->where('res.resources_id',$id);
        $query = $this->db->get();
        
        if($query->num_rows() > 0)
        {
            foreach ($query->result() as $row) {
                $id = $row->payment_terms_id;
            }

            return $id;
        }
        else 
        {
            return $id = '0';
        }
    }    
}