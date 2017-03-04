<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Localmail_Model extends CI_Model {

    private $localmailTable = 'localmail';
    private $localmailColumn = 'localmail_id';

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

    public function form_input_email_resources_attributes($data, $id)
    {   
        if(isset($id) && !empty($id))
        {   
            $data_split = explode('_', $data);
            $this->db->select('*');
            $this->db->from($this->localmailTable.' as loc');
            $this->db->join('resources as res','loc.resources_id = res.resources_id');    
            $this->db->where('res.resources_id',$id);
            $query = $this->db->get();

            foreach ($query->result() as $row) {
                $value = $row->$data;
            }

            $attributes = array(
                'name'          => $data_split[1],
                'id'            => $data_split[1],
                'type'          => 'email',
                'value'         => $value,
                'class'         => 'form-control input-md',
                'placeholder'   => 'insert '.str_replace('_', ' ', $data).' here'
            );
        } 
        else 
        {   
            $data_split = explode('_', $data);
            $attributes = array(
                'name'          => $data_split[1],
                'id'            => $data_split[1],
                'type'          => 'email',
                'class'         => 'form-control input-md',
                'placeholder'   => 'insert '.str_replace('_', ' ', $data).' here'
            );
        }
        return $attributes;        
    }

    public function form_input_date_attributes($data)
    {
        $attributes = array(
            'name'          => $data,
            'id'            => $data,
            'type'          => 'text',
            'class'         => 'form-control date-picker',
            'placeholder'   => 'select '.str_replace('_', ' ', $data).' here'
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
        $query = $this->db->get($this->localmailTable);
        
        $arr[] = array(
            '0' => 'select '.str_replace('_', ' ', $data).' here',
        );

        foreach ($query->result() as $row)
        {
            $arr[] = array(
                $row->localmail_id => $row->localmail_description
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
        $this->db->from($this->localmailTable.' as bus');
        $this->db->join('customer as cus','bus.localmail_id = cus.localmail_id');    
        $this->db->where('cus.customer_id',$id);
        $query = $this->db->get();
        
        if($query->num_rows() > 0)
        {
            foreach ($query->result() as $row) {
                $id = $row->localmail_id;
            }

            return $id;
        }
        else 
        {
            return $id = '0';
        }
    }

    public function form_textarea_attributes($data, $id)
    {   
        if(isset($id) && !empty($id))
        {   
            $this->db->select('*');
            $this->db->from($this->localmailTable.' as con_per');
            $this->db->join('customer as cus','con_per.customer_id = cus.customer_id');    
            $this->db->where('cus.customer_id',$id);
            $query = $this->db->get();

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

    public function form_input_numeric_customer_attributes($data, $id)
    {   
        if(isset($id) && !empty($id))
        {   
            $this->db->select('*');
            $this->db->from('localmail');
            $this->db->where('localmail_table', 'customer');
            $this->db->where('localmail_table_id', $id);
            $query = $this->db->get();

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
                'class'         => 'form-control input-md',
                'placeholder'   => 'insert '.str_replace('_', ' ', $data).' here'
            );
        }

        return $attributes;
    }   

    public function insert($data)
    {
        $this->db->insert($this->localmailTable, $data);
        return $this->db->insert_id();
    }

    public function modify_resources($data, $id)
    {   
        $this->db->where('resources_id', $id);
        $this->db->update($this->localmailTable, $data);
        return true;
    }

    public function get_localmail_by_resources_id($res_id)
    {
        $this->db->where('resources_id', $res_id);
        $query = $this->db->get($this->localmailTable);

        foreach ($query->result() as $row) {
            $res_id = $row->localmail_email;
        }

        return $res_id;
    }

}