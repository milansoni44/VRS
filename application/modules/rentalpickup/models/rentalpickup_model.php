<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Rentalpickup_model extends CI_Model{
    function __construct()
	{
		parent::__construct();
		$this->load->library('Datatables');
        $this->load->library('table');
	}

    public function getVehicle()
    {
        $this->db->select('id,vehicle_reg_no,brand');
        $this->db->where('vehicle_availibility','Available');
		$vehicle = $this->db->get('vehicle');
        return $array = $vehicle->result_array();
    }
    
    public function getVehicleEdit()
    {
        $where_au = "(vehicle_availibility = 'Available' OR vehicle_availibility = 'Rented')";
        $this->db->select('id,vehicle_reg_no,brand');
        // $this->db->where('vehicle_availibility','Available');
        $this->db->where($where_au);
		$vehicle = $this->db->get('vehicle');
        return $array = $vehicle->result_array();
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
    
    public function getCustomer()
    {
        $this->db->select('id,en_name');
		$customer = $this->db->get('customer');
		return $array = $customer->result_array();
    }
    
    public function getCustomerByIdWithJoin($id)
    {
        $this->db->select('c.*,b.branch_name');
        $this->db->from('customer AS c');// I use aliasing make joins easier
        $this->db->join('branch AS b', 'b.id = c.branch_id', 'INNER');
        $this->db->where('c.id',$id);
        $q = $this->db->get();
        if( $q->num_rows() > 0 )
        {
            return $q->row();
        } 
    
        return FALSE;
    }
    
    public function addRentalPickUp($rentalPickUpDetail = array())
	{	
		// rental pickup data
		$RentalPickUpData = array(
                    'branch_id'	                    => $rentalPickUpDetail['branch_id'],
                    'customer_id'                       => $rentalPickUpDetail['customer_id'],
                    'date_rental'                       => $rentalPickUpDetail['date_rental'], 
                    'vehicle_id'           => $rentalPickUpDetail['vehicle_reg_no'],
                    'rental_type'           => $rentalPickUpDetail['rental_type'],
                    'rent_amount'           => $rentalPickUpDetail['rent_amount'],
                    'deposit_amount'           => $rentalPickUpDetail['deposit_amount'],
                    'expected_return_date'           => $rentalPickUpDetail['expected_return_date'],
                    'pickup_from_place'           => $rentalPickUpDetail['pickup_from_place'],
                    'drop_off_place'           => $rentalPickUpDetail['drop_off_place'],
                    'km_allowed'           => $rentalPickUpDetail['km_allowed'],
                    'extra_km_rate'           => $rentalPickUpDetail['extra_km_rate'],
                    'km_reading_out'           => $rentalPickUpDetail['km_reading_out'],
                    //'km_reading_in'           => $rentalPickUpDetail['km_reading_in'],
                    'fuel_level'           => $rentalPickUpDetail['fuel_level'],
                    'gps_km'           => $rentalPickUpDetail['gps_km'],
                    'actual_km'           => $rentalPickUpDetail['actual_km'],
                    'total_km'           => $rentalPickUpDetail['total_km'],
            );
            // echo '<pre>';
		   // print_r($RentalPickUpData);exit;
           $km_used = -$rentalPickUpDetail['km_reading_out'];
           
           //total rented days
            $d1 = $rentalPickUpDetail['date_rental'];
            $d2 = $rentalPickUpDetail['expected_return_date'];
            
            $array = explode('/',$d1);
            
            $temp1 = $array[1];
            $array[1] = $array[0];
            $array[0] = $temp1;
            $newD1 = implode('/',$array);
            $array1 = explode('/',$d2);
            
            $temp2 = $array1[1];
            $array1[1] = $array1[0];
            $array1[0] = $temp2;
            $newD2 = implode('/',$array1);
            $date1 = new DateTime($newD1);
            $date2 = new DateTime($newD2);
            
            
            
            $diff = $date2->diff($date1)->format("%a");
            $total_rent_days = $diff;
           
        if($this->db->insert('rental_pickup', $RentalPickUpData)) {
			$rental_pickup_id = $this->db->insert_id();
            
            $this->db->select('rental_id,vehicle_id');
            $this->db->from('rental_pickup');
            $this->db->where('rental_id',$rental_pickup_id);
            $v = $this->db->get();
            if($v->num_rows() > 0)
            {
                $vehicle_id = $v->row();
            }
            $this->db->set('vehicle_availibility',"'Rented'",FALSE);
            $this->db->where('id',$vehicle_id->vehicle_id);
            $this->db->update('vehicle');
            
            //rate per day
            $rate_per_data = $this->getRatePerDay($rental_pickup_id);
            
            
           // rental return data
           $RentalReturnData = array(
                'rental_id'	          => $rental_pickup_id,
                'pickup_date'           => $rentalPickUpDetail['date_rental'],
                //'return_date'           => $rentalPickUpDetail['expected_return_date'],
                'return_date'           => '',
                'km_in'                 => '', 
                'km_used'               => $km_used,
                'km_extra_used'         => '',
                'km_extra_rate'         => '',
                'total_rented_days'     => $total_rent_days,
                'rate_per_day'          => $rate_per_data,
                'total_rent_charges'     => $rentalPickUpDetail['rent_amount'],
                'fuel_level'            => $rentalPickUpDetail['fuel_level'],
                'fuel_refil_charges'     => '',
                'traffic_fine'          => '',
                'additional_driver_charges' => '',
                'chauffer_charges'      => '',
                'additional_insurance'  => '',
                'pai_charges'            => '',
                'misc_charges'           => '',
                'deduction'             => '',
                'discount_type'         => 1,
                'discount'              => '',
                'invoice_no'            => $rental_pickup_id,
                'invoice_date'          => '',
                'invoice_status'        => '',
                'gps_km'                => $rentalPickUpDetail['gps_km'],
                'actual_km'             => $rentalPickUpDetail['actual_km'],
                'total_km'              => $rentalPickUpDetail['total_km'],
                'net_amount'            => $rentalPickUpDetail['rent_amount'],
            );
            $this->db->insert('rental_return',$RentalReturnData);
			return true;
		}
		
		return false;
	}
    
    public function updateRentalPickUp($rentalPickUpDetail = array(), $id)
	{	
		// rental pickup data
		$RentalPickUpData = array(
                    'branch_id'	                    => $rentalPickUpDetail['branch_id'],
                    'customer_id'                       => $rentalPickUpDetail['customer_id'],
                    'date_rental'                       => $rentalPickUpDetail['date_rental'], 
                    'vehicle_id'           => $rentalPickUpDetail['vehicle_reg_no'],
                    'rental_type'           => $rentalPickUpDetail['rental_type'],
                    'rent_amount'           => $rentalPickUpDetail['rent_amount'],
                    'deposit_amount'           => $rentalPickUpDetail['deposit_amount'],
                    'expected_return_date'           => $rentalPickUpDetail['expected_return_date'],
                    'pickup_from_place'           => $rentalPickUpDetail['pickup_from_place'],
                    'drop_off_place'           => $rentalPickUpDetail['drop_off_place'],
                    'km_allowed'           => $rentalPickUpDetail['km_allowed'],
                    'extra_km_rate'           => $rentalPickUpDetail['extra_km_rate'],
                    'km_reading_out'           => $rentalPickUpDetail['km_reading_out'],
                    //'km_reading_in'           => $rentalPickUpDetail['km_reading_in'],
                    'fuel_level'           => $rentalPickUpDetail['fuel_level'],
                    'gps_km'           => $rentalPickUpDetail['gps_km'],
                    'actual_km'           => $rentalPickUpDetail['actual_km'],
                    'total_km'           => $rentalPickUpDetail['total_km'],
            );   
		   // echo '<pre>';
		   // print_r($RentalPickUpData);exit;
           
		$this->db->where('rental_id', $id);
		if($this->db->update('rental_pickup', $RentalPickUpData)) {
                // echo $this->db->last_query();exit;
				return true;
		}
		return false;
	}
    
    public function getRentalPickUpById($id)
    {
        $q = $this->db->get_where('rental_pickup', array('rental_id' => $id), 1); 
        if( $q->num_rows() > 0 )
        {
            return $q->row();
        } 
    
        return FALSE;
    }
    
    public function getRentalPickUpByIdWithJoin($id)
    {
        $this->db->select('R.*,b.branch_name,c.en_name,v.vehicle_reg_no');
        $this->db->from('rental_pickup AS R');// I use aliasing make joins easier
        $this->db->join('branch AS b', 'b.id = R.branch_id', 'INNER');
        $this->db->join('customer AS c', 'c.id = R.customer_id', 'INNER');
        $this->db->join('vehicle AS v', 'v.id = R.vehicle_id', 'INNER');
        $this->db->where('R.rental_id',$id);
        $q = $this->db->get();
        
        
        // $q = $this->db->get_where('rental_pickup', array('rental_id' => $id), 1); 
        if( $q->num_rows() > 0 )
        {
            return $q->row();
        } 
    
        return FALSE;
    }
    
    public function deleteRentalPickUp($id)
    {
        if($this->db->delete('rental_pickup', array('rental_id' => $id))) {
            $this->db->delete('rental_return', array('rental_id' => $id));
			return true;
	    }
			
		return FALSE;
    }
    
    public function getRentAmount($vehicle_no,$rental_type)
    {
        $this->db->select('id,daily_rate,weekly_rate,month_rate');
        $this->db->from('vehicle');
        $this->db->where('id',$vehicle_no);
        $q = $this->db->get();
        
        if( $q->num_rows() > 0 )
        {
            return $q->row();
        } 
    
        return FALSE;
    }
    
    public function getPlace($branch_id)
    {
        $this->db->select('id,branch_name');
        $this->db->from('branch');
        $this->db->where('id',$branch_id);
        $q = $this->db->get();
        
        if( $q->num_rows() > 0 )
        {
            return $q->row();
        } 
    
        return FALSE;
    }
    
    public function getExtraKM($vehicle_no)
    {
        $this->db->select('id,extra_km,vehicle_type');
        $this->db->from('vehicle');
        $this->db->where('id',$vehicle_no);
        $q = $this->db->get();
        
        if( $q->num_rows() > 0 )
        {
            return $q->row();
        } 
    
        return FALSE;
    }
    
    public function last_id()
    {
        $this->db->select('rental_id');
        $this->db->from('rental_pickup');
        $q = $this->db->get();
        if( $q->num_rows() > 0 )
        {
            return $q->num_rows+1;
        }
        else
        {
            return 1;
        }

        return false;
    }
    
    public function totalRent($vehicle_no,$rental_type,$days)
    {
        if($rental_type == 'Daily')
        {
            $this->db->select('vehicle.id,vehicle.daily_rate');
            $this->db->from('vehicle');
            $this->db->where('vehicle.id',$vehicle_no);
            $q = $this->db->get();
            if($q->num_rows > 0)
            {
                return $q->row();
            }
        }
        if($rental_type == 'Weekly')
        {
            $this->db->select('vehicle.id,vehicle.weekly_rate');
            $this->db->from('vehicle');
            $this->db->where('vehicle.id',$vehicle_no);
            $q = $this->db->get();
            if($q->num_rows > 0)
            {
                return $q->row();
            }
        }
        if($rental_type == 'Monthly')
        {
            $this->db->select('vehicle.id,vehicle.month_rate');
            $this->db->from('vehicle');
            $this->db->where('vehicle.id',$vehicle_no);
            $q = $this->db->get();
            if($q->num_rows > 0)
            {
                return $q->row();
            }
        }
        return false;
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
            return $daily_rate = ($rate->weekly_rate)/7;
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
            return $daily_rate = ($rate->month_rate)/30;
        }
    }
    // agreement details
    function getAgreementDetails($id){
        $this->db->select('*');
        $this->db->from('rental_pickup');
        $this->db->join('customer','customer.id = rental_pickup.customer_id');
        $this->db->join('vehicle','vehicle.id = rental_pickup.vehicle_id');
        $this->db->where('rental_pickup.rental_id',$id);
        $q = $this->db->get();
        if($q->num_rows() > 0){
            return $q->row();
        }
        return false;
    }
    
}
?>