<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Vehicleservice_model extends CI_Model{
    function __construct()
	{
		parent::__construct();
		$this->load->library('Datatables');
        $this->load->library('table');
	}

    public function getBranch()
    {
        $this->db->select('id,branch_name');
		$branch = $this->db->get('branch');
		return $array = $branch->result_array();
    }
    
    public function getVehicle()
    {
        $this->db->select('id,vehicle_reg_no,brand');
        $this->db->where('vehicle_availibility','Available');
		$vehicle = $this->db->get('vehicle');
        return $array = $vehicle->result_array();
    }
    
    /*public function getVehicleEdit($service_no)
    {
        $this->db->select('vehicle.id,vehicle.vehicle_reg_no,vehicle.brand');
        // $this->db->where('vehicle_availibility','Available');
        $this->db->join('vehicle_service','vehicle_service.vehicle_id = vehicle.id');
        $this->db->where('vehicle_service.sevice_no',$service_no);
		$vehicle = $this->db->get();
        echo $this->db->last_query();exit;
        return $array = $vehicle->result_array();
    }*/
    
    public function getGarage()
    {
        $this->db->select('id,garage_name');
		$garage = $this->db->get('garage');
		return $array = $garage->result_array();
    }
	
	//get default branch to set
	public function getDefaultBranch()
	{
		$this->db->select('id,default_branch_id');
		$default_branch = $this->db->get('settings');
		return $array = $default_branch->result_array();
	}
    
    public function addVehicleService($vehicleServiceDetail = array())
	{	
		// vehicle service data
		$vehicleserviceData = array(
                    'branch_id'	                    => $vehicleServiceDetail['branch_id'],
                    'vehicle_id'	                => $vehicleServiceDetail['vehicle_id'],
                    'date_service'                  => $vehicleServiceDetail['date_service'],
                    'service_type'                  => $vehicleServiceDetail['service_type'],
                    'service_required'              => $vehicleServiceDetail['service_required'],
                    'km_at_service'                 => $vehicleServiceDetail['km_at_service'],
                    'voucher_date'                  => $vehicleServiceDetail['voucher_date'],
                    'garage_id'                     => $vehicleServiceDetail['garage_id'],
                    'service_done'                  => $vehicleServiceDetail['service_done'],
                    'service_amount'                => $vehicleServiceDetail['service_amount'],
                    'sparepart_dealer_charges'      => $vehicleServiceDetail['sparepart_dealer_charges'],
                    'sparepart_shop_charges'        => $vehicleServiceDetail['sparepart_shop_charges'],
                    'labour_charges'                => $vehicleServiceDetail['labour_charges'],
                    'date_serviceout'               => $vehicleServiceDetail['date_serviceout'],
                    'washing_charge'                => $vehicleServiceDetail['washing_charge'],
                    'observation'                   => $vehicleServiceDetail['observation'],
            );
            // echo '<pre>';
		   // print_r($vehicleServiceDetail);exit;
        if($this->db->insert('vehicle_service',$vehicleServiceDetail)){
            if($vehicleServiceDetail['service_done'] == 'no'){
                $this->db->where('id',$vehicleServiceDetail['vehicle_id']);
                $this->db->set('vehicle_availibility',"'Repair'",FALSE);
                $this->db->update('vehicle');
            }else{
                $this->db->where('id',$vehicleServiceDetail['vehicle_id']);
                $this->db->set('vehicle_availibility',"'Available'",FALSE);
                $this->db->update('vehicle');
            }
			return true;
		}
		
		return false;
	}
    
    public function updateVehicleService($vehicleserviceDetail = array(), $id)
	{	
		// vehicle service data
		$vehicleserviceData = array(
                    'branch_id'	                    => $vehicleserviceDetail['branch_id'],
                    'vehicle_id'	                => $vehicleserviceDetail['vehicle_id'],
                    'date_service'                  => $vehicleserviceDetail['date_service'],
                    'service_type'                  => $vehicleserviceDetail['service_type'],
                    'service_required'              => $vehicleserviceDetail['service_required'],
                    'km_at_service'                 => $vehicleserviceDetail['km_at_service'],
                    'voucher_date'                  => $vehicleserviceDetail['voucher_date'],
                    'garage_id'                     => $vehicleserviceDetail['garage_id'],
                    'service_done'                  => $vehicleserviceDetail['service_done'],
                    'service_amount'                => $vehicleserviceDetail['service_amount'],
                    'sparepart_dealer_charges'      => $vehicleserviceDetail['sparepart_dealer_charges'],
                    'sparepart_shop_charges'        => $vehicleserviceDetail['sparepart_shop_charges'],
                    'labour_charges'                => $vehicleserviceDetail['labour_charges'],
                    'date_serviceout'               => $vehicleserviceDetail['date_serviceout'],
                    'washing_charge'                => $vehicleserviceDetail['washing_charge'],
                    'observation'                   => $vehicleserviceDetail['observation'],
            );
            // echo '<pre>';
            // print_r($vehicleserviceData);exit;
           
		$this->db->where('service_no', $id);
		if($this->db->update('vehicle_service', $vehicleserviceData)) {
            if($vehicleserviceDetail['service_done'] == 'no'){
                $this->db->where('id',$vehicleServiceDetail['vehicle_id']);
                $this->db->set('vehicle_availibility',"'Repair'",FALSE);
                $this->db->update('vehicle');
            }else{
                $this->db->where('id',$vehicleServiceDetail['vehicle_id']);
                $this->db->set('vehicle_availibility',"'Available'",FALSE);
                $this->db->update('vehicle');
            }
				return true;
		}
		return false;
	}
    
    public function getVehicleServiceDetails($id)
    {
        $q = $this->db->get_where('vehicle_service', array('service_no' => $id), 1); 
        if( $q->num_rows() > 0 )
        {
            return $q->row();
        } 
    
        return FALSE;
    }
    
    public function getVehicleServiceDetailsWithJoin($id)
    {
        $this->db->select('V.*,b.branch_name,G.garage_name,V1.vehicle_reg_no,V1.brand');
        $this->db->from('vehicle_service AS V');// I use aliasing make joins easier
        $this->db->join('branch AS b', 'b.id = V.branch_id', 'INNER');
        $this->db->join('garage AS G', 'G.id = V.garage_id', 'INNER');
        $this->db->join('vehicle AS V1', 'V1.id = V.vehicle_id', 'INNER');
        $this->db->where('V.service_no',$id);
        $q = $this->db->get();
        
        
        // $q = $this->db->get_where('rental_pickup', array('rental_id' => $id), 1); 
        if( $q->num_rows() > 0 )
        {
            return $q->row();
        } 
    
        return FALSE;
    }
    
    public function deleteVehicleService($id)
    {
        if($this->db->delete('vehicle_service', array('service_no' => $id))) {
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
        $this->db->select('id,extra_km');
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
        $this->db->select('service_no');
        $this->db->from('vehicle_service');
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
}
?>