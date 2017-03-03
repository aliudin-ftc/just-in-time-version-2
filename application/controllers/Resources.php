<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Resources extends CI_Controller {
    
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
            'Level_Model' => 'Level_Model',
            'Contact_Model' => 'Contact_Model',
            'Localmail_Model' => 'Localmail_Model',
            'Address_Model' => 'Address_Model',
            'Email_Model' => 'Email_Model',
            'Province_Model' => 'Province_Model',
            'City_Model' => 'City_Model',
            'Barangay_Model' => 'Barangay_Model',
            'Resources_Level_Model' => 'Resources_Level_Model',
            'Payment_Terms_Model' => 'Payment_Terms_Model',
            'Payment_Terms_Resources_Model' => 'Payment_Terms_Resources_Model',
            'Priviledge_Module_Model' => 'Priviledge_Module_Model',
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

    public function outgoing_lists()
    {
        //if( $this->input->is_ajax_request() )
        //{
            $bootgrid_arr = [];
            $current      = null != $this->input->post('current') ? $this->input->post('current') : 1;
            $limit        = $this->input->post('rowCount') == -1 ? 0 : $this->input->post('rowCount');
            $page         = $current !== null ? $current : 1;
            $start_from   = ($page-1) * $limit;
            $wildcard     = null != $this->input->post('searchPhrase') ? $this->input->post('searchPhrase') : null;
            $res_id = $this->input->post('resources_id');

            if( isset($wildcard) )
            {
                $emails = $this->Email_Model->like_resources_email($wildcard, $start_from, $limit, $res_id)->result_array();
                $total = $this->Email_Model->likes_resources_email($wildcard, $res_id)->num_rows();

            }
            else
            {
                $emails = $this->Email_Model->get_all_resources_email($start_from, $limit, $res_id)->result_array();
                $total = $this->Email_Model->get_alls_resources_email($res_id)->num_rows();
            }

            foreach ($emails as $key => $email) 
            { 
                $bootgrid_arr[] = array(
                    'count_id'=> $key + 1 + $start_from,
                    'outgoing-id' => $email['email_id'],
                    'outgoing-email' => $email['email_address'],
                    'outgoing-desc' => $email['email_description']
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

    public function contact_lists()
    {
        if( $this->input->is_ajax_request() )
        {
            $bootgrid_arr = [];
            $current      = null != $this->input->post('current') ? $this->input->post('current') : 1;
            $limit        = $this->input->post('rowCount') == -1 ? 0 : $this->input->post('rowCount');
            $page         = $current !== null ? $current : 1;
            $start_from   = ($page-1) * $limit;
            $wildcard     = null != $this->input->post('searchPhrase') ? $this->input->post('searchPhrase') : null;
            $res_id = $this->input->post('resources_id');

            if( isset($wildcard) )
            {
                $contacts = $this->Contact_Model->like_resources_contact($wildcard, $start_from, $limit, $res_id)->result_array();
                $total = $this->Contact_Model->likes_resources_contact($wildcard, $res_id)->num_rows();

            }
            else
            {
                $contacts = $this->Contact_Model->get_all_resources_contact($start_from, $limit, $res_id)->result_array();
                $total = $this->Contact_Model->get_alls_resources_contact($res_id)->num_rows();
            }

            foreach ($contacts as $key => $contact) 
            { 
                $bootgrid_arr[] = array(
                    'count_id'=> $key + 1 + $start_from,
                    'contact-id' => $contact['contact_id'],
                    'contact-phone' => $contact['contact_phone_number'],
                    'contact-mobile' => $contact['contact_mobile_number'],
                    'contact-fax' => $contact['contact_fax_number']
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

    public function address_lists()
    {
        if( $this->input->is_ajax_request() )
        {
            $bootgrid_arr = [];
            $current      = null != $this->input->post('current') ? $this->input->post('current') : 1;
            $limit        = $this->input->post('rowCount') == -1 ? 0 : $this->input->post('rowCount');
            $page         = $current !== null ? $current : 1;
            $start_from   = ($page-1) * $limit;
            $wildcard     = null != $this->input->post('searchPhrase') ? $this->input->post('searchPhrase') : null;
            $res_id = $this->input->post('resources_id');

            if( isset($wildcard) )
            {
                $addresses = $this->Address_Model->like_resources_address($wildcard, $start_from, $limit, $res_id)->result_array();
                $total = $this->Address_Model->likes_resources_address($wildcard, $res_id)->num_rows();

            }
            else
            {
                $addresses = $this->Address_Model->get_all_resources_address($start_from, $limit, $res_id)->result_array();
                $total = $this->Address_Model->get_alls_resources_address($res_id)->num_rows();
            }

            foreach ($addresses as $key => $address) 
            {  
                $bootgrid_arr[] = array(
                    'count_id'=> $key + 1 + $start_from,
                    'address-id' => $address['address_id'],
                    'address-province' => $this->Province_Model->find_province_name_by_id($address['address_province']),
                    'address-city' => $this->City_Model->find_city_name_by_id($address['address_city']),
                    'address-brgy' => $this->Barangay_Model->find_barangay_name_by_id($address['address_barangay']),
                    'address-street' => $address['address_street']
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

    public function employee_form_data($id) 
    {   
        $data = array( 
            'employee_fname' => $this->Resources_Model->form_input_attributes('resources_firstname', $id),
            'employee_mname' => $this->Resources_Model->form_input_attributes('resources_middlename', $id),
            'employee_lname' => $this->Resources_Model->form_input_attributes('resources_lastname', $id),
            'level_attributes' => $this->Level_Model->form_select_attributes('level_id'), 
                'level_options' => $this->Level_Model->form_select_options('level'),
                'level_selected' => $this->Resources_Level_Model->form_selected_resources_options($id),
            'department_attributes' => $this->Department_Model->form_select_attributes('department_id'), 
                'department_options' => $this->Department_Model->form_select_options('department'),
                'department_selected' => $this->Department_Model->form_selected_resources_options($id),
            'gender_attributes' => $this->Resources_Model->form_select_gender_attributes('resources_gender'), 
                'gender_options' => $this->Resources_Model->form_select_gender_options('gender'),
                'gender_selected' => $this->Resources_Model->form_selected_gender_options($id),
            'local_mail' => $this->Localmail_Model->form_input_email_resources_attributes('localmail_email', $id),
            'tin' => $this->Resources_Model->form_input_numeric_attributes('resources_tin', $id),
            'barcode' => $this->Resources_Model->form_input_numeric_attributes('resources_barcode', $id),
            'interest' => $this->Resources_Model->form_textarea_attributes('resources_interest', $id),
            'province_attributes' => $this->Province_Model->form_select_resources_attributes('province_id'), 
                'province_options' => $this->Province_Model->form_select_resources_options('province'),
                'province_selected' => $this->Province_Model->form_selected_resources_options($id),
            'city_attributes' => $this->City_Model->form_select_resources_attributes('city_id'), 
                'city_options' => $this->City_Model->form_select_resources_options('city', $id),
                'city_selected' => $this->City_Model->form_selected_resources_options($id),
            'barangay_attributes' => $this->Barangay_Model->form_select_resources_attributes('barangay_id'), 
                'barangay_options' => $this->Barangay_Model->form_select_resources_options('barangay', $id),
                'barangay_selected' => $this->Barangay_Model->form_selected_resources_options($id),
            'block' => $this->Address_Model->form_input_resources_attributes('block', $id),
            'street' => $this->Address_Model->form_input_resources_attributes('street', $id),
            'region' => $this->Address_Model->form_input_disabled_resources_attributes('region', $id),
            'phone_number' => $this->Contact_Model->form_input_numeric_resources_attributes('contact_phone_number', $id),
            'mobile_number' => $this->Contact_Model->form_input_numeric_resources_attributes('contact_mobile_number', $id),
            'fax_number' => $this->Contact_Model->form_input_numeric_resources_attributes('contact_fax_number', $id),
            'email_address' => $this->Email_Model->form_input_email_resources_attributes('email_address', $id),
            'email_description' => $this->Email_Model->form_input_resources_attributes('email_description', $id),
            'resources_file' => $this->Resources_Model->form_file($id)
        );
        return $data;
    }

    public function employee($page = null, $view = null, $param1 = null, $param2 =null)
    {   
        $this->validated();
        if($page == "manage" || $page == null)
        {
            $data['menu'] = $this->load_menus($this->session->userdata('priviledge_id'));
            $data['template']   = array(
                'title'         => 'Resources',
                'sub_title'     => 'Employee',
                'method'        => 'Manage',
                'body'          => 'users/manage/employee',
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
                    '<script src="' . base_url("assets/private/users/js/resources.js") . '"></script>'
                    )
                );
            $this->load->view($data['template']['layouts'], $data);
        }
        else if($page == "add")
        {
            $data['menu'] = $this->load_menus($this->session->userdata('priviledge_id'));
            $data['input'] = $this->employee_form_data('');
            $data['template']   = array(
                'title'         => 'Resources',
                'sub_title'     => 'Employee',
                'method'        => 'Add',
                'body'          => 'users/add/employee',
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
                    '<script src="' . base_url("assets/private/users/js/resources.js") . '"></script>'
                    )
                );
            $this->load->view($data['template']['layouts'], $data);
        }
        else if($page == "edit" && $view != null)
        {
            $data['menu'] = $this->load_menus($this->session->userdata('priviledge_id'));
            $data['input'] = $this->employee_form_data($view);
            $data['template']   = array(
                'title'         => 'Resources',
                'sub_title'     => 'Employee',
                'method'        => 'Add',
                'body'          => 'users/edit/employee',
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
                    '<script src="' . base_url("assets/private/users/js/resources.js") . '"></script>'
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
                    $folder = mkdir("uploads/resources/".date('Y-m-d H:i:s'), 0777);
                    $uploaddir = 'uploads/resources/'.date('Y-m-d H:i:s').'/';

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
                $file = 'resources/'.date('Y-m-d H:i:s').'/'.$_GET['filename'];

                $resources = array(
                    'resources_firstname' =>  $this->input->post('firstname'),
                    'resources_middlename' =>  $this->input->post('middlename'),
                    'resources_lastname' => $this->input->post('lastname'),
                    'resources_gender' => $this->input->post('resources_gender'),
                    'department_id' => $this->input->post('department_id'),
                    'resources_tin' => $this->input->post('tin'),
                    'resources_barcode' => $this->input->post('barcode'),
                    'resources_interest' => $this->input->post('interest'),
                    'resources_type_id' => '1',
                    'resources_logo' => $file,
                );

                $resources_id = $this->Resources_Model->insert($resources);
                
                $level = array(
                    'level_id' => $this->input->post('level_id'),
                    'resources_id' => $resources_id
                );

                $level_id = $this->Resources_Level_Model->insert($level);

                $local_mail = array(
                    'localmail_email' => $this->input->post('email'),
                    'resources_id' => $resources_id
                );

                $local_mail_id = $this->Localmail_Model->insert($local_mail);

                $created = array(
                    'created_by' => '1',
                    'created_table' => 'resources',
                    'created_table_id' => $resources_id
                );
                
                $created_id = $this->Created_Model->insert($created);

                $status = array(
                    'status_code' => '1',
                    'status_description' => 'Active',
                    'status_table' => 'resources',
                    'status_table_id' => $resources_id
                );
                
                $status_id = $this->Status_Model->insert($status);

                $data = array(
                    'resources_id' => $resources_id,
                    'message' => 'The employee was successfully saved.',
                    'type'    => 'success'
                );
                echo json_encode( $data ); exit();
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
                    $file = 'resources/'.date('Y-m-d H:i:s').'/'.$_GET['filename'];
                }

                $resources = array(
                    'resources_firstname' =>  $this->input->post('firstname'),
                    'resources_middlename' =>  $this->input->post('middlename'),
                    'resources_lastname' => $this->input->post('lastname'),
                    'resources_gender' => $this->input->post('resources_gender'),
                    'department_id' => $this->input->post('department_id'),
                    'resources_tin' => $this->input->post('tin'),
                    'resources_barcode' => $this->input->post('barcode'),
                    'resources_interest' => $this->input->post('interest'),
                    'resources_type_id' => '1',
                    'resources_logo' => $file,
                );

                $this->Resources_Model->modify($resources, $view);

                $level = array(
                    'level_id' => $this->input->post('level_id')
                );

                $this->Resources_Level_Model->modify_level($level, $view);

                $local_mail = array(
                    'localmail_email' => $this->input->post('email')
                );

                $this->Localmail_Model->modify_resources($local_mail, $view);

                $updated = array(
                    'updated_by' => '1',
                    'updated_table' => 'resources',
                    'updated_table_id' => $view
                );
                
                $updated_id = $this->Updated_Model->insert($updated);

                $data = array(
                    'message' => 'The employee was successfully updated.',
                    'type'    => 'success'
                );
                echo json_encode( $data ); exit();
            }  
        }
        else if($page == "find" && $view != null)
        {
            if( $this->input->is_ajax_request() ) {

                $arr = $this->Resources_Model->find($view);           

                echo json_encode( $arr );

                exit();

            }
        }
        else if($page == "delete" && $view != null)
        {
            if( $this->input->is_ajax_request() ) 
            {
                $status = array(
                    'status_table_id' => $view,
                    'status_table' => 'resources',
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
                    'message' => 'The employee was successfully removed.',
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
                    'status_table' => 'resources',
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
                    'message' => 'The employee was successfully removed.',
                    'type'    => 'success'
                );
                echo json_encode( $data ); exit();

            }   
        }
        else if($page == "save-address")
        {   
            if( $this->input->is_ajax_request() )
            { 
                $resources_id = $this->input->get('resources_id');

                $address = array(
                    'address_table_id' => $resources_id,
                    'address_table' => 'resources',
                    'address_block_no' => $this->input->post('block'),
                    'address_street' => $this->input->post('street'),
                    'address_barangay' => $this->input->post('barangay_id'),
                    'address_city' => $this->input->post('city_id'),
                    'address_province' => $this->input->post('province_id'),
                    'address_region' => 'NCR'
                );

                $address_id = $this->Address_Model->insert($address);

                $created = array(
                    'created_by' => '1',
                    'created_table' => 'address',
                    'created_table_id' => $address_id
                );
                
                $created_id = $this->Created_Model->insert($created);

                $status = array(
                    'status_code' => '1',
                    'status_description' => 'Active',
                    'status_table' => 'address',
                    'status_table_id' => $address_id
                );
                
                $status_id = $this->Status_Model->insert($status);

                $data = array(
                    'message' => 'The employee address was successfully saved.',
                    'type'    => 'success'
                );
                echo json_encode( $data ); exit();
            }
        }
        else if($page == "edit-address" && $view != null)
        {
            if( $this->input->is_ajax_request() ) {

                $arr = $this->Address_Model->find($view);           

                echo json_encode( $arr );

                exit();

            }
        }
        else if($page == "update-address")
        {
            if( $this->input->is_ajax_request() ) 
            { 
                $address = array(
                    'address_block_no' => $this->input->post('block'),
                    'address_street' => $this->input->post('street'),
                    'address_barangay' => $this->input->post('barangay_id'),
                    'address_city' => $this->input->post('city_id'),
                    'address_province' => $this->input->post('province_id'),
                    'address_region' => 'NCR'
                );

                $this->Address_Model->modify($address, $this->input->get('address_no'));

                $updated = array(
                    'updated_by' => '1',
                    'updated_table' => 'address',
                    'updated_table_id' => $this->input->get('address_no')
                );
                
                $this->Updated_Model->insert($updated);

                $data = array(
                    'message' => 'The employee address was successfully updated.',
                    'type'    => 'success'
                );
                echo json_encode( $data ); exit();

            }
        }
        else if($page == "del-address" && $view != null)
        {   
            if( $this->input->is_ajax_request() ) 
            {
                $status = array(
                    'status_table_id' => $view,
                    'status_table' => 'address',
                    'status_code' => '0',
                    'status_description' => 'Inactive'  
                );

                $status_id = $this->Status_Model->delete($status);

                $data = array(
                    'message' => 'The employee address was successfully removed.',
                    'type'    => 'success'
                );
                echo json_encode( $data ); exit();

            }   
        }
        else if($page == "save-contact")
        {   
            if( $this->input->is_ajax_request() )
            { 
                $resources_id = $this->input->get('resources_id');

                $contacts = array(
                    'contact_phone_number' => $this->input->post('phone_number'),
                    'contact_mobile_number' => $this->input->post('mobile_number'),
                    'contact_fax_number' => $this->input->post('fax_number'),
                    'contact_table' => 'resources',
                    'contact_table_id' => $resources_id,
                );

                $contact_id = $this->Contact_Model->insert($contacts);

                
                $created = array(
                    'created_by' => '1',
                    'created_table' => 'contact',
                    'created_table_id' => $contact_id
                );
                
                $created_id = $this->Created_Model->insert($created);

                $status = array(
                    'status_code' => '1',
                    'status_description' => 'Active',
                    'status_table' => 'contact',
                    'status_table_id' => $contact_id
                );
                
                $status_id = $this->Status_Model->insert($status);

                $data = array(
                    "message" => "The employee's contact was successfully saved.",
                    "type"    => "success"
                );
                echo json_encode( $data ); exit();
            }
        }
        else if($page == "edit-contact" && $view != null)
        {
            if( $this->input->is_ajax_request() ) {

                $arr = $this->Contact_Model->find($view);           

                echo json_encode( $arr );

                exit();

            }
        }
        else if($page == "update-contact")
        {
            if( $this->input->is_ajax_request() ) 
            { 
                $contacts = array(
                    'contact_phone_number' => $this->input->post('phone_number'),
                    'contact_mobile_number' => $this->input->post('mobile_number'),
                    'contact_fax_number' => $this->input->post('fax_number')
                );

                $this->Contact_Model->modify($contacts, $this->input->get('contact_no'));

                $updated = array(
                    'updated_by' => '1',
                    'updated_table' => 'contact',
                    'updated_table_id' => $this->input->get('contact_no')
                );
                
                $this->Updated_Model->insert($updated);

                $data = array(
                    "message" => "The employee's contact was successfully updated.",
                    "type"    => "success"
                );
                echo json_encode( $data ); exit();
            }
        }
        else if($page == "del-contact" && $view != null)
        {   
            if( $this->input->is_ajax_request() ) 
            {
                $status = array(
                    'status_table_id' => $view,
                    'status_table' => 'contact',
                    'status_code' => '0',
                    'status_description' => 'Inactive'  
                );

                $status_id = $this->Status_Model->delete($status);

                $data = array(
                    "message" => "The employee's contact was successfully removed.",
                    "type"    => "success"
                );
                echo json_encode( $data ); exit();

            }   
        }
        else if($page == "save-outgoing")
        {   
            if( $this->input->is_ajax_request() )
            { 
                $resources_id = $this->input->get('resources_id');

                $emails = array(
                    'email_address' => $this->input->post('email_address'),
                    'email_description' => $this->input->post('email_description'),
                    'email_table' => 'resources',
                    'email_table_id' => $resources_id,
                );

                $email_id = $this->Email_Model->insert($emails);

                
                $created = array(
                    'created_by' => '1',
                    'created_table' => 'email',
                    'created_table_id' => $email_id
                );
                
                $created_id = $this->Created_Model->insert($created);

                $status = array(
                    'status_code' => '1',
                    'status_description' => 'Active',
                    'status_table' => 'email',
                    'status_table_id' => $email_id
                );
                
                $status_id = $this->Status_Model->insert($status);

                $data = array(
                    "message" => "The employee's outgoing was successfully saved.",
                    "type"    => "success"
                );
                echo json_encode( $data ); exit();
            }
        }
        else if($page == "edit-outgoing" && $view != null)
        {
            if( $this->input->is_ajax_request() ) {

                $arr = $this->Email_Model->find($view);           

                echo json_encode( $arr );

                exit();

            }
        }
        else if($page == "update-outgoing")
        {
            if( $this->input->is_ajax_request() ) 
            { 
                $emails = array(
                    'email_address' => $this->input->post('email_address'),
                    'email_description' => $this->input->post('email_description')
                );

                $this->Email_Model->modify($emails, $this->input->get('outgoing_no'));

                $updated = array(
                    'updated_by' => '1',
                    'updated_table' => 'email',
                    'updated_table_id' => $this->input->get('outgoing_no')
                );
                
                $this->Updated_Model->insert($updated);

                $data = array(
                    "message" => "The employee's outgoing was successfully updated.",
                    "type"    => "success"
                );
                echo json_encode( $data ); exit();

            }
        }
        else if($page == "del-outgoing" && $view != null)
        {   
            if( $this->input->is_ajax_request() ) 
            {
                $status = array(
                    'status_table_id' => $view,
                    'status_table' => 'email',
                    'status_code' => '0',
                    'status_description' => 'Inactive'  
                );

                $status_id = $this->Status_Model->delete($status);

                $data = array(
                    "message" => "The employee's email was successfully removed.",
                    "type"    => "success"
                );
                echo json_encode( $data ); exit();

            }   
        }
        else if($page == "lists" && $view == null)
        {
            if( $this->input->is_ajax_request() )
            {
                $bootgrid_arr = [];
                $current      = null != $this->input->post('current') ? $this->input->post('current') : 1;
                $limit        = $this->input->post('rowCount') == -1 ? 0 : $this->input->post('rowCount');
                $page         = $current !== null ? $current : 1;
                $start_from   = ($page-1) * $limit;
                $wildcard     = null != $this->input->post('searchPhrase') ? $this->input->post('searchPhrase') : null;
                $res_type = 1;

                if( isset($wildcard) )
                {
                    $resources = $this->Resources_Model->like_resources($wildcard, $start_from, $limit, $res_type)->result_array();
                    $total = $this->Resources_Model->likes_resources($wildcard, $res_type)->num_rows();

                }
                else
                {
                    $resources = $this->Resources_Model->get_all_resources($start_from, $limit, $res_type)->result_array();
                    $total = $this->Resources_Model->get_alls_resources($res_type)->num_rows();
                }

                foreach ($resources as $key => $resource) 
                {  
                    $bootgrid_arr[] = array(
                        'count_id'=> $key + 1 + $start_from,
                        'res-id' => $resource['resources_id'],
                        'res-name' => $resource['resources_firstname'].' '.$resource['resources_lastname'],
                        'res-department' => $this->Department_Model->get_department_name_by_id($resource['department_id']),
                        'res-gender' => $resource['resources_gender'],
                        
                        'res-localmail' =>  $this->Localmail_Model->get_localmail_by_resources_id($resource['resources_id'])
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

    public function vendor_form_data($id) 
    {   
        $data = array( 
            'vendor_fname' => $this->Resources_Model->form_input_attributes('resources_firstname', $id),
            'vendor_mname' => $this->Resources_Model->form_input_attributes('resources_middlename', $id),
            'vendor_lname' => $this->Resources_Model->form_input_attributes('resources_lastname', $id),
            'level_attributes' => $this->Level_Model->form_select_attributes('level_id'), 
                'level_options' => $this->Level_Model->form_select_options('level'),
                'level_selected' => $this->Level_Model->form_selected_options($id),
            'department_attributes' => $this->Department_Model->form_select_attributes('department_id'), 
                'department_options' => $this->Department_Model->form_select_options('department'),
                'department_selected' => $this->Department_Model->form_selected_resources_options($id),
            'gender_attributes' => $this->Resources_Model->form_select_gender_attributes('resources_gender'), 
                'gender_options' => $this->Resources_Model->form_select_gender_options('gender'),
                'gender_selected' => $this->Resources_Model->form_selected_gender_options($id),
            'local_mail' => $this->Localmail_Model->form_input_email_resources_attributes('localmail_email', $id),
            'tin' => $this->Resources_Model->form_input_numeric_attributes('resources_tin', $id),
            'barcode' => $this->Resources_Model->form_input_numeric_attributes('resources_barcode', $id),
            'interest' => $this->Resources_Model->form_textarea_attributes('resources_interest', $id),
            'province_attributes' => $this->Province_Model->form_select_resources_attributes('province_id'), 
                'province_options' => $this->Province_Model->form_select_resources_options('province'),
                'province_selected' => $this->Province_Model->form_selected_resources_options($id),
            'city_attributes' => $this->City_Model->form_select_resources_attributes('city_id'), 
                'city_options' => $this->City_Model->form_select_resources_options('city', $id),
                'city_selected' => $this->City_Model->form_selected_resources_options($id),
            'barangay_attributes' => $this->Barangay_Model->form_select_resources_attributes('barangay_id'), 
                'barangay_options' => $this->Barangay_Model->form_select_resources_options('barangay', $id),
                'barangay_selected' => $this->Barangay_Model->form_selected_resources_options($id),
            'block' => $this->Address_Model->form_input_resources_attributes('block', $id),
            'street' => $this->Address_Model->form_input_resources_attributes('street', $id),
            'region' => $this->Address_Model->form_input_disabled_resources_attributes('region', $id),
            'phone_number' => $this->Contact_Model->form_input_numeric_resources_attributes('contact_phone_number', $id),
            'mobile_number' => $this->Contact_Model->form_input_numeric_resources_attributes('contact_mobile_number', $id),
            'fax_number' => $this->Contact_Model->form_input_numeric_resources_attributes('contact_fax_number', $id),
            'email_address' => $this->Email_Model->form_input_email_resources_attributes('email_address', $id),
            'email_description' => $this->Email_Model->form_input_resources_attributes('email_description', $id),
            'resources_file' => $this->Resources_Model->form_file($id),
            'payment_terms_attributes' => $this->Payment_Terms_Model->form_select_attributes('payment_terms_id'), 
                'payment_terms_options' => $this->Payment_Terms_Model->form_select_options('payment_terms', $id),
                'payment_terms_selected' => $this->Payment_Terms_Model->form_selected_resources_options($id),
            'vendor_account' => $this->Resources_Model->form_input_attributes('resources_account', $id),
            'vendor_purchase_code' => $this->Resources_Model->form_input_attributes('resources_purchase_code', $id),
            'vendor_shipment_method' => $this->Resources_Model->form_input_attributes('resources_shipment_method', $id)
        );
        return $data;
    }

    public function vendor($page = null, $view = null, $param1 = null, $param2 =null)
    {
        $this->validated();
        if($page == "manage" || $page == null)
        {
            $data['menu'] = $this->load_menus($this->session->userdata('priviledge_id'));
            $data['template']   = array(
                'title'         => 'Resources',
                'sub_title'     => 'vendor',
                'method'        => 'Manage',
                'body'          => 'users/manage/vendor',
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
                    '<script src="' . base_url("assets/private/users/js/resources.js") . '"></script>'
                    )
                );
            $this->load->view($data['template']['layouts'], $data);
        }
        else if($page == "add")
        {
            $data['menu'] = $this->load_menus($this->session->userdata('priviledge_id'));
            $data['input'] = $this->vendor_form_data('');
            $data['template']   = array(
                'title'         => 'Resources',
                'sub_title'     => 'vendor',
                'method'        => 'Add',
                'body'          => 'users/add/vendor',
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
                    '<script src="' . base_url("assets/private/users/js/resources.js") . '"></script>'
                    )
                );
            $this->load->view($data['template']['layouts'], $data);
        }
        else if($page == "edit" && $view != null)
        {
            $data['menu'] = $this->load_menus($this->session->userdata('priviledge_id'));
            $data['input'] = $this->vendor_form_data($view);
            $data['template']   = array(
                'title'         => 'Resources',
                'sub_title'     => 'vendor',
                'method'        => 'Add',
                'body'          => 'users/edit/vendor',
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
                    '<script src="' . base_url("assets/private/users/js/resources.js") . '"></script>'
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
                    $folder = mkdir("uploads/resources/".date('Y-m-d H:i:s'), 0777);
                    $uploaddir = 'uploads/resources/'.date('Y-m-d H:i:s').'/';

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
                $file = 'resources/'.date('Y-m-d H:i:s').'/'.$_GET['filename'];

                $resources = array(
                    'resources_firstname' =>  $this->input->post('firstname'),
                    'resources_middlename' =>  $this->input->post('middlename'),
                    'resources_lastname' => $this->input->post('lastname'),
                    'resources_gender' => $this->input->post('resources_gender'),
                    'department_id' => $this->input->post('department_id'),
                    'resources_tin' => $this->input->post('tin'),
                    'resources_barcode' => $this->input->post('barcode'),
                    'resources_interest' => $this->input->post('interest'),
                    'resources_account' => $this->input->post('account'),
                    'resources_purchase_code' => $this->input->post('purchase_code'),
                    'resources_shipment_method' => $this->input->post('shipment_method'),
                    'resources_type_id' => '2',
                    'resources_logo' => $file,
                );

                $resources_id = $this->Resources_Model->insert($resources);
                
                $level = array(
                    'level_id' => $this->input->post('level_id'),
                    'resources_id' => $resources_id
                );

                $level_id = $this->Resources_Level_Model->insert($level);

                $payment_terms = array(
                    'payment_terms_id' => $this->input->post('payment_terms_id'),
                    'resources_id' => $resources_id
                );

                $payment_terms_id = $this->Payment_Terms_Resources_Model->insert($payment_terms);

                $local_mail = array(
                    'localmail_email' => $this->input->post('email'),
                    'resources_id' => $resources_id
                );

                $local_mail_id = $this->Localmail_Model->insert($local_mail);

                $created = array(
                    'created_by' => '1',
                    'created_table' => 'resources',
                    'created_table_id' => $resources_id
                );
                
                $created_id = $this->Created_Model->insert($created);

                $status = array(
                    'status_code' => '1',
                    'status_description' => 'Active',
                    'status_table' => 'resources',
                    'status_table_id' => $resources_id
                );
                
                $status_id = $this->Status_Model->insert($status);

                $data = array(
                    'resources_id' => $resources_id,
                    'message' => 'The vendor was successfully saved.',
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
                    'status_table' => 'resources',
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
                    'message' => 'The employee was successfully removed.',
                    'type'    => 'success'
                );
                echo json_encode( $data ); exit();

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
                    $file = 'resources/'.date('Y-m-d H:i:s').'/'.$_GET['filename'];
                }

                $resources = array(
                    'resources_firstname' =>  $this->input->post('firstname'),
                    'resources_middlename' =>  $this->input->post('middlename'),
                    'resources_lastname' => $this->input->post('lastname'),
                    'resources_gender' => $this->input->post('resources_gender'),
                    'department_id' => $this->input->post('department_id'),
                    'resources_tin' => $this->input->post('tin'),
                    'resources_barcode' => $this->input->post('barcode'),
                    'resources_interest' => $this->input->post('interest'),
                    'resources_account' => $this->input->post('account'),
                    'resources_purchase_code' => $this->input->post('purchase_code'),
                    'resources_shipment_method' => $this->input->post('shipment_method'),
                    'resources_type_id' => '2',
                    'resources_logo' => $file,
                );

                $this->Resources_Model->modify($resources, $view);

                $level = array(
                    'level_id' => $this->input->post('level_id')
                );

                $this->Resources_Level_Model->modify_level($level, $view);

                $payment_terms = array(
                    'payment_terms_id' => $this->input->post('payment_terms_id')
                );

                $this->Payment_Terms_Resources_Model->modify($payment_terms, $view);

                $local_mail = array(
                    'localmail_email' => $this->input->post('email')
                );

                $this->Localmail_Model->modify_resources($local_mail, $view);

                $updated = array(
                    'updated_by' => '1',
                    'updated_table' => 'resources',
                    'updated_table_id' => $view
                );
                
                $updated_id = $this->Updated_Model->insert($updated);

                $data = array(
                    'message' => 'The vendor was successfully updated.',
                    'type'    => 'success'
                );
                echo json_encode( $data ); exit();
            }  
        }
        else if($page == "find" && $view != null)
        {
            if( $this->input->is_ajax_request() ) {

                $arr = $this->Resources_Model->find($view);           

                echo json_encode( $arr );

                exit();

            }
        }
        else if($page == "save-address")
        {   
            if( $this->input->is_ajax_request() )
            { 
                $resources_id = $this->input->get('resources_id');

                $address = array(
                    'address_table_id' => $resources_id,
                    'address_table' => 'resources',
                    'address_block_no' => $this->input->post('block'),
                    'address_street' => $this->input->post('street'),
                    'address_barangay' => $this->input->post('barangay_id'),
                    'address_city' => $this->input->post('city_id'),
                    'address_province' => $this->input->post('province_id'),
                    'address_region' => 'NCR'
                );

                $address_id = $this->Address_Model->insert($address);

                $created = array(
                    'created_by' => '1',
                    'created_table' => 'address',
                    'created_table_id' => $address_id
                );
                
                $created_id = $this->Created_Model->insert($created);

                $status = array(
                    'status_code' => '1',
                    'status_description' => 'Active',
                    'status_table' => 'address',
                    'status_table_id' => $address_id
                );
                
                $status_id = $this->Status_Model->insert($status);

                $data = array(
                    'message' => 'The vendor address was successfully saved.',
                    'type'    => 'success'
                );
                echo json_encode( $data ); exit();
            }
        }
        else if($page == "edit-address" && $view != null)
        {
            if( $this->input->is_ajax_request() ) {

                $arr = $this->Address_Model->find($view);           

                echo json_encode( $arr );

                exit();

            }
        }
        else if($page == "update-address")
        {
            if( $this->input->is_ajax_request() ) 
            { 
                $address = array(
                    'address_block_no' => $this->input->post('block'),
                    'address_street' => $this->input->post('street'),
                    'address_barangay' => $this->input->post('barangay_id'),
                    'address_city' => $this->input->post('city_id'),
                    'address_province' => $this->input->post('province_id'),
                    'address_region' => 'NCR'
                );

                $this->Address_Model->modify($address, $this->input->get('address_no'));

                $updated = array(
                    'updated_by' => '1',
                    'updated_table' => 'address',
                    'updated_table_id' => $this->input->get('address_no')
                );
                
                $this->Updated_Model->insert($updated);

                $data = array(
                    'message' => 'The vendor address was successfully updated.',
                    'type'    => 'success'
                );
                echo json_encode( $data ); exit();

            }
        }
        else if($page == "del-address" && $view != null)
        {   
            if( $this->input->is_ajax_request() ) 
            {
                $status = array(
                    'status_table_id' => $view,
                    'status_table' => 'address',
                    'status_code' => '0',
                    'status_description' => 'Inactive'  
                );

                $status_id = $this->Status_Model->delete($status);

                $data = array(
                    'message' => 'The vendor address was successfully removed.',
                    'type'    => 'success'
                );
                echo json_encode( $data ); exit();

            }   
        }
        else if($page == "save-contact")
        {   
            if( $this->input->is_ajax_request() )
            { 
                $resources_id = $this->input->get('resources_id');

                $contacts = array(
                    'contact_phone_number' => $this->input->post('phone_number'),
                    'contact_mobile_number' => $this->input->post('mobile_number'),
                    'contact_fax_number' => $this->input->post('fax_number'),
                    'contact_table' => 'resources',
                    'contact_table_id' => $resources_id,
                );

                $contact_id = $this->Contact_Model->insert($contacts);

                
                $created = array(
                    'created_by' => '1',
                    'created_table' => 'contact',
                    'created_table_id' => $contact_id
                );
                
                $created_id = $this->Created_Model->insert($created);

                $status = array(
                    'status_code' => '1',
                    'status_description' => 'Active',
                    'status_table' => 'contact',
                    'status_table_id' => $contact_id
                );
                
                $status_id = $this->Status_Model->insert($status);

                $data = array(
                    "message" => "The vendor's contact was successfully saved.",
                    "type"    => "success"
                );
                echo json_encode( $data ); exit();
            }
        }
        else if($page == "edit-contact" && $view != null)
        {
            if( $this->input->is_ajax_request() ) {

                $arr = $this->Contact_Model->find($view);           

                echo json_encode( $arr );

                exit();

            }
        }
        else if($page == "update-contact")
        {
            if( $this->input->is_ajax_request() ) 
            { 
                $contacts = array(
                    'contact_phone_number' => $this->input->post('phone_number'),
                    'contact_mobile_number' => $this->input->post('mobile_number'),
                    'contact_fax_number' => $this->input->post('fax_number')
                );

                $this->Contact_Model->modify($contacts, $this->input->get('contact_no'));

                $updated = array(
                    'updated_by' => '1',
                    'updated_table' => 'contact',
                    'updated_table_id' => $this->input->get('contact_no')
                );
                
                $this->Updated_Model->insert($updated);

                $data = array(
                    "message" => "The vendor's contact was successfully updated.",
                    "type"    => "success"
                );
                echo json_encode( $data ); exit();

            }
        }
        else if($page == "del-contact" && $view != null)
        {   
            if( $this->input->is_ajax_request() ) 
            {
                $status = array(
                    'status_table_id' => $view,
                    'status_table' => 'contact',
                    'status_code' => '0',
                    'status_description' => 'Inactive'  
                );

                $status_id = $this->Status_Model->delete($status);

                $data = array(
                    "message" => "The vendor's contact was successfully removed.",
                    "type"    => "success"
                );
                echo json_encode( $data ); exit();

            }   
        }
        else if($page == "save-outgoing")
        {   
            if( $this->input->is_ajax_request() )
            { 
                $resources_id = $this->input->get('resources_id');

                $emails = array(
                    'email_address' => $this->input->post('email_address'),
                    'email_description' => $this->input->post('email_description'),
                    'email_table' => 'resources',
                    'email_table_id' => $resources_id,
                );

                $email_id = $this->Email_Model->insert($emails);

                
                $created = array(
                    'created_by' => '1',
                    'created_table' => 'email',
                    'created_table_id' => $email_id
                );
                
                $created_id = $this->Created_Model->insert($created);

                $status = array(
                    'status_code' => '1',
                    'status_description' => 'Active',
                    'status_table' => 'email',
                    'status_table_id' => $email_id
                );
                
                $status_id = $this->Status_Model->insert($status);

                $data = array(
                    "message" => "The vendor's outgoing was successfully saved.",
                    "type"    => "success"
                );
                echo json_encode( $data ); exit();
            }
        }
        else if($page == "edit-outgoing" && $view != null)
        {
            if( $this->input->is_ajax_request() ) {

                $arr = $this->Email_Model->find($view);           

                echo json_encode( $arr );

                exit();

            }
        }
        else if($page == "update-outgoing")
        {
            if( $this->input->is_ajax_request() ) 
            { 
                $emails = array(
                    'email_address' => $this->input->post('email_address'),
                    'email_description' => $this->input->post('email_description')
                );

                $this->Email_Model->modify($emails, $this->input->get('outgoing_no'));

                $updated = array(
                    'updated_by' => '1',
                    'updated_table' => 'email',
                    'updated_table_id' => $this->input->get('outgoing_no')
                );
                
                $this->Updated_Model->insert($updated);

                $data = array(
                    "message" => "The vendor's outgoing was successfully updated.",
                    "type"    => "success"
                );
                echo json_encode( $data ); exit();

            }
        }
        else if($page == "del-outgoing" && $view != null)
        {   
            if( $this->input->is_ajax_request() ) 
            {
                $status = array(
                    'status_table_id' => $view,
                    'status_table' => 'email',
                    'status_code' => '0',
                    'status_description' => 'Inactive'  
                );

                $status_id = $this->Status_Model->delete($status);

                $data = array(
                    "message" => "The vendor's email was successfully removed.",
                    "type"    => "success"
                );
                echo json_encode( $data ); exit();

            }   
        }
        else if($page == "lists" && $view == null)
        {
            if( $this->input->is_ajax_request() )
            {
                $bootgrid_arr = [];
                $current      = null != $this->input->post('current') ? $this->input->post('current') : 1;
                $limit        = $this->input->post('rowCount') == -1 ? 0 : $this->input->post('rowCount');
                $page         = $current !== null ? $current : 1;
                $start_from   = ($page-1) * $limit;
                $wildcard     = null != $this->input->post('searchPhrase') ? $this->input->post('searchPhrase') : null;
                $res_type = 2;

                if( isset($wildcard) )
                {
                    $resources = $this->Resources_Model->like_resources($wildcard, $start_from, $limit, $res_type)->result_array();
                    $total = $this->Resources_Model->likes_resources($wildcard, $res_type)->num_rows();

                }
                else
                {
                    $resources = $this->Resources_Model->get_all_resources($start_from, $limit, $res_type)->result_array();
                    $total = $this->Resources_Model->get_alls_resources($res_type)->num_rows();
                }

                foreach ($resources as $key => $resource) 
                {  
                    $bootgrid_arr[] = array(
                        'count_id'=> $key + 1 + $start_from,
                        'res-id' => $resource['resources_id'],
                        'res-name' => $resource['resources_firstname'].' '.$resource['resources_lastname'],
                        'res-gender' => $resource['resources_gender'],
                        'res-department' => $this->Department_Model->get_department_name_by_id($resource['department_id']),
                        'res-localmail' =>  $this->Localmail_Model->get_localmail_by_resources_id($resource['resources_id'])
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

    public function contractor_form_data($id) 
    {   
        $data = array( 
            'contractor_fname' => $this->Resources_Model->form_input_attributes('resources_firstname', $id),
            'contractor_mname' => $this->Resources_Model->form_input_attributes('resources_middlename', $id),
            'contractor_lname' => $this->Resources_Model->form_input_attributes('resources_lastname', $id),
            'level_attributes' => $this->Level_Model->form_select_attributes('level_id'), 
                'level_options' => $this->Level_Model->form_select_options('level'),
                'level_selected' => $this->Level_Model->form_selected_options($id),
            'department_attributes' => $this->Department_Model->form_select_attributes('department_id'), 
                'department_options' => $this->Department_Model->form_select_options('department'),
                'department_selected' => $this->Department_Model->form_selected_resources_options($id),
            'gender_attributes' => $this->Resources_Model->form_select_gender_attributes('resources_gender'), 
                'gender_options' => $this->Resources_Model->form_select_gender_options('gender'),
                'gender_selected' => $this->Resources_Model->form_selected_gender_options($id),
            'local_mail' => $this->Localmail_Model->form_input_email_resources_attributes('localmail_email', $id),
            'tin' => $this->Resources_Model->form_input_numeric_attributes('resources_tin', $id),
            'barcode' => $this->Resources_Model->form_input_numeric_attributes('resources_barcode', $id),
            'interest' => $this->Resources_Model->form_textarea_attributes('resources_interest', $id),
            'province_attributes' => $this->Province_Model->form_select_resources_attributes('province_id'), 
                'province_options' => $this->Province_Model->form_select_resources_options('province'),
                'province_selected' => $this->Province_Model->form_selected_resources_options($id),
            'city_attributes' => $this->City_Model->form_select_resources_attributes('city_id'), 
                'city_options' => $this->City_Model->form_select_resources_options('city', $id),
                'city_selected' => $this->City_Model->form_selected_resources_options($id),
            'barangay_attributes' => $this->Barangay_Model->form_select_resources_attributes('barangay_id'), 
                'barangay_options' => $this->Barangay_Model->form_select_resources_options('barangay', $id),
                'barangay_selected' => $this->Barangay_Model->form_selected_resources_options($id),
            'block' => $this->Address_Model->form_input_resources_attributes('block', $id),
            'street' => $this->Address_Model->form_input_resources_attributes('street', $id),
            'region' => $this->Address_Model->form_input_disabled_resources_attributes('region', $id),
            'phone_number' => $this->Contact_Model->form_input_numeric_resources_attributes('contact_phone_number', $id),
            'mobile_number' => $this->Contact_Model->form_input_numeric_resources_attributes('contact_mobile_number', $id),
            'fax_number' => $this->Contact_Model->form_input_numeric_resources_attributes('contact_fax_number', $id),
            'email_address' => $this->Email_Model->form_input_email_resources_attributes('email_address', $id),
            'email_description' => $this->Email_Model->form_input_resources_attributes('email_description', $id),
            'resources_file' => $this->Resources_Model->form_file($id),
            'payment_terms_attributes' => $this->Payment_Terms_Model->form_select_attributes('payment_terms_id'), 
                'payment_terms_options' => $this->Payment_Terms_Model->form_select_options('payment_terms', $id),
                'payment_terms_selected' => $this->Payment_Terms_Model->form_selected_resources_options($id),
            'contractor_account' => $this->Resources_Model->form_input_attributes('resources_account', $id),
            'contractor_purchase_code' => $this->Resources_Model->form_input_attributes('resources_purchase_code', $id),
            'contractor_shipment_method' => $this->Resources_Model->form_input_attributes('resources_shipment_method', $id)
        );
        return $data;
    }

    public function contractor($page = null, $view = null, $param1 = null, $param2 =null)
    {
        $this->validated();
        if($page == "manage" || $page == null)
        {
            $data['menu'] = $this->load_menus($this->session->userdata('priviledge_id'));
            $data['template']   = array(
                'title'         => 'Resources',
                'sub_title'     => 'Contractor',
                'method'        => 'Manage',
                'body'          => 'users/manage/contractor',
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
                    '<script src="' . base_url("assets/private/users/js/resources.js") . '"></script>'
                    )
                );
            $this->load->view($data['template']['layouts'], $data);
        }
        else if($page == "add")
        {
            $data['menu'] = $this->load_menus($this->session->userdata('priviledge_id'));
            $data['input'] = $this->contractor_form_data('');
            $data['template']   = array(
                'title'         => 'Resources',
                'sub_title'     => 'Contractor',
                'method'        => 'Add',
                'body'          => 'users/add/contractor',
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
                    '<script src="' . base_url("assets/private/users/js/resources.js") . '"></script>'
                    )
                );
            $this->load->view($data['template']['layouts'], $data);
        }
        else if($page == "edit" && $view != null)
        {
            $data['menu'] = $this->load_menus($this->session->userdata('priviledge_id'));
            $data['input'] = $this->contractor_form_data($view);
            $data['template']   = array(
                'title'         => 'Resources',
                'sub_title'     => 'Contractor',
                'method'        => 'Add',
                'body'          => 'users/edit/contractor',
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
                    '<script src="' . base_url("assets/private/users/js/resources.js") . '"></script>'
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
                    $folder = mkdir("uploads/resources/".date('Y-m-d H:i:s'), 0777);
                    $uploaddir = 'uploads/resources/'.date('Y-m-d H:i:s').'/';

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
                $file = 'resources/'.date('Y-m-d H:i:s').'/'.$_GET['filename'];

                $resources = array(
                    'resources_firstname' =>  $this->input->post('firstname'),
                    'resources_middlename' =>  $this->input->post('middlename'),
                    'resources_lastname' => $this->input->post('lastname'),
                    'resources_gender' => $this->input->post('resources_gender'),
                    'department_id' => $this->input->post('department_id'),
                    'resources_tin' => $this->input->post('tin'),
                    'resources_barcode' => $this->input->post('barcode'),
                    'resources_interest' => $this->input->post('interest'),
                    'resources_account' => $this->input->post('account'),
                    'resources_purchase_code' => $this->input->post('purchase_code'),
                    'resources_shipment_method' => $this->input->post('shipment_method'),
                    'resources_type_id' => '3',
                    'resources_logo' => $file,
                );

                $resources_id = $this->Resources_Model->insert($resources);
                
                $level = array(
                    'level_id' => $this->input->post('level_id'),
                    'resources_id' => $resources_id
                );

                $level_id = $this->Resources_Level_Model->insert($level);

                $payment_terms = array(
                    'payment_terms_id' => $this->input->post('payment_terms_id'),
                    'resources_id' => $resources_id
                );

                $payment_terms_id = $this->Payment_Terms_Resources_Model->insert($payment_terms);

                $local_mail = array(
                    'localmail_email' => $this->input->post('email'),
                    'resources_id' => $resources_id
                );

                $local_mail_id = $this->Localmail_Model->insert($local_mail);

                $created = array(
                    'created_by' => '1',
                    'created_table' => 'resources',
                    'created_table_id' => $resources_id
                );
                
                $created_id = $this->Created_Model->insert($created);

                $status = array(
                    'status_code' => '1',
                    'status_description' => 'Active',
                    'status_table' => 'resources',
                    'status_table_id' => $resources_id
                );
                
                $status_id = $this->Status_Model->insert($status);

                $data = array(
                    'resources_id' => $resources_id,
                    'message' => 'The contractor was successfully saved.',
                    'type'    => 'success'
                );
                echo json_encode( $data ); exit();
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
                    $file = 'resources/'.date('Y-m-d H:i:s').'/'.$_GET['filename'];
                }

                $resources = array(
                    'resources_firstname' =>  $this->input->post('firstname'),
                    'resources_middlename' =>  $this->input->post('middlename'),
                    'resources_lastname' => $this->input->post('lastname'),
                    'resources_gender' => $this->input->post('resources_gender'),
                    'department_id' => $this->input->post('department_id'),
                    'resources_tin' => $this->input->post('tin'),
                    'resources_barcode' => $this->input->post('barcode'),
                    'resources_interest' => $this->input->post('interest'),
                    'resources_account' => $this->input->post('account'),
                    'resources_purchase_code' => $this->input->post('purchase_code'),
                    'resources_shipment_method' => $this->input->post('shipment_method'),
                    'resources_type_id' => '3',
                    'resources_logo' => $file,
                );

                $this->Resources_Model->modify($resources, $view);

                $level = array(
                    'level_id' => $this->input->post('level_id')
                );

                $this->Resources_Level_Model->modify_level($level, $view);

                $payment_terms = array(
                    'payment_terms_id' => $this->input->post('payment_terms_id')
                );

                $this->Payment_Terms_Resources_Model->modify($payment_terms, $view);

                $local_mail = array(
                    'localmail_email' => $this->input->post('email')
                );

                $this->Localmail_Model->modify_resources($local_mail, $view);

                $updated = array(
                    'updated_by' => '1',
                    'updated_table' => 'resources',
                    'updated_table_id' => $view
                );
                
                $updated_id = $this->Updated_Model->insert($updated);

                $data = array(
                    'message' => 'The contractor was successfully updated.',
                    'type'    => 'success'
                );
                echo json_encode( $data ); exit();
            }  
        }
        else if($page == "find" && $view != null)
        {
            if( $this->input->is_ajax_request() ) {

                $arr = $this->Resources_Model->find($view);           

                echo json_encode( $arr );

                exit();

            }
        }
        else if($page == "delete" && $view != null)
        {
            if( $this->input->is_ajax_request() ) 
            {
                $status = array(
                    'status_table_id' => $view,
                    'status_table' => 'resources',
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
                    'message' => 'The employee was successfully removed.',
                    'type'    => 'success'
                );
                echo json_encode( $data ); exit();

            }   
        }
        else if($page == "save-address")
        {   
            if( $this->input->is_ajax_request() )
            { 
                $resources_id = $this->input->get('resources_id');

                $address = array(
                    'address_table_id' => $resources_id,
                    'address_table' => 'resources',
                    'address_block_no' => $this->input->post('block'),
                    'address_street' => $this->input->post('street'),
                    'address_barangay' => $this->input->post('barangay_id'),
                    'address_city' => $this->input->post('city_id'),
                    'address_province' => $this->input->post('province_id'),
                    'address_region' => 'NCR'
                );

                $address_id = $this->Address_Model->insert($address);

                $created = array(
                    'created_by' => '1',
                    'created_table' => 'address',
                    'created_table_id' => $address_id
                );
                
                $created_id = $this->Created_Model->insert($created);

                $status = array(
                    'status_code' => '1',
                    'status_description' => 'Active',
                    'status_table' => 'address',
                    'status_table_id' => $address_id
                );
                
                $status_id = $this->Status_Model->insert($status);

                $data = array(
                    'message' => 'The contractor address was successfully saved.',
                    'type'    => 'success'
                );
                echo json_encode( $data ); exit();
            }
        }
        else if($page == "edit-address" && $view != null)
        {
            if( $this->input->is_ajax_request() ) {

                $arr = $this->Address_Model->find($view);           

                echo json_encode( $arr );

                exit();

            }
        }
        else if($page == "update-address")
        {
            if( $this->input->is_ajax_request() ) 
            { 
                $address = array(
                    'address_block_no' => $this->input->post('block'),
                    'address_street' => $this->input->post('street'),
                    'address_barangay' => $this->input->post('barangay_id'),
                    'address_city' => $this->input->post('city_id'),
                    'address_province' => $this->input->post('province_id'),
                    'address_region' => 'NCR'
                );

                $this->Address_Model->modify($address, $this->input->get('address_no'));

                $updated = array(
                    'updated_by' => '1',
                    'updated_table' => 'address',
                    'updated_table_id' => $this->input->get('address_no')
                );
                
                $this->Updated_Model->insert($updated);

                $data = array(
                    'message' => 'The contractor address was successfully updated.',
                    'type'    => 'success'
                );
                echo json_encode( $data ); exit();

            }
        }
        else if($page == "del-address" && $view != null)
        {   
            if( $this->input->is_ajax_request() ) 
            {
                $status = array(
                    'status_table_id' => $view,
                    'status_table' => 'address',
                    'status_code' => '0',
                    'status_description' => 'Inactive'  
                );

                $status_id = $this->Status_Model->delete($status);

                $data = array(
                    'message' => 'The contractor address was successfully removed.',
                    'type'    => 'success'
                );
                echo json_encode( $data ); exit();

            }   
        }
        else if($page == "save-contact")
        {   
            if( $this->input->is_ajax_request() )
            { 
                $resources_id = $this->input->get('resources_id');

                $contacts = array(
                    'contact_phone_number' => $this->input->post('phone_number'),
                    'contact_mobile_number' => $this->input->post('mobile_number'),
                    'contact_fax_number' => $this->input->post('fax_number'),
                    'contact_table' => 'resources',
                    'contact_table_id' => $resources_id,
                );

                $contact_id = $this->Contact_Model->insert($contacts);

                
                $created = array(
                    'created_by' => '1',
                    'created_table' => 'contact',
                    'created_table_id' => $contact_id
                );
                
                $created_id = $this->Created_Model->insert($created);

                $status = array(
                    'status_code' => '1',
                    'status_description' => 'Active',
                    'status_table' => 'contact',
                    'status_table_id' => $contact_id
                );
                
                $status_id = $this->Status_Model->insert($status);

                $data = array(
                    "message" => "The contractor's contact was successfully saved.",
                    "type"    => "success"
                );
                echo json_encode( $data ); exit();
            }
        }
        else if($page == "edit-contact" && $view != null)
        {
            if( $this->input->is_ajax_request() ) {

                $arr = $this->Contact_Model->find($view);           

                echo json_encode( $arr );

                exit();

            }
        }
        else if($page == "update-contact")
        {
            if( $this->input->is_ajax_request() ) 
            { 
                $contacts = array(
                    'contact_phone_number' => $this->input->post('phone_number'),
                    'contact_mobile_number' => $this->input->post('mobile_number'),
                    'contact_fax_number' => $this->input->post('fax_number')
                );

                $this->Contact_Model->modify($contacts, $this->input->get('contact_no'));

                $updated = array(
                    'updated_by' => '1',
                    'updated_table' => 'contact',
                    'updated_table_id' => $this->input->get('contact_no')
                );
                
                $this->Updated_Model->insert($updated);

                $data = array(
                    "message" => "The contractor's contact was successfully updated.",
                    "type"    => "success"
                );
                echo json_encode( $data ); exit();

            }
        }
        else if($page == "del-contact" && $view != null)
        {   
            if( $this->input->is_ajax_request() ) 
            {
                $status = array(
                    'status_table_id' => $view,
                    'status_table' => 'contact',
                    'status_code' => '0',
                    'status_description' => 'Inactive'  
                );

                $status_id = $this->Status_Model->delete($status);

                $data = array(
                    "message" => "The contractor's contact was successfully removed.",
                    "type"    => "success"
                );
                echo json_encode( $data ); exit();

            }   
        }
        else if($page == "save-outgoing")
        {   
            if( $this->input->is_ajax_request() )
            { 
                $resources_id = $this->input->get('resources_id');

                $emails = array(
                    'email_address' => $this->input->post('email_address'),
                    'email_description' => $this->input->post('email_description'),
                    'email_table' => 'resources',
                    'email_table_id' => $resources_id,
                );

                $email_id = $this->Email_Model->insert($emails);

                
                $created = array(
                    'created_by' => '1',
                    'created_table' => 'email',
                    'created_table_id' => $email_id
                );
                
                $created_id = $this->Created_Model->insert($created);

                $status = array(
                    'status_code' => '1',
                    'status_description' => 'Active',
                    'status_table' => 'email',
                    'status_table_id' => $email_id
                );
                
                $status_id = $this->Status_Model->insert($status);

                $data = array(
                    "message" => "The contractor's outgoing was successfully saved.",
                    "type"    => "success"
                );
                echo json_encode( $data ); exit();
            }
        }
        else if($page == "edit-outgoing" && $view != null)
        {
            if( $this->input->is_ajax_request() ) {

                $arr = $this->Email_Model->find($view);           

                echo json_encode( $arr );

                exit();

            }
        }
        else if($page == "update-outgoing")
        {
            if( $this->input->is_ajax_request() ) 
            { 
                $emails = array(
                    'email_address' => $this->input->post('email_address'),
                    'email_description' => $this->input->post('email_description')
                );

                $this->Email_Model->modify($emails, $this->input->get('outgoing_no'));

                $updated = array(
                    'updated_by' => '1',
                    'updated_table' => 'email',
                    'updated_table_id' => $this->input->get('outgoing_no')
                );
                
                $this->Updated_Model->insert($updated);

                $data = array(
                    "message" => "The contractor's outgoing was successfully updated.",
                    "type"    => "success"
                );
                echo json_encode( $data ); exit();

            }
        }
        else if($page == "del-outgoing" && $view != null)
        {   
            if( $this->input->is_ajax_request() ) 
            {
                $status = array(
                    'status_table_id' => $view,
                    'status_table' => 'email',
                    'status_code' => '0',
                    'status_description' => 'Inactive'  
                );

                $status_id = $this->Status_Model->delete($status);

                $data = array(
                    "message" => "The contractor's email was successfully removed.",
                    "type"    => "success"
                );
                echo json_encode( $data ); exit();

            }   
        }
        else if($page == "lists" && $view == null)
        {
            if( $this->input->is_ajax_request() )
            {
                $bootgrid_arr = [];
                $current      = null != $this->input->post('current') ? $this->input->post('current') : 1;
                $limit        = $this->input->post('rowCount') == -1 ? 0 : $this->input->post('rowCount');
                $page         = $current !== null ? $current : 1;
                $start_from   = ($page-1) * $limit;
                $wildcard     = null != $this->input->post('searchPhrase') ? $this->input->post('searchPhrase') : null;
                $res_type = 3;

                if( isset($wildcard) )
                {
                    $resources = $this->Resources_Model->like_resources($wildcard, $start_from, $limit, $res_type)->result_array();
                    $total = $this->Resources_Model->likes_resources($wildcard, $res_type)->num_rows();

                }
                else
                {
                    $resources = $this->Resources_Model->get_all_resources($start_from, $limit, $res_type)->result_array();
                    $total = $this->Resources_Model->get_alls_resources($res_type)->num_rows();
                }

                foreach ($resources as $key => $resource) 
                {  
                    $bootgrid_arr[] = array(
                        'count_id'=> $key + 1 + $start_from,
                        'res-id' => $resource['resources_id'],
                        'res-name' => $resource['resources_firstname'].' '.$resource['resources_lastname'],
                        'res-gender' => $resource['resources_gender'],
                        'res-department' => $this->Department_Model->get_department_name_by_id($resource['department_id']),
                        'res-localmail' =>  $this->Localmail_Model->get_localmail_by_resources_id($resource['resources_id'])
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

    public function find_city_by_province($id)
    {
        if( $this->input->is_ajax_request() ) 
        {
            if(isset($id))
            {
                $arr = $this->Address_Model->get_city_by_province($id);           

                echo json_encode( $arr );

                exit();
            }
        }
    }

    public function find_barangay_by_city($id)
    {
        if( $this->input->is_ajax_request() ) 
        {
            if(isset($id))
            {
                $arr = $this->Address_Model->get_barangay_by_city($id);           

                echo json_encode( $arr );

                exit();
            }
        }
    }
}