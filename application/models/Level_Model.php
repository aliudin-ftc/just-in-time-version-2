<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class level_Model extends CI_Model {

    private $levelTable = 'level';
    private $levelColumn = 'level_id';

    public function __construct()
    {
        parent::__construct();
    }

    public function form_input_attributes($data, $id)
    {   
        if(isset($id) && !empty($id))
        {   
            $this->db->where($this->levelColumn, $id);
            $query = $this->db->get($this->levelTable);

            foreach ($query->result() as $row) {
                $value = $row->$data;
            }

            $attributes = array(
                'name'          => $data,
                'id'            => $data,
                'type'          => 'text',
                'value'         => $value,
                'class'         => 'form-control input-md',
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

    public function form_textarea_attributes($data, $id)
    {   
        if(isset($id) && !empty($id))
        {   
            $this->db->where($this->levelColumn, $id);
            $query = $this->db->get($this->levelTable);

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

    public function form_input_numeric_attributes($data, $id)
    {   
        if(isset($id) && !empty($id))
        {   
            $this->db->where($this->levelColumn, $id);
            $query = $this->db->get($this->levelTable);

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
                'class'         => 'form-control input-md numeric',
                'placeholder'   => 'insert '.str_replace('_', ' ', $data).' here'
            );
        }
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

    public function form_select_attach_job_elem_attributes($data)
    {
        $attributes = array(
            'name'          => $data,
            'id'            => $data,
            'disabled'      => 'disabled',
            'class'         => 'selectpicker',
            'data-live-search'  => 'true'
        );

        return $attributes;
    }

    public function form_select_options($data)
    {   
        $query = $this->db->get($this->levelTable);
    
        $arr[] = array(
            '0' => 'select '.str_replace('_', ' ', $data).' here',
        );
        foreach ($query->result() as $row)
        {
            $arr[] = array(
                $row->level_id => $row->level_description
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
        $this->db->from($this->levelTable);  
        $this->db->where($this->levelColumn, $id);
        $query = $this->db->get();
        
        if($query->num_rows() > 0)
        {
            foreach ($query->result() as $row) {
                $id = $row->level_id;
            }

            return $id;
        }
        else 
        {
            return $id = '0';
        }
    }     

    public function find($id)
    {   
        $this->db->select('*');
        $this->db->from('level as dep');
        $this->db->join('created as cre','dep.level_id = cre.created_table_id');
        $this->db->where('cre.created_table','level');    
        $this->db->where('dep.level_id', $id);
        $query = $this->db->get();

        foreach ($query->result() as $row) {

            $arr[] = array(
                'level_id' => $row->level_id,
                'level_code' => $row->level_code,
                'derpartment_name' => $row->level_name,
                'level_description' => $row->level_description
            );

        }

        return $arr;
    }

    public function insert($data)
    {
        $this->db->insert($this->levelTable, $data);
        return $this->db->insert_id();
    }

    public function modify($data, $id)
    {   
        $this->db->where($this->levelColumn, $id);
        $this->db->update($this->levelTable, $data);
        return true;
    }

    public function get_level_name_by_id($id)
    {   
        $this->db->where($this->levelColumn, $id);
        $query = $this->db->get($this->levelTable);

        foreach($query->result() as $row)
        {
            $id = $row->level_name;
        }

        return $id;
    }

}