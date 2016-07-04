<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Vehicle_model extends CI_Model{
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
    
    public function getBrand()
    {
        $this->db->distinct('brand');
        $this->db->select('brand,id');
        $this->db->group_by('brand');
		$brand = $this->db->get('vehicle');
        //echo $this->db->last_query();exit;
		return $array = $brand->result_array();
    }
    
    public function getOwner()
    {
        $this->db->select('id,name');
		$vehicle_owner = $this->db->get('vehicle_owner');
		return $array = $vehicle_owner->result_array();
    }
    
    //get default branch to set
	public function getDefaultBranch()
	{
		$this->db->select('*');
		$default_branch = $this->db->get('settings');
		return $array = $default_branch->result_array();
	}
    
    public function getVehicleByIdWithJoin($id)
    {
        $this->db->select('v.*,b.branch_name,v1.name');
        $this->db->from('vehicle AS v');// I use aliasing make joins easier
        $this->db->join('branch AS b', 'b.id = v.branch_id', 'INNER');
        $this->db->join('vehicle_owner AS v1', 'v1.id = v.owner_id', 'INNER');
        $this->db->where('v.id',$id);
        $q = $this->db->get();
        if( $q->num_rows() > 0 )
        {
            return $q->row();
        } 
    
        return FALSE;
    }
    
    public function addVehicle($vehicleDetail = array())
	{	
		// vehicle data
		$vehicleData = array(
			'branch_id'    => $vehicleDetail['branch_id'],
            'vehicle_reg_no'    => $vehicleDetail['vehicle_reg_no'],
            'owner_id'    => $vehicleDetail['owner'],
            'finance_company'    => $vehicleDetail['finance_company'],
            'brand'    => $vehicleDetail['brand'],
            'trans_type'    => $vehicleDetail['trans_type'],
            'vehicle_type'    => $vehicleDetail['vehicle_type'],
            'model'    => $vehicleDetail['model'],
            'model_year'    => $vehicleDetail['model_year'],
            'reg_expiry_date'    => $vehicleDetail['reg_expiry_date'],
            'insurance_type'    => $vehicleDetail['insurance_type'],
            'breakdown_recovery'    => $vehicleDetail['breakdown_recovery'],
            'insurance_company'    => $vehicleDetail['insurance_company'],
            'insurance_expiry_date'    => $vehicleDetail['insurance_exp_date'],
            'vehicle_availibility'    => $vehicleDetail['vehicle_avail_status'],
            'image'    => $vehicleDetail['image'],
            'seating_capacity'    => $vehicleDetail['seating_capacity'],
            'engine_capacity'    => $vehicleDetail['engine_capacity'],
            'daily_rate'    => $vehicleDetail['daily_rate'],
            'weekly_rate'    => $vehicleDetail['weekly_rate'],
            'month_rate'    => $vehicleDetail['month_rate'],
            'extra_km'    => $vehicleDetail['extra_km'],
            'vehicle_cost'    => $vehicleDetail['vehicle_cost'],
            'gps_id'    => $vehicleDetail['gps_id'],
            'date_fleet_inclusion'    => $vehicleDetail['date_fleet_inclusion'],
            'fuel_type'    => $vehicleDetail['fuel_type'],
            'remarks'    => $vehicleDetail['remarks'],
        );
		   // echo '<pre>';
		   // print_r($vehicleData);exit;
		if($this->db->insert('vehicle', $vehicleData)) {
			$vehicle_id = $this->db->insert_id();
			return true;
		}
		
		return false;
	}
    
    public function updateVehicle($vehicleDetail = array(), $id)
	{	
		// vehicle data
		$vehicleData = array(
			'branch_id'    => $vehicleDetail['branch_id'],
            'vehicle_reg_no'    => $vehicleDetail['vehicle_reg_no'],
            'owner_id'    => $vehicleDetail['owner'],
            'finance_company'    => $vehicleDetail['finance_company'],
            'brand'    => $vehicleDetail['brand'],
            'trans_type'    => $vehicleDetail['trans_type'],
            'vehicle_type'    => $vehicleDetail['vehicle_type'],
            'model'    => $vehicleDetail['model'],
            'model_year'    => $vehicleDetail['model_year'],
            'reg_expiry_date'    => $vehicleDetail['reg_expiry_date'],
            'insurance_type'    => $vehicleDetail['insurance_type'],
            'breakdown_recovery'    => $vehicleDetail['breakdown_recovery'],
            'insurance_company'    => $vehicleDetail['insurance_company'],
            'insurance_expiry_date'    => $vehicleDetail['insurance_exp_date'],
            'vehicle_availibility'    => $vehicleDetail['vehicle_avail_status'],
            'image'    => $vehicleDetail['image'],
            'seating_capacity'    => $vehicleDetail['seating_capacity'],
            'engine_capacity'    => $vehicleDetail['engine_capacity'],
            'daily_rate'    => $vehicleDetail['daily_rate'],
            'weekly_rate'    => $vehicleDetail['weekly_rate'],
            'month_rate'    => $vehicleDetail['month_rate'],
            'extra_km'    => $vehicleDetail['extra_km'],
            'vehicle_cost'    => $vehicleDetail['vehicle_cost'],
            'gps_id'    => $vehicleDetail['gps_id'],
            'date_fleet_inclusion'    => $vehicleDetail['date_fleet_inclusion'],
            'fuel_type'    => $vehicleDetail['fuel_type'],
            'remarks'    => $vehicleDetail['remarks'],
        );
		   // echo '<pre>';
		   // print_r($vehicleData);exit;
		$this->db->where('id', $id);
		if($this->db->update('vehicle', $vehicleData)) {
				return true;
		}
		return false;
	}
    
    public function getVehicleById($id)
    {
        $q = $this->db->get_where('vehicle', array('id' => $id), 1); 
        if( $q->num_rows() > 0 )
        {
            return $q->row();
        } 
    
        return FALSE;
    }
    
    public function deleteVehicle($id)
    {
        if($this->db->delete('vehicle', array('id' => $id))) {
			return true;
	    }
			
		return FALSE;
    }
}
?>