<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class province_Model extends CI_Model {

    private $provinceTable = 'province';
    private $provinceColumn = 'province_id';

    public function __construct()
    {
        parent::__construct();
    }

    public function form_select_resources_attributes($data)
    {
        $attributes = array(
            'name'          => $data,
            'id'            => $data,
            'class'         => 'selectpicker',
            'data-live-search'  => 'true'
        );

        return $attributes;
    }

    public function form_select_resources_options($data)
    {   
        $query = $this->db->get($this->provinceTable);
        
        $arr[] = array(
            '0' => 'select '.str_replace('_', ' ', $data).' here',
        );

        foreach ($query->result() as $row)
        {
            $arr[] = array(
                $row->province_id => $row->province_description
            );
        }

        $array = array();
        foreach($arr as $arrs)
            foreach($arrs as $key => $val)
                $array[$key] = $val;
        return $array;
    }

    public function form_selected_resources_options($id)
    {   
        $this->db->select('*');
        $this->db->from($this->provinceTable.' as prov');
        $this->db->join('address as add', 'prov.province_id = add.address_province');
        $this->db->where('add.address_table', 'resources');
        $this->db->where('add.address_table_id', $id);
        $query = $this->db->get();
        
        if($query->num_rows() > 0)
        {
            foreach ($query->result() as $row) {
                $id = $row->province_id;
            }

            return $id;
        }
        else 
        {
            return $id = '0';
        }
    }

    public function find_province_name_by_id($id)
    {
        $this->db->where($this->provinceColumn, $id);
        $query = $this->db->get($this->provinceTable);

        foreach ($query->result() as $row) {
            $id = $row->province_name;
        }

        return $id;
    }
}