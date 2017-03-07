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
            'Modules_Model' => 'Modules_Model',
            'Contact_Person_Model' => 'Contact_Person_Model',
            'Contact_Model' => 'Contact_Model',
            'Brand_Model' => 'Brand_Model',
            'Department_Model' => 'Department_Model',
            'Account_Model' => 'Account_Model',
            'Branch_Model' => 'Branch_Model',
            'Unit_Of_Measurement_Model' => 'Unit_Of_Measurement_Model',
            'User_Model' => 'User_Model',
            'User_Secret_Model' => 'User_Secret_Model',
            'Priviledge_Module_Model' => 'Priviledge_Module_Model',
            'Modules_Sub_Module_Model' => 'Modules_Sub_Module_Model',
            'Powder_Plastic_Coat_Model' => 'Powder_Plastic_Coat_Model',
            'Painting_Cost_Model' => 'Painting_Cost_Model'
        );

        $this->load->model($models);  
    }

    public function load_menus($id)
    {
        $modules['result'] = $this->Priviledge_Model->get_priviledge_modules($id);        
        $menu = '';

        foreach($modules['result'] as $module) {

            $url = base_url().''.$this->Modules_Model->get_modules_slug($module->modules_id);

            if( $this->Modules_Model->count_modules($module->modules_id) > 0 ) {             

                if($this->Modules_Model->get_modules_name($module->modules_id) == ucwords(str_replace('_',' ',$this->router->fetch_class())))
                {
                    $menu .= '<li class="sub-menu active toggled">';
                } else {
                    $menu .= '<li class="sub-menu">';
                }
                    $menu .= '<a href="" data-ma-action="submenu-toggle">';
                    $menu .= '<i class="'.$this->Modules_Model->get_modules_icon($module->modules_id).'"></i>'; 
                    $menu .= '<span>'.$this->Modules_Model->get_modules_name($module->modules_id).'</span>';
                    $menu .= '</a>';
                    $menu .= '<ul>';
                            
                    $sub_modules['result'] = $this->Modules_Model->get_sub_modules($module->modules_id, $id);
                    foreach($sub_modules['result'] as $sub_module) {

                if($this->router->fetch_method() == $sub_module->sub_modules_slug  || str_replace('_', '-', $this->router->fetch_method()) == $sub_module->sub_modules_slug)           
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

                if($this->Modules_Model->get_modules_name($module->modules_id) == ucwords(str_replace('_',' ',$this->router->fetch_class())))
                {
                    $menu .= '<li class="active">';
                }
                else {
                    $menu .= '<li>';
                }
                    $menu .= '<a href="'.$url.'">';
                    $menu .= '<i class="'.$this->Modules_Model->get_modules_icon($module->modules_id).'"></i>'; 
                    $menu .= $this->Modules_Model->get_modules_name($module->modules_id);
                    $menu .= '</a>';
                    $menu .= '</li>';

            } 

        }//end foreach

        return $menu;
    }

    public function auth()
    {   
        $current = ucwords(str_replace('_',' ',$this->router->fetch_class()));
        $priviledge = $this->Priviledge_Module_Model->check_priviledges($this->session->userdata('priviledge_id'));

        $modules = array();
        foreach ($priviledge as $row) {
            $modules[] = $this->Modules_Model->get_modules_name($row->modules_id);
        }
        
        if (in_array($current, $modules)) {

        } else {
            redirect(base_url('dashboard'));
        }
    }
    
    public function validated()
    {   
        $this->session->set_flashdata('error', "You are not logged in");
        if(!$this->session->userdata('validated')) 
            redirect(base_url('login'));
        else 
            $this->auth();
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
                'tax_type_selected' => $this->Tax_Type_Model->form_selected_customer_options($id),
            'document_type_attributes' => $this->Document_Type_Model->form_select_attributes('document_type_id'), 
                'document_type_options' => $this->Document_Type_Model->form_select_options('document_type'),
                'document_type_selected' => $this->Document_Type_Model->form_selected_options($id),
            'tier_attributes' => $this->Tier_Model->form_select_attributes('tier_id'), 
                'tier_options' => $this->Tier_Model->form_select_options('tier'),
                'tier_selected' => $this->Tier_Model->form_selected_options($id),
            'customer_tin' => $this->Customer_Model->form_input_attributes('customer_tin', $id),
            'customer_credit_limit' => $this->Customer_Model->form_input_numeric_attributes('customer_credit_limit', $id),
            'customer_credit_note' => $this->Customer_Model->form_input_attributes('customer_credit_note', $id),
            'contact_phone_number' => $this->Contact_Model->form_input_numeric_customer_attributes('contact_phone_number', $id),
            'contact_mobile_number' => $this->Contact_Model->form_input_numeric_customer_attributes('contact_mobile_number', $id),
            'contact_fax_number' => $this->Contact_Model->form_input_numeric_customer_attributes('contact_fax_number', $id),
            'customer_delivery_guidelines' => $this->Customer_Model->form_textarea_attributes('customer_delivery_guidelines', $id),
            'customer_remarks' => $this->Customer_Model->form_textarea_attributes('customer_remarks', $id),
            'customer_file' => $this->Customer_Model->form_file($id)
        );
        return $data;
    }

    public function customer($page = null, $view = null, $param1 = null, $param2 =null)
    {   
        $this->validated();
        if($page == "manage" || $page == null)
        {   
            $data['menu'] = $this->load_menus($this->session->userdata('priviledge_id'));
            $data['template']   = array(
                'title'         => 'Maintenance',
                'sub_title'     => 'Customer',
                'method'        => 'Manage',
                'body'          => 'users/manage/customer',
                'layouts'       => 'layouts/users',
                'page'          => array(
                    'parent'    => $this->router->fetch_class(),
                    'category'  => $this->router->fetch_method(),
                    'modules'   => $page,
                    'views'     => $view,     
                    'method'    => $param1,
                    ),
                'partials'      => array(
                    'header'    => 'templates/header',
                    'footer'    => 'templates/footer',
                    'sidebar1'   => 'templates/sidebar1',
                    'sidebar2'   => 'templates/sidebar2'
                    ),
                'metadata'      => array(
                    '<script src="' . base_url("assets/private/users/js/customer.js") . '"></script>'
                    )
                );
            $this->load->view($data['template']['layouts'], $data);
        }
        else if($page == "archived")
        {
            $data['menu'] = $this->load_menus($this->session->userdata('priviledge_id'));
            $data['template']   = array(
                'title'         => 'Maintenance',
                'sub_title'     => 'Customer',
                'method'        => 'Manage',
                'body'          => 'users/archived/customer',
                'layouts'       => 'layouts/users',
                'page'          => array(
                    'parent'    => $this->router->fetch_class(),
                    'category'  => $this->router->fetch_method(),
                    'modules'   => $page,
                    'views'     => $view,     
                    'method'    => $param1,
                    ),
                'partials'      => array(
                    'header'    => 'templates/header',
                    'footer'    => 'templates/footer',
                    'sidebar1'   => 'templates/sidebar1',
                    'sidebar2'   => 'templates/sidebar2'
                    ),
                'metadata'      => array(
                    '<script src="' . base_url("assets/private/users/js/customer.js") . '"></script>'
                    )
                );
            $this->load->view($data['template']['layouts'], $data);
        }
        else if($page == "add")
        {
            $data['menu'] = $this->load_menus($this->session->userdata('priviledge_id'));
            $data['input'] = $this->customer_form_data('');
            $data['template']   = array(
                'title'         => 'Maintenance',
                'sub_title'     => 'Customer',
                'method'        => 'Add',
                'body'          => 'users/add/customer',
                'layouts'       => 'layouts/users',
                'page'          => array(
                    'parent'    => $this->router->fetch_class(),
                    'category'  => $this->router->fetch_method(),
                    'modules'   => $page,
                    'views'     => $view,     
                    'method'    => $param1,
                    ),
                'partials'      => array(
                    'header'    => 'templates/header',
                    'footer'    => 'templates/footer',
                    'sidebar1'   => 'templates/sidebar1',
                    'sidebar2'   => 'templates/sidebar2'
                    ),
                'metadata'      => array(
                    '<script src="' . base_url("assets/private/users/js/customer.js") . '"></script>'
                    )
                );
            $this->load->view($data['template']['layouts'], $data);
        }
        else if($page == "edit" && $view != null)
        {
            $data['menu'] = $this->load_menus($this->session->userdata('priviledge_id'));
            $data['input'] = $this->customer_form_data($view);
            $data['template']   = array(
                'title'         => 'Maintenance',
                'sub_title'     => 'Customer',
                'method'        => 'Edit',
                'body'          => 'users/edit/customer',
                'layouts'       => 'layouts/users',
                'page'          => array(
                    'parent'    => $this->router->fetch_class(),
                    'category'  => $this->router->fetch_method(),
                    'modules'   => $page,
                    'views'     => $view,     
                    'method'    => $param1,
                    ),
                'partials'      => array(
                    'header'    => 'templates/header',
                    'footer'    => 'templates/footer',
                    'sidebar1'   => 'templates/sidebar1',
                    'sidebar2'   => 'templates/sidebar2'
                    ),
                'metadata'      => array(
                    '<script src="' . base_url("assets/private/users/js/customer.js") . '"></script>'
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

                $contact = array(
                    'contact_phone_number' =>  $this->input->post('contact_phone_number'),
                    'contact_mobile_number' =>  $this->input->post('contact_mobile_number'),
                    'contact_fax_number' => $this->input->post('contact_fax_number'),
                    'contact_table' => 'customer',
                    'contact_table_id' => $customer_id
                );

                $contact_id = $this->Contact_Model->insert($contact);
                
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

                $contact = array(
                    'contact_phone_number' =>  $this->input->post('contact_phone_number'),
                    'contact_mobile_number' =>  $this->input->post('contact_mobile_number'),
                    'contact_fax_number' => $this->input->post('contact_fax_number'),
                    'contact_table' => 'customer'
                );

                $this->Contact_Model->modify($contact, $view);

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

    public function brand_form_data($id) 
    {   
        $data = array( 
            'brand_name' => $this->Brand_Model->form_input_attributes('brand_name', $id),
            'brand_description' => $this->Brand_Model->form_input_attributes('brand_description', $id),
            'customer_attributes' => $this->Customer_Model->form_select_attributes('customer_id'), 
                'customer_options' => $this->Customer_Model->form_select_options('customer_name'),
                'customer_selected' => $this->Customer_Model->form_selected_brand_options($id)
        );
        return $data;
    }

    public function brand($page = null, $view = null, $param1 = null, $param2 = null)
    {   
        $this->validated();
        if($page == "manage" || $page == null)
        {
            $data['menu'] = $this->load_menus($this->session->userdata('priviledge_id'));
            $data['template']   = array(
                'title'         => 'Maintenance',
                'sub_title'     => 'Brand',
                'method'        => 'Manage',
                'body'          => 'users/manage/brand',
                'layouts'       => 'layouts/users',
                'page'          => array(
                    'parent'    => $this->router->fetch_class(),
                    'category'  => $this->router->fetch_method(),
                    'modules'   => $page,
                    'views'     => $view,     
                    'method'    => $param1,
                    ),
                'partials'      => array(
                    'header'    => 'templates/header',
                    'footer'    => 'templates/footer',
                    'sidebar1'   => 'templates/sidebar1',
                    'sidebar2'   => 'templates/sidebar2'
                    ),
                'metadata'      => array(
                    '<script src="' . base_url("assets/private/users/js/brand.js") . '"></script>'
                    )
                );
            $this->load->view($data['template']['layouts'], $data);
        }
        else if($page == "archived")
        {
            $data['menu'] = $this->load_menus($this->session->userdata('priviledge_id'));
            $data['template']   = array(
                'title'         => 'Maintenance',
                'sub_title'     => 'Brand',
                'method'        => 'Manage',
                'body'          => 'users/archived/brand',
                'layouts'       => 'layouts/users',
                'page'          => array(
                    'parent'    => $this->router->fetch_class(),
                    'category'  => $this->router->fetch_method(),
                    'modules'   => $page,
                    'views'     => $view,     
                    'method'    => $param1,
                    ),
                'partials'      => array(
                    'header'    => 'templates/header',
                    'footer'    => 'templates/footer',
                    'sidebar1'   => 'templates/sidebar1',
                    'sidebar2'   => 'templates/sidebar2'
                    ),
                'metadata'      => array(
                    '<script src="' . base_url("assets/private/users/js/brand.js") . '"></script>'
                    )
                );
            $this->load->view($data['template']['layouts'], $data);
        }
        else if($page == "add")
        {
            $data['menu'] = $this->load_menus($this->session->userdata('priviledge_id'));
            $data['input'] = $this->brand_form_data('');
            $data['template']   = array(
                'title'         => 'Maintenance',
                'sub_title'     => 'brand',
                'method'        => 'Add',
                'body'          => 'users/add/brand',
                'layouts'       => 'layouts/users',
                'page'          => array(
                    'parent'    => $this->router->fetch_class(),
                    'category'  => $this->router->fetch_method(),
                    'modules'   => $page,
                    'views'     => $view,     
                    'method'    => $param1,
                    ),
                'partials'      => array(
                    'header'    => 'templates/header',
                    'footer'    => 'templates/footer',
                    'sidebar1'   => 'templates/sidebar1',
                    'sidebar2'   => 'templates/sidebar2'
                    ),
                'metadata'      => array(
                    '<script src="' . base_url("assets/private/users/js/brand.js") . '"></script>'
                    )
                );
            $this->load->view($data['template']['layouts'], $data);
        }
        else if($page == "edit" && $view != null)
        {
            $data['menu'] = $this->load_menus($this->session->userdata('priviledge_id'));
            $data['input'] = $this->brand_form_data($view);
            $data['template']   = array(
                'title'         => 'Maintenance',
                'sub_title'     => 'brand',
                'method'        => 'Edit',
                'body'          => 'users/edit/brand',
                'layouts'       => 'layouts/users',
                'page'          => array(
                    'parent'    => $this->router->fetch_class(),
                    'category'  => $this->router->fetch_method(),
                    'modules'   => $page,
                    'views'     => $view,     
                    'method'    => $param1,
                    ),
                'partials'      => array(
                    'header'    => 'templates/header',
                    'footer'    => 'templates/footer',
                    'sidebar1'   => 'templates/sidebar1',
                    'sidebar2'   => 'templates/sidebar2'
                    ),
                'metadata'      => array(
                    '<script src="' . base_url("assets/private/users/js/brand.js") . '"></script>'
                    )
                );
            $this->load->view($data['template']['layouts'], $data);
        }
        else if($page == "save")
        {
            if( $this->input->is_ajax_request() ) 
            {
                $brand = array(
                    'customer_id' =>  $this->input->post('customer_id'),
                    'brand_name' =>  $this->input->post('brand_name'),
                    'brand_description' => $this->input->post('brand_description')
                );

                $brand_id = $this->Brand_Model->insert($brand);

                $created = array(
                    'created_by' => '1',
                    'created_table' => 'brand',
                    'created_table_id' => $brand_id
                );
                
                $created_id = $this->Created_Model->insert($created);

                $status = array(
                    'status_code' => '1',
                    'status_description' => 'Active',
                    'status_table' => 'brand',
                    'status_table_id' => $brand_id
                );
                
                $status_id = $this->Status_Model->insert($status);

                $data = array(
                    'message' => 'The employe was successfully removed.',
                    'type'    => 'success'
                );
                echo json_encode( $data ); exit();
            }
        }
        else if($page == "update" && $view != null)
        {
            if( $this->input->is_ajax_request() ) 
            {
                $brand = array(
                    'customer_id' =>  $this->input->post('customer_id'),
                    'brand_name' =>  $this->input->post('brand_name'),
                    'brand_description' => $this->input->post('brand_description')
                );

                $this->Brand_Model->modify($brand, $view);

                $updated = array(
                    'updated_by' => '1',
                    'updated_table' => 'brand',
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
                    'status_table' => 'brand',
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
                    'status_table' => 'brand',
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

                $arr = $this->Brand_Model->find($view);           

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
                    $brands = $this->Brand_Model->like_brand($wildcard, $start_from, $limit)->result_array();
                    $total = $this->Brand_Model->likes_brand($wildcard)->num_rows();

                }
                else
                {
                    $brands = $this->Brand_Model->get_all_brand($start_from,  $limit)->result_array();
                    $total = $this->Brand_Model->get_alls_brand()->num_rows();
                }

                foreach ($brands as $key => $brand) 
                {
                    $bootgrid_arr[] = array(
                        'count_id'          => $key + 1 + $start_from,
                        'id'                => $brand['brand_id'],
                        'brand-name'        => $brand['brand_name'],
                        'brand-description' => $brand['brand_description'],
                        'customer-name'     => $this->Customer_Model->get_customer_name_by_id($brand['customer_id']),
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
                    $brands = $this->Brand_Model->like_archived_brand($wildcard, $start_from, $limit)->result_array();
                    $total = $this->Brand_Model->likes_archived_brand($wildcard)->num_rows();

                }
                else
                {
                    $brands = $this->Brand_Model->get_all_archived_brand($start_from,  $limit)->result_array();
                    $total = $this->Brand_Model->get_alls_archived_brand()->num_rows();
                }

                foreach ($brands as $key => $brand) 
                {
                    $bootgrid_arr[] = array(
                        'count_id'          => $key + 1 + $start_from,
                        'id'                => $brand['brand_id'],
                        'brand-name'        => $brand['brand_name'],
                        'brand-description' => $brand['brand_description'],
                        'customer-name'     => $this->Customer_Model->get_customer_name_by_id($brand['customer_id']),
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

    public function department_form_data($id) 
    {   
        $data = array( 
            'department_code' => $this->Department_Model->form_input_attributes('department_code', $id),
            'department_name' => $this->Department_Model->form_input_attributes('department_name', $id),
            'department_description' => $this->Department_Model->form_input_attributes('department_description', $id),
        );
        return $data;
    }

    public function department($page = null, $view = null, $param1 = null, $param2 = null)
    {   
        $this->validated();
        if($page == "manage" || $page == null)
        {
            $data['menu'] = $this->load_menus($this->session->userdata('priviledge_id'));
            $data['template']   = array(
                'title'         => 'Maintenance',
                'sub_title'     => 'Department',
                'method'        => 'Manage',
                'body'          => 'users/manage/department',
                'layouts'       => 'layouts/users',
                'page'          => array(
                    'parent'    => $this->router->fetch_class(),
                    'category'  => $this->router->fetch_method(),
                    'modules'   => $page,
                    'views'     => $view,     
                    'method'    => $param1,
                    ),
                'partials'      => array(
                    'header'    => 'templates/header',
                    'footer'    => 'templates/footer',
                    'sidebar1'   => 'templates/sidebar1',
                    'sidebar2'   => 'templates/sidebar2'
                    ),
                'metadata'      => array(
                    '<script src="' . base_url("assets/private/users/js/department.js") . '"></script>'
                    )
                );
            $this->load->view($data['template']['layouts'], $data);
        }
        else if($page == "archived")
        {
            $data['menu'] = $this->load_menus($this->session->userdata('priviledge_id'));
            $data['template']   = array(
                'title'         => 'Maintenance',
                'sub_title'     => 'Department',
                'method'        => 'Manage',
                'body'          => 'users/archived/department',
                'layouts'       => 'layouts/users',
                'page'          => array(
                    'parent'    => $this->router->fetch_class(),
                    'category'  => $this->router->fetch_method(),
                    'modules'   => $page,
                    'views'     => $view,     
                    'method'    => $param1,
                    ),
                'partials'      => array(
                    'header'    => 'templates/header',
                    'footer'    => 'templates/footer',
                    'sidebar1'   => 'templates/sidebar1',
                    'sidebar2'   => 'templates/sidebar2'
                    ),
                'metadata'      => array(
                    '<script src="' . base_url("assets/private/users/js/department.js") . '"></script>'
                    )
                );
            $this->load->view($data['template']['layouts'], $data);
        }
        else if($page == "add")
        {
            $data['menu'] = $this->load_menus($this->session->userdata('priviledge_id'));
            $data['input'] = $this->Department_form_data('');
            $data['template']   = array(
                'title'         => 'Maintenance',
                'sub_title'     => 'Department',
                'method'        => 'Add',
                'body'          => 'users/add/department',
                'layouts'       => 'layouts/users',
                'page'          => array(
                    'parent'    => $this->router->fetch_class(),
                    'category'  => $this->router->fetch_method(),
                    'modules'   => $page,
                    'views'     => $view,     
                    'method'    => $param1,
                    ),
                'partials'      => array(
                    'header'    => 'templates/header',
                    'footer'    => 'templates/footer',
                    'sidebar1'   => 'templates/sidebar1',
                    'sidebar2'   => 'templates/sidebar2'
                    ),
                'metadata'      => array(
                    '<script src="' . base_url("assets/private/users/js/department.js") . '"></script>'
                    )
                );
            $this->load->view($data['template']['layouts'], $data);
        }
        else if($page == "edit" && $view != null)
        {
            $data['menu'] = $this->load_menus($this->session->userdata('priviledge_id'));
            $data['input'] = $this->Department_form_data($view);
            $data['template']   = array(
                'title'         => 'Maintenance',
                'sub_title'     => 'Department',
                'method'        => 'Edit',
                'body'          => 'users/edit/department',
                'layouts'       => 'layouts/users',
                'page'          => array(
                    'parent'    => $this->router->fetch_class(),
                    'category'  => $this->router->fetch_method(),
                    'modules'   => $page,
                    'views'     => $view,     
                    'method'    => $param1,
                    ),
                'partials'      => array(
                    'header'    => 'templates/header',
                    'footer'    => 'templates/footer',
                    'sidebar1'   => 'templates/sidebar1',
                    'sidebar2'   => 'templates/sidebar2'
                    ),
                'metadata'      => array(
                    '<script src="' . base_url("assets/private/users/js/department.js") . '"></script>'
                    )
                );
            $this->load->view($data['template']['layouts'], $data);
        }
        else if($page == "save")
        {
            if( $this->input->is_ajax_request() ) 
            {
                $Department = array(
                    'department_code' =>  $this->input->post('department_code'),
                    'department_name' =>  $this->input->post('department_name'),
                    'department_description' => $this->input->post('department_description')
                );

                $department_id = $this->Department_Model->insert($Department);

                $created = array(
                    'created_by' => '1',
                    'created_table' => 'department',
                    'created_table_id' => $department_id
                );
                
                $created_id = $this->Created_Model->insert($created);

                $status = array(
                    'status_code' => '1',
                    'status_description' => 'Active',
                    'status_table' => 'department',
                    'status_table_id' => $department_id
                );
                
                $status_id = $this->Status_Model->insert($status);

                $data = array(
                    'message' => 'The employe was successfully removed.',
                    'type'    => 'success'
                );
                echo json_encode( $data ); exit();
            }
        }
        else if($page == "update" && $view != null)
        {
            if( $this->input->is_ajax_request() ) 
            {
                $department = array(
                    'department_code' => $this->input->post('department_code'),
                    'department_name' => $this->input->post('department_name'),
                    'department_description' => $this->input->post('department_description')
                );

                $this->Department_Model->modify($department, $view);

                $updated = array(
                    'updated_by' => '1',
                    'updated_table' => 'department',
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
                    'status_table' => 'Department',
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
                    'status_table' => 'Department',
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

                $arr = $this->Department_Model->find($view);           

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
                    $departments = $this->Department_Model->like_department($wildcard, $start_from, $limit)->result_array();
                    $total = $this->Department_Model->likes_department($wildcard)->num_rows();

                }
                else
                {
                    $departments = $this->Department_Model->get_all_department($start_from,$limit)->result_array();
                    $total = $this->Department_Model->get_alls_department()->num_rows();
                }

                foreach ($departments as $key => $department) 
                {
                    $bootgrid_arr[] = array(
                        'count_id'          => $key + 1 + $start_from,
                        'id'                => $department['department_id'],
                        'department-code'   => $department['department_code'],
                        'department-name'   => $department['department_name'],
                        'department-desc'   => $department['department_description']
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
                    $departments = $this->Department_Model->like_archived_Department($wildcard, $start_from, $limit)->result_array();
                    $total = $this->Department_Model->likes_archived_Department($wildcard)->num_rows();

                }
                else
                {
                    $departments = $this->Department_Model->get_all_archived_Department($start_from,  $limit)->result_array();
                    $total = $this->Department_Model->get_alls_archived_Department()->num_rows();
                }

                foreach ($departments as $key => $department) 
                {
                    $bootgrid_arr[] = array(
                        'count_id' => $key + 1 + $start_from,
                        'id' => $department['department_id'],
                        'department-code' => $department['department_code'],
                        'department-name' => $department['department_name'],
                        'department-desc' => $department['department_description'],
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

    public function account_form_data($id) 
    {   
        $data = array( 
            'account_name' => $this->Account_Model->form_input_attributes('account_name', $id),
            'account_description' => $this->Account_Model->form_input_attributes('account_description', $id),
            'customer_attributes' => $this->Customer_Model->form_select_attributes('customer_id'), 
                'customer_options' => $this->Customer_Model->form_select_options('customer_name'),
                'customer_selected' => $this->Customer_Model->form_selected_account_options($id)
        );
        return $data;
    }

    public function account($page = null, $view = null, $param1 = null, $param2 = null)
    {
        $this->validated();
        if($page == "manage" || $page == null)
        {
            $data['menu'] = $this->load_menus($this->session->userdata('priviledge_id'));
            $data['template']   = array(
                'title'         => 'Maintenance',
                'sub_title'     => 'account',
                'method'        => 'Manage',
                'body'          => 'users/manage/account',
                'layouts'       => 'layouts/users',
                'page'          => array(
                    'parent'    => $this->router->fetch_class(),
                    'category'  => $this->router->fetch_method(),
                    'modules'   => $page,
                    'views'     => $view,     
                    'method'    => $param1,
                    ),
                'partials'      => array(
                    'header'    => 'templates/header',
                    'footer'    => 'templates/footer',
                    'sidebar1'   => 'templates/sidebar1',
                    'sidebar2'   => 'templates/sidebar2'
                    ),
                'metadata'      => array(
                    '<script src="' . base_url("assets/private/users/js/account.js") . '"></script>'
                    )
                );
            $this->load->view($data['template']['layouts'], $data);
        }
        else if($page == "archived")
        {
            $data['menu'] = $this->load_menus($this->session->userdata('priviledge_id'));
            $data['template']   = array(
                'title'         => 'Maintenance',
                'sub_title'     => 'account',
                'method'        => 'Manage',
                'body'          => 'users/archived/account',
                'layouts'       => 'layouts/users',
                'page'          => array(
                    'parent'    => $this->router->fetch_class(),
                    'category'  => $this->router->fetch_method(),
                    'modules'   => $page,
                    'views'     => $view,     
                    'method'    => $param1,
                    ),
                'partials'      => array(
                    'header'    => 'templates/header',
                    'footer'    => 'templates/footer',
                    'sidebar1'   => 'templates/sidebar1',
                    'sidebar2'   => 'templates/sidebar2'
                    ),
                'metadata'      => array(
                    '<script src="' . base_url("assets/private/users/js/account.js") . '"></script>'
                    )
                );
            $this->load->view($data['template']['layouts'], $data);
        }
        else if($page == "add")
        {
            $data['menu'] = $this->load_menus($this->session->userdata('priviledge_id'));
            $data['input'] = $this->account_form_data('');
            $data['template']   = array(
                'title'         => 'Maintenance',
                'sub_title'     => 'account',
                'method'        => 'Add',
                'body'          => 'users/add/account',
                'layouts'       => 'layouts/users',
                'page'          => array(
                    'parent'    => $this->router->fetch_class(),
                    'category'  => $this->router->fetch_method(),
                    'modules'   => $page,
                    'views'     => $view,     
                    'method'    => $param1,
                    ),
                'partials'      => array(
                    'header'    => 'templates/header',
                    'footer'    => 'templates/footer',
                    'sidebar1'   => 'templates/sidebar1',
                    'sidebar2'   => 'templates/sidebar2'
                    ),
                'metadata'      => array(
                    '<script src="' . base_url("assets/private/users/js/account.js") . '"></script>'
                    )
                );
            $this->load->view($data['template']['layouts'], $data);
        }
        else if($page == "edit" && $view != null)
        {
            $data['menu'] = $this->load_menus($this->session->userdata('priviledge_id'));
            $data['input'] = $this->account_form_data($view);
            $data['template']   = array(
                'title'         => 'Maintenance',
                'sub_title'     => 'account',
                'method'        => 'Edit',
                'body'          => 'users/edit/account',
                'layouts'       => 'layouts/users',
                'page'          => array(
                    'parent'    => $this->router->fetch_class(),
                    'category'  => $this->router->fetch_method(),
                    'modules'   => $page,
                    'views'     => $view,     
                    'method'    => $param1,
                    ),
                'partials'      => array(
                    'header'    => 'templates/header',
                    'footer'    => 'templates/footer',
                    'sidebar1'   => 'templates/sidebar1',
                    'sidebar2'   => 'templates/sidebar2'
                    ),
                'metadata'      => array(
                    '<script src="' . base_url("assets/private/users/js/account.js") . '"></script>'
                    )
                );
            $this->load->view($data['template']['layouts'], $data);
        }
        else if($page == "save")
        {
            if( $this->input->is_ajax_request() ) 
            {
                $account = array(
                    'customer_id' =>  $this->input->post('customer_id'),
                    'account_name' =>  $this->input->post('account_name'),
                    'account_description' => $this->input->post('account_description')
                );

                $account_id = $this->Account_Model->insert($account);

                $created = array(
                    'created_by' => '1',
                    'created_table' => 'account',
                    'created_table_id' => $account_id
                );
                
                $created_id = $this->Created_Model->insert($created);

                $status = array(
                    'status_code' => '1',
                    'status_description' => 'Active',
                    'status_table' => 'account',
                    'status_table_id' => $account_id
                );
                
                $status_id = $this->Status_Model->insert($status);

                $data = array(
                    'message' => 'The employe was successfully removed.',
                    'type'    => 'success'
                );
                echo json_encode( $data ); exit();
            }
        }
        else if($page == "update" && $view != null)
        {
            if( $this->input->is_ajax_request() ) 
            {
                $account = array(
                    'customer_id' =>  $this->input->post('customer_id'),
                    'account_name' =>  $this->input->post('account_name'),
                    'account_description' => $this->input->post('account_description')
                );

                $this->Account_Model->modify($account, $view);

                $updated = array(
                    'updated_by' => '1',
                    'updated_table' => 'account',
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
                    'status_table' => 'account',
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
                    'status_table' => 'account',
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

                $arr = $this->Account_Model->find($view);           

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
                    $accounts = $this->Account_Model->like_account($wildcard, $start_from, $limit)->result_array();
                    $total = $this->Account_Model->likes_account($wildcard)->num_rows();

                }
                else
                {
                    $accounts = $this->Account_Model->get_all_account($start_from,  $limit)->result_array();
                    $total = $this->Account_Model->get_alls_account()->num_rows();
                }

                foreach ($accounts as $key => $account) 
                {
                    $bootgrid_arr[] = array(
                        'count_id'          => $key + 1 + $start_from,
                        'id'                => $account['account_id'],
                        'account-name'        => $account['account_name'],
                        'account-description' => $account['account_description'],
                        'customer-name'     => $this->Customer_Model->get_customer_name_by_id($account['customer_id']),
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
                    $accounts = $this->Account_Model->like_archived_account($wildcard, $start_from, $limit)->result_array();
                    $total = $this->Account_Model->likes_archived_account($wildcard)->num_rows();

                }
                else
                {
                    $accounts = $this->Account_Model->get_all_archived_account($start_from,  $limit)->result_array();
                    $total = $this->Account_Model->get_alls_archived_account()->num_rows();
                }

                foreach ($accounts as $key => $account) 
                {
                    $bootgrid_arr[] = array(
                        'count_id'          => $key + 1 + $start_from,
                        'id'                => $account['account_id'],
                        'account-name'        => $account['account_name'],
                        'account-description' => $account['account_description'],
                        'customer-name'     => $this->Customer_Model->get_customer_name_by_id($account['customer_id']),
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

    public function branch_form_data($id) 
    {   
        $data = array( 
            'branch_name' => $this->Branch_Model->form_input_attributes('branch_name', $id),
            'branch_description' => $this->Branch_Model->form_input_attributes('branch_description', $id),
            'account_attributes' => $this->Account_Model->form_select_attributes('account_id'), 
                'account_options' => $this->Account_Model->form_select_options('account_name'),
                'account_selected' => $this->Account_Model->form_selected_branch_options($id)
        );
        return $data;
    }

    public function branch($page = null, $view = null, $param1 = null, $param2 = null)
    {
        $this->validated();
        if($page == "manage" || $page == null)
        {
            $data['menu'] = $this->load_menus($this->session->userdata('priviledge_id'));
            $data['template']   = array(
                'title'         => 'Maintenance',
                'sub_title'     => 'branch',
                'method'        => 'Manage',
                'body'          => 'users/manage/branch',
                'layouts'       => 'layouts/users',
                'page'          => array(
                    'parent'    => $this->router->fetch_class(),
                    'category'  => $this->router->fetch_method(),
                    'modules'   => $page,
                    'views'     => $view,     
                    'method'    => $param1,
                    ),
                'partials'      => array(
                    'header'    => 'templates/header',
                    'footer'    => 'templates/footer',
                    'sidebar1'   => 'templates/sidebar1',
                    'sidebar2'   => 'templates/sidebar2'
                    ),
                'metadata'      => array(
                    '<script src="' . base_url("assets/private/users/js/branch.js") . '"></script>'
                    )
                );
            $this->load->view($data['template']['layouts'], $data);
        }
        else if($page == "archived")
        {
            $data['menu'] = $this->load_menus($this->session->userdata('priviledge_id'));
            $data['template']   = array(
                'title'         => 'Maintenance',
                'sub_title'     => 'branch',
                'method'        => 'Manage',
                'body'          => 'users/archived/branch',
                'layouts'       => 'layouts/users',
                'page'          => array(
                    'parent'    => $this->router->fetch_class(),
                    'category'  => $this->router->fetch_method(),
                    'modules'   => $page,
                    'views'     => $view,     
                    'method'    => $param1,
                    ),
                'partials'      => array(
                    'header'    => 'templates/header',
                    'footer'    => 'templates/footer',
                    'sidebar1'   => 'templates/sidebar1',
                    'sidebar2'   => 'templates/sidebar2'
                    ),
                'metadata'      => array(
                    '<script src="' . base_url("assets/private/users/js/branch.js") . '"></script>'
                    )
                );
            $this->load->view($data['template']['layouts'], $data);
        }
        else if($page == "add")
        {
            $data['menu'] = $this->load_menus($this->session->userdata('priviledge_id'));
            $data['input'] = $this->branch_form_data('');
            $data['template']   = array(
                'title'         => 'Maintenance',
                'sub_title'     => 'branch',
                'method'        => 'Add',
                'body'          => 'users/add/branch',
                'layouts'       => 'layouts/users',
                'page'          => array(
                    'parent'    => $this->router->fetch_class(),
                    'category'  => $this->router->fetch_method(),
                    'modules'   => $page,
                    'views'     => $view,     
                    'method'    => $param1,
                    ),
                'partials'      => array(
                    'header'    => 'templates/header',
                    'footer'    => 'templates/footer',
                    'sidebar1'   => 'templates/sidebar1',
                    'sidebar2'   => 'templates/sidebar2'
                    ),
                'metadata'      => array(
                    '<script src="' . base_url("assets/private/users/js/branch.js") . '"></script>'
                    )
                );
            $this->load->view($data['template']['layouts'], $data);
        }
        else if($page == "edit" && $view != null)
        {
            $data['menu'] = $this->load_menus($this->session->userdata('priviledge_id'));
            $data['input'] = $this->branch_form_data($view);
            $data['template']   = array(
                'title'         => 'Maintenance',
                'sub_title'     => 'branch',
                'method'        => 'Edit',
                'body'          => 'users/edit/branch',
                'layouts'       => 'layouts/users',
                'page'          => array(
                    'parent'    => $this->router->fetch_class(),
                    'category'  => $this->router->fetch_method(),
                    'modules'   => $page,
                    'views'     => $view,     
                    'method'    => $param1,
                    ),
                'partials'      => array(
                    'header'    => 'templates/header',
                    'footer'    => 'templates/footer',
                    'sidebar1'   => 'templates/sidebar1',
                    'sidebar2'   => 'templates/sidebar2'
                    ),
                'metadata'      => array(
                    '<script src="' . base_url("assets/private/users/js/branch.js") . '"></script>'
                    )
                );
            $this->load->view($data['template']['layouts'], $data);
        }
        else if($page == "save")
        {
            if( $this->input->is_ajax_request() ) 
            {
                $branch = array(
                    'account_id' =>  $this->input->get('account_id'),
                    'branch_name' =>  $this->input->get('branch_name'),
                    'branch_description' => $this->input->get('branch_description')
                );

                $branch_id = $this->Branch_Model->insert($branch);

                $created = array(
                    'created_by' => '1',
                    'created_table' => 'branch',
                    'created_table_id' => $branch_id
                );
                
                $created_id = $this->Created_Model->insert($created);

                $status = array(
                    'status_code' => '1',
                    'status_description' => 'Active',
                    'status_table' => 'branch',
                    'status_table_id' => $branch_id
                );
                
                $status_id = $this->Status_Model->insert($status);

                $data = array(
                    'message' => 'The employe was successfully removed.',
                    'type'    => 'success'
                );
                echo json_encode( $data ); exit();
            }
        }
        else if($page == "update" && $view != null)
        {
            if( $this->input->is_ajax_request() ) 
            {
                $branch = array(
                    'account_id' =>  $this->input->post('account_id'),
                    'branch_name' =>  $this->input->post('branch_name'),
                    'branch_description' => $this->input->post('branch_description')
                );

                $this->Branch_Model->modify($branch, $view);

                $updated = array(
                    'updated_by' => '1',
                    'updated_table' => 'branch',
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
                    'status_table' => 'branch',
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
                    'status_table' => 'branch',
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

                $arr = $this->Branch_Model->find($view);           

                echo json_encode( $arr );

                exit();

            }
        }
        else if($page == "lists")
        {
            //if( $this->input->is_ajax_request() )
            //{
                $bootgrid_arr = [];
                $current      = null != $this->input->post('current') ? $this->input->post('current') : 1;
                $limit        = $this->input->post('rowCount') == -1 ? 0 : $this->input->post('rowCount');
                $page         = $current !== null ? $current : 1;
                $start_from   = ($page-1) * $limit;
                $wildcard     = null != $this->input->post('searchPhrase') ? $this->input->post('searchPhrase') : null;
                

                if( isset($wildcard) )
                {
                    $branchs = $this->Branch_Model->like_branch($wildcard, $start_from, $limit)->result_array();
                    $total = $this->Branch_Model->likes_branch($wildcard)->num_rows();

                }
                else
                {
                    $branchs = $this->Branch_Model->get_all_branch($start_from,  $limit)->result_array();
                    $total = $this->Branch_Model->get_alls_branch()->num_rows();
                }

                foreach ($branchs as $key => $branch) 
                {
                    $bootgrid_arr[] = array(
                        'count_id'          => $key + 1 + $start_from,
                        'id'                => $branch['branch_id'],
                        'branch-name'        => $branch['branch_name'],
                        'branch-description' => $branch['branch_description'],
                        'account-name'     => $this->Account_Model->get_account_name_by_id($branch['account_id']),
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
            //}
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
                    $branchs = $this->Branch_Model->like_archived_branch($wildcard, $start_from, $limit)->result_array();
                    $total = $this->Branch_Model->likes_archived_branch($wildcard)->num_rows();

                }
                else
                {
                    $branchs = $this->Branch_Model->get_all_archived_branch($start_from,  $limit)->result_array();
                    $total = $this->Branch_Model->get_alls_archived_branch()->num_rows();
                }

                foreach ($branchs as $key => $branch) 
                {
                    $bootgrid_arr[] = array(
                        'count_id'          => $key + 1 + $start_from,
                        'id'                => $branch['branch_id'],
                        'branch-name'        => $branch['branch_name'],
                        'branch-description' => $branch['branch_description'],
                        'account-name'     => $this->Account_Model->get_account_name_by_id($branch['account_id']),
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

    public function unit_of_measurement_form_data($id) 
    {   
        $data = array( 
            'unit_of_measurement_code' => $this->Unit_Of_Measurement_Model->form_input_attributes('unit_of_measurement_code', $id),
            'unit_of_measurement_name' => $this->Unit_Of_Measurement_Model->form_input_attributes('unit_of_measurement_name', $id),
            'unit_of_measurement_description' => $this->Unit_Of_Measurement_Model->form_input_attributes('unit_of_measurement_description', $id),
        );
        return $data;
    }

    public function unit_of_measurement($page = null, $view = null, $param1 = null, $param2 = null)
    {
        $this->validated();
        if($page == "manage" || $page == null)
        {
            $data['menu'] = $this->load_menus($this->session->userdata('priviledge_id'));
            $data['template']   = array(
                'title'         => 'Maintenance',
                'sub_title'     => 'Unit of Measurement',
                'method'        => 'Manage',
                'body'          => 'users/manage/unit-of-measurement',
                'layouts'       => 'layouts/users',
                'page'          => array(
                    'parent'    => $this->router->fetch_class(),
                    'category'  => $this->router->fetch_method(),
                    'modules'   => $page,
                    'views'     => $view,     
                    'method'    => $param1,
                    ),
                'partials'      => array(
                    'header'    => 'templates/header',
                    'footer'    => 'templates/footer',
                    'sidebar1'   => 'templates/sidebar1',
                    'sidebar2'   => 'templates/sidebar2'
                    ),
                'metadata'      => array(
                    '<script src="' . base_url("assets/private/users/js/unit-of-measurement.js") . '"></script>'
                    )
                );
            $this->load->view($data['template']['layouts'], $data);
        }
        else if($page == "archived")
        {
            $data['menu'] = $this->load_menus($this->session->userdata('priviledge_id'));
            $data['template']   = array(
                'title'         => 'Maintenance',
                'sub_title'     => 'Unit of Measurement',
                'method'        => 'Archived',
                'body'          => 'users/archived/unit-of-measurement',
                'layouts'       => 'layouts/users',
                'page'          => array(
                    'parent'    => $this->router->fetch_class(),
                    'category'  => $this->router->fetch_method(),
                    'modules'   => $page,
                    'views'     => $view,     
                    'method'    => $param1,
                    ),
                'partials'      => array(
                    'header'    => 'templates/header',
                    'footer'    => 'templates/footer',
                    'sidebar1'   => 'templates/sidebar1',
                    'sidebar2'   => 'templates/sidebar2'
                    ),
                'metadata'      => array(
                    '<script src="' . base_url("assets/private/users/js/unit-of-measurement.js") . '"></script>'
                    )
                );
            $this->load->view($data['template']['layouts'], $data);
        }
        else if($page == "add")
        {
            $data['menu'] = $this->load_menus($this->session->userdata('priviledge_id'));
            $data['input'] = $this->unit_of_measurement_form_data('');
            $data['template']   = array(
                'title'         => 'Maintenance',
                'sub_title'     => 'unit_of_measurement',
                'method'        => 'Add',
                'body'          => 'users/add/unit-of-measurement',
                'layouts'       => 'layouts/users',
                'page'          => array(
                    'parent'    => $this->router->fetch_class(),
                    'category'  => $this->router->fetch_method(),
                    'modules'   => $page,
                    'views'     => $view,     
                    'method'    => $param1,
                    ),
                'partials'      => array(
                    'header'    => 'templates/header',
                    'footer'    => 'templates/footer',
                    'sidebar1'   => 'templates/sidebar1',
                    'sidebar2'   => 'templates/sidebar2'
                    ),
                'metadata'      => array(
                    '<script src="' . base_url("assets/private/users/js/unit-of-measurement.js") . '"></script>'
                    )
                );
            $this->load->view($data['template']['layouts'], $data);
        }
        else if($page == "edit" && $view != null)
        {
            $data['menu'] = $this->load_menus($this->session->userdata('priviledge_id'));
            $data['input'] = $this->unit_of_measurement_form_data($view);
            $data['template']   = array(
                'title'         => 'Maintenance',
                'sub_title'     => 'Unit of Measurement',
                'method'        => 'Edit',
                'body'          => 'users/edit/unit-of-measurement',
                'layouts'       => 'layouts/users',
                'page'          => array(
                    'parent'    => $this->router->fetch_class(),
                    'category'  => $this->router->fetch_method(),
                    'modules'   => $page,
                    'views'     => $view,     
                    'method'    => $param1,
                    ),
                'partials'      => array(
                    'header'    => 'templates/header',
                    'footer'    => 'templates/footer',
                    'sidebar1'   => 'templates/sidebar1',
                    'sidebar2'   => 'templates/sidebar2'
                    ),
                'metadata'      => array(
                    '<script src="' . base_url("assets/private/users/js/unit-of-measurement.js") . '"></script>'
                    )
                );
            $this->load->view($data['template']['layouts'], $data);
        }
        else if($page == "save")
        {
            if( $this->input->is_ajax_request() ) 
            {
                $unit_of_measurement = array(
                    'unit_of_measurement_code' =>  $this->input->post('unit_of_measurement_code'),
                    'unit_of_measurement_name' =>  $this->input->post('unit_of_measurement_name'),
                    'unit_of_measurement_description' => $this->input->post('unit_of_measurement_description')
                );

                $unit_of_measurement_id = $this->Unit_Of_Measurement_Model->insert($unit_of_measurement);

                $created = array(
                    'created_by' => '1',
                    'created_table' => 'unit_of_measurement',
                    'created_table_id' => $unit_of_measurement_id
                );
                
                $created_id = $this->Created_Model->insert($created);

                $status = array(
                    'status_code' => '1',
                    'status_description' => 'Active',
                    'status_table' => 'unit_of_measurement',
                    'status_table_id' => $unit_of_measurement_id
                );
                
                $status_id = $this->Status_Model->insert($status);

                $data = array(
                    'message' => 'The employe was successfully removed.',
                    'type'    => 'success'
                );
                echo json_encode( $data ); exit();
            }
        }
        else if($page == "update" && $view != null)
        {
            if( $this->input->is_ajax_request() ) 
            {
                $unit_of_measurement = array(
                    'unit_of_measurement_code' => $this->input->post('unit_of_measurement_code'),
                    'unit_of_measurement_name' => $this->input->post('unit_of_measurement_name'),
                    'unit_of_measurement_description' => $this->input->post('unit_of_measurement_description')
                );

                $this->Unit_Of_Measurement_Model->modify($unit_of_measurement, $view);

                $updated = array(
                    'updated_by' => '1',
                    'updated_table' => 'unit_of_measurement',
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
                    'status_table' => 'unit_of_measurement',
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
                    'status_table' => 'unit_of_measurement',
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

                $arr = $this->Unit_Of_Measurement_Model->find($view);           

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
                    $unit_of_measurements = $this->Unit_Of_Measurement_Model->like_unit_of_measurement($wildcard, $start_from, $limit)->result_array();
                    $total = $this->Unit_Of_Measurement_Model->likes_unit_of_measurement($wildcard)->num_rows();

                }
                else
                {
                    $unit_of_measurements = $this->Unit_Of_Measurement_Model->get_all_unit_of_measurement($start_from,$limit)->result_array();
                    $total = $this->Unit_Of_Measurement_Model->get_alls_unit_of_measurement()->num_rows();
                }

                foreach ($unit_of_measurements as $key => $unit_of_measurement) 
                {
                    $bootgrid_arr[] = array(
                        'count_id'          => $key + 1 + $start_from,
                        'id'                => $unit_of_measurement['unit_of_measurement_id'],
                        'unit-of-measurement-code'   => $unit_of_measurement['unit_of_measurement_code'],
                        'unit-of-measurement-name'   => $unit_of_measurement['unit_of_measurement_name'],
                        'unit-of-measurement-desc'   => $unit_of_measurement['unit_of_measurement_description']
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
                    $unit_of_measurements = $this->Unit_Of_Measurement_Model->like_archived_unit_of_measurement($wildcard, $start_from, $limit)->result_array();
                    $total = $this->Unit_Of_Measurement_Model->likes_archived_unit_of_measurement($wildcard)->num_rows();

                }
                else
                {
                    $unit_of_measurements = $this->Unit_Of_Measurement_Model->get_all_archived_unit_of_measurement($start_from,  $limit)->result_array();
                    $total = $this->Unit_Of_Measurement_Model->get_alls_archived_unit_of_measurement()->num_rows();
                }

                foreach ($unit_of_measurements as $key => $unit_of_measurement) 
                {
                    $bootgrid_arr[] = array(
                        'count_id' => $key + 1 + $start_from,
                        'id' => $unit_of_measurement['unit_of_measurement_id'],
                        'unit-of-measurement-code' => $unit_of_measurement['unit_of_measurement_code'],
                        'unit-of-measurement-name' => $unit_of_measurement['unit_of_measurement_name'],
                        'unit-of-measurement-desc' => $unit_of_measurement['unit_of_measurement_description'],
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

    public function tax_type_form_data($id) 
    {   
        $data = array( 
            'tax_type_code' => $this->Tax_Type_Model->form_input_attributes('tax_type_code', $id),
            'tax_type_name' => $this->Tax_Type_Model->form_input_attributes('tax_type_name', $id),
            'tax_type_description' => $this->Tax_Type_Model->form_input_attributes('tax_type_description', $id),
        );
        return $data;
    }

    public function tax_type($page = null, $view = null, $param1 = null, $param2 = null)
    {   
        $this->validated();
        if($page == "manage" || $page == null)
        {
            $data['menu'] = $this->load_menus($this->session->userdata('priviledge_id'));
            $data['template']   = array(
                'title'         => 'Maintenance',
                'sub_title'     => 'Tax Type',
                'method'        => 'Manage',
                'body'          => 'users/manage/tax-type',
                'layouts'       => 'layouts/users',
                'page'          => array(
                    'parent'    => $this->router->fetch_class(),
                    'category'  => $this->router->fetch_method(),
                    'modules'   => $page,
                    'views'     => $view,     
                    'method'    => $param1,
                    ),
                'partials'      => array(
                    'header'    => 'templates/header',
                    'footer'    => 'templates/footer',
                    'sidebar1'   => 'templates/sidebar1',
                    'sidebar2'   => 'templates/sidebar2'
                    ),
                'metadata'      => array(
                    '<script src="' . base_url("assets/private/users/js/tax-type.js") . '"></script>'
                    )
                );
            $this->load->view($data['template']['layouts'], $data);
        }
        else if($page == "archived")
        {
            $data['menu'] = $this->load_menus($this->session->userdata('priviledge_id'));
            $data['template']   = array(
                'title'         => 'Maintenance',
                'sub_title'     => 'Tax Type',
                'method'        => 'Manage',
                'body'          => 'users/archived/tax-type',
                'layouts'       => 'layouts/users',
                'page'          => array(
                    'parent'    => $this->router->fetch_class(),
                    'category'  => $this->router->fetch_method(),
                    'modules'   => $page,
                    'views'     => $view,     
                    'method'    => $param1,
                    ),
                'partials'      => array(
                    'header'    => 'templates/header',
                    'footer'    => 'templates/footer',
                    'sidebar1'   => 'templates/sidebar1',
                    'sidebar2'   => 'templates/sidebar2'
                    ),
                'metadata'      => array(
                    '<script src="' . base_url("assets/private/users/js/tax-type.js") . '"></script>'
                    )
                );
            $this->load->view($data['template']['layouts'], $data);
        }
        else if($page == "add")
        {
            $data['menu'] = $this->load_menus($this->session->userdata('priviledge_id'));
            $data['input'] = $this->tax_type_form_data('');
            $data['template']   = array(
                'title'         => 'Maintenance',
                'sub_title'     => 'Tax Type',
                'method'        => 'Add',
                'body'          => 'users/add/tax-type',
                'layouts'       => 'layouts/users',
                'page'          => array(
                    'parent'    => $this->router->fetch_class(),
                    'category'  => $this->router->fetch_method(),
                    'modules'   => $page,
                    'views'     => $view,     
                    'method'    => $param1,
                    ),
                'partials'      => array(
                    'header'    => 'templates/header',
                    'footer'    => 'templates/footer',
                    'sidebar1'   => 'templates/sidebar1',
                    'sidebar2'   => 'templates/sidebar2'
                    ),
                'metadata'      => array(
                    '<script src="' . base_url("assets/private/users/js/tax-type.js") . '"></script>'
                    )
                );
            $this->load->view($data['template']['layouts'], $data);
        }
        else if($page == "edit" && $view != null)
        {
            $data['menu'] = $this->load_menus($this->session->userdata('priviledge_id'));
            $data['input'] = $this->tax_type_form_data($view);
            $data['template']   = array(
                'title'         => 'Maintenance',
                'sub_title'     => 'Tax Type',
                'method'        => 'Edit',
                'body'          => 'users/edit/tax-type',
                'layouts'       => 'layouts/users',
                'page'          => array(
                    'parent'    => $this->router->fetch_class(),
                    'category'  => $this->router->fetch_method(),
                    'modules'   => $page,
                    'views'     => $view,     
                    'method'    => $param1,
                    ),
                'partials'      => array(
                    'header'    => 'templates/header',
                    'footer'    => 'templates/footer',
                    'sidebar1'   => 'templates/sidebar1',
                    'sidebar2'   => 'templates/sidebar2'
                    ),
                'metadata'      => array(
                    '<script src="' . base_url("assets/private/users/js/tax-type.js") . '"></script>'
                    )
                );
            $this->load->view($data['template']['layouts'], $data);
        }
        else if($page == "save")
        {
            if( $this->input->is_ajax_request() ) 
            {
                $tax_type = array(
                    'tax_type_code' =>  $this->input->post('tax_type_code'),
                    'tax_type_name' =>  $this->input->post('tax_type_name'),
                    'tax_type_description' => $this->input->post('tax_type_description')
                );

                $tax_type_id = $this->Tax_Type_Model->insert($tax_type);

                $created = array(
                    'created_by' => '1',
                    'created_table' => 'tax_type',
                    'created_table_id' => $tax_type_id
                );
                
                $created_id = $this->Created_Model->insert($created);

                $status = array(
                    'status_code' => '1',
                    'status_description' => 'Active',
                    'status_table' => 'tax_type',
                    'status_table_id' => $tax_type_id
                );
                
                $status_id = $this->Status_Model->insert($status);

                $data = array(
                    'message' => 'The employe was successfully removed.',
                    'type'    => 'success'
                );
                echo json_encode( $data ); exit();
            }
        }
        else if($page == "update" && $view != null)
        {
            if( $this->input->is_ajax_request() ) 
            {
                $tax_type = array(
                    'tax_type_code' => $this->input->post('tax_type_code'),
                    'tax_type_name' => $this->input->post('tax_type_name'),
                    'tax_type_description' => $this->input->post('tax_type_description')
                );

                $this->Tax_Type_Model->modify($tax_type, $view);

                $updated = array(
                    'updated_by' => '1',
                    'updated_table' => 'tax_type',
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
                    'status_table' => 'tax_type',
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
                    'status_table' => 'tax_type',
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
            if( $this->input->is_ajax_request() ) 
            {

                $arr = $this->Tax_Type_Model->find($view);           

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
                    $tax_types = $this->Tax_Type_Model->like_tax_type($wildcard, $start_from, $limit)->result_array();
                    $total = $this->Tax_Type_Model->likes_tax_type($wildcard)->num_rows();

                }
                else
                {
                    $tax_types = $this->Tax_Type_Model->get_all_tax_type($start_from,$limit)->result_array();
                    $total = $this->Tax_Type_Model->get_alls_tax_type()->num_rows();
                }

                foreach ($tax_types as $key => $tax_type) 
                {
                    $bootgrid_arr[] = array(
                        'count_id'          => $key + 1 + $start_from,
                        'id'                => $tax_type['tax_type_id'],
                        'tax-type-code'   => $tax_type['tax_type_code'],
                        'tax-type-name'   => $tax_type['tax_type_name'],
                        'tax-type-desc'   => $tax_type['tax_type_description']
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
                    $tax_types = $this->Tax_Type_Model->like_archived_tax_type($wildcard, $start_from, $limit)->result_array();
                    $total = $this->Tax_Type_Model->likes_archived_tax_type($wildcard)->num_rows();

                }
                else
                {
                    $tax_types = $this->Tax_Type_Model->get_all_archived_tax_type($start_from,  $limit)->result_array();
                    $total = $this->Tax_Type_Model->get_alls_archived_tax_type()->num_rows();
                }

                foreach ($tax_types as $key => $tax_type) 
                {
                    $bootgrid_arr[] = array(
                        'count_id' => $key + 1 + $start_from,
                        'id' => $tax_type['tax_type_id'],
                        'tax-type-code' => $tax_type['tax_type_code'],
                        'tax-type-name' => $tax_type['tax_type_name'],
                        'tax-type-desc' => $tax_type['tax_type_description'],
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

    public function contact_person_form_data($id) 
    {   
        $data = array( 
            'customer_attributes' => $this->Customer_Model->form_select_attributes('customer_id'), 
                'customer_options' => $this->Customer_Model->form_select_options('customer_name'),
                'customer_selected' => $this->Customer_Model->form_selected_contact_person_options($id),
            'contact_person_firstname' => $this->Contact_Person_Model->form_input_attributes('contact_person_firstname', $id),
            'contact_person_middlename' => $this->Contact_Person_Model->form_input_attributes('contact_person_middlename', $id),
            'contact_person_lastname' => $this->Contact_Person_Model->form_input_attributes('contact_person_lastname', $id),
            'contact_person_gender_attributes' => $this->Contact_Person_Model->form_select_gender_attributes('contact_person_gender'), 
                'contact_person_gender_options' => $this->Contact_Person_Model->form_select_gender_options('contact_person_gender'),
                'contact_person_gender_selected' => $this->Contact_Person_Model->form_selected_gender_options($id),
            'contact_person_position' => $this->Contact_Person_Model->form_input_attributes('contact_person_position', $id),
            'contact_person_birthdate' => $this->Contact_Person_Model->form_input_date_attributes('contact_person_birthdate', $id),
            'contact_person_interest' => $this->Contact_Person_Model->form_textarea_attributes('contact_person_interest', $id),
            'contact_person_remarks' => $this->Contact_Person_Model->form_textarea_attributes('contact_person_remarks', $id)
        );
        return $data;
    }

    public function contact_person($page = null, $view = null, $param1 = null, $param2 = null)
    {
        $this->validated();
        if($page == "manage" || $page == null)
        {
            $data['menu'] = $this->load_menus($this->session->userdata('priviledge_id'));
            $data['template']   = array(
                'title'         => 'Maintenance',
                'sub_title'     => 'Contact Person',
                'method'        => 'Manage',
                'body'          => 'users/manage/contact-person',
                'layouts'       => 'layouts/users',
                'page'          => array(
                    'parent'    => $this->router->fetch_class(),
                    'category'  => $this->router->fetch_method(),
                    'modules'   => $page,
                    'views'     => $view,     
                    'method'    => $param1,
                    ),
                'partials'      => array(
                    'header'    => 'templates/header',
                    'footer'    => 'templates/footer',
                    'sidebar1'   => 'templates/sidebar1',
                    'sidebar2'   => 'templates/sidebar2'
                    ),
                'metadata'      => array(
                    '<script src="' . base_url("assets/private/users/js/contact-person.js") . '"></script>'
                    )
                );
            $this->load->view($data['template']['layouts'], $data);
        }
        else if($page == "archived")
        {
            $data['menu'] = $this->load_menus($this->session->userdata('priviledge_id'));
            $data['template']   = array(
                'title'         => 'Maintenance',
                'sub_title'     => 'Contact Person',
                'method'        => 'Archived',
                'body'          => 'users/archived/contact-person',
                'layouts'       => 'layouts/users',
                'page'          => array(
                    'parent'    => $this->router->fetch_class(),
                    'category'  => $this->router->fetch_method(),
                    'modules'   => $page,
                    'views'     => $view,     
                    'method'    => $param1,
                    ),
                'partials'      => array(
                    'header'    => 'templates/header',
                    'footer'    => 'templates/footer',
                    'sidebar1'   => 'templates/sidebar1',
                    'sidebar2'   => 'templates/sidebar2'
                    ),
                'metadata'      => array(
                    '<script src="' . base_url("assets/private/users/js/contact-person.js") . '"></script>'
                    )
                );
            $this->load->view($data['template']['layouts'], $data);
        }
        else if($page == "add")
        {
            $data['menu'] = $this->load_menus($this->session->userdata('priviledge_id'));
            $data['input'] = $this->contact_person_form_data('');
            $data['template']   = array(
                'title'         => 'Maintenance',
                'sub_title'     => 'Contact Person',
                'method'        => 'Add',
                'body'          => 'users/add/contact-person',
                'layouts'       => 'layouts/users',
                'page'          => array(
                    'parent'    => $this->router->fetch_class(),
                    'category'  => $this->router->fetch_method(),
                    'modules'   => $page,
                    'views'     => $view,     
                    'method'    => $param1,
                    ),
                'partials'      => array(
                    'header'    => 'templates/header',
                    'footer'    => 'templates/footer',
                    'sidebar1'   => 'templates/sidebar1',
                    'sidebar2'   => 'templates/sidebar2'
                    ),
                'metadata'      => array(
                    '<script src="' . base_url("assets/private/users/js/contact-person.js") . '"></script>'
                    )
                );
            $this->load->view($data['template']['layouts'], $data);
        }
        else if($page == "edit" && $view != null)
        {
            $data['menu'] = $this->load_menus($this->session->userdata('priviledge_id'));
            $data['input'] = $this->contact_person_form_data($view);
            $data['template']   = array(
                'title'         => 'Maintenance',
                'sub_title'     => 'Contact Person',
                'method'        => 'Edit',
                'body'          => 'users/edit/contact-person',
                'layouts'       => 'layouts/users',
                'page'          => array(
                    'parent'    => $this->router->fetch_class(),
                    'category'  => $this->router->fetch_method(),
                    'modules'   => $page,
                    'views'     => $view,     
                    'method'    => $param1,
                    ),
                'partials'      => array(
                    'header'    => 'templates/header',
                    'footer'    => 'templates/footer',
                    'sidebar1'   => 'templates/sidebar1',
                    'sidebar2'   => 'templates/sidebar2'
                    ),
                'metadata'      => array(
                    '<script src="' . base_url("assets/private/users/js/contact-person.js") . '"></script>'
                    )
                );
            $this->load->view($data['template']['layouts'], $data);
        }
        else if($page == "save")
        {
            if( $this->input->is_ajax_request() ) 
            {   
                $contact_person = array(
                    'customer_id' =>  $this->input->post('customer_id'),
                    'contact_person_firstname' =>  $this->input->post('contact_person_firstname'),
                    'contact_person_middlename' => $this->input->post('contact_person_middlename'),
                    'contact_person_lastname' => $this->input->post('contact_person_lastname'),
                    'contact_person_position' => $this->input->post('contact_person_position'),
                    'contact_person_gender' => $this->input->post('contact_person_gender'),
                    'contact_person_birthdate' => date("Y-m-d", strtotime($this->input->post('contact_person_birthdate'))),
                    'contact_person_interest' => $this->input->post('contact_person_interest'),
                    'contact_person_remarks' => $this->input->post('contact_person_remarks')
                );

                $contact_person_id = $this->Contact_Person_Model->insert($contact_person);

                $created = array(
                    'created_by' => '1',
                    'created_table' => 'contact_person',
                    'created_table_id' => $contact_person_id
                );
                
                $created_id = $this->Created_Model->insert($created);

                $status = array(
                    'status_code' => '1',
                    'status_description' => 'Active',
                    'status_table' => 'contact_person',
                    'status_table_id' => $contact_person_id
                );
                
                $status_id = $this->Status_Model->insert($status);

                $data = array(
                    'message' => 'The contact person was successfully saved.',
                    'type'    => 'success'
                );
                echo json_encode( $data ); exit();
            }
        }
        else if($page == "update" && $view != null)
        {
            if( $this->input->is_ajax_request() ) 
            {
                $contact_person = array(
                    'customer_id' =>  $this->input->post('customer_id'),
                    'contact_person_firstname' =>  $this->input->post('contact_person_firstname'),
                    'contact_person_middlename' => $this->input->post('contact_person_middlename'),
                    'contact_person_lastname' => $this->input->post('contact_person_lastname'),
                    'contact_person_position' => $this->input->post('contact_person_position'),
                    'contact_person_gender' => $this->input->post('contact_person_gender'),
                    'contact_person_birthdate' => date("Y-m-d", strtotime($this->input->post('contact_person_birthdate'))),
                    'contact_person_interest' => $this->input->post('contact_person_interest'),
                    'contact_person_remarks' => $this->input->post('contact_person_remarks')
                );

                $this->Contact_Person_Model->modify($contact_person, $view);

                $updated = array(
                    'updated_by' => '1',
                    'updated_table' => 'contact_person',
                    'updated_table_id' => $view
                );
                
                $updated_id = $this->Updated_Model->insert($updated);

                $data = array(
                    'message' => 'The contact person was successfully updated.',
                    'type'    => 'success'
                );
                echo json_encode( $data ); exit();
            }
        }
        else if($page == "delete" && $view != null)
        {
            if( $this->input->is_ajax_request() ) 
            {
                $status = array(
                    'status_table_id' => $view,
                    'status_table' => 'contact_person',
                    'status_code' => '0',
                    'status_description' => 'Inactive'  
                );

                $status_id = $this->Status_Model->delete($status);

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
                    'status_table' => 'contact_person',
                    'status_code' => '1',
                    'status_description' => 'Active'  
                );

                $status_id = $this->Status_Model->undo($status);

                $data = array(
                    'message' => 'The employe was successfully restored.',
                    'type'    => 'success'
                );
                echo json_encode( $data ); exit();

            }   
        }
        else if($page == "find" && $view != null)
        {
            if( $this->input->is_ajax_request() ) 
            {
                $arr = $this->Contact_Person_Model->find($view);           

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
                    $contact_persons = $this->Contact_Person_Model->like_contact_person($wildcard, $start_from, $limit)->result_array();
                    $total = $this->Contact_Person_Model->likes_contact_person($wildcard)->num_rows();

                }
                else
                {
                    $contact_persons = $this->Contact_Person_Model->get_all_contact_person($start_from,$limit)->result_array();
                    $total = $this->Contact_Person_Model->get_alls_contact_person()->num_rows();
                }

                foreach ($contact_persons as $key => $contact_person) 
                {
                    $bootgrid_arr[] = array(
                        'count_id'              => $key + 1 + $start_from,
                        'contact-person-id'     => $contact_person['contact_person_id'],
                        'contact-person-name'   => $contact_person['contact_person_firstname'].' '.$contact_person['contact_person_middlename'].' '.$contact_person['contact_person_lastname'],
                        'contact-person-gender' => $contact_person['contact_person_gender'],
                        'customer-name'         => $this->Customer_Model->get_customer_name_by_id($contact_person['customer_id']),
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
                    $contact_persons = $this->Contact_Person_Model->like_archived_contact_person($wildcard, $start_from, $limit)->result_array();
                    $total = $this->Contact_Person_Model->likes_archived_contact_person($wildcard)->num_rows();

                }
                else
                {
                    $contact_persons = $this->Contact_Person_Model->get_all_archived_contact_person($start_from,  $limit)->result_array();
                    $total = $this->Contact_Person_Model->get_alls_archived_contact_person()->num_rows();
                }

                foreach ($contact_persons as $key => $contact_person) 
                {
                    $bootgrid_arr[] = array(
                        'count_id'              => $key + 1 + $start_from,
                        'contact-person-id'     => $contact_person['contact_person_id'],
                        'contact-person-name'   => $contact_person['contact_person_firstname'].' '.$contact_person['contact_person_middlename'].' '.$contact_person['contact_person_lastname'],
                        'contact-person-gender' => $contact_person['contact_person_gender'],
                        'customer-name'         => $this->Customer_Model->get_customer_name_by_id($contact_person['customer_id']),
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

    public function user_form_data($id) 
    {   
        $data = array( 
            'resources_attributes' => $this->Resources_Model->form_select_user_attributes('resources_id'), 
                'resources_options' => $this->Resources_Model->form_select_user_options('user'),
                'resources_selected' => $this->Resources_Model->form_selected_user_options($id),
            'priviledge_attributes' => $this->Priviledge_Model->form_select_attributes('priviledge_id'), 
                'priviledge_options' => $this->Priviledge_Model->form_select_options('priviledge'),
                'priviledge_selected' => $this->Priviledge_Model->form_selected_user_options($id),
            'username' => $this->User_Model->form_input_attributes('user_username', $id),
            'password' => $this->User_Model->form_input_password_attributes('user_password', $id),
            'secret_question_attributes' => $this->User_Secret_Model->form_select_attributes('user_secret_id'), 
                'secret_question_options' => $this->User_Secret_Model->form_select_options('user_secret_question'),
                'secret_question_selected' => $this->User_Secret_Model->form_selected_user_options($id),
            'secret_password' => $this->User_Model->form_input_password_attributes('user_secret_password', $id)
        );
        return $data;
    }

    public function user($page = null, $view = null, $param1 = null, $param2 = null)
    {
        $this->validated();
        if($page == "manage" || $page == null)
        {
            $data['menu'] = $this->load_menus($this->session->userdata('priviledge_id'));
            $data['template']   = array(
                'title'         => 'Maintenance',
                'sub_title'     => 'User',
                'method'        => 'Manage',
                'body'          => 'users/manage/user',
                'layouts'       => 'layouts/users',
                'page'          => array(
                    'parent'    => $this->router->fetch_class(),
                    'category'  => $this->router->fetch_method(),
                    'modules'   => $page,
                    'views'     => $view,     
                    'method'    => $param1,
                    ),
                'partials'      => array(
                    'header'    => 'templates/header',
                    'footer'    => 'templates/footer',
                    'sidebar1'   => 'templates/sidebar1',
                    'sidebar2'   => 'templates/sidebar2'
                    ),
                'metadata'      => array(
                    '<script src="' . base_url("assets/private/users/js/user.js") . '"></script>'
                    )
                );
            $this->load->view($data['template']['layouts'], $data);
        }
        else if($page == "archived")
        {
            $data['menu'] = $this->load_menus($this->session->userdata('priviledge_id'));
            $data['template']   = array(
                'title'         => 'Maintenance',
                'sub_title'     => 'User',
                'method'        => 'Archived',
                'body'          => 'users/archived/user',
                'layouts'       => 'layouts/users',
                'page'          => array(
                    'parent'    => $this->router->fetch_class(),
                    'category'  => $this->router->fetch_method(),
                    'modules'   => $page,
                    'views'     => $view,     
                    'method'    => $param1,
                    ),
                'partials'      => array(
                    'header'    => 'templates/header',
                    'footer'    => 'templates/footer',
                    'sidebar1'   => 'templates/sidebar1',
                    'sidebar2'   => 'templates/sidebar2'
                    ),
                'metadata'      => array(
                    '<script src="' . base_url("assets/private/users/js/user.js") . '"></script>'
                    )
                );
            $this->load->view($data['template']['layouts'], $data);
        }
        else if($page == "add")
        {
            $data['menu'] = $this->load_menus($this->session->userdata('priviledge_id'));
            $data['input'] = $this->user_form_data('');
            $data['template']   = array(
                'title'         => 'Maintenance',
                'sub_title'     => 'User',
                'method'        => 'Add',
                'body'          => 'users/add/user',
                'layouts'       => 'layouts/users',
                'page'          => array(
                    'parent'    => $this->router->fetch_class(),
                    'category'  => $this->router->fetch_method(),
                    'modules'   => $page,
                    'views'     => $view,     
                    'method'    => $param1,
                    ),
                'partials'      => array(
                    'header'    => 'templates/header',
                    'footer'    => 'templates/footer',
                    'sidebar1'   => 'templates/sidebar1',
                    'sidebar2'   => 'templates/sidebar2'
                    ),
                'metadata'      => array(
                    '<script src="' . base_url("assets/private/users/js/user.js") . '"></script>'
                    )
                );
            $this->load->view($data['template']['layouts'], $data);
        }
        else if($page == "edit" && $view != null)
        {
            $data['menu'] = $this->load_menus($this->session->userdata('priviledge_id'));
            $data['input'] = $this->user_form_data($view);
            $data['template']   = array(
                'title'         => 'Maintenance',
                'sub_title'     => 'User',
                'method'        => 'Edit',
                'body'          => 'users/edit/user',
                'layouts'       => 'layouts/users',
                'page'          => array(
                    'parent'    => $this->router->fetch_class(),
                    'category'  => $this->router->fetch_method(),
                    'modules'   => $page,
                    'views'     => $view,     
                    'method'    => $param1,
                    ),
                'partials'      => array(
                    'header'    => 'templates/header',
                    'footer'    => 'templates/footer',
                    'sidebar1'   => 'templates/sidebar1',
                    'sidebar2'   => 'templates/sidebar2'
                    ),
                'metadata'      => array(
                    '<script src="' . base_url("assets/private/users/js/user.js") . '"></script>'
                    )
                );
            $this->load->view($data['template']['layouts'], $data);
        }
        else if($page == "save")
        {
            //if( $this->input->is_ajax_request() ) 
            //{
                $user = array(
                    'resources_id' => $this->input->post('resources_id'),
                    'priviledge_id' =>  $this->input->post('priviledge_id'),
                    'user_username' => $this->input->post('username'),
                    'user_password' => password_hash($this->input->post('password'), PASSWORD_BCRYPT),
                    'user_secret_id' => $this->input->post('user_secret_id'),
                    'user_secret_password' => password_hash($this->input->post('secret_password'), PASSWORD_BCRYPT)
                );

                $user_id = $this->User_Model->insert($user);

                $created = array(
                    'created_by' => '1',
                    'created_table' => 'user',
                    'created_table_id' => $user_id
                );
                
                $created_id = $this->Created_Model->insert($created);

                $status = array(
                    'status_code' => '1',
                    'status_description' => 'Active',
                    'status_table' => 'user',
                    'status_table_id' => $user_id
                );
                
                $status_id = $this->Status_Model->insert($status);

                $data = array(
                    'message' => 'The user was successfully saved.',
                    'type'    => 'success'
                );
                echo json_encode( $data ); exit();
            //}
        }
        else if($page == "update" && $view != null)
        {
            if( $this->input->is_ajax_request() ) 
            {
                $user = array(
                    'resources_id' => $this->input->post('resources_id'),
                    'priviledge_id' =>  $this->input->post('priviledge_id'),
                    'user_username' => $this->input->post('username'),
                    'user_password' => password_hash($this->input->post('password'), PASSWORD_BCRYPT),
                    'user_secret_id' => $this->input->post('user_secret_id'),
                    'user_secret_password' => password_hash($this->input->post('secret_password'), PASSWORD_BCRYPT)
                );

                $this->User_Model->modify($user, $view);

                $updated = array(
                    'updated_by' => '1',
                    'updated_table' => 'user',
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
                    'status_table' => 'user',
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
                    'message' => 'The user was successfully removed.',
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
                    'status_table' => 'user',
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
                    'message' => 'The user was successfully restored.',
                    'type'    => 'success'
                );
                echo json_encode( $data ); exit();

            }   
        }
        else if($page == "find" && $view != null)
        {
            if( $this->input->is_ajax_request() ) {

                $arr = $this->User_Model->find($view);           

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
                    $users = $this->User_Model->like_user($wildcard, $start_from, $limit)->result_array();
                    $total = $this->User_Model->likes_user($wildcard)->num_rows();

                }
                else
                {
                    $users = $this->User_Model->get_all_user($start_from,$limit)->result_array();
                    $total = $this->User_Model->get_alls_user()->num_rows();
                }

                foreach ($users as $key => $user) 
                {
                    $bootgrid_arr[] = array(
                        'count_id' => $key + 1 + $start_from,
                        'user-id' => $user['user_id'],
                        'user-res' => $this->Resources_Model->get_resources_name_by_id($user['resources_id']),
                        'user-priv' => $this->Priviledge_Model->get_priviledge_name_by_id($user['priviledge_id']),
                        'user-name' => $user['user_username'],
                        'user-secret' => $this->User_Secret_Model->get_secret_question_by_id($user['user_secret_id'])
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
                    $users = $this->User_Model->like_archived_user($wildcard, $start_from, $limit)->result_array();
                    $total = $this->User_Model->likes_archived_user($wildcard)->num_rows();

                }
                else
                {
                    $users = $this->User_Model->get_all_archived_user($start_from,$limit)->result_array();
                    $total = $this->User_Model->get_alls_archived_user()->num_rows();
                }

                foreach ($users as $key => $user) 
                {
                    $bootgrid_arr[] = array(
                        'count_id' => $key + 1 + $start_from,
                        'user-id' => $user['user_id'],
                        'user-res' => $this->Resources_Model->get_resources_name_by_id($user['resources_id']),
                        'user-priv' => $this->Priviledge_Model->get_priviledge_name_by_id($user['priviledge_id']),
                        'user-name' => $user['user_username'],
                        'user-secret' => $this->User_Secret_Model->get_secret_question_by_id($user['user_secret_id'])
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

    

    public function priviledge_form_data($id) 
    {   
        $data = array(
            'priviledge_code' => $this->Priviledge_Model->form_input_attributes('priviledge_code', $id),
            'priviledge_name' => $this->Priviledge_Model->form_input_attributes('priviledge_name', $id),
            'priviledge_description' => $this->Priviledge_Model->form_input_attributes('priviledge_description', $id),
            'modules' => $this->Priviledge_Model->priviledge_modules($id)
        );
        return $data;
    }

    public function priviledge($page = null, $view = null, $param1 = null, $param2 = null)
    {
        $this->validated();
        if($page == "manage" || $page == null)
        {
            $data['menu'] = $this->load_menus($this->session->userdata('priviledge_id'));
            $data['template']   = array(
                'title'         => 'Maintenance',
                'sub_title'     => 'Priviledge',
                'method'        => 'Manage',
                'body'          => 'users/manage/priviledge',
                'layouts'       => 'layouts/users',
                'page'          => array(
                    'parent'    => $this->router->fetch_class(),
                    'category'  => $this->router->fetch_method(),
                    'modules'   => $page,
                    'views'     => $view,     
                    'method'    => $param1,
                    ),
                'partials'      => array(
                    'header'    => 'templates/header',
                    'footer'    => 'templates/footer',
                    'sidebar1'   => 'templates/sidebar1',
                    'sidebar2'   => 'templates/sidebar2'
                    ),
                'metadata'      => array(
                    '<script src="' . base_url("assets/private/users/js/priviledge.js") . '"></script>'
                    )
                );
            $this->load->view($data['template']['layouts'], $data);
        }
        else if($page == "archived" || $page == null)
        {
            $data['menu'] = $this->load_menus($this->session->userdata('priviledge_id'));
            $data['template']   = array(
                'title'         => 'Maintenance',
                'sub_title'     => 'Priviledge',
                'method'        => 'Archived',
                'body'          => 'users/archived/priviledge',
                'layouts'       => 'layouts/users',
                'page'          => array(
                    'parent'    => $this->router->fetch_class(),
                    'category'  => $this->router->fetch_method(),
                    'modules'   => $page,
                    'views'     => $view,     
                    'method'    => $param1,
                    ),
                'partials'      => array(
                    'header'    => 'templates/header',
                    'footer'    => 'templates/footer',
                    'sidebar1'   => 'templates/sidebar1',
                    'sidebar2'   => 'templates/sidebar2'
                    ),
                'metadata'      => array(
                    '<script src="' . base_url("assets/private/users/js/priviledge.js") . '"></script>'
                    )
                );
            $this->load->view($data['template']['layouts'], $data);
        }
        else if($page == "add")
        {
            $data['menu'] = $this->load_menus($this->session->userdata('priviledge_id'));
            $data['input'] = $this->priviledge_form_data('');
            $data['template']   = array(
                'title'         => 'Maintenance',
                'sub_title'     => 'Priviledge',
                'method'        => 'Add',
                'body'          => 'users/add/priviledge',
                'layouts'       => 'layouts/users',
                'page'          => array(
                    'parent'    => $this->router->fetch_class(),
                    'category'  => $this->router->fetch_method(),
                    'modules'   => $page,
                    'views'     => $view,     
                    'method'    => $param1,
                    ),
                'partials'      => array(
                    'header'    => 'templates/header',
                    'footer'    => 'templates/footer',
                    'sidebar1'   => 'templates/sidebar1',
                    'sidebar2'   => 'templates/sidebar2'
                    ),
                'metadata'      => array(
                    '<script src="' . base_url("assets/private/users/js/priviledge.js") . '"></script>'
                    )
                );
            $this->load->view($data['template']['layouts'], $data);
        }
        else if($page == "edit" && $view != null)
        {
            $data['menu'] = $this->load_menus($this->session->userdata('priviledge_id'));
            $data['input'] = $this->priviledge_form_data($view);
            $data['template']   = array(
                'title'         => 'Maintenance',
                'sub_title'     => 'Priviledge',
                'method'        => 'Edit',
                'body'          => 'users/edit/priviledge',
                'layouts'       => 'layouts/users',
                'page'          => array(
                    'parent'    => $this->router->fetch_class(),
                    'category'  => $this->router->fetch_method(),
                    'modules'   => $page,
                    'views'     => $view,     
                    'method'    => $param1,
                    ),
                'partials'      => array(
                    'header'    => 'templates/header',
                    'footer'    => 'templates/footer',
                    'sidebar1'   => 'templates/sidebar1',
                    'sidebar2'   => 'templates/sidebar2'
                    ),
                'metadata'      => array(
                    '<script src="' . base_url("assets/private/users/js/priviledge.js") . '"></script>'
                    )
                );
            $this->load->view($data['template']['layouts'], $data);
        }
        else if($page == "save")
        {
            if( $this->input->is_ajax_request() ) 
            {
                $priviledge = array(
                    'priviledge_code' => $this->input->post('code'),
                    'priviledge_name' =>  $this->input->post('name'),
                    'priviledge_description' => $this->input->post('description') 
                );

                $priviledge_id = $this->Priviledge_Model->insert($priviledge);

                foreach($this->input->post('priviledges') as $item)
                {
                    list($modules_id, $sub_modules_id) = explode(',',$item);

                    if($sub_modules_id != "mods")
                    {
                        $module = array(
                            'modules_id' => $modules_id,
                            'sub_modules_id' => $sub_modules_id,
                            'priviledge_id' => $priviledge_id
                        );

                        $mod_sub_id = $this->Modules_Sub_Module_Model->insert($module);
                    }

                    $res = $this->Priviledge_Module_Model->check($modules_id, $priviledge_id); 

                    if($res > 0)
                    {

                    } 
                    else 
                    {
                        $priviledge_mod = array(
                            'priviledge_id' => $priviledge_id,
                            'modules_id' => $modules_id
                        );

                        $priv_mod_id = $this->Priviledge_Module_Model->insert($priviledge_mod);
                    }

                }

                $created = array(
                    'created_by' => '1',
                    'created_table' => 'priviledge',
                    'created_table_id' => $priviledge_id
                );
                
                $created_id = $this->Created_Model->insert($created);

                $status = array(
                    'status_code' => '1',
                    'status_description' => 'Active',
                    'status_table' => 'priviledge',
                    'status_table_id' => $priviledge_id
                );
                
                $status_id = $this->Status_Model->insert($status);

                $data = array(
                    'message' => 'The priviledge was successfully saved.',
                    'type'    => 'success'
                );
                echo json_encode( $data ); exit();
            }
        }
        else if($page == "update" && $view != null)
        {
            if( $this->input->is_ajax_request() ) 
            {
                $priviledge = array(
                    'priviledge_code' => $this->input->post('code'),
                    'priviledge_name' =>  $this->input->post('name'),
                    'priviledge_description' => $this->input->post('description') 
                );

                $this->Priviledge_Model->modify($priviledge, $view);

                $this->Modules_Sub_Module_Model->delete($view);
                $this->Priviledge_Module_Model->delete($view);

                foreach($this->input->post('priviledges') as $item)
                {
                    list($modules_id, $sub_modules_id) = explode(',',$item);

                    if($sub_modules_id != "mods")
                    {
                        $module = array(
                            'modules_id' => $modules_id,
                            'sub_modules_id' => $sub_modules_id,
                            'priviledge_id' => $view
                        );

                        $mod_sub_id = $this->Modules_Sub_Module_Model->insert($module);
                    }

                    $res = $this->Priviledge_Module_Model->check($modules_id, $view); 

                    if($res > 0)
                    {

                    } 
                    else 
                    {
                        $priviledge_mod = array(
                            'priviledge_id' => $view,
                            'modules_id' => $modules_id
                        );

                        $priv_mod_id = $this->Priviledge_Module_Model->insert($priviledge_mod);
                    }

                }

                $updated = array(
                    'updated_by' => '1',
                    'updated_table' => 'customer',
                    'updated_table_id' => $view
                );
                
                $updated_id = $this->Updated_Model->insert($updated);

                $data = array(
                    'message' => 'The priviledge was successfully updated.',
                    'type'    => 'success'
                );
                echo json_encode( $data ); exit();
            }
        }
        else if($page == "delete" && $view != null)
        {
            if( $this->input->is_ajax_request() ) 
            {
                $status = array(
                    'status_table_id' => $view,
                    'status_table' => 'priviledge',
                    'status_code' => '0',
                    'status_description' => 'Inactive'  
                );

                $status_id = $this->Status_Model->delete($status);

                $data = array(
                    'message' => 'The priviledge was successfully removed.',
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
                    'status_table' => 'priviledge',
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
                    'message' => 'The priviledge was successfully restored.',
                    'type'    => 'success'
                );
                echo json_encode( $data ); exit();

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
                    $priviledges = $this->Priviledge_Model->like_priviledge($wildcard, $start_from, $limit)->result_array();
                    $total = $this->Priviledge_Model->likes_priviledge($wildcard)->num_rows();

                }
                else
                {
                    $priviledges = $this->Priviledge_Model->get_all_priviledge($start_from,$limit)->result_array();
                    $total = $this->Priviledge_Model->get_alls_priviledge()->num_rows();
                }

                foreach ($priviledges as $key => $priviledge) 
                {
                    $bootgrid_arr[] = array(
                        'count_id' => $key + 1 + $start_from,
                        'priv-id' => $priviledge['priviledge_id'],
                        'priv-code' => $priviledge['priviledge_code'],
                        'priv-name' => $priviledge['priviledge_name'],
                        'priv-desc' => $priviledge['priviledge_description']
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
                    $priviledges = $this->Priviledge_Model->like_archived_priviledge($wildcard, $start_from, $limit)->result_array();
                    $total = $this->Priviledge_Model->likes_archived_priviledge($wildcard)->num_rows();

                }
                else
                {
                    $priviledges = $this->Priviledge_Model->get_all_archived_priviledge($start_from,$limit)->result_array();
                    $total = $this->Priviledge_Model->get_alls_archived_priviledge()->num_rows();
                }

                foreach ($priviledges as $key => $priviledge) 
                {
                    $bootgrid_arr[] = array(
                        'count_id' => $key + 1 + $start_from,
                        'priv-id' => $priviledge['priviledge_id'],
                        'priv-code' => $priviledge['priviledge_code'],
                        'priv-name' => $priviledge['priviledge_name'],
                        'priv-desc' => $priviledge['priviledge_description']
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

    public function powder_plastic_coat_form_data($id) 
    {   
        $data = array( 
            'powder_plastic_coat_code' => $this->Powder_Plastic_Coat_Model->form_input_attributes('powder_plastic_coat_code', $id),
            'powder_plastic_coat_name' => $this->Powder_Plastic_Coat_Model->form_input_attributes('powder_plastic_coat_name', $id),
            'powder_plastic_coat_description' => $this->Powder_Plastic_Coat_Model->form_input_attributes('powder_plastic_coat_description', $id),
            'powder_plastic_coat_weighted_ave' => $this->Powder_Plastic_Coat_Model->form_input_numeric_attributes('powder_plastic_coat_weighted_ave', $id),
            'unit_of_measurement_attributes' => $this->Unit_Of_Measurement_Model->form_select_attributes('unit_of_measurement_id'), 
                'unit_of_measurement_options' => $this->Unit_Of_Measurement_Model->form_select_options('unit_of_measurement'),
                'unit_of_measurement_selected' => $this->Unit_Of_Measurement_Model->form_selected_powder_plastic_coat_options($id),
        );
        return $data;
    }

    public function powder_plastic_coat($page = null, $view = null, $param1 = null, $param2 = null)
    {   
        $this->validated();
        if($page == "manage" || $page == null)
        {
            $data['menu'] = $this->load_menus($this->session->userdata('priviledge_id'));
            $data['template']   = array(
                'title'         => 'Maintenance',
                'sub_title'     => 'Powder Plastic Coat',
                'method'        => 'Manage',
                'body'          => 'users/manage/powder-plastic-coat',
                'layouts'       => 'layouts/users',
                'page'          => array(
                    'parent'    => $this->router->fetch_class(),
                    'category'  => $this->router->fetch_method(),
                    'modules'   => $page,
                    'views'     => $view,     
                    'method'    => $param1,
                    ),
                'partials'      => array(
                    'header'    => 'templates/header',
                    'footer'    => 'templates/footer',
                    'sidebar1'   => 'templates/sidebar1',
                    'sidebar2'   => 'templates/sidebar2'
                    ),
                'metadata'      => array(
                    '<script src="' . base_url("assets/private/users/js/powder-plastic-coat.js") . '"></script>'
                    )
                );
            $this->load->view($data['template']['layouts'], $data);
        }
        else if($page == "archived")
        {
            $data['menu'] = $this->load_menus($this->session->userdata('priviledge_id'));
            $data['template']   = array(
                'title'         => 'Maintenance',
                'sub_title'     => 'Powder Plastic Coat',
                'method'        => 'Archived',
                'body'          => 'users/archived/powder-plastic-coat',
                'layouts'       => 'layouts/users',
                'page'          => array(
                    'parent'    => $this->router->fetch_class(),
                    'category'  => $this->router->fetch_method(),
                    'modules'   => $page,
                    'views'     => $view,     
                    'method'    => $param1,
                    ),
                'partials'      => array(
                    'header'    => 'templates/header',
                    'footer'    => 'templates/footer',
                    'sidebar1'   => 'templates/sidebar1',
                    'sidebar2'   => 'templates/sidebar2'
                    ),
                'metadata'      => array(
                    '<script src="' . base_url("assets/private/users/js/powder-plastic-coat.js") . '"></script>'
                    )
                );
            $this->load->view($data['template']['layouts'], $data);
        }
        else if($page == "add")
        {
            $data['menu'] = $this->load_menus($this->session->userdata('priviledge_id'));
            $data['input'] = $this->Powder_Plastic_Coat_form_data('');
            $data['template']   = array(
                'title'         => 'Maintenance',
                'sub_title'     => 'Powder Plastic Coat',
                'method'        => 'Add',
                'body'          => 'users/add/powder-plastic-coat',
                'layouts'       => 'layouts/users',
                'page'          => array(
                    'parent'    => $this->router->fetch_class(),
                    'category'  => $this->router->fetch_method(),
                    'modules'   => $page,
                    'views'     => $view,     
                    'method'    => $param1,
                    ),
                'partials'      => array(
                    'header'    => 'templates/header',
                    'footer'    => 'templates/footer',
                    'sidebar1'   => 'templates/sidebar1',
                    'sidebar2'   => 'templates/sidebar2'
                    ),
                'metadata'      => array(
                    '<script src="' . base_url("assets/private/users/js/powder-plastic-coat.js") . '"></script>'
                    )
                );
            $this->load->view($data['template']['layouts'], $data);
        }
        else if($page == "edit" && $view != null)
        {
            $data['menu'] = $this->load_menus($this->session->userdata('priviledge_id'));
            $data['input'] = $this->Powder_Plastic_Coat_form_data($view);
            $data['template']   = array(
                'title'         => 'Maintenance',
                'sub_title'     => 'Powder Plastic Coat',
                'method'        => 'Edit',
                'body'          => 'users/edit/powder-plastic-coat',
                'layouts'       => 'layouts/users',
                'page'          => array(
                    'parent'    => $this->router->fetch_class(),
                    'category'  => $this->router->fetch_method(),
                    'modules'   => $page,
                    'views'     => $view,     
                    'method'    => $param1,
                    ),
                'partials'      => array(
                    'header'    => 'templates/header',
                    'footer'    => 'templates/footer',
                    'sidebar1'   => 'templates/sidebar1',
                    'sidebar2'   => 'templates/sidebar2'
                    ),
                'metadata'      => array(
                    '<script src="' . base_url("assets/private/users/js/powder-plastic-coat.js") . '"></script>'
                    )
                );
            $this->load->view($data['template']['layouts'], $data);
        }
        else if($page == "save")
        {
            if( $this->input->is_ajax_request() ) 
            {
                $powder_plastic_coat = array(
                    'powder_plastic_coat_code' =>  $this->input->post('code'),
                    'powder_plastic_coat_name' =>  $this->input->post('name'),
                    'powder_plastic_coat_description' => $this->input->post('description'),
                    'powder_plastic_coat_weighted_ave' => $this->input->post('weighted_ave'),
                    'unit_of_measurement_id' => $this->input->post('unit_of_measurement_id')
                );

                $powder_plastic_coat_id = $this->Powder_Plastic_Coat_Model->insert($powder_plastic_coat);

                $created = array(
                    'created_by' => '1',
                    'created_table' => 'powder_plastic_coat',
                    'created_table_id' => $powder_plastic_coat_id
                );
                
                $created_id = $this->Created_Model->insert($created);

                $status = array(
                    'status_code' => '1',
                    'status_description' => 'Active',
                    'status_table' => 'powder_plastic_coat',
                    'status_table_id' => $powder_plastic_coat_id
                );
                
                $status_id = $this->Status_Model->insert($status);

                $data = array(
                    'message' => 'The powder plastic coat was successfully saved.',
                    'type'    => 'success'
                );
                echo json_encode( $data ); exit();
            }
        }
        else if($page == "update" && $view != null)
        {
            if( $this->input->is_ajax_request() ) 
            {
                $powder_plastic_coat = array(
                    'powder_plastic_coat_code' =>  $this->input->post('code'),
                    'powder_plastic_coat_name' =>  $this->input->post('name'),
                    'powder_plastic_coat_description' => $this->input->post('description'),
                    'powder_plastic_coat_weighted_ave' => $this->input->post('weighted_ave'),
                    'unit_of_measurement_id' => $this->input->post('unit_of_measurement_id')
                );

                $this->Powder_Plastic_Coat_Model->modify($powder_plastic_coat, $view);

                $updated = array(
                    'updated_by' => '1',
                    'updated_table' => 'powder_plastic_coat',
                    'updated_table_id' => $view
                );
                
                $updated_id = $this->Updated_Model->insert($updated);

                $data = array(
                    'message' => 'The powder plastic coat was successfully updated.',
                    'type'    => 'success'
                );
                echo json_encode( $data ); exit();
            }
        }
        else if($page == "delete" && $view != null)
        {
            if( $this->input->is_ajax_request() ) 
            {
                $status = array(
                    'status_table_id' => $view,
                    'status_table' => 'powder_plastic_coat',
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
                    'message' => 'The powder plastic coat was successfully removed.',
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
                    'status_table' => 'powder_plastic_coat',
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
                    'message' => 'The powder plastic coat was successfully restored.',
                    'type'    => 'success'
                );
                echo json_encode( $data ); exit();
            }   
        }
        else if($page == "find" && $view != null)
        {
            if( $this->input->is_ajax_request() ) {

                $arr = $this->Powder_Plastic_Coat_Model->find($view);           

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
                    $powder_plastic_coats = $this->Powder_Plastic_Coat_Model->like_powder_plastic_coat($wildcard, $start_from, $limit)->result_array();
                    $total = $this->Powder_Plastic_Coat_Model->likes_powder_plastic_coat($wildcard)->num_rows();

                }
                else
                {
                    $powder_plastic_coats = $this->Powder_Plastic_Coat_Model->get_all_powder_plastic_coat($start_from,$limit)->result_array();
                    $total = $this->Powder_Plastic_Coat_Model->get_alls_powder_plastic_coat()->num_rows();
                }

                foreach ($powder_plastic_coats as $key => $powder_plastic_coat) 
                {
                    $bootgrid_arr[] = array(
                        'count_id' => $key + 1 + $start_from,
                        'id'       => $powder_plastic_coat['powder_plastic_coat_id'],
                        'code'     => $powder_plastic_coat['powder_plastic_coat_code'],
                        'name'     => $powder_plastic_coat['powder_plastic_coat_name'],
                        'desc'     => $powder_plastic_coat['powder_plastic_coat_description'],
                        'weight'   => $powder_plastic_coat['powder_plastic_coat_weighted_ave'],
                        'uom'      => $this->Unit_Of_Measurement_Model->get_uom_name_by_id($powder_plastic_coat['unit_of_measurement_id'])
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
                    $powder_plastic_coats = $this->Powder_Plastic_Coat_Model->like_archived_powder_plastic_coat($wildcard, $start_from, $limit)->result_array();
                    $total = $this->Powder_Plastic_Coat_Model->likes_archived_powder_plastic_coat($wildcard)->num_rows();

                }
                else
                {
                    $powder_plastic_coats = $this->Powder_Plastic_Coat_Model->get_all_archived_powder_plastic_coat($start_from,  $limit)->result_array();
                    $total = $this->Powder_Plastic_Coat_Model->get_alls_archived_powder_plastic_coat()->num_rows();
                }

                foreach ($powder_plastic_coats as $key => $powder_plastic_coat) 
                {
                    $bootgrid_arr[] = array(
                        'count_id' => $key + 1 + $start_from,
                        'id'       => $powder_plastic_coat['powder_plastic_coat_id'],
                        'code'     => $powder_plastic_coat['powder_plastic_coat_code'],
                        'name'     => $powder_plastic_coat['powder_plastic_coat_name'],
                        'desc'     => $powder_plastic_coat['powder_plastic_coat_description'],
                        'weight'   => $powder_plastic_coat['powder_plastic_coat_weighted_ave'],
                        'uom'      => $this->Unit_Of_Measurement_Model->get_uom_name_by_id($powder_plastic_coat['unit_of_measurement_id'])
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

    public function painting_cost_form_data($id) 
    {   
        $data = array( 
            'code' => $this->Painting_Cost_Model->form_input_attributes('painting_cost_code', $id),
            'name' => $this->Painting_Cost_Model->form_input_attributes('painting_cost_name', $id),
            'description' => $this->Painting_Cost_Model->form_input_attributes('painting_cost_description', $id),
            'cost' => $this->Painting_Cost_Model->form_input_numeric_attributes('painting_cost_price', $id),
        );
        return $data;
    }

    public function painting_cost($page = null, $view = null, $param1 = null, $param2 = null)
    {   
        $this->validated();
        if($page == "manage" || $page == null)
        {
            $data['menu'] = $this->load_menus($this->session->userdata('priviledge_id'));
            $data['template']   = array(
                'title'         => 'Maintenance',
                'sub_title'     => 'Painting Cost',
                'method'        => 'Manage',
                'body'          => 'users/manage/painting-cost',
                'layouts'       => 'layouts/users',
                'page'          => array(
                    'parent'    => $this->router->fetch_class(),
                    'category'  => $this->router->fetch_method(),
                    'modules'   => $page,
                    'views'     => $view,     
                    'method'    => $param1,
                    ),
                'partials'      => array(
                    'header'    => 'templates/header',
                    'footer'    => 'templates/footer',
                    'sidebar1'   => 'templates/sidebar1',
                    'sidebar2'   => 'templates/sidebar2'
                    ),
                'metadata'      => array(
                    '<script src="' . base_url("assets/private/users/js/painting-cost.js") . '"></script>'
                    )
                );
            $this->load->view($data['template']['layouts'], $data);
        }
        else if($page == "archived")
        {
            $data['menu'] = $this->load_menus($this->session->userdata('priviledge_id'));
            $data['template']   = array(
                'title'         => 'Maintenance',
                'sub_title'     => 'Painting Cost',
                'method'        => 'Archived',
                'body'          => 'users/archived/painting-cost',
                'layouts'       => 'layouts/users',
                'page'          => array(
                    'parent'    => $this->router->fetch_class(),
                    'category'  => $this->router->fetch_method(),
                    'modules'   => $page,
                    'views'     => $view,     
                    'method'    => $param1,
                    ),
                'partials'      => array(
                    'header'    => 'templates/header',
                    'footer'    => 'templates/footer',
                    'sidebar1'   => 'templates/sidebar1',
                    'sidebar2'   => 'templates/sidebar2'
                    ),
                'metadata'      => array(
                    '<script src="' . base_url("assets/private/users/js/painting-cost.js") . '"></script>'
                    )
                );
            $this->load->view($data['template']['layouts'], $data);
        }
        else if($page == "add")
        {
            $data['menu'] = $this->load_menus($this->session->userdata('priviledge_id'));
            $data['input'] = $this->painting_cost_form_data('');
            $data['template']   = array(
                'title'         => 'Maintenance',
                'sub_title'     => 'Painting Cost',
                'method'        => 'Add',
                'body'          => 'users/add/painting-cost',
                'layouts'       => 'layouts/users',
                'page'          => array(
                    'parent'    => $this->router->fetch_class(),
                    'category'  => $this->router->fetch_method(),
                    'modules'   => $page,
                    'views'     => $view,     
                    'method'    => $param1,
                    ),
                'partials'      => array(
                    'header'    => 'templates/header',
                    'footer'    => 'templates/footer',
                    'sidebar1'   => 'templates/sidebar1',
                    'sidebar2'   => 'templates/sidebar2'
                    ),
                'metadata'      => array(
                    '<script src="' . base_url("assets/private/users/js/painting-cost.js") . '"></script>'
                    )
                );
            $this->load->view($data['template']['layouts'], $data);
        }
        else if($page == "edit" && $view != null)
        {
            $data['menu'] = $this->load_menus($this->session->userdata('priviledge_id'));
            $data['input'] = $this->painting_cost_form_data($view);
            $data['template']   = array(
                'title'         => 'Maintenance',
                'sub_title'     => 'Painting Cost',
                'method'        => 'Edit',
                'body'          => 'users/edit/painting-cost',
                'layouts'       => 'layouts/users',
                'page'          => array(
                    'parent'    => $this->router->fetch_class(),
                    'category'  => $this->router->fetch_method(),
                    'modules'   => $page,
                    'views'     => $view,     
                    'method'    => $param1,
                    ),
                'partials'      => array(
                    'header'    => 'templates/header',
                    'footer'    => 'templates/footer',
                    'sidebar1'   => 'templates/sidebar1',
                    'sidebar2'   => 'templates/sidebar2'
                    ),
                'metadata'      => array(
                    '<script src="' . base_url("assets/private/users/js/painting-cost.js") . '"></script>'
                    )
                );
            $this->load->view($data['template']['layouts'], $data);
        }
        else if($page == "save")
        {
            if( $this->input->is_ajax_request() ) 
            {
                $painting_cost = array(
                    'painting_cost_code' =>  $this->input->post('painting_cost_code'),
                    'painting_cost_name' =>  $this->input->post('painting_cost_name'),
                    'painting_cost_description' => $this->input->post('painting_cost_description'),
                    'painting_cost_price' => $this->input->post('painting_cost_price')
                );

                $painting_cost_id = $this->Painting_Cost_Model->insert($painting_cost);

                $created = array(
                    'created_by' => '1',
                    'created_table' => 'painting_cost',
                    'created_table_id' => $painting_cost_id
                );
                
                $created_id = $this->Created_Model->insert($created);

                $status = array(
                    'status_code' => '1',
                    'status_description' => 'Active',
                    'status_table' => 'painting_cost',
                    'status_table_id' => $painting_cost_id
                );
                
                $status_id = $this->Status_Model->insert($status);

                $data = array(
                    'message' => 'The painting cost was successfully saved.',
                    'type'    => 'success'
                );
                echo json_encode( $data ); exit();
            }
        }
        else if($page == "update" && $view != null)
        {
            if( $this->input->is_ajax_request() ) 
            {
                $painting_cost = array(
                    'painting_cost_code' =>  $this->input->post('painting_cost_code'),
                    'painting_cost_name' =>  $this->input->post('painting_cost_name'),
                    'painting_cost_description' => $this->input->post('painting_cost_description'),
                    'painting_cost_price' => $this->input->post('painting_cost_price')
                );

                $this->Painting_Cost_Model->modify($painting_cost, $view);

                $updated = array(
                    'updated_by' => '1',
                    'updated_table' => 'painting_cost',
                    'updated_table_id' => $view
                );
                
                $updated_id = $this->Updated_Model->insert($updated);

                $data = array(
                    'message' => 'The painting cost was successfully updated.',
                    'type'    => 'success'
                );
                echo json_encode( $data ); exit();
            }
        }
        else if($page == "delete" && $view != null)
        {
            if( $this->input->is_ajax_request() ) 
            {
                $status = array(
                    'status_table_id' => $view,
                    'status_table' => 'painting_cost',
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
                    'message' => 'The painting cost was successfully removed.',
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
                    'status_table' => 'painting_cost',
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
                    'message' => 'The painting cost was successfully restored.',
                    'type'    => 'success'
                );
                echo json_encode( $data ); exit();
            }   
        }
        else if($page == "find" && $view != null)
        {
            if( $this->input->is_ajax_request() ) {

                $arr = $this->Painting_Cost_Model->find($view);           

                echo json_encode( $arr );

                exit();

            }
        }
        else if($page == "lists")
        {
            //if( $this->input->is_ajax_request() )
            //{
                $bootgrid_arr = [];
                $current      = null != $this->input->post('current') ? $this->input->post('current') : 1;
                $limit        = $this->input->post('rowCount') == -1 ? 0 : $this->input->post('rowCount');
                $page         = $current !== null ? $current : 1;
                $start_from   = ($page-1) * $limit;
                $wildcard     = null != $this->input->post('searchPhrase') ? $this->input->post('searchPhrase') : null;
                

                if( isset($wildcard) )
                {
                    $painting_costs = $this->Painting_Cost_Model->like_painting_cost($wildcard, $start_from, $limit)->result_array();
                    $total = $this->Painting_Cost_Model->likes_painting_cost($wildcard)->num_rows();

                }
                else
                {
                    $painting_costs = $this->Painting_Cost_Model->get_all_painting_cost($start_from,$limit)->result_array();
                    $total = $this->Painting_Cost_Model->get_alls_painting_cost()->num_rows();
                }

                foreach ($painting_costs as $key => $painting_cost) 
                {
                    $bootgrid_arr[] = array(
                        'count_id'          => $key + 1 + $start_from,
                        'id'    =>  $painting_cost['painting_cost_id'],
                        'code'  =>  $painting_cost['painting_cost_code'],
                        'name'  =>  $painting_cost['painting_cost_name'],
                        'desc'  =>  $painting_cost['painting_cost_description'],
                        'cost'  =>  $painting_cost['painting_cost_price']
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
            //}
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
                    $painting_costs = $this->Painting_Cost_Model->like_archived_painting_cost($wildcard, $start_from, $limit)->result_array();
                    $total = $this->Painting_Cost_Model->likes_archived_painting_cost($wildcard)->num_rows();

                }
                else
                {
                    $painting_costs = $this->Painting_Cost_Model->get_all_archived_painting_cost($start_from,  $limit)->result_array();
                    $total = $this->Painting_Cost_Model->get_alls_archived_painting_cost()->num_rows();
                }

                foreach ($painting_costs as $key => $painting_cost) 
                {
                    $bootgrid_arr[] = array(
                        'count_id'          => $key + 1 + $start_from,
                        'id'    =>  $painting_cost['painting_cost_id'],
                        'code'  =>  $painting_cost['painting_cost_code'],
                        'name'  =>  $painting_cost['painting_cost_name'],
                        'desc'  =>  $painting_cost['painting_cost_description'],
                        'cost'  =>  $painting_cost['painting_cost_price']
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
    ////// test
}