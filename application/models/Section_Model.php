<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Section_Model extends CI_Model {

    private $sectionTable = 'section';
    private $sectionColumn = 'section_id';

    public function __construct()
    {
        parent::__construct();
    }
    
    public function insert($data)
    {
        $this->db->insert($this->sectionTable, $data);
        return $this->db->insert_id();
    }

    public function all_sections()
    {
        $query = $this->db->get($this->sectionTable);
        return $query->result();
    }


    public function placeholders($id)
    {
        $this->db->where($this->sectionColumn, $id);
        return $this->db->get($this->sectionTable)->row()->section_name;
    }

    public function form_input_numeric_attributes($data, $id)
    {   
        if(isset($id) && !empty($id))
        {   
            $this->db->where($this->sectionColumn, $id);
            $query = $this->db->get($this->sectionTable);

            foreach ($query->result() as $row) {
                $value = $row->$data;
            }

            $attributes = array(
                'name'          => $this->placeholders($data),
                'id'            => $this->placeholders($data),
                'type'          => 'text',
                'value'         => $value,
                'class'         => 'form-control input-md numeric',
                'placeholder'   => 'insert '.str_replace('_', ' ', $this->placeholders($data)).' here'
            );
        } 
        else {
            $attributes = array(
                'name'          => $this->placeholders($data),
                'id'            => $this->placeholders($data),
                'type'          => 'text',
                'class'         => 'form-control input-md numeric',
                'placeholder'   => 'insert '.str_replace('_', ' ',  $this->placeholders($data)).' here'
            );
        }
        return $attributes;
    }
}