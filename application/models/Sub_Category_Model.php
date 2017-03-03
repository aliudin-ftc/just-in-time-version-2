<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Sub_Category_Model extends CI_Model {

    private $sub_categoryTable = 'sub_category';
    private $sub_categoryColumn = 'sub_category_id';

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
        $query = $this->db->get($this->sub_categoryTable);
        
        $arr[] = array(
            '0' => 'select '.str_replace('_', ' ', $data).' here',
        );

        foreach ($query->result() as $row)
        {
            $arr[] = array(
                $row->sub_category_id => $row->sub_category_name
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
        $this->db->from($this->sub_categoryTable.' as sub_category');
        $this->db->join('job_order as job','sub_category.sub_category_id = job.sub_category_id');    
        $this->db->where('job.job_order_id',$id);
        $query = $this->db->get();
        
        if($query->num_rows() > 0)
        {
            foreach ($query->result() as $row) {
                $id = $row->sub_category_id;
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
            $this->db->from('sub_category as sub');
            $this->db->join('job_elements as job', 'sub.sub_category_id = job.sub_category_id');
            $this->db->where('job.job_elements_id', $id);
            $query = $this->db->get();
            
            if($query->num_rows() > 0)
            {
                foreach ($query->result() as $row) {
                    $id = $row->sub_category_id;
                }

                return $id;
            }
            else 
            {
                return $id = '0';
            }
        } else {     
            $this->db->where($this->sub_categoryColumn, $id);
            $query = $this->db->get($this->sub_categoryTable);
            
            if($query->num_rows() > 0)
            {
                foreach ($query->result() as $row) {
                    $id = $row->sub_category_id;
                }

                return $id;
            }
            else 
            {
                return $id = '0';
            }
        }
    }  

    public function get_sub_category_name_by_id($id)
    {
        $this->db->where($this->sub_categoryColumn, $id);
        $query = $this->db->get($this->sub_categoryTable);

        foreach ($query->result() as $row) {
            $id = $row->sub_category_name;
        }

        return $id;
    } 

}