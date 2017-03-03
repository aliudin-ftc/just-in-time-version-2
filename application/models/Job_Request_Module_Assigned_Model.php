<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Job_Request_Module_Assigned_Model extends CI_Model {

    private $job_request_module_assignedTable = 'job_request_module_assigned';
    private $job_request_module_assignedColumn = 'job_request_module_assigned_id';

    public function __construct()
    {
        parent::__construct();
    }
    
    public function insert($data)
    {
        $this->db->insert($this->job_request_module_assignedTable, $data);
        return $this->db->insert_id();
    }

    public function get_assigned_job_request($id)
    {
        $this->db->where('job_request_module_id', $id);
        $query = $this->db->get($this->job_request_module_assignedTable);

        if($query->num_rows() > 0)
        {
            foreach ($query->result() as $row) {
                $id = $row->resources_id;
            }
            return $id;
        }
        else
        {
            return $id = '';
        }

        
    }

    public function form_input_assign_estimator_attributes($data, $id)
    {   
        if(isset($id) && !empty($id))
        {   
            $this->db->where($this->job_request_module_assignedColumn, $id);
            $query = $this->db->get($this->job_request_module_assignedTable);

            foreach ($query->result() as $row) {
                $value = $row->$data;
            }

            $attributes = array(
                'name'          => $data,
                'id'            => $data,
                'type'          => 'text',
                'value'         => $value,
                'class'         => 'form-control input-md date-time-picker',
                'placeholder'   => 'insert '.str_replace('_', ' ', $data).' here'
            );
        } 
        else {
            $attributes = array(
                'name'          => $data,
                'id'            => $data,
                'type'          => 'text',
                'class'         => 'form-control input-md date-time-picker',
                'placeholder'   => 'insert date and time here'
            );
        }
        return $attributes;
    }

    public function form_textarea_assign_estimator_attributes($data, $id)
    {   
        if(isset($id) && !empty($id))
        {   
            $this->db->where($this->job_request_module_assignedColumn, $id);
            $query = $this->db->get($this->job_request_module_assignedTable);

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
                'placeholder'   => 'insert remarks here'
            );
        }
        return $attributes;        
    }
}