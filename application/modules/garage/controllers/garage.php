<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Garage extends CI_Controller 
{
    
    function __construct()
	{
		parent::__construct();
		
		// check if user logged in 
		if (!$this->ion_auth->logged_in())
	  	{
			redirect('auth/login');
	  	}
		$this->load->library('form_validation');
		$this->load->library('Ion_auth');
		$this->security->csrf_verify(); 
		$this->load->model('garage_model');
		$this->load->library('Datatables');
	}
    
    function index()
    {
        if (!$this->ion_auth->logged_in())
	  	{
			redirect('auth/login');
	  	}
        $meta['page_title'] = 'Garage Details';
		$data['page_title'] = "Garage details";
		$this->load->view('commons/header',$meta);
		$this->load->view('index',$data);
		$this->load->view('commons/footer');
    }
    
    function garage_details()
    {
        $this->datatables->select('garage.id,branch.branch_name as branchName,garage_name,location,garage.telephone as telephone,mobile_no,garage.email as email,contact_person')
        //->unset_column('garage.id')
        ->from('garage')
        ->join('branch','branch.id = garage.branch_id', 'INNER')
        ->add_column("Actions", "<a href='garage/view/$1'><i class='fa fa-eye'></i></a> &nbsp; <a href='garage/edit/$1'><i class='fa fa-pencil-square-o'></i></a> &nbsp; <a href='garage/delete/$1' onclick=\"return confirm('Are you sure you want to delete?');\"><i class='fa fa-trash-o'></i></a>", "garage.id");
		
        echo $this->datatables->generate();
    }
    
    function view($garage_id)
    {
        $id = $garage_id;
        $garage_details = $this->garage_model->getGarageByIdwithBranch($garage_id);
        $data['id'] = $garage_id;
        $data['garage'] = $garage_details;
        $meta['page_title'] = 'View Garage';
        $data['page_title'] = "View Garage";
        $this->load->view('commons/header', $meta);
        $this->load->view('view', $data);
        $this->load->view('commons/footer');
    }
    
    function add()
    {
        //garage form validation
        /* ==============VALIDATION FOR SELECTBOX AGENT ================ */
        $this->form_validation->set_rules('branch','Branch','required|callback_check_default');
        $this->form_validation->set_message('check_default', 'You need to select branch other than the default.');
        /* --------------*/
        $this->form_validation->set_rules('garage_name', 'Garage Name', 'trim|required|xss_clean');
        $this->form_validation->set_rules('location', 'Location', 'trim|xss_clean');
        $this->form_validation->set_rules('telephone', 'Telephone', 'trim|xss_clean');
        $this->form_validation->set_rules('mobile_no', 'Mobile No', 'trim|xss_clean');
        $this->form_validation->set_rules('email', 'Email', 'trim|xss_clean|valid_email');
        $this->form_validation->set_rules('contact_person', 'Contact Person', 'trim|xss_clean');
        
        if ($this->form_validation->run() == true)
        {
            $garageDetail = array(
                    'branch_id'	        =>	$this->input->post('branch'),
                    'garage_name'       =>  $this->input->post('garage_name'),
                    'location'          =>  $this->input->post('location'),
                    'telephone'         =>  $this->input->post('telephone'),
                    'mobile_no'         =>  $this->input->post('mobile_no'),
                    'email'             =>  $this->input->post('email'),
                    'contact_person'    =>  $this->input->post('contact_person')
                );
                /*echo '<pre>';
                print_r($garageDetail);exit;*/
        }
        
        if ( ($this->form_validation->run() == true) && $this->garage_model->addGarage($garageDetail))
		{  
			$this->session->set_flashdata('success', 'Garage added successfully.');
			redirect("garage",'refresh');
		}
		else
		{  
			/*$data['property_type_name'] = array('name' => 'property_type_name',
				'id' => 'property_type_name',
				'type' => 'text',
				'value' => $this->form_validation->set_value('property_type_name'),
			);*/
			$data['branch'] = $this->garage_model->getBranch();
		    $meta['page_title'] = 'Add Garage';
            $data['page_title'] = "Add Garage";
            $this->load->view('commons/header', $meta);
            $this->load->view('add', $data);
            $this->load->view('commons/footer');
		
		}	
	}
    
    /* =====================VALIDATION FOR Branch ======================== */
    function check_default($post_string)
    {
        return $post_string == '0' ? FALSE : TRUE;
    }
    
    public function edit($garage_id)
    {
        $id = $garage_id;
        
        if($post = $this->input->post())
        {
            //garage form validation
            /* ==============VALIDATION FOR SELECTBOX AGENT ================ */
            $this->form_validation->set_rules('branch','Branch','required|callback_check_default');
            $this->form_validation->set_message('check_default', 'You need to select branch other than the default.');
            /* --------------*/
            $this->form_validation->set_rules('garage_name', 'Garage Name', 'trim|required|xss_clean');
            $this->form_validation->set_rules('location', 'Location', 'trim|xss_clean');
            $this->form_validation->set_rules('telephone', 'Telephone', 'trim|xss_clean');
            $this->form_validation->set_rules('mobile_no', 'Mobile No', 'trim|xss_clean');
            $this->form_validation->set_rules('email', 'Email', 'trim|xss_clean|valid_email');
            $this->form_validation->set_rules('contact_person', 'Contact Person', 'trim|xss_clean');
            
            if ($this->form_validation->run() == true)
            {
                $garageDetail = array(
                    'branch_id'	        =>	$this->input->post('branch'),
                    'garage_name'       =>  $this->input->post('garage_name'),
                    'location'          =>  $this->input->post('location'),
                    'telephone'         =>  $this->input->post('telephone'),
                    'mobile_no'         =>  $this->input->post('mobile_no'),
                    'email'             =>  $this->input->post('email'),
                    'contact_person'    =>  $this->input->post('contact_person')
                );
                /*echo '<pre>';
                print_r($garageDetail);exit;*/
            }
            if ( ($this->form_validation->run() == true) && $this->garage_model->updateGarage($garageDetail,$id))
            {  
                $this->session->set_flashdata('success', 'Garage edited successfully.');
                redirect("garage",'refresh');
            }
            else
            {  
                /*$data['property_type_name'] = array('name' => 'property_type_name',
                    'id' => 'property_type_name',
                    'type' => 'text',
                    'value' => $this->form_validation->set_value('property_type_name'),
                );*/
                $garage_details = $this->garage_model->getGarageById($garage_id);
                $data['branch'] = $this->pdc_model->getBranch();
                /*echo '<pre>';
                print_r($branch_details);exit;*/
                $data['id'] = $garage_id;
                $data['garage'] = $garage_details;
                $meta['page_title'] = 'Edit Garage';
                $data['page_title'] = "Edit Garage";
                $this->load->view('commons/header', $meta);
                $this->load->view('edit', $data);
                $this->load->view('commons/footer');
            
            }
        }
        else
        {
            $garage_details = $this->garage_model->getGarageById($garage_id);
            $data['branch'] = $this->garage_model->getBranch();
            /*echo '<pre>';
            print_r($branch_details);exit;*/
            $data['id'] = $garage_id;
            $data['garage'] = $garage_details;
            $meta['page_title'] = 'Edit Garage';
            $data['page_title'] = "Edit Garage";
            $this->load->view('commons/header', $meta);
            $this->load->view('edit', $data);
            $this->load->view('commons/footer');
        }
    }
    
    public function delete($branch_id)
    {
        $id = $branch_id;
        if($this->garage_model->deletegarage($id))
        {
            $this->session->set_flashdata('success', 'Garage deleted successfully.');
            redirect("garage",'refresh');
        }
    }
}
?>