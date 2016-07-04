<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Rentalreturn_model extends CI_Model{
    function __construct()
	{
		parent::__construct();
		$this->load->library('Datatables');
        $this->load->library('table');
	}

    public function updateRentalReturn($rentalReturnDetail = array(), $id)
	{	
		// rental return data
            $RentalReturnData = array(
                'pickup_date'                =>   $rentalReturnDetail['pickup_date'],
                'return_date'                =>   $rentalReturnDetail['rental_return_date'],
                'km_in' 	                 =>   $rentalReturnDetail['km_in'],
                'km_used'	                 =>   $rentalReturnDetail['km_used'],
                'km_extra_used'	             =>   $rentalReturnDetail['km_extra_used'],
                'km_extra_rate'	             =>   $rentalReturnDetail['km_extra_rate'],
                'total_rented_days'	         =>   $rentalReturnDetail['total_rented_days'],
                'rate_per_day'	             =>   $rentalReturnDetail['rate_per_day'],
                'total_rent_charges'	     =>   $rentalReturnDetail['total_rent_charge'],
                'fuel_level'	             =>   $rentalReturnDetail['fuel_level'],
                'fuel_refil_charges'         =>   $rentalReturnDetail['fuel_refil_charges'],
                'traffic_fine'	             =>   $rentalReturnDetail['traffic_fine'],
                'additional_driver_charges'  =>   $rentalReturnDetail['additional_driver_charge'],    
                'chauffer_charges'	         =>   $rentalReturnDetail['chauffer_charges'],
                'additional_insurance'	     =>   $rentalReturnDetail['additional_insurance'],
                'pai_charges'	             =>   $rentalReturnDetail['pai_charges'],
                'misc_charges'	             =>   $rentalReturnDetail['misc_charges'],
                'deduction'	                 =>   $rentalReturnDetail['deduction'],
                'discount_type'              =>   $rentalReturnDetail['discount_type'],
                'discount'                   =>   $rentalReturnDetail['discount'],
                'invoice_no'	             =>   $rentalReturnDetail['invoice_no'],
                'invoice_date'	             =>   $rentalReturnDetail['invoice_date'],
                'invoice_status'	         =>   $rentalReturnDetail['invoice_status'],
                'gps_km'                     => $rentalReturnDetail['gps_km'],
                'actual_km'                  => $rentalReturnDetail['actual_km'],
                'total_km'                   => $rentalReturnDetail['total_km'],
                'net_amount'                 => $rentalReturnDetail['net_amount'],
                'remarks'                    => $rentalReturnDetail['remarks'],
                'status'                     => $rentalReturnDetail['status'],
            ); 
		   // echo '<pre>';
		   // print_r($RentalReturnData);exit;
           
		$this->db->where('rental_id', $id);
		if($this->db->update('rental_return', $RentalReturnData)) {
                // $pickup_data = array(
                    // 'expected_return_date'  =>  $rentalReturnDetail['rental_return_date'],
                    // 'rent_amount'           =>  $rentalReturnDetail['total_rent_charge'],
                // );
                // //update rental_pickup `return_date` and `total_rent_charge`
                // $this->db->where('rental_id', $id);
                // $this->db->update('rental_pickup',$pickup_data);
                $this->db->select('rental_id,vehicle_id');
                $this->db->from('rental_pickup');
                $this->db->where('rental_id',$id);
                $v = $this->db->get();
                if($v->num_rows() > 0)
                {
                    $vehicle_id = $v->row();
                }
                $this->db->set('vehicle_availibility',"'Available'",FALSE);
                $this->db->where('id',$vehicle_id->vehicle_id);
                $this->db->update('vehicle');
                
				return true;
		}
		return false;
	}
    
    public function getRentalReturnById($id)
    {
        $q = $this->db->get_where('rental_return', array('rental_id' => $id), 1); 
        if( $q->num_rows() > 0 )
        {
            return $q->row();
        } 
    
        return FALSE;
    }
    
    public function getRatePerDay($rental_id)
    {
        $this->db->select('rental_pickup.rental_type,rental_pickup.vehicle_id');
        $this->db->from('rental_pickup');
        $this->db->join('vehicle','vehicle.id = rental_pickup.vehicle_id');
        $this->db->where('rental_id',$rental_id);
        $q_rental_type = $this->db->get();
        if($q_rental_type->num_rows() > 0)
        {
            $row1=$q_rental_type->row();
        }
        $rental_type = $row1->rental_type;
        $vehicle_id = $row1->vehicle_id;
        
        if($rental_type == "Daily")
        {
            $this->db->select('daily_rate');
            $this->db->from('vehicle');
            $this->db->where('id',$vehicle_id);
            $q_daily_rate = $this->db->get();
            //echo $this->db->last_query();exit;
            if($q_daily_rate->num_rows() > 0)
            {
                $rate = $q_daily_rate->row();
            }
            return $daily_rate = $rate->daily_rate;
        }
        if($rental_type == "Weekly")
        {
            $this->db->select('weekly_rate');
            $this->db->from('vehicle');
            $this->db->where('id',$vehicle_id);
            $q_weekly_rate = $this->db->get();
            //echo $this->db->last_query();exit;
            if($q_weekly_rate->num_rows() > 0)
            {
                $rate = $q_weekly_rate->row();
            }
            return $daily_rate = $rate->weekly_rate;
        }
        if($rental_type == "Monthly")
        {
            $this->db->select('month_rate');
            $this->db->from('vehicle');
            $this->db->where('id',$vehicle_id);
            $q_month_rate = $this->db->get();
            //echo $this->db->last_query();exit;
            if($q_month_rate->num_rows() > 0)
            {
                $rate = $q_month_rate->row();
            }
            return $daily_rate = $rate->month_rate;
        }
    }
    
    public function getKMOut($id){
        $this->db->select('km_reading_out');
        $this->db->from('rental_pickup');
        $this->db->where('rental_id',$id);
        $q = $this->db->get();
        if($q->num_rows > 0){
            return $q->row();
        }
        return false;
    }
    
    public function getKmAllowed($id){
        $this->db->select('rental_id,km_allowed,rental_type,vehicle.extra_km as extra_km,vehicle.daily_rate as daily_rate,vehicle.weekly_rate as weekly_rate,vehicle.month_rate as month_rate, rental_pickup.date_rental as pickup_date,rental_pickup.expected_return_date as return_date');
        $this->db->from('rental_pickup');
        $this->db->join('vehicle','vehicle.id=rental_pickup.vehicle_id');
        $this->db->where('rental_id',$id);
        $q = $this->db->get();
        if($q->num_rows()>0){
            return $q->row();
        }
        return false;
    }
    
    public function getDeduction($id){
        $this->db->select('rental_id,receipt_amount,ledger.title');
        $this->db->from('receipts');
        $this->db->join('ledger','ledger.id = receipts.reciept_ledger');
        $this->db->where('rental_id',$id);
        $this->db->where('ledger.title','DEPOSIT');
        $q = $this->db->get();
         if($q->num_rows()>0){
            $deduction = $q->row();
            if(!is_null(gettype($deduction->receipt_amount)))
            {
               return $deduction->receipt_amount;
            }
         }else{
             return 0;
         }
         
        //echo gettype($deduction->receipt_amount);exit;
        
        
    }
    
    public function updatePickUp($rental_id, $pickup_data = array()){
        $RentalPickUpData = array(
                'rental_type'                =>   $pickup_data['rental_type'],
            );
        $this->db->where('rental_id',$rental_id);    
        if($this->db->update('rental_pickup',$RentalPickUpData)){
            return true;
        }
        return false;
    }
    
    function getReturnStatus($id){
        $this->db->select('status');
        $this->db->from('rental_return');
        $this->db->where('rental_id',$id);
        $q = $this->db->get();
        if($q->num_rows() > 0){
            return $q->row();
        }
        return false;
    }
}
?>