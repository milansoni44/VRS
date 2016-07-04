<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Payment extends CI_Controller 
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
		$this->load->model('payment_model');
		$this->load->library('Datatables');
	}
    
    function index()
    {
        if (!$this->ion_auth->logged_in())
	  	{
			redirect('auth/login');
	  	}
        $meta['page_title'] = 'Payment Details';
		$data['page_title'] = "Payment details";
		$this->load->view('commons/header',$meta);
		$this->load->view('index',$data);
		$this->load->view('commons/footer');
    }
    
    function payment_non_rental()
    {
        if (!$this->ion_auth->logged_in())
	  	{
			redirect('auth/login');
	  	}
        $meta['page_title'] = 'Payment Non Rental Details';
		$data['page_title'] = "Payment Non Rental Details";
		$this->load->view('commons/header',$meta);
		$this->load->view('payment_non_rental',$data);
		$this->load->view('commons/footer');
    }
    
    function payment_details()
    {
        $this->datatables->select('payment_view.payment_voucher_no,branch.branch_name as branchName,payment_voucher_date,payment_ledger,invoice_no,vehicle.vehicle_reg_no,vehicle.brand,payment_amount,description,mode_of_payment,status')
        ->from('payment_view')
        ->join('branch','branch.id = payment_view.branch_id', 'INNER')
        ->join('rental_pickup','rental_pickup.rental_id = payment_view.rental_id', 'INNER')
        ->join('vehicle','vehicle.id = rental_pickup.vehicle_id', 'INNER')
        ->where('status','A')
        ->add_column("Actions", "<a href='payment/view/$1'><i class='fa fa-eye'></i></a> &nbsp; <a href='payment/print_payment/$1'>print</a> &nbsp; <a href='payment/delete/$1' onclick=\"return confirm('Are you sure you want to delete?');\"><i class='fa fa-trash-o'></i></a>", "payment_view.payment_voucher_no");
		
        echo $this->datatables->generate();
    }
    
    function payment_details_non_rental()
    {
        $this->datatables->select('payment_view.payment_voucher_no,branch.branch_name as branchName,vehicle_id,payment_voucher_date,payment_ledger,payment_amount,description,mode_of_payment,status')
        ->from('payment_view')
        ->join('branch','branch.id = payment_view.branch_id', 'INNER')
        //->join('rental_pickup','rental_pickup.rental_id = payment_view.rental_id', 'INNER')
        //->join('vehicle','vehicle.id = payment_view.vehicle_id', 'INNER')
        ->where('status','A')
        ->where('payment_view.rental_id',0)
        ->where('payment_view.invoice_no',0)
        ->add_column("Actions", "<a href='view_non_rental/$1'><i class='fa fa-eye'></i></a> &nbsp; <a href='print_non_rental/$1'>print</a> &nbsp; <a href='payment/delete/$1' onclick=\"return confirm('Are you sure you want to delete?');\"><i class='fa fa-trash-o'></i></a>", "payment_view.payment_voucher_no");
		
        echo $this->datatables->generate();
    }
    
    function print_payment($payment_id){
        $data['payment'] = $this->payment_model->getPayment($payment_id);
        $this->load->view('payment-voucher',$data);
    }
    
    function print_non_rental($p_id){
        $data['payment'] = $this->payment_model->getPaymentNonRental($p_id);
        // echo '<pre>';
        // print_r($data['payment']);exit;
        $this->load->view('payment-voucher',$data);
    }
    
    function view($payment_id)
    {
        $id = $payment_id;
        $payment_details = $this->payment_model->getPaymentByIdwithRentalID($payment_id);
        // echo '<pre>';
        // print_r($payment_details);exit;
        $data['id'] = $payment_id;
        $data['payment'] = $payment_details;
        $meta['page_title'] = 'View Payment';
        $data['page_title'] = "View Payment";
        $this->load->view('commons/header', $meta);
        $this->load->view('view', $data);
        $this->load->view('commons/footer');
        
    }
    
    function view_non_rental($payment_id)
    {
        $id = $payment_id;
        $payment_details = $this->payment_model->getPaymentByIdwithoutRentalID($payment_id);
        // echo '<pre>';
        // print_r($payment_details);exit;
        $data['id'] = $payment_id;
        $data['payment'] = $payment_details;
        $meta['page_title'] = 'View Payment Non Rental';
        $data['page_title'] = "View Payment Non Rental";
        $this->load->view('commons/header', $meta);
        $this->load->view('view_non_rental', $data);
        $this->load->view('commons/footer');
        
    }
    
    function add()
    {
        //payment form validation
        /* ==============VALIDATION FOR SELECTBOX AGENT ================ */
        $this->form_validation->set_rules('branch','Branch','trim|required|xss_clean');
        /* --------------*/
        $this->form_validation->set_rules('payment_voucher_date', 'payment Voucher Date', 'trim|required|xss_clean');
        /* ==============VALIDATION FOR SELECTBOX RentalID ================ */
        $this->form_validation->set_rules('rental_id','Rental ID','trim|xss_clean');
        /* --------------*/
        $this->form_validation->set_rules('vehicle_id','Vehicle','xss_clean');
        $this->form_validation->set_rules('payment_ledger', 'Payment Ledger', 'trim|xss_clean');
        $this->form_validation->set_rules('payment_amount', 'Payment Amount', 'trim|required|xss_clean');
        $this->form_validation->set_rules('invoice_no', 'Invoice No', 'trim|xss_clean');
        $this->form_validation->set_rules('description', 'Description', 'trim|xss_clean');
        $this->form_validation->set_rules('payment_mode','Mode of Payment','required|callback_check_default');
        $this->form_validation->set_message('check_default', 'You need to select mode of payment other than the default.');
        
        if ($this->form_validation->run() == true)
        {
            $transaction_date = date('d/m/Y');
            $type = 'P';
            $amount = $this->input->post('payment_amount');
            $voucher_date = $this->input->post('payment_voucher_date');
            $mode = $this->input->post('payment_mode');
            $cheque_date = $this->input->post('cheque_date');
            $cheque_no = $this->input->post('cheque_no');
            $bank_name = $this->input->post('bank_name');
            $from_account = $this->input->post('from_ac');
            $to_account = $this->input->post('to_ac');
            $narration = $this->input->post('description');
            $transaction_ref = '';
            $voucher_status = 1;
            $vehicle_id = $this->input->post('vehicle_id');
            
            //transaction header array
            $transaction_header = array(
                            'transaction_date'      => $transaction_date,
                            'type'                  => $type,
                            'amount'                => $amount,
                            'voucher_date'          => $voucher_date,
                            'mode'                  => $mode,
                            'cheque_date'           => $cheque_date,
                            'cheque_no'             => $cheque_no,
                            'bank_name'             => $bank_name,
                            'from_account'          => $from_account,
                            'to_account'            => $to_account,
                            'narration'             => $narration,
                            'transaction_ref'       => $transaction_ref,
                            'voucher_status'        => $voucher_status,
                    );
            // echo '<pre>';
			// print_r($transaction_header);exit;
            
            $paymentDetail = array(
                    'branch_id'	            =>	$this->input->post('branch'),
                    'payment_voucher_date'	=>	$this->input->post('payment_voucher_date'),
                    'payment_ledger'        =>  $this->input->post('to_ac'),
                    'vehicle_id'            =>  $this->input->post('vehicle_id1'),
                    'rental_id'             =>  $this->input->post('rental_id'),
                    'invoice_no'            =>  $this->input->post('invoice_no'),
                    'payment_amount'        =>  $this->input->post('payment_amount'),
                    'description'           =>  $this->input->post('description'),
                    'payment_mode'          =>  $this->input->post('payment_mode'),
                    'status'          =>  'A',
                    
                );
					// echo '<pre>';
					// print_r($paymentDetail);exit;
        }
        
        if ( ($this->form_validation->run() == true) && $this->payment_model->addPayment($paymentDetail,$transaction_header,$vehicle_id))
		{  
			$this->session->set_flashdata('success', 'Payment added successfully.');
			redirect("payment",'refresh');
		}
		else
		{  
			$data['branch'] = $this->payment_model->getBranch();
            $data['vehicle'] = $this->payment_model->getVehicles();
            // echo '<pre>';
            // print_r($date['vehicle']);exit;
            $data['rental_id'] = $this->payment_model->getRentalReturn();
			$data['default_branch'] = $this->payment_model->getDefaultBranch();
            $data['payment_ledger'] = $this->payment_model->getPaymentLedger();
            // echo '<pre>';
            // print_r($data['rental_id']);exit;
            $data['payment_voucher_no'] = $this->payment_model->getLastID();
            //echo $data['payment_voucher_no'];exit;
            $meta['page_title'] = 'Add Payment';
            $data['page_title'] = "Add Payment";
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
    
    /* =====================VALIDATION FOR invoice id ======================== */
    function check_default1($post_string)
    {
        return $post_string == '0' ? FALSE : TRUE;
    }
    
    public function edit($payment_id)
    {
        $id = $payment_id;
        
        if($post = $this->input->post())
        {
            //payment form validation
            /* ==============VALIDATION FOR SELECTBOX AGENT ================ */
            $this->form_validation->set_rules('branch','Branch','trim|required|xss_clean');
            /* --------------*/
            $this->form_validation->set_rules('payment_voucher_date', 'payment Voucher Date', 'trim|required|xss_clean');
            /* ==============VALIDATION FOR SELECTBOX RentalID ================ */
            $this->form_validation->set_rules('rental_id','Rental ID','required|callback_check_default1');
            $this->form_validation->set_message('check_default1', 'You need to select rental id other than the default.');
            /* --------------*/
            $this->form_validation->set_rules('payment_ledger', 'Payment Ledger', 'trim|xss_clean');
            $this->form_validation->set_rules('payment_amount', 'Payment Amount', 'trim|required|xss_clean');
            $this->form_validation->set_rules('invoice_no', 'Invoice No', 'trim|xss_clean');
            $this->form_validation->set_rules('description', 'Description', 'trim|xss_clean');
            $this->form_validation->set_rules('payment_mode','Mode of Payment','required|callback_check_default');
            $this->form_validation->set_message('check_default', 'You need to select mode of payment other than the default.');
            
            if ($this->form_validation->run() == true)
            {
                $paymentDetail = array(
                        'branch_id'	            =>	$this->input->post('branch'),
                        'payment_voucher_date'	=>	$this->input->post('payment_voucher_date'),
                        'payment_ledger'        =>  $this->input->post('payment_ledger'),
                        'rental_id'             =>  $this->input->post('rental_id'),
                        'invoice_no'            =>  $this->input->post('invoice_no'),
                        'payment_amount'        =>  $this->input->post('payment_amount'),
                        'description'           =>  $this->input->post('description'),
                        'payment_mode'          =>  $this->input->post('payment_mode'),
                        'status'          =>  'A',
                        
                    );
                           // echo '<pre>';
                           // print_r($paymentDetail);exit;
            }
            if ( ($this->form_validation->run() == true) && $this->payment_model->updatePayment($paymentDetail,$id))
            {  
                $this->session->set_flashdata('success', 'Payment edited successfully.');
                redirect("payment",'refresh');
            }
            else
            {  
                $payment_details = $this->payment_model->getPaymentById($payment_id);
                $data['branch'] = $this->payment_model->getBranch();
                // echo '<pre>';
                // print_r($payment_details);exit;
                $data['rental_id'] = $this->payment_model->getRentalReturn();
                $data['id'] = $payment_id;
                $data['payment'] = $payment_details;
                $meta['page_title'] = 'Edit payment';
                $data['page_title'] = "Edit payment";
                $this->load->view('commons/header', $meta);
                $this->load->view('edit', $data);
                $this->load->view('commons/footer');
            
            }
        }
        else
        {
            $payment_details = $this->payment_model->getpaymentById($payment_id);
            $data['branch'] = $this->payment_model->getBranch();
            // echo '<pre>';
            // print_r($payment_details);exit;
            $data['rental_id'] = $this->payment_model->getRentalReturn();
            $data['id'] = $payment_id;
            $data['payment'] = $payment_details;
            $meta['page_title'] = 'Edit payment';
            $data['page_title'] = "Edit payment";
            $this->load->view('commons/header', $meta);
            $this->load->view('edit', $data);
            $this->load->view('commons/footer');
        }
    }
    
    function scanInvoiceNo()
    {
        if($this->input->post('rental_id')) 
        { 
            // $vehicle_no = $this->input->post('vehicle_no');
            $rental_id = $this->input->post('rental_id');
        }
        $invoiceNo = $this->payment_model->getInvoiceNo($rental_id);
        // $data = array("invoice_no"=>$invoiceNo->invoice_no,"vehicle_id"=>$invoiceNo->id);
        $data = array("invoice_no"=>$invoiceNo->invoice_no,'vehicle_type'=>$invoiceNo->vehicleType,"deposit_amount"=>$invoiceNo->deposit_amount,"rent_amount"=>$invoiceNo->rent_amount,"km_extra_used"=>$invoiceNo->km_extra_used,"extra_km"=>$invoiceNo->km_extra_rate,'vehicle_id'=>$invoiceNo->id);
        echo json_encode($data);
    }
    
    public function delete($payment_id)
    {
        $id = $payment_id;
        if($this->payment_model->deletePayment($id))
        {
            $this->session->set_flashdata('success', 'Payment deleted successfully.');
            redirect("payment",'refresh');
        }
    }
}
?>