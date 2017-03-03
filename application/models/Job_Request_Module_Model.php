<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Job_Request_Module_Model extends CI_Model {

    private $job_request_moduleTable = 'job_request_module';
    private $job_request_moduleColumn = 'job_request_module_id';

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

    public function form_input_numeric_job_request_attributes($data, $id)
    {   
        if(isset($id) && !empty($id))
        {   
            $this->db->where($this->job_request_moduleColumn, $id);
            $query = $this->db->get($this->job_request_moduleTable);

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
                'value'         => $id,
                'type'          => 'text',
                'class'         => 'form-control input-md numeric',
                'placeholder'   => 'insert '.str_replace('_', ' ', $data).' here'
            );
        }
        return $attributes;
    }

    public function form_input_numeric_attach_job_elem_job_request_attributes($data, $id)
    {   
        if(isset($id) && !empty($id))
        {   
            $this->db->where($this->job_request_moduleColumn, $id);
            $query = $this->db->get($this->job_request_moduleTable);

            foreach ($query->result() as $row) {
                $value = $row->$data;
            }

            $attributes = array(
                'name'          => $data,
                'id'            => $data,
                'type'          => 'text',
                'value'         => $value,
                'disabled'      => 'disabled',
                'class'         => 'form-control input-md numeric',
                'placeholder'   => 'insert '.str_replace('_', ' ', $data).' here'
            );
        } 
        else {
            $attributes = array(
                'name'          => $data,
                'id'            => $data,
                'value'         => $id,
                'type'          => 'text',
                'disabled'      => 'disabled',
                'class'         => 'form-control input-md numeric',
                'placeholder'   => 'insert '.str_replace('_', ' ', $data).' here'
            );
        }
        return $attributes;
    }

    public function form_textarea_job_request_attributes($data, $id)
    {   
        if(isset($id) && !empty($id))
        {   
            $this->db->where($this->job_request_moduleColumn, $id);
            $query = $this->db->get($this->job_request_moduleTable);

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

    public function form_textarea_attach_job_elem_job_request_attributes($data, $id)
    {   
        if(isset($id) && !empty($id))
        {   
            $this->db->where($this->job_request_moduleColumn, $id);
            $query = $this->db->get($this->job_request_moduleTable);

            foreach ($query->result() as $row) {
                $value = $row->$data;
            }

            $attributes = array(
                'name'          => $data,
                'id'            => $data,
                'rows'          => '5',
                'value'         => $value,
                'disabled'      => 'disabled',
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
                'disabled'      => 'disabled',
                'class'         => 'auto-size form-control',
                'placeholder'   => 'insert '.str_replace('_', ' ', $data).' here'
            );
        }
        return $attributes;        
    }

    public function form_input_date_job_request_attributes($data, $id)
    {   
        if(isset($id) && !empty($id))
        {
            $this->db->where($this->job_request_moduleColumn, $id);
            $query = $this->db->get($this->job_request_moduleTable);

            foreach ($query->result() as $row) {
                $value = $row->$data;
            }

            $attributes = array(
                'name'          => $data,
                'id'            => $data,
                'type'          => 'text',
                'value'         => date("d-M-Y",strtotime($value)),
                'class'         => 'form-control date-picker',
                'placeholder'   => 'insert '.str_replace('_', ' ', $data).' here'
            );
        } 
        else 
        {
            $attributes = array(
                'name'          => $data,
                'id'            => $data,
                'type'          => 'text',
                'class'         => 'form-control date-picker',
                'placeholder'   => 'insert '.str_replace('_', ' ', $data).' here'
            );
        }

        return $attributes;
    }

    public function form_input_date_attach_job_elem_job_request_attributes($data, $id)
    {   
        if(isset($id) && !empty($id))
        {
            $this->db->where($this->job_request_moduleColumn, $id);
            $query = $this->db->get($this->job_request_moduleTable);

            foreach ($query->result() as $row) {
                $value = $row->$data;
            }

            $attributes = array(
                'name'          => $data,
                'id'            => $data,
                'type'          => 'text',
                'disabled'      => 'disabled',
                'value'         => date("d-M-Y",strtotime($value)),
                'class'         => 'form-control',
                'placeholder'   => 'insert '.str_replace('_', ' ', $data).' here'
            );
        } 
        else 
        {
            $attributes = array(
                'name'          => $data,
                'id'            => $data,
                'type'          => 'text',
                'disabled'      => 'disabled',
                'class'         => 'form-control input-md',
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

    public function form_select_options($data)
    {   
        $query = $this->db->get($this->job_request_moduleTable);
        
        $arr[] = array(
            '0' => 'select '.str_replace('_', ' ', $data).' here',
        );

        foreach ($query->result() as $row)
        {
            $arr[] = array(
                $row->job_request_module_id => $row->job_request_module_name
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
        $this->db->from($this->job_request_moduleTable.' as job_request_module');
        $this->db->join('job_order as job','job_request_module.job_request_module_id = job.job_request_module_id');    
        $this->db->where('job.job_order_id',$id);
        $query = $this->db->get();
        
        if($query->num_rows() > 0)
        {
            foreach ($query->result() as $row) {
                $id = $row->job_request_module_id;
            }

            return $id;
        }
        else 
        {
            return $id = '0';
        }
    }    

    public function form_selected_job_request_module_options($id)
    {   
        $this->db->where($this->job_request_moduleColumn, $id);
        $query = $this->db->get($this->job_request_moduleTable);
        
        if($query->num_rows() > 0)
        {
            foreach ($query->result() as $row) {
                $id = $row->job_request_module_id;
            }

            return $id;
        }
        else 
        {
            return $id = '0';
        }
    }   

    public function check_sequence($id, $module, $job)
    {   
        $job_id = $this->Job_Order_Model->find_job_order_id($job);
        $this->db->where('job_request_module_id !=', $module);
        $this->db->where('job_request_type_id', $id);
        $this->db->where('job_order_id', $job_id);
        $query = $this->db->get($this->job_request_moduleTable);

        return ($query->num_rows() + 1);
    }

    public function find_sequence_by_id($id)
    {
        $this->db->where($this->job_request_moduleColumn, $id);
        $query = $this->db->get($this->job_request_moduleTable);

        foreach ($query->result() as $row) {
            $id = $row->job_request_module_sequence;
        }

        return $id;
    }

    public function insert($data)
    {
        $this->db->insert($this->job_request_moduleTable, $data);
        return $this->db->insert_id();
    }

    public function modify($data, $id)
    {   
        $this->db->where($this->job_request_moduleColumn, $id);
        $this->db->update($this->job_request_moduleTable, $data);
        return true;
    }

    public function get_all_job_request($start_from=0, $limit=0, $job_order_id)
    {  
        $this->db->select('*');
        $this->db->from($this->job_request_moduleTable.' as job');
        $this->db->join('status as stat','job.job_request_module_id = stat.status_table_id');
        $this->db->where('stat.status_table', $this->job_request_moduleTable);  
        $this->db->where('stat.status_code', 1);  
        $this->db->where('job.job_order_id', $job_order_id);
        $this->db->order_by($this->job_request_moduleColumn, 'DESC');
        $query = $this->db->limit( $limit, $start_from )->get();
        return $query;
    }

    public function get_alls_job_request($job_order_id)
    {   
        $this->db->select('*');
        $this->db->from($this->job_request_moduleTable.' as job');
        $this->db->join('status as stat','job.job_request_module_id = stat.status_table_id');
        $this->db->where('stat.status_table', $this->job_request_moduleTable);  
        $this->db->where('stat.status_code', 1);  
        $this->db->where('job.job_order_id', $job_order_id);
        $this->db->order_by($this->job_request_moduleColumn, 'DESC');
        $query = $this->db->get();
        return $query;
    }

    public function like_job_request($wildcard='', $start_from=0, $limit=0, $job_order_id)
    {
        $this->db->select('*');
        $this->db->from($this->job_request_moduleTable);
        $this->db->where('job_order_id', $job_order_id);
        $this->db->order_by($this->job_request_moduleColumn, 'DESC');
        $query = $this->db->limit( $limit, $start_from )->get();
        return $query;
    }

    public function likes_job_request($wildcard='', $job_order_id)
    {
        $this->db->select('*');
        $this->db->from($this->job_request_moduleTable);
        $this->db->where('job_order_id', $job_order_id);
        $this->db->order_by($this->job_request_moduleColumn, 'DESC');
        $query = $this->db->get();
        return $query;
    }

    public function get_all_archived_job_request($start_from=0, $limit=0, $job_order_id)
    {  
        $this->db->select('*');
        $this->db->from($this->job_request_moduleTable.' as job');
        $this->db->join('status as stat','job.job_request_module_id = stat.status_table_id');
        $this->db->where('stat.status_table', $this->job_request_moduleTable);  
        $this->db->where('stat.status_code', 0);  
        $this->db->where('job.job_order_id', $job_order_id);
        $this->db->order_by($this->job_request_moduleColumn, 'DESC');
        $query = $this->db->limit( $limit, $start_from )->get();
        return $query;
    }

    public function get_alls_archived_job_request($job_order_id)
    {   
        $this->db->select('*');
        $this->db->from($this->job_request_moduleTable.' as job');
        $this->db->join('status as stat','job.job_request_module_id = stat.status_table_id');
        $this->db->where('stat.status_table', $this->job_request_moduleTable);  
        $this->db->where('stat.status_code', 0);  
        $this->db->where('job.job_order_id', $job_order_id);
        $this->db->order_by($this->job_request_moduleColumn, 'DESC');
        $query = $this->db->get();
        return $query;
    }

    public function like_job_archived_request($wildcard='', $start_from=0, $limit=0, $job_order_id)
    {
        $this->db->select('*');
        $this->db->from($this->job_request_moduleTable);
        $this->db->where('job_order_id', $job_order_id);
        $this->db->order_by($this->job_request_moduleColumn, 'DESC');
        $query = $this->db->limit( $limit, $start_from )->get();
        return $query;
    }

    public function likes_job_archived_request($wildcard='', $job_order_id)
    {
        $this->db->select('*');
        $this->db->from($this->job_request_moduleTable);
        $this->db->where('job_order_id', $job_order_id);
        $this->db->order_by($this->job_request_moduleColumn, 'DESC');
        $query = $this->db->get();
        return $query;
    }

    public function get_all_job_estimate_planner($start_from=0, $limit=0, $priv_id)
    {   
        $priv_id = 27;
        $this->db->select('*');
        $this->db->from($this->job_request_moduleTable.' as job');
        $this->db->join('status as stat','job.job_request_module_id = stat.status_table_id');
        $this->db->join('job_request as job_req','job.job_request_id = job_req.job_request_id');
        $this->db->join('job_request_type as job_req_type','job.job_request_type_id = job_req_type.job_request_type_id');
        $this->db->join('job_order as jo','job.job_order_id = jo.job_order_id');
        $this->db->where('stat.status_table', $this->job_request_moduleTable);  
        $this->db->where('stat.status_code', 1);  
        $this->db->where('job_req.job_request_name','Estimate');
        $this->db->where('job_req_type.job_request_type_name','Estimate');
        $this->db->where('job.job_request_module_approval','approved');
        $this->db->order_by('job.'.$this->job_request_moduleColumn, 'DESC');
        $query = $this->db->limit( $limit, $start_from )->get();
        return $query;
    }

    public function get_alls_job_estimate_planner($priv_id)
    {   
        $priv_id = 27;
        $this->db->select('*');
        $this->db->from($this->job_request_moduleTable.' as job');
        $this->db->join('status as stat','job.job_request_module_id = stat.status_table_id');
        $this->db->join('job_request as job_req','job.job_request_id = job_req.job_request_id');
        $this->db->join('job_request_type as job_req_type','job.job_request_type_id = job_req_type.job_request_type_id');
        $this->db->join('job_order as jo','job.job_order_id = jo.job_order_id');
        $this->db->where('stat.status_table', $this->job_request_moduleTable);  
        $this->db->where('stat.status_code', 1);  
        $this->db->where('job_req.job_request_name','Estimate');
        $this->db->where('job_req_type.job_request_type_name','Estimate');
        $this->db->where('job.job_request_module_approval','approved');
        $this->db->order_by('job.'.$this->job_request_moduleColumn, 'DESC');
        $query = $this->db->get();
        return $query;
    }

    public function get_all_job_estimate_cost($start_from=0, $limit=0, $user_id)
    {   
        $user_id = 42;
        $this->db->select('*');
        $this->db->from($this->job_request_moduleTable.' as job');
        $this->db->join('job_request_module_assigned as job_as','job.job_request_module_id = job_as.job_request_module_id');
        $this->db->join('status as stat','job.job_request_module_id = stat.status_table_id');
        $this->db->join('job_request as job_req','job.job_request_id = job_req.job_request_id');
        $this->db->join('job_request_type as job_req_type','job.job_request_type_id = job_req_type.job_request_type_id');
        $this->db->join('job_order as jo','job.job_order_id = jo.job_order_id');
        $this->db->where('stat.status_table', $this->job_request_moduleTable);  
        $this->db->where('stat.status_code', 1);  
        $this->db->where('job_req.job_request_name','Estimate');
        $this->db->where('job_req_type.job_request_type_name','Estimate');
        $this->db->where('job.job_request_module_approval','approved');
        $this->db->where('job_as.resources_id', $user_id);
        $this->db->order_by('job.'.$this->job_request_moduleColumn, 'DESC');
        $query = $this->db->limit( $limit, $start_from )->get();
        return $query;
    }

    public function get_alls_job_estimate_cost($user_id)
    {   
        $user_id = 42;
        $this->db->select('*');
        $this->db->from($this->job_request_moduleTable.' as job');        
        $this->db->join('job_request_module_assigned as job_as','job.job_request_module_id = job_as.job_request_module_id');
        $this->db->join('status as stat','job.job_request_module_id = stat.status_table_id');
        $this->db->join('job_request as job_req','job.job_request_id = job_req.job_request_id');
        $this->db->join('job_request_type as job_req_type','job.job_request_type_id = job_req_type.job_request_type_id');
        $this->db->join('job_order as jo','job.job_order_id = jo.job_order_id');
        $this->db->where('stat.status_table', $this->job_request_moduleTable);  
        $this->db->where('stat.status_code', 1);  
        $this->db->where('job_req.job_request_name','Estimate');
        $this->db->where('job_req_type.job_request_type_name','Estimate');
        $this->db->where('job.job_request_module_approval','approved');
        $this->db->where('job_as.resources_id', $user_id);
        $this->db->order_by('job.'.$this->job_request_moduleColumn, 'DESC');
        $query = $this->db->get();
        return $query;
    }

    public function get_all_approval($start_from=0, $limit=0, $priv_id)
    {   
        
        $priv_id = 31;

        $this->db->where('priviledge_id', $priv_id);
        $query = $this->db->get('job_request_module_role');
        $arr = array();
        foreach ($query->result() as $row) {
            $this->db->select('job.job_request_module_id');
            $this->db->from($this->job_request_moduleTable.' as job');
            $this->db->join('status as stat','job.job_request_module_id = stat.status_table_id');
            $this->db->join('job_request as job_req','job.job_request_id = job_req.job_request_id');
            $this->db->join('job_request_type as job_req_type','job.job_request_type_id = job_req_type.job_request_type_id');
            $this->db->join('job_order as jo','job.job_order_id = jo.job_order_id');
            $this->db->join('job_order_po as po','jo.job_order_id = po.job_order_id');
            $this->db->join('customer as cus','jo.customer_id = cus.customer_id');
            $this->db->where('stat.status_table', $this->job_request_moduleTable);  
            $this->db->where('stat.status_code', 1);
            $this->db->where('cus.tier_id', $row->tier_id);

            if($row->job_request_id == 2 && $row->job_request_id == 3 && $row->job_request_id == 4 && $row->job_request_id == 5)
            { 
                if($row->sequence == 6){
                    $this->db->where('job.job_request_module_sequence >=', $row->sequence);
                } else {
                    $this->db->where('job.job_request_module_sequence', $row->sequence);
                }

                $this->db->where('job.job_request_id', $row->job_request_id);
            } 
            else if($row->job_request_id == 7)
            {
                $this->db->where('job.job_request_module_sequence >=', $row->sequence);
                $this->db->where('job.job_request_id', $row->job_request_id);
            } 
            else if($row->job_request_id == 6)
            {   
                if($row->sequence == 1){
                    $this->db->where('po.job_order_po_no !=', NULL);
                    $this->db->where('job.job_request_module_sequence >=', $row->sequence);
                    $this->db->where('job.job_request_id', $row->job_request_id);
                } else if($row->sequence == 2 && $row->sequence == 3) {
                    $this->db->where('job.job_request_module_sequence', $row->sequence);
                    $this->db->where('job.job_request_id', $row->job_request_id);
                } else {
                    $this->db->where('job.job_request_module_sequence >=', $row->sequence);
                    $this->db->where('job.job_request_id', $row->job_request_id);
                }
            }

            $this->db->group_start();
            $this->db->where('job.job_request_module_status_id', 2);
            $this->db->or_where('job.job_request_module_status_id', 3);
            $this->db->group_end();
            $this->db->order_by('job.'.$this->job_request_moduleColumn, 'DESC');
            $query1 = $this->db->get();
            foreach ($query1->result() as $row1)
            {
                $arr[] = $row1->job_request_module_id;
            }
        }


        $this->db->select('job.job_request_module_id, jo.job_order_id, job.job_request_id, job.job_request_module_approval, job.job_request_type_id, job.job_request_module_sequence, job_stat.resources_id');
        $this->db->from($this->job_request_moduleTable.' as job');
        $this->db->join('job_request as job_req','job.job_request_id = job_req.job_request_id');
        $this->db->join('job_request_type as job_req_type','job.job_request_type_id = job_req_type.job_request_type_id');
        $this->db->join('job_order as jo','job.job_order_id = jo.job_order_id');
        $this->db->join('job_request_module_status_sent as job_stat','job.job_request_module_id = job_stat.job_request_module_id');
        if(!empty($arr))
            $this->db->where_in('job.'.$this->job_request_moduleColumn, $arr);
        else 
            $this->db->where('job.'.$this->job_request_moduleColumn, 0);
        $this->db->order_by('job.'.$this->job_request_moduleColumn, 'DESC');
        $query2 = $this->db->limit( $limit, $start_from )->get();

        return $query2;
    }

    public function get_alls_approval($priv_id)
    {   
        $priv_id = 31;

        $this->db->where('priviledge_id', $priv_id);
        $query = $this->db->get('job_request_module_role');
        $arr = array();
        foreach ($query->result() as $row) {
            $this->db->select('job.job_request_module_id');
            $this->db->from($this->job_request_moduleTable.' as job');
            $this->db->join('status as stat','job.job_request_module_id = stat.status_table_id');
            $this->db->join('job_request as job_req','job.job_request_id = job_req.job_request_id');
            $this->db->join('job_request_type as job_req_type','job.job_request_type_id = job_req_type.job_request_type_id');
            $this->db->join('job_order as jo','job.job_order_id = jo.job_order_id');
            $this->db->join('job_order_po as po','jo.job_order_id = po.job_order_id');
            $this->db->join('customer as cus','jo.customer_id = cus.customer_id');
            $this->db->where('stat.status_table', $this->job_request_moduleTable);  
            $this->db->where('stat.status_code', 1);
            $this->db->where('cus.tier_id', $row->tier_id);

            if($row->job_request_id == 2 && $row->job_request_id == 3 && $row->job_request_id == 4 && $row->job_request_id == 5)
            { 
                if($row->sequence == 6){
                    $this->db->where('job.job_request_module_sequence >=', $row->sequence);
                } else {
                    $this->db->where('job.job_request_module_sequence', $row->sequence);
                }

                $this->db->where('job.job_request_id', $row->job_request_id);
            } 
            else if($row->job_request_id == 7)
            {
                $this->db->where('job.job_request_module_sequence >=', $row->sequence);
                $this->db->where('job.job_request_id', $row->job_request_id);
            } 
            else if($row->job_request_id == 6)
            {   
                if($row->sequence == 1){
                    $this->db->where('po.job_order_po_no !=', NULL);
                    $this->db->where('job.job_request_module_sequence >=', $row->sequence);
                    $this->db->where('job.job_request_id', $row->job_request_id);
                } else if($row->sequence == 2 && $row->sequence == 3) {
                    $this->db->where('job.job_request_module_sequence', $row->sequence);
                    $this->db->where('job.job_request_id', $row->job_request_id);
                } else {
                    $this->db->where('job.job_request_module_sequence >=', $row->sequence);
                    $this->db->where('job.job_request_id', $row->job_request_id);
                }
            }

            $this->db->group_start();
            $this->db->where('job.job_request_module_status_id', 2);
            $this->db->or_where('job.job_request_module_status_id', 3);
            $this->db->group_end();
            $this->db->order_by('job.'.$this->job_request_moduleColumn, 'DESC');
            $query1 = $this->db->get();
            foreach ($query1->result() as $row1)
            {
                $arr[] = $row1->job_request_module_id;
            }
        }


        $this->db->select('job.job_request_module_id, jo.job_order_id, job.job_request_id, job.job_request_module_approval, job.job_request_type_id, job.job_request_module_sequence, job_stat.resources_id');
        $this->db->from($this->job_request_moduleTable.' as job');
        $this->db->join('job_request as job_req','job.job_request_id = job_req.job_request_id');
        $this->db->join('job_request_type as job_req_type','job.job_request_type_id = job_req_type.job_request_type_id');
        $this->db->join('job_order as jo','job.job_order_id = jo.job_order_id');
        $this->db->join('job_request_module_status_sent as job_stat','job.job_request_module_id = job_stat.job_request_module_id');
        if(!empty($arr))
            $this->db->where_in('job.'.$this->job_request_moduleColumn, $arr);
        else 
            $this->db->where('job.'.$this->job_request_moduleColumn, 0);
        $this->db->order_by('job.'.$this->job_request_moduleColumn, 'DESC');
        $query2 = $this->db->get();

        return $query2;
    }

    public function form_input_numeric_view_jobrequest_attributes($data, $id)
    {   
        if(isset($id) && !empty($id))
        {   
            $this->db->where($this->job_request_moduleColumn, $id);
            $query = $this->db->get($this->job_request_moduleTable);

            foreach ($query->result() as $row) {
                $value = $row->$data;
            }

            $attributes = array(
                'name'          => $data,
                'id'            => $data,
                'type'          => 'text',
                'value'         => $value,
                'disabled'      => 'disabled',
                'class'         => 'form-control input-md numeric',
                'placeholder'   => 'insert '.str_replace('_', ' ', $data).' here'
            );
        } 
        else {
            $attributes = array(
                'name'          => $data,
                'id'            => $data,
                'value'         => $id,
                'type'          => 'text',
                'class'         => 'form-control input-md numeric',
                'placeholder'   => 'insert '.str_replace('_', ' ', $data).' here'
            );
        }
        return $attributes;
    }

    public function form_input_date_view_jobrequest_attributes($data, $id)
    {   
        if(isset($id) && !empty($id))
        {
            $this->db->where($this->job_request_moduleColumn, $id);
            $query = $this->db->get($this->job_request_moduleTable);

            foreach ($query->result() as $row) {
                $value = $row->$data;
            }

            $attributes = array(
                'name'          => $data,
                'id'            => $data,
                'type'          => 'text',
                'disabled'      => 'disabled',
                'value'         => date("d-M-Y",strtotime($value)),
                'class'         => 'form-control date-picker',
                'placeholder'   => 'insert '.str_replace('_', ' ', $data).' here'
            );
        } 
        else 
        {
            $attributes = array(
                'name'          => $data,
                'id'            => $data,
                'type'          => 'text',
                'class'         => 'form-control date-picker',
                'placeholder'   => 'insert '.str_replace('_', ' ', $data).' here'
            );
        }

        return $attributes;
    }

    public function form_textarea_view_jobrequest_attributes($data, $id)
    {   
        if(isset($id) && !empty($id))
        {   
            $this->db->where($this->job_request_moduleColumn, $id);
            $query = $this->db->get($this->job_request_moduleTable);

            foreach ($query->result() as $row) {
                $value = $row->$data;
            }

            $attributes = array(
                'name'          => $data,
                'id'            => $data,
                'rows'          => '5',
                'value'         => $value,
                'disabled'      => 'disabled',
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
}