<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Settings extends CI_Controller{
    function __construct(){
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('settings_model');
        $this->load->library('upload');
    }
    
    function index(){
        // validation
        $this->form_validation->set_rules('name','Name','trim|required');
        $this->form_validation->set_rules('address','Address','trim|required');
        $this->form_validation->set_rules('currency','Currency Code','trim');
        
        if($this->form_validation->run() == true){
            if($_FILES['logo']['size'] > 0)
			{
                $ext1 = end(explode(".", $_FILES['logo']['name']));
                $file_name = "logo".".".$ext1;
                $image_path = realpath(APPPATH."../assets/uploads/logo/");
                $config1 = array(
				'upload_path' => $image_path,
				'allowed_types' => "gif|jpg|png|jpeg",
				'overwrite' => TRUE,
				'file_name' => $file_name
				);
                // echo '<pre>';
                // print_r($config1);
                $this->upload->initialize($config1);
                if($this->upload->do_upload('logo'))
				{
					$data1 = array('logo' => $this->upload->data());
                }
				else
				{
                    // echo '<pre>';    
					$error = array('error' => $this->upload->display_errors());
                    // print_r($error);
					$this->load->view('add', $error);
				}
            }
            else
            {
                $data1['logo']['file_name'] = $this->input->post('logo_img');
            }
            
            $data = array(
                'logo'              =>  $data1['logo']['file_name'],
                'company_name'      =>  $this->input->post('name'),
                'company_address'   =>  $this->input->post('address'),  
                'currency_code'     =>  $this->input->post('currency'),
            );
            // echo '<pre>';
            // print_r($data);exit;
        }
        
        if($this->form_validation->run() == true && $this->settings_model->updateSetting($data)){
            $this->session->set_flashdata('success','Settings Updated successfully.');
            redirect('settings','refresh');
        }else{
            $data['setting'] = $this->settings_model->getSettings();
            // echo '<pre>';
            // print_r($data['setting']);exit;
            $data['page_title'] = "System Settings";
            $meta['page_title'] = "System Settings";
            $this->load->view('commons/header',$meta);
            $this->load->view('index',$data);
            $this->load->view('commons/footer',$meta);
        }
    }
}
?>