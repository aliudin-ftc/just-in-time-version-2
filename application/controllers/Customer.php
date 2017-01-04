<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Customer extends CI_Controller {
    
    private $data = array();

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('form');
    }

    public function manage()
    {
        $data['template']   = array(
            'title'         => 'Maintenance',
            'sub_title'     => 'Customer',
            'method'		=> 'Manage',
            'body'          => 'users/manage-customers',
            'layouts'       => 'layouts/users',
            'page'          => array(
            	'role'		=>	$this->router->fetch_class(),
            	'modules' 	=>	$this->router->fetch_method(),
            	'category' 	=>	$this->uri->segment($this->uri->total_segments() - 1),    	
            	'method'	=> 	$this->uri->segment($this->uri->total_segments())
            	),
            'partials'      => array(
                'header'    => 'templates/header',
                'footer'    => 'templates/footer',
                'sidebar1'   => 'templates/sidebar1',
                'sidebar2'   => 'templates/sidebar2'
                ),
            'metadata'      => array(
                '<script src="' . base_url("assets/private/users/js/customers.js") . '"></script>'
                )
            );
        $this->load->view($data['template']['layouts'], $data);
    }

    public function archived()
    {
        $data['template']   = array(
            'title'         => 'Maintenance',
            'sub_title'     => 'Customer',
            'method'		=> 'Manage',
            'body'          => 'users/archived-customers',
            'layouts'       => 'layouts/users',
            'page'          => array(
            	'role'		=>	$this->router->fetch_class(),
            	'modules' 	=>	$this->router->fetch_method(),
            	'category' 	=>	$this->uri->segment($this->uri->total_segments() - 1),    	
            	'method'	=> 	$this->uri->segment($this->uri->total_segments())
            	),
            'partials'      => array(
                'header'    => 'templates/header',
                'footer'    => 'templates/footer',
                'sidebar1'   => 'templates/sidebar1',
                'sidebar2'   => 'templates/sidebar2'
                ),
            'metadata'      => array(
                '<script src="' . base_url("assets/private/users/js/customers.js") . '"></script>'
                )
            );
        $this->load->view($data['template']['layouts'], $data);
    }

    public function lists()
    {
    	if( $this->input->is_ajax_request() )
        {
            $bootgrid_arr = [];
            $current      = null != $this->input->post('current') ? $this->input->post('current') : 1;
            $limit        = $this->input->post('rowCount') == -1 ? 0 : $this->input->post('rowCount');
            $page         = $current !== null ? $current : 1;
            $start_from   = ($page-1) * $limit;
            $wildcard     = null != $this->input->post('searchPhrase') ? $this->input->post('searchPhrase') : null;
            

            if( isset($wildcard) )
            {
                $customers = $this->Customer_Model->like_customer($wildcard, $start_from, $limit)->result_array();
                $total = $this->Customer_Model->likes_customer($wildcard)->num_rows();

            }
            else
            {
                $customers = $this->Customer_Model->get_all_customer($start_from,  $limit)->result_array();
                $total = $this->Customer_Model->get_alls_customer()->num_rows();
            }

            foreach ($customers as $key => $customer) 
            {
                $bootgrid_arr[] = array(
                    'count_id'      	=> $key + 1 + $start_from,
                    'id'            	=> $customer['customer_id'],
                    'name'      		=> $customer['customer_name'],
                    'business-unit'     => $this->Business_Unit_Model->get_business_unit_name($customer['business_unit_id']),
                    'account-executive' => $this->Resources_Model->get_account_executive_name($customer['resources_id']),
                    'credit-limit'      => $customer['customer_credit_limit'] 
                );
            }

            $data = array(
                "current"       => intval($current),
                "rowCount"      => $limit,
                "searchPhrase"  => $wildcard,
                "total"         => intval( $total ),
                "rows"          => $bootgrid_arr,
            );

            echo json_encode( $data );
            exit();
        }
    }

    public function archived_lists()
    {
    	if( $this->input->is_ajax_request() )
        {
            $bootgrid_arr = [];
            $current      = null != $this->input->post('current') ? $this->input->post('current') : 1;
            $limit        = $this->input->post('rowCount') == -1 ? 0 : $this->input->post('rowCount');
            $page         = $current !== null ? $current : 1;
            $start_from   = ($page-1) * $limit;
            $wildcard     = null != $this->input->post('searchPhrase') ? $this->input->post('searchPhrase') : null;
            

            if( isset($wildcard) )
            {
                $customers = $this->Customer_Model->like_archived_customer($wildcard, $start_from, $limit)->result_array();
                $total = $this->Customer_Model->likes_archived_customer($wildcard)->num_rows();

            }
            else
            {
                $customers = $this->Customer_Model->get_all_archived_customer($start_from,  $limit)->result_array();
                $total = $this->Customer_Model->get_alls_archived_customer()->num_rows();
            }

            foreach ($customers as $key => $customer) 
            {
                $bootgrid_arr[] = array(
                    'count_id'      	=> $key + 1 + $start_from,
                    'id'            	=> $customer['customer_id'],
                    'name'      		=> $customer['customer_name'],
                    'business-unit'     => $this->Business_Unit_Model->get_business_unit_name($customer['business_unit_id']),
                    'account-executive' => $this->Resources_Model->get_account_executive_name($customer['resources_id']),
                    'credit-limit'      => $customer['customer_credit_limit'] 
                );
            }

            $data = array(
                "current"       => intval($current),
                "rowCount"      => $limit,
                "searchPhrase"  => $wildcard,
                "total"         => intval( $total ),
                "rows"          => $bootgrid_arr,
            );

            echo json_encode( $data );
            exit();
        }
    }

    public function add()
    {	
    	$data['info'] = '';
        $data['template']   = array(
            'title'         => 'Maintenance',
            'sub_title'     => 'Customer',
            'method'		=> 'Add',
            'body'          => 'users/add-customer',
            'layouts'       => 'layouts/users',
            'page'          => array(
            	'role'		=>	$this->router->fetch_class(),
            	'modules' 	=>	$this->router->fetch_method(),
            	'category' 	=>	$this->uri->segment($this->uri->total_segments() - 1),    	
            	'method'	=> 	$this->uri->segment($this->uri->total_segments())
            	),
            'partials'      => array(
                'header'    => 'templates/header',
                'footer'    => 'templates/footer',
                'sidebar1'   => 'templates/sidebar1',
                'sidebar2'   => 'templates/sidebar2'
                ),
            'metadata'      => array(
                '<script src="' . base_url("assets/private/users/js/customers.js") . '"></script>'
                )
            );
        $this->load->view($data['template']['layouts'], $data);
    }

    public function edit($id)
    {	
    	$data['info'] = $id;
        $data['template']   = array(
            'title'         => 'Maintenance',
            'sub_title'     => 'Customer',
            'method'		=> 'Edit',
            'body'          => 'users/edit-customer',
            'layouts'       => 'layouts/users',
            'page'          => array(
            	'role'		=>	$this->router->fetch_class(),
            	'modules' 	=>	$this->router->fetch_method(),
            	'category' 	=>	$this->uri->segment($this->uri->total_segments() - 1),    	
            	'method'	=> 	$this->uri->segment($this->uri->total_segments())
            	),
            'partials'      => array(
                'header'    => 'templates/header',
                'footer'    => 'templates/footer',
                'sidebar1'   => 'templates/sidebar1',
                'sidebar2'   => 'templates/sidebar2'
                ),
            'metadata'      => array(
                '<script src="' . base_url("assets/private/users/js/customers.js") . '"></script>'
                )
            );
        $this->load->view($data['template']['layouts'], $data);
    }

    public function uploads()
    {
    	if( $this->input->is_ajax_request() ) {                

			if(isset($_GET['files']))
            {
	            $error = false;
	            $files = array();
	            $folder = mkdir("uploads/".date('Y-m-d H:i:s'), 0777);
	            $uploaddir = 'uploads/'.date('Y-m-d H:i:s').'/';

	            foreach($_FILES as $file)
	            {
	                if(move_uploaded_file($file['tmp_name'], $uploaddir .basename($file['name'])))
	                {
	                    $files[] = $uploaddir .$file['name'];
	                }
	            }

	            $data = 
	            ($error) ? 
	            array('error' => 'There was an error uploading your files') : 
	            array('success' => 'The file has been uploaded successfully.');
        	} 
            
            echo json_encode( $data ); exit();

        }
    }

    public function save()
    {
    	if( $this->input->is_ajax_request() ) {

            $file = date('Y-m-d H:i:s').'/'.$_GET['filename'];

    		$customer = array(
                'business_unit_id' =>  $this->input->post('business_unit_id'),
                'resources_id' =>  $this->input->post('resources_id'),
                'tax_type_id' => $this->input->post('tax_type_id'),
                'document_type_id' => $this->input->post('document_type_id'),
                'tier_id' => $this->input->post('tier_id'),
                'business_style_id' => $this->input->post('business_style_id'),
                'customer_code' => $this->input->post('customer_code'),
                'customer_name' => $this->input->post('customer_name'),
                'customer_description' => $this->input->post('customer_description'),
                'customer_logo' => $file,
                'customer_delivery_guidelines' => $this->input->post('customer_delivery_guidelines'),
                'customer_tin' => $this->input->post('customer_tin'),
                'customer_credit_limit' => $this->input->post('customer_credit_limit'),
                'customer_credit_note' => $this->input->post('customer_credit_note'),
                'customer_remarks' => $this->input->post('customer_remarks')
            );

            $customer_id = $this->Customer_Model->insert($customer);

            $created = array(
            	'created_by' => '1',
            	'created_table' => 'customer',
            	'created_table_id' => $customer_id
            );
			
			$created_id = $this->Created_Model->insert($created);

            $status = array(
            	'status_code' => '1',
            	'status_description' => 'Active',
            	'status_table' => 'customer',
            	'status_table_id' => $customer_id
            );
			
			$status_id = $this->Status_Model->insert($status);


    	}
    }

    public function update($id)
    {
        if( $this->input->is_ajax_request() ) {

            if(isset($_GET['old']))
            {
                $file = $_GET['filename'];
            } 
            else 
            {
                $file = date('Y-m-d H:i:s').'/'.$_GET['filename'];
            }

            $customer = array(
                'business_unit_id' =>  $this->input->post('business_unit_id'),
                'resources_id' =>  $this->input->post('resources_id'),
                'tax_type_id' => $this->input->post('tax_type_id'),
                'document_type_id' => $this->input->post('document_type_id'),
                'tier_id' => $this->input->post('tier_id'),
                'business_style_id' => $this->input->post('business_style_id'),
                'customer_code' => $this->input->post('customer_code'),
                'customer_name' => $this->input->post('customer_name'),
                'customer_description' => $this->input->post('customer_description'),
                'customer_logo' => $file,
                'customer_delivery_guidelines' => $this->input->post('customer_delivery_guidelines'),
                'customer_tin' => $this->input->post('customer_tin'),
                'customer_credit_limit' => $this->input->post('customer_credit_limit'),
                'customer_credit_note' => $this->input->post('customer_credit_note'),
                'customer_remarks' => $this->input->post('customer_remarks')
            );

            $this->Customer_Model->modify($customer, $id);

            $updated = array(
                'updated_by' => '1',
                'updated_table' => 'customer',
                'updated_table_id' => $id
            );
            
            $updated_id = $this->Updated_Model->insert($updated);

        }
    }

    public function find($id)
    {
        if( $this->input->is_ajax_request() ) {

            $arr = $this->Customer_Model->find($id);           

            echo json_encode( $arr );

            exit();

        }
    }

    public function delete($id)
    {
    	if( $this->input->is_ajax_request() ) {

			$status = array(
                'status_table_id' => $id,
                'status_table' => 'customer',
                'status_code' => '0',
                'status_description' => 'Inactive'  
            );

			$status_id = $this->Status_Model->delete($status);

            /*$history = array(
                'history_logs' => 'has deleted incident report with id ('.$val.').',
                'history_category' => 'incident report',
                'emp_id' => $this->session->userdata('emp_id')
            );
            
            $history_id = $this->History->insert($history);
			*/

			$data = array(
                'message' => 'The employe was successfully removed.',
                'type'    => 'success'
            );
            echo json_encode( $data ); exit();

		}	
    }
    
    public function undo($id)
    {
    	if( $this->input->is_ajax_request() ) {

			$status = array(
                'status_table_id' => $id,
                'status_table' => 'customer',
                'status_code' => '1',
                'status_description' => 'Active'  
            );

			$status_id = $this->Status_Model->undo($status);

            /*$history = array(
                'history_logs' => 'has deleted incident report with id ('.$val.').',
                'history_category' => 'incident report',
                'emp_id' => $this->session->userdata('emp_id')
            );
            
            $history_id = $this->History->insert($history);
			*/

			$data = array(
                'message' => 'The employe was successfully restored.',
                'type'    => 'success'
            );
            echo json_encode( $data ); exit();

		}	
    }

}