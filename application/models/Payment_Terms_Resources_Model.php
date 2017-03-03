<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Payment_Terms_Resources_Model extends CI_Model {

    private $payment_terms_resourcesTable = 'payment_terms_resources';
    private $payment_terms_resourcesColumn = 'payment_terms_resources_id';

    public function __construct()
    {
        parent::__construct();
    }  

    public function form_selected_resources_options($id)
    {   
        $this->db->select('*');
        $this->db->from('payment_terms_resources as pay');
        $this->db->join('resources as res','pay.resources_id = res.resources_id');    
        $this->db->where('res.resources_id',$id);
        $query = $this->db->get();
        
        if($query->num_rows() > 0)
        {
            foreach ($query->result() as $row) {
                $id = $row->payment_terms_resources_id;
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
        $this->db->insert($this->payment_terms_resourcesTable, $data);
        return $this->db->insert_id();
    }

    public function modify($data, $id)
    {   
        $this->db->where('resources_id', $id);
        $this->db->update($this->payment_terms_resourcesTable, $data);
        return true;
    }  
}