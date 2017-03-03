<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Department_Model extends CI_Model {

    private $departmentTable = 'department';
    private $departmentColumn = 'department_id';

    public function __construct()
    {
        parent::__construct();
    }

    public function form_input_attributes($data, $id)
    {   
        if(isset($id) && !empty($id))
        {   
            $this->db->where($this->departmentColumn, $id);
            $query = $this->db->get($this->departmentTable);

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
            $this->db->where($this->departmentColumn, $id);
            $query = $this->db->get($this->departmentTable);

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
            $this->db->where($this->departmentColumn, $id);
            $query = $this->db->get($this->departmentTable);

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
        $query = $this->db->get($this->departmentTable);
    
        $arr[] = array(
            '0' => 'select '.str_replace('_', ' ', $data).' here',
        );
        foreach ($query->result() as $row)
        {
            $arr[] = array(
                $row->department_id => $row->department_description
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
        $this->db->from($this->departmentTable);  
        $this->db->where($this->departmentColumn, $id);
        $query = $this->db->get();
        
        if($query->num_rows() > 0)
        {
            foreach ($query->result() as $row) {
                $id = $row->department_id;
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
        $this->db->from($this->departmentTable.' as dep');
        $this->db->join('resources as res','dep.department_id = res.department_id');  
        $this->db->where('res.resources_id', $id);
        $query = $this->db->get();
        
        if($query->num_rows() > 0)
        {
            foreach ($query->result() as $row) {
                $id = $row->department_id;
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
        $this->db->from($this->departmentTable.' as dep');
        $this->db->join('job_order as job','dep.department_id = job.department_id');  
        $this->db->where('job.job_order_id', $job_id);
        $query = $this->db->get();
        
        if($query->num_rows() > 0)
        {
            foreach ($query->result() as $row) {
                $id = $row->department_id;
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
            $this->db->from('department as dep');
            $this->db->join('job_request_module as req_mod', 'dep.department_id = req_mod.department_id');
            $this->db->where('job_request_module_id', $id);
            $query = $this->db->get();
            
            if($query->num_rows() > 0)
            {
                foreach ($query->result() as $row) {
                    $id = $row->department_id;
                }

                return $id;
            }
            else 
            {
                return $id = '0';
            }
        } else {     
            $this->db->where($this->departmentColumn, $id);
            $query = $this->db->get($this->departmentTable);
            
            if($query->num_rows() > 0)
            {
                foreach ($query->result() as $row) {
                    $id = $row->department_id;
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
        $this->db->from($this->departmentTable.' as dep');
        $this->db->join('brand as bra','dep.department_id = bra.department_id');
        $this->db->where('bra.brand_id', $id);
        $query = $this->db->get();
        
        if($query->num_rows() > 0)
        {
            foreach ($query->result() as $row) {
                $id = $row->department_id;
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
            $this->db->where($this->departmentColumn, $id);
            $query = $this->db->get($this->departmentTable);

            foreach ($query->result() as $row) {
                $id = $row->department_logo;
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
        $this->db->from('department as dep');
        $this->db->join('created as cre','dep.department_id = cre.created_table_id');
        $this->db->where('cre.created_table','department');    
        $this->db->where('dep.department_id', $id);
        $query = $this->db->get();

        foreach ($query->result() as $row) {

            $arr[] = array(
                'department_id' => $row->department_id,
                'department_code' => $row->department_code,
                'derpartment_name' => $row->department_name,
                'department_description' => $row->department_description
            );

        }

        return $arr;
    }

    public function insert($data)
    {
        $this->db->insert($this->departmentTable, $data);
        return $this->db->insert_id();
    }

    public function modify($data, $id)
    {   
        $this->db->where($this->departmentColumn, $id);
        $this->db->update($this->departmentTable, $data);
        return true;
    }

    public function get_all_department($start_from=0, $limit=0)
    {  
        $this->db->select('*');
        $this->db->from($this->departmentTable.' as dep');
        $this->db->join('status as stat','dep.department_id = stat.status_table_id');
        $this->db->where('stat.status_table', $this->departmentTable);  
        $this->db->where('stat.status_code', 1);  
        $this->db->order_by('dep.'.$this->departmentColumn, 'DESC');
        $query = $this->db->limit( $limit, $start_from )->get();
        return $query;
    }

    public function get_alls_department()
    {   
        $this->db->select('*');
        $this->db->from($this->departmentTable.' as dep');
        $this->db->join('status as stat','dep.department_id = stat.status_table_id');
        $this->db->where('stat.status_table', $this->departmentTable);  
        $this->db->where('stat.status_code', 1);
        $this->db->order_by('dep.'.$this->departmentColumn, 'DESC');
        $query = $this->db->get();
        return $query;
    }

    public function like_department($wildcard='', $start_from=0, $limit=0)
    {
        $this->db->select('*');
        $this->db->from($this->departmentTable.' as dep');
        $this->db->join('status as stat','dep.department_id = stat.status_table_id');
        $this->db->where('stat.status_table', $this->departmentTable);  
        $this->db->where('stat.status_code', 1);  
        $this->db->group_start();
        $this->db->or_where('dep.department_id LIKE', '%' . $wildcard . '%');
        $this->db->or_where('dep.department_code LIKE', '%' . $wildcard . '%');
        $this->db->or_where('dep.department_name LIKE', '%' . $wildcard . '%');
        $this->db->or_where('dep.department_description LIKE', '%' . $wildcard . '%');
        $this->db->group_end();
        $this->db->order_by('dep.'.$this->departmentColumn, 'DESC');
        $query = $this->db->limit( $limit, $start_from )->get();
        return $query;   
    }

    public function likes_department($wildcard='')
    {
        $this->db->select('*');
        $this->db->from($this->departmentTable.' as dep');
        $this->db->join('status as stat','dep.department_id = stat.status_table_id');
        $this->db->where('stat.status_table', $this->departmentTable);  
        $this->db->where('stat.status_code', 1);  
        $this->db->group_start();
        $this->db->or_where('dep.department_id LIKE', '%' . $wildcard . '%');
        $this->db->or_where('dep.department_code LIKE', '%' . $wildcard . '%');
        $this->db->or_where('dep.department_name LIKE', '%' . $wildcard . '%');
        $this->db->or_where('dep.department_description LIKE', '%' . $wildcard . '%');
        $this->db->group_end();
        $this->db->order_by('dep.'.$this->departmentColumn, 'DESC');
        $query = $this->db->get();
        return $query;
    }

    public function get_all_archived_department($start_from=0, $limit=0)
    {  
        $this->db->select('*');
        $this->db->from($this->departmentTable.' as dep');
        $this->db->join('status as stat','dep.department_id = stat.status_table_id');
        $this->db->where('stat.status_table', $this->departmentTable);  
        $this->db->where('stat.status_code', 0);  
        $this->db->order_by('dep.'.$this->departmentColumn, 'DESC');
        $query = $this->db->limit( $limit, $start_from )->get();
        return $query;
    }

    public function get_alls_archived_department()
    {   
        $this->db->select('*');
        $this->db->from($this->departmentTable.' as dep');
        $this->db->join('status as stat','dep.department_id = stat.status_table_id');
        $this->db->where('stat.status_table', $this->departmentTable);  
        $this->db->where('stat.status_code', 0);
        $this->db->order_by('dep.'.$this->departmentColumn, 'DESC');
        $query = $this->db->get();
        return $query;
    }

    public function like_archived_department($wildcard='', $start_from=0, $limit=0)
    {
        $this->db->select('*');
        $this->db->from($this->departmentTable.' as dep');
        $this->db->join('status as stat','dep.department_id = stat.status_table_id');
        $this->db->where('stat.status_table', $this->departmentTable);  
        $this->db->where('stat.status_code', 0);  
        $this->db->group_start();
        $this->db->or_where('dep.department_id LIKE', '%' . $wildcard . '%');
        $this->db->or_where('dep.department_code LIKE', '%' . $wildcard . '%');
        $this->db->or_where('dep.department_name LIKE', '%' . $wildcard . '%');
        $this->db->or_where('dep.department_description LIKE', '%' . $wildcard . '%');
        $this->db->group_end();
        $this->db->order_by('dep.'.$this->departmentColumn, 'DESC');
        $query = $this->db->limit( $limit, $start_from )->get();
        return $query;      
    }

    public function likes_archived_department($wildcard='')
    {
        $this->db->select('*');
        $this->db->from($this->departmentTable.' as dep');
        $this->db->join('status as stat','dep.department_id = stat.status_table_id');
        $this->db->where('stat.status_table', $this->departmentTable);  
        $this->db->where('stat.status_code', 0);  
        $this->db->group_start();
        $this->db->or_where('dep.department_id LIKE', '%' . $wildcard . '%');
        $this->db->or_where('dep.department_code LIKE', '%' . $wildcard . '%');
        $this->db->or_where('dep.department_name LIKE', '%' . $wildcard . '%');
        $this->db->or_where('dep.department_description LIKE', '%' . $wildcard . '%');
        $this->db->group_end();
        $this->db->order_by('dep.'.$this->departmentColumn, 'DESC');
        $query = $this->db->get();
        return $query;   
    }

    public function get_department_name_by_id($id)
    {   
        $this->db->where($this->departmentColumn, $id);
        $query = $this->db->get($this->departmentTable);

        foreach($query->result() as $row)
        {
            $id = $row->department_name;
        }

        return $id;
    }

    public function form_select_view_jobrequest_attributes($data, $id)
    {   
        if(isset($id) && !empty($id))
        {
            $attributes = array(
                'name'          => $data,
                'id'            => $data,
                'disabled'      => 'disabled',
                'class'         => 'selectpicker',
                'data-live-search'  => 'true'
            );
        } 
        else 
        {
            $attributes = array(
                'name'          => $data,
                'id'            => $data,
                'class'         => 'selectpicker',
                'data-live-search'  => 'true'
            );
        }
        return $attributes;
    }

    public function form_select_view_jobrequest_options($data, $id)
    { 
        $query = $this->db->get($this->departmentTable);
        
        $arr[] = array(
            '0' => 'select '.str_replace('_', ' ', $data).' here',
        );

        foreach ($query->result() as $row)
        {
            $arr[] = array(
                $row->department_id => $row->department_name
            );
        }

        $array = array();
        foreach($arr as $arrs)
            foreach($arrs as $key => $val)
                $array[$key] = $val;
        return $array;
    }   

    public function form_selected_view_jobrequest_options($id)
    {   
        $this->db->select('*');
        $this->db->from('job_request_module as job');
        $this->db->join('job_order as jo','job.job_order_id = jo.job_order_id');
        $this->db->where('job.job_request_module_id', $id);
        $query = $this->db->get();
        
        if($query->num_rows() > 0)
        {
            foreach ($query->result() as $row) {
                $id = $row->department_id;
            }

            return $id;
        }
        else 
        {
            return $id = '0';
        }
    } 
}