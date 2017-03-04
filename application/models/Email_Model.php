<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Email_Model extends CI_Model {

    private $emailTable = 'email';
    private $emailColumn = 'email_id';

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
        $query = $this->db->get($this->emailTable);
        
        $arr[] = array(
            '0' => 'select '.str_replace('_', ' ', $data).' here',
        );

        foreach ($query->result() as $row)
        {
            $arr[] = array(
                $row->email_id => $row->email_description
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
        $this->db->from($this->emailTable.' as bus');
        $this->db->join('customer as cus','bus.email_id = cus.email_id');    
        $this->db->where('cus.customer_id',$id);
        $query = $this->db->get();
        
        if($query->num_rows() > 0)
        {
            foreach ($query->result() as $row) {
                $id = $row->email_id;
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
            $this->db->from($this->emailTable.' as con_per');
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
            $this->db->from('email');
            $this->db->where('email_table', 'customer');
            $this->db->where('email_table_id', $id);
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
        $this->db->insert($this->emailTable, $data);
        return $this->db->insert_id();
    }

    public function modify($data, $id)
    {   
        $this->db->where($this->emailColumn, $id);
        $this->db->update($this->emailTable, $data);
        return true;
    }

    public function get_all_resources_email($start_from=0, $limit=0, $resources_id)
    {  
        $this->db->select('*');
        $this->db->from($this->emailTable. ' as em');
        $this->db->join('status as stat','em.email_id = stat.status_table_id');
        $this->db->where('stat.status_table', $this->emailTable);  
        $this->db->where('stat.status_code', 1);
        $this->db->where('em.email_table', 'resources');
        $this->db->where('em.email_table_id', $resources_id);  
        $this->db->order_by('em.'.$this->emailColumn, 'DESC');
        $query = $this->db->limit( $limit, $start_from )->get();
        return $query;
    }

    public function get_alls_resources_email($resources_id)
    {   
        $this->db->select('*');
        $this->db->from($this->emailTable. ' as em');
        $this->db->join('status as stat','em.email_id = stat.status_table_id');
        $this->db->where('stat.status_table', $this->emailTable);  
        $this->db->where('stat.status_code', 1);
        $this->db->where('em.email_table', 'resources');
        $this->db->where('em.email_table_id', $resources_id);  
        $this->db->order_by('em.'.$this->emailColumn, 'DESC');
        $query = $this->db->get();
        return $query;
    }

    public function like_resources_email($wildcard, $start_from=0, $limit=0, $resources_id)
    {  
        $this->db->select('*');
        $this->db->from($this->emailTable. ' as em');
        $this->db->join('status as stat','em.email_id = stat.status_table_id');
        $this->db->where('stat.status_table', $this->emailTable);  
        $this->db->where('stat.status_code', 1);
        $this->db->where('add.email_table', 'resources');
        $this->db->group_start();
        $this->db->where('em.email_table_id', $resources_id); 
        $this->db->or_where('em.email_address LIKE', $wildcard . '%');
        $this->db->or_where('em.email_description LIKE', $wildcard . '%');
        $this->db->group_end();
        $this->db->order_by('em.'.$this->emailColumn, 'DESC');
        $query = $this->db->limit( $limit, $start_from )->get();
        return $query;
    }

    public function likes_resources_email($wildcard, $resources_id)
    {   
        $this->db->select('*');
        $this->db->from($this->emailTable. ' as add');
        $this->db->join('status as stat','em.email_id = stat.status_table_id');
        $this->db->where('stat.status_table', $this->emailTable);  
        $this->db->where('stat.status_code', 1);
        $this->db->where('em.email_table', 'resources');
        $this->db->group_start();
        $this->db->where('em.email_table_id', $resources_id); 
        $this->db->or_where('em.email_address LIKE', $wildcard . '%');
        $this->db->or_where('em.email_description LIKE', $wildcard . '%');
        $this->db->group_end();
        $this->db->order_by('em.'.$this->emailColumn, 'DESC');
        $query = $this->db->get();
        return $query;
    }

    public function form_input_resources_attributes($data, $id)
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
        $attributes = array(
            'name'          => $data,
            'id'            => $data,
            'type'          => 'email',
            'class'         => 'form-control input-md',
            'placeholder'   => 'insert '.str_replace('_', ' ', $data).' here'
        );
        return $attributes;        
    }

    public function find($id)
    {
        $query = $this->db->where($this->emailColumn, $id)->get($this->emailTable);
        
        foreach($query->result() as $row)
        {
            $arr[] = array(
                'email_address' => $row->email_address,
                'email_description' => $row->email_description
            );
        }

        return $arr;
    }
}   