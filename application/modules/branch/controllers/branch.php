<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Branch extends CI_Controller 
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
		$this->load->model('branch_model');
		$this->load->library('Datatables');
	}
    
    function index()
    {
        if (!$this->ion_auth->logged_in())
	  	{
			redirect('auth/login');
	  	}
        $meta['page_title'] = 'Branch Details';
		$data['page_title'] = "Branch details";
		$this->load->view('commons/header',$meta);
		$this->load->view('index',$data);
		$this->load->view('commons/footer');
    }
    
    function branch_details()
    {
        $this->datatables->select('id,branch_name,po_box,postal_code,city,telephone,mobile,email,incharge')
        //->unset_column('id')
        ->from('branch')
        ->add_column("Actions", "<a href='branch/view/$1'><i class='fa fa-eye'></i></a> &nbsp; <a href='branch/edit/$1'><i class='fa fa-pencil-square-o'></i></a> &nbsp; <a href='branch/delete/$1' onclick=\"return confirm('Are you sure you want to delete?');\"><i class='fa fa-trash-o'></i></a>", "id");
		
        echo $this->datatables->generate();
    }
    
    function view($branch_id)
    {
        $id = $branch_id;
        $branch_details = $this->branch_model->getBranchById($branch_id);
        /*echo '<pre>';
        print_r($branch_details);exit;*/
        $data['id'] = $branch_id;
        $data['branch'] = $branch_details;
        $meta['page_title'] = 'View Branch';
        $data['page_title'] = "View Branch";
        $this->load->view('commons/header', $meta);
        $this->load->view('view', $data);
        $this->load->view('commons/footer');
        
    }
    
    function add()
    {
        //branch form validation
        $this->form_validation->set_rules('branch_name', 'Branch Name', 'trim|required|xss_clean');
        $this->form_validation->set_rules('po_box', 'Po Box', 'trim|xss_clean|numeric');
        $this->form_validation->set_rules('postal_code', 'Postal Code', 'trim|xss_clean|numeric');
        $this->form_validation->set_rules('city', 'City', 'trim|xss_clean');
        $this->form_validation->set_rules('telephone', 'Telephone', 'trim|xss_clean|numeric');
        $this->form_validation->set_rules('mobile', 'Mobile', 'trim|xss_clean|numeric');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean|valid_email');
        $this->form_validation->set_rules('incharge', 'Incharge Name', 'trim|xss_clean');
        
        if ($this->form_validation->run() == true)
        {
            $branchDetail = array(
                    'branch_name'	=>	$this->input->post('branch_name'),
                    'po_box'        =>  $this->input->post('po_box'),
                    'postal_code'   =>  $this->input->post('postal_code'),
                    'city'          =>  $this->input->post('city'),
                    'telephone'     =>  $this->input->post('telephone'),
                    'mobile'        =>  $this->input->post('mobile'),
                    'email'         =>  $this->input->post('email'),
                    'incharge'      =>  $this->input->post('incharge')
                );
					   /*echo '<pre>';
					   print_r($branchDetail);exit;*/
        }
        
        if ( ($this->form_validation->run() == true) && $this->branch_model->addBranch($branchDetail))
		{  
			$this->session->set_flashdata('success', 'Branch added successfully.');
			redirect("branch",'refresh');
		}
		else
		{  
			$meta['page_title'] = 'Add Branch';
            $data['page_title'] = "Add Branch";
            $this->load->view('commons/header', $meta);
            $this->load->view('add', $data);
            $this->load->view('commons/footer');
		
		}	
	}
    
    public function edit($branch_id)
    {
        $id = $branch_id;
        
        if($post = $this->input->post())
        {
            //branch form validation
            $this->form_validation->set_rules('branch_name', 'Branch Name', 'trim|required|xss_clean');
            $this->form_validation->set_rules('po_box', 'Po Box', 'trim|xss_clean|numeric');
            $this->form_validation->set_rules('postal_code', 'Postal Code', 'trim|xss_clean|numeric');
            $this->form_validation->set_rules('city', 'City', 'trim|xss_clean');
            $this->form_validation->set_rules('telephone', 'Telephone', 'trim|xss_clean|numeric');
            $this->form_validation->set_rules('mobile', 'Mobile', 'trim|xss_clean|numeric');
            $this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean|valid_email');
            $this->form_validation->set_rules('incharge', 'Incharge Name', 'trim|xss_clean');
            
            if ($this->form_validation->run() == true)
            {
                $branchDetail = array(
                        'branch_name'	=>	$this->input->post('branch_name'),
                        'po_box'        =>  $this->input->post('po_box'),
                        'postal_code'   =>  $this->input->post('postal_code'),
                        'city'          =>  $this->input->post('city'),
                        'telephone'     =>  $this->input->post('telephone'),
                        'mobile'        =>  $this->input->post('mobile'),
                        'email'         =>  $this->input->post('email'),
                        'incharge'      =>  $this->input->post('incharge')
                    );
                    /*echo '<pre>';
                    print_r($branchDetail);exit;*/
            }
            if ( ($this->form_validation->run() == true) && $this->branch_model->updateBranch($branchDetail,$id))
            {  
                $this->session->set_flashdata('success', 'Branch edited successfully.');
                redirect("branch",'refresh');
            }
            else
            {  
                /*$data['property_type_name'] = array('name' => 'property_type_name',
                    'id' => 'property_type_name',
                    'type' => 'text',
                    'value' => $this->form_validation->set_value('property_type_name'),
                );*/
                $branch_details = $this->branch_model->getBranchById($branch_id);
                /*echo '<pre>';
                print_r($branch_details);exit;*/
                $data['id'] = $branch_id;
                $data['branch'] = $branch_details;
                $meta['page_title'] = 'Edit Branch';
                $data['page_title'] = "Edit Branch";
                $this->load->view('commons/header', $meta);
                $this->load->view('edit', $data);
                $this->load->view('commons/footer');
            
            }
        }
        else
        {
            $branch_details = $this->branch_model->getBranchById($branch_id);
            /*echo '<pre>';
            print_r($branch_details);exit;*/
            $data['id'] = $branch_id;
            $data['branch'] = $branch_details;
            $meta['page_title'] = 'Edit Branch';
            $data['page_title'] = "Edit Branch";
            $this->load->view('commons/header', $meta);
            $this->load->view('edit', $data);
            $this->load->view('commons/footer');
        }
    }
    
    public function delete($branch_id)
    {
        $id = $branch_id;
        if($this->branch_model->deleteBranch($id))
        {
            $this->session->set_flashdata('success', 'Branch deleted successfully.');
            redirect("branch",'refresh');
        }
    }
}
?>