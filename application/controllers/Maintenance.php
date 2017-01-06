<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Maintenance extends CI_Controller {
    
    private $data = array();

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('form');
        $this->load_models();
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
            'Priviledge_Model'  => 'Priviledge_Model',
            'Modules_Model' => 'Modules_Model'
        );

        $this->load->model($models);  
    }

    public function load_menus($id)
    {
        $modules['result'] = $this->Priviledge_Model->get_priviledge_modules($id);        
        $menu = '';

        foreach($modules['result'] as $module) {

            $url = base_url().''.$this->Modules_Model->get_modules_slug($module->modules_id);

            if( $this->Modules_Model->count_modules($module->modules_id) > 1 ) {             

                if($this->Modules_Model->get_modules_name($module->modules_id) == ucfirst($this->router->fetch_class()))
                {
                    $menu .= '<li class="sub-menu active">';
                } else {
                    $menu .= '<li class="sub-menu ">';
                }
                    $menu .= '<a href="" data-ma-action="submenu-toggle">';
                    $menu .= '<i class="'.$this->Modules_Model->get_modules_icon($module->modules_id).'"></i>'; 
                    $menu .= '<span>'.$this->Modules_Model->get_modules_name($module->modules_id).'</span>';
                    $menu .= '</a>';
                    $menu .= '<ul>';
                            
                    $sub_modules['result'] = $this->Modules_Model->get_sub_modules($module->modules_id, 1);
                    foreach($sub_modules['result'] as $sub_module) {

                if($this->router->fetch_method() == $sub_module->sub_modules_slug)           
                {    
                    $menu .= '<li class="active">';
                } else {
                    $menu .= '<li>';
                }
                    $menu .= '<a href="'.$url.'/'.$sub_module->sub_modules_slug.'"><span>'.$sub_module->sub_modules_name.'</span></a>';
                    $menu .= '</li>';
                       
                       }//end foreach
                            
                    $menu .= '</ul>';
                    $menu .= '</li>';

            } else {

                    $menu .= '<li>';
                    $menu .= '<a href="'.$url.'">';
                    $menu .= '<i class="'.$this->Modules_Model->get_modules_icon($module->modules_id).'"></i>'; 
                    $menu .= $this->Modules_Model->get_modules_name($module->modules_id);
                    $menu .= '</a>';
                    $menu .= '</li>';

            } 

        }//end foreach

        return $menu;
    }

    public function customer_form_data($id) 
    {   
        $data = array( 
            'customer_name' => $this->Customer_Model->form_input_attributes('customer_name', $id),
            'customer_description' => $this->Customer_Model->form_input_attributes('customer_description', $id),
            'customer_code' => $this->Customer_Model->form_input_attributes('customer_code', $id),
            'business_unit_attributes' => $this->Business_Unit_Model->form_select_attributes('business_unit_id'), 
                'business_unit_options' => $this->Business_Unit_Model->form_select_options('business_unit'),
                'business_unit_selected' => $this->Business_Unit_Model->form_selected_options($id),
            'resources_attributes' => $this->Resources_Model->form_select_attributes('resources_id'), 
                'resources_options' => $this->Resources_Model->form_select_options('account executive'),
                'resources_selected' => $this->Resources_Model->form_selected_options($id),
            'business_style_attributes' => $this->Business_Style_Model->form_select_attributes('business_style_id'), 
                'business_style_options' => $this->Business_Style_Model->form_select_options('business_style'),
                'business_style_selected' => $this->Business_Style_Model->form_selected_options($id),
            'tax_type_attributes' => $this->Tax_Type_Model->form_select_attributes('tax_type_id'), 
                'tax_type_options' => $this->Tax_Type_Model->form_select_options('tax_type'),
                'tax_type_selected' => $this->Tax_Type_Model->form_selected_options($id),
            'document_type_attributes' => $this->Document_Type_Model->form_select_attributes('document_type_id'), 
                'document_type_options' => $this->Document_Type_Model->form_select_options('document_type'),
                'document_type_selected' => $this->Document_Type_Model->form_selected_options($id),
            'tier_attributes' => $this->Tier_Model->form_select_attributes('tier_id'), 
                'tier_options' => $this->Tier_Model->form_select_options('tier'),
                'tier_selected' => $this->Tier_Model->form_selected_options($id),
            'customer_tin' => $this->Customer_Model->form_input_attributes('customer_tin', $id),
            'customer_credit_limit' => $this->Customer_Model->form_input_numeric_attributes('customer_credit_limit', $id),
            'customer_credit_note' => $this->Customer_Model->form_input_attributes('customer_credit_note', $id),
            'customer_delivery_guidelines' => $this->Customer_Model->form_textarea_attributes('customer_delivery_guidelines', $id),
            'customer_remarks' => $this->Customer_Model->form_textarea_attributes('customer_remarks', $id),
            'customer_file' => $this->Customer_Model->form_file($id)
        );
        return $data;
    }

    public function customer($page = null, $view = null)
    {
        if($page == "manage" || $page == null)
        {
            $data['menu'] = $this->load_menus(1);
            $data['template']   = array(
                'title'         => 'Maintenance',
                'sub_title'     => 'Customer',
                'method'        => 'Manage',
                'body'          => 'users/manage-customers',
                'layouts'       => 'layouts/users',
                'page'          => array(
                    'role'      =>  $this->router->fetch_class(),
                    'modules'   =>  $this->router->fetch_method(),
                    'category'  =>  $this->uri->segment($this->uri->total_segments() - 1),      
                    'method'    =>  $this->uri->segment($this->uri->total_segments())
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
        else if($page == "archived")
        {
            $data['menu'] = $this->load_menus(1);
            $data['template']   = array(
                'title'         => 'Maintenance',
                'sub_title'     => 'Customer',
                'method'        => 'Manage',
                'body'          => 'users/archived-customers',
                'layouts'       => 'layouts/users',
                'page'          => array(
                    'role'      =>  $this->router->fetch_class(),
                    'modules'   =>  $this->router->fetch_method(),
                    'category'  =>  $this->uri->segment($this->uri->total_segments() - 1),      
                    'method'    =>  $this->uri->segment($this->uri->total_segments())
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
        else if($page == "add")
        {
            $data['menu'] = $this->load_menus(1);
            $data['input'] = $this->customer_form_data('');
            $data['template']   = array(
                'title'         => 'Maintenance',
                'sub_title'     => 'Customer',
                'method'        => 'Add',
                'body'          => 'users/add-customer',
                'layouts'       => 'layouts/users',
                'page'          => array(
                    'role'      =>  $this->router->fetch_class(),
                    'modules'   =>  $this->router->fetch_method(),
                    'category'  =>  $this->uri->segment($this->uri->total_segments() - 1),      
                    'method'    =>  $this->uri->segment($this->uri->total_segments())
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
        else if($page == "edit" && $view != null)
        {
            $data['menu'] = $this->load_menus(1);
            $data['input'] = $this->customer_form_data($view);
            $data['template']   = array(
                'title'         => 'Maintenance',
                'sub_title'     => 'Customer',
                'method'        => 'Edit',
                'body'          => 'users/edit-customer',
                'layouts'       => 'layouts/users',
                'page'          => array(
                    'role'      =>  $this->router->fetch_class(),
                    'modules'   =>  $this->router->fetch_method(),
                    'category'  =>  $this->uri->segment($this->uri->total_segments() - 1),      
                    'method'    =>  $this->uri->segment($this->uri->total_segments())
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
        else if($page == "uploads")
        {   
            if( $this->input->is_ajax_request() ) 
            {          
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
        else if($page == "save")
        {
            if( $this->input->is_ajax_request() ) 
            {
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
        else if($page == "update" && $view != null)
        {
            if( $this->input->is_ajax_request() ) 
            {
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

                $this->Customer_Model->modify($customer, $view);

                $updated = array(
                    'updated_by' => '1',
                    'updated_table' => 'customer',
                    'updated_table_id' => $view
                );
                
                $updated_id = $this->Updated_Model->insert($updated);
            }
        }
        else if($page == "delete" && $view != null)
        {
            if( $this->input->is_ajax_request() ) 
            {
                $status = array(
                    'status_table_id' => $view,
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
        else if($page == "undo" && $view != null)
        {
            if( $this->input->is_ajax_request() ) 
            {
                $status = array(
                    'status_table_id' => $view,
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
        else if($page == "find" && $view != null)
        {
            if( $this->input->is_ajax_request() ) {

                $arr = $this->Customer_Model->find($view);           

                echo json_encode( $arr );

                exit();

            }
        }
        else if($page == "lists")
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
                        'count_id'          => $key + 1 + $start_from,
                        'id'                => $customer['customer_id'],
                        'name'              => $customer['customer_name'],
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
        else if($page == "archived-lists")
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
                        'count_id'          => $key + 1 + $start_from,
                        'id'                => $customer['customer_id'],
                        'name'              => $customer['customer_name'],
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
        else {
            show_404();
        }       
    }
}