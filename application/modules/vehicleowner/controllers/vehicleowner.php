<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Vehicleowner extends CI_Controller 
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
		$this->load->model('vehicleowner_model');
		$this->load->library('Datatables');
	}
    
    function index()
    {
        if (!$this->ion_auth->logged_in())
	  	{
			redirect('auth/login');
	  	}
        $meta['page_title'] = 'Vehicle Owner Details';
		$data['page_title'] = "Vehicle Owner details";
		$this->load->view('commons/header',$meta);
		$this->load->view('index',$data);
		$this->load->view('commons/footer');
    }
    
    function vehicle_owner_details()
    {
        $this->datatables->select('id,company_abbrev,company_name,name,mobile_no,email')
        //->unset_column('id')
        ->from('vehicle_owner')
        ->add_column("Actions", "<a href='vehicleowner/view/$1'><i class='fa fa-eye'></i></a> &nbsp; <a href='vehicleowner/edit/$1'><i class='fa fa-pencil-square-o'></i></a> &nbsp; <a href='vehicleowner/delete/$1' onclick=\"return confirm('Are you sure you want to delete?');\"><i class='fa fa-trash-o'></i></a>", "id");
		
        echo $this->datatables->generate();
    }
    
    function view($owner_id)
    {
        $id = $owner_id;
        $owner_details = $this->vehicleowner_model->getOwnerById($owner_id);
        /*echo '<pre>';
        print_r($owner_details);exit;*/
        $data['id'] = $owner_id;
        $data['owner'] = $owner_details;
        $meta['page_title'] = 'View Vehicle Owner';
        $data['page_title'] = "View Vehicle Owner";
        $this->load->view('commons/header', $meta);
        $this->load->view('view', $data);
        $this->load->view('commons/footer');
    }
    
    function add()
    {
        //vehicle owner form validation
        $this->form_validation->set_rules('company_abbrev', 'Company Abbreviation', 'trim|required|xss_clean');
        $this->form_validation->set_rules('company_name', 'Company Name', 'trim|required|xss_clean');
        $this->form_validation->set_rules('name', 'Owner Name', 'trim|required|xss_clean');
        $this->form_validation->set_rules('mobile_no', 'Mobile No', 'trim|xss_clean|numeric');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean|valid_email');
        
        if ($this->form_validation->run() == true)
        {
            $vehicleOwnerDetail = array(
                    'company_abbrev'	=>	$this->input->post('company_abbrev'),
                    'company_name'      =>  $this->input->post('company_name'),
                    'name'              =>  $this->input->post('name'),
                    'mobile_no'         =>  $this->input->post('mobile_no'),
                    'email'             =>  $this->input->post('email'),
                );
                /*echo '<pre>';
                print_r($vehicleOwnerDetail);exit;*/
        }
        
        if ( ($this->form_validation->run() == true) && $this->vehicleowner_model->addVehicleOwner($vehicleOwnerDetail))
		{  
			$this->session->set_flashdata('success', 'Vehicle Owner updated successfully.');
			redirect("vehicleowner",'refresh');
		}
		else
		{  
			/*$data['property_type_name'] = array('name' => 'property_type_name',
				'id' => 'property_type_name',
				'type' => 'text',
				'value' => $this->form_validation->set_value('property_type_name'),
			);*/
			
		    $meta['page_title'] = 'Add Vehicle Owner';
            $data['page_title'] = "Add Vehicle Owner";
            $this->load->view('commons/header', $meta);
            $this->load->view('add', $data);
            $this->load->view('commons/footer');
		
		}	
	}
    
    public function edit($owner_id)
    {
        $id = $owner_id;
        
        if($post = $this->input->post())
        {
            //vehicle owner form validation
            $this->form_validation->set_rules('company_abbrev', 'Company Abbreviation', 'trim|required|xss_clean');
            $this->form_validation->set_rules('company_name', 'Company Name', 'trim|required|xss_clean');
            $this->form_validation->set_rules('name', 'Owner Name', 'trim|required|xss_clean');
            $this->form_validation->set_rules('mobile_no', 'Mobile No', 'trim|xss_clean|numeric');
            $this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean|valid_email');
            
            if ($this->form_validation->run() == true)
            {
                $vehicleOwnerDetail = array(
                        'company_abbrev'	=>	$this->input->post('company_abbrev'),
                        'company_name'      =>  $this->input->post('company_name'),
                        'name'              =>  $this->input->post('name'),
                        'mobile_no'         =>  $this->input->post('mobile_no'),
                        'email'             =>  $this->input->post('email'),
                    );
                    /*echo '<pre>';
                    print_r($vehicleOwnerDetail);exit;*/
            }
            
            if ( ($this->form_validation->run() == true) && $this->vehicleowner_model->updateVehicleOwner($vehicleOwnerDetail,$id))
            {  
                $this->session->set_flashdata('success', 'Vehicle Owner added successfully.');
                redirect("vehicleowner",'refresh');
            }
            else
            {  
                /*$data['property_type_name'] = array('name' => 'property_type_name',
                    'id' => 'property_type_name',
                    'type' => 'text',
                    'value' => $this->form_validation->set_value('property_type_name'),
                );*/
                $vehicleowner_details = $this->vehicleowner_model->getOwnerById($owner_id);
                /*echo '<pre>';
                print_r($branch_details);exit;*/
                $data['id'] = $owner_id;
                $data['branch'] = $vehicleowner_details;
                $meta['page_title'] = 'Edit Vehicle Owner';
                $data['page_title'] = "Edit Vehicle Owner";
                $this->load->view('commons/header', $meta);
                $this->load->view('edit', $data);
                $this->load->view('commons/footer');
            
            }
        }
        else
        {
            $vehicleowner_details = $this->vehicleowner_model->getOwnerById($owner_id);
            /*echo '<pre>';
            print_r($vehicleowner_details);exit;*/
            $data['id'] = $owner_id;
            $data['owner'] = $vehicleowner_details;
            $meta['page_title'] = 'Edit Vehicle Owner';
            $data['page_title'] = "Edit Vehicle Owner";
            $this->load->view('commons/header', $meta);
            $this->load->view('edit', $data);
            $this->load->view('commons/footer');
        }
    }
    
    public function delete($owner_id)
    {
        $id = $owner_id;
        if($this->vehicleowner_model->deleteOwner($id))
        {
            $this->session->set_flashdata('success', 'Vehicle owner deleted successfully.');
            redirect("vehicleowner",'refresh');
        }
    }
}
?>