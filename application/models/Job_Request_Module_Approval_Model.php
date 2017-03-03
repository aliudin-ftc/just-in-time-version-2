<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Job_Request_Module_Approval_Model extends CI_Model {

    private $job_request_module_approvalTable = 'job_request_module_approval';
    private $job_request_module_approvalColumn = 'job_request_module_approval_id';

    public function __construct()
    {
        parent::__construct();
    }
    
    public function insert($data)
    {
        $this->db->insert($this->job_request_module_approvalTable, $data);
        return $this->db->insert_id();
    }

    public function find_approval_date_by_id($id)
    {
        $this->db->where('job_request_module_id', $id);
        $query = $this->db->get($this->job_request_module_approvalTable);
        
        foreach ($query->result() as $row) {
            $id = date("d-M-Y",strtotime($row->job_request_module_approval_datetime)).'<br/>'.date("h:i A",strtotime($row->job_request_module_approval_datetime));
        }

        return $id;
    }

    public function search_approve_mine_job_request($mod_id, $res_id)
    {
        $this->db->where('job_request_module_id', $mod_id);
        $this->db->where('resources_id', $res_id);
        $query = $this->db->get($this->job_request_module_approvalTable);
        if($query->num_rows() > 0)
        {
            return $mod_id = 'true';
        }
        else {
            return $mod_id = 'false';
        }
    }

    public function search_all_approval_for_job_request($id)
    {
        $this->db->where('job_request_module_id', $id);
        $query = $this->db->get($this->job_request_module_approvalTable);
            
        $approve = '';
        if($query->num_rows() > 0)
        {
            foreach ($query->result() as $row) {
                $approve .= $this->Resources_Model->get_resources_name_by_id($row->resources_id).' <br/>';
            }
        }

        return $approve;
    }

    public function form_textarea_jobrequest_attributes($data, $id)
    {   
        if(isset($id) && !empty($id))
        {   
            $this->db->where('job_request_module_id', $id);
            $query = $this->db->get($this->job_request_module_approvalTable);

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
}