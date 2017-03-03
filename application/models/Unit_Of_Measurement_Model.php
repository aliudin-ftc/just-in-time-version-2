<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Unit_Of_Measurement_Model extends CI_Model {

    private $unit_of_measurementTable = 'unit_of_measurement';
    private $unit_of_measurementColumn = 'unit_of_measurement_id';

    public function __construct()
    {
        parent::__construct();
    }

    public function form_input_attributes($data, $id)
    {   
        if(isset($id) && !empty($id))
        {   
            $this->db->where($this->unit_of_measurementColumn, $id);
            $query = $this->db->get($this->unit_of_measurementTable);

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
            $this->db->where($this->unit_of_measurementColumn, $id);
            $query = $this->db->get($this->unit_of_measurementTable);

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
            $this->db->where($this->unit_of_measurementColumn, $id);
            $query = $this->db->get($this->unit_of_measurementTable);

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

    public function form_select_options($data)
    {   
        $query = $this->db->get($this->unit_of_measurementTable);
    
        $arr[] = array(
            '0' => 'select '.str_replace('_', ' ', $data).' here',
        );
        foreach ($query->result() as $row)
        {
            $arr[] = array(
                $row->unit_of_measurement_id => $row->unit_of_measurement_code
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
        $this->db->from($this->unit_of_measurementTable);  
        $this->db->where($this->unit_of_measurementColumn, $id);
        $query = $this->db->get();
        
        if($query->num_rows() > 0)
        {
            foreach ($query->result() as $row) {
                $id = $row->unit_of_measurement_id;
            }

            return $id;
        }
        else 
        {
            return $id = '0';
        }
    }       

    public function form_selected_brand_options($id)
    {   
        $this->db->select('*');
        $this->db->from($this->unit_of_measurementTable.' as dep');
        $this->db->join('brand as bra','dep.unit_of_measurement_id = bra.unit_of_measurement_id');
        $this->db->where('bra.brand_id', $id);
        $query = $this->db->get();
        
        if($query->num_rows() > 0)
        {
            foreach ($query->result() as $row) {
                $id = $row->unit_of_measurement_id;
            }

            return $id;
        }
        else 
        {
            return $id = '0';
        }
    }    

    public function form_selected_powder_plastic_coat_options($id)
    {   
        $this->db->select('*');
        $this->db->from($this->unit_of_measurementTable.' as unit');
        $this->db->join('powder_plastic_coat as ppc','unit.unit_of_measurement_id = ppc.unit_of_measurement_id');
        $this->db->where('ppc.powder_plastic_coat_id', $id);
        $query = $this->db->get();
        
        if($query->num_rows() > 0)
        {
            foreach ($query->result() as $row) {
                $id = $row->unit_of_measurement_id;
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
            $this->db->where($this->unit_of_measurementColumn, $id);
            $query = $this->db->get($this->unit_of_measurementTable);

            foreach ($query->result() as $row) {
                $id = $row->unit_of_measurement_logo;
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
        $this->db->from('unit_of_measurement as unit');
        $this->db->join('created as cre','unit.unit_of_measurement_id = cre.created_table_id');
        $this->db->where('cre.created_table','unit_of_measurement');    
        $this->db->where('unit.unit_of_measurement_id', $id);
        $query = $this->db->get();

        foreach ($query->result() as $row) {

            $arr[] = array(
                'unit_of_measurement_id' => $row->unit_of_measurement_id,
                'unit_of_measurement_code' => $row->unit_of_measurement_code,
                'unit_of_measurement_name' => $row->unit_of_measurement_name,
                'unit_of_measurement_description' => $row->unit_of_measurement_description
            );

        }

        return $arr;
    }

    public function insert($data)
    {
        $this->db->insert($this->unit_of_measurementTable, $data);
        return $this->db->insert_id();
    }

    public function modify($data, $id)
    {   
        $this->db->where($this->unit_of_measurementColumn, $id);
        $this->db->update($this->unit_of_measurementTable, $data);
        return true;
    }

    public function get_all_unit_of_measurement($start_from=0, $limit=0)
    {  
        $this->db->select('*');
        $this->db->from($this->unit_of_measurementTable.' as dep');
        $this->db->join('status as stat','dep.unit_of_measurement_id = stat.status_table_id');
        $this->db->where('stat.status_table', $this->unit_of_measurementTable);  
        $this->db->where('stat.status_code', 1);  
        $this->db->order_by('dep.'.$this->unit_of_measurementColumn, 'DESC');
        $query = $this->db->limit( $limit, $start_from )->get();
        return $query;
    }

    public function get_alls_unit_of_measurement()
    {   
        $this->db->select('*');
        $this->db->from($this->unit_of_measurementTable.' as dep');
        $this->db->join('status as stat','dep.unit_of_measurement_id = stat.status_table_id');
        $this->db->where('stat.status_table', $this->unit_of_measurementTable);  
        $this->db->where('stat.status_code', 1);
        $this->db->order_by('dep.'.$this->unit_of_measurementColumn, 'DESC');
        $query = $this->db->get();
        return $query;
    }

    public function like_unit_of_measurement($wildcard='', $start_from=0, $limit=0)
    {
        $this->db->select('*');
        $this->db->from($this->unit_of_measurementTable.' as unit');
        $this->db->join('status as stat','unit.unit_of_measurement_id = stat.status_table_id');
        $this->db->where('stat.status_table', $this->unit_of_measurementTable);  
        $this->db->where('stat.status_code', 1);  
        $this->db->group_start();
        $this->db->or_where('unit.unit_of_measurement_id LIKE', '%' . $wildcard . '%');
        $this->db->or_where('unit.unit_of_measurement_code LIKE', '%' . $wildcard . '%');
        $this->db->or_where('unit.unit_of_measurement_name LIKE', '%' . $wildcard . '%');
        $this->db->or_where('unit.unit_of_measurement_description LIKE', '%' . $wildcard . '%');
        $this->db->group_end();
        $this->db->order_by('unit.'.$this->unit_of_measurementColumn, 'DESC');
        $query = $this->db->limit( $limit, $start_from )->get();
        return $query;     
    }

    public function likes_unit_of_measurement($wildcard='')
    {
        $this->db->select('*');
        $this->db->from($this->unit_of_measurementTable.' as unit');
        $this->db->join('status as stat','unit.unit_of_measurement_id = stat.status_table_id');
        $this->db->where('stat.status_table', $this->unit_of_measurementTable);  
        $this->db->where('stat.status_code', 1);  
        $this->db->group_start();
        $this->db->or_where('unit.unit_of_measurement_id LIKE', '%' . $wildcard . '%');
        $this->db->or_where('unit.unit_of_measurement_code LIKE', '%' . $wildcard . '%');
        $this->db->or_where('unit.unit_of_measurement_name LIKE', '%' . $wildcard . '%');
        $this->db->or_where('unit.unit_of_measurement_description LIKE', '%' . $wildcard . '%');
        $this->db->group_end();
        $this->db->order_by('unit.'.$this->unit_of_measurementColumn, 'DESC');
        $query = $this->db->get();
        return $query;     
    }

    public function get_all_archived_unit_of_measurement($start_from=0, $limit=0)
    {  
        $this->db->select('*');
        $this->db->from($this->unit_of_measurementTable.' as dep');
        $this->db->join('status as stat','dep.unit_of_measurement_id = stat.status_table_id');
        $this->db->where('stat.status_table', $this->unit_of_measurementTable);  
        $this->db->where('stat.status_code', 0);  
        $this->db->order_by('dep.'.$this->unit_of_measurementColumn, 'DESC');
        $query = $this->db->limit( $limit, $start_from )->get();
        return $query;
    }

    public function get_alls_archived_unit_of_measurement()
    {   
        $this->db->select('*');
        $this->db->from($this->unit_of_measurementTable.' as dep');
        $this->db->join('status as stat','dep.unit_of_measurement_id = stat.status_table_id');
        $this->db->where('stat.status_table', $this->unit_of_measurementTable);  
        $this->db->where('stat.status_code', 0);
        $this->db->order_by('dep.'.$this->unit_of_measurementColumn, 'DESC');
        $query = $this->db->get();
        return $query;
    }

    public function like_archived_unit_of_measurement($wildcard='', $start_from=0, $limit=0)
    {
        $this->db->select('*');
        $this->db->from($this->unit_of_measurementTable.' as unit');
        $this->db->join('status as stat','unit.unit_of_measurement_id = stat.status_table_id');
        $this->db->where('stat.status_table', $this->unit_of_measurementTable);  
        $this->db->where('stat.status_code', 0);  
        $this->db->group_start();
        $this->db->or_where('unit.unit_of_measurement_id LIKE', '%' . $wildcard . '%');
        $this->db->or_where('unit.unit_of_measurement_code LIKE', '%' . $wildcard . '%');
        $this->db->or_where('unit.unit_of_measurement_name LIKE', '%' . $wildcard . '%');
        $this->db->or_where('unit.unit_of_measurement_description LIKE', '%' . $wildcard . '%');
        $this->db->group_end();
        $this->db->order_by('unit.'.$this->unit_of_measurementColumn, 'DESC');
        $query = $this->db->limit( $limit, $start_from )->get();
        return $query;  
    }

    public function likes_archived_unit_of_measurement($wildcard='')
    {
        $this->db->select('*');
        $this->db->from($this->unit_of_measurementTable.' as unit');
        $this->db->join('status as stat','unit.unit_of_measurement_id = stat.status_table_id');
        $this->db->where('stat.status_table', $this->unit_of_measurementTable);  
        $this->db->where('stat.status_code', 0);  
        $this->db->group_start();
        $this->db->or_where('unit.unit_of_measurement_id LIKE', '%' . $wildcard . '%');
        $this->db->or_where('unit.unit_of_measurement_code LIKE', '%' . $wildcard . '%');
        $this->db->or_where('unit.unit_of_measurement_name LIKE', '%' . $wildcard . '%');
        $this->db->or_where('unit.unit_of_measurement_description LIKE', '%' . $wildcard . '%');
        $this->db->group_end();
        $this->db->order_by('unit.'.$this->unit_of_measurementColumn, 'DESC');
        $query = $this->db->get();
        return $query;  
    }

    public function get_unit_of_measurement_code_by_id($id)
    {   
        $this->db->where($this->unit_of_measurementColumn, $id);
        $query = $this->db->get($this->unit_of_measurementTable);

        foreach($query->result() as $row)
        {
            $id = $row->unit_of_measurement_code;
        }

        return $id;
    }

    public function get_unit_of_measurement_name_by_id($id)
    {   
        $this->db->where($this->unit_of_measurementColumn, $id);
        $query = $this->db->get($this->unit_of_measurementTable);

        foreach($query->result() as $row)
        {
            $id = $row->unit_of_measurement_name;
        }

        return $id;
    }

    public function form_select_jo_attributes($data)
    {
        $attributes = array(
            'name'          => $data,
            'id'            => $data,
            'class'         => 'selectpicker',
            'data-live-search'  => 'true'
        );

        return $attributes;
    }

    public function form_select_jo_options($data)
    {   
        $query = $this->db->get($this->unit_of_measurementTable);
    
        $arr[] = array(
            '0' => 'select '.str_replace('_', ' ', $data).' here',
        );
        foreach ($query->result() as $row)
        {
            $arr[] = array(
                $row->unit_of_measurement_id => $row->unit_of_measurement_description
            );
        }
        
        $array = array();
        foreach($arr as $arrs)
            foreach($arrs as $key => $val)
                $array[$key] = $val;
        return $array;
    }   
    
    public function form_selected_jo_options($id)
    {   
        $this->db->select('*');
        $this->db->from('unit_of_measurement as unit');
        $this->db->join('job_order as job','unit.unit_of_measurement_id = job.unit_of_measurement_id');
        $this->db->where('job.job_order_no', $id);
        $query = $this->db->get();
        
        if($query->num_rows() > 0)
        {
            foreach ($query->result() as $row) {
                $id = $row->unit_of_measurement_id;
            }
            return $id;
        }
        else 
        {
            return $id = '0';
        }
    }

    public function get_uom_name_by_id($id)
    {   
        $this->db->where($this->unit_of_measurementColumn, $id);
        $query = $this->db->get($this->unit_of_measurementTable);

        foreach($query->result() as $row)
        {
            $id = $row->unit_of_measurement_name;
        }

        return $id;
    }

}