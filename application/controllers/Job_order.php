<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Job_order extends CI_Controller {
    
    private $data = array();

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('download');
        $this->load_models();
    }

    public function auth()
    {

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
            'Job_Type_Model' => 'Job_Type_Model',
            'Job_Order_Model' => 'Job_Order_Model',
            'Department_Model' => 'Department_Model',
            'Job_Order_Bill_Model' => 'Job_Order_Bill_Model',
            'Contact_Person_Model' => 'Contact_Person_Model',
            'Unit_Of_Measurement_Model' => 'Unit_Of_Measurement_Model',
            'Job_Order_Materials_Model' => 'Job_Order_Materials_Model',
            'Job_Order_Instructions_Model' => 'Job_Order_Instructions_Model',
            'Brand_Model' => 'Brand_Model',
            'Account_Model' => 'Account_Model',
            'Branch_Model' => 'Branch_Model',
            'Job_Order_Po_Model' => 'Job_Order_Po_Model',
            'Job_Order_Brand_Model' => 'Job_Order_Brand_Model',
            'Job_Order_Account_Model' => 'Job_Order_Account_Model',
            'Job_Order_Branch_Model' => 'Job_Order_Branch_Model',
            'Job_Order_Tags_Model' => 'Job_Order_Tags_Model',
            'Job_Order_Contact_Person_Model' => 'Job_Order_Contact_Person_Model',
            'Job_Status_Model' => 'Job_Status_Model',
            'Job_Request_Model' => 'Job_Request_Model',
            'Job_Request_Type_Model' => 'Job_Request_Type_Model',
            'Job_Request_Category_Model' => 'Job_Request_Category_Model',
            'Job_Request_Module_Model' => 'Job_Request_Module_Model',
            'Uploads_Model' => 'Uploads_Model',
            'Product_Category_Model' => 'Product_Category_Model',
            'Sub_Category_Model' => 'Sub_Category_Model',
            'Packing_Instructions_Model' => 'Packing_Instructions_Model',
            'Job_Element_Model' => 'Job_Element_Model'
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

    public function job_order_form_data($id) 
    {   
        $data = array( 
            'job_order_no' => $this->Job_Order_Model->form_input_jo_no_attributes('job_order_no', $id),
            'job_status' => $this->Job_Order_Model->form_input_jo_status_attributes('job_status_id', $id),
            'job_type_attributes' => $this->Job_Type_Model->form_select_jo_attributes('job_type_id'), 
                'job_type_options' => $this->Job_Type_Model->form_select_jo_options('job_type'),
                'job_type_selected' => $this->Job_Type_Model->form_selected_jo_options($id),
            'customer_attributes' => $this->Customer_Model->form_select_attributes('customer_id'), 
                'customer_options' => $this->Customer_Model->form_select_options('customer_name'),
                'customer_selected' => $this->Customer_Model->form_selected_jo_cus_options($id),
            'job_order_name' => $this->Job_Order_Model->form_input_jo_attributes('job_order_name', $id),
            'department_attributes' => $this->Department_Model->form_select_attributes('department_id'), 
                'department_options' => $this->Department_Model->form_select_options('project_manage_by'),
                'department_selected' => $this->Department_Model->form_selected_jo_options($id),
            'business_unit_attributes' => $this->Business_Unit_Model->form_select_attributes_jo('business_unit_id'), 
                'business_unit_options' => $this->Business_Unit_Model->form_select_options('business_unit'),
                'business_unit_selected' => $this->Business_Unit_Model->form_selected_jo_options($id),
            'resources_attributes' => $this->Resources_Model->form_select_jo_attributes('resources_id'), 
                'resources_options' => $this->Resources_Model->form_select_options('account executive'),
                'resources_selected' => $this->Resources_Model->form_selected_jo_options($id),
            'contact_person_attributes' => $this->Contact_Person_Model->form_select_attributes('contact_person_id'), 
                'contact_person_options' => $this->Contact_Person_Model->form_select_jo_options('contact_person', $id),
                'contact_person_selected' => $this->Contact_Person_Model->form_selected_jo_options($id),
            'unit_of_measurement_attributes' => $this->Unit_Of_Measurement_Model->form_select_attributes('unit_of_measurement_id'), 
                'unit_of_measurement_options' => $this->Unit_Of_Measurement_Model->form_select_options('unit_of_measurement'),
                'unit_of_measurement_selected' => $this->Unit_Of_Measurement_Model->form_selected_jo_options($id),
            'job_quantity' => $this->Job_Order_Model->form_input_numeric_jo_attributes('job_order_qty', $id),
            'job_order_materials_description' => $this->Job_Order_Materials_Model->form_textarea_jo_attributes('job_order_materials_description', $id),
            'job_order_instructions_description' => $this->Job_Order_Instructions_Model->form_textarea_jo_attributes('job_order_instructions_description', $id),
            'brand_attributes' => $this->Brand_Model->form_select_attributes('brand_id'), 
                'brand_options' => $this->Brand_Model->form_select_jo_options('brand', $id),
                'brand_selected' => $this->Brand_Model->form_selected_jo_options($id),
            'account_attributes' => $this->Account_Model->form_select_attributes('account_id'), 
                'account_options' => $this->Account_Model->form_select_jo_options('account', $id),
                'account_selected' => $this->Account_Model->form_selected_jo_options($id),
            'branch_attributes' => $this->Branch_Model->form_select_attributes('branch_id'), 
                'branch_options' => $this->Branch_Model->form_select_jo_options('branch', $id),
                'branch_selected' => $this->Branch_Model->form_selected_jo_options($id), 
            'job_order_po_no' => $this->Job_Order_Po_Model->form_input_jo_attributes('job_order_po_no', $id),
            'job_order_po_date' => $this->Job_Order_Po_Model->form_input_date_jo_attributes('job_order_po_date', $id),
            'job_order_barcode' => $this->Job_Order_Model->form_input_jo_attributes('job_order_barcode', $id),   
            'bill_to_attributes' => $this->Customer_Model->form_select_attributes('bill_to'), 
                'bill_to_options' => $this->Customer_Model->form_select_options('bill_to'),
                'bill_to_selected' => $this->Customer_Model->form_selected_jo_options($id), 
            'billing_discount' => $this->Job_Order_Bill_Model->form_input_numeric_jo_attributes('billing_discount', $id),
            'billing_quantity' => $this->Job_Order_Bill_Model->form_input_numeric_jo_attributes('billing_quantity', $id),
            'job_uom_attributes' => $this->Unit_Of_Measurement_Model->form_select_jo_attributes('billing_uom'), 
                'job_uom_options' => $this->Unit_Of_Measurement_Model->form_select_jo_options('unit_of_measurement'),
                'job_uom_selected' => $this->Unit_Of_Measurement_Model->form_selected_jo_options($id),
            'job_order_tags_attributes' => $this->Job_Order_Model->form_select_jo_multiple_attributes('job_order_tags'), 
                'job_order_tags_options' => $this->Job_Order_Model->form_select_jo_multiple_options('job_order_tags'),
                'job_order_tags_selected' => $this->Job_Order_Model->form_selected_jo_multiple_options($id), 
            'jo_reasons' => $this->Job_Order_Model->form_textarea_jo_free_attributes('job_order_free_reasons', $id)
        );
        return $data;
    }

    public function index($page = null, $view = null, $param1 = null, $param2 = null)
    {
        $data['menu'] = $this->load_menus($this->session->userdata('priviledge_id'));
        $data['template']   = array(
            'title'         => '('.$this->Modules_Model->get_modules_name(2).' '.str_replace('_', ' ',ucfirst($this->router->fetch_class())).')',
            'sub_title'     => '',
            'method'        => 'Manage',
            'body'          => 'users/manage/job-order',
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
                '<script src="' . base_url("assets/private/users/js/job-order.js") . '"></script>'
                )
            );
        $this->load->view($data['template']['layouts'], $data);    
    }

    public function manage($page = null, $view = null, $param1 = null, $param2 = null)
    {   
        if($page == null)
        {
            $data['menu'] = $this->load_menus($this->session->userdata('priviledge_id'));
            $data['template']   = array(
                'title'         => 'Job Order',
                'sub_title'     => '',
                'method'        => 'Manage',
                'body'          => 'users/manage/job-order',
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
                    '<script src="' . base_url("assets/private/users/js/job-order.js") . '"></script>'
                    )
                );
            $this->load->view($data['template']['layouts'], $data);  
        }
        else if($page == "add")
        {
            $data['menu'] = $this->load_menus($this->session->userdata('priviledge_id'));
            $data['input'] = $this->job_order_form_data('');
            $data['free_job_order'] = array(
                'free' => $this->Job_Order_Model->find_job_order_free_by_id('job_order_free', ''),
                'reasons' => $this->Job_Order_Model->find_job_order_free_by_id('job_order_free_reasons', '')
            );
            $data['template']   = array(
            'title'         => 'Job Order',
            'sub_title'     => '',
            'method'        => 'Add',
            'body'          => 'users/add/job-order',
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
                '<script src="' . base_url("assets/private/users/js/job-order.js") . '"></script>'
                )
            );
            $this->load->view($data['template']['layouts'], $data);
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
                    $jobs = $this->Job_Order_Model->like_job($wildcard, $start_from, $limit)->result_array();
                    $total = $this->Job_Order_Model->likes_job($wildcard)->num_rows();

                }
                else
                {
                    $jobs = $this->Job_Order_Model->get_all_job($start_from,  $limit)->result_array();
                    $total = $this->Job_Order_Model->get_alls_job()->num_rows();
                }

                foreach ($jobs as $key => $job) 
                {
                    $bootgrid_arr[] = array(
                        'count_id'=> $key + 1 + $start_from,
                        'job-no' => $job['job_order_no'],
                        'job-name' => $job['job_order_name'],
                        'job-customer' => $this->Customer_Model->get_customer_name_by_id($job['customer_id']),
                        'job-ae' => $this->Customer_Model->get_account_executive_name_by_customer_id($job['customer_id']),
                        'job-qty' => $job['job_order_qty'],
                        'job-uom' => $this->Unit_Of_Measurement_Model->get_uom_name_by_id($job['unit_of_measurement_id']),
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
        else if($page == "bills")
        {
            if( $this->input->is_ajax_request() )
            {
                $bootgrid_arr = [];
                $current      = null != $this->input->post('current') ? $this->input->post('current') : 1;
                $limit        = $this->input->post('rowCount') == -1 ? 0 : $this->input->post('rowCount');
                $page         = $current !== null ? $current : 1;
                $start_from   = ($page-1) * $limit;
                $wildcard     = null != $this->input->post('searchPhrase') ? $this->input->post('searchPhrase') : null;
                $job_number = $this->input->post('job_number');

                if( isset($wildcard) )
                {
                    $job_bills = $this->Job_Order_Bill_Model->like_job_bills($wildcard, $start_from, $limit)->result_array();
                    $total = $this->Job_Order_Bill_Model->likes_job_bills($wildcard)->num_rows();

                }
                else
                {
                    $job_bills = $this->Job_Order_Bill_Model->get_all_job_bills($start_from,$limit, $job_number)->result_array();
                    $total = $this->Job_Order_Bill_Model->get_alls_job_bills($job_number)->num_rows();
                }

                foreach ($job_bills as $key => $job_bill) 
                {
                    $bootgrid_arr[] = array(
                        'count_id'          => $key + 1 + $start_from,
                        'job-order-bill-id'     => $job_bill['job_order_bill_id'],
                        'job-order-bill-to'     => $this->Customer_Model->get_customer_name_by_id($job_bill['customer_id']),
                        'job-order-bill-qty'    => $job_bill['job_order_bill_qty'],
                        'job-order-bill-uom'    => $this->Unit_Of_Measurement_Model->get_uom_name_by_id($job_bill['unit_of_measurement_id']),
                        'job-order-bill-dc'     => $job_bill['job_order_bill_discount']
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
        else if($page == "initial")
        {
            if( $this->input->is_ajax_request() )
            { 
                $job_id = $this->Job_Order_Model->find_job_id_by_job_no($this->input->get('job_no'));

                $job_order_bill = array(
                    'job_order_id' => $job_id,
                    'customer_id' =>  $this->input->get('job_bill'),
                    'job_order_bill_discount' =>  $this->input->get('job_dc'),
                    'job_order_bill_qty' => $this->input->get('job_qty'),
                    'unit_of_measurement_id' => $this->input->get('job_uom'),
                );

                $job_order_bill_id = $this->Job_Order_Bill_Model->insert($job_order_bill);

                $created = array(
                    'created_by' => '1',
                    'created_table' => 'job_order_bill',
                    'created_table_id' => $job_order_bill_id
                );
                
                $created_id = $this->Created_Model->insert($created);

                $status = array(
                    'status_code' => '1',
                    'status_description' => 'Active',
                    'status_table' => 'job_order_bill',
                    'status_table_id' => $job_order_bill_id
                );
                
                $status_id = $this->Status_Model->insert($status);

                $data = array(
                    'message' => 'The job order bill was successfully saved.',
                    'type'    => 'success'
                );
                echo json_encode( $data ); exit();
            }
        }
        else if($page == "save-bill")
        {   
            if( $this->input->is_ajax_request() )
            { 
                $job_id = $this->Job_Order_Model->find_job_id_by_job_no($this->input->get('job_order_no'));

                $job_order_bill = array(
                    'job_order_id' => $job_id,
                    'customer_id' =>  $this->input->post('bill_to'),
                    'job_order_bill_discount' =>  $this->input->post('billing_discount'),
                    'job_order_bill_qty' => $this->input->post('billing_quantity'),
                    'unit_of_measurement_id' => $this->input->post('billing_uom'),
                );

                $job_order_bill_id = $this->Job_Order_Bill_Model->insert($job_order_bill);

                $created = array(
                    'created_by' => '1',
                    'created_table' => 'job_order_bill',
                    'created_table_id' => $job_order_bill_id
                );
                
                $created_id = $this->Created_Model->insert($created);

                $status = array(
                    'status_code' => '1',
                    'status_description' => 'Active',
                    'status_table' => 'job_order_bill',
                    'status_table_id' => $job_order_bill_id
                );
                
                $status_id = $this->Status_Model->insert($status);

                $data = array(
                    'message' => 'The job order bill was successfully saved.',
                    'type'    => 'success'
                );
                echo json_encode( $data ); exit();
            }
        }
        else if($page == "edit-bill" && $view != null)
        {
            if( $this->input->is_ajax_request() ) {

                $arr = $this->Job_Order_Bill_Model->find($view);           

                echo json_encode( $arr );

                exit();

            }
        }
        else if($page == "update-bill")
        {
            if( $this->input->is_ajax_request() ) 
            {
                $job_order_bill = array(
                    'customer_id' =>  $this->input->post('bill_to'),
                    'job_order_bill_discount' =>  $this->input->post('billing_discount'),
                    'job_order_bill_qty' => $this->input->post('billing_quantity'),
                    'unit_of_measurement_id' => $this->input->post('billing_uom'),
                );

                $this->Job_Order_Bill_Model->change($job_order_bill, $this->input->get('bill_no'));

                $updated = array(
                    'updated_by' => '1',
                    'updated_table' => 'job_order_bill',
                    'updated_table_id' => $this->input->get('bill_no')
                );
                
                $this->Updated_Model->insert($updated);

                $data = array(
                    'message' => 'The job order was successfully updated.',
                    'type'    => 'success'
                );
                echo json_encode( $data ); exit();

            }
        }
        else if($page == "del-bill" && $view != null)
        {   
            if( $this->input->is_ajax_request() ) 
            {
                $status = array(
                    'status_table_id' => $view,
                    'status_table' => 'job_order_bill',
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
        else if($page == "save")
        {
            if( $this->input->is_ajax_request() )
            {   
                $job_order_count = $this->Job_Order_Model->count_jo();
                $job_no = $this->input->get('business_unit_id').substr(date("Y"),2).'-'.$job_order_count;

                $job_order = array(
                    'job_type_id' =>  $this->input->post('job_type_id'),
                    'customer_id' => $this->input->post('customer_id'),
                    'department_id' => $this->input->post('department_id'),
                    'unit_of_measurement_id' => $this->input->post('unit_of_measurement_id'),
                    'job_order_no' => $job_no,
                    'job_order_name' => $this->input->post('job_order_name'),
                    'job_order_qty' => $this->input->post('job_order_qty'),
                    'job_order_barcode' => $this->input->post('job_order_barcode'),
                    'job_status_id' => '1',
                    'job_order_free' => $this->input->post('free_job_order'),
                    'job_order_free_reasons' => $this->input->post('job_order_free_reasons')
                );

                $job_order_id = $this->Job_Order_Model->insert($job_order);

                $created = array(
                    'created_by' => '1',
                    'created_table' => 'job_order',
                    'created_table_id' => $job_order_id
                );
                
                $created_id = $this->Created_Model->insert($created);

                $job_order_materials = array(
                    'job_order_id' => $job_order_id,
                    'job_order_materials_description' => $this->input->post('job_order_materials_description')
                );

                $job_order_materials_id = $this->Job_Order_Materials_Model->insert($job_order_materials);

                $job_order_instructions = array(
                    'job_order_id' => $job_order_id,
                    'job_order_instructions_description' => $this->input->post('job_order_instructions_description')
                );

                $job_order_instructions_id = $this->Job_Order_Instructions_Model->insert($job_order_instructions);

                $job_order_po = array(
                    'job_order_id' => $job_order_id,
                    'job_order_po_no' => $this->input->post('job_order_po_no'),
                    'job_order_po_date' => date("Y-m-d", strtotime($this->input->post('job_order_po_date')))
                );

                $job_order_po_id = $this->Job_Order_Po_Model->insert($job_order_po);


                if( null !== $this->input->post('job_order_tags') )
                {   
                    $this->Job_Order_Tags_Model->delete($job_order_id);

                    foreach($this->input->post('job_order_tags') as $item)
                    {
                        $job_order_tags = array(
                            'job_order_id' => $job_order_id,
                            'job_order_id_tag' => $item
                        );
                        
                        $job_order_tags_id = $this->Job_Order_Tags_Model->insert($job_order_tags);
                    }
                }

                if( null !== $this->input->post('contact_person_id') )
                {
                    $job_order_contact_persons = array(
                        'job_order_id' => $job_order_id,
                        'contact_person_id' => $this->input->post('contact_person_id')
                    );

                    $this->Job_Order_Contact_Person_Model->delete($job_order_id);
                    $job_order_brand_id = $this->Job_Order_Contact_Person_Model->insert($job_order_contact_persons);
                }

                if( null !== $this->input->post('brand_id') )
                {
                    $job_order_brands = array(
                        'job_order_id' => $job_order_id,
                        'brand_id' => $this->input->post('brand_id')
                    );

                    $this->Job_Order_Brand_Model->delete($job_order_id);
                    $job_order_brand_id = $this->Job_Order_Brand_Model->insert($job_order_brands);
                }

                if( null !== $this->input->post('account_id') )
                {
                    $job_order_accounts = array(
                        'job_order_id' => $job_order_id,
                        'account_id' => $this->input->post('account_id')
                    );

                    $this->Job_Order_Account_Model->delete($job_order_id);
                    $job_order_account_id = $this->Job_Order_Account_Model->insert($job_order_accounts);
                }

                if( null !== $this->input->post('branch_id') )
                {
                    $job_order_branchs = array(
                        'job_order_id' => $job_order_id,
                        'branch_id' => $this->input->post('branch_id')
                    );

                    $this->Job_Order_Branch_Model->delete($job_order_id);
                    $job_order_branch_id = $this->Job_Order_Branch_Model->insert($job_order_branchs);
                }

                $data = array(
                    'job_no' => $job_no,
                    'job_qty' => $this->input->post('job_order_qty'),
                    'job_uom' => $this->input->post('unit_of_measurement_id'),
                    'job_bill' => $this->input->post('customer_id'),
                    'message' => 'The job order was successfully saved.',
                    'type'    => 'success'
                );
                echo json_encode( $data ); exit();
            }
        }
        else if($page == "update")
        {
            if( $this->input->is_ajax_request() )
            {                   
                $job_order = array(
                    'job_type_id' =>  $this->input->post('job_type_id'),
                    'customer_id' => $this->input->post('customer_id'),
                    'department_id' => $this->input->post('department_id'),
                    'unit_of_measurement_id' => $this->input->post('unit_of_measurement_id'),
                    'job_order_name' => $this->input->post('job_order_name'),
                    'job_order_qty' => $this->input->post('job_order_qty'),
                    'job_order_barcode' => $this->input->post('job_order_barcode'),
                    'job_order_free' => $this->input->post('free_job_order'),
                    'job_order_free_reasons' => $this->input->get('job_order_free_reasons')
                );

                $this->Job_Order_Model->modify($job_order, $this->input->get('job_order_no'));

                $job_id = $this->Job_Order_Model->find_job_id_by_job_no($this->input->get('job_order_no'));

                $updated = array(
                    'updated_by' => '1',
                    'updated_table' => 'job_order',
                    'updated_table_id' => $job_id
                );
                
                $this->Updated_Model->insert($updated);

                $job_order_materials = array(
                    'job_order_materials_description' => $this->input->post('job_order_materials_description')
                );

                $this->Job_Order_Materials_Model->modify($job_order_materials, $job_id);

                $job_order_instructions = array(
                    'job_order_instructions_description' => $this->input->post('job_order_instructions_description')
                );

                $this->Job_Order_Instructions_Model->modify($job_order_instructions, $job_id);

                $job_order_po = array(
                    'job_order_po_no' => $this->input->post('job_order_po_no'),
                    'job_order_po_date' => date("Y-m-d", strtotime($this->input->post('job_order_po_date')))
                );

                $this->Job_Order_Po_Model->modify($job_order_po, $job_id);

                if( null !== $this->input->post('job_order_tags') )
                {   
                    $this->Job_Order_Tags_Model->delete($job_id);
                    
                    foreach($this->input->post('job_order_tags') as $item)
                    {
                        $job_order_tags = array(
                            'job_order_id' => $job_id,
                            'job_order_id_tag' => $item
                        );
                        
                        $job_order_tags_id = $this->Job_Order_Tags_Model->insert($job_order_tags);
                    }
                } else {
                    $this->Job_Order_Tags_Model->delete($job_id);
                }

                if( null !== $this->input->post('contact_person_id') )
                {
                    $job_order_contact_persons = array(
                        'job_order_id' => $job_id,
                        'contact_person_id' => $this->input->post('contact_person_id')
                    );

                    $this->Job_Order_Contact_Person_Model->delete($job_id);
                    $job_order_brand_id = $this->Job_Order_Contact_Person_Model->insert($job_order_contact_persons);
                }

                if( null !== $this->input->post('brand_id') )
                {
                    $job_order_brands = array(
                        'job_order_id' => $job_id,
                        'brand_id' => $this->input->post('brand_id')
                    );

                    $this->Job_Order_Brand_Model->delete($job_id);
                    $job_order_brand_id = $this->Job_Order_Brand_Model->insert($job_order_brands);
                }

                if( null !== $this->input->post('account_id') )
                {
                    $job_order_accounts = array(
                        'job_order_id' => $job_id,
                        'account_id' => $this->input->post('account_id')
                    );

                    $this->Job_Order_Account_Model->delete($job_id);
                    $job_order_account_id = $this->Job_Order_Account_Model->insert($job_order_accounts);
                }

                if( null !== $this->input->post('branch_id') )
                {
                    $job_order_branchs = array(
                        'job_order_id' => $job_id,
                        'branch_id' => $this->input->post('branch_id')
                    );

                    $this->Job_Order_Branch_Model->delete($job_id);
                    $job_order_branch_id = $this->Job_Order_Branch_Model->insert($job_order_branchs);
                }


                $check = $this->Job_Order_Bill_Model->check_rows($job_id, $this->input->post('customer_id'), 0, $this->input->post('job_order_qty'), $this->input->post('unit_of_measurement_id'));

                if($check  == 'many'){

                } 
                else if($check == 'none') 
                {
                    $job_order_bill = array(
                        'job_order_id' => $job_id,
                        'customer_id' =>  $this->input->post('customer_id'),
                        'job_order_bill_discount' =>  0,
                        'job_order_bill_qty' => $this->input->post('job_order_qty'),
                        'unit_of_measurement_id' => $this->input->post('unit_of_measurement_id'),
                    );

                    $job_order_bill_id = $this->Job_Order_Bill_Model->modify($job_order_bill, $job_id);

                    $updated = array(
                        'updated_by' => '1',
                        'updated_table' => 'job_order_bill',
                        'updated_table_id' => $job_id
                    );
                    
                    $updated_id = $this->Updated_Model->insert($updated);
                } 
                else if($check == 'nothing')
                {
                    $job_order_bill = array(
                        'job_order_id' => $job_id,
                        'customer_id' =>  $this->input->post('customer_id'),
                        'job_order_bill_discount' =>  0,
                        'job_order_bill_qty' => $this->input->post('job_order_qty'),
                        'unit_of_measurement_id' => $this->input->post('unit_of_measurement_id'),
                    );

                    $job_order_bill_id = $this->Job_Order_Bill_Model->insert($job_order_bill);

                    $created = array(
                        'created_by' => '1',
                        'created_table' => 'job_order_bill',
                        'created_table_id' => $job_order_bill_id
                    );
                    
                    $created_id = $this->Created_Model->insert($created);

                    $status = array(
                        'status_code' => '1',
                        'status_description' => 'Active',
                        'status_table' => 'job_order_bill',
                        'status_table_id' => $job_order_bill_id
                    );
                    
                    $status_id = $this->Status_Model->insert($status);
                }

                $data = array(
                    'message' => 'The job order was successfully updated.',
                    'type'    => 'success'
                );
                echo json_encode( $data ); exit();
            }
        }
        else if($page == "edit" && $view != null)
        {
            $data['menu'] = $this->load_menus($this->session->userdata('priviledge_id'));
            $data['input'] = $this->job_order_form_data($view);
            $data['free_job_order'] = array(
                'free' => $this->Job_Order_Model->find_job_order_free_by_id('job_order_free', $view),
                'reasons' => $this->Job_Order_Model->find_job_order_free_by_id('job_order_free_reasons',$view)
            );
            $data['template']   = array(
            'title'         => 'Job Order',
            'sub_title'     => '',
            'method'        => 'Edit',
            'body'          => 'users/edit/job-order',
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
                '<script src="' . base_url("assets/private/users/js/job-order.js") . '"></script>'
                )
            );
            $this->load->view($data['template']['layouts'], $data);
        }     
    
        else if($page == "job-request" && is_numeric(substr($view, 0, 3)))
        {   
            if($param1 == null && $param2 == null)
            {
                $data['menu'] = $this->load_menus($this->session->userdata('priviledge_id'));
                $data['template']   = array(
                    'title'         => $page,
                    'sub_title'     => '',
                    'method'        => 'Manage',
                    'body'          => 'users/manage/job-request',
                    'layouts'       => 'layouts/users',
                    'page'          => array(
                        'parent'    => $this->router->fetch_class(),
                        'category'  => $this->router->fetch_method(),
                        'modules'   => $page,
                        'views'     => $view,     
                        'method'    => $param1,
                        'request_name' => $this->Job_Order_Model->find_job_name_by_job_number($view)
                        ),
                    'partials'      => array(
                        'header'    => 'templates/header',
                        'footer'    => 'templates/footer',
                        'sidebar1'   => 'templates/sidebar1',
                        'sidebar2'   => 'templates/sidebar2'
                        ),
                    'metadata'      => array(
                        '<script src="' . base_url("assets/private/users/js/job-request.js") . '"></script>'
                        )
                    );
                $this->load->view($data['template']['layouts'], $data);
            }
            else if($param1 == "archived" && $param2 == null)
            {
                $data['menu'] = $this->load_menus($this->session->userdata('priviledge_id'));
                $data['template']   = array(
                    'title'         => $page,
                    'sub_title'     => '',
                    'method'        => 'Archived',
                    'body'          => 'users/archived/job-request',
                    'layouts'       => 'layouts/users',
                    'page'          => array(
                        'parent'    => $this->router->fetch_class(),
                        'category'  => $this->router->fetch_method(),
                        'modules'   => $page,
                        'views'     => $view,     
                        'method'    => $param1,
                        'request_name' => $this->Job_Order_Model->find_job_name_by_job_number($view)
                        ),
                    'partials'      => array(
                        'header'    => 'templates/header',
                        'footer'    => 'templates/footer',
                        'sidebar1'   => 'templates/sidebar1',
                        'sidebar2'   => 'templates/sidebar2'
                        ),
                    'metadata'      => array(
                        '<script src="' . base_url("assets/private/users/js/job-request.js") . '"></script>'
                        )
                    );
                $this->load->view($data['template']['layouts'], $data);
            }
            else if($param1 == "add" && $param2 == null)
            {
                $data['menu'] = $this->load_menus($this->session->userdata('priviledge_id'));
                $data['input'] = $this->job_request_form_data($view, '');
                $data['template']   = array(
                'title'         => $page,
                'sub_title'     => '',
                'method'        => $param1,
                'body'          => 'users/add/job-request',
                'layouts'       => 'layouts/users',
                'page'          => array(
                    'parent'    => $this->router->fetch_class(),
                    'category'  => $this->router->fetch_method(),
                    'modules'   => $page,
                    'views'     => $view,     
                    'method'    => $param1
                    ),
                'partials'      => array(
                    'header'    => 'templates/header',
                    'footer'    => 'templates/footer',
                    'sidebar1'   => 'templates/sidebar1',
                    'sidebar2'   => 'templates/sidebar2'
                    ),
                'metadata'      => array(
                    '<script src="' . base_url("assets/private/users/js/job-request.js") . '"></script>'
                    )
                );
                $this->load->view($data['template']['layouts'], $data);
            }
            else if($param1 == "edit" && $param2 != null)
            {
                $data['menu'] = $this->load_menus($this->session->userdata('priviledge_id'));
                $data['input'] = $this->job_request_form_data($view, $param2);
                $data['template']   = array(
                'title'           => $page,
                'sub_title'       => '',
                'method'          => $param1,
                'body'            => 'users/edit/job-request',
                'layouts'         => 'layouts/users',
                'page'            => array(
                    'parent'      => $this->router->fetch_class(),
                    'category'    => $this->router->fetch_method(),
                    'modules'     => $page,
                    'views'       => $view,     
                    'method'      => $param1,
                    'request_no'  => $param2,
                    'sequence_no' => $this->Job_Request_Module_Model->find_sequence_by_id($param2)
                    ),
                'partials'      => array(
                    'header'    => 'templates/header',
                    'footer'    => 'templates/footer',
                    'sidebar1'   => 'templates/sidebar1',
                    'sidebar2'   => 'templates/sidebar2'
                    ),
                'metadata'      => array(
                    '<script src="' . base_url("assets/private/users/js/job-request.js") . '"></script>'
                    )
                );
                $this->load->view($data['template']['layouts'], $data);
            }
            else if($param1 == "attach" && $param2 != null)
            {
                $data['menu'] = $this->load_menus($this->session->userdata('priviledge_id'));
                $data['input'] = $this->attach_job_request_form_data($view, $param2);
                $data['template']   = array(
                'title'           => $page,
                'sub_title'       => '',
                'method'          => $param1,
                'body'            => 'users/add/attach-element',
                'layouts'         => 'layouts/users',
                'page'            => array(
                    'parent'      => $this->router->fetch_class(),
                    'category'    => $this->router->fetch_method(),
                    'modules'     => $page,
                    'views'       => $view,     
                    'method'      => $param1,
                    'request_no'  => $param2,
                    'sequence_no' => $this->Job_Request_Module_Model->find_sequence_by_id($param2)
                    ),
                'partials'      => array(
                    'header'    => 'templates/header',
                    'footer'    => 'templates/footer',
                    'sidebar1'   => 'templates/sidebar1',
                    'sidebar2'   => 'templates/sidebar2'
                    ),
                'metadata'      => array(
                    '<script src="' . base_url("assets/private/users/js/job-request.js") . '"></script>'
                    )
                );
                $this->load->view($data['template']['layouts'], $data);
            }
            else if ($param1 == "upload-lists" && $param2 == null)
            {
                if( $this->input->is_ajax_request() )
                {
                    $bootgrid_arr = [];
                    $current      = null != $this->input->post('current') ? $this->input->post('current') : 1;
                    $limit        = $this->input->post('rowCount') == -1 ? 0 : $this->input->post('rowCount');
                    $page         = $current !== null ? $current : 1;
                    $start_from   = ($page-1) * $limit;
                    $wildcard     = null != $this->input->post('searchPhrase') ? $this->input->post('searchPhrase') : null;
                    $job_request_module_id = $this->input->post('job_request_module_id');

                    if( isset($wildcard) )
                    {
                        $uploads = $this->Uploads_Model->like_job_request_uploads($wildcard, $start_from, $limit)->result_array();
                        $total = $this->Uploads_Model->likes_job_request_uploads($wildcard)->num_rows();

                    }
                    else
                    {
                        $uploads = $this->Uploads_Model->get_all_job_request_uploads($start_from,$limit, $job_request_module_id)->result_array();
                        $total = $this->Uploads_Model->get_alls_job_request_uploads($job_request_module_id)->num_rows();
                    }

                    foreach ($uploads as $key => $upload) 
                    {
                        $bootgrid_arr[] = array(
                            'count_id'    => $key + 1 + $start_from,
                            'file-no'     => $upload['uploads_id'],
                            'file-name'   => $upload['uploads_filename'],
                            'file-format' => $upload['uploads_format'],
                            'file-url'    => $upload['uploads_link']
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
        }
        else if ($page == "job-request" && $view == "lists" && is_numeric(substr($param1, 0, 3)))
        {   
            //if( $this->input->is_ajax_request() )
            //{   
                if(!isset($param2))
                {
                    $bootgrid_arr = [];
                    $current      = null != $this->input->post('current') ? $this->input->post('current') : 1;
                    $limit        = $this->input->post('rowCount') == -1 ? 0 : $this->input->post('rowCount');
                    $page         = $current !== null ? $current : 1;
                    $start_from   = ($page-1) * $limit;
                    $wildcard     = null != $this->input->post('searchPhrase') ? $this->input->post('searchPhrase') : null;
                    
                    $job_order_id = $this->Job_Order_Model->find_job_order_id($param1);

                    if( isset($wildcard) )
                    {
                        $job_requests = $this->Job_Request_Module_Model->like_job_request($wildcard, $start_from, $limit, $job_order_id)->result_array();
                        $total = $this->Job_Request_Module_Model->likes_job_request($wildcard, $job_order_id)->num_rows();

                    }
                    else
                    {
                        $job_requests = $this->Job_Request_Module_Model->get_all_job_request($start_from, $limit, $job_order_id)->result_array();
                        $total = $this->Job_Request_Module_Model->get_alls_job_request($job_order_id)->num_rows();
                    }

                    foreach ($job_requests as $key => $job_request) 
                    {
                        $bootgrid_arr[] = array(
                            'count_id' => $key + 1 + $start_from,
                            'job-request-id' => $job_request['job_request_module_id'],
                            'job-status' => $this->Job_Status_Model->find_status_name_by_id($job_request['job_status_id']),
                            'job-request' => $this->Job_Request_Model->find_request_name_by_id($job_request['job_request_id']),
                            'job-request-type' => $this->Job_Request_Type_Model->find_request_type_name_by_id($job_request['job_request_type_id']),
                            'job-sequence' => $job_request['job_request_module_sequence'],
                            'job-endorsed' => $this->Department_Model->get_department_name_by_id($job_request['department_id']),
                            'state' => $job_request['job_request_module_status_id']
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
                else 
                {
                    $bootgrid_arr = [];
                    $current      = null != $this->input->post('current') ? $this->input->post('current') : 1;
                    $limit        = $this->input->post('rowCount') == -1 ? 0 : $this->input->post('rowCount');
                    $page         = $current !== null ? $current : 1;
                    $start_from   = ($page-1) * $limit;
                    $wildcard     = null != $this->input->post('searchPhrase') ? $this->input->post('searchPhrase') : null;
                    
                    $job_order_id = $this->Job_Order_Model->find_job_order_id($param1);

                    if( isset($wildcard) )
                    {
                        $job_requests = $this->Job_Request_Module_Model->like_archived_job_request($wildcard, $start_from, $limit, $job_order_id)->result_array();
                        $total = $this->Job_Request_Module_Model->likes_archived_job_request($wildcard, $job_order_id)->num_rows();

                    }
                    else
                    {
                        $job_requests = $this->Job_Request_Module_Model->get_all_archived_job_request($start_from, $limit, $job_order_id)->result_array();
                        $total = $this->Job_Request_Module_Model->get_alls_archived_job_request($job_order_id)->num_rows();
                    }

                    foreach ($job_requests as $key => $job_request) 
                    {
                        $bootgrid_arr[] = array(
                            'count_id' => $key + 1 + $start_from,
                            'job-request-id' => $job_request['job_request_module_id'],
                            'job-status' => $this->Job_Status_Model->find_status_name_by_id($job_request['job_status_id']),
                            'job-request' => $this->Job_Request_Model->find_request_name_by_id($job_request['job_request_id']),
                            'job-request-type' => $this->Job_Request_Type_Model->find_request_type_name_by_id($job_request['job_request_type_id']),
                            'job-sequence' => $job_request['job_request_module_sequence'],
                            'job-endorsed' => $this->Department_Model->get_department_name_by_id($job_request['department_id']),
                            'state' => $job_request['job_request_module_status_id']
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
                
            //}
        }
        else if ($page == "job-element" && is_numeric(substr($view, 0, 3)))
        {
            if($param1 == null && $param2 == null)
            {
                $data['menu'] = $this->load_menus($this->session->userdata('priviledge_id'));
                $data['template']   = array(
                    'title'         => $page,
                    'sub_title'     => '',
                    'method'        => 'Manage',
                    'body'          => 'users/manage/job-element',
                    'layouts'       => 'layouts/users',
                    'page'          => array(
                        'parent'    => $this->router->fetch_class(),
                        'category'  => $this->router->fetch_method(),
                        'modules'   => $page,
                        'views'     => $view,     
                        'method'    => $param1,
                        'request_name' => $this->Job_Order_Model->find_job_name_by_job_number($view)
                        ),
                    'partials'      => array(
                        'header'    => 'templates/header',
                        'footer'    => 'templates/footer',
                        'sidebar1'   => 'templates/sidebar1',
                        'sidebar2'   => 'templates/sidebar2'
                        ),
                    'metadata'      => array(
                        '<script src="' . base_url("assets/private/users/js/job-element.js") . '"></script>'
                        )
                    );
                $this->load->view($data['template']['layouts'], $data);
            }
            else if($param1 == "archived" && $param2 == null)
            {
                $data['menu'] = $this->load_menus($this->session->userdata('priviledge_id'));
                $data['template']   = array(
                    'title'         => $page,
                    'sub_title'     => '',
                    'method'        => 'Archived',
                    'body'          => 'users/archived/job-element',
                    'layouts'       => 'layouts/users',
                    'page'          => array(
                        'parent'    => $this->router->fetch_class(),
                        'category'  => $this->router->fetch_method(),
                        'modules'   => $page,
                        'views'     => $view,     
                        'method'    => $param1,
                        'request_name' => $this->Job_Order_Model->find_job_name_by_job_number($view)
                        ),
                    'partials'      => array(
                        'header'    => 'templates/header',
                        'footer'    => 'templates/footer',
                        'sidebar1'   => 'templates/sidebar1',
                        'sidebar2'   => 'templates/sidebar2'
                        ),
                    'metadata'      => array(
                        '<script src="' . base_url("assets/private/users/js/job-element.js") . '"></script>'
                        )
                    );
                $this->load->view($data['template']['layouts'], $data);
            }
            else if($param1 == "add" && $param2 == null)
            {
                $data['menu'] = $this->load_menus($this->session->userdata('priviledge_id'));
                $data['input'] = $this->job_element_form_data($view, '');
                $data['template']   = array(
                'title'         => $page,
                'sub_title'     => '',
                'method'        => $param1,
                'body'          => 'users/add/job-element',
                'layouts'       => 'layouts/users',
                'page'          => array(
                    'parent'    => $this->router->fetch_class(),
                    'category'  => $this->router->fetch_method(),
                    'modules'   => $page,
                    'views'     => $view,     
                    'method'    => $param1
                    ),
                'partials'      => array(
                    'header'    => 'templates/header',
                    'footer'    => 'templates/footer',
                    'sidebar1'   => 'templates/sidebar1',
                    'sidebar2'   => 'templates/sidebar2'
                    ),
                'metadata'      => array(
                    '<script src="' . base_url("assets/private/users/js/job-element.js") . '"></script>'
                    )
                );
                $this->load->view($data['template']['layouts'], $data);
            }
            else if($param1 == "edit" && $param2 != null)
            {
                $data['menu'] = $this->load_menus($this->session->userdata('priviledge_id'));
                $data['input'] = $this->job_element_form_data($view, $param2);
                $data['template']   = array(
                'title'           => $page,
                'sub_title'       => '',
                'method'          => $param1,
                'body'            => 'users/edit/job-element',
                'layouts'         => 'layouts/users',
                'page'            => array(
                    'parent'      => $this->router->fetch_class(),
                    'category'    => $this->router->fetch_method(),
                    'modules'     => $page,
                    'views'       => $view,     
                    'method'      => $param1,
                    'request_no'  => $param2
                    ),
                'partials'      => array(
                    'header'    => 'templates/header',
                    'footer'    => 'templates/footer',
                    'sidebar1'   => 'templates/sidebar1',
                    'sidebar2'   => 'templates/sidebar2'
                    ),
                'metadata'      => array(
                    '<script src="' . base_url("assets/private/users/js/job-element.js") . '"></script>'
                    )
                );
                $this->load->view($data['template']['layouts'], $data);
            }
            else if ($param1 == "upload-lists" && $param2 == null)
            {
                if( $this->input->is_ajax_request() )
                {
                    $bootgrid_arr = [];
                    $current      = null != $this->input->post('current') ? $this->input->post('current') : 1;
                    $limit        = $this->input->post('rowCount') == -1 ? 0 : $this->input->post('rowCount');
                    $page         = $current !== null ? $current : 1;
                    $start_from   = ($page-1) * $limit;
                    $wildcard     = null != $this->input->post('searchPhrase') ? $this->input->post('searchPhrase') : null;
                    $job_elements_id = $this->input->post('job_elements_id');

                    if( isset($wildcard) )
                    {
                        $uploads = $this->Uploads_Model->like_job_element_uploads($wildcard, $start_from, $limit)->result_array();
                        $total = $this->Uploads_Model->likes_job_element_uploads($wildcard)->num_rows();

                    }
                    else
                    {
                        $uploads = $this->Uploads_Model->get_all_job_element_uploads($start_from,$limit, $job_elements_id)->result_array();
                        $total = $this->Uploads_Model->get_alls_job_element_uploads($job_elements_id)->num_rows();
                    }

                    foreach ($uploads as $key => $upload) 
                    {
                        $bootgrid_arr[] = array(
                            'count_id'    => $key + 1 + $start_from,
                            'file-no'     => $upload['uploads_id'],
                            'file-name'   => $upload['uploads_filename'],
                            'file-format' => $upload['uploads_format'],
                            'file-url'    => $upload['uploads_link']
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
        }
        else if ($page == "job-element" && $view == "lists" && is_numeric(substr($param1, 0, 3)))
        {   
            if( $this->input->is_ajax_request() )
            {   
                if(!isset($param2))
                {
                    $bootgrid_arr = [];
                    $current      = null != $this->input->post('current') ? $this->input->post('current') : 1;
                    $limit        = $this->input->post('rowCount') == -1 ? 0 : $this->input->post('rowCount');
                    $page         = $current !== null ? $current : 1;
                    $start_from   = ($page-1) * $limit;
                    $wildcard     = null != $this->input->post('searchPhrase') ? $this->input->post('searchPhrase') : null;
                    
                    $job_order_id = $this->Job_Order_Model->find_job_order_id($param1);

                    if( isset($wildcard) )
                    {
                        $job_elements = $this->Job_Element_Model->like_job_element($wildcard, $start_from, $limit, $job_order_id)->result_array();
                        $total = $this->Job_Element_Model->likes_job_element($wildcard, $job_order_id)->num_rows();

                    }
                    else
                    {
                        $job_elements = $this->Job_Element_Model->get_all_job_element($start_from, $limit, $job_order_id)->result_array();
                        $total = $this->Job_Element_Model->get_alls_job_element($job_order_id)->num_rows();
                    }

                    foreach ($job_elements as $key => $job_element) 
                    {
                        $bootgrid_arr[] = array(
                            'count_id' => $key + 1 + $start_from,
                            'job-element-id' => $job_element['job_elements_id'],
                            'job-prod-sub' => '<span class="c-black">'.$this->Product_Category_Model->get_product_category_name_by_id($job_element['product_category_id']).'</span> / '.
                            $this->Sub_Category_Model->get_sub_category_name_by_id($job_element['sub_category_id']),
                            'job-req-mod' => $job_element['job_request_module_id'],
                            'job-element-name' => $job_element['job_elements_name'],
                            'job-element-size' => $job_element['job_elements_font_size'].' '.
                            $this->Unit_Of_Measurement_Model->get_unit_of_measurement_code_by_id($job_element['job_elements_font_uom']).' x '.
                            $job_element['job_elements_depth_size'].' '.
                            $this->Unit_Of_Measurement_Model->get_unit_of_measurement_code_by_id($job_element['job_elements_depth_uom']).' x '.
                            $job_element['job_elements_depth_size'].' '.
                            $this->Unit_Of_Measurement_Model->get_unit_of_measurement_code_by_id($job_element['job_elements_height_uom']),
                            'job-element-pack' => $this->Packing_Instructions_Model->get_packing_instructions_name_by_id($job_element['packing_instructions_id'])
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
                else 
                {
                    $bootgrid_arr = [];
                    $current      = null != $this->input->post('current') ? $this->input->post('current') : 1;
                    $limit        = $this->input->post('rowCount') == -1 ? 0 : $this->input->post('rowCount');
                    $page         = $current !== null ? $current : 1;
                    $start_from   = ($page-1) * $limit;
                    $wildcard     = null != $this->input->post('searchPhrase') ? $this->input->post('searchPhrase') : null;
                    
                    $job_order_id = $this->Job_Order_Model->find_job_order_id($param1);

                    if( isset($wildcard) )
                    {
                        $job_elements = $this->Job_Element_Model->like_archived_job_element($wildcard, $start_from, $limit, $job_order_id)->result_array();
                        $total = $this->Job_Element_Model->likes_archived_job_element($wildcard, $job_order_id)->num_rows();

                    }
                    else
                    {
                        $job_elements = $this->Job_Element_Model->get_all_archived_job_element($start_from, $limit, $job_order_id)->result_array();
                        $total = $this->Job_Element_Model->get_alls_archived_job_element($job_order_id)->num_rows();
                    }

                    foreach ($job_elements as $key => $job_element) 
                    {
                        $bootgrid_arr[] = array(
                            'count_id' => $key + 1 + $start_from,
                            'job-element-id' => $job_element['job_elements_id'],
                            'job-prod-sub' => '<span class="c-black">'.$this->Product_Category_Model->get_product_category_name_by_id($job_element['product_category_id']).'</span> / '.
                            $this->Sub_Category_Model->get_sub_category_name_by_id($job_element['sub_category_id']),
                            'job-req-mod' => $job_element['job_request_module_id'],
                            'job-element-name' => $job_element['job_elements_name'],
                            'job-element-size' => $job_element['job_elements_font_size'].' '.
                            $this->Unit_Of_Measurement_Model->get_unit_of_measurement_code_by_id($job_element['job_elements_font_uom']).' x '.
                            $job_element['job_elements_depth_size'].' '.
                            $this->Unit_Of_Measurement_Model->get_unit_of_measurement_code_by_id($job_element['job_elements_depth_uom']).' x '.
                            $job_element['job_elements_depth_size'].' '.
                            $this->Unit_Of_Measurement_Model->get_unit_of_measurement_code_by_id($job_element['job_elements_height_uom']),
                            'job-element-pack' => $this->Packing_Instructions_Model->get_packing_instructions_name_by_id($job_element['packing_instructions_id'])
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
        } 
    }

    public function job_element_form_data($id, $value) 
    {   
        $data = array( 
            'job_element_no' => $this->Job_Element_Model->form_input_job_element_no_attributes('job_elements_id', $value),
            'job_order_no' => $this->Job_Order_Model->form_input_jo_no_attributes('job_order_no', $id),
            'job_order_name' => $this->Job_Order_Model->form_input_jo_no_attributes('job_order_name', $id),
            'product_category_attributes' => $this->Product_Category_Model->form_select_attributes('product_category_id'), 
                'product_category_options' => $this->Product_Category_Model->form_select_options('product_category'),
                'product_category_selected' => $this->Product_Category_Model->form_selected_job_element_options($value),
            'sub_category_attributes' => $this->Sub_Category_Model->form_select_attributes('sub_category_id'), 
                'sub_category_options' => $this->Sub_Category_Model->form_select_options('sub_category'),
                'sub_category_selected' => $this->Sub_Category_Model->form_selected_job_element_options($value),
            'packing_instructions_attributes' => $this->Packing_Instructions_Model->form_select_attributes('packing_instructions_id'), 
                'packing_instructions_options' => $this->Packing_Instructions_Model->form_select_options('packing_instructions'),
                'packing_instructions_selected' => $this->Packing_Instructions_Model->form_selected_job_element_options($value),
            'job_elements_name' => $this->Job_Element_Model->form_input_job_element_attributes('job_elements_name', $value),
            'job_elements_quantity' => $this->Job_Element_Model->form_input_numeric_job_element_attributes('job_elements_quantity', $value),
            'job_elements_font_size' => $this->Job_Element_Model->form_input_numeric_job_element_attributes('job_elements_font_size', $value),
            'job_elements_font_uom_attributes' => $this->Job_Element_Model->form_select_attributes('job_elements_font_uom'), 
                'job_elements_font_uom_options' => $this->Unit_Of_Measurement_Model->form_select_options('job_elements_font_uom'),
                'job_elements_font_uom_selected' => $this->Job_Element_Model->form_selected_job_element_options('job_elements_font_uom',$value),
            'job_elements_depth_size' => $this->Job_Element_Model->form_input_numeric_job_element_attributes('job_elements_depth_size', $value),
            'job_elements_depth_uom_attributes' => $this->Unit_Of_Measurement_Model->form_select_attributes('job_elements_depth_uom'), 
                'job_elements_depth_uom_options' => $this->Unit_Of_Measurement_Model->form_select_options('job_elements_depth_uom'),
                'job_elements_depth_uom_selected' => $this->Job_Element_Model->form_selected_job_element_options('job_elements_depth_uom',$value),
            'job_elements_height_size' => $this->Job_Element_Model->form_input_numeric_job_element_attributes('job_elements_height_size', $value),
            'job_elements_height_uom_attributes' => $this->Unit_Of_Measurement_Model->form_select_attributes('job_elements_height_uom'), 
                'job_elements_height_uom_options' => $this->Unit_Of_Measurement_Model->form_select_options('job_elements_height_uom'),
                'job_elements_height_uom_selected' => $this->Job_Element_Model->form_selected_job_element_options('job_elements_height_uom',$value),
            'job_elements_delivery_location' => $this->Job_Element_Model->form_textarea_job_element_attributes('job_elements_delivery_location', $value),
            'job_elements_remarks' => $this->Job_Element_Model->form_textarea_job_element_attributes('job_elements_remarks', $value),
        );
        return $data;
    }

    public function job_request_form_data($id, $value) 
    {   
        $data = array( 
            'job_order_no' => $this->Job_Order_Model->form_input_jo_no_attributes('job_order_no', $id),
            'job_order_name' => $this->Job_Order_Model->form_input_jo_no_attributes('job_order_name', $id),
            'job_status_attributes' => $this->Job_Status_Model->form_select_job_request_attributes('job_status_id', $value), 
                'job_status_options' => $this->Job_Status_Model->form_select_job_request_options('job_status', $id),
                'job_status_selected' => $this->Job_Status_Model->form_selected_job_request_options($id),
            'job_request_attributes' => $this->Job_Request_Model->form_select_job_request_attributes('job_request_id', $value), 
                'job_request_options' => $this->Job_Request_Model->form_select_job_request_options('job_request', $id),
                'job_request_selected' => $this->Job_Request_Model->form_selected_job_request_options($value),
            'job_request_type_attributes' => $this->Job_Request_Type_Model->form_select_job_request_attributes('job_request_type_id', $value), 
                'job_request_type_options' => $this->Job_Request_Type_Model->form_select_options('job_request_type'),
                'job_request_type_selected' => $this->Job_Request_Type_Model->form_selected_job_request_options($value),
            'job_request_category_attributes' => $this->Job_Request_Category_Model->form_select_job_request_attributes('job_request_category_id', $value), 
                'job_request_category_options' => $this->Job_Request_Category_Model->form_select_options('job_request_category'),
                'job_request_category_selected' => $this->Job_Request_Category_Model->form_selected_job_request_options($value),
            'job_request_quantity' => $this->Job_Request_Module_Model->form_input_numeric_job_request_attributes('job_request_module_qty', $value),
            'job_request_endorsed_to_attributes' => $this->Department_Model->form_select_attributes('department_id'), 
                'job_request_endorsed_to_options' => $this->Department_Model->form_select_options('endorsed_to'),
                'job_request_endorsed_to_selected' => $this->Department_Model->form_selected_job_request_options($value),
            'job_request_date' => $this->Job_Request_Module_Model->form_input_date_job_request_attributes('job_request_module_req_date', $value),
            'job_request_due_date' => $this->Job_Request_Module_Model->form_input_date_job_request_attributes('job_request_module_due_date', $value),
            'job_request_instructions' => $this->Job_Request_Module_Model->form_textarea_job_request_attributes('job_request_module_instructions', $value),
            'job_request_attachments' => $this->Job_Request_Module_Model->form_textarea_job_request_attributes('job_request_module_attachments', $value),
        );
        return $data;
    }

    public function attach_job_request_form_data($id, $value) 
    {   
        $data = array( 
            'job_order_no' => $this->Job_Order_Model->form_input_jo_no_attributes('job_order_no', $id),
            'job_order_name' => $this->Job_Order_Model->form_input_jo_no_attributes('job_order_name', $id),
            'job_status_attributes' => $this->Job_Status_Model->form_select_attach_job_elem_attributes('job_status_id'), 
                'job_status_options' => $this->Job_Status_Model->form_select_options('job_status'),
                'job_status_selected' => $this->Job_Status_Model->form_selected_job_request_options($id),
            'job_request_attributes' => $this->Job_Request_Model->form_select_attach_job_elem_attributes('job_request_id'), 
                'job_request_options' => $this->Job_Request_Model->form_select_options('job_request'),
                'job_request_selected' => $this->Job_Request_Model->form_selected_job_request_options($value),
            'job_request_type_attributes' => $this->Job_Request_Type_Model->form_select_attach_job_elem_attributes('job_request_type_id'), 
                'job_request_type_options' => $this->Job_Request_Type_Model->form_select_options('job_request_type'),
                'job_request_type_selected' => $this->Job_Request_Type_Model->form_selected_job_request_options($value),
            'job_request_category_attributes' => $this->Job_Request_Category_Model->form_select_attach_job_elem_attributes('job_request_category_id'), 
                'job_request_category_options' => $this->Job_Request_Category_Model->form_select_options('job_request_category'),
                'job_request_category_selected' => $this->Job_Request_Category_Model->form_selected_job_request_options($value),
            'job_request_quantity' => $this->Job_Request_Module_Model->form_input_numeric_attach_job_elem_job_request_attributes('job_request_module_qty', $value),
            'job_request_endorsed_to_attributes' => $this->Department_Model->form_select_attach_job_elem_attributes('department_id'), 
                'job_request_endorsed_to_options' => $this->Department_Model->form_select_options('endorsed_to'),
                'job_request_endorsed_to_selected' => $this->Department_Model->form_selected_job_request_options($value),
            'job_request_date' => $this->Job_Request_Module_Model->form_input_date_attach_job_elem_job_request_attributes('job_request_module_req_date', $value),
            'job_request_due_date' => $this->Job_Request_Module_Model->form_input_date_attach_job_elem_job_request_attributes('job_request_module_due_date', $value),
            'job_request_instructions' => $this->Job_Request_Module_Model->form_textarea_attach_job_elem_job_request_attributes('job_request_module_instructions', $value),
            'job_request_attachments' => $this->Job_Request_Module_Model->form_textarea_attach_job_elem_job_request_attributes('job_request_module_attachments', $value),
        );
        return $data;
    }
    
    public function find_by_customer($id = null)
    {   
        if( $this->input->is_ajax_request() ) 
        {
            if(isset($id))
            {
                $arr = $this->Customer_Model->get_customer_values_by_id($id);           

                echo json_encode( $arr );

                exit();
            }
        }
        
    }

    public function find_brand_by_customer($id = null)
    {   
        if( $this->input->is_ajax_request() ) 
        {
            if(isset($id))
            {
                $arr = $this->Brand_Model->get_brand_by_customer($id);           

                echo json_encode( $arr );

                exit();
            }
        }        
    }

    public function find_contact_person_by_customer($id = null)
    {   
        if( $this->input->is_ajax_request() ) 
        {
            if(isset($id))
            {
                $arr = $this->Contact_Person_Model->get_contact_person_by_customer($id);           

                echo json_encode( $arr );

                exit();
            }
        }        
    }

    public function find_account_by_customer($id = null)
    {   
        if( $this->input->is_ajax_request() ) 
        {
            if(isset($id))
            {
                $arr = $this->Account_Model->get_account_by_customer($id);           

                echo json_encode( $arr );

                exit();
            }
        }        
    }

    public function find_branch_by_account($id = null)
    {   
        if( $this->input->is_ajax_request() ) 
        {
            if(isset($id))
            {
                $arr = $this->Branch_Model->get_branch_by_account($id);           

                echo json_encode( $arr );

                exit();
            }
        }        
    }

}