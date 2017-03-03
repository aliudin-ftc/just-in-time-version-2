<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {
    
    private $data = array();
    private $redirect = array();

    public function __construct()
    {
        parent::__construct();
        $this->load_models();
    }

    public function load_models()
    {
        $models = array(
            'Resources_Model' => 'Resources_Model',
            'Status_Model' => 'Status_Model',
            'Created_Model' => 'Created_Model',
            'Updated_Model' => 'Updated_Model',
            'Priviledge_Model'  => 'Priviledge_Model',
            'Modules_Model' => 'Modules_Model',
            'User_Model' => 'User_Model'
        );

        $this->load->model($models);  
    }

    public function auth()
    {   
        $this->redirect = array(
            '0' => base_url(),
            '1' => base_url('dashboard')
            );

        if($this->uri->segment(1) != "logout"){
            if($this->session->userdata('priviledge_id')){
                redirect($this->redirect[1]);
            }
        } else {
            $this->logout();
        }
    }   

    public function index()
    {   
        //print_r($this->session->userdata); 
        $this->auth();
        $data['template']   = array(
            'title'         => 'Login',
            'sub_title'     => '',
            'method'        => '',
            'body'          => 'guest/login',
            'layouts'       => 'layouts/guest',
            'page'          => array(),
            'partials'      => array(
                'header'    => 'templates/header',
                'footer'    => 'templates/footer',
                'sidebar1'   => 'templates/sidebar1',
                'sidebar2'   => 'templates/sidebar2'
                ),
            'metadata'      => array(
                '<script src="' . base_url("assets/private/guest/js/login.js") . '"></script>'
                )
            );
        $this->load->view($data['template']['layouts'], $data);
    }

    public function login()
    {
        $username = $this->security->xss_clean($this->input->post('username'));
        $password = $this->security->xss_clean($this->input->post('password'));

        if( $this->User_Model->check($username, $password) ) {
            if( null !== $this->session->userdata('referred_from') ) {
                redirect($this->session->userdata('referred_from'), 'refresh');
            } else { 
                redirect($this->redirect[1]);
            }
        }

        $this->session->set_flashdata('message','Invalid credentials');        
        redirect(base_url('login'));
    }

    public function logout()
    {   
        $this->session->sess_destroy();        
        redirect(base_url('login'), 'refresh');
    }
}