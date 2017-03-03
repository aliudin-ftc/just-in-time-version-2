<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Job_element extends CI_Controller {
    
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
            'Job_Element_Model' => 'Job_Element_Model'
        );

        $this->load->model($models);  
    }

    public function save()
    {
        if( $this->input->is_ajax_request() )
        {   
            $job_order_id = $this->Job_Order_Model->find_job_order_id($this->input->get('job_order_no'));

            $job_elements = array(
                'job_order_id' => $job_order_id,
                'product_category_id' =>  $this->input->post('product_category_id'),
                'sub_category_id' => $this->input->post('sub_category_id'),
                'packing_instructions_id' => $this->input->post('packing_instructions_id'),
                'job_elements_name' => $this->input->post('job_elements_name'),
                'job_elements_quantity' => $this->input->post('job_elements_quantity'),
                'job_elements_font_size' => $this->input->post('job_elements_font_size'),
                'job_elements_font_uom' => $this->input->post('job_elements_font_uom'),
                'job_elements_depth_size' => $this->input->post('job_elements_depth_size'),
                'job_elements_depth_uom' => $this->input->post('job_elements_depth_uom'),
                'job_elements_height_size' => $this->input->post('job_elements_height_size'),
                'job_elements_height_uom' => $this->input->post('job_elements_height_uom'),
                'job_elements_delivery_location' => $this->input->post('job_elements_delivery_location'),
                'job_elements_remarks' => $this->input->post('job_elements_remarks')
            );

            $job_elements_id = $this->Job_Element_Model->insert($job_elements);

            $created = array(
                'created_by' => '1',
                'created_table' => 'job_elements',
                'created_table_id' => $job_elements_id
            );
            
            $created_id = $this->Created_Model->insert($created);
            
            $status = array(
                'status_code' => '1',
                'status_description' => 'Active',
                'status_table' => 'job_elements',
                'status_table_id' => $job_elements_id
            );
            
            $status_id = $this->Status_Model->insert($status);

            $data = array(
                'job_elements_id' => $job_elements_id,
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

            $job_elements = array(
                'job_order_id' => $job_order_id,
                'product_category_id' =>  $this->input->post('product_category_id'),
                'sub_category_id' => $this->input->post('sub_category_id'),
                'packing_instructions_id' => $this->input->post('packing_instructions_id'),
                'job_elements_name' => $this->input->post('job_elements_name'),
                'job_elements_quantity' => $this->input->post('job_elements_quantity'),
                'job_elements_font_size' => $this->input->post('job_elements_font_size'),
                'job_elements_font_uom' => $this->input->post('job_elements_font_uom'),
                'job_elements_depth_size' => $this->input->post('job_elements_depth_size'),
                'job_elements_depth_uom' => $this->input->post('job_elements_depth_uom'),
                'job_elements_height_size' => $this->input->post('job_elements_height_size'),
                'job_elements_height_uom' => $this->input->post('job_elements_height_uom'),
                'job_elements_delivery_location' => $this->input->post('job_elements_delivery_location'),
                'job_elements_remarks' => $this->input->post('job_elements_remarks')
            );

            $this->Job_Element_Model->modify($job_elements, $this->input->get('elements_id'));

            $updated = array(
                'updated_by' => '1',
                'updated_table' => 'job_elements',
                'updated_table_id' => $this->input->get('elements_id')
            );
            
            $this->Updated_Model->insert($updated);

            $data = array(
                'job_elements_id' => $this->input->get('elements_id'),
                'message' => 'The job request was successfully updated.',
                'type'    => 'success'
            );

            echo json_encode( $data ); exit();
        }
    }

    public function uploads($id)
    {
        if( $this->input->is_ajax_request() )
        {
            $files = array();
            $folder = mkdir("uploads/job-element/".date('Y-m-d H:i:s'), 0777);
            $uploaddir = 'uploads/job-element/'.date('Y-m-d H:i:s').'/';

            foreach($_FILES as $file)
            {
                if(move_uploaded_file($file['tmp_name'], $uploaddir .basename($file['name'])))
                {
                    $files[] = $uploaddir .$file['name'];

                    $upload_file = array(
                        "uploads_filename" => $file['name'],
                        "uploads_format" => $file['type'],
                        "uploads_link" => $uploaddir .basename($file['name']),
                        "uploads_table" => 'job_elements',
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

    public function download($base, $folder, $timestamp, $file)
    {
        $this->load->helper('download');
        force_download($base.'/'.$folder.'/'.urldecode($timestamp).'/'.$file, NULL);
    }

    public function delete($id)
    {
        if( $this->input->is_ajax_request() )
        {
            $status = array(
                'status_table_id' => $id,
                'status_table' => 'job_elements',
                'status_code' => '0',
                'status_description' => 'Inactive'  
            );

            $status_id = $this->Status_Model->delete($status);

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
                'status_table' => 'job_elements',
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

    public function available_elements($id)
    {
        if( $this->input->is_ajax_request() )
        {
            $bootgrid_arr = [];
            $current      = null != $this->input->post('current') ? $this->input->post('current') : 1;
            $limit        = $this->input->post('rowCount') == -1 ? 0 : $this->input->post('rowCount');
            $page         = $current !== null ? $current : 1;
            $start_from   = ($page-1) * $limit;
            $wildcard     = null != $this->input->post('searchPhrase') ? $this->input->post('searchPhrase') : null;

            $job_no = $this->input->post('job_order_no');
            $job_id = $this->Job_Order_Model->find_job_order_id($job_no);
            

            if( isset($wildcard) )
            {
                $job_elements = $this->Job_Element_Model->like_available_job_element($wildcard, $start_from, $limit, $id, $job_id)->result_array();
                $total = $this->Job_Element_Model->likes_available_job_element($wildcard, $id, $job_id)->num_rows();

            }
            else
            {
                $job_elements = $this->Job_Element_Model->get_all_available_job_element($start_from,  $limit, $id, $job_id)->result_array();
                $total = $this->Job_Element_Model->get_alls_available_job_element($id, $job_id)->num_rows();
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

    public function attach_elements($id)
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