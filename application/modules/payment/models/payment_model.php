<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class payment_model extends CI_Model{
    
    function __construct()
	{
		parent::__construct();
		$this->load->library('Datatables');
        $this->load->library('table');
	}
    
    public function addPayment($paymentDetail=array(), $transaction_header = array(),$vehicle_id)
    {
        // payment data
        $paymentData = array(
            'branch_id'                 =>  $paymentDetail['branch_id'],
            'payment_voucher_date'      =>  $paymentDetail['payment_voucher_date'],
            'payment_ledger'            =>  $paymentDetail['payment_ledger'],
            'vehicle_id'                =>  $paymentDetail['vehicle_id'],
            'invoice_no'                =>  $paymentDetail['invoice_no'],
            'rental_id'                 =>  $paymentDetail['rental_id'],
            'payment_amount'            =>  $paymentDetail['payment_amount'],
            'description'               =>  $paymentDetail['description'],
            'mode_of_payment'           =>  $paymentDetail['payment_mode'],
        );
        
        // echo '<pre>';
        // print_r($paymentData);exit;
        
        if($this->db->insert('payments', $paymentData)) {
			$payment_id = $this->db->insert_id();
		}
        //transaction header date
            $transaction_header_data = array(
                    'transaction_date'      => $transaction_header['transaction_date'],
                    'vehicle_id'            => $vehicle_id,
                    'vehicle_reg_no'        => $paymentDetail['vehicle_id'],
                    'type'                  => $transaction_header['type'],
                    'amount'                => $transaction_header['amount'],
                    'voucher_no'            =>  $payment_id,
                    'voucher_date'          => $transaction_header['voucher_date'],
                    'mode'                  => $transaction_header['mode'],
                    'cheque_date'           => $transaction_header['cheque_date'],
                    'cheque_no'             => $transaction_header['cheque_no'],
                    'bank_name'             => $transaction_header['bank_name'],
                    'from_account'          => $transaction_header['from_account'],
                    'to_account'            => $transaction_header['to_account'],
                    'narration'             => $transaction_header['narration'],
                    'transaction_ref'       => $transaction_header['transaction_ref'],
                    'voucher_status'        => $transaction_header['voucher_status'],
            );
            // echo '<pre>';
            // print_r($transaction_header_data);exit;
            if($this->db->insert('transaction_header',$transaction_header_data))
            {
                $transaction_id = $this->db->insert_id();
                
                //transaction detail debit
                $transaction_debit_data = array(
                    'transaction_id'            => $transaction_id,
                    'voucher_type'              => 'D',
                    'voucher_no'                => $payment_id,
                    'ledger_no'                 => $transaction_header['from_account'],
                    'dr_amount'                 => $transaction_header['amount'],
                    'voucher_status'            => $transaction_header['voucher_status'],
                );
                $this->db->insert('transaction_detail',$transaction_debit_data);
                
                //transaction detail credit
                $transaction_credit_data = array(
                    'transaction_id'            => $transaction_id,
                    'voucher_type'              => 'C',
                    'voucher_no'                => $payment_id,
                    'ledger_no'                 => $transaction_header['to_account'],
                    'cr_amount'                 => $transaction_header['amount'],
                    'voucher_status'            => $transaction_header['voucher_status'],
                );
                $this->db->insert('transaction_detail',$transaction_credit_data);
                $transaction_detail_id = $this->db->insert_id();
                return true;
            }
        return false;
    }
    
    public function getPaymentById($id)
    {
        $q = $this->db->get_where('payments', array('payment_voucher_no' => $id), 1); 
        if( $q->num_rows() > 0 )
        {
            return $q->row();
        } 
    
        return FALSE;
    }
    
    public function getPaymentByIdwithRentalID($id)
    {
        $this->db->select('R.*,B.branch_name');
        $this->db->from('payments AS R');// I use aliasing make joins easier
        $this->db->join('branch AS B', 'B.id = R.branch_id', 'INNER');
        $this->db->join('rental_return AS Q', 'Q.rental_id = R.rental_id', 'INNER');
        $this->db->where('R.payment_voucher_no',$id);
        $q = $this->db->get();
        if( $q->num_rows() > 0 )
        {
            return $q->row();
        } 
    
        return FALSE;
    }
    
    public function getPaymentByIdwithoutRentalID($id)
    {
        $this->db->select('R.*,B.branch_name,L.title');
        $this->db->from('payments AS R');// I use aliasing make joins easier
        $this->db->join('branch AS B', 'B.id = R.branch_id', 'INNER');
        $this->db->join('ledger AS L', 'L.id = R.payment_ledger', 'INNER');
        $this->db->where('R.payment_voucher_no',$id);
        $q = $this->db->get();
        if( $q->num_rows() > 0 )
        {
            return $q->row();
        } 
    
        return FALSE;
    }
    
    public function updatepayment($paymentDetail,$id)
    {
        //echo $id;exit;
        //payment data
		$paymentData = array(
            'branch_id'                 =>  $paymentDetail['branch_id'],
            'payment_voucher_date'      =>  $paymentDetail['payment_voucher_date'],
            'reciept_ledger'            =>  $paymentDetail['payment_ledger'],
            'invoice_no'                =>  $paymentDetail['invoice_no'],
            'rental_id'                 =>  $paymentDetail['rental_id'],
            'payment_amount'            =>  $paymentDetail['payment_amount'],
            'description'               =>  $paymentDetail['description'],
            'mode_of_payment'           =>  $paymentDetail['payment_mode'],
        );
        /*echo '<pre>';
        print_r($paymentData);exit;*/
		
		$this->db->where('payment_voucher_no', $id);
		if($this->db->update('payments', $paymentData)) {
				return true;
		}
		return false;
    }
    
    public function deletePayment($id)
    {
        $this->db->set('status',"'C'", FALSE);
        $this->db->where('payment_voucher_no',$id);
        if($this->db->update('payments')) {
			return true;
	    }
			
		return FALSE;
    }
    
    public function getBranch()
    {
        $this->db->select('id,branch_name');
		$branch = $this->db->get('branch');
		return $array = $branch->result_array();
    }
    // vehicle list
    public function getVehicles()
    {
        $this->db->select('id,vehicle_reg_no,brand');
		$branch = $this->db->get('vehicle');
		return $array = $branch->result_array();
    }
    
    //get default branch to set
	public function getDefaultBranch()
	{
		$this->db->select('id,default_branch_id');
		$default_branch = $this->db->get('settings');
		return $array = $default_branch->result_array();
	}
    
    public function getRentalReturn()
    {
        $this->db->select('rental_return.rental_id,rental_pickup.customer_id,customer.en_name,vehicle.vehicle_reg_no');
        $this->db->from('rental_return');
        $this->db->join('rental_pickup', 'rental_pickup.rental_id = rental_return.rental_id', 'INNER');
        $this->db->join('vehicle', 'vehicle.id = rental_pickup.vehicle_id', 'INNER');
        $this->db->join('customer', 'customer.id = rental_pickup.customer_id', 'INNER');
        
        $rental_return = $this->db->get();
        return $array = $rental_return->result_array();
    }
    
    public function getInvoiceNo($rental_id)
    {
        // $this->db->select('invoice_no,vehicle.id');
        // $this->db->from('rental_return');
        // $this->db->join('rental_pickup','rental_pickup.rental_id = rental_return.rental_id');
        // $this->db->join('vehicle','vehicle.id = rental_pickup.vehicle_id');
        // $this->db->where('rental_id',$rental_id);
        // $q = $this->db->get();
        // if( $q->num_rows() > 0 )
        // {
            // return $q->row();
        // } 
        $this->db->select('rental_return.invoice_no,vehicle.vehicle_type as vehicleType,rental_pickup.deposit_amount,rental_pickup.rent_amount,rental_return.km_extra_rate,rental_return.km_extra_used,vehicle.id');
        $this->db->from('rental_return');
        $this->db->join('rental_pickup','rental_pickup.rental_id = rental_return.rental_id');
        $this->db->join('vehicle','vehicle.id = rental_pickup.vehicle_id');
        $this->db->where('rental_return.rental_id',$rental_id);
        $q = $this->db->get();
        if( $q->num_rows() > 0 )
        {
            return $q->row();
        } 
    
        return FALSE;
    }
    
    public function getPaymentLedger()
    {
        $this->db->select('id,title');
        $this->db->from('ledger');
        //$this->db->where('type','Expenditure');
        
        $ledger = $this->db->get();
        return $array = $ledger->result_array();
    }
    
    public function getLastID()
    {
        $this->db->select('payment_voucher_no');
        $q = $this->db->get('payments');
        return $a = $q->num_rows() + 1;
        // if( $q->num_rows() > 0 )
        // {
            // return $q->num_rows();
        // }
        // return false;        
    }
    
    public function getPayment($id)
    {
        $this->db->select('R.*,B.branch_name,customer.en_name,transaction_header.cheque_no,transaction_header.mode,transaction_header.cheque_date,transaction_header.bank_name');
        $this->db->from('payments AS R');// I use aliasing make joins easier
        $this->db->join('branch AS B', 'B.id = R.branch_id', 'INNER');
        $this->db->join('transaction_header', 'transaction_header.voucher_no = R.payment_voucher_no', 'INNER');
        $this->db->join('rental_return AS Q', 'Q.rental_id = R.rental_id', 'INNER');
        $this->db->join('rental_pickup', 'rental_pickup.rental_id = R.rental_id', 'INNER');
        $this->db->join('customer', 'customer.id = rental_pickup.customer_id', 'INNER');
        $this->db->where('R.payment_voucher_no',$id);
        $q = $this->db->get();
        if( $q->num_rows() > 0 )
        {
            return $q->row();
        } 
    
        return FALSE;
    }
    
    public function getPaymentNonRental($id)
    {
        $this->db->select('R.*,B.branch_name,transaction_header.cheque_no,transaction_header.mode,transaction_header.cheque_date,transaction_header.bank_name');
        $this->db->from('payments AS R');// I use aliasing make joins easier
        $this->db->join('branch AS B', 'B.id = R.branch_id', 'INNER');
        $this->db->join('transaction_header', 'transaction_header.voucher_no = R.payment_voucher_no', 'INNER');
        // $this->db->join('rental_return AS Q', 'Q.rental_id = R.rental_id', 'INNER');
        // $this->db->join('rental_pickup', 'rental_pickup.rental_id = R.rental_id', 'INNER');
        // $this->db->join('customer', 'customer.id = rental_pickup.customer_id', 'INNER');
        $this->db->where('R.payment_voucher_no',$id);
        $q = $this->db->get();
        if( $q->num_rows() > 0 )
        {
            return $q->row();
        } 
    
        return FALSE;
    }
}
?>