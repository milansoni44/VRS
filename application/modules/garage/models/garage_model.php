<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Garage_model extends CI_Model{
    
    function __construct()
	{
		parent::__construct();
		$this->load->library('Datatables');
        $this->load->library('table');
	}
    
    public function addGarage($garageDetail=array())
    {
        // garage data
        $garageData = array(
            'branch_id'         =>  $garageDetail['branch_id'],
            'garage_name'       =>  $garageDetail['garage_name'],
            'location'          =>  $garageDetail['location'],
            'telephone'         =>  $garageDetail['telephone'],
            'mobile_no'         =>  $garageDetail['mobile_no'],
            'email'             =>  $garageDetail['email'],
            'contact_person'    =>  $garageDetail['contact_person']
        );
        
        /*echo '<pre>';
        print_r($garageData);exit;*/
        
        if($this->db->insert('garage', $garageData)) {
			$garage_id = $this->db->insert_id();
			return true;
		}
        return false;
    }
    
    public function getGarageById($id)
    {
        $q = $this->db->get_where('garage', array('id' => $id), 1); 
        if( $q->num_rows() > 0 )
        {
            return $q->row();
        } 
    
        return FALSE;
    }
    
    public function getGarageByIdwithBranch($id)
    {
        $this->db->select('G.*,B.branch_name');
        $this->db->from('garage AS G');// I use aliasing make joins easier
        $this->db->join('branch AS B', 'B.id = G.branch_id', 'INNER');
        $this->db->where('G.id',$id);
        $q = $this->db->get();
        if( $q->num_rows() > 0 )
        {
            return $q->row();
        } 
    
        return FALSE;
    }
    
    public function updateGarage($garageDetail,$id)
    {
        //echo $id;exit;
        //garage data
		$garageData = array(
            'branch_id'         =>  $garageDetail['branch_id'],
            'garage_name'       =>  $garageDetail['garage_name'],
            'location'          =>  $garageDetail['location'],
            'telephone'         =>  $garageDetail['telephone'],
            'mobile_no'         =>  $garageDetail['mobile_no'],
            'email'             =>  $garageDetail['email'],
            'contact_person'    =>  $garageDetail['contact_person']
        );
        /*echo '<pre>';
        print_r($garageData);exit;*/
		
		$this->db->where('id', $id);
		if($this->db->update('garage', $garageData)) {
				return true;
		}
		return false;
    }
    
    public function deletegarage($id)
    {
        if($this->db->delete('garage', array('id' => $id))) {
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
}
?>