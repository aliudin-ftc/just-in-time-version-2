<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Job_request extends CI_Controller {
    
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
            'Job_Request_Module_Status_Sent_Model' => 'Job_Request_Module_Status_Sent_Model'
        );

        $this->load->model($models);  
    }

    public function check_job_request_type_sequence($id, $module, $job)
    {
        $res = $this->Job_Request_Module_Model->check_sequence($id, $module, $job);

        $data = array(
            "sequence" => $res
        );

        echo json_encode( $data );
        exit();
    }

    public function save()
    {
        if( $this->input->is_ajax_request() )
        {   
            $job_order_id = $this->Job_Order_Model->find_job_order_id($this->input->get('job_order_no'));

            $job_order = array(
                "job_status_id" => $this->input->post('job_status_id')
            );

            $this->Job_Order_Model->modify($job_order, $this->input->get('job_order_no'));

            $job_request_module = array(
                'job_order_id' =>  $job_order_id ,
                'job_request_id' => $this->input->post('job_request_id'),
                'job_request_type_id' => $this->input->post('job_request_type_id'),
                'job_request_category_id' => $this->input->post('job_request_category_id'),
                'department_id' => $this->input->post('department_id'),
                'job_status_id' => $this->input->post('job_status_id'),
                'job_request_module_sequence' => $this->input->get('job_request_sequence'),
                'job_request_module_qty' => $this->input->post('job_request_module_qty'),
                'job_request_module_req_date' => date("Y-m-d", strtotime($this->input->post('job_request_module_req_date'))),
                'job_request_module_due_date' => date("Y-m-d", strtotime($this->input->post('job_request_module_due_date'))),
                'job_request_module_instructions' => $this->input->post('job_request_module_instructions'),
                'job_request_module_attachments' => $this->input->post('job_request_module_attachments'),
                'job_request_module_status_id' => 1
            );

            $job_request_module_id = $this->Job_Request_Module_Model->insert($job_request_module);

            $created = array(
                'created_by' => '1',
                'created_table' => 'job_request_module',
                'created_table_id' => $job_request_module_id
            );
            
            $created_id = $this->Created_Model->insert($created);
            
            $status = array(
                'status_code' => '1',
                'status_description' => 'Active',
                'status_table' => 'job_request_module',
                'status_table_id' => $job_request_module_id
            );
            
            $status_id = $this->Status_Model->insert($status);

            $data = array(
                'job_request_module_id' => $job_request_module_id,
                'message' => 'The job request was successfully saved.',
                'type'    => 'success'
            );

            echo json_encode( $data ); exit();
        }
    }

    public function update()
    {
        if( $this->input->is_ajax_request() )
        {   
            $job_order_id = $this->Job_Order_Model->find_job_order_id($this->input->get('job_order_no'));

            if( null !== $this->input->post('job_status_id') )
            {
                $job_request_module = array(
                    'job_order_id' =>  $job_order_id ,
                    'job_request_id' => $this->input->post('job_request_id'),
                    'job_request_type_id' => $this->input->post('job_request_type_id'),
                    'job_request_category_id' => $this->input->post('job_request_category_id'),
                    'department_id' => $this->input->post('department_id'),
                    'job_status_id' => $this->input->post('job_status_id'),
                    'job_request_module_sequence' => $this->input->get('job_request_sequence'),
                    'job_request_module_qty' => $this->input->post('job_request_module_qty'),
                    'job_request_module_req_date' => date("Y-m-d", strtotime($this->input->post('job_request_module_req_date'))),
                    'job_request_module_due_date' => date("Y-m-d", strtotime($this->input->post('job_request_module_due_date'))),
                    'job_request_module_instructions' => $this->input->post('job_request_module_instructions'),
                    'job_request_module_attachments' => $this->input->post('job_request_module_attachments'),
                    'job_request_module_status_id' => 1
                );
            } 
            else 
            {
                $job_request_module = array(
                    'job_order_id' =>  $job_order_id ,
                    'department_id' => $this->input->post('department_id'),
                    'job_request_module_sequence' => $this->input->get('job_request_sequence'),
                    'job_request_module_qty' => $this->input->post('job_request_module_qty'),
                    'job_request_module_req_date' => date("Y-m-d", strtotime($this->input->post('job_request_module_req_date'))),
                    'job_request_module_due_date' => date("Y-m-d", strtotime($this->input->post('job_request_module_due_date'))),
                    'job_request_module_instructions' => $this->input->post('job_request_module_instructions'),
                    'job_request_module_attachments' => $this->input->post('job_request_module_attachments'), 
                    'job_request_module_status_id' => 1
                );
            }

            $this->Job_Request_Module_Model->modify($job_request_module, $this->input->get('module_id'));

            $updated = array(
                'updated_by' => '1',
                'updated_table' => 'job_request_module',
                'updated_table_id' => $this->input->get('module_id')
            );
            
            $this->Updated_Model->insert($updated);

            $data = array(
                'job_request_module_id' => $this->input->get('module_id'),
                'message' => 'The job request was successfully updated.',
                'type'    => 'success'
            );

            echo json_encode( $data ); exit();
        }
    }

    public function download($base, $folder, $timestamp, $file)
    {
        $this->load->helper('download');
        force_download($base.'/'.$folder.'/'.urldecode($timestamp).'/'.$file, NULL);
    }
    
    public function uploads($id)
    {
        if( $this->input->is_ajax_request() )
        {
            $files = array();
            $folder = mkdir("uploads/job-request/".date('Y-m-d H:i:s'), 0777);
            $uploaddir = 'uploads/job-request/'.date('Y-m-d H:i:s').'/';

            foreach($_FILES as $file)
            {
                if(move_uploaded_file($file['tmp_name'], $uploaddir .basename($file['name'])))
                {
                    $files[] = $uploaddir .$file['name'];

                    $upload_file = array(
                        "uploads_filename" => $file['name'],
                        "uploads_format" => $file['type'],
                        "uploads_link" => $uploaddir .basename($file['name']),
                        "uploads_table" => 'job_request_module',
                        "uploads_table_id" => $id
                    );

                    $upload_file_id = $this->Uploads_Model->insert($upload_file);

                    $status = array(
                        'status_code' => '1',
                        'status_description' => 'Active',
                        'status_table' => 'uploads',
                        'status_table_id' => $upload_file_id
                    );

                    $status_id = $this->Status_Model->insert($status);
                }

                $data = array(
                    "message" => "success"
                );

                echo json_encode( $data );
                exit();
            }
        }     
    }

    public function delete_element($id)
    {
        if( $this->input->is_ajax_request() )
        {
            $elements = explode(",", $this->input->get('elements'));

            $arr = array();
            foreach ($elements as $element) {
                $arr[] = $element;

                $attach = array(
                    'job_request_module_id' => 0
                );

                $this->Job_Element_Model->modify($attach, $element);

                $updated = array(
                    'updated_by' => '1',
                    'updated_table' => 'job_elements',
                    'updated_table_id' => $element
                );

                $this->Updated_Model->insert($updated);
            }

            $data = array(
                'element' => $arr,
                'message' => 'The job element was successfully removed.',
                'type'    => 'success'
            );
            echo json_encode( $data ); exit();
        }
    }

    public function save_elements($id)
    {   
        if( $this->input->is_ajax_request() )
        {
            $elements = explode(",", $this->input->get('elements'));

            $arr = array();
            foreach ($elements as $element) {
                $arr[] = $element;

                $attach = array(
                    'job_request_module_id' => $id
                );

                $this->Job_Element_Model->modify($attach, $element);

                $updated = array(
                    'updated_by' => '1',
                    'updated_table' => 'job_elements',
                    'updated_table_id' => $element
                );

                $this->Updated_Model->insert($updated);
            }

            $data = array(
                'element' => $arr,
                'message' => 'The job element was successfully removed.',
                'type'    => 'success'
            );
            echo json_encode( $data ); exit();
        }
    }

    public function delete($id)
    {
        if( $this->input->is_ajax_request() )
        {
            $status = array(
                'status_table_id' => $id,
                'status_table' => 'job_request_module',
                'status_code' => '0',
                'status_description' => 'Inactive'  
            );

            $status_id = $this->Status_Model->delete($status);

            $data = array(
                "job_request_module_status" => "cancelled"
            );

            $this->Job_Request_Module_Model->modify($data, $id);

            $updated = array(
                'updated_by' => '1',
                'updated_table' => 'job_request_module',
                'updated_table_id' => $id
            );

            $this->Updated_Model->insert($updated);

            $data = array(
                'message' => 'The job element was successfully removed.',
                'type'    => 'success'
            );
            echo json_encode( $data ); exit();
        }     
    }

    public function undo($id)
    {
        if( $this->input->is_ajax_request() )
        {
            $status = array(
                'status_table_id' => $id,
                'status_table' => 'job_request_module',
                'status_code' => '1',
                'status_description' => 'Active'  
            );

            $status_id = $this->Status_Model->delete($status);

            $data = array(
                'message' => 'The job element was successfully restored.',
                'type'    => 'success'
            );
            echo json_encode( $data ); exit();
        }     
    }

    public function check_element($job_no, $req_id)
    {
        if( $this->input->is_ajax_request() )
        {   
            $job_order_id = $this->Job_Order_Model->find_job_order_id($job_no);

            $counts = $this->Job_Request_Model->check_element_attach($job_order_id, $req_id);
            
            $data = array(
                'counts'  => $counts,
                'message' => 'The job element was successfully restored.',
                'type'    => 'success'
            );
            echo json_encode( $data ); exit();
        }
    }
    
    public function send($id)
    {
        if( $this->input->is_ajax_request() )
        {
            $job_request = array(
                'job_request_module_status_id' => 2
            );

            $this->Job_Request_Module_Model->modify($job_request, $id);

            $updated = array(
                'updated_by' => $this->session->userdata('resources_id'),
                'updated_table' => 'job_request_module',
                'updated_table_id' => $id
            );

            $this->Updated_Model->insert($updated);

            $job_stat_sent = array(
                'job_request_module_id' => $id,
                'job_request_module_status_id' => 2,
                'resources_id' => $this->session->userdata('resources_id')
            );

            $job_sent_id = $this->Job_Request_Module_Status_Sent_Model->insert($job_stat_sent);

            $data = array(
                'message' => 'The job request has been sent.',
                'type'    => 'success'
            );
            echo json_encode( $data ); exit();
        }
    }

    public function delete_uploads($id)
    {
        if( $this->input->is_ajax_request() )
        {
            $status = array(
                'status_table_id' => $id,
                'status_table' => 'uploads',
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

    public function find_job_request_by_job_status($id)
    {
        if( $this->input->is_ajax_request() ) 
        {
            if(isset($id))
            {
                $arr = $this->Job_Request_Model->get_request_by_jobs_status($id);           

                echo json_encode( $arr );

                exit();
            }
        }
    }

    public function find_job_request_type_by_job_request($id)
    {
        if( $this->input->is_ajax_request() ) 
        {
            if(isset($id))
            {
                $arr = $this->Job_Request_Type_Model->get_request_type_by_job_request($id);           

                echo json_encode( $arr );

                exit();
            }
        }
    }

    public function find_job_request_category_by_job_request($id)
    {
        if( $this->input->is_ajax_request() ) 
        {
            if(isset($id))
            {
                $arr = $this->Job_Request_Category_Model->get_request_category_by_job_request($id);           

                echo json_encode( $arr );

                exit();
            }
       }
    }
}