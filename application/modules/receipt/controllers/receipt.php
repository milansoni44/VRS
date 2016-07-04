<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Receipt extends CI_Controller 
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
		$this->load->model('receipt_model');
		$this->load->library('Datatables');
	}
    
    function index()
    {
        if (!$this->ion_auth->logged_in())
	  	{
			redirect('auth/login');
	  	}
        
        $meta['page_title'] = 'Receipt Details Rental';
		$data['page_title'] = "Receipt Details Rental";
		$this->load->view('commons/header',$meta);
		$this->load->view('index',$data);
		$this->load->view('commons/footer');
    }
    
    function receipt_non_rental()
    {
        if (!$this->ion_auth->logged_in())
	  	{
			redirect('auth/login');
	  	}
        
        $meta['page_title'] = 'receipt Details Non Rental';
		$data['page_title'] = "Receipt Details Non Rental";
		$this->load->view('commons/header',$meta);
		$this->load->view('non_rental_receipt',$data);
		$this->load->view('commons/footer');
    }
    
    function receipt_details()
    {
        $this->datatables->select('receipt_view.receipt_voucher_no,branch.branch_name as branchName,receipt_voucher_date,ledger.title as title,invoice_no,vehicle.vehicle_reg_no,vehicle.brand,receipt_amount,description,mode_of_receipt,status')
        ->from('receipt_view')
        ->join('branch','branch.id = receipt_view.branch_id', 'INNER')
        ->join('ledger','ledger.id = receipt_view.reciept_ledger')
        ->join('rental_pickup','rental_pickup.rental_id = receipt_view.rental_id')
        ->join('vehicle','vehicle.id = rental_pickup.vehicle_id')
        ->where('receipt_view.status','A')
        ->add_column("Actions", "<a href='receipt/view/$1'><i class='fa fa-eye'></i></a> &nbsp; <a href='receipt/print_receipt/$1'>print</a> &nbsp; <a href='receipt/delete/$1' onclick=\"return confirm('Are you sure you want to delete?');\"><i class='fa fa-trash-o'></i></a>", "receipt_view.receipt_voucher_no");
        
        echo $this->datatables->generate();
    }
    
    function receipt_details_nonRental()
    {
        $this->datatables->select('receipt_view.receipt_voucher_no,branch.branch_name as branchName,receipt_voucher_date,ledger.title as title,receipt_amount,description,mode_of_receipt,status')
        ->from('receipt_view')
        ->join('branch','branch.id = receipt_view.branch_id', 'INNER')
        ->join('ledger','ledger.id = receipt_view.reciept_ledger')
        // ->join('rental_pickup','rental_pickup.rental_id = receipt_view.rental_id')
        // ->join('vehicle','vehicle.id = rental_pickup.vehicle_id')
        ->where('receipt_view.status','A')
        ->where('receipt_view.invoice_no',0)
        ->where('receipt_view.rental_id',0)
        ->add_column("Actions", "<a href='view_non_rental/$1'><i class='fa fa-eye'></i></a> &nbsp; <a href='receipt/print_receipt_non_rental/$1'>print</a> &nbsp; <a href='delete/$1' onclick=\"return confirm('Are you sure you want to delete?');\"><i class='fa fa-trash-o'></i></a>", "receipt_view.receipt_voucher_no");
        
        echo $this->datatables->generate();
    }
    
    function print_receipt($receipt_id){
        $data['receiptData'] = $this->receipt_model->getReceipt($receipt_id);
        $this->load->view('receipt-voucher',$data);
    }
    
    function print_receipt_non_rental($receipt_id){
        $data['receiptData'] = $this->receipt_model->getReceiptNonRental($receipt_id);
        // echo '<pre>';
        // print_r($data['receiptData']);exit;
        $this->load->view('receipt-voucher',$data);
    }
    
    function view($receipt_id)
    {
        $id = $receipt_id;
        $receipt_details = $this->receipt_model->getReceiptByIdwithRentalID($receipt_id);
        // echo '<pre>';
        // print_r($receipt_details);exit;
        $data['id'] = $receipt_id;
        $data['receipt'] = $receipt_details;
        $meta['page_title'] = 'View Receipt';
        $data['page_title'] = "View Receipt";
        $this->load->view('commons/header', $meta);
        $this->load->view('view', $data);
        $this->load->view('commons/footer');
        
    }
    
    function view_non_rental($receipt_id)
    {
        $id = $receipt_id;
        $receipt_details = $this->receipt_model->getReceiptByIdwithoutRentalID($receipt_id);
        // echo '<pre>';
        // print_r($receipt_details);exit;
        $data['id'] = $receipt_id;
        $data['receipt'] = $receipt_details;
        $meta['page_title'] = 'View Receipt';
        $data['page_title'] = "View Receipt";
        $this->load->view('commons/header', $meta);
        $this->load->view('view_non_rental', $data);
        $this->load->view('commons/footer');
        
    }
    
    function add()
    {
        //receipt form validation
        /* ==============VALIDATION FOR SELECTBOX AGENT ================ */
        $this->form_validation->set_rules('branch','Branch','trim|required|xss_clean');
        $this->form_validation->set_rules('receipt_voucher_date', 'Receipt Voucher Date', 'trim|required|xss_clean');
        /* ==============VALIDATION FOR SELECTBOX RentalID ================ */
        $this->form_validation->set_rules('rental_id','Rental ID','trim|xss_clean');
        /* --------------*/
        $this->form_validation->set_rules('receipt_ledger', 'Receipt Ledger', 'trim|xss_clean');
        $this->form_validation->set_rules('receipt_amount', 'Receipt Amount', 'trim|required|xss_clean');
        $this->form_validation->set_rules('invoice_no', 'Invoice No', 'trim|xss_clean');
        $this->form_validation->set_rules('description', 'Description', 'trim|xss_clean');
        $this->form_validation->set_rules('receipt_mode','Mode of Receipt','required|callback_check_default');
        $this->form_validation->set_message('check_default', 'You need to select mode of receipt other than the default.');
        
        if ($this->form_validation->run() == true)
        {
            $rental_id = $this->input->post('rental_id');
            $transaction_date = date('d/m/Y');
            $type = 'R';
            $amount = $this->input->post('receipt_amount');
            $voucher_date = $this->input->post('receipt_voucher_date');
            $mode = $this->input->post('receipt_mode');
            $cheque_date = $this->input->post('cheque_date');
            $cheque_no = $this->input->post('cheque_no');
            $bank_name = $this->input->post('bank_name');
            $from_account = $this->input->post('from_ac');
            $to_account = $this->input->post('to_ac');
            $receipt_mode = $this->input->post('receipt_mode');
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
            if($rental_id == 0){
                $receiptDetail = array(
                    'branch_id'	            =>	$this->input->post('branch'),
                    'receipt_voucher_date'	=>	$this->input->post('receipt_voucher_date'),
                    'from_ac'               =>  $this->input->post('from_ac'),
                    'to_ac'                 =>  $this->input->post('to_ac'),
                    'receipt_amount'        =>  $this->input->post('receipt_amount'),
                    'description'           =>  $this->input->post('description'),
                    'receipt_mode'          =>  $this->input->post('receipt_mode'),
                    
                );
            }else{
                $receiptDetail = array(
                    'branch_id'	            =>	$this->input->post('branch'),
                    'receipt_voucher_date'	=>	$this->input->post('receipt_voucher_date'),
                    'from_ac'               =>  $this->input->post('from_ac'),
                    'to_ac'                 =>  $this->input->post('to_ac'),
                    'rental_id'             =>  $this->input->post('rental_id'),
                    'invoice_no'            =>  $this->input->post('invoice_no'),
                    'receipt_amount'        =>  $this->input->post('receipt_amount'),
                    'description'           =>  $this->input->post('description'),
                    'receipt_mode'          =>  $this->input->post('receipt_mode'),
                );
            }
           // echo '<pre>';
           // print_r($receiptDetail);exit;
        }
        
        if ( ($this->form_validation->run() == true) && $this->receipt_model->addReceipt($rental_id,$receiptDetail,$transaction_header,$vehicle_id))
		{  
			$this->session->set_flashdata('success', 'Receipt added successfully.');
			redirect("receipt",'refresh');
		}
		else
		{  
			$data['branch'] = $this->receipt_model->getBranch();
            $data['rental_id'] = $this->receipt_model->getRentalReturn();
            //$data['receipt_ledger'] = $this->receipt_model->getReceiptLedger();
            // echo '</pre>';
            // print_r($data['receipt_ledger']);exit;
			$data['default_branch'] = $this->receipt_model->getDefaultBranch();
            $default_branch_id = $data['default_branch'][0]['default_branch_id'];
            $data['default_branch_ledger'] = $this->receipt_model->getDefaultLedger($default_branch_id);
            // echo '<pre>';
            // print_r($data['default_branch_ledger']);exit;
            $data['receipt_voucher_no'] = $this->receipt_model->getLastID();
            // echo $data['receipt_voucher_no'];exit;
            $meta['page_title'] = 'Add Receipt';
            $data['page_title'] = "Add Receipt";
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
    
    public function edit($receipt_id)
    {
        $id = $receipt_id;
        
        if($post = $this->input->post())
        {
            //receipt form validation
            /* ==============VALIDATION FOR SELECTBOX AGENT ================ */
            $this->form_validation->set_rules('branch','Branch','required|callback_check_default');
            $this->form_validation->set_message('check_default', 'You need to select branch other than the default.');
            /* --------------*/
            $this->form_validation->set_rules('receipt_voucher_date', 'Receipt Voucher Date', 'trim|required|xss_clean');
            /* ==============VALIDATION FOR SELECTBOX RentalID ================ */
            $this->form_validation->set_rules('rental_id','Rental ID','trim|xss_clean');
            /* --------------*/
            $this->form_validation->set_rules('receipt_ledger', 'Receipt Ledger', 'trim|xss_clean');
            $this->form_validation->set_rules('receipt_amount', 'Receipt Amount', 'trim|required|xss_clean');
            $this->form_validation->set_rules('invoice_no', 'Invoice No', 'trim|xss_clean');
            $this->form_validation->set_rules('description', 'Description', 'trim|xss_clean');
            $this->form_validation->set_rules('receipt_mode','Mode of Receipt','required|callback_check_default');
            $this->form_validation->set_message('check_default', 'You need to select mode of receipt other than the default.');
            
            if ($this->form_validation->run() == true)
            {
                $receiptDetail = array(
                        'branch_id'	            =>	$this->input->post('branch'),
                        'receipt_voucher_date'	=>	$this->input->post('receipt_voucher_date'),
                        'from_ac'               =>  $this->input->post('from_ac'),
                        'to_ac'                 =>  $this->input->post('to_ac'),
                        'rental_id'             =>  $this->input->post('rental_id'),
                        'invoice_no'            =>  $this->input->post('invoice_no'),
                        'receipt_amount'        =>  $this->input->post('receipt_amount'),
                        'description'           =>  $this->input->post('description'),
                        'receipt_mode'          =>  $this->input->post('receipt_mode'),
                        
                    );
                           // echo '<pre>';
                           // print_r($receiptDetail);exit;
            }
            if ( ($this->form_validation->run() == true) && $this->receipt_model->updateReceipt($receiptDetail,$id))
            {  
                $this->session->set_flashdata('success', 'Receipt edited successfully.');
                redirect("receipt",'refresh');
            }
            else
            {  
                $receipt_details = $this->receipt_model->getReceiptById($receipt_id);
                $data['branch'] = $this->receipt_model->getBranch();
                $data['receipt_ledger'] = $this->receipt_model->getReceiptLedger();
                // echo '<pre>';
                // print_r($receipt_details);exit;
                $data['rental_id'] = $this->receipt_model->getRentalReturn();
                $data['id'] = $receipt_id;
                $data['receipt'] = $receipt_details;
                $meta['page_title'] = 'Edit receipt';
                $data['page_title'] = "Edit receipt";
                $this->load->view('commons/header', $meta);
                $this->load->view('edit', $data);
                $this->load->view('commons/footer');
            
            }
        }
        else
        {
            $receipt_details = $this->receipt_model->getReceiptById($receipt_id);
            $data['branch'] = $this->receipt_model->getBranch();
            $data['receipt_ledger'] = $this->receipt_model->getReceiptLedger();
            // echo '<pre>';
            // print_r($receipt_details);exit;
            $data['rental_id'] = $this->receipt_model->getRentalReturn();
            $data['id'] = $receipt_id;
            $data['receipt'] = $receipt_details;
            $meta['page_title'] = 'Edit receipt';
            $data['page_title'] = "Edit receipt";
            $this->load->view('commons/header', $meta);
            $this->load->view('edit', $data);
            $this->load->view('commons/footer');
        }
    }
    
    function scanLedgerType()
    {
        if($this->input->post('branch_id')) 
        { 
            $branch_id = $this->input->post('branch_id');
        }
        $ledgerType = $this->receipt_model->getDefaultLedger($branch_id);
        echo json_encode($ledgerType);
    }
    
    function scanInvoiceNo()
    {
        if($this->input->post('rental_id')) 
        { 
            // $vehicle_no = $this->input->post('vehicle_no');
            $rental_id = $this->input->post('rental_id');
        }
        $invoiceNo = $this->receipt_model->getInvoiceNo($rental_id);
        $data = array("invoice_no"=>$invoiceNo->invoice_no,'vehicle_type'=>$invoiceNo->vehicleType,"deposit_amount"=>$invoiceNo->deposit_amount,"rent_amount"=>$invoiceNo->rent_amount,"km_extra_used"=>$invoiceNo->km_extra_used,"extra_km"=>$invoiceNo->km_extra_rate,'vehicle_id'=>$invoiceNo->id);
        echo json_encode($data);
    }
    
    public function delete($receipt_id)
    {
        $id = $receipt_id;
        if($this->receipt_model->deleteReceipt($id))
        {
            $this->session->set_flashdata('success', 'Receipt deleted successfully.');
            redirect("receipt",'refresh');
        }
    }
}
?>