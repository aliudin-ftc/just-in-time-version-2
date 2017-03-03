<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Barangay_Model extends CI_Model {

    private $barangayTable = 'barangay';
    private $barangayColumn = 'barangay_id';

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

    public function form_select_resources_options($data, $id)
    {   
        /*$this->db->select('*');
        $this->db->from($this->barangayTable.' as brgy');
        $this->db->join('city as city','brgy.city_id = city.city_id');
        $this->db->join('province as prov','city.province_id = prov.province_id');
        $this->db->join('address as add','prov.province_id = add.address_province');
        $this->db->where('add.address_table', 'resources');
        $this->db->where('add.address_table_id', $id);
        $query = $this->db->get();
        */
        $arr[] = array(
            '0' => 'select '.str_replace('_', ' ', $data).' here',
        );

        /*foreach ($query->result() as $row)
        {
            $arr[] = array(
                $row->barangay_id => $row->barangay_name
            );
        }*/

        $array = array();
        foreach($arr as $arrs)
            foreach($arrs as $key => $val)
                $array[$key] = $val;
        return $array;
    }

    public function form_selected_resources_options($id)
    {   
        $this->db->select('*');
        $this->db->from($this->barangayTable.' as barangay');
        $this->db->join('address as add', 'barangay.barangay_id = add.address_barangay');
        $this->db->where('add.address_table', 'resources');
        $this->db->where('add.address_table_id', $id);
        $query = $this->db->get();
        
        if($query->num_rows() > 0)
        {
            foreach ($query->result() as $row) {
                $id = $row->barangay_id;
            }

            return $id;
        }
        else 
        {
            return $id = '0';
        }
    }

    public function find_barangay_name_by_id($id)
    {
        $this->db->where($this->barangayColumn, $id);
        $query = $this->db->get($this->barangayTable);

        foreach ($query->result() as $row) {
            $id = $row->barangay_name;
        }

        return $id;
    }
}