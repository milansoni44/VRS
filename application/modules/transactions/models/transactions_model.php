<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Transactions_model extends CI_Model{
    
    function __construct()
	{
		parent::__construct();
		$this->load->library('Datatables');
        $this->load->library('table');
    }
    
    function getLedger(){
        $this->db->select('id,title');
        $this->db->from('ledger');
        $rs = $this->db->get();
        if($rs->num_rows() > 0){
            return $rs->result_array();
        }
        return false;
    }
    
    function getAccountStatementPeriod($start,$end,$rental_type){
        
        $wh = "`transaction_date` between '".$start."' and '".$end."'";
        
        if($rental_type == 'rental'){
            $this->db->select('transaction_id,vehicle.vehicle_reg_no,transaction_date,narration,CrAmount,DrAmount');
            $this->db->from('account_statement');
            $this->db->join('vehicle','vehicle.id = account_statement.vehicle_id');
            $this->db->where($wh);
        }else{
            $this->db->select('transaction_id,transaction_date,narration,CrAmount,DrAmount');
            $this->db->from('account_statement');
            $this->db->where($wh);
            $this->db->where('vehicle_id',0);
        }
        $rs = $this->db->get();
        // echo $this->db->last_query();exit;
        if($rs->num_rows() > 0){
            return $rs->result_array();
        }
        return false;
    }
    
    function getLedgerWiseTransaction($start_date,$end_date,$ledger){
        
        $wh = "STR_TO_DATE(`transaction_date`,'%d/%m/%Y')"." between STR_TO_DATE('".$start_date."','%d/%m/%Y') and STR_TO_DATE('".$end_date."','%d/%m/%Y')";
        
        if($ledger == 0){
            $this->db->select('transaction_id,transaction_date,narration,title,DrAmount,CrAmount');
            $this->db->from('ledger_wise_transaction');
            $this->db->where($wh);
        }else{
            $this->db->select('transaction_id,transaction_date,narration,title,DrAmount,CrAmount');
            $this->db->from('ledger_wise_transaction');
            $this->db->where($wh);
            $this->db->where('id',$ledger);
        }
        $rs = $this->db->get();
        
        if($rs->num_rows() > 0){
            return $rs->result_array();
        }
        return false;
    }
    
    function getTotalAmount($start_date, $end_date,$rental_type){
        $wh = "`transaction_date` between '".$start_date."' and '".$end_date."'";
        
        if($rental_type == "rental"){
            $this->db->select('SUM(CrAmount) as CreditTotal,SUM(DrAmount) as DebitTotal');
            $this->db->from('account_statement');
            $this->db->join('vehicle','vehicle.id = account_statement.vehicle_id');
            $this->db->where($wh);
        }else{
            $this->db->select('SUM(CrAmount) as CreditTotal,SUM(DrAmount) as DebitTotal');
            $this->db->from('account_statement');
            $this->db->where($wh);
        }
        $q = $this->db->get();
        // echo $this->db->last_query();exit;
        if($q->num_rows() > 0){
            return $q->row();
        }
        return false;
    }
    function getLedgerTotalAmount($start_date, $end_date, $ledger){
        $wh = "STR_TO_DATE(`transaction_date`,'%d/%m/%Y')"." between STR_TO_DATE('".$start_date."','%d/%m/%Y') and STR_TO_DATE('".$end_date."','%d/%m/%Y')";
        
        if($ledger == 0){
            $this->db->select('SUM(CrAmount) as CrAmount, SUM(DrAmount) as DrAmount');
            $this->db->from('ledger_wise_transaction');
            $this->db->where($wh);
        }else{
            $this->db->select('SUM(CrAmount) as CrAmount, SUM(DrAmount) as DrAmount');
            $this->db->from('ledger_wise_transaction');
            $this->db->where($wh);
            $this->db->where('id',$ledger);
        }
        $q = $this->db->get();
        
        if($q->num_rows() > 0){
            return $q->row();
        }
        return false;
    }
    
    function getLedgerUnique($start_date,$end_date){
        // $wh = "STR_TO_DATE(`transaction_date`,'%d/%m/%Y')"." between STR_TO_DATE('".$start_date."','%d/%m/%Y') and STR_TO_DATE('".$end_date."','%d/%m/%Y')";
        $this->db->distinct();
        $this->db->select('id,title');
        $this->db->from('ledger');
        // $this->db->where($wh);
        $q = $this->db->get();
        if($q->num_rows() > 0){
            return $q->result_array();
        }
        return false;
    }
    
    // ledger wise transaction
    function getHeaderDetail($start_date,$end_date,$ledger){
        $wh = "STR_TO_DATE(`TransactionDate`,'%d/%m/%Y')"." between STR_TO_DATE('".$start_date."','%d/%m/%Y') and STR_TO_DATE('".$end_date."','%d/%m/%Y')";
        if($ledger == 0){
            $query = $this->db->query("SELECT * from header_detail where ".$wh);
        }else{
            $query = $this->db->query("SELECT * from header_detail where ".$wh." AND Ledger = ".$ledger);
        }
        // echo $this->db->last_query();exit;
        if ($query->num_rows() > 0)
        {
            foreach ($query->result() as $row)
           {
              $row1[] = $row;
           }
           return $row1;
        }
        return false;
    }
    
    function getHeaderDetailArray($start_date,$end_date,$ledger){
        $wh = "STR_TO_DATE(`TransactionDate`,'%d/%m/%Y')"." between STR_TO_DATE('".$start_date."','%d/%m/%Y') and STR_TO_DATE('".$end_date."','%d/%m/%Y')";
        if($ledger == 0){
            $query = $this->db->query("SELECT header_detail.TransactionId,header_detail.TransactionDate,header_detail.vehicle_reg_no,ledger.title,header_detail.Description,header_detail.CrAmount,header_detail.DrAmount from header_detail JOIN ledger ON ledger.id = header_detail.Ledger where ".$wh);
        }else{
            $query = $this->db->query("SELECT header_detail.TransactionId,header_detail.TransactionDate,header_detail.vehicle_reg_no,ledger.title,header_detail.Description,header_detail.CrAmount,header_detail.DrAmount from header_detail JOIN ledger ON ledger.id = header_detail.Ledger where ".$wh." AND Ledger = ".$ledger);
        }
        // echo $this->db->last_query();exit;
        if ($query->num_rows() > 0)
        {
            foreach ($query->result_array() as $row)
           {
              $row1[] = $row;
           }
           return $row1;
        }
        return false;
    }
    
    
    function unique_ledger_from_transaction($start_date,$end_date){
        // here write query of distinct to get unique ledger from transaction table 
        // make array of that renturn in funtion
        
        $wh = "STR_TO_DATE(`TransactionDate`,'%d/%m/%Y')"." between STR_TO_DATE('".$start_date."','%d/%m/%Y') and STR_TO_DATE('".$end_date."','%d/%m/%Y')";

        
        $array_of_unique_ledger = $this->db->query("SELECT DISTINCT(Ledger) from header_detail WHERE ".$wh);
        // echo $this->db->last_query();exit;
        if ($array_of_unique_ledger->num_rows() > 0)
        {
            foreach ($array_of_unique_ledger->result_array() as $row)
            {
                $row1[] = $row;
            }
            return $row1;
        }
        return FALSE;
    }
    function transaction_of_single_ledger($ledger_id,$start_date,$end_date){
        // write quest to get the all transaction detail of specific ledger from transaction table 
        // and return to function
        $wh = "STR_TO_DATE(`TransactionDate`,'%d/%m/%Y')"." between STR_TO_DATE('".$start_date."','%d/%m/%Y') and STR_TO_DATE('".$end_date."','%d/%m/%Y')";
        
        $this->db->select('*');
        $this->db->from('header_detail');
        $this->db->where('header_detail.Ledger',$ledger_id);
        $this->db->where($wh);
        // $this->db->order_by("header_detail.Ledger");
        
        $q = $this->db->get();
              
        if($q->num_rows() > 0){
            $tempArry =$q->result_array();
            // print_r($tempArry);exit;
            $tempSingleTransaction = "";
            for($i=0; $i<sizeof($tempArry); $i++){
                $tempSingleTransaction .= $tempArry[$i]['TransactionId'].'+';
                $tempSingleTransaction .= $tempArry[$i]['TransactionDate'].'+';
                $tempSingleTransaction .= $tempArry[$i]['vehicle_reg_no'].'+';
                $tempSingleTransaction .= $tempArry[$i]['Description'].'+';
                $tempSingleTransaction .= $tempArry[$i]['DrAmount'].'+';
                $tempSingleTransaction .= $tempArry[$i]['CrAmount'];
                if($i != (sizeof($tempArry)-1)){
                    $tempSingleTransaction .= "*";
                }        
            }
            return $tempSingleTransaction;
        }
        return FALSE;
    }
    
    function getLedgerTitle($ledger_id){
        $this->db->select('title');
        $this->db->from('ledger');
        $this->db->where('id',$ledger_id);
        $q = $this->db->get();
        
        if($q->num_rows() > 0){
            foreach($q->result() as $row)
            {
                return $row->title;
            }
        }
        return FALSE;
    }
    function getTotalLedger($ledger,$start_date,$end_date){
        // echo $ledger;exit;
        $wh = "STR_TO_DATE(`TransactionDate`,'%d/%m/%Y')"." between STR_TO_DATE('".$start_date."','%d/%m/%Y') and STR_TO_DATE('".$end_date."','%d/%m/%Y')";
        if($ledger == 0){
            $this->db->select('SUM(CrAmount) as CreditTotal,SUM(DrAmount) as DebitTotal');
            $this->db->from('header_detail');
            $this->db->where($wh);
            $q = $this->db->get();
        }else{
            $this->db->select('SUM(CrAmount) as CreditTotal,SUM(DrAmount) as DebitTotal');
            $this->db->from('header_detail');
            $this->db->where($wh);
            $this->db->where('header_detail.Ledger',$ledger);
            $q = $this->db->get();
        }
        if($q->num_rows() > 0){
            return $q->row();
        }
        return false;
    }
    function getVehicle(){
        $this->db->select('id,vehicle_reg_no,brand');
        $this->db->from('vehicle');
        $rs = $this->db->get();
        if($rs->num_rows() > 0){
            return $rs->result_array();
        }
        return false;
    }
	
	function getVehicleIncomeExpense($start_date,$end_date,$vehicle){
		$wh = "`transaction_date` between '".$start_date."' and '".$end_date."'";
		if($vehicle == 0){
			$this->db->select('income_expense.vehicle_reg_no,income_expense.brand,vehicle_owner.name,SUM(income) as Income,SUM(expense) as Expense');
			$this->db->from('income_expense');
            $this->db->join('vehicle','vehicle.id = income_expense.id');
            $this->db->join('vehicle_owner','vehicle_owner.id = vehicle.owner_id');
			$this->db->where($wh);
			$this->db->group_by('income_expense.id');
            $this->db->order_by('vehicle_owner.id');
		}else{
			$this->db->select('income_expense.vehicle_reg_no,income_expense.brand,vehicle_owner.name,SUM(income) as Income,SUM(expense) as Expense');
            $this->db->from('income_expense');
            $this->db->join('vehicle','vehicle.id = income_expense.id');
            $this->db->join('vehicle_owner','vehicle_owner.id = vehicle.owner_id');
            $this->db->where($wh);
            $this->db->where('income_expense.id',$vehicle);
		}
		$q = $this->db->get();
		if($q->num_rows()>0){
			return $q->result_array();
		}
		return false;
	}
	
	function getVehicleIncomeExpenseDetail($start_date,$end_date,$vehicle){
		$wh = "`transaction_date` between '".$start_date."' and '".$end_date."'";
		if($vehicle == 0){
			$this->db->select('transaction_id,transaction_date,vehicle_reg_no,brand,description,income,expense');
			$this->db->from('income_expense');
			$this->db->where($wh);
		}else{
			$this->db->select('transaction_id,transaction_date,vehicle_reg_no,brand,description,income,expense');
            $this->db->from('income_expense');
            $this->db->where($wh);
            $this->db->where('id',$vehicle);
		}
		$q = $this->db->get();
		if($q->num_rows()>0){
			return $q->result_array();
		}
		return false;
	}
}
?>