<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Customer_model extends CI_Model{
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
    
    public function addCustomer($customerDetail = array())
	{	
		// customer data
		$customerData = array(
                    'branch_id'	                    => $customerDetail['branch_id'],
                    'en_name'                       => $customerDetail['en_name'],
                    'ar_name'                       => $customerDetail['ar_name'], 
                    'en_nationality_code'           => $customerDetail['en_nationality_code'],
                    'ar_nationality_code'           => $customerDetail['ar_nationality_code'],
                    'en_passport_no'                => $customerDetail['en_passport_no'],
                    'ar_passport_no'                => $customerDetail['ar_passport_no'],
                    'en_place_issue'                => $customerDetail['en_place_issue'],    
                    'ar_place_issue'                => $customerDetail['ar_place_issue'],    
                    'en_date_issue'                 => $customerDetail['en_date_issue'],    
                    'ar_date_issue'                 => $customerDetail['ar_date_issue'],
                    'en_date_expiry'                => $customerDetail['en_date_expiry'],
                    'ar_date_expiry'                => $customerDetail['ar_date_expiry'],
                    'en_national_id'                => $customerDetail['en_national_id'],
                    'ar_national_id'                => $customerDetail['ar_national_id'],
                    'en_id_date_expiry'             => $customerDetail['en_id_date_expiry'],
                    'ar_id_date_expiry'             => $customerDetail['ar_id_date_expiry'],
                    'en_local_address'              => $customerDetail['en_local_address'],
                    'ar_local_address'              => $customerDetail['ar_local_address'],
                    'en_company_name'               => $customerDetail['en_company_name'],
                    'ar_company_name'               => $customerDetail['ar_company_name'],
                    'en_mailing_address'            => $customerDetail['en_mailing_address'],
                    'ar_mailing_address'            => $customerDetail['ar_mailing_address'],
                    'passport_img'                  => $customerDetail['passport_img'],
                    'national_id_img'               => $customerDetail['national_id_img'],
                    'driving_licence_img'           => $customerDetail['driving_licence_img'],
                    'customer_img'                  => $customerDetail['customer_img'],
                    'telephone'                     => $customerDetail['telephone'],
                    'mobile_no'                     => $customerDetail['mobile_no'],
                    'email'                         => $customerDetail['email'],
                    'reference_person_name'         => $customerDetail['reference_person_name'],    
                    'reference_person_mobile'       => $customerDetail['reference_person_mobile'],
                    'reference_source_field'        => $customerDetail['reference_source_field'],
            );   
		   // echo '<pre>';
		   // print_r($customerData);exit;
		if($this->db->insert('customer', $customerData)) {
			$customer_id = $this->db->insert_id();
			return true;
		}
		
		return false;
	}
    
    public function updateCustomer($customerDetail = array(), $id)
	{	
		// customer data
		$customerData = array(
                    'branch_id'	                    => $customerDetail['branch_id'],
                    'en_name'                       => $customerDetail['en_name'],
                    'ar_name'                       => $customerDetail['ar_name'], 
                    'en_nationality_code'           => $customerDetail['en_nationality_code'],
                    'ar_nationality_code'           => $customerDetail['ar_nationality_code'],
                    'en_passport_no'                => $customerDetail['en_passport_no'],
                    'ar_passport_no'                => $customerDetail['ar_passport_no'],
                    'en_place_issue'                => $customerDetail['en_place_issue'],    
                    'ar_place_issue'                => $customerDetail['ar_place_issue'],    
                    'en_date_issue'                 => $customerDetail['en_date_issue'],    
                    'ar_date_issue'                 => $customerDetail['ar_date_issue'],
                    'en_date_expiry'                => $customerDetail['en_date_expiry'],
                    'ar_date_expiry'                => $customerDetail['ar_date_expiry'],
                    'en_national_id'                => $customerDetail['en_national_id'],
                    'ar_national_id'                => $customerDetail['ar_national_id'],
                    'en_id_date_expiry'             => $customerDetail['en_id_date_expiry'],
                    'ar_id_date_expiry'             => $customerDetail['ar_id_date_expiry'],
                    'en_local_address'              => $customerDetail['en_local_address'],
                    'ar_local_address'              => $customerDetail['ar_local_address'],
                    'en_company_name'               => $customerDetail['en_company_name'],
                    'ar_company_name'               => $customerDetail['ar_company_name'],
                    'en_mailing_address'            => $customerDetail['en_mailing_address'],
                    'ar_mailing_address'            => $customerDetail['ar_mailing_address'],
                    'passport_img'                  => $customerDetail['passport_img'],
                    'national_id_img'               => $customerDetail['national_id_img'],
                    'driving_licence_img'           => $customerDetail['driving_licence_img'],
                    'customer_img'                  => $customerDetail['customer_img'],
                    'telephone'                     => $customerDetail['telephone'],
                    'mobile_no'                     => $customerDetail['mobile_no'],
                    'email'                         => $customerDetail['email'],
                    'reference_person_name'         => $customerDetail['reference_person_name'],    
                    'reference_person_mobile'       => $customerDetail['reference_person_mobile'],
                    'reference_source_field'        => $customerDetail['reference_source_field'],
            );   
		   // echo '<pre>';
		   // print_r($customerData);exit;
           
		$this->db->where('id', $id);
		if($this->db->update('customer', $customerData)) {
                // echo $this->db->last_query();exit;
				return true;
		}
		return false;
	}
    
    public function getCustomerById($id)
    {
        $q = $this->db->get_where('customer', array('id' => $id), 1); 
        if( $q->num_rows() > 0 )
        {
            return $q->row();
        } 
    
        return FALSE;
    }
    
    public function deleteCustomer($id)
    {
        if($this->db->delete('customer', array('id' => $id))) {
			return true;
	    }
			
		return FALSE;
    }
}
?>