<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Direct_Materials_Item_Model extends CI_Model {

    private $direct_materials_itemTable = 'direct_materials_item';
    private $direct_materials_itemColumn = 'direct_materials_item_id';

    public function __construct()
    {
        parent::__construct();
    }
    
    public function insert($data)
    {
        $this->db->insert($this->direct_materials_itemTable, $data);
        return $this->db->insert_id();
    }

    public function form_input_numeric_attributes($data, $id)
    {   
        if(isset($id) && !empty($id))
        {   
            $this->db->where($this->direct_materials_itemColumn, $id);
            $query = $this->db->get($this->direct_materials_itemTable);

            foreach ($query->result() as $row) {
                $value = $row->$data;
            }

            $attributes = array(
                'name'          => $data,
                'id'            => $data,
                'type'          => 'text',
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
                'type'          => 'text',
                'class'         => 'form-control input-md numeric',
                'placeholder'   => 'insert '.str_replace('_', ' ', $data).' here'
            );
        } 
        return $attributes;
    }

}