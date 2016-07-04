<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Home_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->load->library('Datatables');
        $this->load->library('table');
	}
	
	function getAllAvailableVehicles() 
	{
        $this->db->select('*');
        $this->db->from('vehicle');
        $this->db->where('vehicle_availibility','Available');
        $q = $this->db->get();
		if($q->num_rows() > 0) {
				return $q->num_rows();
			}
				
			return 0;
	}
    
    function getAllRentedVehicles() 
	{
        $this->db->select('*');
        $this->db->from('vehicle');
        $this->db->where('vehicle_availibility','Rented');
        $q = $this->db->get();
		if($q->num_rows() > 0) {
				return $q->num_rows();
			}
				
			return 0;
	}
    
    function getAllRepairVehicles() 
	{
        $this->db->select('*');
        $this->db->from('vehicle');
        $this->db->where('vehicle_availibility','Repair');
        $q = $this->db->get();
		if($q->num_rows() > 0) {
				return $q->num_rows();
			}
				
			return 0;
	}
	
	function getAllVehicles() 
	{
		$q = $this->db->get('vehicle');
		if($q->num_rows() > 0) {
				return $q->num_rows();
			}
				
			return FALSE;
	}
    
    function getTotalIncome(){
        $this->db->select('SUM(dr_amount) as income');
        $this->db->from('transaction_detail');
        $this->db->join('ledger','ledger.id = transaction_detail.ledger_no');
        $this->db->where('ledger.title','RENTAL CHARGES');
        $q = $this->db->get();
        // echo $this->db->last_query();exit;
        if($q->num_rows() > 0){
            return $q->row();
        }
        return 0;
    }
    
    function getTotalIncomeDay($current_date){
        $wh = "STR_TO_DATE(`voucher_date`,'%d/%m/%Y')"." = STR_TO_DATE('".$current_date."','%d/%m/%Y')";
        
        $this->db->select('SUM(cr_amount) as income');
        $this->db->from('transaction_header');
        $this->db->join('transaction_detail','transaction_detail.transaction_id = transaction_header.transaction_id');
        $this->db->join('ledger','ledger.id = transaction_detail.ledger_no');
        $this->db->where('ledger.id',13);
        $this->db->where($wh);
        $q = $this->db->get();
        // echo $this->db->last_query();exit;
        if($q->num_rows() > 0){
            $dayIncome = $q->row();
            if($dayIncome->income == NULL){
                return 0.000;
            }else{
                // return $dayIncome->income;
                $rental_return = $this->getTotalRentalReturnDay($current_date);
                return ($dayIncome->income-$rental_return);
            }
        }
        // return (object)array('income'=>'0');
    }
    
    function getTotalRentalReturnDay($current_date){
        $wh = "STR_TO_DATE(`voucher_date`,'%d/%m/%Y')"." = STR_TO_DATE('".$current_date."','%d/%m/%Y')";
        
        $this->db->select('SUM(dr_amount) as income');
        $this->db->from('transaction_header');
        $this->db->join('transaction_detail','transaction_detail.transaction_id = transaction_header.transaction_id');
        $this->db->join('ledger','ledger.id = transaction_detail.ledger_no');
        $this->db->where('ledger.id',26);
        $this->db->where($wh);
        $q = $this->db->get();
        if($q->num_rows() > 0){
            $dayIncome = $q->row();
            if($dayIncome->income == NULL){
                return 0.000;
            }else{
                // return $dayIncome->income;
                return $dayIncome->income;
            }
        }
    }
    
    function getTotalExpenseDay($current_date){
        
        $ignore = array(25,26,13,4,5,6,18);
        $wh = "STR_TO_DATE(`voucher_date`,'%d/%m/%Y')"." = STR_TO_DATE('".$current_date."','%d/%m/%Y')";

        $this->db->select('SUM(dr_amount) as expense');
        $this->db->from('transaction_header');
        $this->db->join('transaction_detail','transaction_detail.transaction_id = transaction_header.transaction_id');
        $this->db->join('ledger','ledger.id = transaction_detail.ledger_no');
        $this->db->where_not_in('ledger.id',$ignore);
        $this->db->where('ledger.type','Expenditure');
        $this->db->where($wh);
        $q = $this->db->get();
        // echo $this->db->last_query();exit;
        if($q->num_rows() > 0){
            $dayExpense = $q->row();
            if($dayExpense->expense == NULL){
                return 0.000;
            }else{
                return $dayExpense->expense;
            }
        }
        // return (object)array('expense'=>0);
    }
    
    function getTransactionforMonthIncome($current){
        // $wh = "STR_TO_DATE(`voucher_date`,'%m/%Y')"." = STR_TO_DATE('".$current."','%m/%Y')";
        $like = '/'.$current;
        $this->db->select('SUM(cr_amount) as monthly_income');
        $this->db->from('transaction_header');
        $this->db->join('transaction_detail','transaction_detail.transaction_id = transaction_header.transaction_id');
        $this->db->join('ledger','ledger.id = transaction_detail.ledger_no');
        $this->db->where('ledger.id',13);
        $this->db->like('transaction_header.voucher_date',$like,'before');
        $q = $this->db->get();
        // echo $this->db->last_query();exit;
        if($q->num_rows() > 0){
            $monthly_income = $q->row();
            if($monthly_income->monthly_income == NULL){
                return 0.000;
            }else{
                $rental_return = $this->getTotalRentalReturnMonth($current);
                return ($monthly_income->monthly_income-$rental_return);
            }
        }
        // return (object)array('monthly_income'=>0);
    }
    
    function getTotalRentalReturnMonth($current){
        
        $like = '/'.$current;
        $this->db->select('SUM(dr_amount) as monthly_income');
        $this->db->from('transaction_header');
        $this->db->join('transaction_detail','transaction_detail.transaction_id = transaction_header.transaction_id');
        $this->db->join('ledger','ledger.id = transaction_detail.ledger_no');
        $this->db->where('ledger.id',26);
        $this->db->like('transaction_header.voucher_date',$like,'before');
        $q = $this->db->get();
        // echo $this->db->last_query();exit;
        if($q->num_rows() > 0){
            $monthly_income = $q->row();
            if($monthly_income->monthly_income == NULL){
                return 0.000;
            }else{
                return $monthly_income->monthly_income;
            }
        }
    }
    
    function getTransactionforMonthExpense($current){
        $ignore = array(25,26,13,4,5,6,18);
        $like = '/'.$current;
        // $wh = "STR_TO_DATE(`voucher_date`,'%d/%m/%Y')"." = STR_TO_DATE('".$current_date."','%d/%m/%Y')";

        $this->db->select('SUM(dr_amount) as monthly_expense');
        $this->db->from('transaction_header');
        $this->db->join('transaction_detail','transaction_detail.transaction_id = transaction_header.transaction_id');
        $this->db->join('ledger','ledger.id = transaction_detail.ledger_no');
        $this->db->where_not_in('ledger.id',$ignore);
        $this->db->where('ledger.type','Expenditure');
        $this->db->like('transaction_header.voucher_date',$like,'before');
        $q = $this->db->get();
        // echo $this->db->last_query();exit;
        if($q->num_rows() > 0){
            $monthly_expense = $q->row();
            if($monthly_expense->monthly_expense == NULL){
                return 0.000;
            }else{
                return $monthly_expense->monthly_expense;
            }
        }
        // return (object)array('monthly_expense'=>0);
    }
	
	function get_calendar_data($year, $month) {
		
		$query = $this->db->select('date, data')->from('calendar')
			->like('date', "$year-$month", 'after')->get();
			
		$cal_data = array();
		
		foreach ($query->result() as $row) {
			$day = (int)substr($row->date,8,2);
			$cal_data[$day] = str_replace("|", "<br>", html_entity_decode($row->data));
		}
		
		return $cal_data;
		
	}
}

/* End of file home_model.php */ 
/* Location: ./sma/modules/home/models/home_model.php */
