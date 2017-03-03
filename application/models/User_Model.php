<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class User_Model extends CI_Model {

    private $userTable = 'user';
    private $userColumn = 'user_id';

    public function __construct()
    {
        parent::__construct();
    }

    public function form_input_attributes($data, $id)
    {
        if(isset($id) && !empty($id))
        {   
            $data_split = explode('_', $data);
            $this->db->where($this->userColumn, $id);
            $query = $this->db->get($this->userTable);

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

    public function form_input_password_attributes($data, $id)
    {
        /*if(isset($id) && !empty($id))
        {   
            $data_split = explode('_', $data);
            $this->db->where($this->userColumn, $id);
            $query = $this->db->get($this->userTable);

            foreach ($query->result() as $row) {
                $value = $row->$data;
            }

            if(count($data_split) > 2)
            {
                $attributes = array(
                    'name'          => $data_split[1].'_'.$data_split[2],
                    'id'            => $data_split[1].'_'.$data_split[2],
                    'type'          => 'password',
                    'value'         => $value,
                    'class'         => 'form-control input-md',
                    'placeholder'   => 'insert '.str_replace('_', ' ', $data_split[1].'_'.$data_split[2]).' here'
                );
            } else {
                $attributes = array(
                    'name'          => $data_split[1],
                    'id'            => $data_split[1],
                    'type'          => 'password',
                    'value'         => $value,
                    'class'         => 'form-control input-md',
                    'placeholder'   => 'insert '.str_replace('_', ' ', $data_split[1]).' here'
                );
            }
        } 
        else {*/
            $data_split = explode('_', $data);
            if(count($data_split) > 2)
            {
                $attributes = array(
                    'name'          => $data_split[1].'_'.$data_split[2],
                    'id'            => $data_split[1].'_'.$data_split[2],
                    'type'          => 'password',
                    'class'         => 'form-control input-md',
                    'placeholder'   => 'insert '.str_replace('_', ' ', $data_split[1].'_'.$data_split[2]).' here'
                );
            } else {
                $attributes = array(
                    'name'          => $data_split[1],
                    'id'            => $data_split[1],
                    'type'          => 'password',
                    'class'         => 'form-control input-md',
                    'placeholder'   => 'insert '.str_replace('_', ' ', $data_split[1]).' here'
                );
            }
                
        //}
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
        $query = $this->db->get($this->userTable);
    
        $arr[] = array(
            '0' => 'select '.str_replace('_', ' ', $data).' here',
        );
        foreach ($query->result() as $row)
        {
            $arr[] = array(
                $row->user_id => $row->user_name
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
        $this->db->from($this->userTable);  
        $this->db->where($this->userColumn, $id);
        $query = $this->db->get();
        
        if($query->num_rows() > 0)
        {
            foreach ($query->result() as $row) {
                $id = $row->user_id;
            }

            return $id;
        }
        else 
        {
            return $id = '0';
        }
    }    

    public function insert($data)
    {
        $this->db->insert($this->userTable, $data);
        return $this->db->insert_id();
    }

    public function modify($data, $id)
    {   
        $this->db->where($this->userColumn, $id);
        $this->db->update($this->userTable, $data);
        return true;
    }

    public function find($id)
    {   
        $this->db->select('*');
        $this->db->from($this->userTable);
        $this->db->where($this->userColumn, $id);
        $query = $this->db->get();

        foreach ($query->result() as $row) {

            $arr[] = array(
                'user_id' => $row->user_id,
                'resources_id' => $row->resources_id,
                'priviledge_id' => $row->priviledge_id,
                'user_username' => $row->user_username,
                //'user_password' => password_verify($row->user_password),
                'user_secret_id' => $row->user_secret_id,
                //'user_secret_password' => $row->user_secret_password
            );

        }

        return $arr;
    }

    public function get_all_user($start_from=0, $limit=0)
    {  
        $this->db->select('*');
        $this->db->from($this->userTable.' as use');
        $this->db->join('status as stat','use.user_id = stat.status_table_id');
        $this->db->where('stat.status_table', $this->userTable);  
        $this->db->where('stat.status_code', 1);  
        $this->db->order_by('use.'.$this->userColumn, 'DESC');
        $query = $this->db->limit( $limit, $start_from )->get();
        return $query;
    }

    public function get_alls_user()
    {   
        $this->db->select('*');
        $this->db->from($this->userTable.' as use');
        $this->db->join('status as stat','use.user_id = stat.status_table_id');
        $this->db->where('stat.status_table', $this->userTable);  
        $this->db->where('stat.status_code', 1);  
        $this->db->order_by('use.'.$this->userColumn, 'DESC');
        $query = $this->db->get();
        return $query;
    }

    public function like_user($wildcard='', $start_from=0, $limit=0)
    {
        $this->db->select('*');
        $this->db->from($this->userTable.' as use');
        $this->db->join('status as stat','use.user_id = stat.status_table_id');
        $this->db->join('resources as res','use.resources_id = res.resources_id');
        $this->db->join('priviledge as priv','use.priviledge_id = priv.priviledge_id');
        $this->db->join('user_secret as sec','use.user_secret_id = sec.user_secret_id');
        $this->db->where('stat.status_table', $this->userTable);  
        $this->db->where('stat.status_code', 1);  
        $this->db->group_start();
        $this->db->or_where('use.user_id LIKE', $wildcard . '%');
        $this->db->or_where('res.resources_firstname LIKE', '%'. $wildcard . '%');
        $this->db->or_where('res.resources_lastname LIKE', '%'. $wildcard . '%');
        $this->db->or_where('priv.priviledge_name LIKE', '%'. $wildcard . '%');
        $this->db->or_where('use.user_username LIKE', '%'. $wildcard . '%');
        $this->db->or_where('sec.user_secret_question LIKE', '%'. $wildcard . '%');
        $this->db->group_end();
        $this->db->order_by('use.'.$this->userColumn, 'DESC');
        $query = $this->db->limit( $limit, $start_from )->get();
        return $query;
    }

    public function likes_user($wildcard='')
    {
        $this->db->select('*');
        $this->db->from($this->userTable.' as use');
        $this->db->join('status as stat','use.user_id = stat.status_table_id');
        $this->db->join('resources as res','use.resources_id = res.resources_id');
        $this->db->join('priviledge as priv','use.priviledge_id = priv.priviledge_id');
        $this->db->join('user_secret as sec','use.user_secret_id = sec.user_secret_id');
        $this->db->where('stat.status_table', $this->userTable);  
        $this->db->where('stat.status_code', 1);  
        $this->db->group_start();
        $this->db->or_where('use.user_id LIKE', $wildcard . '%');
        $this->db->or_where('res.resources_firstname LIKE', '%'. $wildcard . '%');
        $this->db->or_where('res.resources_lastname LIKE', '%'. $wildcard . '%');
        $this->db->or_where('priv.priviledge_name LIKE', '%'. $wildcard . '%');
        $this->db->or_where('use.user_username LIKE', '%'. $wildcard . '%');
        $this->db->or_where('sec.user_secret_question LIKE', '%'. $wildcard . '%');
        $this->db->group_end(); 
        $this->db->order_by('use.'.$this->userColumn, 'DESC');
        $query = $this->db->get();
        return $query;
    }

    public function get_all_archived_user($start_from=0, $limit=0)
    {  
        $this->db->select('*');
        $this->db->from($this->userTable.' as use');
        $this->db->join('status as stat','use.user_id = stat.status_table_id');
        $this->db->where('stat.status_table', $this->userTable);  
        $this->db->where('stat.status_code', 0);  
        $this->db->order_by('use.'.$this->userColumn, 'DESC');
        $query = $this->db->limit( $limit, $start_from )->get();
        return $query;
    }

    public function get_alls_archived_user()
    {   
        $this->db->select('*');
        $this->db->from($this->userTable.' as use');
        $this->db->join('status as stat','use.user_id = stat.status_table_id');
        $this->db->where('stat.status_table', $this->userTable);  
        $this->db->where('stat.status_code', 0);  
        $this->db->order_by('use.'.$this->userColumn, 'DESC');
        $query = $this->db->get();
        return $query;
    }

    public function like_archived_user($wildcard='', $start_from=0, $limit=0)
    {
        $this->db->select('*');
        $this->db->from($this->userTable.' as use');
        $this->db->join('status as stat','use.user_id = stat.status_table_id');
        $this->db->join('resources as res','use.resources_id = res.resources_id');
        $this->db->join('priviledge as priv','use.priviledge_id = priv.priviledge_id');
        $this->db->join('user_secret as sec','use.user_secret_id = sec.user_secret_id');
        $this->db->where('stat.status_table', $this->userTable);  
        $this->db->where('stat.status_code', 0);  
        $this->db->group_start();
        $this->db->or_where('use.user_id LIKE', $wildcard . '%');
        $this->db->or_where('res.resources_firstname LIKE', '%'. $wildcard . '%');
        $this->db->or_where('res.resources_lastname LIKE', '%'. $wildcard . '%');
        $this->db->or_where('priv.priviledge_name LIKE', '%'. $wildcard . '%');
        $this->db->or_where('use.user_username LIKE', '%'. $wildcard . '%');
        $this->db->or_where('sec.user_secret_question LIKE', '%'. $wildcard . '%');
        $this->db->group_end();
        $this->db->order_by('use.'.$this->userColumn, 'DESC');
        $query = $this->db->limit( $limit, $start_from )->get();
        return $query;
    }

    public function likes_archived_user($wildcard='')
    {
        $this->db->select('*');
        $this->db->from($this->userTable.' as use');
        $this->db->join('status as stat','use.user_id = stat.status_table_id');
        $this->db->join('resources as res','use.resources_id = res.resources_id');
        $this->db->join('priviledge as priv','use.priviledge_id = priv.priviledge_id');
        $this->db->join('user_secret as sec','use.user_secret_id = sec.user_secret_id');
        $this->db->where('stat.status_table', $this->userTable);  
        $this->db->where('stat.status_code', 0);  
        $this->db->group_start();
        $this->db->or_where('use.user_id LIKE', $wildcard . '%');
        $this->db->or_where('res.resources_firstname LIKE', '%'. $wildcard . '%');
        $this->db->or_where('res.resources_lastname LIKE', '%'. $wildcard . '%');
        $this->db->or_where('priv.priviledge_name LIKE', '%'. $wildcard . '%');
        $this->db->or_where('use.user_username LIKE', '%'. $wildcard . '%');
        $this->db->or_where('sec.user_secret_question LIKE', '%'. $wildcard . '%');
        $this->db->group_end(); 
        $this->db->order_by('use.'.$this->userColumn, 'DESC');
        $query = $this->db->get();
        return $query;
    }

    public function check($username, $password)
    {   
        $query = $this->db->where('user_username', $username)->get($this->userTable);

        if($query->num_rows() == 1 && ($row = $query->row()) ) {

            if( password_verify($password, $row->user_password) ) {
                $data = array(
                    'resources_id' => $row->resources_id,
                    'priviledge_id' => $row->priviledge_id,
                    'user_id' => $row->user_id,
                    'user_username' => $row->user_username,
                    'validated' => true,
                );
                $this->session->set_userdata($data);
                $this->session->unset_userdata('login');
                return true;
            }
        }

        return false;
    }
}