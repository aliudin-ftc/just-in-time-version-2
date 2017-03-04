<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Resources_Model extends CI_Model {

    private $resourcesTable = 'resources';
    private $resourcesColumn = 'resources_id';

    public function __construct()
    {
        parent::__construct();
    }

    public function form_input_attributes($data, $id)
    {
        if(isset($id) && !empty($id))
        {   
            $data_split = explode('_', $data);
            $this->db->where($this->resourcesColumn, $id);
            $query = $this->db->get($this->resourcesTable);

            foreach ($query->result() as $row) {
                $value = $row->$data;
            }

            if(count($data_split) > 2)
            {
                $attributes = array(
                    'name'          => $data_split[1].'_'.$data_split[2],
                    'id'            => $data_split[1].'_'.$data_split[2],
                    'type'          => 'text',
                    'value'         => $value,
                    'class'         => 'form-control input-md',
                    'placeholder'   => 'insert '.str_replace('_', ' ', $data_split[1].'_'.$data_split[2]).' here'
                );
            } else {
                $attributes = array(
                    'name'          => $data_split[1],
                    'id'            => $data_split[1],
                    'type'          => 'text',
                    'value'         => $value,
                    'class'         => 'form-control input-md',
                    'placeholder'   => 'insert '.str_replace('_', ' ', $data_split[1]).' here'
                );
            }
        } 
        else {
            $data_split = explode('_', $data);
            if(count($data_split) > 2)
            {
                $attributes = array(
                    'name'          => $data_split[1].'_'.$data_split[2],
                    'id'            => $data_split[1].'_'.$data_split[2],
                    'type'          => 'text',
                    'class'         => 'form-control input-md',
                    'placeholder'   => 'insert '.str_replace('_', ' ', $data_split[1].'_'.$data_split[2]).' here'
                );
            } else {
                $attributes = array(
                    'name'          => $data_split[1],
                    'id'            => $data_split[1],
                    'type'          => 'text',
                    'class'         => 'form-control input-md',
                    'placeholder'   => 'insert '.str_replace('_', ' ', $data_split[1]).' here'
                );
            }
                
        }
        return $attributes;
    }

    public function form_textarea_attributes($data, $id)
    {   
        if(isset($id) && !empty($id))
        {   
            $data_split = explode('_', $data);
            $this->db->where($this->resourcesColumn, $id);
            $query = $this->db->get($this->resourcesTable);

            foreach ($query->result() as $row) {
                $value = $row->$data;
            }

            $data_split = explode('_', $data);
            if(count($data_split) > 2)
            {
                $attributes = array(
                    'name'          => $data_split[1].'_'.$data_split[2],
                    'id'            => $data_split[1].'_'.$data_split[2],
                    'rows'          => '5',
                    'value'         => $value,
                    'class'         => 'auto-size form-control',
                    'placeholder'   => 'insert '.str_replace('_', ' ', $data_split[1].'_'.$data_split[2]).' here'
                );
            } else {
                $attributes = array(
                    'name'          => $data_split[1],
                    'id'            => $data_split[1],
                    'rows'          => '5',
                    'value'         => $value,
                    'class'         => 'auto-size form-control',
                    'placeholder'   => 'insert '.str_replace('_', ' ', $data_split[1]).' here'
                );
            }
        } 
        else 
        {
            $data_split = explode('_', $data);
            if(count($data_split) > 2)
            {
                $attributes = array(
                    'name'          => $data_split[1].'_'.$data_split[2],
                    'id'            => $data_split[1].'_'.$data_split[2],
                    'rows'          => '5',
                    'class'         => 'auto-size form-control',
                    'placeholder'   => 'insert '.str_replace('_', ' ', $data_split[1].'_'.$data_split[2]).' here'
                );
            } else {
                $attributes = array(
                    'name'          => $data_split[1],
                    'id'            => $data_split[1],
                    'rows'          => '5',
                    'class'         => 'auto-size form-control',
                    'placeholder'   => 'insert '.str_replace('_', ' ', $data_split[1]).' here'
                );
            }
        }
        return $attributes;        
    }

    public function form_input_numeric_attributes($data, $id)
    {   
        if(isset($id) && !empty($id))
        {   
            $data_split = explode('_', $data);
            $this->db->where($this->resourcesColumn, $id);
            $query = $this->db->get($this->resourcesTable);

            foreach ($query->result() as $row) {
                $value = $row->$data;
            }

            if(count($data_split) > 2)
            {
                $attributes = array(
                    'name'          => $data_split[1].'_'.$data_split[2],
                    'id'            => $data_split[1].'_'.$data_split[2],
                    'type'          => 'text',
                    'value'         => $value,
                    'class'         => 'form-control input-md numeric',
                    'placeholder'   => 'insert '.str_replace('_', ' ', $data_split[1].'_'.$data_split[2]).' here'
                );
            } else {
                $attributes = array(
                    'name'          => $data_split[1],
                    'id'            => $data_split[1],
                    'type'          => 'text',
                    'value'         => $value,
                    'class'         => 'form-control input-md numeric',
                    'placeholder'   => 'insert '.str_replace('_', ' ', $data_split[1]).' here'
                );
            }
        } 
        else {
            $data_split = explode('_', $data);
            if(count($data_split) > 2)
            {
                $attributes = array(
                    'name'          => $data_split[1].'_'.$data_split[2],
                    'id'            => $data_split[1].'_'.$data_split[2],
                    'type'          => 'text',
                    'class'         => 'form-control input-md numeric',
                    'placeholder'   => 'insert '.str_replace('_', ' ', $data_split[1].'_'.$data_split[2]).' here'
                );
            } else {
                $attributes = array(
                    'name'          => $data_split[1],
                    'id'            => $data_split[1],
                    'type'          => 'text',
                    'class'         => 'form-control input-md numeric',
                    'placeholder'   => 'insert '.str_replace('_', ' ', $data_split[1]).' here'
                );
            }
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
                $row->resources_id => $row->resources_firstname.' '.$row->resources_lastname
            );
        }

        $array = array();
        foreach($arr as $arrs)
            foreach($arrs as $key => $val)
                $array[$key] = $val;
        return $array;
    }

    public function get_account_executive_name($id)
    {
        $this->db->where($this->resourcesColumn, $id);
        $query = $this->db->get($this->resourcesTable);

        foreach ($query->result() as $row)
        {
            $id = $row->resources_firstname.' '.$row->resources_lastname;      
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

    public function form_select_jo_attributes($data)
    {
        $attributes = array(
            'name'          => $data,
            'id'            => $data,
            'class'         => 'selectpicker',
            'disabled'      => 'disabled',
            'data-live-search'  => 'true'
        );

        return $attributes;
    }    

    public function form_selected_jo_options($id)
    {   
        $job_id = $this->Job_Order_Model->find_job_id_by_job_no($id);

        $this->db->select('*');
        $this->db->from($this->resourcesTable.' as res');
        $this->db->join('customer as cus','res.resources_id = cus.resources_id'); 
        $this->db->join('job_order as job','cus.customer_id = job.customer_id');   
        $this->db->where('job.job_order_id',$job_id);
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
    
    public function form_select_gender_attributes($data)
    {
        $attributes = array(
            'name'          => $data,
            'id'            => $data,
            'class'         => 'selectpicker',
            'data-live-search'  => 'true'
        );

        return $attributes;
    }

    public function form_select_gender_options($data)
    {   
        $arr[] = array(
            '0' => 'select '.str_replace('_', ' ', $data).' here',
        );

        $arr[] = array(
            'Male' => 'Male',
            'Female' => 'Female',
        );

        return call_user_func_array('array_merge', $arr);
    }

    public function form_selected_gender_options($id)
    {   
        $this->db->select('*');
        $this->db->from($this->resourcesTable);  
        $this->db->where($this->resourcesColumn, $id);
        $query = $this->db->get();
        
        if($query->num_rows() > 0)
        {
            foreach ($query->result() as $row) {
                $id = $row->resources_gender;
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
            $this->db->where($this->resourcesColumn, $id);
            $query = $this->db->get($this->resourcesTable);

            foreach ($query->result() as $row) {
                $id = $row->resources_logo;
            }
            return $id;
        } 
        else 
        {             
            return $id = '';
        }
    }

    public function insert($data)
    {
        $this->db->insert($this->resourcesTable, $data);
        return $this->db->insert_id();
    }

    public function modify($data, $id)
    {   
        $this->db->where($this->resourcesColumn, $id);
        $this->db->update($this->resourcesTable, $data);
        return true;
    }

    public function find($id)
    {   
        $this->db->select('*');
        $this->db->from('resources as res');
        $this->db->join('created as cre','res.resources_id = cre.created_table_id');
        $this->db->where('cre.created_table','resources');    
        $this->db->where('res.resources_id', $id);
        $query = $this->db->get();

        foreach ($query->result() as $row) {

            if($row->resources_logo != "")
            {
                $this->db->select('*');
                $this->db->join('resources as res','up.updated_table_id = res.resources_id');
                $this->db->where('up.updated_table','resources');
                $this->db->order_by('updated_id','desc');
                $query1 = $this->db->get('updated as up','1');
                
                if($query1->num_rows() >0)
                {
                    foreach ($query1->result() as $row1) {
                        $arr[] = array(
                            'resources_logo' => $row->resources_logo,
                            'resources_id' => $row->resources_id
                        );
                    }
                }
                else 
                {
                    $arr[] = array(
                        'resources_logo' => $row->resources_logo,
                        'resources_id' => $row->resources_id
                    );
                }
            }
            else
            {
                    $arr[] = array(
                        'resources_logo' => '',
                        'resources_id' => $row->resources_id
                    );
            }

        }

        return $arr;
    }

    public function get_all_resources($start_from=0, $limit=0, $type)
    {  
        $this->db->select('*');
        $this->db->from($this->resourcesTable.' as res');
        $this->db->join('status as stat','res.resources_id = stat.status_table_id');
        $this->db->where('stat.status_table', $this->resourcesTable);  
        $this->db->where('stat.status_code', 1);  
        $this->db->where('res.resources_type_id', $type);
        $this->db->order_by('res.'.$this->resourcesColumn, 'DESC');
        $query = $this->db->limit( $limit, $start_from )->get();
        return $query;
    }

    public function get_alls_resources($type)
    {   
        $this->db->select('*');
        $this->db->from($this->resourcesTable.' as res');
        $this->db->join('status as stat','res.resources_id = stat.status_table_id');
        $this->db->where('stat.status_table', $this->resourcesTable);  
        $this->db->where('stat.status_code', 1);  
        $this->db->where('res.resources_type_id', $type);
        $this->db->order_by('res.'.$this->resourcesColumn, 'DESC');
        $query = $this->db->get();
        return $query;
    }

    public function like_resources($wildcard, $start_from=0, $limit=0, $type)
    {  
        $this->db->select('*');
        $this->db->from($this->resourcesTable.' as res');
        $this->db->join('status as stat','res.resources_id = stat.status_table_id');
        $this->db->join('department as dep','res.department_id = dep.department_id');
        $this->db->join('localmail as loc','res.resources_id = loc.resources_id');
        $this->db->where('stat.status_table', $this->resourcesTable);  
        $this->db->where('stat.status_code', 1);  
        $this->db->where('res.resources_type_id', $type);
        $this->db->group_start();
        $this->db->or_where('res.resources_id LIKE', $wildcard . '%');
        $this->db->or_where('res.resources_firstname LIKE', $wildcard . '%');
        $this->db->or_where('res.resources_lastname LIKE', $wildcard . '%');
        $this->db->or_where('res.resources_gender LIKE', $wildcard . '%');
        $this->db->or_where('dep.department_name LIKE', $wildcard . '%');
        $this->db->or_where('loc.localmail_email LIKE', $wildcard . '%');
        $this->db->group_end();
        $this->db->order_by('res.'.$this->resourcesColumn, 'DESC');
        $query = $this->db->limit( $limit, $start_from )->get();
        return $query;
    }

    public function likes_resources($wildcard, $type)
    {   
        $this->db->select('*');
        $this->db->from($this->resourcesTable.' as res');
        $this->db->join('status as stat','res.resources_id = stat.status_table_id');
        $this->db->join('department as dep','res.department_id = dep.department_id');
        $this->db->join('localmail as loc','res.resources_id = loc.resources_id');
        $this->db->where('stat.status_table', $this->resourcesTable);  
        $this->db->where('stat.status_code', 1);  
        $this->db->where('res.resources_type_id', $type);
        $this->db->group_start();
        $this->db->or_where('res.resources_id LIKE', $wildcard . '%');
        $this->db->or_where('res.resources_firstname LIKE', $wildcard . '%');
        $this->db->or_where('res.resources_lastname LIKE', $wildcard . '%');
        $this->db->or_where('res.resources_gender LIKE', $wildcard . '%');
        $this->db->or_where('dep.department_name LIKE', $wildcard . '%');
        $this->db->or_where('loc.localmail_email LIKE', $wildcard . '%');
        $this->db->group_end();
        $this->db->order_by('res.'.$this->resourcesColumn, 'DESC');
        $query = $this->db->get();
        return $query;
    }

    public function form_select_user_attributes($data)
    {
        $attributes = array(
            'name'          => $data,
            'id'            => $data,
            'class'         => 'selectpicker',
            'data-live-search'  => 'true'
        );

        return $attributes;
    }

    public function form_select_user_options($data)
    {   
        $this->db->select('*');
        $this->db->from($this->resourcesTable.' as res');
        $this->db->join('status as stat','res.resources_id = stat.status_table_id');
        $this->db->where('stat.status_table', $this->resourcesTable);  
        $this->db->where('stat.status_code', 1);  
        $query = $this->db->get();
    
        $arr[] = array(
            '0' => 'select '.str_replace('_', ' ', $data).' here',
        );
        foreach ($query->result() as $row)
        {
            $arr[] = array(
                $row->resources_id => $row->resources_firstname.' '.$row->resources_lastname
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
        $this->db->from($this->resourcesTable.' as res');
        $this->db->join('user as use','res.resources_id = use.resources_id');  
        $this->db->where('use.user_id', $id);
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

    public function get_resources_name_by_id($id)
    {
        $this->db->where($this->resourcesColumn, $id);
        $query = $this->db->get($this->resourcesTable);

        foreach ($query->result() as $row) {
            $id = $row->resources_firstname.' '.$row->resources_lastname;
        }

        return $id;
    }

    public function form_select_assign_estimator_attributes($data)
    {
        $attributes = array(
            'name'          => $data,
            'id'            => $data,
            'class'         => 'selectpicker',
            'data-live-search'  => 'true'
        );

        return $attributes;
    }

    public function form_select_assign_estimator_options($data)
    {   
        $this->db->select('*');
        $this->db->from('resources as res'); 
        $this->db->join('user as use','res.resources_id = use.resources_id');
        $this->db->join('priviledge as priv','use.priviledge_id = priv.priviledge_id');
        $this->db->group_start();
        $this->db->where('priv.priviledge_name','Estimator');
        $this->db->or_where('priv.priviledge_name','Planner - Estimate');
        $this->db->group_end();
        $query = $this->db->get();
        
        $arr[] = array(
            '0' => 'select '.str_replace('_', ' ', $data).' here',
        );

        foreach ($query->result() as $row)
        {
            $arr[] = array(
                $row->resources_id => $row->resources_firstname.' '.$row->resources_lastname
            );
        }

        $array = array();
        foreach($arr as $arrs)
            foreach($arrs as $key => $val)
                $array[$key] = $val;
        return $array;
    }

    public function form_selected_assign_estimator_options($id)
    {   
        $this->db->select('*');
        $this->db->from($this->resourcesTable.' as res');
        $this->db->join('job_request_module_assigned as job','res.resources_id = job.resources_id');    
        $this->db->where('job.job_request_module_assigned_id',$id);
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