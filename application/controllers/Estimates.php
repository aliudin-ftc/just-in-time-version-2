<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Estimates extends CI_Controller {
    
    private $data = array();

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('download');
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
            'Job_Element_Model' => 'Job_Element_Model',
            'Priviledge_Module_Model' => 'Priviledge_Module_Model',
            'Job_Request_Module_Status_Sent_Model' => 'Job_Request_Module_Status_Sent_Model',
            'Job_Request_Module_Assigned_Model' => 'Job_Request_Module_Assigned_Model',
            'Job_Request_Module_Approval_Model' => 'Job_Request_Module_Approval_Model'
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

    public function index()
    {
        $data['menu'] = $this->load_menus($this->session->userdata('priviledge_id'));
            $data['template']   = array(
                'title'         => 'Estimates',
                'sub_title'     => 'Planner',
                'method'        => 'Manage',
                'body'          => 'users/manage/estimate-planner',
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
                    '<script src="' . base_url("assets/private/users/js/estimate.js") . '"></script>'
                    )
                );
            $this->load->view($data['template']['layouts'], $data);
    }  

    public function planner($page = null, $view = null, $param1 = null, $param2 = null)
    { 
        $this->validated();
        if($page == null)
        {
            $data['menu'] = $this->load_menus($this->session->userdata('priviledge_id'));
            $data['input'] = $this->assign_form_data('');
            $data['template']   = array(
                'title'         => 'Estimates',
                'sub_title'     => 'Planner',
                'method'        => 'Manage',
                'body'          => 'users/manage/estimate-planner',
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
                    '<script src="' . base_url("assets/private/users/js/estimate.js") . '"></script>'
                    )
                );
            $this->load->view($data['template']['layouts'], $data);
        }
        else if ($page == "lists")
        {
            //if( $this->input->is_ajax_request() )
            //{
                $bootgrid_arr = [];
                $current      = null != $this->input->post('current') ? $this->input->post('current') : 1;
                $limit        = $this->input->post('rowCount') == -1 ? 0 : $this->input->post('rowCount');
                $page         = $current !== null ? $current : 1;
                $start_from   = ($page-1) * $limit;
                $wildcard     = null != $this->input->post('searchPhrase') ? $this->input->post('searchPhrase') : null;
                $priviledge_id = $this->session->userdata('priviledge_id');

                if( isset($wildcard) )
                {
                    $jobs = $this->Job_Request_Module_Model->like_job_estimate_planner($wildcard, $start_from, $limit)->result_array();
                    $total = $this->Job_Request_Module_Model->likes_job_estimate_planner($wildcard)->num_rows();

                }
                else
                {   
                    $jobs = $this->Job_Request_Module_Model->get_all_job_estimate_planner($start_from,  $limit, $priviledge_id)->result_array();
                    $total = $this->Job_Request_Module_Model->get_alls_job_estimate_planner($priviledge_id)->num_rows();
                }

                foreach ($jobs as $key => $job) 
                {
                    $bootgrid_arr[] = array(
                        'count_id'=> $key + 1 + $start_from,
                        'id' => $job['job_request_module_id'],
                        'time-sent' => $this->Job_Request_Module_Approval_Model->find_approval_date_by_id($job['job_request_module_id']),
                        'job-no' => $this->Job_Order_Model->find_job_number_by_job_id($job['job_order_id']).'<br/>('.$this->Job_Order_Model->find_job_name_by_job_id($job['job_order_id']).')',
                        'request-no' => $job['job_request_module_sequence'],
                        'agent' => $this->Job_Order_Model->find_agent_by_job_id($job['job_order_id']),
                        'customer' => $this->Job_Order_Model->find_customer_name_by_job_id($job['job_order_id']),
                        'job-assign' => $this->Resources_Model->get_resources_name_by_id($this->Job_Request_Module_Assigned_Model->get_assigned_job_request($job['job_request_module_id']))
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
        else if ($page == "assign" && $view != null) {
            //if( $this->input->is_ajax_request() )
            //{
                $assign = array(
                    'resources_id' => $this->input->post('resources_id'),
                    'job_request_module_id' => $view,
                    'job_request_module_assigned_type' => 'estimate',
                    'job_request_module_assigned_start_date' =>  date("Y-m-d h:i:s", strtotime($this->input->post('job_request_module_assigned_start_date'))),
                    'job_request_module_assigned_remarks' => $this->input->post('job_request_module_assigned_remarks')
                );

                $assign_id = $this->Job_Request_Module_Assigned_Model->insert($assign);

                $created = array(
                    'created_by' => $this->session->userdata('resources_id'),
                    'created_table' => 'job_request_module_assigned',
                    'created_table_id' => $assign_id
                );
                
                $created_id = $this->Created_Model->insert($created);

                $data = array(
                    'message' => 'The request has been assigned successfully,',
                    'type'    => 'success'
                );
                echo json_encode( $data ); exit();
            //}
        }
    }

    public function job_request($page = null, $view = null, $param1 = null, $param2 = null)
    {   
        if ($page == "view" && $view != null)
        {
            $data['menu'] = $this->load_menus($this->session->userdata('priviledge_id'));
            $data['input'] = $this->job_request_form_data($view);
            $data['template']   = array(
            'title'           => $page,
            'sub_title'       => 'Job Request',
            'method'          => $param1,
            'body'            => 'users/view/job-request',
            'layouts'         => 'layouts/users',
            'page'            => array(
                'parent'      => $this->router->fetch_class(),
                'category'    => $this->router->fetch_method(),
                'modules'     => $page,
                'views'       => $view,     
                'method'      => $param1,
                'request_no'  => $param2,
                'sequence_no' => $this->Job_Request_Module_Model->find_sequence_by_id($view)
                ),
            'partials'      => array(
                'header'    => 'templates/header',
                'footer'    => 'templates/footer',
                'sidebar1'   => 'templates/sidebar1',
                'sidebar2'   => 'templates/sidebar2'
                ),
            'metadata'      => array(
                '<script src="' . base_url("assets/private/users/js/approval-job-request.js") . '"></script>'
                )
            );
            $this->load->view($data['template']['layouts'], $data);
        }
    }
    public function job_request_form_data($id) 
    {   
        $data = array( 
            'job_order_no' => $this->Job_Order_Model->form_input_view_jo_jobrequest_attributes('job_order_no', $id),
            'job_order_name' => $this->Job_Order_Model->form_input_view_jo_name_jobrequest_attributes('job_order_name', $id),
            'job_status_attributes' => $this->Job_Status_Model->form_select_view_jobrequest_attributes('job_status_id', $id), 
                'job_status_options' => $this->Job_Status_Model->form_select_view_jobrequest_options('job_status', $id),
                'job_status_selected' => $this->Job_Status_Model->form_selected_view_jobrequest_options($id),
            'job_request_attributes' => $this->Job_Request_Model->form_select_view_jobrequest_attributes('job_request_id', $id), 
                'job_request_options' => $this->Job_Request_Model->form_select_view_jobrequest_options('job_request', $id),
                'job_request_selected' => $this->Job_Request_Model->form_selected_view_jobrequest_options($id),
            'job_request_type_attributes' => $this->Job_Request_Type_Model->form_select_view_jobrequest_attributes('job_request_type_id', $id), 
                'job_request_type_options' => $this->Job_Request_Type_Model->form_select_view_jobrequest_options('job_request_type', $id),
                'job_request_type_selected' => $this->Job_Request_Type_Model->form_selected_view_jobrequest_options($id),
            'job_request_category_attributes' => $this->Job_Request_Category_Model->form_select_view_jobrequest_attributes('job_request_category_id', $id), 
                'job_request_category_options' => $this->Job_Request_Category_Model->form_select_view_jobrequest_options('job_request_category', $id),
                'job_request_category_selected' => $this->Job_Request_Category_Model->form_selected_view_jobrequest_options($id),
            'job_request_quantity' => $this->Job_Request_Module_Model->form_input_numeric_view_jobrequest_attributes('job_request_module_qty', $id),
            'job_request_endorsed_to_attributes' => $this->Department_Model->form_select_view_jobrequest_attributes('department_id', $id), 
                'job_request_endorsed_to_options' => $this->Department_Model->form_select_view_jobrequest_options('endorsed_to', $id),
                'job_request_endorsed_to_selected' => $this->Department_Model->form_selected_view_jobrequest_options($id),
            'job_request_date' => $this->Job_Request_Module_Model->form_input_date_view_jobrequest_attributes('job_request_module_req_date', $id),
            'job_request_due_date' => $this->Job_Request_Module_Model->form_input_date_view_jobrequest_attributes('job_request_module_due_date', $id),
            'job_request_instructions' => $this->Job_Request_Module_Model->form_textarea_view_jobrequest_attributes('job_request_module_instructions', $id),
            'job_request_attachments' => $this->Job_Request_Module_Model->form_textarea_view_jobrequest_attributes('job_request_module_attachments', $id)
        );
        return $data;
    }

    public function assign_form_data($id) 
    {   
        $data = array( 
            'resources_attributes' => $this->Resources_Model->form_select_assign_estimator_attributes('resources_id'), 
                'resources_options' => $this->Resources_Model->form_select_assign_estimator_options('estimator'),
                'resources_selected' => $this->Resources_Model->form_selected_assign_estimator_options($id),
            'job_request_module_assigned_remarks' => $this->Job_Request_Module_Assigned_Model->form_textarea_assign_estimator_attributes('job_request_module_assigned_remarks', $id),
            'job_request_module_assigned_start_date' => $this->Job_Request_Module_Assigned_Model->form_input_assign_estimator_attributes('job_request_module_assigned_start_date', $id)
        );
        return $data;
    }


    public function cost_estimate($page = null, $view = null, $param1 = null, $param2 = null)
    { 
        $this->validated();
        if($page == null)
        {
            $data['menu'] = $this->load_menus($this->session->userdata('priviledge_id'));
            $data['input'] = $this->assign_form_data('');
            $data['template']   = array(
                'title'         => 'Estimates',
                'sub_title'     => 'Cost Estimate',
                'method'        => 'Manage',
                'body'          => 'users/manage/cost-estimate',
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
                    '<script src="' . base_url("assets/private/users/js/estimate.js") . '"></script>'
                    )
                );
            $this->load->view($data['template']['layouts'], $data);
        }
        else if ($page == "lists")
        {
            //if( $this->input->is_ajax_request() )
            //{
                $bootgrid_arr = [];
                $current      = null != $this->input->post('current') ? $this->input->post('current') : 1;
                $limit        = $this->input->post('rowCount') == -1 ? 0 : $this->input->post('rowCount');
                $page         = $current !== null ? $current : 1;
                $start_from   = ($page-1) * $limit;
                $wildcard     = null != $this->input->post('searchPhrase') ? $this->input->post('searchPhrase') : null;
                $user_id = $this->session->userdata('resources_id');

                if( isset($wildcard) )
                {
                    $jobs = $this->Job_Request_Module_Model->like_job_estimate_cost($wildcard, $start_from, $limit)->result_array();
                    $total = $this->Job_Request_Module_Model->likes_job_estimate_cost($wildcard)->num_rows();
                }
                else
                {   
                    $jobs = $this->Job_Request_Module_Model->get_all_job_estimate_cost($start_from,  $limit, $user_id)->result_array();
                    $total = $this->Job_Request_Module_Model->get_alls_job_estimate_cost($user_id)->num_rows();
                }

                foreach ($jobs as $key => $job) 
                {
                    $bootgrid_arr[] = array(
                        'count_id'=> $key + 1 + $start_from,
                        'id' => $job['job_request_module_id'],
                        'time-sent' => $this->Job_Request_Module_Approval_Model->find_approval_date_by_id($job['job_request_module_id']),
                        'job-no' => $this->Job_Order_Model->find_job_number_by_job_id($job['job_order_id']).'<br/>('.$this->Job_Order_Model->find_job_name_by_job_id($job['job_order_id']).')',
                        'request-no' => $job['job_request_module_sequence'],
                        'agent' => $this->Job_Order_Model->find_agent_by_job_id($job['job_order_id']),
                        'customer' => $this->Job_Order_Model->find_customer_name_by_job_id($job['job_order_id']),
                        'job-assign' => $this->Resources_Model->get_resources_name_by_id($this->Job_Request_Module_Assigned_Model->get_assigned_job_request($job['job_request_module_id']))
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
        else if ($page == "edit" && $view != null)
        {
            $data['menu'] = $this->load_menus($this->session->userdata('priviledge_id'));
            $data['input'] = $this->job_request_form_data($view);
            $data['template']   = array(
            'title'           => $page,
            'sub_title'       => 'Job Request',
            'method'          => $param1,
            'body'            => 'users/edit/cost-estimate',
            'layouts'         => 'layouts/users',
            'page'            => array(
                'parent'      => $this->router->fetch_class(),
                'category'    => $this->router->fetch_method(),
                'modules'     => $page,
                'views'       => $view,     
                'method'      => $param1,
                'request_no'  => $param2,
                'sequence_no' => $this->Job_Request_Module_Model->find_sequence_by_id($view)
                ),
            'partials'      => array(
                'header'    => 'templates/header',
                'footer'    => 'templates/footer',
                'sidebar1'   => 'templates/sidebar1',
                'sidebar2'   => 'templates/sidebar2'
                ),
            'metadata'      => array(
                '<script src="' . base_url("assets/private/users/js/estimate.js") . '"></script>'
                )
            );
            $this->load->view($data['template']['layouts'], $data);
        }

    }

    public function attach_elements($id)
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
                $job_elements = $this->Job_Element_Model->like_attach_job_element($wildcard, $start_from, $limit)->result_array();
                $total = $this->Job_Element_Model->likes_attach_job_element($wildcard)->num_rows();

            }
            else
            {
                $job_elements = $this->Job_Element_Model->get_all_attach_job_element($start_from,  $limit, $id)->result_array();
                $total = $this->Job_Element_Model->get_alls_attach_job_element($id)->num_rows();
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
                    'job-element-pack' => $this->Packing_Instructions_Model->get_packing_instructions_name_by_id($job_element['packing_instructions_id']),
                    'job-element-qty' => $job_element['job_elements_quantity'],
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
}