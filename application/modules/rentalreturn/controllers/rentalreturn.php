<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Rentalreturn extends CI_Controller
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
		$this->load->model('rentalreturn_model');
        $this->load->library('upload');
		$this->load->library('Datatables');
	}

    function index()
    {
        if (!$this->ion_auth->logged_in())
	  	{
			redirect('auth/login');
	  	}
        $meta['page_title'] = 'Rental Return Details';
		$data['page_title'] = "Rental Return details";
		$this->load->view('commons/header',$meta);
		$this->load->view('index',$data);
		$this->load->view('commons/footer');
    }
    
    function rental_return_details()
    {
        $this->datatables->select('rental_return_view.rental_id,vehicle_reg_no,pickup_date,return_date,total_rented_days,km_used,km_extra_used,rate_per_day,total_rent_charges,km_extra_rate,discount,net_amount')
        ->from('rental_return_view')
		->join('rental_pickup_view','rental_pickup_view.rental_id = rental_return_view.rental_id')
		->join('vehicle','vehicle.id = rental_pickup_view.vehicle_id')
        ->add_column("Actions", "<a href='rentalreturn/view/$1'><i class='fa fa-eye'></i></a> &nbsp; <a href='rentalreturn/edit/$1'><i class='fa fa-pencil-square-o'></i></a>", "rental_return_view.rental_id");
		
        echo $this->datatables->generate();
    }
    
    function view($rental_return_id)
    {
        $rentalReturnDetail = $this->rentalreturn_model->getRentalReturnById($rental_return_id);
        // echo '<pre>';
        // print_r($rentalReturnDetail);exit;
        $data['rental_return'] = $rentalReturnDetail;
        $data['id'] = $rental_return_id;
        $meta['page_title'] = 'View Rental Return';
        $data['page_title'] = "View Rental Return";
        $this->load->view('commons/header', $meta);
        $this->load->view('view', $data);
        $this->load->view('commons/footer');
    }
    
    // function add()
    // {
        // //rental return form validation
        // /* ==============VALIDATION FOR SELECTBOX AGENT ================ */
        // $this->form_validation->set_rules('branch','Branch','required|callback_check_default');
        // $this->form_validation->set_message('check_default', 'You need to select branch other than the default.');
        
        // $this->form_validation->set_rules('date_rental', 'Date Of Rental', 'trim|xss_clean');
        // /* -------VALIDATION FOR CUSTOMER-------*/
        // $this->form_validation->set_rules('customer','Customer','required|callback_check_default_customer');
        // $this->form_validation->set_message('check_default_customer', 'You need to select customer other than the default.');
        
        // /* -------VALIDATION FOR VEHICLE NO-------*/
        // $this->form_validation->set_rules('vehicle_no','Vehicle Number','required|callback_check_default_vehicle_no');
        // $this->form_validation->set_message('check_default_vehicle_no', 'You need to select vehicle number other than the default.');
        
        // $this->form_validation->set_rules('rental_type', 'Rental Type', 'trim|xss_clean');
        // $this->form_validation->set_rules('rent_amount', 'Rent Amount', 'trim|xss_clean');
        // $this->form_validation->set_rules('expected_return_date', 'Expected Return Date', 'trim|xss_clean');
        // $this->form_validation->set_rules('pickup_from_place', 'Pick Up From Place', 'trim|xss_clean');
        // $this->form_validation->set_rules('drop_off_place', 'Drop Off Place', 'trim|xss_clean');
        // $this->form_validation->set_rules('km_allowed', 'Kellometer Allowed', 'trim|xss_clean');
        // $this->form_validation->set_rules('extra_km_rate', 'Extra Km Rate', 'trim|xss_clean');
        // $this->form_validation->set_rules('km_reading_out', 'Km Reading Out', 'trim|xss_clean');
        // $this->form_validation->set_rules('km_reading_in', 'Km Reading In', 'trim|xss_clean');
        // $this->form_validation->set_rules('fuel_level', 'Fuel Level', 'trim|xss_clean');
        
        // $this->form_validation->set_rules('gps_km', 'GPS Km', 'trim|xss_clean');
        // $this->form_validation->set_rules('actual_km', 'Actual Km', 'trim|xss_clean');
        // $this->form_validation->set_rules('total_km', 'Total Km', 'trim|xss_clean');
        
        // if ($this->form_validation->run() == true)
        // {
            // $rentalPickUpDetail = array(
                    // 'branch_id'	        =>	$this->input->post('branch'),
                    // 'customer_id'	        =>	$this->input->post('customer'),
                    // 'date_rental'	        =>	$this->input->post('date_rental'),
                    // 'vehicle_reg_no'	        =>	$this->input->post('vehicle_no'),
                    // 'rental_type'	        =>	$this->input->post('rental_type'),
                    // 'rent_amount'	        =>	$this->input->post('rent_amount'),
                    // 'expected_return_date'	        =>	$this->input->post('expected_return_date'),
                    // 'pickup_from_place'	        =>	$this->input->post('pickup_from_place'),
                    // 'drop_off_place'	        =>	$this->input->post('drop_off_place'),
                    // 'km_allowed'	        =>	$this->input->post('km_allowed'),
                    // 'extra_km_rate'	        =>	$this->input->post('extra_km_rate'),
                    // 'km_reading_out'	        =>	$this->input->post('km_reading_out'),
                    // 'km_reading_in'	        =>	$this->input->post('km_reading_in'),
                    // 'fuel_level'	        =>	$this->input->post('fuel_level'),
                    // 'gps_km'	        =>	$this->input->post('gps_km'),
                    // 'actual_km'	        =>	$this->input->post('actual_km'),
                    // 'total_km'	        =>	$this->input->post('total_km'),
                // );
                // // echo '<pre>';
                // // print_r($rentalPickUpDetail);exit;
        // }
        
        // if ( ($this->form_validation->run() == true) && $this->rentalpickup_model->addRentalPickUp($rentalPickUpDetail))
		// {  
			// $this->session->set_flashdata('success', 'Rental PickUp added successfully.');
			// redirect("rentalpickup",'refresh');
		// }
		// else
		// {  
            // $data['vehicle'] = $this->rentalpickup_model->getVehicle();
            // $data['branch'] = $this->rentalpickup_model->getBranch();
            // $data['customer'] = $this->rentalpickup_model->getCustomer();
            // // $data['last_id'] = $this->rentalpickup_model->last_id();
            // // echo '<pre>';
            // // print_r($data['last_id']);exit;
            // $meta['page_title'] = 'Add Rental Return';
            // $data['page_title'] = "Add Rental Return";
            // $this->load->view('commons/header', $meta);
            // $this->load->view('add', $data);
            // $this->load->view('commons/footer');
		// }
    // }
    
    function edit($rental_return_id)
    {
        $status = $this->rentalreturn_model->getReturnStatus($rental_return_id);
        if($status->status == 'completed'){
            $this->session->set_flashdata('success', 'Rental Return already completed.');
            redirect('rentalreturn','refresh');
        }
        $id = $rental_return_id;
        
        if($post = $this->input->post())
        {
            //rental return form validation
            
            $this->form_validation->set_rules('rental_return_date', 'Date Of Rental Return', 'trim|xss_clean');
            // $this->form_validation->set_rules('km_in', 'KM In', 'trim|required|xss_clean');
            $this->form_validation->set_rules('km_used', 'KM Used', 'trim|xss_clean');
            $this->form_validation->set_rules('km_extra_used', 'KM Extra Used', 'trim|xss_clean');
            $this->form_validation->set_rules('total_rented_days', 'Rented Days', 'trim|xss_clean');
            $this->form_validation->set_rules('rate_per_day', 'Rate Per Day', 'trim|xss_clean');
            $this->form_validation->set_rules('total_rent_charge', 'Total Rent Charges', 'trim|xss_clean');
            $this->form_validation->set_rules('fuel_level', 'Fuel Level', 'trim|xss_clean');
            $this->form_validation->set_rules('fuel_refil_charges', 'Fuel Refil Charges', 'trim|xss_clean');
            $this->form_validation->set_rules('traffic_fine', 'Traffic fine', 'trim|xss_clean');
            $this->form_validation->set_rules('additional_driver_charge', 'Additional Driver Charges', 'trim|xss_clean');
            $this->form_validation->set_rules('chauffer_charges', 'Chauffer Charges', 'trim|xss_clean');
            $this->form_validation->set_rules('additional_insurance', 'Additional Insurance', 'trim|xss_clean');
            $this->form_validation->set_rules('pai_charge', 'PAI Charge', 'trim|xss_clean');
            $this->form_validation->set_rules('misc_charges', 'Miscellaneous Charges', 'trim|xss_clean');
            $this->form_validation->set_rules('deduction', 'Deduction', 'trim|xss_clean');
            $this->form_validation->set_rules('discount', 'Discount', 'trim|xss_clean');
            $this->form_validation->set_rules('invoice_no', 'Invoice No', 'trim|xss_clean');
            $this->form_validation->set_rules('invoice_date', 'Invoic Date', 'trim|xss_clean');
            $this->form_validation->set_rules('invoice_status', 'Invoice Status', 'trim|xss_clean');
            
            $this->form_validation->set_rules('gps_km', 'GPS Km', 'trim|xss_clean');
            $this->form_validation->set_rules('actual_km', 'Actual Km', 'trim|xss_clean');
            $this->form_validation->set_rules('total_km', 'Total Km', 'trim|xss_clean');
            $this->form_validation->set_rules('net_amount', 'Net Amount Payable', 'trim|xss_clean');
            
            
            if ($this->form_validation->run() == true)
            {
                $rentalReturnDetail = array(
                    'pickup_date'	        =>	$this->input->post('pickUP_date'),
                    'rental_return_date'	        =>	$this->input->post('rental_return_date'),
                    'km_in'                 =>  $this->input->post('km_in'),
                    'km_used'	        =>	$this->input->post('km_used'),
                    'km_extra_used'	        =>	$this->input->post('km_extra_used'),
                    'km_extra_rate'	        =>	$this->input->post('extra_km_rate'),
                    'total_rented_days'	        =>	$this->input->post('total_rented_days'),
                    'rate_per_day'	        =>	$this->input->post('per_day_rate'),
                    'total_rent_charge'	        =>	$this->input->post('total_rent_charge'),
                    'fuel_level'	        =>	$this->input->post('fuel_level'),
                    'fuel_refil_charges'	        =>	$this->input->post('fuel_refil_charges'),
                    'traffic_fine'	        =>	$this->input->post('traffic_fine'),
                    'additional_driver_charge'	        =>	$this->input->post('additional_driver_charge'),
                    'chauffer_charges'	        =>	$this->input->post('chauffer_charges'),
                    'additional_insurance'	        =>	$this->input->post('additional_insurance'),
                    'pai_charges'	        =>	$this->input->post('pai_charge'),
                    'misc_charges'	        =>	$this->input->post('misc_charges'),
                    'deduction'	        =>	$this->input->post('deduction'),
                    'discount_type'	        =>	$this->input->post('discount_type'),
                    'discount'	        =>	$this->input->post('discount'),
                    'invoice_no'	        =>	$this->input->post('invoice_no'),
                    'invoice_date'	        =>	$this->input->post('invoice_date'),
                    'invoice_status'	        =>	$this->input->post('invoice_status'),
                    'gps_km'	        =>	$this->input->post('gps_km'),
                    'actual_km'	        =>	$this->input->post('actual_km'),
                    'total_km'	        =>	$this->input->post('total_km'),
                    'net_amount'	        =>	$this->input->post('net_amount'),
                    'remarks'           => $this->input->post('remarks'),
                    'status'            => 'completed',
                );
                // echo '<pre>';
                // print_r($rentalReturnDetail);exit;
            }
            
            if ( ($this->form_validation->run() == true) && $this->rentalreturn_model->updateRentalReturn($rentalReturnDetail,$rental_return_id))
            {  
                $this->session->set_flashdata('success', 'Rental Return edited successfully.');
                redirect("rentalreturn",'refresh');
            }
            else
            {  
                $rentalReturnDetail = $this->rentalreturn_model->getRentalReturnById($rental_return_id);
                $data['km_out'] = $this->rentalreturn_model->getKMOut($rental_return_id);
                $data['rate_per_data'] = $this->rentalreturn_model->getRatePerDay($rental_return_id);
                $data['deduction'] = $this->rentalreturn_model->getDeduction($rental_return_id);
                // if(empty($data['deduction'])){
                    // $data['deduction'] = 0;
                // }
                // else{
                    // $data['deduction'] = $deduction_val->receipt_amount;
                // }
                // echo '<pre>';
                // print_r($data['km_out']);exit;
                // echo '<pre>';
                // print_r($rentalReturnDetail);exit;
                $data['rental_return'] = $rentalReturnDetail;
                $data['id'] = $rental_return_id;
                $meta['page_title'] = 'Edit Rental Return';
                $data['page_title'] = "Edit Rental Return";
                $this->load->view('commons/header', $meta);
                $this->load->view('edit', $data);
                $this->load->view('commons/footer');
            
            }
        }
        else
        {
            $rentalReturnDetail = $this->rentalreturn_model->getRentalReturnById($rental_return_id);
            $data['rate_per_data'] = $this->rentalreturn_model->getRatePerDay($rental_return_id);
            $data['km_out'] = $this->rentalreturn_model->getKMOut($rental_return_id);
            $data['deduction'] = $this->rentalreturn_model->getDeduction($rental_return_id);
            // if(empty($data['deduction'])){
                // $data['deduction'] = 0;
            // }
            // else{
                // $data['deduction'] = $deduction_val->receipt_amount;
            // }
            // echo '<pre>';
            // print_r($data['deduction']);exit;
            // echo '<pre>';
            // print_r($data['rate_per_data']);exit;
            $data['rental_return'] = $rentalReturnDetail;
            $data['id'] = $rental_return_id;
            $meta['page_title'] = 'Edit Rental Return';
            $data['page_title'] = "Edit Rental Return";
            $this->load->view('commons/header', $meta);
            $this->load->view('edit', $data);
            $this->load->view('commons/footer');
        }
        	
	}
    
    function scanExtraKmUsed()
    {
        $rental_id = $this->input->post('rental_id');
        $days = $this->input->post('days');
        $km_in = $this->input->post('km_in');
        $km_out = $this->input->post('km_out');
        $km_used = $this->input->post('km_used');
        $kmAllowed = $this->rentalreturn_model->getKmAllowed($rental_id);
        
        $extra_km_rate = $kmAllowed->extra_km;
        $rental_type = $kmAllowed->rental_type;
        $daily_rate= $kmAllowed->daily_rate;
        $weekly_rate = ($kmAllowed->weekly_rate)/7;
        $month_rate = ($kmAllowed->month_rate)/30;
        
        
        $extra_km_rate_used ; 
        $extra_km_used;
        $allowedKM;
        $totalAllowedKMRent = 0 ;
        if($rental_type == "Weekly"){
            if((round($days/7))<1){
                $allowedKM = $days * 200 ;
                $totalAllowedKMRent =  $daily_rate * $days;
            }else{
                $allowedKM = (round($days/7))*1200 + (round($days%7))*200 ;
                $totalAllowedKMRent =  $weekly_rate * $days;
            }  
        }else if($rental_type == "Monthly"){
            if((round($days/30))<1){
                $allowedKM = $days * 200 ;
                $totalAllowedKMRent =  $daily_rate * $days;
            }else{
                $allowedKM = (round($days/30))*4800 + ($days%30)*200 ;
                $totalAllowedKMRent =  $month_rate * $days;
            }  
        }else{
            $allowedKM = $days * 200 ;
            $totalAllowedKMRent =  $daily_rate * $days;
        }
        if(($km_used - $allowedKM) < 0){
            $extra_km_used = 0;
            $extra_km_rate_used = 0.000;
        }else{
            $extra_km_used = $km_used - $allowedKM;
            $extra_km_rate_used = round($extra_km_used * $extra_km_rate);
        }
        $data = array(
            'extra_km_used'     =>  $extra_km_used,
            'allowedKM'         =>  $allowedKM,
            'rent_charge'       =>  $totalAllowedKMRent,
            'extra_km_rate_used'=>  $extra_km_rate_used,
        );
        echo json_encode($data);
    }
    function scanDailyRent(){
        $rental_id = $this->input->post('rental_id');
        $days = $this->input->post('days');
        $kmAllowed = $this->rentalreturn_model->getKmAllowed($rental_id);
        $rental_type = $kmAllowed->rental_type;
        $daily_rate= $kmAllowed->daily_rate;
        $weekly_rate = ($kmAllowed->weekly_rate)/7;
        $month_rate = ($kmAllowed->month_rate)/30;
        
        //total rented days from pickup 
            $d1 = $kmAllowed->pickup_date;
            $d2 = $kmAllowed->return_date;
            
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
            $total_rent_days_pickup = $diff;
        
        $rent_per_day;
        $total_rent_charge;
        
        if($rental_type == "Daily"){
            $rent_per_day = $daily_rate;
            $total_rent_charge = number_format(($days * $rent_per_day),3);
            // $pickUpData = array(
                // 'rental_type'   => 'Daily',
            // );
            // change pick update > rental type to daily
            //$update = $this->rentalreturn_model->updatePickUp($rental_id,$pickUpData);
        }else if($rental_type == "Weekly"){
            if($days < 7){
                $rent_per_day = $daily_rate;
                $total_rent_charge = number_format(($days * $rent_per_day),3);
                $pickUpData = array(
                    'rental_type'   => 'Daily',
                );
                // change pick update > rental type to daily
                $update = $this->rentalreturn_model->updatePickUp($rental_id,$pickUpData);
            }else{
                $rent_per_day = $weekly_rate;
                $total_rent_charge = number_format(($days * $rent_per_day),3);
                $pickUpData = array(
                    'rental_type'   => 'Weekly',
                );
                // change pick update > rental type to weekly
                $update = $this->rentalreturn_model->updatePickUp($rental_id,$pickUpData);
            }
        }else if($rental_type == "Monthly"){
            if($days < 30){
                $rent_per_day = $daily_rate;
                $total_rent_charge = number_format(($days * $rent_per_day),3); 
                $pickUpData = array(
                    'rental_type'   => 'Daily',
                );
                // change pick update > rental type to daily
                $update = $this->rentalreturn_model->updatePickUp($rental_id,$pickUpData);
            }else{
                $rent_per_day = $month_rate;
                $total_rent_charge = number_format(($days * $rent_per_day),3);
                $pickUpData = array(
                    'rental_type'   => 'Monthly',
                );
                // change pick update > rental type to monthly
                $update = $this->rentalreturn_model->updatePickUp($rental_id,$pickUpData);
            }
        }
        $dataArr = array(
            'rent_charge'   =>  $total_rent_charge,
            'rent_per_day'  =>  $rent_per_day,
        );
        echo json_encode($dataArr);
    }
}
?>