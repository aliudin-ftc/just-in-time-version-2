<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Priviledge_Model extends CI_Model {

    private $priviledgeTable = 'priviledge';
    private $priviledgeColumn = 'priviledge_id';

    public function __construct()
    {
        parent::__construct();
    }
    
    public function get_priviledge_modules($id)
    {   
        $this->db->select('*');
        $this->db->from('priviledge_modules as pri_mod');
        $this->db->join('priviledge as pri','pri_mod.priviledge_id = pri.priviledge_id');
        $this->db->where('pri_mod.priviledge_id', $id);
        $this->db->order_by('priviledge_order', 'ASC');
        $query = $this->db->get();
        return $query->result();
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
        $this->db->from($this->priviledgeTable.' as priv');
        $this->db->join('status as stat','priv.priviledge_id = stat.status_table_id');
        $this->db->where('stat.status_table', $this->priviledgeTable);  
        $this->db->where('stat.status_code', 1);
        $query = $this->db->get();
    
        $arr[] = array(
            '0' => 'select '.str_replace('_', ' ', $data).' here',
        );
        foreach ($query->result() as $row)
        {
            $arr[] = array(
                $row->priviledge_id => $row->priviledge_name
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
        $this->db->from($this->priviledgeTable.' as priv');
        $this->db->join('user as use','priv.priviledge_id = use.priviledge_id');  
        $this->db->where('use.user_id', $id);
        $query = $this->db->get();
        
        if($query->num_rows() > 0)
        {
            foreach ($query->result() as $row) {
                $id = $row->priviledge_id;
            }

            return $id;
        }
        else 
        {
            return $id = '0';
        }
    }    

    public function get_priviledge_name_by_id($id)
    {
        $this->db->where($this->priviledgeColumn, $id);
        $query = $this->db->get($this->priviledgeTable);

        foreach ($query->result() as $row) {
            $id = $row->priviledge_name;
        }

        return $id;
    }

    public function get_priviledge_id_by_resources_id($id)
    {
        $this->db->where($this->priviledgeColumn, $id);
        $query = $this->db->get($this->priviledgeTable);

        foreach ($query->result() as $row) {
            $id = $row->priviledge_name;
        }

        return $id;
    }

    public function get_all_priviledge($start_from=0, $limit=0)
    {  
        $this->db->select('*');
        $this->db->from($this->priviledgeTable.' as priv');
        $this->db->join('status as stat','priv.priviledge_id = stat.status_table_id');
        $this->db->where('stat.status_table', $this->priviledgeTable);  
        $this->db->where('stat.status_code', 1);  
        $this->db->order_by('priv.'.$this->priviledgeColumn, 'DESC');
        $query = $this->db->limit( $limit, $start_from )->get();
        return $query;
    }

    public function get_alls_priviledge()
    {   
        $this->db->select('*');
        $this->db->from($this->priviledgeTable.' as priv');
        $this->db->join('status as stat','priv.priviledge_id = stat.status_table_id');
        $this->db->where('stat.status_table', $this->priviledgeTable);  
        $this->db->where('stat.status_code', 1);  
        $this->db->order_by('priv.'.$this->priviledgeColumn, 'DESC');
        $query = $this->db->get();
        return $query;
    }

    public function like_priviledge($wildcard='', $start_from=0, $limit=0)
    {
        $this->db->select('*');
        $this->db->from($this->priviledgeTable.' as priv');
        $this->db->join('status as stat','priv.priviledge_id = stat.status_table_id');
        $this->db->where('stat.status_table', $this->priviledgeTable);  
        $this->db->where('stat.status_code', 1); 
        $this->db->group_start();
        $this->db->or_where('priv.priviledge_id LIKE', $wildcard . '%');
        $this->db->or_where('priv.priviledge_code LIKE', '%'. $wildcard . '%');
        $this->db->or_where('priv.priviledge_name LIKE', '%'. $wildcard . '%');
        $this->db->or_where('priv.priviledge_description LIKE', '%'. $wildcard . '%');
        $this->db->group_end();
        $this->db->order_by('priv.'.$this->priviledgeColumn, 'DESC');
        $query = $this->db->limit( $limit, $start_from )->get();
        return $query;
    }

    public function likes_priviledge($wildcard='')
    {
        $this->db->select('*');
        $this->db->from($this->priviledgeTable.' as priv');
        $this->db->join('status as stat','priv.priviledge_id = stat.status_table_id');
        $this->db->where('stat.status_table', $this->priviledgeTable);  
        $this->db->where('stat.status_code', 1); 
        $this->db->group_start();
        $this->db->or_where('priv.priviledge_id LIKE', $wildcard . '%');
        $this->db->or_where('priv.priviledge_code LIKE', '%'. $wildcard . '%');
        $this->db->or_where('priv.priviledge_name LIKE', '%'. $wildcard . '%');
        $this->db->or_where('priv.priviledge_description LIKE', '%'. $wildcard . '%');
        $this->db->group_end();
        $this->db->order_by('priv.'.$this->priviledgeColumn, 'DESC');
        $query = $this->db->get();
        return $query;
    }

    public function get_all_archived_priviledge($start_from=0, $limit=0)
    {  
        $this->db->select('*');
        $this->db->from($this->priviledgeTable.' as priv');
        $this->db->join('status as stat','priv.priviledge_id = stat.status_table_id');
        $this->db->where('stat.status_table', $this->priviledgeTable);  
        $this->db->where('stat.status_code', 0);  
        $this->db->order_by('priv.'.$this->priviledgeColumn, 'DESC');
        $query = $this->db->limit( $limit, $start_from )->get();
        return $query;
    }

    public function get_alls_archived_priviledge()
    {   
        $this->db->select('*');
        $this->db->from($this->priviledgeTable.' as priv');
        $this->db->join('status as stat','priv.priviledge_id = stat.status_table_id');
        $this->db->where('stat.status_table', $this->priviledgeTable);  
        $this->db->where('stat.status_code', 0);  
        $this->db->order_by('priv.'.$this->priviledgeColumn, 'DESC');
        $query = $this->db->get();
        return $query;
    }

    public function like_archived_priviledge($wildcard='', $start_from=0, $limit=0)
    {
        $this->db->select('*');
        $this->db->from($this->priviledgeTable.' as priv');
        $this->db->join('status as stat','priv.priviledge_id = stat.status_table_id');
        $this->db->where('stat.status_table', $this->priviledgeTable);  
        $this->db->where('stat.status_code', 0); 
        $this->db->group_start();
        $this->db->or_where('priv.priviledge_id LIKE', $wildcard . '%');
        $this->db->or_where('priv.priviledge_code LIKE', '%'. $wildcard . '%');
        $this->db->or_where('priv.priviledge_name LIKE', '%'. $wildcard . '%');
        $this->db->or_where('priv.priviledge_description LIKE', '%'. $wildcard . '%');
        $this->db->group_end();
        $this->db->order_by('priv.'.$this->priviledgeColumn, 'DESC');
        $query = $this->db->limit( $limit, $start_from )->get();
        return $query;
    }

    public function likes_archived_priviledge($wildcard='')
    {
        $this->db->select('*');
        $this->db->from($this->priviledgeTable.' as priv');
        $this->db->join('status as stat','priv.priviledge_id = stat.status_table_id');
        $this->db->where('stat.status_table', $this->priviledgeTable);  
        $this->db->where('stat.status_code', 0); 
        $this->db->group_start();
        $this->db->or_where('priv.priviledge_id LIKE', $wildcard . '%');
        $this->db->or_where('priv.priviledge_code LIKE', '%'. $wildcard . '%');
        $this->db->or_where('priv.priviledge_name LIKE', '%'. $wildcard . '%');
        $this->db->or_where('priv.priviledge_description LIKE', '%'. $wildcard . '%');
        $this->db->group_end();
        $this->db->order_by('priv.'.$this->priviledgeColumn, 'DESC');
        $query = $this->db->get();
        return $query;
    }

    public function form_input_attributes($data, $id)
    {
        if(isset($id) && !empty($id))
        {   
            $data_split = explode('_', $data);
            $this->db->where($this->priviledgeColumn, $id);
            $query = $this->db->get($this->priviledgeTable);

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

    public function priviledge_modules($id)
    {
        $this->db->order_by('modules_order', 'ASC');
        $query = $this->db->get('modules');


        $arr = array();
        foreach ($query->result() as $row) {
            
            $this->db->where('priviledge_id', $id);
            $this->db->where('modules_id', $row->modules_id);
            $queryPriv = $this->db->get('priviledge_modules');    

            if($queryPriv->num_rows() > 0)
            {
                $arr[$row->modules_id] = array(
                    'modules_id' => $row->modules_id,
                    'modules_name' => $row->modules_name,
                    'checked' => '1'
                );
            } 
            else 
            {
                $arr[$row->modules_id] = array(
                    'modules_id' => $row->modules_id,
                    'modules_name' => $row->modules_name,
                    'checked' => '0'
                );
            }

            $this->db->select('*');
            $this->db->from('modules_sub_modules');
            $this->db->where('modules_id', $row->modules_id);
            $this->db->where('priviledge_id', 1);
            $query1 = $this->db->get();

            foreach ($query1->result() as $row1) {

                $this->db->where('priviledge_id', $id);
                $this->db->where('modules_id', $row->modules_id);
                $this->db->where('sub_modules_id', $row1->sub_modules_id);
                $queryMod = $this->db->get('modules_sub_modules');

                if($queryMod->num_rows() > 0)
                {
                    $arr[$row->modules_id]['modules'][] = array(
                        'sub_modules_id' => $row1->sub_modules_id,
                        'sub_modules_name' => $this->Modules_Model->get_sub_modules_name_by_id($row1->sub_modules_id),
                        'checked' => '1'
                    );
                }
                else
                {
                    $arr[$row->modules_id]['modules'][] = array(
                        'sub_modules_id' => $row1->sub_modules_id,
                        'sub_modules_name' => $this->Modules_Model->get_sub_modules_name_by_id($row1->sub_modules_id),
                        'checked' => '0'
                    );
                }                
            }

        }

        return $arr;
    }

    public function insert($data)
    {
        $this->db->insert($this->priviledgeTable, $data);
        return $this->db->insert_id();
    }

    public function modify($data, $id)
    {   
        $this->db->where($this->priviledgeColumn, $id);
        $this->db->update($this->priviledgeTable, $data);
        return true;
    }
}