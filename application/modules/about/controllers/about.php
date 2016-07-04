<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class About extends CI_Controller{
    public function __construct(){
        parent::__construct();
    }
    
    function index(){
        $meta['page_title'] = "About Us";
        $data['page_title'] = "About Us";
        $this->load->view('commons/header',$meta);
        $this->load->view('about',$data);
        $this->load->view('commons/footer');
    }
}
?>