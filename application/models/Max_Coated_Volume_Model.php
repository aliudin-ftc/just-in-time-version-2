<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Max_Coated_Volume_Model extends CI_Model {

    private $max_coated_volumeTable = 'max_coated_volume';
    private $max_coated_volumeColumn = 'max_coated_volume_id';

    public function __construct()
    {
        parent::__construct();
    }
    
    public function get_max_coated_volume_price_by_id($id)
    {
        $this->db->where($this->max_coated_volumeColumn, $id);
        $query = $this->db->get($this->max_coated_volumeTable);

        foreach ($query->result() as $row) {
            $id = $row->max_coated_volume_price;
        }

        return $id;
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
        $query = $this->db->get($this->max_coated_volumeTable);
    
        $arr[] = array(
            '0' => 'select '.str_replace('_', ' ', $data).' here',
        );
        foreach ($query->result() as $row)
        {
            $arr[] = array(
                $row->max_coated_volume_id => $row->max_coated_volume_price
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
        $this->db->from($this->max_coated_volumeTable);  
        $this->db->where($this->max_coated_volumeColumn, $id);
        $query = $this->db->get();
        
        if($query->num_rows() > 0)
        {
            foreach ($query->result() as $row) {
                $id = $row->max_coatead_volume_id;
            }

            return $id;
        }
        else 
        {
            return $id = '0';
        }
    } 
}