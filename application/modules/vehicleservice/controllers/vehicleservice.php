<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Vehicleservice extends CI_Controller
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
		$this->load->model('vehicleservice_model');
        $this->load->library('upload');
		$this->load->library('Datatables');
	}

    function index()
    {
        if (!$this->ion_auth->logged_in())
	  	{
			redirect('auth/login');
	  	}
        $meta['page_title'] = 'Vehicle Service Details';
		$data['page_title'] = "Vehicle Service Details";
		$this->load->view('commons/header',$meta);
		$this->load->view('index',$data);
		$this->load->view('commons/footer');
    }
    
    function vehicle_service_details()
    {
        $this->datatables->select('service_no,branch.branch_name as branchName,vehicle.vehicle_reg_no,date_service,service_type,voucher_date,garage.garage_name as garageName,service_done,service_amount,sparepart_dealer_charges,sparepart_shop_charges,labour_charges,date_serviceout')
        ->from('vehicle_service_view')
        ->join('branch', 'branch.id=vehicle_service_view.branch_id', 'INNER')
        ->join('garage', 'garage.id=vehicle_service_view.garage_id', 'INNER')
        ->join('vehicle','vehicle.id = vehicle_service_view.vehicle_id')
        ->add_column("Actions", "<a href='vehicleservice/view/$1'><i class='fa fa-eye'></i></a> &nbsp; <a href='vehicleservice/edit/$1'><i class='fa fa-pencil-square-o'></i></a> &nbsp; <a href='vehicleservice/delete/$1' onclick=\"return confirm('Are you sure you want to delete?');\"><i class='fa fa-trash-o'></i></a>", "service_no");
		
        echo $this->datatables->generate();
    }
    
    function view($service_no)
    {
        $vehicleServiceDetail = $this->vehicleservice_model->getVehicleServiceDetailsWithJoin($service_no);
        // echo '<pre>';
        // print_r($vehicleServiceDetail);exit;
        $data['vehicle_service'] = $vehicleServiceDetail;
        $data['id'] = $service_no;
        $data['branch'] = $this->vehicleservice_model->getBranch();
        $data['garage'] = $this->vehicleservice_model->getGarage();
        $meta['page_title'] = 'View Vehicle Service';
        $data['page_title'] = "View Vehicle Service";
        $this->load->view('commons/header', $meta);
        $this->load->view('view', $data);
        $this->load->view('commons/footer');
    }
    
    function add()
    {
        //vehicle service form validation
        /* ==============VALIDATION FOR SELECTBOX Branch ================ */
        $this->form_validation->set_rules('branch','Branch','required|callback_check_default');
        $this->form_validation->set_message('check_default', 'You need to select branch other than the default.');
        
        $this->form_validation->set_rules('date_service', 'Date of Service', 'required|trim|xss_clean');
        
        $this->form_validation->set_rules('service_type', 'Service Type', 'required|callback_check_serviceType');
        $this->form_validation->set_message('check_serviceType', 'You need to select service type other than the default.');
        
        $this->form_validation->set_rules('service_required', 'Service Required', 'trim|xss_clean');
        $this->form_validation->set_rules('km_at_service', 'Kilometre at Service', 'trim|xss_clean');
        $this->form_validation->set_rules('voucher_date', 'Voucher Date', 'trim|xss_clean');
        /* -------VALIDATION FOR GARAGE-------*/
        $this->form_validation->set_rules('garage','Garage','required|callback_check_default_garage');
        $this->form_validation->set_message('check_default_garage', 'You need to select garage other than the default.');
        
        $this->form_validation->set_rules('service_done', 'Service Done', 'trim|xss_clean');
        $this->form_validation->set_rules('service_amount', 'Service Amount', 'trim|xss_clean');
        $this->form_validation->set_rules('sparepart_dealer_charges', 'SparePart Charges Dealer', 'trim|xss_clean');
        $this->form_validation->set_rules('sparepart_shop_charges', 'SparePart Charges Shop', 'trim|xss_clean');
        $this->form_validation->set_rules('labour_charges', 'Labour Charges', 'trim|xss_clean');
        $this->form_validation->set_rules('date_serviceout', 'Date of Service Out', 'trim|xss_clean');
        
        $this->form_validation->set_rules('washing_charge', 'Magic Touch Washing Charge', 'trim|xss_clean');
        
        if ($this->form_validation->run() == true)
        {
            $vehicleServiceDetail = array(
                    'branch_id'	        =>	$this->input->post('branch'),
                    'vehicle_id'	        =>	$this->input->post('vehicle_no'),
                    'date_service'	        =>	$this->input->post('date_service'),
                    'service_type'	        =>	$this->input->post('service_type'),
                    'service_required'	        =>	$this->input->post('service_required'),
                    'km_at_service'	        =>	$this->input->post('km_at_service'),
                    'voucher_date'	        =>	$this->input->post('voucher_date'),
                    'garage_id'	        =>	$this->input->post('garage'),
                    'service_done'	        =>	$this->input->post('service_done'),
                    'service_amount'	        =>	$this->input->post('service_amount'),
                    'sparepart_dealer_charges'	        =>	$this->input->post('sparepart_dealer_charges'),
                    'sparepart_shop_charges'	        =>	$this->input->post('sparepart_shop_charges'),
                    'labour_charges'	        =>	$this->input->post('labour_charges'),
                    'date_serviceout'	        =>	$this->input->post('date_serviceout'),
                    'washing_charge'	        =>	$this->input->post('washing_charge'),
                    'observation'	        =>	$this->input->post('observation'),
                );
                // echo '<pre>';
                // print_r($vehicleServiceDetail);exit;
        }
        
        if ( ($this->form_validation->run() == true) && $this->vehicleservice_model->addVehicleService($vehicleServiceDetail))
		{  
			$this->session->set_flashdata('success', 'Vehicle Service added successfully.');
			redirect("vehicleservice",'refresh');
		}
		else
		{  
            $data['vehicle'] = $this->vehicleservice_model->getVehicle();
            $data['branch'] = $this->vehicleservice_model->getBranch();
			$data['default_branch'] = $this->vehicleservice_model->getDefaultBranch();
            $data['garage'] = $this->vehicleservice_model->getGarage();
            $data['last_id'] = $this->vehicleservice_model->last_id();
            // echo '<pre>';
            // print_r($data['garage']);exit;
            $meta['page_title'] = 'Add Vehicle Service';
            $data['page_title'] = "Add Vehicle Service";
            $this->load->view('commons/header', $meta);
            $this->load->view('add', $data);
            $this->load->view('commons/footer');
		}
    }
    
    function edit($service_no)
    {
        $id = $service_no;
        
        if($post = $this->input->post())
        {
            //vehicle service form validation
            /* ==============VALIDATION FOR SELECTBOX Branch ================ */
            $this->form_validation->set_rules('branch','Branch','required|callback_check_default');
            $this->form_validation->set_message('check_default', 'You need to select branch other than the default.');
            
            $this->form_validation->set_rules('date_service', 'Date of Service', 'required|trim|xss_clean');
            
            $this->form_validation->set_rules('service_type', 'Service Type', 'required|callback_check_serviceType');
            $this->form_validation->set_message('check_serviceType', 'You need to select service type other than the default.');
            
            $this->form_validation->set_rules('service_required', 'Service Required', 'trim|xss_clean');
            $this->form_validation->set_rules('km_at_service', 'Kilometre at Service', 'trim|xss_clean');
            $this->form_validation->set_rules('voucher_date', 'Voucher Date', 'trim|xss_clean');
            /* -------VALIDATION FOR GARAGE-------*/
            $this->form_validation->set_rules('garage','Garage','required|callback_check_default_garage');
            $this->form_validation->set_message('check_default_garage', 'You need to select garage other than the default.');
            
            $this->form_validation->set_rules('service_done', 'Service Done', 'trim|xss_clean');
            $this->form_validation->set_rules('service_amount', 'Service Amount', 'trim|xss_clean');
            $this->form_validation->set_rules('sparepart_dealer_charges', 'SparePart Charges Dealer', 'trim|xss_clean');
            $this->form_validation->set_rules('sparepart_shop_charges', 'SparePart Charges Shop', 'trim|xss_clean');
            $this->form_validation->set_rules('labour_charges', 'Labour Charges', 'trim|xss_clean');
            $this->form_validation->set_rules('date_serviceout', 'Date of Service Out', 'trim|xss_clean');
            
            $this->form_validation->set_rules('washing_charge', 'Magic Touch Washing Charge', 'trim|xss_clean');
        
            if ($this->form_validation->run() == true)
            {
                $vehicleServiceDetail = array(
                    'branch_id'	            =>	$this->input->post('branch'),
                    'vehicle_id'	        =>	$this->input->post('vehicle_no'),
                    'date_service'	        =>	$this->input->post('date_service'),
                    'service_type'	        =>	$this->input->post('service_type'),
                    'service_required'	    =>	$this->input->post('service_required'),
                    'km_at_service'	        =>	$this->input->post('km_at_service'),
                    'voucher_date'	        =>	$this->input->post('voucher_date'),
                    'garage_id'	            =>	$this->input->post('garage'),
                    'service_done'	        =>	$this->input->post('service_done'),
                    'service_amount'	    =>	$this->input->post('service_amount'),
                    'sparepart_dealer_charges'  =>	$this->input->post('sparepart_dealer_charges'),
                    'sparepart_shop_charges'    =>	$this->input->post('sparepart_shop_charges'),
                    'labour_charges'	        =>	$this->input->post('labour_charges'),
                    'date_serviceout'	        =>	$this->input->post('date_serviceout'),
                    'washing_charge'	        =>	$this->input->post('washing_charge'),
                    'observation'	        =>	$this->input->post('observation'),
                );
                // echo '<pre>';
                // print_r($vehicleServiceDetail);exit;
            }
            
            if ( ($this->form_validation->run() == true) && $this->vehicleservice_model->updateVehicleService($vehicleServiceDetail,$service_no))
            {  
                $this->session->set_flashdata('success', 'Vehicle Service edited successfully.');
                redirect("vehicleservice",'refresh');
            }
            else
            {  
                $vehicleServiceDetail = $this->vehicleservice_model->getVehicleServiceDetails($service_no);
                $data['vehicle'] = $this->vehicleservice_model->getVehicle();
                // echo '<pre>';
                // print_r($data['vehicle']);exit;
                $data['vehicle_service'] = $vehicleServiceDetail;
                $data['id'] = $service_no;
                $data['branch'] = $this->vehicleservice_model->getBranch();
                $data['garage'] = $this->vehicleservice_model->getGarage();
                $meta['page_title'] = 'Edit Vehicle Service';
                $data['page_title'] = "Edit Vehicle Service";
                $this->load->view('commons/header', $meta);
                $this->load->view('edit', $data);
                $this->load->view('commons/footer');
            
            }
        }
        else
        {
            $vehicleServiceDetail = $this->vehicleservice_model->getVehicleServiceDetails($service_no);
            $data['vehicle'] = $this->vehicleservice_model->getVehicle();
            // echo '<pre>';
            // print_r($vehicleServiceDetail);exit;
            $data['vehicle_service'] = $vehicleServiceDetail;
            $data['id'] = $service_no;
            $data['branch'] = $this->vehicleservice_model->getBranch();
            $data['garage'] = $this->vehicleservice_model->getGarage();
            $meta['page_title'] = 'Edit Vehicle Service';
            $data['page_title'] = "Edit Vehicle Service";
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
    
    /* =====================VALIDATION FOR Vehicle No ======================== */
    function check_default_garage($post_string)
    {
        return $post_string == '0' ? FALSE : TRUE;
    }
    
    /* =====================VALIDATION FOR Service Type ======================== */
    function check_serviceType($post_string)
    {
        return $post_string == '0' ? FALSE : TRUE;
    }
    
    public function delete($service_no)
    {
        $id = $service_no;
        if($this->vehicleservice_model->deleteVehicleService($id))
        {
            $this->session->set_flashdata('success', 'Vehicle Service deleted successfully.');
            redirect("vehicleservice",'refresh');
        }
    }
}
?>