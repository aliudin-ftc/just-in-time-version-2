<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Packing_Instructions_Model extends CI_Model {

    private $packing_instructionsTable = 'packing_instructions';
    private $packing_instructionsColumn = 'packing_instructions_id';

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
        $query = $this->db->get($this->packing_instructionsTable);
        
        $arr[] = array(
            '0' => 'select '.str_replace('_', ' ', $data).' here',
        );

        foreach ($query->result() as $row)
        {
            $arr[] = array(
                $row->packing_instructions_id => $row->packing_instructions_name
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
        $this->db->from($this->packing_instructionsTable.' as packing_instructions');
        $this->db->join('job_order as job','packing_instructions.packing_instructions_id = job.packing_instructions_id');    
        $this->db->where('job.job_order_id',$id);
        $query = $this->db->get();
        
        if($query->num_rows() > 0)
        {
            foreach ($query->result() as $row) {
                $id = $row->packing_instructions_id;
            }

            return $id;
        }
        else 
        {
            return $id = '0';
        }
    }    

    public function form_selected_job_element_options($id)
    {   
        if(isset($id) && !empty($id))
        {   
            $this->db->select('*');
            $this->db->from('packing_instructions as pack');
            $this->db->join('job_elements as job', 'pack.packing_instructions_id = job.packing_instructions_id');
            $this->db->where('job.job_elements_id', $id);
            $query = $this->db->get();
            
            if($query->num_rows() > 0)
            {
                foreach ($query->result() as $row) {
                    $id = $row->packing_instructions_id;
                }

                return $id;
            }
            else 
            {
                return $id = '0';
            }
        } else {     
            $this->db->where($this->packing_instructionsColumn, $id);
            $query = $this->db->get($this->packing_instructionsTable);
            
            if($query->num_rows() > 0)
            {
                foreach ($query->result() as $row) {
                    $id = $row->packing_instructions_id;
                }

                return $id;
            }
            else 
            {
                return $id = '0';
            }
        }
    }   

    public function get_packing_instructions_name_by_id($id)
    {
        $this->db->where($this->packing_instructionsColumn, $id);
        $query = $this->db->get($this->packing_instructionsTable);

        foreach ($query->result() as $row) {
            $id = $row->packing_instructions_name;
        }

        return $id;
    }
}