<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

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
		$this->load->model('home_model');
		$this->load->library('Datatables');
		$this->load->library('session');
		
	}
	
   function index()
   {
	   if (!$this->ion_auth->logged_in())
	  	{
			redirect('auth/login');
	  	}
	  else
		{
            $data['total_vehicle'] = $this->home_model->getAllVehicles();
            $data['total_available'] = $this->home_model->getAllAvailableVehicles();
            $data['total_rented'] = $this->home_model->getAllRentedVehicles();
            $data['total_repair'] = $this->home_model->getAllRepairVehicles();
            $data['dayIncome'] = number_format((float)$this->home_model->getTotalIncomeDay(date('d/m/Y')),3,'.','');
            
            // $b = array("labels" => array("fuck","sex","bhos"),"datasets"=> array(array("2"=>"2_fuck","3"=>"3_sex"),array("2"=>"2_fuck","3"=>"3_sex")));
            $date = date('d/m/Y');
            $data['dayExpense'] = number_format((float)$this->home_model->getTotalExpenseDay(date('d/m/Y')),3,'.','');
            
            //webservice
            
            
            
            $current = date('m/Y');
            
            $data['monthly_income'] = number_format((float)$this->home_model->getTransactionforMonthIncome($current),3,'.',''); 
            $data['monthly_expense'] = number_format((float)$this->home_model->getTransactionforMonthExpense($current),3,'.',''); 
            // echo '<pre>';
            // print_r($data['monthly_expense']);exit;
            //$data['num_employer'] = $this->home_model->getAllEmployers();
            $meta['page_title'] = 'Home';
            $data['page_title'] = "Home";
            $this->load->view('commons/header', $meta);
            $this->load->view('index', $data);
            $this->load->view('commons/footer');
		}
   	}
   
   function candidates_details()
    {
        $this->datatables->select('id,code,position,name,dob,Nationality,birthplace')
        ->unset_column('id')
        ->from('candidate')
		->add_column("Actions", "<a href='candidate/view_single_candidate/$1'>View</a>", "id");
		
        echo $this->datatables->generate();
    }
	
	function view_candidate()
	{
		$this->load->view('view_candidate');
	}
	
	function employer_details()
    {
        $this->datatables->select('employer.id,company_name,contact_person,contact_number,employer.position,candidate.name as candidate_name,status')
        ->unset_column('employer.id')
		->from('employer')
		->join('candidate', 'candidate.id=employer.candidate_id', 'INNER')
		->add_column("Actions", "<a href='employer/view_single_employer/$1'>View</a>", "employer.id");
		
        echo $this->datatables->generate();
    }
	
	function view_employer()
	{
		$this->load->view('view_employer');
	}
	
   function language($lang = false){
	    if($this->input->get('lang')){ $lang = $this->input->get('lang'); }
		$this->load->helper('cookie');
		$folder = 'sma/language/';
		$languagefiles = scandir($folder);
		if(in_array($lang, $languagefiles)){
		//setcookie("sma_language", $lang, '31536000');
		$cookie = array(
                   'name'   => 'language',
                   'value'  => $lang,
                   'expire' => '31536000',
				   'prefix' => 'sma_',
				   'secure' => false
               );
 
		$this->input->set_cookie($cookie);
		}
		redirect($_SERVER["HTTP_REFERER"]); 
	}
	
}
 