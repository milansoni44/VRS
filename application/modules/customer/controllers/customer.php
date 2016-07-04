<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Customer extends CI_Controller 
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
		$this->load->model('customer_model');
        $this->load->library('upload');
		$this->load->library('Datatables');
	}

    function index()
    {
        if (!$this->ion_auth->logged_in())
	  	{
			redirect('auth/login');
	  	}
        $meta['page_title'] = 'Customer Details';
		$data['page_title'] = "Customer details";
		$this->load->view('commons/header',$meta);
		$this->load->view('index',$data);
		$this->load->view('commons/footer');
    }
    
    function customer_details()
    {
        $this->datatables->select('customer.id,branch.branch_name as branchName,en_name,en_nationality_code,en_passport_no,en_place_issue,en_date_issue,en_date_expiry,en_national_id,reference_source_field')
        //->unset_column('customer.id')
        ->from('customer')
        ->join('branch', 'branch.id=customer.branch_id', 'INNER')
        ->add_column("Actions", "<a href='customer/view/$1'><i class='fa fa-eye'></i></a> &nbsp; <a href='customer/edit/$1'><i class='fa fa-pencil-square-o'></i></a> &nbsp; <a href='customer/delete/$1' onclick=\"return confirm('Are you sure you want to delete?');\"><i class='fa fa-trash-o'></i></a>", "customer.id");
		
        echo $this->datatables->generate();
    }
    
    function view($customer_id)
    {
        $customer_details = $this->customer_model->getCustomerByIdWithJoin($customer_id);
        // echo '<pre>';
        // print_r($customer_details);exit;
        $data['id'] = $customer_id;
        $data['customer'] = $customer_details;
        $meta['page_title'] = 'View Customer';
        $data['page_title'] = "View Customer";
        $this->load->view('commons/header', $meta);
        $this->load->view('view', $data);
        $this->load->view('commons/footer');
    }
    
    function add()
    {
        //customer form validation
        /* ==============VALIDATION FOR SELECTBOX AGENT ================ */
        $this->form_validation->set_rules('branch','Branch','required|callback_check_default');
        $this->form_validation->set_message('check_default', 'You need to select branch other than the default.');
        /* --------------*/
        $this->form_validation->set_rules('en_name', 'Cutomer Name', 'trim|required|xss_clean');
        $this->form_validation->set_rules('en_nationality_code', 'Nationality Code', 'trim|xss_clean');
        $this->form_validation->set_rules('en_passport_no', 'Passport Number', 'trim|xss_clean');
        $this->form_validation->set_rules('en_place_issue', 'Passport Place Issue', 'trim|xss_clean');
        $this->form_validation->set_rules('en_date_issue', 'Passport Date Issue', 'trim|xss_clean');
        $this->form_validation->set_rules('en_date_expiry', 'Passport Date Expiry', 'trim|xss_clean');
        $this->form_validation->set_rules('en_national_id', 'National ID', 'trim|xss_clean');
        $this->form_validation->set_rules('en_id_date_expiry', 'National ID expiry date', 'trim|xss_clean');
        $this->form_validation->set_rules('en_local_address', 'Local Address', 'trim|xss_clean');
        $this->form_validation->set_rules('en_company_name', 'Company Name', 'trim|xss_clean');
        $this->form_validation->set_rules('en_mailing_address', 'Mailing Address', 'trim|xss_clean');
        
        /* ================ ARABIC FIELDS ============================================ */
        $this->form_validation->set_rules('ar_name', 'Cutomer Name', 'trim|xss_clean');
        $this->form_validation->set_rules('ar_nationality_code', 'Nationality Code', 'trim|xss_clean');
        $this->form_validation->set_rules('ar_passport_no', 'Passport Number', 'trim|xss_clean');
        $this->form_validation->set_rules('ar_place_issue', 'Passport Place Issue', 'trim|xss_clean');
        $this->form_validation->set_rules('ar_date_issue', 'Passport Date Issue', 'trim|xss_clean');
        $this->form_validation->set_rules('ar_date_expiry', 'Passport Date Expiry', 'trim|xss_clean');
        $this->form_validation->set_rules('ar_national_id', 'National ID', 'trim|xss_clean');
        $this->form_validation->set_rules('ar_id_date_expiry', 'National ID expiry date', 'trim|xss_clean');
        $this->form_validation->set_rules('ar_local_address', 'Local Address', 'trim|xss_clean');
        $this->form_validation->set_rules('ar_company_name', 'Company Name', 'trim|xss_clean');
        $this->form_validation->set_rules('ar_mailing_address', 'Mailing Address', 'trim|xss_clean');    
        
        $this->form_validation->set_rules('telephone', 'Telephone', 'trim|xss_clean');
        $this->form_validation->set_rules('mobile_no', 'Mobile Number', 'trim|xss_clean');
        $this->form_validation->set_rules('email', 'Email', 'trim|xss_clean|valid_email');
        $this->form_validation->set_rules('reference_person_name', 'Reference Person Name', 'trim|xss_clean');
        $this->form_validation->set_rules('reference_person_mobile', 'Reference Person mobile', 'trim|xss_clean');
        $this->form_validation->set_rules('reference_source_field', 'Reference Source Field', 'trim|xss_clean');
        
        if ($this->form_validation->run() == true)
        {
            $count = $this->db->from('customer');
            $query = $this->db->get();
            $rowcount = $query->num_rows();
            if($rowcount == 0)
            {
                $rowcount = $rowcount + 1;
            }
            
            if($_FILES['passport_img']['size'] > 0)
			{
                $ext1 = end(explode(".", $_FILES['passport_img']['name']));
                $file_name = "passport-".$rowcount.".".$ext1;
                $image_path = realpath(APPPATH."../assets/uploads/passports/");
                $config1 = array(
				'upload_path' => $image_path,
				'allowed_types' => "gif|jpg|png|jpeg|pdf|doc|docx|ppt|pptx|xls|xlsx",
				'overwrite' => TRUE,
				'file_name' => $file_name
				);
                // echo '<pre>';
                // print_r($config1);
                $this->upload->initialize($config1);
                if($this->upload->do_upload('passport_img'))
				{
					$data1 = array('passport_img' => $this->upload->data());
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
                $data1['passport_img']['file_name'] = "";
            }
            
            if($_FILES['national_id_img']['size'] > 0)
			{
                $ext1 = end(explode(".", $_FILES['national_id_img']['name']));
                $file_name = "national_id-".$rowcount.".".$ext1;
                $image_path = realpath(APPPATH."../assets/uploads/national_ids/");
                $config2 = array(
				'upload_path' => $image_path,
				'allowed_types' => "gif|jpg|png|jpeg|pdf|doc|docx|ppt|pptx|xls|xlsx",
				'overwrite' => TRUE,
				// 'max_size' => "2048000", // Can be set to particular file size , here it is 2 MB(2048 Kb)
				// 'max_height' => "1440",
				// 'max_width' => "900",
                'file_name' => $file_name
				);
                // echo '<pre>';
                // print_r($config2);
                $this->upload->initialize($config2);
                if($this->upload->do_upload('national_id_img'))
				{
					$data2 = array('national_id_img' => $this->upload->data());
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
                $data2['national_id_img']['file_name'] = "";
            }
            
            if($_FILES['driving_licence_img']['size'] > 0)
			{
                $ext1 = end(explode(".", $_FILES['driving_licence_img']['name']));
                $file_name = "driving_licence-".$rowcount.".".$ext1;
                $image_path = realpath(APPPATH."../assets/uploads/driving_licences/");
                $config3 = array(
				'upload_path' => $image_path,
				'allowed_types' => "gif|jpg|png|jpeg|pdf|doc|docx|ppt|pptx|xls|xlsx",
				'overwrite' => TRUE,
				// 'max_size' => "2048000", // Can be set to particular file size , here it is 2 MB(2048 Kb)
				// 'max_height' => "1440",
				// 'max_width' => "900",
                'file_name' => $file_name
				);
                // echo '<pre>';
                // print_r($config3);
                $this->upload->initialize($config3);
                if($this->upload->do_upload('driving_licence_img'))
				{
					$data3 = array('driving_licence_img' => $this->upload->data());
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
                $data3['driving_licence_img']['file_name'] = "";
            }
            
            if($_FILES['customer_img']['size'] > 0)
			{
                $ext1 = end(explode(".", $_FILES['customer_img']['name']));
                $file_name = "customer-".$rowcount.".".$ext1;
                $image_path = realpath(APPPATH."../assets/uploads/customers/");
                $config4 = array(
				'upload_path' => $image_path,
				'allowed_types' => "gif|jpg|png|jpeg|pdf|doc|docx|ppt|pptx|xls|xlsx",
				'overwrite' => TRUE,
				// 'max_size' => "2048000", // Can be set to particular file size , here it is 2 MB(2048 Kb)
				// 'max_height' => "1440",
				// 'max_width' => "900",
                'file_name' => $file_name
				);
                // echo '<pre>';
                // print_r($config4);
                $this->upload->initialize($config4);
                if($this->upload->do_upload('customer_img'))
				{
					$data4 = array('customer_img' => $this->upload->data());
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
                $data4['customer_img']['file_name'] = "";
            }
            
            $customerDetail = array(
                    'branch_id'	        =>	$this->input->post('branch'),
                    'en_name'       =>  $this->input->post('en_name'),
                    'ar_name'       =>  $this->input->post('ar_name'),
                    'en_nationality_code'       =>  $this->input->post('en_nationality_code'),
                    'ar_nationality_code'       =>  $this->input->post('ar_nationality_code'),
                    'en_passport_no'          =>  $this->input->post('en_passport_no'),
                    'ar_passport_no'          =>  $this->input->post('ar_passport_no'),
                    'en_place_issue'         =>  $this->input->post('en_place_issue'),
                    'ar_place_issue'         =>  $this->input->post('ar_place_issue'),
                    'en_date_issue'         =>  $this->input->post('en_date_issue'),
                    'ar_date_issue'         =>  $this->input->post('ar_date_issue'),
                    'en_date_expiry'         =>  $this->input->post('en_date_expiry'),
                    'ar_date_expiry'         =>  $this->input->post('ar_date_expiry'),
                    'en_national_id'             =>  $this->input->post('en_national_id'),
                    'ar_national_id'             =>  $this->input->post('ar_national_id'),
                    'en_id_date_expiry'    =>  $this->input->post('en_id_date_expiry'),
                    'ar_id_date_expiry'    =>  $this->input->post('ar_id_date_expiry'),
                    'en_local_address'    =>  $this->input->post('en_local_address'),
                    'ar_local_address'    =>  $this->input->post('ar_local_address'),
                    'en_company_name'    =>  $this->input->post('en_company_name'),
                    'ar_company_name'    =>  $this->input->post('ar_company_name'),
                    'en_mailing_address'    =>  $this->input->post('en_mailing_address'),
                    'ar_mailing_address'    =>  $this->input->post('ar_mailing_address'),
                    'passport_img'          =>  $data1['passport_img']['file_name'],
                    'national_id_img'          =>  $data2['national_id_img']['file_name'],
                    'driving_licence_img'          =>  $data3['driving_licence_img']['file_name'],
                    'customer_img'          =>  $data4['customer_img']['file_name'],
                    'telephone'    =>  $this->input->post('telephone'),
                    'mobile_no'    =>  $this->input->post('mobile_no'),
                    'email'    =>  $this->input->post('email'),
                    'reference_person_name'    =>  $this->input->post('reference_person_name'),
                    'reference_person_mobile'    =>  $this->input->post('reference_person_mobile'),
                    'reference_source_field'    =>  $this->input->post('reference_source_field')
                );
                //echo '<pre>';
                //print_r($customerDetail);exit;
        }
        
        if ( ($this->form_validation->run() == true) && $this->customer_model->addCustomer($customerDetail))
		{  
			$this->session->set_flashdata('success', 'Customer added successfully.');
			redirect("customer",'refresh');
		}
		else
		{  
            $data['branch'] = $this->customer_model->getBranch();
			$meta['page_title'] = 'Add Customer';
            $data['page_title'] = "Add Customer";
            $this->load->view('commons/header', $meta);
            $this->load->view('add', $data);
            $this->load->view('commons/footer');
		
		}	
	}
    
    function edit($customer_id)
    {
        $id = $customer_id;
        
        if($post = $this->input->post())
        {
            //customer form validation
            /* ==============VALIDATION FOR SELECTBOX AGENT ================ */
            $this->form_validation->set_rules('branch','Branch','required|callback_check_default');
            $this->form_validation->set_message('check_default', 'You need to select branch other than the default.');
            /* --------------*/
            $this->form_validation->set_rules('en_name', 'Cutomer Name', 'trim|required|xss_clean');
            $this->form_validation->set_rules('en_nationality_code', 'Nationality Code', 'trim|xss_clean');
            $this->form_validation->set_rules('en_passport_no', 'Passport Number', 'trim|xss_clean');
            $this->form_validation->set_rules('en_place_issue', 'Passport Place Issue', 'trim|xss_clean');
            $this->form_validation->set_rules('en_date_issue', 'Passport Date Issue', 'trim|xss_clean');
            $this->form_validation->set_rules('en_date_expiry', 'Passport Date Expiry', 'trim|xss_clean');
            $this->form_validation->set_rules('en_national_id', 'National ID', 'trim|xss_clean');
            $this->form_validation->set_rules('en_id_date_expiry', 'National ID expiry date', 'trim|xss_clean');
            $this->form_validation->set_rules('en_local_address', 'Local Address', 'trim|xss_clean');
            $this->form_validation->set_rules('en_company_name', 'Company Name', 'trim|xss_clean');
            $this->form_validation->set_rules('en_mailing_address', 'Mailing Address', 'trim|xss_clean');
            
            /* ================ ARABIC FIELDS ============================================ */
            $this->form_validation->set_rules('ar_name', 'Cutomer Name', 'trim|xss_clean');
            $this->form_validation->set_rules('ar_nationality_code', 'Nationality Code', 'trim|xss_clean');
            $this->form_validation->set_rules('ar_passport_no', 'Passport Number', 'trim|xss_clean');
            $this->form_validation->set_rules('ar_place_issue', 'Passport Place Issue', 'trim|xss_clean');
            $this->form_validation->set_rules('ar_date_issue', 'Passport Date Issue', 'trim|xss_clean');
            $this->form_validation->set_rules('ar_date_expiry', 'Passport Date Expiry', 'trim|xss_clean');
            $this->form_validation->set_rules('ar_national_id', 'National ID', 'trim|xss_clean');
            $this->form_validation->set_rules('ar_id_date_expiry', 'National ID expiry date', 'trim|xss_clean');
            $this->form_validation->set_rules('ar_local_address', 'Local Address', 'trim|xss_clean');
            $this->form_validation->set_rules('ar_company_name', 'Company Name', 'trim|xss_clean');
            $this->form_validation->set_rules('ar_mailing_address', 'Mailing Address', 'trim|xss_clean');    
            
            $this->form_validation->set_rules('telephone', 'Telephone', 'trim|xss_clean');
            $this->form_validation->set_rules('mobile_no', 'Mobile Number', 'trim|xss_clean');
            $this->form_validation->set_rules('email', 'Email', 'trim|xss_clean|valid_email');
            $this->form_validation->set_rules('reference_person_name', 'Reference Person Name', 'trim|xss_clean');
            $this->form_validation->set_rules('reference_person_mobile', 'Reference Person mobile', 'trim|xss_clean');
            $this->form_validation->set_rules('reference_source_field', 'Reference Source Field', 'trim|xss_clean');
            
            if ($this->form_validation->run() == true)
            {
                if($_FILES['passport_img']['size'] > 0)
                {
                    $ext1 = end(explode(".", $_FILES['passport_img']['name']));
                    $file_name = "customer_id-".$customer_id.".".$ext1;
                    $image_path = realpath(APPPATH."../assets/uploads/passports/");
                    $config1 = array(
                    'upload_path' => $image_path,
                    'allowed_types' => "gif|jpg|png|jpeg|pdf|doc|docx|ppt|pptx|xls|xlsx",
                    'overwrite' => TRUE,
                    // 'max_size' => "2048000", // Can be set to particular file size , here it is 2 MB(2048 Kb)
                    // 'max_height' => "1440",
                    // 'max_width' => "900",
                    'file_name' => $file_name
                    );
                    // echo '<pre>';
                    // print_r($config1);
                    $this->upload->initialize($config1);
                    if($this->upload->do_upload('passport_img'))
                    {
                        $data1 = array('passport_img' => $this->upload->data());
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
                    $data1['passport_img']['file_name'] = $this->input->post('passport_edit');
                }
                
                if($_FILES['national_id_img']['size'] > 0)
                {
                    $ext1 = end(explode(".", $_FILES['national_id_img']['name']));
                    $file_name = "customer_id-".$customer_id.".".$ext1;
                    $image_path = realpath(APPPATH."../assets/uploads/national_ids/");
                    $config2 = array(
                    'upload_path' => $image_path,
                    'allowed_types' => "gif|jpg|png|jpeg|pdf|doc|docx|ppt|pptx|xls|xlsx",
                    'overwrite' => TRUE,
                    // 'max_size' => "2048000", // Can be set to particular file size , here it is 2 MB(2048 Kb)
                    // 'max_height' => "1440",
                    // 'max_width' => "900",
                    'file_name' => $file_name
                    );
                    // echo '<pre>';
                    // print_r($config2);
                    $this->upload->initialize($config2);
                    if($this->upload->do_upload('national_id_img'))
                    {
                        $data2 = array('national_id_img' => $this->upload->data());
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
                    $data2['national_id_img']['file_name'] = $this->input->post('national_id_edit');
                }
                
                if($_FILES['driving_licence_img']['size'] > 0)
                {
                    $ext1 = end(explode(".", $_FILES['driving_licence_img']['name']));
                    $file_name = "customer_id-".$customer_id.".".$ext1;
                    $image_path = realpath(APPPATH."../assets/uploads/driving_licences/");
                    $config3 = array(
                    'upload_path' => $image_path,
                    'allowed_types' => "gif|jpg|png|jpeg|pdf|doc|docx|ppt|pptx|xls|xlsx",
                    'overwrite' => TRUE,
                    // 'max_size' => "2048000", // Can be set to particular file size , here it is 2 MB(2048 Kb)
                    // 'max_height' => "1440",
                    // 'max_width' => "900",
                    'file_name' => $file_name
                    );
                    // echo '<pre>';
                    // print_r($config3);
                    $this->upload->initialize($config3);
                    if($this->upload->do_upload('driving_licence_img'))
                    {
                        $data3 = array('driving_licence_img' => $this->upload->data());
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
                    $data3['driving_licence_img']['file_name'] = $this->input->post('driving_licence_edit');
                }
                
                if($_FILES['customer_img']['size'] > 0)
                {
                    $ext1 = end(explode(".", $_FILES['customer_img']['name']));
                    $file_name = "customer_id-".$customer_id.".".$ext1;
                    $image_path = realpath(APPPATH."../assets/uploads/customers/");
                    $config4 = array(
                    'upload_path' => $image_path,
                    'allowed_types' => "gif|jpg|png|jpeg|pdf|doc|docx|ppt|pptx|xls|xlsx",
                    'overwrite' => TRUE,
                    // 'max_size' => "2048000", // Can be set to particular file size , here it is 2 MB(2048 Kb)
                    // 'max_height' => "1440",
                    // 'max_width' => "900",
                    'file_name' => $file_name
                    );
                    // echo '<pre>';
                    // print_r($config4);
                    $this->upload->initialize($config4);
                    if($this->upload->do_upload('customer_img'))
                    {
                        $data4 = array('customer_img' => $this->upload->data());
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
                    $data4['customer_img']['file_name'] = $this->input->post('customer_edit');
                }
                $customerDetail = array(
                    'branch_id'	        =>	$this->input->post('branch'),
                    'en_name'       =>  $this->input->post('en_name'),
                    'ar_name'       =>  $this->input->post('ar_name'),
                    'en_nationality_code'       =>  $this->input->post('en_nationality_code'),
                    'ar_nationality_code'       =>  $this->input->post('ar_nationality_code'),
                    'en_passport_no'          =>  $this->input->post('en_passport_no'),
                    'ar_passport_no'          =>  $this->input->post('ar_passport_no'),
                    'en_place_issue'         =>  $this->input->post('en_place_issue'),
                    'ar_place_issue'         =>  $this->input->post('ar_place_issue'),
                    'en_date_issue'         =>  $this->input->post('en_date_issue'),
                    'ar_date_issue'         =>  $this->input->post('ar_date_issue'),
                    'en_date_expiry'         =>  $this->input->post('en_date_expiry'),
                    'ar_date_expiry'         =>  $this->input->post('ar_date_expiry'),
                    'en_national_id'             =>  $this->input->post('en_national_id'),
                    'ar_national_id'             =>  $this->input->post('ar_national_id'),
                    'en_id_date_expiry'    =>  $this->input->post('en_id_date_expiry'),
                    'ar_id_date_expiry'    =>  $this->input->post('ar_id_date_expiry'),
                    'en_local_address'    =>  $this->input->post('en_local_address'),
                    'ar_local_address'    =>  $this->input->post('ar_local_address'),
                    'en_company_name'    =>  $this->input->post('en_company_name'),
                    'ar_company_name'    =>  $this->input->post('ar_company_name'),
                    'en_mailing_address'    =>  $this->input->post('en_mailing_address'),
                    'ar_mailing_address'    =>  $this->input->post('ar_mailing_address'),
                    'passport_img'          =>  $data1['passport_img']['file_name'],
                    'national_id_img'          =>  $data2['national_id_img']['file_name'],
                    'driving_licence_img'          =>  $data3['driving_licence_img']['file_name'],
                    'customer_img'          =>  $data4['customer_img']['file_name'],
                    'telephone'    =>  $this->input->post('telephone'),
                    'mobile_no'    =>  $this->input->post('mobile_no'),
                    'email'    =>  $this->input->post('email'),
                    'reference_person_name'    =>  $this->input->post('reference_person_name'),
                    'reference_person_mobile'    =>  $this->input->post('reference_person_mobile'),
                    'reference_source_field'    =>  $this->input->post('reference_source_field')
                );
                    // echo '<pre>';
                    // print_r($customerDetail);exit;
            }
            
            if ( ($this->form_validation->run() == true) && $this->customer_model->updateCustomer($customerDetail,$customer_id))
            {  
                $this->session->set_flashdata('success', 'Customer edited successfully.');
                redirect("customer",'refresh');
            }
            else
            {  
                $customer_details = $this->customer_model->getCustomerById($customer_id);
                // echo '<pre>';
                // print_r($customer_details);exit;
                $data['id'] = $customer_id;
                $data['customer'] = $customer_details;
                $data['branch'] = $this->customer_model->getBranch();
                $meta['page_title'] = 'Edit Customer';
                $data['page_title'] = "Edit Customer";
                $this->load->view('commons/header', $meta);
                $this->load->view('edit', $data);
                $this->load->view('commons/footer');
            
            }
        }
        else
        {
            $customer_details = $this->customer_model->getCustomerById($customer_id);
            // echo '<pre>';
            // print_r($customer_details);exit;
            $data['customer'] = $customer_details;
            $data['id'] = $customer_id;
            $data['branch'] = $this->customer_model->getBranch();
            $meta['page_title'] = 'Edit Customer';
            $data['page_title'] = "Edit Customer";
            $this->load->view('commons/header', $meta);
            $this->load->view('edit', $data);
            $this->load->view('commons/footer');
        }
        	
	}

    /* =====================VALIDATION FOR Branch ======================== */
    function check_default($post_string)
    {
        return $post_string == '0' ? FALSE : TRUE;
    }
    
    public function delete($customer_id)
    {
        $id = $customer_id;
        if($this->customer_model->deleteCustomer($id))
        {
            $this->session->set_flashdata('success', 'Customer deleted successfully.');
            redirect("customer",'refresh');
        }
    }
}
?>