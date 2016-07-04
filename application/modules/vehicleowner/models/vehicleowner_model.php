<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Vehicleowner_model extends CI_Model{
    
    function __construct()
	{
		parent::__construct();
		$this->load->library('Datatables');
        $this->load->library('table');
	}
    
    public function addVehicleOwner($vehicleOwnerDetail=array())
    {
        // vehicle owner data
        $vehicleOwnerData = array(
            'company_abbrev'   =>  $vehicleOwnerDetail['company_abbrev'],
            'company_name'        =>  $vehicleOwnerDetail['company_name'],
            'name'   =>  $vehicleOwnerDetail['name'],
            'mobile_no'          =>  $vehicleOwnerDetail['mobile_no'],
            'email'     =>  $vehicleOwnerDetail['email'],
        );
        
        /*echo '<pre>';
        print_r($vehicleOwnerData);exit;*/
        
        if($this->db->insert('vehicle_owner', $vehicleOwnerData)) {
			$owner_id = $this->db->insert_id();
			return true;
		}
        return false;
    }
    
    public function getOwnerById($id)
    {
        $q = $this->db->get_where('vehicle_owner', array('id' => $id), 1); 
        if( $q->num_rows() > 0 )
        {
            return $q->row();
        } 
    
        return FALSE;
    }
    
    public function updateVehicleOwner($vehicleOwnerDetail,$id)
    {
        //echo $id;exit;
        //vehicle owner data
		$ownerData = array(
			'company_abbrev'   =>  $vehicleOwnerDetail['company_abbrev'],
            'company_name'        =>  $vehicleOwnerDetail['company_name'],
            'name'   =>  $vehicleOwnerDetail['name'],
            'mobile_no'          =>  $vehicleOwnerDetail['mobile_no'],
            'email'        =>  $vehicleOwnerDetail['email'],
        );
        /*echo '<pre>';
        print_r($ownerData);exit;*/
		
		$this->db->where('id', $id);
		if($this->db->update('vehicle_owner', $ownerData)) {
				return true;
		}
		return false;
    }
    
    public function deleteOwner($id)
    {
        if($this->db->delete('vehicle_owner', array('id' => $id))) {
			return true;
	    }
			
		return FALSE;
    }
}
?>