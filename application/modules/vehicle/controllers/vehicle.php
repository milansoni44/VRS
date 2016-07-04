<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Vehicle extends CI_Controller 
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
		$this->load->model('vehicle_model');
        $this->load->library('upload');
		$this->load->library('Datatables');
	}

    function index()
    {
        if (!$this->ion_auth->logged_in())
	  	{
			redirect('auth/login');
	  	}
        $meta['page_title'] = 'Vehicle Details';
		$data['page_title'] = "Vehicle details";
		$this->load->view('commons/header',$meta);
		$this->load->view('index',$data);
		$this->load->view('commons/footer');
    }
    
    function vehicle_details()
    {
        $vehicle = $this->input->get("vehicle");
        if($vehicle == "total"){
            $this->datatables->select('vehicle.id,vehicle_reg_no,branch.branch_name as BranchName,brand,trans_type,vehicle_type,model_year,vehicle_availibility,daily_rate,weekly_rate,month_rate,extra_km,fuel_type')
            ->unset_column('vehicle.id')
            ->from('vehicle')
            ->join('branch', 'branch.id=vehicle.branch_id', 'INNER')
            ->join('vehicle_owner', 'vehicle_owner.id=vehicle.owner_id', 'INNER');
		}else if($vehicle == "available"){
            $this->datatables->select('vehicle.id,vehicle_reg_no,branch.branch_name as BranchName,brand,trans_type,vehicle_type,model_year,vehicle_availibility,daily_rate,weekly_rate,month_rate,extra_km,fuel_type')
            ->unset_column('vehicle.id')
            ->from('vehicle')
            ->join('branch', 'branch.id=vehicle.branch_id', 'INNER')
            ->join('vehicle_owner', 'vehicle_owner.id=vehicle.owner_id', 'INNER')
            ->where('vehicle.vehicle_availibility','Available');
		}else if($vehicle == "rented"){
            $this->datatables->select('vehicle.id,vehicle_reg_no,branch.branch_name as BranchName,brand,trans_type,vehicle_type,model_year,vehicle_availibility,daily_rate,weekly_rate,month_rate,extra_km,fuel_type')
            ->unset_column('vehicle.id')
            ->from('vehicle')
            ->join('branch', 'branch.id=vehicle.branch_id', 'INNER')
            ->join('vehicle_owner', 'vehicle_owner.id=vehicle.owner_id', 'INNER')
            ->where('vehicle.vehicle_availibility','Rented');
		}else if($vehicle == "returned"){
            $this->datatables->select('vehicle.id,vehicle_reg_no,branch.branch_name as BranchName,brand,trans_type,vehicle_type,model_year,vehicle_availibility,daily_rate,weekly_rate,month_rate,extra_km,fuel_type')
            ->unset_column('vehicle.id')
            ->from('vehicle')
            ->join('branch', 'branch.id=vehicle.branch_id', 'INNER')
            ->join('vehicle_owner', 'vehicle_owner.id=vehicle.owner_id', 'INNER')
            ->where('vehicle.vehicle_availibility','Returned');
		}else{
            $this->datatables->select('vehicle.id,vehicle_reg_no,branch.branch_name as BranchName,brand,trans_type,vehicle_type,model_year,vehicle_availibility,daily_rate,weekly_rate,month_rate,extra_km,fuel_type')
            ->unset_column('vehicle.id')
            ->from('vehicle')
            ->join('branch', 'branch.id=vehicle.branch_id', 'INNER')
            ->join('vehicle_owner', 'vehicle_owner.id=vehicle.owner_id', 'INNER')
            ->where('vehicle.vehicle_availibility','Repair');
		}
            $this->datatables->add_column("Actions", "<a href='vehicle/view/$1'><i class='fa fa-eye'></i></a> &nbsp; <a href='vehicle/edit/$1'><i class='fa fa-pencil-square-o'></i></a> &nbsp; <a href='vehicle/delete/$1' onclick=\"return confirm('Are you sure you want to delete?');\"><i class='fa fa-trash-o'></i></a>", "vehicle.id");
        echo $this->datatables->generate();
    }
    
    function view($vehicle_id)
    {
        $vehicle_details = $this->vehicle_model->getVehicleByIdWithJoin($vehicle_id);
        // echo '<pre>';
        // print_r($vehicle_details);exit;
        $data['id'] = $vehicle_id;
        $data['vehicle'] = $vehicle_details;
        $data['branch'] = $this->vehicle_model->getBranch();
        $data['owner'] = $this->vehicle_model->getOwner();
        $meta['page_title'] = 'View Vehicle';
        $data['page_title'] = "View Vehicle";
        $this->load->view('commons/header', $meta);
        $this->load->view('view', $data);
        $this->load->view('commons/footer');
    }
    
    function add()
    {
        //vehicle form validation
        /* ==============VALIDATION FOR SELECTBOX branch ================ */
        $this->form_validation->set_rules('branch','Branch','required|callback_check_default');
        $this->form_validation->set_message('check_default', 'You need to select branch other than the default.');
        /* --------------*/
        $this->form_validation->set_rules('vehicle_reg_no', 'Vehicle Reg. No', 'trim|required|xss_clean');
        $this->form_validation->set_rules('owner', 'Location', 'trim|xss_clean');
        $this->form_validation->set_rules('finance_company', 'Finance Company', 'trim|xss_clean');
        $this->form_validation->set_rules('brand', 'Brand', 'trim|xss_clean');
        $this->form_validation->set_rules('trans_type', 'Transmission Type', 'trim|xss_clean');
        $this->form_validation->set_rules('vehicle_type', 'Vehicle Type', 'trim|xss_clean');
        $this->form_validation->set_rules('model', 'Model', 'trim|xss_clean');
        $this->form_validation->set_rules('model_year', 'model_year', 'trim|xss_clean');
        $this->form_validation->set_rules('insurance_type', 'Insurance Type', 'trim|xss_clean');
        $this->form_validation->set_rules('breakdown_recovery', 'Breakdown Recovery', 'trim|xss_clean');
        $this->form_validation->set_rules('insurance_company', 'Insurance Company', 'trim|xss_clean');
        $this->form_validation->set_rules('insurance_exp_date', 'Insurance Expiry Date', 'trim|xss_clean');
        $this->form_validation->set_rules('vehicle_avail_status', 'Vehicle Availability Status', 'trim|xss_clean');
        $this->form_validation->set_rules('seating_capacity', 'Seating Capacity', 'trim|xss_clean');
        $this->form_validation->set_rules('engine_capacity', 'Engine Capacity', 'trim|xss_clean');
        $this->form_validation->set_rules('daily_rate', 'Daily Rate', 'trim|xss_clean');
        $this->form_validation->set_rules('weekly_rate', 'weekly Rate', 'trim|xss_clean');
        $this->form_validation->set_rules('month_rate', 'Month Rate', 'trim|xss_clean');
        $this->form_validation->set_rules('extra_km', 'Extra Km', 'trim|xss_clean');
        $this->form_validation->set_rules('gps_id', 'GPS ID', 'trim|xss_clean');
        $this->form_validation->set_rules('date_fleet_inclusion', 'Date of Fleet Inclusion', 'trim|xss_clean');
        $this->form_validation->set_rules('fuel_type', 'Fuel Type', 'trim|xss_clean');
        $this->form_validation->set_rules('remarks', 'Remarks', 'trim|xss_clean');
        
        if ($this->form_validation->run() == true)
        {
            if($this->input->post('brand') == 0)
            {
                $brand = $this->input->post('model');
            }
            else{
                $brand = $this->input->post('brand');
            }
            $count = $this->db->from('vehicle');
            $query = $this->db->get();
            $rowcount = $query->num_rows();
            if($rowcount == 0)
            {
                $rowcount = $rowcount + 1;
            }
            if($_FILES['image']['size'] > 0)
			{
                $ext1 = end(explode(".", $_FILES['image']['name']));
                $file_name = "vehicle-".$rowcount.".".$ext1;
                $image_path = realpath(APPPATH."../assets/uploads/vehicles/");
                $config = array(
				'upload_path' => $image_path,
				'allowed_types' => "gif|jpg|png|jpeg|pdf",
				'overwrite' => TRUE,
				// 'max_size' => "2048000", // Can be set to particular file size , here it is 2 MB(2048 Kb)
				// 'max_height' => "1440",
				// 'max_width' => "900",
                'file_name' => $file_name
				);
                // echo '<pre>';
                // print_r($config);
                $this->upload->initialize($config);
                if($this->upload->do_upload('image'))
				{
					$data = array('image' => $this->upload->data());
                }
				else
				{
                    // echo '<pre>';    
					$error = array('error' => $this->upload->display_errors());
                    // print_r($error);
					$this->load->view('add', $error);
				}
            }
            else
            {
                $data['image']['file_name'] = "";
            }
            $vehicleDetail = array(
                    'vehicle_reg_no'       =>  $this->input->post('vehicle_reg_no'),
                    'branch_id'	        =>	$this->input->post('branch'),
                    'owner'          =>  $this->input->post('owner'),
                    'finance_company'         =>  $this->input->post('finance_company'),
                    'brand'         =>  $brand,
                    'trans_type'             =>  $this->input->post('trans_type'),
                    'vehicle_type'             =>  $this->input->post('vehicle_type'),
                    'model'    =>  $this->input->post('model'),
                    'model_year'    =>  $this->input->post('model_year'),
                    'reg_expiry_date' => $this->input->post('reg_exp_date'),
                    'insurance_type'    =>  $this->input->post('insurance_type'),
                    'breakdown_recovery'    =>  $this->input->post('breakdown_recovery'),
                    'insurance_company'    =>  $this->input->post('insurance_company'),
                    'insurance_exp_date'    =>  $this->input->post('insurance_exp_date'),
                    'vehicle_avail_status'    =>  $this->input->post('vehicle_avail_status'),
                    'image'    =>  $data['image']['file_name'],
                    'seating_capacity'    =>  $this->input->post('seating_capacity'),
                    'engine_capacity'    =>  $this->input->post('engine_capacity'),
                    'daily_rate'    =>  $this->input->post('daily_rate'),
                    'weekly_rate'    =>  $this->input->post('weekly_rate'),
                    'month_rate'    =>  $this->input->post('month_rate'),
                    'extra_km'    =>  $this->input->post('extra_km'),
                    'vehicle_cost'    =>  $this->input->post('vehicle_cost'),
                    'gps_id'    =>  $this->input->post('gps_id'),
                    'date_fleet_inclusion'    =>  $this->input->post('date_fleet_inclusion'),
                    'fuel_type'    =>  $this->input->post('fuel_type'),
                    'remarks'    =>  $this->input->post('remarks'),
                );
                // echo '<pre>';
                // print_r($vehicleDetail);exit;
        }
        
        if ( ($this->form_validation->run() == true) && $this->vehicle_model->addVehicle($vehicleDetail))
		{  
			$this->session->set_flashdata('success', 'Vehicle added successfully.');
			redirect("vehicle",'refresh');
		}
		else
		{  
            $data['branch'] = $this->vehicle_model->getBranch();
            $data['brand']  = $this->vehicle_model->getBrand();
            $data['owner'] = $this->vehicle_model->getOwner();
            $data['default_branch'] = $this->vehicle_model->getDefaultBranch();
            // print_r($data['default_branch']);exit;
			$meta['page_title'] = 'Add Vehicle';
            $data['page_title'] = "Add Vehicle";
            $this->load->view('commons/header', $meta);
            $this->load->view('add', $data);
            $this->load->view('commons/footer');
		
		}	
	}
    
    function edit($vehicle_id)
    {
        $id = $vehicle_id;
        
        if($post = $this->input->post())
        {
            //vehicle form validation
            /* ==============VALIDATION FOR SELECTBOX branch ================ */
            $this->form_validation->set_rules('branch','Branch','required|callback_check_default');
            $this->form_validation->set_message('check_default', 'You need to select branch other than the default.');
            /* --------------*/
            $this->form_validation->set_rules('vehicle_reg_no', 'Vehicle Reg. No', 'trim|required|xss_clean');
            $this->form_validation->set_rules('owner', 'Location', 'trim|xss_clean');
            $this->form_validation->set_rules('finance_company', 'Finance Company', 'trim|xss_clean');
            $this->form_validation->set_rules('brand', 'Brand', 'trim|xss_clean');
            $this->form_validation->set_rules('trans_type', 'Transmission Type', 'trim|xss_clean');
            $this->form_validation->set_rules('vehicle_type', 'Vehicle Type', 'trim|xss_clean');
            $this->form_validation->set_rules('model', 'Model', 'trim|xss_clean');
            $this->form_validation->set_rules('model_year', 'model_year', 'trim|xss_clean');
            $this->form_validation->set_rules('insurance_type', 'Insurance Type', 'trim|xss_clean');
            $this->form_validation->set_rules('breakdown_recovery', 'Breakdown Recovery', 'trim|xss_clean');
            $this->form_validation->set_rules('insurance_company', 'Insurance Company', 'trim|xss_clean');
            $this->form_validation->set_rules('insurance_exp_date', 'Insurance Expiry Date', 'trim|xss_clean');
            $this->form_validation->set_rules('vehicle_avail_status', 'Vehicle Availability Status', 'trim|xss_clean');
            $this->form_validation->set_rules('seating_capacity', 'Seating Capacity', 'trim|xss_clean');
            $this->form_validation->set_rules('engine_capacity', 'Engine Capacity', 'trim|xss_clean');
            $this->form_validation->set_rules('daily_rate', 'Daily Rate', 'trim|xss_clean');
            $this->form_validation->set_rules('weekly_rate', 'weekly Rate', 'trim|xss_clean');
            $this->form_validation->set_rules('month_rate', 'Month Rate', 'trim|xss_clean');
            $this->form_validation->set_rules('extra_km', 'Extra Km', 'trim|xss_clean');
            $this->form_validation->set_rules('gps_id', 'GPS ID', 'trim|xss_clean');
            $this->form_validation->set_rules('date_fleet_inclusion', 'Date of Fleet Inclusion', 'trim|xss_clean');
            $this->form_validation->set_rules('fuel_type', 'Fuel Type', 'trim|xss_clean');
            $this->form_validation->set_rules('remarks', 'Remarks', 'trim|xss_clean');
            
            if ($this->form_validation->run() == true)
            {
                if($this->input->post('brand') == 0)
                {
                    $brand = $this->input->post('model');
                }
                else{
                    $brand = $this->input->post('brand');
                }
                if($_FILES['image']['size'] > 0)
                {
                    $ext1 = end(explode(".", $_FILES['image']['name']));
                    $file_name = "vehicle-".$vehicle_id.".".$ext1;
                    $image_path = realpath(APPPATH."../assets/uploads/vehicles/");
                    $config = array(
                    'upload_path' => $image_path,
                    'allowed_types' => "gif|jpg|png|jpeg|pdf",
                    'overwrite' => TRUE,
                    // 'max_size' => "2048000", // Can be set to particular file size , here it is 2 MB(2048 Kb)
                    // 'max_height' => "1440",
                    // 'max_width' => "900",
                    'file_name' => $file_name
                    );
                    // echo '<pre>';
                    // print_r($config);
                    $this->upload->initialize($config);
                    if($this->upload->do_upload('image'))
                    {
                        $data = array('image' => $this->upload->data());
                    }
                    else
                    {
                        // echo '<pre>';    
                        $error = array('error' => $this->upload->display_errors());
                        // print_r($error);
                        $this->load->view('add', $error);
                    }
                }
                else
                {
                    $data['image']['file_name'] = $this->input->post('image_edit');
                }
                $vehicleDetail = array(
                    'vehicle_reg_no'       =>  $this->input->post('vehicle_reg_no'),
                    'branch_id'	        =>	$this->input->post('branch'),
                    'owner'          =>  $this->input->post('owner'),
                    'finance_company'         =>  $this->input->post('finance_company'),
                    'brand'         =>  $brand,
                    'trans_type'             =>  $this->input->post('trans_type'),
                    'vehicle_type'             =>  $this->input->post('vehicle_type'),
                    'model'    =>  $this->input->post('model'),
                    'model_year'    =>  $this->input->post('model_year'),
                    'reg_expiry_date' => $this->input->post('reg_exp_date'),
                    'insurance_type'    =>  $this->input->post('insurance_type'),
                    'breakdown_recovery'    =>  $this->input->post('breakdown_recovery'),
                    'insurance_company'    =>  $this->input->post('insurance_company'),
                    'insurance_exp_date'    =>  $this->input->post('insurance_exp_date'),
                    'vehicle_avail_status'    =>  $this->input->post('vehicle_avail_status'),
                    'image'    =>  $data['image']['file_name'],
                    'seating_capacity'    =>  $this->input->post('seating_capacity'),
                    'engine_capacity'    =>  $this->input->post('engine_capacity'),
                    'daily_rate'    =>  $this->input->post('daily_rate'),
                    'weekly_rate'    =>  $this->input->post('weekly_rate'),
                    'month_rate'    =>  $this->input->post('month_rate'),
                    'extra_km'    =>  $this->input->post('extra_km'),
                    'vehicle_cost'    =>  $this->input->post('vehicle_cost'),
                    'gps_id'    =>  $this->input->post('gps_id'),
                    'date_fleet_inclusion'    =>  $this->input->post('date_fleet_inclusion'),
                    'fuel_type'    =>  $this->input->post('fuel_type'),
                    'remarks'    =>  $this->input->post('remarks'),
                );
                    // echo '<pre>';
                    // print_r($vehicleDetail);exit;
            }
            
            if ( ($this->form_validation->run() == true) && $this->vehicle_model->updateVehicle($vehicleDetail,$vehicle_id))
            {  
                $this->session->set_flashdata('success', 'Vehicle edited successfully.');
                redirect("vehicle",'refresh');
            }
            else
            {  
                $vehicle_details = $this->vehicle_model->getVehicleById($vehicle_id);
                $data['brand']  = $this->vehicle_model->getBrand();
                // echo '<pre>';
                // print_r($vehicle_details);exit;
                $data['id'] = $vehicle_id;
                $data['vehicle'] = $vehicle_details;
                $data['branch'] = $this->vehicle_model->getBranch();
                $data['owner'] = $this->vehicle_model->getOwner();
                $meta['page_title'] = 'Edit Vehicle';
                $data['page_title'] = "Edit Vehicle";
                $this->load->view('commons/header', $meta);
                $this->load->view('edit', $data);
                $this->load->view('commons/footer');
            
            }
        }
        else
        {
            $vehicle_details = $this->vehicle_model->getVehicleById($vehicle_id);
            // echo '<pre>';
            // print_r($vehicle_details);exit;
            $data['vehicle'] = $vehicle_details;
            $data['id'] = $vehicle_id;
            $data['brand']  = $this->vehicle_model->getBrand();
            //$data['models']  = $this->vehicle_model->getAllModel();
            $data['branch'] = $this->vehicle_model->getBranch();
            $data['owner'] = $this->vehicle_model->getOwner();
            $meta['page_title'] = 'Edit Vehicle';
            $data['page_title'] = "Edit Vehicle";
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
    
    public function delete($vehicle_id)
    {
        $id = $vehicle_id;
        if($this->vehicle_model->deleteVehicle($id))
        {
            $this->session->set_flashdata('success', 'Vehicle deleted successfully.');
            redirect("vehicle",'refresh');
        }
    }
}
?>