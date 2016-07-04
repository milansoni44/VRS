<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Quotationheader_model extends CI_Model{
    
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
    
    public function getCustomer()
    {
        $this->db->select('id,en_name');
		$customer = $this->db->get('customer');
		return $array = $customer->result_array();
    }
    
    public function getQuotationHeader($id){
        $this->db->select('*');
        $this->db->from('quotation_header');
        $this->db->where('quotation_id',$id);
        $q = $this->db->get();
        
        if($q->num_rows() > 0)
        {
            return $q->row();
        }
        return false;
    }
    
    public function getQuotationHeaderDetails($id){
        $this->db->select('*');
        $this->db->from('quotation_detail');
        $this->db->where('quotation_id',$id);
        $q = $this->db->get();
        
        if($q->num_rows() > 0)
        {
            return $q->result_array();
        }
        return false;
    }
    
    public function getVehicle()
    {
        
       // $this->db->distinct();
        $this->db->select('brand');
        $this->db->from('vehicle');
        $q = $this->db->get();
        if($q->num_rows() > 0)
        {
            return $q->result_array();
        }
        return false;
    }
      public function getVehicle1()
    {
        $this->db->select('*');
        $this->db->from('vehicle');
        $q = $this->db->get();
        if($q->num_rows() > 0)
        {
            return $q->result_array();
        }
        return false;
       
    }
    
    public function getVehicleId()
    {
        //$this->db->distinct();
        $this->db->select('id');
        $this->db->from('vehicle');
        $q = $this->db->get();
        if($q->num_rows() > 0)
        {
            return $q->result_array();
        }
        return false;
    }
    
    public function getVehicleRegNo()
    {
        //$this->db->distinct();
        $this->db->select('vehicle_reg_no');
        $this->db->from('vehicle');
        $q = $this->db->get();
        if($q->num_rows() > 0)
        {
            return $q->result_array();
        }
        return false;
    }
    
    public function getVehicleData($vehicle_id){
        $this->db->select('*');
        $this->db->from('vehicle');
        $this->db->where('id',$vehicle_id);
        $q = $this->db->get();
        if($q->num_rows() > 0){
            return $q->row();
        }
        return false;
    }
    
    public function addQuotationDetail($quotationHeader = array(),$quotationDetails = array()){
        //quotation header data
        $quotationData = array(
            'branch_id'               => $quotationHeader['branch_id'],
            'customer_id'             => $quotationHeader['customer_id'],
            'quotation_date'          => $quotationHeader['quotation_date'],
            'validity_upto'           => $quotationHeader['validity_upto'],
            'status'                  => $quotationHeader['status'],
        );
        // echo '<pre>';
        // print_r($quotationData);exit;
        if($this->db->insert('quotation_header', $quotationData)){
            $quotationHeaderID = $this->db->insert_id();
            
            $addOn = array('quotation_id' => $quotationHeaderID);
					end($addOn);
					foreach ( $quotationDetails as &$var ) {
						$var = array_merge($addOn, $var);
			}
				
			if($this->db->insert_batch('quotation_detail', $quotationDetails)) {
				return true;
			}
        }
    }
    
    public function updateQuotationHeader($quotationHeader = array(),$quotationDetails = array(),$quotation_id)
    {
        //quotation header data
        $quotationData = array(
            'branch_id'                 => $quotationHeader['branch_id'],
            'customer_id'               => $quotationHeader['customer_id'],
            'quotation_date'            => $quotationHeader['quotation_date'],
            'validity_upto'             => $quotationHeader['validity_upto'],
            'status'                    => $quotationHeader['status'],
        );
        
        $this->db->where('quotation_id', $quotation_id);
        if($this->db->update('quotation_header', $quotationData) && $this->db->delete('quotation_detail', array('quotation_id' => $quotation_id))){
            
            $addOn = array('quotation_id' => $quotation_id);
                end($addOn);
                foreach ( $quotationDetails as &$var ) {
                        $var = array_merge($addOn, $var);
                }
        
        
            if($this->db->insert_batch('quotation_detail', $quotationDetails)) {
                return true;
            }
        }
    }
    public function getQuotationHeaderWithJoin($id){
        $this->db->select('quotation_header.*,customer.en_name,branch.branch_name');
        $this->db->from('quotation_header');
        $this->db->join('customer','customer.id = quotation_header.customer_id');
        $this->db->join('branch','branch.id = quotation_header.branch_id');
        $this->db->where('quotation_id',$id);
        $q = $this->db->get();
        
        if($q->num_rows() > 0)
        {
            return $q->row();
        }
        return false;
    }
    
    function getQuotation($id){
        $this->db->select('quotation_header.quotation_id,quotation_header.customer_id,quotation_header.quotation_date,customer.en_name,customer.en_local_address,customer.en_nationality_code,customer.en_company_name');
        $this->db->from('quotation_header');
        $this->db->join('quotation_detail','quotation_detail.quotation_id = quotation_header.quotation_id');
        $this->db->join('customer','customer.id = quotation_header.customer_id');
        $this->db->where('quotation_header.quotation_id',$id);
        $q = $this->db->get();
        // echo $this->db->last_query();
        if($q->num_rows() > 0){
            return $q->row();
        }
        return false;
    }
    //get quotatation details by quotation_id
    function getQuotationDetails($id){
        $this->db->select('vehicle.brand,quotation_detail.quotation_id,quotation_detail.engine_capacity,quotation_detail.model_year,quotation_detail.daily_rate,quotation_detail.weekly_rate,quotation_detail.monthly_rate,quotation_detail.insurance_type,quotation_detail.breakdown_recovery');
        $this->db->from('quotation_detail');
        $this->db->join('quotation_header','quotation_header.quotation_id = quotation_detail.quotation_id');
        $this->db->join('vehicle','vehicle.id = quotation_detail.vehicle_id');
        $this->db->where('quotation_detail.quotation_id',$id);
        $q = $this->db->get();
        // echo $this->db->last_query();
        if($q->num_rows() > 0){
            return $q->result_array();
        }
        return false;
    }
}