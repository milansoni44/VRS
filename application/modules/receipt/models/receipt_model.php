<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Receipt_model extends CI_Model{
    
    function __construct()
	{
		parent::__construct();
		$this->load->library('Datatables');
        $this->load->library('table');
	}
    
    public function getRentalId(){
        $q = $this->db->get('receipts');
        if( $q->num_rows() > 0 )
        {
            return $q->result_array();
        } 
    
        return FALSE;
        
    }
    
    public function addReceipt($rental_id, $receiptDetail = array(), $transaction_header = array(),$vehicle_id)
    {
        if($rental_id == 0){
            // receipt data
            $receiptData = array(
                'branch_id'                 =>  $receiptDetail['branch_id'],
                'receipt_voucher_date'      =>  $receiptDetail['receipt_voucher_date'],
                'reciept_ledger'            =>  $receiptDetail['from_ac'],
                'receipt_amount'            =>  $receiptDetail['receipt_amount'],
                'description'               =>  $receiptDetail['description'],
                'mode_of_receipt'           =>  $receiptDetail['receipt_mode'],
                'status'                    =>  'A',
            );
        }else{
            // receipt data
            $receiptData = array(
                'branch_id'                 =>  $receiptDetail['branch_id'],
                'receipt_voucher_date'      =>  $receiptDetail['receipt_voucher_date'],
                'reciept_ledger'            =>  $receiptDetail['from_ac'],
                'invoice_no'                =>  $receiptDetail['invoice_no'],
                'rental_id'                 =>  $receiptDetail['rental_id'],
                'receipt_amount'            =>  $receiptDetail['receipt_amount'],
                'description'               =>  $receiptDetail['description'],
                'mode_of_receipt'           =>  $receiptDetail['receipt_mode'],
                'status'                    =>  'A',
            );
        }
        // echo '<pre>';
        // print_r($receiptData);exit;
        
        if($this->db->insert('receipts', $receiptData)) {
			$receipt_id = $this->db->insert_id();
			// return true;
		}
        //transaction header date
            $transaction_header_data = array(
                    'transaction_date'      => $transaction_header['transaction_date'],
                    'vehicle_id'            => $vehicle_id,
                    'type'                  => $transaction_header['type'],
                    'amount'                => $transaction_header['amount'],
                    'voucher_no'            =>  $receipt_id,
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
                $transaction_credit_data = array(
                    'transaction_id'            => $transaction_id,
                    'voucher_type'              => 'C',
                    'voucher_no'                => $receipt_id,
                    'ledger_no'                 => $transaction_header['to_account'],
                    'dr_amount'                 => $transaction_header['amount'],
                    'voucher_status'            => $transaction_header['voucher_status'],
                );
                $this->db->insert('transaction_detail',$transaction_credit_data);
                
                //transaction detail credit
                $transaction_debit_data = array(
                    'transaction_id'            => $transaction_id,
                    'voucher_type'              => 'D',
                    'voucher_no'                => $receipt_id,
                    'ledger_no'                 => $transaction_header['from_account'],
                    'cr_amount'                 => $transaction_header['amount'],
                    'voucher_status'            => $transaction_header['voucher_status'],
                );
                $this->db->insert('transaction_detail',$transaction_debit_data);
                $transaction_detail_id = $this->db->insert_id();
                return true;
            }
        return false;
    }
    
    public function getReceiptById($id)
    {
        $q = $this->db->get_where('receipts', array('receipt_voucher_no' => $id), 1); 
        if( $q->num_rows() > 0 )
        {
            return $q->row();
        } 
    
        return FALSE;
    }
    
    public function getReceiptByIdwithRentalID($id)
    {
        $this->db->select('R.*,B.branch_name');
        $this->db->from('receipts AS R');// I use aliasing make joins easier
        $this->db->join('branch AS B', 'B.id = R.branch_id', 'INNER');
        $this->db->join('rental_return AS Q', 'Q.rental_id = R.rental_id', 'INNER');
        $this->db->where('R.receipt_voucher_no',$id);
        $q = $this->db->get();
        if( $q->num_rows() > 0 )
        {
            return $q->row();
        } 
    
        return FALSE;
    }
    
    public function getReceiptByIdwithoutRentalID($id)
    {
        $this->db->select('R.*,B.branch_name');
        $this->db->from('receipts AS R');// I use aliasing make joins easier
        $this->db->join('branch AS B', 'B.id = R.branch_id', 'INNER');
        // $this->db->join('rental_return AS Q', 'Q.rental_id = R.rental_id', 'INNER');
        $this->db->where('R.receipt_voucher_no',$id);
        $q = $this->db->get();
        if( $q->num_rows() > 0 )
        {
            return $q->row();
        } 
    
        return FALSE;
    }
    
    public function updateReceipt($receiptDetail,$id)
    {
        //echo $id;exit;
        //receipt data
		$receiptData = array(
            'branch_id'                 =>  $receiptDetail['branch_id'],
            'receipt_voucher_date'      =>  $receiptDetail['receipt_voucher_date'],
            'reciept_ledger'            =>  $receiptDetail['receipt_ledger'],
            'invoice_no'                =>  $receiptDetail['invoice_no'],
            'rental_id'                 =>  $receiptDetail['rental_id'],
            'receipt_amount'            =>  $receiptDetail['receipt_amount'],
            'description'               =>  $receiptDetail['description'],
            'mode_of_receipt'           =>  $receiptDetail['receipt_mode'],
            'status'                    =>  'A',
        );
        /*echo '<pre>';
        print_r($receiptData);exit;*/
		
		$this->db->where('receipt_voucher_no', $id);
		if($this->db->update('receipts', $receiptData)) {
				return true;
		}
		return false;
    }
    
    public function deleteReceipt($id)
    {
        $this->db->set('status',"'C'", FALSE);
        $this->db->where('receipt_voucher_no',$id);
        if($this->db->update('receipts')){
            return true;
        }
        /*if($this->db->delete('receipts', array('receipt_voucher_no' => $id))) {
			return true;
	    }*/
			
		return FALSE;
    }
    
    public function getBranch()
    {
        $this->db->select('id,branch_name');
		$branch = $this->db->get('branch');
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
        $this->db->select('rental_return.rental_id,rental_pickup.customer_id,customer.en_name,vehicle.id,vehicle.vehicle_reg_no');
        $this->db->from('rental_return');
        $this->db->join('rental_pickup', 'rental_pickup.rental_id = rental_return.rental_id', 'INNER');
        $this->db->join('vehicle', 'vehicle.id = rental_pickup.vehicle_id', 'INNER');
        $this->db->join('customer', 'customer.id = rental_pickup.customer_id', 'INNER');
        
        $rental_return = $this->db->get();
        return $array = $rental_return->result_array();
    }
    
    public function getReceiptLedger()
    {
        $this->db->select('id,title');
        $this->db->from('ledger');
        //$this->db->where('type','Income');
        
        $ledger = $this->db->get();
        return $array = $ledger->result_array();
    }
    
    public function getInvoiceNo($rental_id)
    {
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
    
    public function getDefaultLedger($id){
        $this->db->select('type,title,id');
        $this->db->from('ledger');
        //$this->db->join('branch','branch.id = ledger.branch_id');
        $this->db->where('branch_id',$id);
        $this->db->where('type','Income');
        $q = $this->db->get();
        if($q->num_rows() > 0)
        {
            return $q->result_array();
        }
        return false;
    }
    
    public function getLastID()
    {
        $this->db->select('receipt_voucher_no');
        $q = $this->db->get('receipts');
        return $a = $q->num_rows() + 1;
        // if( $q->num_rows() > 0 )
        // {
            // return $q->num_rows();
        // }
        // return false;        
    }
    
    function getReceipt($id){
        $this->db->select('R.*,B.branch_name,customer.en_name,transaction_header.mode,transaction_header.cheque_no,transaction_header.cheque_date,transaction_header.bank_name');
        $this->db->from('receipts AS R');// I use aliasing make joins easier
        $this->db->join('branch AS B', 'B.id = R.branch_id', 'INNER');
        $this->db->join('rental_return AS Q', 'Q.rental_id = R.rental_id', 'INNER');
        $this->db->join('rental_pickup', 'rental_pickup.rental_id = R.rental_id', 'INNER');
        $this->db->join('transaction_header', 'transaction_header.voucher_no = R.receipt_voucher_no', 'INNER');
        $this->db->join('customer', 'customer.id = rental_pickup.customer_id', 'INNER');
        $this->db->where('R.receipt_voucher_no',$id);
        $q = $this->db->get();
        if( $q->num_rows() > 0 )
        {
            return $q->row();
        } 
    
        return FALSE;
    }
    
    function getReceiptNonRental($id){
        $this->db->select('R.*,B.branch_name,transaction_header.mode,transaction_header.cheque_no,transaction_header.cheque_date,transaction_header.bank_name');
        $this->db->from('receipts AS R');// I use aliasing make joins easier
        $this->db->join('branch AS B', 'B.id = R.branch_id', 'INNER');
        //$this->db->join('rental_return AS Q', 'Q.rental_id = R.rental_id', 'INNER');
        //$this->db->join('rental_pickup', 'rental_pickup.rental_id = R.rental_id', 'INNER');
        $this->db->join('transaction_header', 'transaction_header.voucher_no = R.receipt_voucher_no', 'INNER');
        //$this->db->join('customer', 'customer.id = rental_pickup.customer_id', 'INNER');
        $this->db->where('R.receipt_voucher_no',$id);
        $q = $this->db->get();
        if( $q->num_rows() > 0 )
        {
            return $q->row();
        } 
    
        return FALSE;
    }
}
?>