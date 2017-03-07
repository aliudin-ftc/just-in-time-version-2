<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Approval extends CI_Controller {
    
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

    public function job_request($page = null, $view = null, $param1 = null, $param2 = null)
    { 
        $this->validated();
        if($page == null)
        {
            $data['menu'] = $this->load_menus($this->session->userdata('priviledge_id'));
            $data['input'] = $this->disapprove_job_request_form_data($view);
            $data['template']   = array(
                'title'         => 'Approval',
                'sub_title'     => 'Job Request',
                'method'        => 'Approval',
                'body'          => 'users/manage/approval-job-request',
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
                    '<script src="' . base_url("assets/private/users/js/approval-job-request.js") . '"></script>'
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
                    $jobs = $this->Job_Request_Module_Model->like_approval($wildcard, $start_from, $limit)->result_array();
                    $total = $this->Job_Request_Module_Model->likes_approval($wildcard)->num_rows();

                }
                else
                {   
                    $jobs = $this->Job_Request_Module_Model->get_all_approval($start_from,  $limit, $priviledge_id)->result_array();
                    $total = $this->Job_Request_Module_Model->get_alls_approval($priviledge_id)->num_rows();
                }

                foreach ($jobs as $key => $job) 
                {
                    $bootgrid_arr[] = array(
                        'count_id'=> $key + 1 + $start_from,
                        'id' => $job['job_request_module_id'],
                        'date-sent' => $this->Job_Request_Module_Status_Sent_Model->find_sent_date_by_id($job['job_request_module_id']),
                        'job-no' => $this->Job_Order_Model->find_job_number_by_job_id($job['job_order_id']),
                        'job-request-by' => $this->Resources_Model->get_resources_name_by_id($job['resources_id']),
                        'job-request' => $this->Job_Request_Model->find_request_name_by_id($job['job_request_id']).' - '.$this->Job_Request_Type_Model->find_request_type_name_by_id($job['job_request_type_id']).'<br/>('.$job['job_request_module_sequence'].' sequence)',
                        'approved-by' => $this->Job_Request_Module_Approval_Model->search_all_approval_for_job_request($job['job_request_module_id']),
                        'approved-mine' => $this->Job_Request_Module_Approval_Model->search_approve_mine_job_request($job['job_request_module_id'], $this->session->userdata('resources_id')),
                        'req' => $job['job_request_id'],
                        'required' => $this->Job_Request_Model->count_required($job['job_request_module_id'], $job['job_request_id'], $job['job_request_module_sequence']),
                        'status' => $job['job_request_module_approval'] ,
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
        else if ($page == "approve" && $view != null)
        {   
            if( $this->input->is_ajax_request() )
            {
                $approve = array(
                    'resources_id' => $this->session->userdata('resources_id'),
                    'job_request_module_id' => $view,
                    'job_request_module_approval_type' => 'approved'
                );

                $approve_id = $this->Job_Request_Module_Approval_Model->insert($approve);

                $required = $this->input->get('required');

                if($required == 1)
                {   
                    $approval = array(
                        'job_request_module_approval' => 'approved',
                        'job_request_module_status_id' => 3
                    );
                    
                    $this->Job_Request_Module_Model->modify($approval, $view);

                    $updated = array(
                        'updated_by' => '1',
                        'updated_table' => 'job_request_module',
                        'updated_table_id' => $view
                    );
                    
                    $updated_id = $this->Updated_Model->insert($updated);
                }

                $created = array(
                    'created_by' => $this->session->userdata('resources_id'),
                    'created_table' => 'job_request_module_approval',
                    'created_table_id' => $approve_id
                );
                
                $created_id = $this->Created_Model->insert($created);

                $data = array(
                    'message' => 'The request has been approved successfully,',
                    'type'    => 'success'
                );
                echo json_encode( $data ); exit();
            }
        }
        else if ($page == "disapprove" && $view != null)
        {   
            if( $this->input->is_ajax_request() )
            {
                $disapprove = array(
                    'resources_id' => $this->session->userdata('resources_id'),
                    'job_request_module_id' => $view,
                    'job_request_module_approval_type' => 'disapproved',
                    'job_request_module_approval_remarks' => $this->input->get('reason')
                );

                $disapprove_id = $this->Job_Request_Module_Approval_Model->insert($disapprove);

                $required = $this->input->get('required');

                if($required == 1)
                {   
                    $disapproval = array(
                        'job_request_module_approval' => 'disapproved',
                        'job_request_module_status_id' => 5
                    );
                    
                    $this->Job_Request_Module_Model->modify($disapproval, $view);

                    $updated = array(
                        'updated_by' => '1',
                        'updated_table' => 'job_request_module',
                        'updated_table_id' => $view
                    );
                    
                    $updated_id = $this->Updated_Model->insert($updated);
                }

                $created = array(
                    'created_by' => $this->session->userdata('resources_id'),
                    'created_table' => 'job_request_module_approval',
                    'created_table_id' => $disapprove_id
                );
                
                $created_id = $this->Created_Model->insert($created);

                $data = array(
                    'message' => 'The request has been disapproved successfully.',
                    'type'    => 'success'
                );
                echo json_encode( $data ); exit();
            }
        }
        else if ($page == "view" && $view != null)
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

    public function disapprove_job_request_form_data($id)
    {
        $data = array( 
            'disapproved_reason' => $this->Job_Request_Module_Approval_Model->form_textarea_jobrequest_attributes('job_request_module_approval_remarks', $id)  
        );
        return $data;
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
}