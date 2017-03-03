<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Painting_Cost_Model extends CI_Model {

    private $painting_costTable = 'painting_cost';
    private $painting_costColumn = 'painting_cost_id';

    public function __construct()
    {
        parent::__construct();
    }

    public function form_input_attributes($data, $id)
    {   
        if(isset($id) && !empty($id))
        {   
            $this->db->where($this->painting_costColumn, $id);
            $query = $this->db->get($this->painting_costTable);

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
            $this->db->where($this->painting_costColumn, $id);
            $query = $this->db->get($this->painting_costTable);

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
            $this->db->where($this->painting_costColumn, $id);
            $query = $this->db->get($this->painting_costTable);

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
        $query = $this->db->get($this->painting_costTable);
    
        $arr[] = array(
            '0' => 'select '.str_replace('_', ' ', $data).' here',
        );
        foreach ($query->result() as $row)
        {
            $arr[] = array(
                $row->painting_cost_id => $row->painting_cost_description
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
        $this->db->from($this->painting_costTable);  
        $this->db->where($this->painting_costColumn, $id);
        $query = $this->db->get();
        
        if($query->num_rows() > 0)
        {
            foreach ($query->result() as $row) {
                $id = $row->painting_cost_id;
            }

            return $id;
        }
        else 
        {
            return $id = '0';
        }
    }       

    public function form_selected_resources_options($id)
    {   
        $this->db->select('*');
        $this->db->from($this->painting_costTable.' as paint');
        $this->db->join('resources as res','paint.painting_cost_id = res.painting_cost_id');  
        $this->db->where('res.resources_id', $id);
        $query = $this->db->get();
        
        if($query->num_rows() > 0)
        {
            foreach ($query->result() as $row) {
                $id = $row->painting_cost_id;
            }

            return $id;
        }
        else 
        {
            return $id = '0';
        }
    }  

    public function form_selected_jo_options($id)
    {   
        $job_id = $this->Job_Order_Model->find_job_id_by_job_no($id);

        $this->db->select('*');
        $this->db->from($this->painting_costTable.' as paint');
        $this->db->join('job_order as job','paint.painting_cost_id = job.painting_cost_id');  
        $this->db->where('job.job_order_id', $job_id);
        $query = $this->db->get();
        
        if($query->num_rows() > 0)
        {
            foreach ($query->result() as $row) {
                $id = $row->painting_cost_id;
            }

            return $id;
        }
        else 
        {
            return $id = '0';
        }
    }

    public function form_selected_job_request_options($id)
    {   
        if(isset($id) && !empty($id))
        {   
            $this->db->select('*');
            $this->db->from('painting_cost as paint');
            $this->db->join('job_request_module as req_mod', 'paint.painting_cost_id = req_mod.painting_cost_id');
            $this->db->where('job_request_module_id', $id);
            $query = $this->db->get();
            
            if($query->num_rows() > 0)
            {
                foreach ($query->result() as $row) {
                    $id = $row->painting_cost_id;
                }

                return $id;
            }
            else 
            {
                return $id = '0';
            }
        } else {     
            $this->db->where($this->painting_costColumn, $id);
            $query = $this->db->get($this->painting_costTable);
            
            if($query->num_rows() > 0)
            {
                foreach ($query->result() as $row) {
                    $id = $row->painting_cost_id;
                }

                return $id;
            }
            else 
            {
                return $id = '0';
            }
        }
    }

    public function form_selected_brand_options($id)
    {   
        $this->db->select('*');
        $this->db->from($this->painting_costTable.' as paint');
        $this->db->join('brand as bra','paint.painting_cost_id = bra.painting_cost_id');
        $this->db->where('bra.brand_id', $id);
        $query = $this->db->get();
        
        if($query->num_rows() > 0)
        {
            foreach ($query->result() as $row) {
                $id = $row->painting_cost_id;
            }

            return $id;
        }
        else 
        {
            return $id = '0';
        }
    }      

    public function form_file($id)
    {   
        if(isset($id) && !empty($id))
        {
            $this->db->where($this->painting_costColumn, $id);
            $query = $this->db->get($this->painting_costTable);

            foreach ($query->result() as $row) {
                $id = $row->painting_cost_logo;
            }
            return $id;
        } 
        else 
        {             
            return $id = '';
        }
    }

    public function find($id)
    {   
        $this->db->select('*');
        $this->db->from('painting_cost as paint');
        $this->db->join('created as cre','paint.painting_cost_id = cre.created_table_id');
        $this->db->where('cre.created_table','painting_cost');    
        $this->db->where('paint.painting_cost_id', $id);
        $query = $this->db->get();

        foreach ($query->result() as $row) {

            $arr[] = array(
                'painting_cost_id' => $row->painting_cost_id,
                'painting_cost_code' => $row->painting_cost_code,
                'derpartment_name' => $row->painting_cost_name,
                'painting_cost_description' => $row->painting_cost_description
            );

        }

        return $arr;
    }

    public function insert($data)
    {
        $this->db->insert($this->painting_costTable, $data);
        return $this->db->insert_id();
    }

    public function modify($data, $id)
    {   
        $this->db->where($this->painting_costColumn, $id);
        $this->db->update($this->painting_costTable, $data);
        return true;
    }

    public function get_all_painting_cost($start_from=0, $limit=0)
    {  
        $this->db->select('*');
        $this->db->from($this->painting_costTable.' as paint');
        $this->db->join('status as stat','paint.painting_cost_id = stat.status_table_id');
        $this->db->where('stat.status_table', $this->painting_costTable);  
        $this->db->where('stat.status_code', 1);  
        $this->db->order_by('paint.'.$this->painting_costColumn, 'DESC');
        $query = $this->db->limit( $limit, $start_from )->get();
        return $query;
    }

    public function get_alls_painting_cost()
    {   
        $this->db->select('*');
        $this->db->from($this->painting_costTable.' as paint');
        $this->db->join('status as stat','paint.painting_cost_id = stat.status_table_id');
        $this->db->where('stat.status_table', $this->painting_costTable);  
        $this->db->where('stat.status_code', 1);
        $this->db->order_by('paint.'.$this->painting_costColumn, 'DESC');
        $query = $this->db->get();
        return $query;
    }

    public function like_painting_cost($wildcard='', $start_from=0, $limit=0)
    {
        $this->db->select('*');
        $this->db->from($this->painting_costTable.' as paint');
        $this->db->join('status as stat','paint.painting_cost_id = stat.status_table_id');
        $this->db->where('stat.status_table', $this->painting_costTable);  
        $this->db->where('stat.status_code', 1);  
        $this->db->group_start();
        $this->db->or_where('paint.painting_cost_id LIKE', '%' . $wildcard . '%');
        $this->db->or_where('paint.painting_cost_code LIKE', '%' . $wildcard . '%');
        $this->db->or_where('paint.painting_cost_name LIKE', '%' . $wildcard . '%');
        $this->db->or_where('paint.painting_cost_description LIKE', '%' . $wildcard . '%');
        $this->db->or_where('paint.painting_cost_price LIKE', '%' . $wildcard . '%');
        $this->db->group_end();
        $this->db->order_by('paint.'.$this->painting_costColumn, 'DESC');
        $query = $this->db->limit( $limit, $start_from )->get();
        return $query;   
    }

    public function likes_painting_cost($wildcard='')
    {
        $this->db->select('*');
        $this->db->from($this->painting_costTable.' as paint');
        $this->db->join('status as stat','paint.painting_cost_id = stat.status_table_id');
        $this->db->where('stat.status_table', $this->painting_costTable);  
        $this->db->where('stat.status_code', 1);  
        $this->db->group_start();
        $this->db->or_where('paint.painting_cost_id LIKE', '%' . $wildcard . '%');
        $this->db->or_where('paint.painting_cost_code LIKE', '%' . $wildcard . '%');
        $this->db->or_where('paint.painting_cost_name LIKE', '%' . $wildcard . '%');
        $this->db->or_where('paint.painting_cost_description LIKE', '%' . $wildcard . '%');
        $this->db->or_where('paint.painting_cost_price LIKE', '%' . $wildcard . '%');
        $this->db->group_end();
        $this->db->order_by('paint.'.$this->painting_costColumn, 'DESC');
        $query = $this->db->get();
        return $query;
    }

    public function get_all_archived_painting_cost($start_from=0, $limit=0)
    {  
        $this->db->select('*');
        $this->db->from($this->painting_costTable.' as paint');
        $this->db->join('status as stat','paint.painting_cost_id = stat.status_table_id');
        $this->db->where('stat.status_table', $this->painting_costTable);  
        $this->db->where('stat.status_code', 0);  
        $this->db->order_by('paint.'.$this->painting_costColumn, 'DESC');
        $query = $this->db->limit( $limit, $start_from )->get();
        return $query;
    }

    public function get_alls_archived_painting_cost()
    {   
        $this->db->select('*');
        $this->db->from($this->painting_costTable.' as paint');
        $this->db->join('status as stat','paint.painting_cost_id = stat.status_table_id');
        $this->db->where('stat.status_table', $this->painting_costTable);  
        $this->db->where('stat.status_code', 0);
        $this->db->order_by('paint.'.$this->painting_costColumn, 'DESC');
        $query = $this->db->get();
        return $query;
    }

    public function like_archived_painting_cost($wildcard='', $start_from=0, $limit=0)
    {
        $this->db->select('*');
        $this->db->from($this->painting_costTable.' as paint');
        $this->db->join('status as stat','paint.painting_cost_id = stat.status_table_id');
        $this->db->where('stat.status_table', $this->painting_costTable);  
        $this->db->where('stat.status_code', 0);  
        $this->db->group_start();
        $this->db->or_where('paint.painting_cost_id LIKE', '%' . $wildcard . '%');
        $this->db->or_where('paint.painting_cost_code LIKE', '%' . $wildcard . '%');
        $this->db->or_where('paint.painting_cost_name LIKE', '%' . $wildcard . '%');
        $this->db->or_where('paint.painting_cost_description LIKE', '%' . $wildcard . '%');
        $this->db->or_where('paint.painting_cost_price LIKE', '%' . $wildcard . '%');
        $this->db->group_end();
        $this->db->order_by('paint.'.$this->painting_costColumn, 'DESC');
        $query = $this->db->limit( $limit, $start_from )->get();
        return $query;      
    }

    public function likes_archived_painting_cost($wildcard='')
    {
        $this->db->select('*');
        $this->db->from($this->painting_costTable.' as paint');
        $this->db->join('status as stat','paint.painting_cost_id = stat.status_table_id');
        $this->db->where('stat.status_table', $this->painting_costTable);  
        $this->db->where('stat.status_code', 0);  
        $this->db->group_start();
        $this->db->or_where('paint.painting_cost_id LIKE', '%' . $wildcard . '%');
        $this->db->or_where('paint.painting_cost_code LIKE', '%' . $wildcard . '%');
        $this->db->or_where('paint.painting_cost_name LIKE', '%' . $wildcard . '%');
        $this->db->or_where('paint.painting_cost_description LIKE', '%' . $wildcard . '%');
        $this->db->or_where('paint.painting_cost_price LIKE', '%' . $wildcard . '%');
        $this->db->group_end();
        $this->db->order_by('paint.'.$this->painting_costColumn, 'DESC');
        $query = $this->db->get();
        return $query;   
    }

    public function get_painting_cost_name_by_id($id)
    {   
        $this->db->where($this->painting_costColumn, $id);
        $query = $this->db->get($this->painting_costTable);

        foreach($query->result() as $row)
        {
            $id = $row->painting_cost_name;
        }

        return $id;
    }

}