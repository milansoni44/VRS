<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Ledger_model extends CI_Model{
    
    function __construct()
	{
		parent::__construct();
		$this->load->library('Datatables');
        $this->load->library('table');
	}
    
    public function addLedger($ledgerDetail=array())
    {
        // ledger data
        $ledgerData = array(
            'branch_id'   =>  $ledgerDetail['branch_id'],
            'type'        =>  $ledgerDetail['type'],
            'title'   =>  $ledgerDetail['title'],
            'accountgroup_id'   =>  $ledgerDetail['accountgroup_id'],
            'opening_balance'          =>  $ledgerDetail['opening_balance'],
            'closing_balance'          =>  $ledgerDetail['closing_balance'],
        );
        
        // echo '<pre>';
        // print_r($ledgerData);exit;
        
        if($this->db->insert('ledger', $ledgerData)) {
			$ledger_id = $this->db->insert_id();
			return true;
		}
        return false;
    }
    
    public function getledgerWithJoin($id)
    {
        $this->db->select('L.*,B.branch_name,A.group_title');
        $this->db->from('ledger AS L');// I use aliasing make joins easier
        $this->db->join('branch AS B', 'B.id = L.branch_id', 'INNER');
        $this->db->join('account_group AS A', 'A.id = L.accountgroup_id', 'INNER');
        $this->db->where('L.id',$id);
        $q = $this->db->get();
        if( $q->num_rows() > 0 )
        {
            return $q->row();
        } 
    
        return FALSE;
    }
    
    public function getledgerById($id)
    {
        $q = $this->db->get_where('ledger', array('id' => $id), 1); 
        if( $q->num_rows() > 0 )
        {
            return $q->row();
        } 
    
        return FALSE;
    }
    
    public function updateLedger($ledgerDetail,$id)
    {
        // echo $id;exit;
        //ledger data
		$ledgerData = array(
            'branch_id'   =>  $ledgerDetail['branch_id'],
            'type'        =>  $ledgerDetail['type'],
            'title'   =>  $ledgerDetail['title'],
            'accountgroup_id'   =>  $ledgerDetail['accountgroup_id'],
            'opening_balance'          =>  $ledgerDetail['opening_balance'],
            'closing_balance'          =>  $ledgerDetail['closing_balance'],
        );
        // echo '<pre>';
        // print_r($ledgerData);exit;
		
		$this->db->where('id', $id);
		if($this->db->update('ledger', $ledgerData)) {
				return true;
		}
		return false;
    }
    
    public function getBranch()
    {
        $this->db->select('id,branch_name');
		$branch = $this->db->get('branch');
		return $array = $branch->result_array();
    }
    
    public function getAccountGroup()
    {
        $this->db->select('id,group_title');
		$acc_group = $this->db->get('account_group');
		return $array = $acc_group->result_array();
    }
    
    public function deleteLedger($id)
    {
        if($this->db->delete('ledger', array('id' => $id))) {
			return true;
	    }
			
		return FALSE;
    }
}
?>