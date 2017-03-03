<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Powder_Plastic_Coat_Model extends CI_Model {

    private $powder_plastic_coatTable = 'powder_plastic_coat';
    private $powder_plastic_coatColumn = 'powder_plastic_coat_id';

    public function __construct()
    {
        parent::__construct();
    }

    public function form_input_attributes($data, $id)
    {   
        if(isset($id) && !empty($id))
        {   
            $data_split = explode('_', $data);
            $this->db->where($this->powder_plastic_coatColumn, $id);
            $query = $this->db->get($this->powder_plastic_coatTable);

            foreach ($query->result() as $row) {
                $value = $row->$data;
            }

            if(count($data_split) > 2)
            {
                $attributes = array(
                    'name'          => $data_split[3],
                    'id'            => $data_split[3],
                    'type'          => 'text',
                    'value'         => $value,
                    'class'         => 'form-control input-md',
                    'placeholder'   => 'insert '.str_replace('_', ' ', $data).' here'
                );
            } else {
                $attributes = array(
                    'name'          => $data_split[3],
                    'id'            => $data_split[3],
                    'type'          => 'text',
                    'value'         => $value,
                    'class'         => 'form-control input-md',
                    'placeholder'   => 'insert '.str_replace('_', ' ', $data).' here'
                );
            }
        } 
        else {
            $data_split = explode('_', $data);
            if(count($data_split) > 2)
            {
                $attributes = array(
                    'name'          => $data_split[3],
                    'id'            => $data_split[3],
                    'type'          => 'text',
                    'class'         => 'form-control input-md',
                    'placeholder'   => 'insert '.str_replace('_', ' ', $data_split[3]).' here'
                );
            } else {
                $attributes = array(
                    'name'          => $data_split[3],
                    'id'            => $data_split[3],
                    'type'          => 'text',
                    'class'         => 'form-control input-md',
                    'placeholder'   => 'insert '.str_replace('_', ' ', $data_split[3]).' here'
                );
            }
                
        }
        return $attributes;
    }

    public function form_textarea_attributes($data, $id)
    {   
        if(isset($id) && !empty($id))
        {   
            $this->db->where($this->powder_plastic_coatColumn, $id);
            $query = $this->db->get($this->powder_plastic_coatTable);

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
            $data_split = explode('_', $data);
            $this->db->where($this->powder_plastic_coatColumn, $id);
            $query = $this->db->get($this->powder_plastic_coatTable);

            foreach ($query->result() as $row) {
                $value = $row->$data;
            }

            if(count($data_split) > 2)
            {
                $attributes = array(
                    'name'          => $data_split[3].'_'.$data_split[4],
                    'id'            => $data_split[3].'_'.$data_split[4],
                    'type'          => 'text',
                    'value'         => $value,
                    'class'         => 'form-control input-md numeric',
                    'placeholder'   => 'insert '.str_replace('_', ' ', $data_split[3].' '.$data_split[4]).' here'
                );
            } else {
                $attributes = array(
                    'name'          => $data_split[3].'_'.$data_split[4],
                    'id'            => $data_split[3].'_'.$data_split[4],
                    'type'          => 'text',
                    'value'         => $value,
                    'class'         => 'form-control input-md numeric',
                    'placeholder'   => 'insert '.str_replace('_', ' ', $data_split[3].' '.$data_split[4]).' here'
                );
            }
        } 
        else {
            $data_split = explode('_', $data);
            if(count($data_split) > 2)
            {
                $attributes = array(
                    'name'          => $data_split[3].'_'.$data_split[4],
                    'id'            => $data_split[3].'_'.$data_split[4],
                    'type'          => 'text',
                    'class'         => 'form-control input-md numeric',
                    'placeholder'   => 'insert '.str_replace('_', ' ', $data_split[3].' '.$data_split[4]).' here'
                );
            } else {
                $attributes = array(
                    'name'          => $data_split[3].'_'.$data_split[4],
                    'id'            => $data_split[3].'_'.$data_split[4],
                    'type'          => 'text',
                    'class'         => 'form-control input-md numeric',
                    'placeholder'   => 'insert '.str_replace('_', ' ', $data_split[3].' '.$data_split[4]).' here'
                );
            }
                
        }
        return $attributes;
    }


    public function find($id)
    {   
        $this->db->select('*');
        $this->db->from('powder_plastic_coat as dep');
        $this->db->join('created as cre','dep.powder_plastic_coat_id = cre.created_table_id');
        $this->db->where('cre.created_table','powder_plastic_coat');    
        $this->db->where('dep.powder_plastic_coat_id', $id);
        $query = $this->db->get();

        foreach ($query->result() as $row) {

            $arr[] = array(
                'powder_plastic_coat_id' => $row->powder_plastic_coat_id,
                'powder_plastic_coat_code' => $row->powder_plastic_coat_code,
                'derpartment_name' => $row->powder_plastic_coat_name,
                'powder_plastic_coat_description' => $row->powder_plastic_coat_description
            );

        }

        return $arr;
    }

    public function insert($data)
    {
        $this->db->insert($this->powder_plastic_coatTable, $data);
        return $this->db->insert_id();
    }

    public function modify($data, $id)
    {   
        $this->db->where($this->powder_plastic_coatColumn, $id);
        $this->db->update($this->powder_plastic_coatTable, $data);
        return true;
    }

    public function get_all_powder_plastic_coat($start_from=0, $limit=0)
    {  
        $this->db->select('*');
        $this->db->from($this->powder_plastic_coatTable.' as pow');
        $this->db->join('status as stat','pow.powder_plastic_coat_id = stat.status_table_id');
        $this->db->where('stat.status_table', $this->powder_plastic_coatTable);  
        $this->db->where('stat.status_code', 1);  
        $this->db->order_by('pow.'.$this->powder_plastic_coatColumn, 'DESC');
        $query = $this->db->limit( $limit, $start_from )->get();
        return $query;
    }

    public function get_alls_powder_plastic_coat()
    {   
        $this->db->select('*');
        $this->db->from($this->powder_plastic_coatTable.' as pow');
        $this->db->join('status as stat','pow.powder_plastic_coat_id = stat.status_table_id');
        $this->db->where('stat.status_table', $this->powder_plastic_coatTable);  
        $this->db->where('stat.status_code', 1);
        $this->db->order_by('pow.'.$this->powder_plastic_coatColumn, 'DESC');
        $query = $this->db->get();
        return $query;
    }

    public function like_powder_plastic_coat($wildcard='', $start_from=0, $limit=0)
    {
        $this->db->select('*');
        $this->db->from($this->powder_plastic_coatTable.' as pow');
        $this->db->join('status as stat','pow.powder_plastic_coat_id = stat.status_table_id');
        $this->db->join('unit_of_measurement as uom','pow.unit_of_measurement_id = uom.unit_of_measurement_id');
        $this->db->where('stat.status_table', $this->powder_plastic_coatTable);  
        $this->db->where('stat.status_code', 1);  
        $this->db->group_start();
        $this->db->or_where('pow.powder_plastic_coat_id LIKE', '%' . $wildcard . '%');
        $this->db->or_where('pow.powder_plastic_coat_code LIKE', '%' . $wildcard . '%');
        $this->db->or_where('pow.powder_plastic_coat_name LIKE', '%' . $wildcard . '%');
        $this->db->or_where('pow.powder_plastic_coat_description LIKE', '%' . $wildcard . '%');
        $this->db->or_where('pow.powder_plastic_coat_weighted_ave LIKE', '%' . $wildcard . '%');
        $this->db->or_where('uom.unit_of_measurement_name LIKE', '%' . $wildcard . '%');
        $this->db->group_end();
        $this->db->order_by('pow.'.$this->powder_plastic_coatColumn, 'DESC');
        $query = $this->db->limit( $limit, $start_from )->get();
        return $query;   
    }

    public function likes_powder_plastic_coat($wildcard='')
    {
        $this->db->select('*');
        $this->db->from($this->powder_plastic_coatTable.' as pow');
        $this->db->join('status as stat','pow.powder_plastic_coat_id = stat.status_table_id');
        $this->db->join('unit_of_measurement as uom','pow.unit_of_measurement_id = uom.unit_of_measurement_id');
        $this->db->where('stat.status_table', $this->powder_plastic_coatTable);  
        $this->db->where('stat.status_code', 1);  
        $this->db->group_start();
        $this->db->or_where('pow.powder_plastic_coat_id LIKE', '%' . $wildcard . '%');
        $this->db->or_where('pow.powder_plastic_coat_code LIKE', '%' . $wildcard . '%');
        $this->db->or_where('pow.powder_plastic_coat_name LIKE', '%' . $wildcard . '%');
        $this->db->or_where('pow.powder_plastic_coat_description LIKE', '%' . $wildcard . '%');
        $this->db->or_where('pow.powder_plastic_coat_weighted_ave LIKE', '%' . $wildcard . '%');
        $this->db->or_where('uom.unit_of_measurement_name LIKE', '%' . $wildcard . '%');
        $this->db->group_end();
        $this->db->order_by('pow.'.$this->powder_plastic_coatColumn, 'DESC');
        $query = $this->db->get();
        return $query;
    }

    public function get_all_archived_powder_plastic_coat($start_from=0, $limit=0)
    {  
        $this->db->select('*');
        $this->db->from($this->powder_plastic_coatTable.' as dep');
        $this->db->join('status as stat','dep.powder_plastic_coat_id = stat.status_table_id');
        $this->db->where('stat.status_table', $this->powder_plastic_coatTable);  
        $this->db->where('stat.status_code', 0);  
        $this->db->order_by('dep.'.$this->powder_plastic_coatColumn, 'DESC');
        $query = $this->db->limit( $limit, $start_from )->get();
        return $query;
    }

    public function get_alls_archived_powder_plastic_coat()
    {   
        $this->db->select('*');
        $this->db->from($this->powder_plastic_coatTable.' as dep');
        $this->db->join('status as stat','dep.powder_plastic_coat_id = stat.status_table_id');
        $this->db->where('stat.status_table', $this->powder_plastic_coatTable);  
        $this->db->where('stat.status_code', 0);
        $this->db->order_by('dep.'.$this->powder_plastic_coatColumn, 'DESC');
        $query = $this->db->get();
        return $query;
    }

    public function like_archived_powder_plastic_coat($wildcard='', $start_from=0, $limit=0)
    {
        $this->db->select('*');
        $this->db->from($this->powder_plastic_coatTable.' as pow');
        $this->db->join('status as stat','pow.powder_plastic_coat_id = stat.status_table_id');
        $this->db->join('unit_of_measurement as uom','pow.unit_of_measurement_id = uom.unit_of_measurement_id');
        $this->db->where('stat.status_table', $this->powder_plastic_coatTable);  
        $this->db->where('stat.status_code', 0);  
        $this->db->group_start();
        $this->db->or_where('pow.powder_plastic_coat_id LIKE', '%' . $wildcard . '%');
        $this->db->or_where('pow.powder_plastic_coat_code LIKE', '%' . $wildcard . '%');
        $this->db->or_where('pow.powder_plastic_coat_name LIKE', '%' . $wildcard . '%');
        $this->db->or_where('pow.powder_plastic_coat_description LIKE', '%' . $wildcard . '%');
        $this->db->or_where('pow.powder_plastic_coat_weighted_ave LIKE', '%' . $wildcard . '%');
        $this->db->or_where('uom.unit_of_measurement_name LIKE', '%' . $wildcard . '%');
        $this->db->group_end();
        $this->db->order_by('pow.'.$this->powder_plastic_coatColumn, 'DESC');
        $query = $this->db->limit( $limit, $start_from )->get();
        return $query;       
    }

    public function likes_archived_powder_plastic_coat($wildcard='')
    {
        $this->db->select('*');
        $this->db->from($this->powder_plastic_coatTable.' as pow');
        $this->db->join('status as stat','pow.powder_plastic_coat_id = stat.status_table_id');
        $this->db->join('unit_of_measurement as uom','pow.unit_of_measurement_id = uom.unit_of_measurement_id');
        $this->db->where('stat.status_table', $this->powder_plastic_coatTable);  
        $this->db->where('stat.status_code', 0);  
        $this->db->group_start();
        $this->db->or_where('pow.powder_plastic_coat_id LIKE', '%' . $wildcard . '%');
        $this->db->or_where('pow.powder_plastic_coat_code LIKE', '%' . $wildcard . '%');
        $this->db->or_where('pow.powder_plastic_coat_name LIKE', '%' . $wildcard . '%');
        $this->db->or_where('pow.powder_plastic_coat_description LIKE', '%' . $wildcard . '%');
        $this->db->or_where('pow.powder_plastic_coat_weighted_ave LIKE', '%' . $wildcard . '%');
        $this->db->or_where('uom.unit_of_measurement_name LIKE', '%' . $wildcard . '%');
        $this->db->group_end();
        $this->db->order_by('pow.'.$this->powder_plastic_coatColumn, 'DESC');
        $query = $this->db->get();
        return $query;      
    }

    public function get_powder_plastic_coat_name_by_id($id)
    {   
        $this->db->where($this->powder_plastic_coatColumn, $id);
        $query = $this->db->get($this->powder_plastic_coatTable);

        foreach($query->result() as $row)
        {
            $id = $row->powder_plastic_coat_name;
        }

        return $id;
    }

}