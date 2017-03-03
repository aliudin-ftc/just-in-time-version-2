<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class user_secret_Model extends CI_Model {

    private $user_secretTable = 'user_secret';
    private $user_secretColumn = 'user_secret_id';

    public function __construct()
    {
        parent::__construct();
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
        $query = $this->db->get($this->user_secretTable);
    
        $arr[] = array(
            '0' => 'select '.str_replace('_', ' ', $data).' here',
        );
        foreach ($query->result() as $row)
        {
            $arr[] = array(
                $row->user_secret_id => $row->user_secret_question
            );
        }
        
        $array = array();
        foreach($arr as $arrs)
            foreach($arrs as $key => $val)
                $array[$key] = $val;
        return $array;
    }   
    
    public function form_selected_user_options($id)
    {   
        $this->db->select('*');
        $this->db->from($this->user_secretTable);  
        $this->db->where($this->user_secretColumn, $id);
        $query = $this->db->get();
        
        if($query->num_rows() > 0)
        {
            foreach ($query->result() as $row) {
                $id = $row->user_secret_id;
            }

            return $id;
        }
        else 
        {
            return $id = '0';
        }
    }  

    public function get_secret_question_by_id($id)
    {
        $this->db->where($this->user_secretColumn, $id);
        $query = $this->db->get($this->user_secretTable);

        foreach ($query->result() as $row) {
            $id = $row->user_secret_question;
        }

        return $id;
    }  
}