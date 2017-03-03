<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends CI_Controller {
    
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
            'Modules_Model' => 'Modules_Model'
        );

        $this->load->model($models);  
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


    public function index()
    {  
        $this->validated();
        $data['menu'] = $this->load_menus($this->session->userdata('priviledge_id'));
        $data['template']   = array(
            'title'         => 'Dashboard',
            'sub_title'     => '',
            'method'        => 'Manage',
            'body'          => 'users/dashboard',
            'layouts'       => 'layouts/users',
            'page'          => array(),
            'partials'      => array(
                'header'    => 'templates/header',
                'footer'    => 'templates/footer',
                'sidebar1'   => 'templates/sidebar1',
                'sidebar2'   => 'templates/sidebar2'
                ),
            'metadata'      => array(
                '<link href="' . base_url("assets/public/vendors/bower_components/fullcalendar/dist/fullcalendar.min.css"). '" rel="stylesheet">',
                '<script src="' . base_url("assets/public/vendors/bower_components/fullcalendar/dist/fullcalendar.min.js").'"></script>',
                '<script src="' . base_url("assets/public/vendors/bower_components/simpleWeather/jquery.simpleWeather.min.js").'"></script>',
                '<script src="' . base_url("assets/public/vendors/bower_components/salvattore/dist/salvattore.min.js").'"></script>',
                '<script src="' . base_url("assets/public/vendors/bower_components/flot/jquery.flot.js").'"></script>',
                '<script src="' . base_url("assets/public/vendors/bower_components/flot/jquery.flot.resize.js").'"></script>',
                '<script src="' . base_url("assets/public/vendors/bower_components/flot.curvedlines/curvedLines.js").'"></script>',
                '<script src="' . base_url("assets/public/vendors/sparklines/jquery.sparkline.min.js").'"></script>',
                '<script src="' . base_url("assets/public/vendors/bower_components/jquery.easy-pie-chart/dist/jquery.easypiechart.min.js").'"></script>',
                '<script src="' . base_url("assets/public/js/flot-charts/curved-line-chart.js").'"></script>',
                '<script src="' . base_url("assets/public/js/flot-charts/line-chart.js").'"></script>',
                '<script src="' . base_url("assets/public/js/charts.js"). '"></script>'
                )
            );
        $this->load->view($data['template']['layouts'], $data);
    }
}