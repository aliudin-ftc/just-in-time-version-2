<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Job_Element_Model extends CI_Model {

    private $job_elementTable = 'job_elements';
    private $job_elementColumn = 'job_elements_id';

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
        $query = $this->db->get($this->job_elementTable);
        
        $arr[] = array(
            '0' => 'select '.str_replace('_', ' ', $data).' here',
        );

        foreach ($query->result() as $row)
        {
            $arr[] = array(
                $row->job_element_id => $row->job_element_name
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
        $this->db->from($this->job_elementTable.' as job_element');
        $this->db->join('job_order as job','job_element.job_element_id = job.job_element_id');    
        $this->db->where('job.job_order_id',$id);
        $query = $this->db->get();
        
        if($query->num_rows() > 0)
        {
            foreach ($query->result() as $row) {
                $id = $row->job_element_id;
            }

            return $id;
        }
        else 
        {
            return $id = '0';
        }
    }  

    public function form_input_job_element_no_attributes($data, $id)
    {
        if(isset($id) && !empty($id))
        {   
            $this->db->where($this->job_elementColumn, $id);
            $query = $this->db->get($this->job_elementTable);

            foreach ($query->result() as $row) {
                $value = $row->$data;
            }

            $attributes = array(
                'name'          => $data,
                'id'            => $data,
                'type'          => 'text',
                'value'         => $value,
                'class'         => 'form-control input-md',
                'disabled'      => 'disabled',
                'placeholder'   => 'insert '.str_replace('_', ' ', $data).' here'
            );
        } 
        else {
            $attributes = array(
                'name'          => $data,
                'id'            => $data,
                'type'          => 'text',
                'class'         => 'form-control input-md',
                'disabled'      => 'disabled',
                'placeholder'   => '**********'
            );
        }
        return $attributes;
    }

    public function form_input_job_element_attributes($data, $id)
    {   
        if(isset($id) && !empty($id))
        {   
            $this->db->where($this->job_elementColumn, $id);
            $query = $this->db->get($this->job_elementTable);

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

    public function form_input_numeric_job_element_attributes($data, $id)
    {   
        if(isset($id) && !empty($id))
        {   
            $this->db->where($this->job_elementColumn, $id);
            $query = $this->db->get($this->job_elementTable);

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

    public function form_selected_job_element_options($data, $id)
    {   
        if(isset($id) && !empty($id))
        {   
            $this->db->select('*');
            $this->db->from('job_elements as job');
            $this->db->join('unit_of_measurement as unit', 'job.'.$data.' = unit.unit_of_measurement_id');
            $this->db->where('job.job_elements_id', $id);
            $query = $this->db->get();
            
            if($query->num_rows() > 0)
            {
                foreach ($query->result() as $row) {
                    $id = $row->$data;
                }

                return $id;
            }
            else 
            {
                return $id = '0';
            }
        }
    } 

    public function form_textarea_job_element_attributes($data, $id)
    {   
        if(isset($id) && !empty($id))
        {   
            $this->db->where($this->job_elementColumn, $id);
            $query = $this->db->get($this->job_elementTable);

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

    public function insert($data)
    {
        $this->db->insert($this->job_elementTable, $data);
        return $this->db->insert_id();
    }

    public function modify($data, $id)
    {   
        $this->db->where($this->job_elementColumn, $id);
        $this->db->update($this->job_elementTable, $data);
        return true;
    }

    public function get_all_attach_job_element($start_from=0, $limit=0, $job_req_mod_id)
    {  
        $this->db->select('*');
        $this->db->from($this->job_elementTable.' as job');
        $this->db->join('status as stat','job.job_elements_id = stat.status_table_id');
        $this->db->where('stat.status_table', $this->job_elementTable);  
        $this->db->where('stat.status_code', 1);  
        $this->db->where('job.job_request_module_id', $job_req_mod_id);
        $this->db->order_by($this->job_elementColumn, 'DESC');
        $query = $this->db->limit( $limit, $start_from )->get();
        return $query;
    }

    public function get_alls_attach_job_element($job_req_mod_id)
    {   
        $this->db->select('*');
        $this->db->from($this->job_elementTable.' as job');
        $this->db->join('status as stat','job.job_elements_id = stat.status_table_id');
        $this->db->where('stat.status_table', $this->job_elementTable);  
        $this->db->where('stat.status_code', 1);  
        $this->db->where('job.job_request_module_id', $job_req_mod_id);
        $this->db->order_by($this->job_elementColumn, 'DESC');
        $query = $this->db->get();
        return $query;
    }

    public function like_attach_job_element($wildcard='', $start_from=0, $limit=0, $job_req_mod_id)
    {
        $this->db->select('*');
        $this->db->from($this->job_elementTable);
        $this->db->order_by($this->job_elementColumn, 'DESC');
        $query = $this->db->limit( $limit, $start_from )->get();
        return $query;
    }

    public function likes_attach_job_element($wildcard='', $job_req_mod_id)
    {
        $this->db->select('*');
        $this->db->from($this->job_elementTable);
        $this->db->order_by($this->job_elementColumn, 'DESC');
        $query = $this->db->get();
        return $query;
    }

    public function get_all_available_job_element($start_from=0, $limit=0, $req_id, $job_order_id)
    {  
        $this->db->select('*');
        $this->db->from($this->job_elementTable.' as job');
        $this->db->join('job_order as jo','job.job_order_id = jo.job_order_id');
        $this->db->join('status as stat','job.job_elements_id = stat.status_table_id');
        $this->db->where('stat.status_table', $this->job_elementTable);  
        $this->db->where('stat.status_code', 1);  
        $this->db->group_start();
        $this->db->where('job.job_request_module_id', NULL);
        $this->db->or_where('job.job_request_module_id', 0);
        $this->db->group_end();
        $this->db->where('jo.job_order_id', $job_order_id);
        $this->db->order_by($this->job_elementColumn, 'DESC');
        $query = $this->db->limit( $limit, $start_from )->get();
        return $query;
    }

    public function get_alls_available_job_element($req_id, $job_order_id)
    {   
        $this->db->select('*');
        $this->db->from($this->job_elementTable.' as job');
        $this->db->join('job_order as jo','job.job_order_id = jo.job_order_id');
        $this->db->join('status as stat','job.job_elements_id = stat.status_table_id');
        $this->db->where('stat.status_table', $this->job_elementTable);  
        $this->db->group_start();
        $this->db->where('job.job_request_module_id', NULL);
        $this->db->or_where('job.job_request_module_id', 0);
        $this->db->group_end();
        $this->db->where('jo.job_order_id', $job_order_id);
        $this->db->order_by($this->job_elementColumn, 'DESC');
        $query = $this->db->get();
        return $query;
    }

    public function like_available_job_element($wildcard='', $start_from=0, $limit=0, $req_id, $job_order_id)
    {
        $this->db->select('*');
        $this->db->from($this->job_elementTable);
        $this->db->order_by($this->job_elementColumn, 'DESC');
        $query = $this->db->limit( $limit, $start_from )->get();
        return $query;
    }

    public function likes_available_job_element($wildcard='', $req_id, $job_order_id)
    {
        $this->db->select('*');
        $this->db->from($this->job_elementTable);
        $this->db->order_by($this->job_elementColumn, 'DESC');
        $query = $this->db->get();
        return $query;
    }

    public function get_all_job_element($start_from=0, $limit=0, $job_order_id)
    {  
        $this->db->select('*');
        $this->db->from($this->job_elementTable.' as job');
        $this->db->join('status as stat','job.job_elements_id = stat.status_table_id');
        $this->db->where('stat.status_table', $this->job_elementTable);  
        $this->db->where('stat.status_code', 1);  
        $this->db->where('job.job_order_id', $job_order_id);
        $this->db->order_by($this->job_elementColumn, 'DESC');
        $query = $this->db->limit( $limit, $start_from )->get();
        return $query;
    }

    public function get_alls_job_element($job_order_id)
    {   
        $this->db->select('*');
        $this->db->from($this->job_elementTable.' as job');
        $this->db->join('status as stat','job.job_elements_id = stat.status_table_id');
        $this->db->where('stat.status_table', $this->job_elementTable);  
        $this->db->where('stat.status_code', 1);  
        $this->db->where('job.job_order_id', $job_order_id);
        $this->db->order_by($this->job_elementColumn, 'DESC');
        $query = $this->db->get();
        return $query;
    }

    public function like_job_element($wildcard='', $start_from=0, $limit=0)
    {
        $this->db->select('*');
        $this->db->from($this->job_elementTable);
        $this->db->order_by($this->job_elementColumn, 'DESC');
        $query = $this->db->limit( $limit, $start_from )->get();
        return $query;
    }

    public function likes_job_element($wildcard='')
    {
        $this->db->select('*');
        $this->db->from($this->job_elementTable);
        $this->db->order_by($this->job_elementColumn, 'DESC');
        $query = $this->db->get();
        return $query;
    }

    public function get_all_archived_job_element($start_from=0, $limit=0, $job_order_id)
    {  
        $this->db->select('*');
        $this->db->from($this->job_elementTable.' as job');
        $this->db->join('status as stat','job.job_elements_id = stat.status_table_id');
        $this->db->where('stat.status_table', $this->job_elementTable);  
        $this->db->where('stat.status_code', 0);  
        $this->db->where('job.job_order_id', $job_order_id);
        $this->db->order_by($this->job_elementColumn, 'DESC');
        $query = $this->db->limit( $limit, $start_from )->get();
        return $query;
    }

    public function get_alls_archived_job_element($job_order_id)
    {   
        $this->db->select('*');
        $this->db->from($this->job_elementTable.' as job');
        $this->db->join('status as stat','job.job_elements_id = stat.status_table_id');
        $this->db->where('stat.status_table', $this->job_elementTable);  
        $this->db->where('stat.status_code', 0);  
        $this->db->where('job.job_order_id', $job_order_id);
        $this->db->order_by($this->job_elementColumn, 'DESC');
        $query = $this->db->get();
        return $query;
    }

    public function like_archived_job_element($wildcard='', $start_from=0, $limit=0)
    {
        $this->db->select('*');
        $this->db->from($this->job_elementTable);
        $this->db->order_by($this->job_elementColumn, 'DESC');
        $query = $this->db->limit( $limit, $start_from )->get();
        return $query;
    }

    public function likes_archived_job_element($wildcard='')
    {
        $this->db->select('*');
        $this->db->from($this->job_elementTable);
        $this->db->order_by($this->job_elementColumn, 'DESC');
        $query = $this->db->get();
        return $query;
    }

    public function direct_materials_powder_cost_element($start_from=0, $limit=0, $elem_id)
    {  
        $this->db->select('diri.direct_materials_item_id, diri.powder_plastic_coat_id, diri.max_coated_volume_id, diri.direct_materials_item_sq_in_unit, diri.direct_materials_item_costs');
        $this->db->from('cost_estimate as cost');
        $this->db->join('dir_mat_est_cost_est as dir','cost.cost_estimate_id = dir.cost_estimate_id');
        $this->db->join('direct_materials_estimate as dirm','dir.direct_materials_estimate_id = dirm.direct_materials_estimate_id');
        $this->db->join('direct_materials_item as diri','dirm.direct_materials_estimate_id = diri.direct_materials_estimate_id');
        $this->db->join('status as stat','diri.direct_materials_item_id = stat.status_table_id');
        $this->db->where('cost.job_elements_id', $elem_id);  
        $this->db->where('stat.status_table', 'direct_materials_item');  
        $this->db->where('stat.status_code', 1);  
        $this->db->order_by('diri.direct_materials_item_id', 'DESC');
        $query = $this->db->limit( $limit, $start_from )->get();
        return $query;
    }

    public function direct_materials_powder_cost_elements($elem_id)
    {   
        $this->db->select('diri.direct_materials_item_id, diri.powder_plastic_coat_id, diri.max_coated_volume_id, diri.direct_materials_item_sq_in_unit, diri.direct_materials_item_costs');
        $this->db->from('cost_estimate as cost');
        $this->db->join('dir_mat_est_cost_est as dir','cost.cost_estimate_id = dir.cost_estimate_id');
        $this->db->join('direct_materials_estimate as dirm','dir.direct_materials_estimate_id = dirm.direct_materials_estimate_id');
        $this->db->join('direct_materials_item as diri','dirm.direct_materials_estimate_id = diri.direct_materials_estimate_id');
        $this->db->join('status as stat','diri.direct_materials_item_id = stat.status_table_id');
        $this->db->where('cost.job_elements_id', $elem_id);  
        $this->db->where('stat.status_table', 'direct_materials_item');  
        $this->db->where('stat.status_code', 1);  
        $this->db->order_by('diri.direct_materials_item_id', 'DESC');
        $query = $this->db->get();
        return $query;
    }

}