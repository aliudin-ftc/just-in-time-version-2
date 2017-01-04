<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Resources_Model extends CI_Model {

    private $resourcesTable = 'resources';
    private $resourcesColumn = 'resources_id';

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
        $this->db->select('*');
        $this->db->from('resources as res');                
        $this->db->join('resources_level as res_lvl', 'res.resources_id = res_lvl.resources_id'); 
        $this->db->join('level as lvl', 'res_lvl.level_id = lvl.level_id');
        $this->db->where('lvl.level_name','Account Executive');
        $query = $this->db->get();
        
        $arr[] = array(
            '0' => 'select '.str_replace('_', ' ', $data).' here',
        );

        foreach ($query->result() as $row)
        {
            $arr[] = array(
                $row->resources_id => $row->resources_fname.' '.$row->resources_lname
            );
        }

        return call_user_func_array('array_merge', $arr);
    }

    public function get_account_executive_name($id)
    {
        $this->db->where($this->resourcesColumn, $id);
        $query = $this->db->get($this->resourcesTable);

        foreach ($query->result() as $row)
        {
            $id = $row->resources_fname.' '.$row->resources_lname;      
        }
        return $id;  
    }
    
    public function form_selected_options($id)
    {   
        $this->db->select('*');
        $this->db->from($this->resourcesTable.' as res');
        $this->db->join('customer as cus','res.resources_id = cus.resources_id');    
        $this->db->where('cus.customer_id',$id);
        $query = $this->db->get();
        
        if($query->num_rows() > 0)
        {
            foreach ($query->result() as $row) {
                $id = $row->resources_id;
            }

            return $id;
        }
        else 
        {
            return $id = '0';
        }
    }       
}