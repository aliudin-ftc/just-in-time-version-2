<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Bill_Of_Materials_Category_Model extends CI_Model {

    private $bill_of_materials_categoryTable = 'bill_of_materials_category';
    private $bill_of_materials_categoryColumn = 'bill_of_materials_category_id';

    public function __construct()
    {
        parent::__construct();
    }
    public function like_bill_of_materials_category($wildcard='', $start_from=0, $limit=0)
    {
        $this->db->select('*');
        $this->db->from($this->bill_of_materials_categoryTable.' as bomc');
        $this->db->join('status as stat','bomc.bill_of_materials_category_id = stat.status_table_id');
        $this->db->where('stat.status_table', $this->bill_of_materials_categoryTable);  
        $this->db->where('stat.status_code', 1);  
        $this->db->group_start();
        $this->db->or_where('bomc.bill_of_materials_category_id LIKE', '%' . $wildcard . '%');
        $this->db->or_where('bomc.bill_of_materials_category_code LIKE', '%' . $wildcard . '%');
        $this->db->or_where('bomc.bill_of_materials_category_name LIKE', '%' . $wildcard . '%');
        $this->db->or_where('bomc.bill_of_materials_category_description LIKE', '%' . $wildcard . '%');
        $this->db->group_end();
        $this->db->order_by('bomc.'.$this->bill_of_materials_categoryColumn, 'DESC');
        $query = $this->db->limit( $limit, $start_from )->get();
        return $query;   
    }

    public function like_count_bill_of_materials_category($wildcard='')
    {
        $this->db->select('*');
        $this->db->from($this->bill_of_materials_categoryTable.' as bomc');
        $this->db->join('status as stat','bomc.bill_of_materials_category_id = stat.status_table_id');
        $this->db->where('stat.status_table', $this->bill_of_materials_categoryTable);  
        $this->db->where('stat.status_code', 1);  
        $this->db->group_start();
        $this->db->or_where('bomc.bill_of_materials_category_id LIKE', '%' . $wildcard . '%');
        $this->db->or_where('bomc.bill_of_materials_category_code LIKE', '%' . $wildcard . '%');
        $this->db->or_where('bomc.bill_of_materials_category_name LIKE', '%' . $wildcard . '%');
        $this->db->or_where('bomc.bill_of_materials_category_description LIKE', '%' . $wildcard . '%');
        $this->db->group_end();
        $this->db->order_by('bomc.'.$this->bill_of_materials_categoryColumn, 'DESC');
        $query = $this->db->get();
        return $query;
    }

    public function get_all_bill_of_materials_category($start_from=0, $limit=0)
    {  
        $this->db->select('*');
        $this->db->from($this->bill_of_materials_categoryTable.' as bomc');
        $this->db->join('status as stat','bomc.bill_of_materials_category_id = stat.status_table_id');
        $this->db->where('stat.status_table', $this->bill_of_materials_categoryTable);  
        $this->db->where('stat.status_code', 1);  
        $this->db->order_by('bomc.'.$this->bill_of_materials_categoryColumn, 'DESC');
        $query = $this->db->limit( $limit, $start_from )->get();
        return $query;
    }

    public function get_all_count_bill_of_materials_category()
    {   
        $this->db->select('*');
        $this->db->from($this->bill_of_materials_categoryTable.' as bomc');
        $this->db->join('status as stat','bomc.bill_of_materials_category_id = stat.status_table_id');
        $this->db->where('stat.status_table', $this->bill_of_materials_categoryTable);  
        $this->db->where('stat.status_code', 1);
        $this->db->order_by('bomc.'.$this->bill_of_materials_categoryColumn, 'DESC');
        $query = $this->db->get();
        return $query;
    }
    public function form_input_attributes($data, $id)
    {   
        if(isset($id) && !empty($id))
        {   
            $this->db->where($this->bill_of_materials_categoryColumn, $id);
            $query = $this->db->get($this->bill_of_materials_categoryTable);

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

    public function insert($data)
    {
        $this->db->insert($this->bill_of_materials_categoryTable, $data);
        return $this->db->insert_id();
    }

    public function find($id)
    {   
        $this->db->select('*');
        $this->db->from('bill_of_materials_category as bomc');
        $this->db->join('created as cre','bomc.bill_of_materials_category_id = cre.created_table_id');
        $this->db->where('cre.created_table','bill_of_materials_category');    
        $this->db->where('bomc.bill_of_materials_category_id', $id);
        $query = $this->db->get();

        foreach ($query->result() as $row) {

            $arr[] = array(
                'bill_of_materials_category_id' => $row->bill_of_materials_category_id,
                'bill_of_materials_category_code' => $row->bill_of_materials_category_code,
                'bill_of_materials_category_name' => $row->bill_of_materials_category_name,
                'bill_of_materials_category_description' => $row->bill_of_materials_category_description
            );

        }

        return $arr;
    }
    public function modify($data, $id)
    {   
        $this->db->where($this->bill_of_materials_categoryColumn, $id);
        $this->db->update($this->bill_of_materials_categoryTable, $data);
        return true;
    }

    public function like_archived_bill_of_materials_category($wildcard='', $start_from=0, $limit=0)
    {
        $this->db->select('*');
        $this->db->from($this->bill_of_materials_categoryTable.' as bomc');
        $this->db->join('status as stat','bomc.bill_of_materials_category_id = stat.status_table_id');
        $this->db->where('stat.status_table', $this->bill_of_materials_categoryTable);  
        $this->db->where('stat.status_code', 0);  
        $this->db->group_start();
        $this->db->or_where('bomc.bill_of_materials_category_id LIKE', '%' . $wildcard . '%');
        $this->db->or_where('bomc.bill_of_materials_category_code LIKE', '%' . $wildcard . '%');
        $this->db->or_where('bomc.bill_of_materials_category_name LIKE', '%' . $wildcard . '%');
        $this->db->or_where('bomc.bill_of_materials_category_description LIKE', '%' . $wildcard . '%');
        $this->db->group_end();
        $this->db->order_by('bomc.'.$this->bill_of_materials_categoryColumn, 'DESC');
        $query = $this->db->limit( $limit, $start_from )->get();
        return $query;      
    }

    public function like_archived_count_bill_of_materials_category($wildcard='')
    {
        $this->db->select('*');
        $this->db->from($this->bill_of_materials_categoryTable.' as bomc');
        $this->db->join('status as stat','bomc.bill_of_materials_category_id = stat.status_table_id');
        $this->db->where('stat.status_table', $this->bill_of_materials_categoryTable);  
        $this->db->where('stat.status_code', 0);  
        $this->db->group_start();
        $this->db->or_where('bomc.bill_of_materials_category_id LIKE', '%' . $wildcard . '%');
        $this->db->or_where('bomc.bill_of_materials_category_code LIKE', '%' . $wildcard . '%');
        $this->db->or_where('bomc.bill_of_materials_category_name LIKE', '%' . $wildcard . '%');
        $this->db->or_where('bomc.bill_of_materials_category_description LIKE', '%' . $wildcard . '%');
        $this->db->group_end();
        $this->db->order_by('bomc.'.$this->bill_of_materials_categoryColumn, 'DESC');
        $query = $this->db->get();
        return $query;   
    }

    public function get_all_archived_bill_of_materials_category($start_from=0, $limit=0)
    {  
        $this->db->select('*');
        $this->db->from($this->bill_of_materials_categoryTable.' as bomc');
        $this->db->join('status as stat','bomc.bill_of_materials_category_id = stat.status_table_id');
        $this->db->where('stat.status_table', $this->bill_of_materials_categoryTable);  
        $this->db->where('stat.status_code', 0);  
        $this->db->order_by('bomc.'.$this->bill_of_materials_categoryColumn, 'DESC');
        $query = $this->db->limit( $limit, $start_from )->get();
        return $query;
    }

    public function get_all_archived_count_bill_of_materials_category()
    {   
        $this->db->select('*');
        $this->db->from($this->bill_of_materials_categoryTable.' as bomc');
        $this->db->join('status as stat','bomc.bill_of_materials_category_id = stat.status_table_id');
        $this->db->where('stat.status_table', $this->bill_of_materials_categoryTable);  
        $this->db->where('stat.status_code', 0);
        $this->db->order_by('bomc.'.$this->bill_of_materials_categoryColumn, 'DESC');
        $query = $this->db->get();
        return $query;
    }
}