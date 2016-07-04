<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Pdc extends CI_Controller 
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
		$this->load->model('pdc_model');
		$this->load->library('Datatables');
	}
    
    function index()
    {
        if (!$this->ion_auth->logged_in())
	  	{
			redirect('auth/login');
	  	}
        $meta['page_title'] = 'PDC Details';
		$data['page_title'] = "PDC details";
		$this->load->view('commons/header',$meta);
		$this->load->view('index',$data);
		$this->load->view('commons/footer');
    }
    
    function pdc_details()
    {
        $this->datatables->select('pdc.id,branch.branch_name as branchName,date_issue,date_cheque,cheque_no,bank_ref,party_favouring,reason,amount,bank_account_no,vehicle_no')
        //->unset_column('pdc.id')
        ->from('pdc')
        ->join('branch','branch.id = pdc.branch_id', 'INNER')
        ->add_column("Actions", "<a href='pdc/view/$1'><i class='fa fa-eye'></i></a> &nbsp; <a href='pdc/edit/$1'><i class='fa fa-pencil-square-o'></i></a> &nbsp; <a href='pdc/delete/$1' onclick=\"return confirm('Are you sure you want to delete?');\"><i class='fa fa-trash-o'></i></a>", "pdc.id");
		
        echo $this->datatables->generate();
    }
    
    function view($pdc_id)
    {
        $id = $pdc_id;
        $pdc_details = $this->pdc_model->getPdcByIdwithBranch($pdc_id);
        $data['id'] = $pdc_id;
        $data['pdc'] = $pdc_details;
        $meta['page_title'] = 'View PDC';
        $data['page_title'] = "View PDC";
        $this->load->view('commons/header', $meta);
        $this->load->view('view', $data);
        $this->load->view('commons/footer');
        
    }
    
    function add()
    {
        //pdc form validation
        /* ==============VALIDATION FOR SELECTBOX AGENT ================ */
        $this->form_validation->set_rules('branch','Branch','required|callback_check_default');
        $this->form_validation->set_message('check_default', 'You need to select branch other than the default.');
        /* --------------*/
        $this->form_validation->set_rules('date_issue', 'Date of Issue', 'trim|required|xss_clean');
        $this->form_validation->set_rules('date_cheque', 'Date in Cheque', 'trim|required|xss_clean');
        $this->form_validation->set_rules('cheque_no', 'Cheque Number', 'trim|required|xss_clean|numeric');
        $this->form_validation->set_rules('bank_ref', 'Bank Reference', 'trim|xss_clean');
        $this->form_validation->set_rules('party_favouring', 'Party Favouring', 'trim|xss_clean');
        $this->form_validation->set_rules('reason', 'Reason', 'trim|xss_clean');
        $this->form_validation->set_rules('amount', 'Amount', 'trim|required|xss_clean');
        $this->form_validation->set_rules('bank_account_no', 'Bank Account Number', 'trim|xss_clean|required|numeric');
        $this->form_validation->set_rules('vehicle_no', 'Vehicle Number', 'trim|xss_clean|required');
        $this->form_validation->set_rules('payment_from_date', 'Payment From date', 'trim|xss_clean');
        $this->form_validation->set_rules('payment_to_date', 'Payment To date', 'trim|xss_clean');
        
        if ($this->form_validation->run() == true)
        {
            $pdcDetail = array(
                    'branch_id'	        =>	$this->input->post('branch'),
                    'date_issue'	    =>	$this->input->post('date_issue'),
                    'date_cheque'       =>  $this->input->post('date_cheque'),
                    'cheque_no'         =>  $this->input->post('cheque_no'),
                    'bank_ref'          =>  $this->input->post('bank_ref'),
                    'party_favouring'   =>  $this->input->post('party_favouring'),
                    'reason'            =>  $this->input->post('reason'),
                    'amount'            =>  $this->input->post('amount'),
                    'bank_account_no'   =>  $this->input->post('bank_account_no'),
                    'vehicle_no'        =>  $this->input->post('vehicle_no'),
                    'payment_from_date' =>  $this->input->post('payment_from_date'),
                    'payment_to_date'   =>  $this->input->post('payment_to_date')
                );
					   /*echo '<pre>';
					   print_r($pdcDetail);exit;*/
        }
        
        if ( ($this->form_validation->run() == true) && $this->pdc_model->addpdc($pdcDetail))
		{  
			$this->session->set_flashdata('success', 'PDC added successfully.');
			redirect("pdc",'refresh');
		}
		else
		{  
			/*$data['property_type_name'] = array('name' => 'property_type_name',
				'id' => 'property_type_name',
				'type' => 'text',
				'value' => $this->form_validation->set_value('property_type_name'),
			);*/
			$data['branch'] = $this->pdc_model->getBranch();
            $meta['page_title'] = 'Add PDC';
            $data['page_title'] = "Add PDC";
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
    
    public function edit($pdc_id)
    {
        $id = $pdc_id;
        
        if($post = $this->input->post())
        {
            //pdc form validation
            /* ==============VALIDATION FOR SELECTBOX AGENT ================ */
            $this->form_validation->set_rules('branch','Branch','required|callback_check_default');
            $this->form_validation->set_message('check_default', 'You need to select branch other than the default.');
            /* --------------*/
            
            $this->form_validation->set_rules('date_issue', 'Date od Issue', 'trim|required|xss_clean');
            $this->form_validation->set_rules('date_cheque', 'Date in Cheque', 'trim|required|xss_clean');
            $this->form_validation->set_rules('cheque_no', 'Cheque Number', 'trim|required|xss_clean|numeric');
            $this->form_validation->set_rules('bank_ref', 'Bank Reference', 'trim|xss_clean');
            $this->form_validation->set_rules('party_favouring', 'Party Favouring', 'trim|xss_clean');
            $this->form_validation->set_rules('reason', 'Reason', 'trim|xss_clean');
            $this->form_validation->set_rules('amount', 'Amount', 'trim|required|xss_clean');
            $this->form_validation->set_rules('bank_account_no', 'Bank Account Number', 'trim|xss_clean|required|numeric');
            $this->form_validation->set_rules('vehicle_no', 'Vehicle Number', 'trim|xss_clean|required');
            $this->form_validation->set_rules('payment_from_date', 'Payment From date', 'trim|xss_clean');
            $this->form_validation->set_rules('payment_to_date', 'Payment To date', 'trim|xss_clean');
            
            if ($this->form_validation->run() == true)
            {
                $pdcDetail = array(
                    'branch_id'	        =>	$this->input->post('branch'),
                    'date_issue'	    =>	$this->input->post('date_issue'),
                    'date_cheque'       =>  $this->input->post('date_cheque'),
                    'cheque_no'         =>  $this->input->post('cheque_no'),
                    'bank_ref'          =>  $this->input->post('bank_ref'),
                    'party_favouring'   =>  $this->input->post('party_favouring'),
                    'reason'            =>  $this->input->post('reason'),
                    'amount'            =>  $this->input->post('amount'),
                    'bank_account_no'   =>  $this->input->post('bank_account_no'),
                    'vehicle_no'        =>  $this->input->post('vehicle_no'),
                    'payment_from_date' =>  $this->input->post('payment_from_date'),
                    'payment_to_date'   =>  $this->input->post('payment_to_date')
                );
                // echo '<pre>';
                // print_r($pdcDetail);exit;
            }
            if ( ($this->form_validation->run() == true) && $this->pdc_model->updatePdc($pdcDetail,$id))
            {  
                $this->session->set_flashdata('success', 'PDC edited successfully.');
                redirect("pdc",'refresh');
            }
            else
            {  
                /*$data['property_type_name'] = array('name' => 'property_type_name',
                    'id' => 'property_type_name',
                    'type' => 'text',
                    'value' => $this->form_validation->set_value('property_type_name'),
                );*/
                $pdc_details = $this->pdc_model->getPdcById($pdc_id);
                $data['branch'] = $this->pdc_model->getBranch();
                /*echo '<pre>';
                print_r($pdc_details);exit;*/
                $data['id'] = $pdc_id;
                $data['pdc'] = $pdc_details;
                $meta['page_title'] = 'Edit PDC';
                $data['page_title'] = "Edit PDC";
                $this->load->view('commons/header', $meta);
                $this->load->view('edit', $data);
                $this->load->view('commons/footer');
            
            }
        }
        else
        {
            $pdc_details = $this->pdc_model->getPdcById($pdc_id);
            $data['branch'] = $this->pdc_model->getBranch();
            /*echo '<pre>';
            print_r($pdc_details);exit;*/
            $data['id'] = $pdc_id;
            $data['pdc'] = $pdc_details;
            $meta['page_title'] = 'Edit PDC';
            $data['page_title'] = "Edit PDC";
            $this->load->view('commons/header', $meta);
            $this->load->view('edit', $data);
            $this->load->view('commons/footer');
        }
    }
    
    public function delete($pdc_id)
    {
        $id = $pdc_id;
        if($this->pdc_model->deletePdc($id))
        {
            $this->session->set_flashdata('success', 'PDC deleted successfully.');
            redirect("pdc",'refresh');
        }
    }
}
?>