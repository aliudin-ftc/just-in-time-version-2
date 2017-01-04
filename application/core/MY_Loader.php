<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class MY_Loader extends CI_Loader{
    public function __construct(){
        
    }
    public function controller($file_path){
        $CI = & get_instance();
     
        $file_path_arr = explode('/', $file_path);
        $file_name = end($file_path_arr);
        
        $file_path = APPPATH.'controllers/'.$file_path.'.php';
        $object_name = $file_name;
        $class_name = ucfirst($file_name);
     
        if(file_exists($file_path)){
            require $file_path;
         
            $CI->$object_name = new $class_name();
        }
        else{
            show_error("Unable to load the requested controller class: ".$class_name);
        }
    }
}