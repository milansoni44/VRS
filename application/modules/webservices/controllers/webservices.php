<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Webservices extends CI_Controller
{
    function __construct()
	{
		parent::__construct();
		
		// check if user logged in 
		if (!$this->ion_auth->logged_in())
	  	{
			redirect('auth/login');
	  	}
		$this->load->library('Ion_auth');
		$this->security->csrf_verify(); 
		$this->load->model('webservices_model');
    }

    function DailyIncomeAndExpense()
    {
        if (!$this->ion_auth->logged_in())
	  	{
			redirect('auth/login');
	  	}
        
        $date = date('d/m/Y');
        $dayIncome = $this->webservices_model->getTotalIncomeDay($date);
            
        $dayExpense = $this->webservices_model->getTotalExpenseDay($date);
        
        //webservice
        echo json_encode(array('dayIncome'=>$dayIncome,'dayExpense'=>$dayExpense));
    }
    
    function getDaywiseIncome(){
        $d=cal_days_in_month(CAL_GREGORIAN,date('m'),date('Y'));
        for($i=0;$i<$d;$i++){
            $d1 = date('m/Y');
            $days = ($i+1)."/".$d1;
            $dayWiseIncome[] = intval($this->webservices_model->getDaywiseIncome($days));
        }
        
        echo json_encode($dayWiseIncome);
    }
    function getDaywiseExpense(){
        $d=cal_days_in_month(CAL_GREGORIAN,date('m'),date('Y'));
        for($i=0;$i<$d;$i++){
            $d1 = date('m/Y');
            $days = ($i)."/".$d1;
            $dayWiseExpense[] = intval($this->webservices_model->getDaywiseExpense($days));
        }
        echo json_encode($dayWiseExpense);
    }
    function getDaywiseIncomeExpense(){
        $d=cal_days_in_month(CAL_GREGORIAN,date('m'),date('Y'));
        for($i=1;$i<=$d;$i++){
            $d1 = date('m/Y');
            $days = ($i)."/".$d1;
            $dayWiseIncome[] = intval($this->webservices_model->getTotalIncomeDay($days));
            $dayWiseExpense[] = intval($this->webservices_model->getTotalExpenseDay($days));
            $days1[]= "".(string)$i."";
            
            
        }
        //echo json_encode(array('income'=>$dayWiseIncome,'expense'=>$dayWiseExpense,'days'=>$days1));
        $income[] = "Income";
        $expense[] = "Expense";
        echo json_encode(array('income'=>array_merge($income,$dayWiseIncome),'expense'=>array_merge($expense,$dayWiseExpense)));
    }
    
    function vehicleIncomeByRent(){
        $current = date('m/Y');
        $vehicleIncome = $this->webservices_model->vehicleIncomeByRent($current);
        // echo '<pre>';
        // print_r($vehicleIncome);
        $v_income = array();
        $v_vehicle_reg_no = array();
        foreach($vehicleIncome as $vI){
            $v_vehicle_reg_no[] = $vI['vehicle_reg_no'];
            $v_income[]= $vI['income'];
            //echo $vI['vehicle_reg_no'].'<br>';
        }
       // print_r($v_income);
       // for($i=0; $i<sizeof($v_income); $i++ ){
           // echo $v_income[$i];
       // }
       echo json_encode(array('vehicle_reg_no'=>$v_vehicle_reg_no,'income'=>$v_income));
    }
    
    function vehicleIncomeByRentLeast(){
        $current = date('m/Y');
        $vehicleIncomeLeast = $this->webservices_model->vehicleIncomeByRentLeast($current);
        // echo '<pre>';
        // print_r($vehicleIncomeLeast);
        foreach($vehicleIncomeLeast as $vI){
            $v_vehicle_reg_no[] = $vI['vehicle_reg_no'];
            $v_income[]= $vI['incomeleast'];
        }
        // echo json_encode($vehicleIncomeLeast);
        echo json_encode(array('vehicle_reg_no'=>$v_vehicle_reg_no,'income'=>$v_income));
    }
}
?>