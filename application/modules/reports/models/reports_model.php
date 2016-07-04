<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Reports_model extends CI_Model{
    
    function __construct()
	{
		parent::__construct();
		$this->load->library('Datatables');
        $this->load->library('table');
    }
    
    function getGarage(){
        $this->db->select('id,garage_name');
        $this->db->from('garage');
        $rs = $this->db->get();
        if($rs->num_rows() > 0){
            return $rs->result_array();
        }
        return false;
    }
    
    function getVehicle(){
        $this->db->select('id,vehicle_reg_no,brand');
        $this->db->from('vehicle');
        $rs = $this->db->get();
        if($rs->num_rows() > 0){
            return $rs->result_array();
        }
        return false;
    }
    
    function getVehicleList(){
        
        $this->db->select('id,vehicle_reg_no,brand,model_year,daily_rate,weekly_rate,month_rate,extra_km,vehicle_availibility');
        $this->db->from('vehicle');
        $rs = $this->db->get();
        if($rs->num_rows() > 0){
            return $rs->result_array();
        }
        return false;
    }
    
    function getVehicleServiceListPeriod($start_date,$end_date,$garage){
        
        if($garage == 0){
            $this->db->select('service_no,date_service,vehicle.vehicle_reg_no,garage.garage_name,service_done,service_amount');
            $this->db->from('vehicle_service');
            $this->db->join('garage','garage.id = vehicle_service.garage_id');
            $this->db->join('vehicle','vehicle.id = vehicle_service.vehicle_id');
            $this->db->where('date_service >=',$start_date);
            $this->db->where('date_service <=',$end_date);
            $rs = $this->db->get();
        }else{
            $this->db->select('service_no,date_service,vehicle.vehicle_reg_no,garage.garage_name,service_done,service_amount');
            $this->db->from('vehicle_service');
            $this->db->join('garage','garage.id = vehicle_service.garage_id');
            $this->db->join('vehicle','vehicle.id = vehicle_service.vehicle_id');
            $this->db->where('date_service >=',$start_date);
            $this->db->where('date_service <=',$end_date);
            $this->db->where('garage.id',$garage);
            $rs = $this->db->get();
        }
        if($rs->num_rows() > 0){
            return $rs->result_array();
        }
        return false;
    }
    
    function getVehicleRenewal($start_date,$end_date,$due){
        
        $wh = "STR_TO_DATE(`reg_expiry_date`,'%d/%m/%Y')"." between STR_TO_DATE('".$start_date."','%d/%m/%Y') and STR_TO_DATE('".$end_date."','%d/%m/%Y')";
        
        $wh1 = "STR_TO_DATE(`insurance_expiry_date`,'%d/%m/%Y')"." between STR_TO_DATE('".$start_date."','%d/%m/%Y') and STR_TO_DATE('".$end_date."','%d/%m/%Y')";
        
        if($due == 0){
            $this->db->select('vehicle.id,vehicle_reg_no,insurance_company,insurance_expiry_date,reg_expiry_date');
        //->unset_column('vehicle.id')
            $this->db->from('vehicle');
            $this->db->join('branch', 'branch.id=vehicle.branch_id', 'INNER');
            $this->db->join('vehicle_owner', 'vehicle_owner.id=vehicle.owner_id', 'INNER');
            $this->db->where('branch.id',DEFAULT_BRANCH);
            $this->db->where($wh);
            $this->db->or_where($wh1);
        }else if($due == 1){
            $this->db->select('vehicle.id,vehicle_reg_no,insurance_company,insurance_expiry_date,reg_expiry_date');
            $this->db->from('vehicle');
            $this->db->join('branch', 'branch.id=vehicle.branch_id', 'INNER');
            $this->db->join('vehicle_owner', 'vehicle_owner.id=vehicle.owner_id', 'INNER');
            $this->db->where('branch.id',DEFAULT_BRANCH);
            $this->db->where($wh);
        }else{
            $this->db->select('vehicle.id,vehicle_reg_no,insurance_company,insurance_expiry_date,reg_expiry_date');
            //->unset_column('vehicle.id')
            $this->db->from('vehicle');
            $this->db->join('branch', 'branch.id=vehicle.branch_id', 'INNER');
            $this->db->join('vehicle_owner', 'vehicle_owner.id=vehicle.owner_id', 'INNER');
            $this->db->where('branch.id',DEFAULT_BRANCH);
            $this->db->where($wh1);
        }
        
        $rs = $this->db->get();
        if($rs->num_rows() > 0){
            return $rs->result_array();
        }
        return false;
    }
    
    function getVehicleInsuranceRenewal($start_date,$end_date){
        
        $wh = "STR_TO_DATE(`insurance_expiry_date`,'%d/%m/%Y')"." between STR_TO_DATE('".$start_date."','%d/%m/%Y') and STR_TO_DATE('".$end_date."','%d/%m/%Y')";
        
        $this->db->select('vehicle.id,vehicle_reg_no,insurance_company,insurance_expiry_date,reg_expiry_date');
        //->unset_column('vehicle.id')
        $this->db->from('vehicle');
        $this->db->join('branch', 'branch.id=vehicle.branch_id', 'INNER');
        $this->db->join('vehicle_owner', 'vehicle_owner.id=vehicle.owner_id', 'INNER');
        $this->db->where('branch.id',DEFAULT_BRANCH);
        $this->db->where($wh);
        $rs = $this->db->get();
        if($rs->num_rows() > 0){
            return $rs->result_array();
        }
        return false;
    }
    
    function getReceiptPeriod($start_date,$end_date,$rental_type){
        $start_date = $this->input->get('start_date');
        $end_date = $this->input->get('end_date');
        
        $wh = "STR_TO_DATE(`receipt_voucher_date`,'%d/%m/%Y')"." between STR_TO_DATE('".$start_date."','%d/%m/%Y') and STR_TO_DATE('".$end_date."','%d/%m/%Y')";
        if($rental_type == 'rental'){
            $this->db->select('receipts.receipt_voucher_no,vehicle.vehicle_reg_no,receipt_voucher_date,description,ledger.title as title,receipt_amount');
            $this->db->from('receipts');
            $this->db->join('rental_pickup','rental_pickup.rental_id = receipts.rental_id');
            $this->db->join('vehicle','vehicle.id = rental_pickup.vehicle_id');
            $this->db->join('branch','branch.id = receipts.branch_id', 'INNER');
            $this->db->join('ledger','ledger.id = receipts.reciept_ledger');
            $this->db->where('branch.id',DEFAULT_BRANCH);
            $this->db->where('receipts.status','A');
        }else{
            $this->db->select('receipts.receipt_voucher_no,receipt_voucher_date,description,ledger.title as title,receipt_amount')
            ->from('receipts')
            ->join('branch','branch.id = receipts.branch_id', 'INNER')
            ->join('ledger','ledger.id = receipts.reciept_ledger')
            ->where('branch.id',DEFAULT_BRANCH)
            ->where('receipts.status','A')
            ->where('receipts.rental_id',0)
            ->where('receipts.invoice_no',0);
        }
        $this->db->where($wh);
        $rs = $this->db->get();
        // echo $this->db->last_query();exit;
        if($rs->num_rows() > 0){
            return $rs->result_array();
        }
        return false;
    }
    
    function getPaymentPeriod($start_date,$end_date,$rental_type){
        
        $wh = "STR_TO_DATE(`payment_voucher_date`,'%d/%m/%Y')"." between STR_TO_DATE('".$start_date."','%d/%m/%Y') and STR_TO_DATE('".$end_date."','%d/%m/%Y')";
        if($rental_type == 'rental'){
            
            $this->db->select('payments.payment_voucher_no,vehicle.vehicle_reg_no,payment_voucher_date,description,ledger.title as title,payment_amount');
            $this->db->from('payments');
            $this->db->join('rental_pickup','rental_pickup.rental_id = payments.rental_id');
            $this->db->join('vehicle','vehicle.id = rental_pickup.vehicle_id');
            $this->db->join('branch','branch.id = payments.branch_id', 'INNER');
            $this->db->join('ledger','ledger.id = payments.payment_ledger');
            $this->db->where('branch.id',DEFAULT_BRANCH);
            $this->db->where('payments.status','A');
        }else{
            $this->db->select('payments.payment_voucher_no,payment_voucher_date,payments.vehicle_id,description,ledger.title as payment_ledger,payment_amount')
            ->from('payments')
            //->join('rental_pickup','rental_pickup.rental_id = payments.rental_id')
            //->join('vehicle','vehicle.id = rental_pickup.vehicle_id')
            ->join('branch','branch.id = payments.branch_id', 'INNER')
            ->join('ledger','ledger.id = payments.payment_ledger', 'INNER')
            ->where('branch.id',DEFAULT_BRANCH)
            ->where('status','A')
            ->where('payments.rental_id',0)
            ->where('payments.invoice_no',0);
        }
        $this->db->where($wh);
        $rs = $this->db->get();
        if($rs->num_rows() > 0){
            return $rs->result_array();
        }
        return false;
    }
    
    function getChequeDuePeriod($start_date,$end_date){
        
        $wh = "STR_TO_DATE(`date_issue`,'%d/%m/%Y')"." between STR_TO_DATE('".$start_date."','%d/%m/%Y') and STR_TO_DATE('".$end_date."','%d/%m/%Y')";
        
        $this->db->select('vehicle_no,date_issue,cheque_no,bank_ref,amount,reason');
        $this->db->from('pdc');
        // $this->db->where('mode','CHEQUE');
        $this->db->where($wh);
        $rs = $this->db->get();
        
        if($rs->num_rows() > 0){
            return $rs->result_array();
        }
        return false;
    }
    
    function getVehicleRentedPeriod($start_date,$end_date,$vehicle){
        
        if($vehicle == 0){
            $wh = "STR_TO_DATE(`date_rental`,'%d/%m/%Y')"." between STR_TO_DATE('".$start_date."','%d/%m/%Y') and STR_TO_DATE('".$end_date."','%d/%m/%Y')";
        
            $this->db->select('rental_pickup.rental_id as id,vehicle.vehicle_reg_no,vehicle.brand,customer.en_name,rental_pickup.date_rental,rental_return.return_date,rental_return.total_rented_days,rental_pickup.rental_type,rental_return.rate_per_day,rental_pickup.deposit_amount,rental_return.misc_charges,rental_return.deduction,rental_return.total_rent_charges');
            $this->db->from('rental_pickup');
            $this->db->join('vehicle','vehicle.id = rental_pickup.vehicle_id');
            $this->db->join('customer','customer.id = rental_pickup.customer_id');
            $this->db->join('rental_return','rental_return.rental_id = rental_pickup.rental_id');
            $this->db->where($wh);
        }else{
            $wh = "STR_TO_DATE(`date_rental`,'%d/%m/%Y')"." between STR_TO_DATE('".$start_date."','%d/%m/%Y') and STR_TO_DATE('".$end_date."','%d/%m/%Y')";
        
            $this->db->select('rental_pickup.rental_id as id,vehicle.vehicle_reg_no,vehicle.brand,customer.en_name,rental_pickup.date_rental,rental_return.return_date,rental_return.total_rented_days,rental_pickup.rental_type,rental_return.rate_per_day,rental_pickup.deposit_amount,rental_return.misc_charges,rental_return.deduction,rental_return.total_rent_charges');
            $this->db->from('rental_pickup');
            $this->db->join('vehicle','vehicle.id = rental_pickup.vehicle_id');
            $this->db->join('customer','customer.id = rental_pickup.customer_id');
            $this->db->join('rental_return','rental_return.rental_id = rental_pickup.rental_id');
            $this->db->where($wh);
            $this->db->where('rental_pickup.vehicle_id',$vehicle);
        }
        
        $rs = $this->db->get();
        if($rs->num_rows() > 0){
            return $rs->result_array();
        }
        return false;
    }
    
    function getVehicleExpectedReturnPeriod($start_date,$end_date,$vehicle){
        
        $wh = "STR_TO_DATE(`expected_return_date`,'%d/%m/%Y')"." between STR_TO_DATE('".$start_date."','%d/%m/%Y') and STR_TO_DATE('".$end_date."','%d/%m/%Y')";
        
        if($vehicle == 0){
            $this->db->select('rental_pickup.rental_id as id,vehicle.vehicle_reg_no,vehicle.brand,customer.en_name,rental_pickup.date_rental,rental_pickup.expected_return_date,rental_return.total_rented_days,rental_pickup.rental_type,rental_return.rate_per_day,rental_pickup.deposit_amount,rental_return.misc_charges,rental_return.deduction,rental_return.total_rent_charges');
            $this->db->from('rental_pickup');
            $this->db->join('vehicle','vehicle.id = rental_pickup.vehicle_id');
            $this->db->join('customer','customer.id = rental_pickup.customer_id');
            $this->db->join('rental_return','rental_return.rental_id = rental_pickup.rental_id');
            $this->db->where($wh);
        }else{
            $this->db->select('rental_pickup.rental_id as id,vehicle.vehicle_reg_no,vehicle.brand,customer.en_name,rental_pickup.date_rental,rental_pickup.expected_return_date,rental_return.total_rented_days,rental_pickup.rental_type,rental_return.rate_per_day,rental_pickup.deposit_amount,rental_return.misc_charges,rental_return.deduction,rental_return.total_rent_charges');
            $this->db->from('rental_pickup');
            $this->db->join('vehicle','vehicle.id = rental_pickup.vehicle_id');
            $this->db->join('customer','customer.id = rental_pickup.customer_id');
            $this->db->join('rental_return','rental_return.rental_id = rental_pickup.rental_id');
            $this->db->where($wh);
            $this->db->where('rental_pickup.vehicle_id',$vehicle);
        }
        
        $rs = $this->db->get();
        if($rs->num_rows() > 0){
            return $rs->result_array();
        }
        return false;
    }
}
?>