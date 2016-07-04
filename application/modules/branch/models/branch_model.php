<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Branch_model extends CI_Model{
    
    function __construct()
	{
		parent::__construct();
		$this->load->library('Datatables');
        $this->load->library('table');
	}
    
    public function addBranch($branchDetail=array())
    {
        // branch data
        $branchData = array(
            'branch_name'   =>  $branchDetail['branch_name'],
            'po_box'        =>  $branchDetail['po_box'],
            'postal_code'   =>  $branchDetail['postal_code'],
            'city'          =>  $branchDetail['city'],
            'telephone'     =>  $branchDetail['telephone'],
            'mobile'        =>  $branchDetail['mobile'],
            'email'         =>  $branchDetail['email'],
            'incharge'      =>  $branchDetail['incharge']
        );
        
        /*echo '<pre>';
        print_r($branchData);exit;*/
        
        if($this->db->insert('branch', $branchData)) {
			$branch_id = $this->db->insert_id();
			return true;
		}
        return false;
    }
    
    public function getBranchById($id)
    {
        $q = $this->db->get_where('branch', array('id' => $id), 1); 
        if( $q->num_rows() > 0 )
        {
            return $q->row();
        } 
    
        return FALSE;
    }
    
    public function updateBranch($branchDetail,$id)
    {
        //echo $id;exit;
        //branch data
		$branchData = array(
			'branch_name'   =>  $branchDetail['branch_name'],
            'po_box'        =>  $branchDetail['po_box'],
            'postal_code'   =>  $branchDetail['postal_code'],
            'city'          =>  $branchDetail['city'],
            'telephone'     =>  $branchDetail['telephone'],
            'mobile'        =>  $branchDetail['mobile'],
            'email'         =>  $branchDetail['email'],
            'incharge'      =>  $branchDetail['incharge']
		);
        /*echo '<pre>';
        print_r($branchData);exit;*/
		
		$this->db->where('id', $id);
		if($this->db->update('branch', $branchData)) {
				return true;
		}
		return false;
    }
    
    public function deleteBranch($id)
    {
        if($this->db->delete('branch', array('id' => $id))) {
			return true;
	    }
			
		return FALSE;
    }
}
?>