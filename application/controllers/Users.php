<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users extends CI_Controller {
    
    public function __construct()
    {
        parent::__construct();
        $this->load_controllers();
        $this->load_models();
    }

    public function load_controllers()
    {
    	$this->load->controller('Customer');
    }

    public function load_models()
    {
    	$models = array(
        	'Customer_Model' => 'Customer_Model',
        	'Tier_Model' => 'Tier_Model',
        	'Document_Type_Model' => 'Document_Type_Model',
        	'Tax_Type_Model' => 'Tax_Type_Model',
        	'Business_Style_Model' => 'Business_Style_Model',
        	'Business_Unit_Model' => 'Business_Unit_Model',
        	'Resources_Model' => 'Resources_Model',
        	'Status_Model' => 'Status_Model',
        	'Created_Model' => 'Created_Model',
        	'Updated_Model' => 'Updated_Model',
        );

        $this->load->model($models);  
    }

    
    public function maintenance($modules = null, $page = null, $view = null)
    {	
    	/*
	    | ---------------------------------
	    | # maintenance - customer
	    | ---------------------------------
	    */
    	if($modules == "customer") 
    	{
	    	if($page == "manage" || $page == null)
	    	{
	        	$this->Customer->manage();
	    	}
	    	else if($page == "archived")
	    	{
	    		$this->Customer->archived();
	    	}
	    	else if($page == "add")
	    	{
	    		$this->Customer->add();
	    	}
	    	else if($page == "edit" && $view != null)
	    	{
	    		$this->Customer->edit($view);
	    	}
	    	else if($page == "uploads")
	    	{	
	    		$this->Customer->uploads();
	    	}
	    	else if($page == "save")
	    	{
	    		$this->Customer->save();
	    	}
	    	else if($page == "update")
	    	{
	    		$this->Customer->update($view);
	    	}
	    	else if($page == "delete")
	    	{
	    		$this->Customer->delete($view);
	    	}
	    	else if($page == "undo")
	    	{
	    		$this->Customer->undo($view);
	    	}
	    	else if($page == "find")
	    	{
	    		$this->Customer->find($view);
	    	}
	    	else if($page == "lists")
	    	{
	    		$this->Customer->lists();
	    	}
	    	else if($page == "archived-lists")
	    	{
	    		$this->Customer->archived_lists();
	    	}	
	    	else {
	    		show_404();
	    	}    	
    	}

    	/*
	    | ---------------------------------
	    | # maintenance - account
	    | ---------------------------------
	    */
	    else if($modules == "machine") 
    	{
	    	if($page == "manage" || $page == null)
	    	{
	        	$this->Customer->manage();
	    	}
	    	else if($page == "add")
	    	{
	    		$this->Customer->add();
	    	}
    	}

    }

}