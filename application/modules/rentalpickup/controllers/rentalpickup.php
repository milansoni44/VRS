<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Rentalpickup extends CI_Controller
{
    function __construct()
	{
		parent::__construct();
		
		// check if user logged in 
		if (!$this->ion_auth->logged_in())
	  	{
			redirect('auth/login');
	  	}
		$this->load->library('form_validation');
		$this->load->library('Ion_auth');
		$this->security->csrf_verify(); 
		$this->load->model('rentalpickup_model');
        $this->load->library('upload');
		$this->load->library('Datatables');
	}

    function index()
    {
        if (!$this->ion_auth->logged_in())
	  	{
			redirect('auth/login');
	  	}
        $meta['page_title'] = 'Rental Pickup Details';
		$data['page_title'] = "Rental Pickup details";
		$this->load->view('commons/header',$meta);
		$this->load->view('index',$data);
		$this->load->view('commons/footer');
    }
    
    function rental_pickup_details()
    {
        $this->datatables->select("rental_pickup_view.rental_id,date_rental,customer.en_name,vehicle.vehicle_reg_no,rental_type,expected_return_date,rental_return_view.return_date,km_extra_rate,total_rent_charges,discount,net_amount")
        ->from('rental_pickup_view')
		->join('customer','customer.id=rental_pickup_view.customer_id')
		->join('vehicle','vehicle.id=rental_pickup_view.vehicle_id')
		->join('rental_return_view','rental_return_view.rental_id = rental_pickup_view.rental_id')
		->add_column("Actions", "<a href='rentalpickup/view/$1'><i class='fa fa-eye'></i></a> &nbsp; <a href='rentalpickup/edit/$1'><i class='fa fa-pencil-square-o'></i></a> &nbsp; <a href='rentalpickup/delete/$1' onclick=\"return confirm('Are you sure you want to delete?');\"><i class='fa fa-trash-o'></i></a> &nbsp; <a href='rentalpickup/print_agreement/$1'>Print</i></a> &nbsp; <a href='rentalreturn/edit/$1'><i class='fa fa-plus-square'></i></a>", "rental_pickup_view.rental_id");
		
        echo $this->datatables->generate();
    }
    
    function print_agreement($rental_pickup_id){
        
        $data['agreement'] = $this->rentalpickup_model->getAgreementDetails($rental_pickup_id);
        // $data['previous_rental'] = $this->rentalpickup_model->getPreviousRental($rental_pickup_id);
        // echo '<pre>';
        // print_r($data['agreement']);exit;
        $this->load->view('rental_agreement',$data);
    }
    
    function view($rental_pickup_id)
    {
        $rentalPickUpDetail = $this->rentalpickup_model->getRentalPickUpByIdWithJoin($rental_pickup_id);
        // echo '<pre>';
        // print_r($rentalPickUpDetail);exit;
        $data['rental_pickup'] = $rentalPickUpDetail;
        $data['id'] = $rental_pickup_id;
        $data['vehicle'] = $this->rentalpickup_model->getVehicle();
        $data['branch'] = $this->rentalpickup_model->getBranch();
        $data['customer'] = $this->rentalpickup_model->getCustomer();
        $meta['page_title'] = 'View Rental PickUp';
        $data['page_title'] = "View Rental PickUp";
        $this->load->view('commons/header', $meta);
        $this->load->view('view', $data);
        $this->load->view('commons/footer');
    }
    
    function add()
    {
        // //rental pickup form validation
        // /* ==============VALIDATION FOR SELECTBOX AGENT ================ */
        $this->form_validation->set_rules('branch','Branch','required|callback_check_default');
        $this->form_validation->set_message('check_default', 'You need to select branch other than the default.');
        
        $this->form_validation->set_rules('date_rental', 'Date Of Rental', 'trim|xss_clean');
        /* -------VALIDATION FOR CUSTOMER-------*/
        $this->form_validation->set_rules('customer','Customer','required|callback_check_default_customer');
        $this->form_validation->set_message('check_default_customer', 'You need to select customer other than the default.');
        
        /* -------VALIDATION FOR VEHICLE NO-------*/
        $this->form_validation->set_rules('vehicle_no','Vehicle Number','required|callback_check_default_vehicle_no');
        $this->form_validation->set_message('check_default_vehicle_no', 'You need to select vehicle number other than the default.');
        
        $this->form_validation->set_rules('rental_type', 'Rental Type', 'trim|xss_clean');
        $this->form_validation->set_rules('deposit_amount', 'Deposit Amount', 'trim|xss_clean');
        $this->form_validation->set_rules('rent_amount', 'Rent Amount', 'trim|xss_clean');
        $this->form_validation->set_rules('expected_return_date', 'Expected Return Date', 'trim|xss_clean');
        $this->form_validation->set_rules('pickup_from_place', 'Pick Up From Place', 'trim|xss_clean');
        $this->form_validation->set_rules('drop_off_place', 'Drop Off Place', 'trim|xss_clean');
        $this->form_validation->set_rules('km_allowed', 'Kilometre Allowed', 'trim|xss_clean');
        $this->form_validation->set_rules('extra_km_rate', 'Extra Km Rate', 'trim|xss_clean');
        $this->form_validation->set_rules('km_reading_out', 'Km Reading Out', 'trim|xss_clean');
        //$this->form_validation->set_rules('km_reading_in', 'Km Reading In', 'trim|xss_clean');
        $this->form_validation->set_rules('fuel_level', 'Fuel Level', 'trim|xss_clean');
        
        $this->form_validation->set_rules('gps_km', 'GPS Km', 'trim|xss_clean');
        $this->form_validation->set_rules('actual_km', 'Actual Km', 'trim|xss_clean');
        $this->form_validation->set_rules('total_km', 'Total Km', 'trim|xss_clean');
        
        if ($this->form_validation->run() == true)
        {
            $rentalPickUpDetail = array(
                    'branch_id'	        =>	$this->input->post('branch'),
                    'customer_id'	        =>	$this->input->post('customer'),
                    'date_rental'	        =>	$this->input->post('date_rental'),
                    'vehicle_reg_no'	        =>	$this->input->post('vehicle_no'),
                    'rental_type'	        =>	$this->input->post('rental_type'),
                    'rent_amount'	        =>	$this->input->post('rent_amount'),
                    'deposit_amount'	        =>	$this->input->post('deposit_amount'),
                    'expected_return_date'	        =>	$this->input->post('expected_return_date'),
                    'pickup_from_place'	        =>	$this->input->post('pickup_from_place'),
                    'drop_off_place'	        =>	$this->input->post('drop_off_place'),
                    'km_allowed'	        =>	$this->input->post('km_allowed'),
                    'extra_km_rate'	        =>	$this->input->post('extra_km_rate'),
                    'km_reading_out'	        =>	$this->input->post('km_reading_out'),
                    //'km_reading_in'	        =>	$this->input->post('km_reading_in'),
                    'fuel_level'	        =>	$this->input->post('fuel_level'),
                    'gps_km'	        =>	$this->input->post('gps_km'),
                    'actual_km'	        =>	$this->input->post('actual_km'),
                    'total_km'	        =>	$this->input->post('total_km'),
                );
                // echo '<pre>';
                // print_r($rentalPickUpDetail);exit;
        }
        
        if ( ($this->form_validation->run() == true) && $this->rentalpickup_model->addRentalPickUp($rentalPickUpDetail))
		{  
			$this->session->set_flashdata('success', 'Rental PickUp added successfully.');
			redirect("rentalpickup",'refresh');
		}
		else
		{  
            $data['vehicle'] = $this->rentalpickup_model->getVehicle();
            // echo '<pre>';
            // print_r($data['vehicle']);exit;
            $data['branch'] = $this->rentalpickup_model->getBranch();
			$data['default_branch'] = $this->rentalpickup_model->getDefaultBranch();
            $data['customer'] = $this->rentalpickup_model->getCustomer();
            $data['last_id'] = $this->rentalpickup_model->last_id();
            //echo '<pre>';
            //print_r($data['default_branch']);exit;
            $meta['page_title'] = 'Add Rental PickUp';
            $data['page_title'] = "Add Rental PickUp";
            $this->load->view('commons/header', $meta);
            $this->load->view('add', $data);
            $this->load->view('commons/footer');
		}
    }
    
    function edit($rental_pickup_id)
    {
        $id = $rental_pickup_id;
        
        if($post = $this->input->post())
        {
            // //rental pickup form validation
            // /* ==============VALIDATION FOR SELECTBOX AGENT ================ */
            $this->form_validation->set_rules('branch','Branch','required|callback_check_default');
            $this->form_validation->set_message('check_default', 'You need to select branch other than the default.');
            
            $this->form_validation->set_rules('date_rental', 'Date Of Rental', 'trim|xss_clean');
            /* -------VALIDATION FOR CUSTOMER-------*/
            $this->form_validation->set_rules('customer','Customer','required|callback_check_default_customer');
            $this->form_validation->set_message('check_default_customer', 'You need to select customer other than the default.');
            
            /* -------VALIDATION FOR VEHICLE NO-------*/
            $this->form_validation->set_rules('vehicle_no','Vehicle Number','required|callback_check_default_vehicle_no');
            $this->form_validation->set_message('check_default_vehicle_no', 'You need to select vehicle number other than the default.');
            
            $this->form_validation->set_rules('rental_type', 'Rental Type', 'trim|xss_clean');
            $this->form_validation->set_rules('deposit_amount', 'Deposit Amount', 'trim|xss_clean');
            $this->form_validation->set_rules('rent_amount', 'Rent Amount', 'trim|xss_clean');
            $this->form_validation->set_rules('expected_return_date', 'Expected Return Date', 'trim|xss_clean');
            $this->form_validation->set_rules('pickup_from_place', 'Pick Up From Place', 'trim|xss_clean');
            $this->form_validation->set_rules('drop_off_place', 'Drop Off Place', 'trim|xss_clean');
            $this->form_validation->set_rules('km_allowed', 'Kilometre Allowed', 'trim|xss_clean');
            $this->form_validation->set_rules('extra_km_rate', 'Extra Km Rate', 'trim|xss_clean');
            $this->form_validation->set_rules('km_reading_out', 'Km Reading Out', 'trim|xss_clean');
            //$this->form_validation->set_rules('km_reading_in', 'Km Reading In', 'trim|xss_clean');
            $this->form_validation->set_rules('fuel_level', 'Fuel Level', 'trim|xss_clean');
            
            $this->form_validation->set_rules('gps_km', 'GPS Km', 'trim|xss_clean');
            $this->form_validation->set_rules('actual_km', 'Actual Km', 'trim|xss_clean');
            $this->form_validation->set_rules('total_km', 'Total Km', 'trim|xss_clean');
        
            if ($this->form_validation->run() == true)
            {
                $rentalPickUpDetail = array(
                    'branch_id'	        =>	$this->input->post('branch'),
                    'customer_id'	        =>	$this->input->post('customer'),
                    'date_rental'	        =>	$this->input->post('date_rental'),
                    'vehicle_reg_no'	        =>	$this->input->post('vehicle_no'),
                    'rental_type'	        =>	$this->input->post('rental_type'),
                    'rent_amount'	        =>	$this->input->post('rent_amount'),
                    'deposit_amount'	        =>	$this->input->post('deposit_amount'),
                    'expected_return_date'	        =>	$this->input->post('expected_return_date'),
                    'pickup_from_place'	        =>	$this->input->post('pickup_from_place'),
                    'drop_off_place'	        =>	$this->input->post('drop_off_place'),
                    'km_allowed'	        =>	$this->input->post('km_allowed'),
                    'extra_km_rate'	        =>	$this->input->post('extra_km_rate'),
                    'km_reading_out'	        =>	$this->input->post('km_reading_out'),
                    //'km_reading_in'	        =>	$this->input->post('km_reading_in'),
                    'fuel_level'	        =>	$this->input->post('fuel_level'),
                    'gps_km'	        =>	$this->input->post('gps_km'),
                    'actual_km'	        =>	$this->input->post('actual_km'),
                    'total_km'	        =>	$this->input->post('total_km'),
                );
                // echo '<pre>';
                // print_r($rentalPickUpDetail);exit;
            }
            
            if ( ($this->form_validation->run() == true) && $this->rentalpickup_model->updateRentalPickUp($rentalPickUpDetail,$rental_pickup_id))
            {  
                $this->session->set_flashdata('success', 'Rental PickUp edited successfully.');
                redirect("rentalpickup",'refresh');
            }
            else
            {  
                $rentalPickUpDetail = $this->rentalpickup_model->getRentalPickUpById($rental_pickup_id);
                // echo '<pre>';
                // print_r($rentalPickUpDetail);exit;
                $data['rental_pickup'] = $rentalPickUpDetail;
                $data['id'] = $rental_pickup_id;
                $data['vehicle'] = $this->rentalpickup_model->getVehicleEdit();
                // echo '<pre>';
                // print_r($data['vehicle']);exit;
                $data['branch'] = $this->rentalpickup_model->getBranch();
                $data['customer'] = $this->rentalpickup_model->getCustomer();
                $meta['page_title'] = 'Edit Rental PickUp';
                $data['page_title'] = "Edit Rental PickUp";
                $this->load->view('commons/header', $meta);
                $this->load->view('edit', $data);
                $this->load->view('commons/footer');
            
            }
        }
        else
        {
            $rentalPickUpDetail = $this->rentalpickup_model->getRentalPickUpById($rental_pickup_id);
            // echo '<pre>';
            // print_r($rentalPickUpDetail);exit;
            $data['rental_pickup'] = $rentalPickUpDetail;
            $data['id'] = $rental_pickup_id;
            $data['vehicle'] = $this->rentalpickup_model->getVehicleEdit($rental_pickup_id);
            // echo '<pre>';
            // print_r($data['vehicle']);exit;
            $data['branch'] = $this->rentalpickup_model->getBranch();
            $data['customer'] = $this->rentalpickup_model->getCustomer();
            $meta['page_title'] = 'Edit Rental PickUp';
            $data['page_title'] = "Edit Rental PickUp";
            $this->load->view('commons/header', $meta);
            $this->load->view('edit', $data);
            $this->load->view('commons/footer');
        }
        	
	}

    /* =====================VALIDATION FOR Branch ======================== */
    function check_default($post_string)
    {
        return $post_string == '0' ? FALSE : TRUE;
    }
    
    /* =====================VALIDATION FOR Customer ======================== */
    function check_default_customer($post_string)
    {
        return $post_string == '0' ? FALSE : TRUE;
    }
    
    /* =====================VALIDATION FOR Vehicle No ======================== */
    function check_default_vehicle_no($post_string)
    {
        return $post_string == '0' ? FALSE : TRUE;
    }
    
    public function delete($rental_pickup_id)
    {
        $id = $rental_pickup_id;
        if($this->rentalpickup_model->deleteRentalPickUp($id))
        {
            $this->session->set_flashdata('success', 'Rental PickUp deleted successfully.');
            redirect("rentalpickup",'refresh');
        }
    }
    
    function scanRentAmount()
    {
        if($this->input->post('vehicle_no')) 
        { 
            $vehicle_no = $this->input->post('vehicle_no');
            $rental_type = $this->input->post('rental_type');
        }
        
        // $data = array('vehicle_no' => $vehicle_no, 'rental_type'=>$rental_type);
        // echo json_encode($data);
        $rentAmount = $this->rentalpickup_model->getRentAmount($vehicle_no, $rental_type);
        if($rental_type == 'Daily')
        {
            $data = array("rate"=>$rentAmount->daily_rate);
            echo json_encode($data);
        }
        else if($rental_type == 'Weekly')
        {
            $data = array("rate"=>$rentAmount->weekly_rate);
            echo json_encode($data);
        }
        else if($rental_type == 'Monthly')
        {
            $data = array("rate"=>$rentAmount->month_rate);
            echo json_encode($data);
        }
    }
    
    function scanPlace()
    {
        if($this->input->post('branch_id')) 
        { 
            $branch_id = $this->input->post('branch_id');
        }
        
        $place = $this->rentalpickup_model->getPlace($branch_id);
        $data = array("place"=>$place->branch_name);
        echo json_encode($data);
    }
    
    function scanExtraKM()
    {
        if($this->input->post('vehicle_no')) 
        { 
            $vehicle_no = $this->input->post('vehicle_no');
        }
        
        $extraKM = $this->rentalpickup_model->getExtraKM($vehicle_no);
        $data = array("extra_km"=>$extraKM->extra_km,"vehicle_type"=> $extraKM->vehicle_type);
        echo json_encode($data);
    }
    //calculate toatal rent amount
    function calculateTotalRent()
    {
        if($this->input->post('vehicle_no'))
        {
            $vehicle_no = $this->input->post('vehicle_no');
        }
        if($this->input->post('rent_type'))
        {
            $rent_type = $this->input->post('rent_type');
        }
        if($this->input->post('days'))
        {
            $days = $this->input->post('days');
        }
        $rate = $this->rentalpickup_model->totalRent($vehicle_no, $rent_type, $days);
        if($rent_type == 'Daily')
        {
            $totalRentAmount = $rate->daily_rate*$days;
            $data = array('totalRentalAmount'=>$totalRentAmount);
            echo json_encode($data);
        }
        if($rent_type == 'Weekly')
        {
            $totalRentAmount = (($rate->weekly_rate)/7)*$days;
            $data = array('totalRentalAmount'=>$totalRentAmount);
            echo json_encode($data);
        }
        if($rent_type == 'Monthly')
        {
            $totalRentAmount = (($rate->month_rate)/30)*$days;
            $data = array('totalRentalAmount'=>$totalRentAmount);
            echo json_encode($data);
        }
    }
    
    function testDateTime()
    {
        $meta['page_title'] = 'Edit Rental PickUp';
        $data['page_title'] = "Edit Rental PickUp";
        $this->load->view('commons/header', $meta);
        $this->load->view('testDateTime');
        $this->load->view('commons/footer');
    }
    
}
?>