<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Webservices_model extends CI_Model{
    function __construct()
	{
		parent::__construct();
		$this->load->library('Datatables');
        $this->load->library('table');
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
                return 0;
            }else{
                // return $dayIncome->income;
                $rental_return = $this->getTotalRentalReturnDay($current_date);
                return ($dayIncome->income-$rental_return);
            }
        }
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
                return 0;
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
                return 0;
            }else{
                return $dayExpense->expense;
            }
        }
        // return (object)array('expense'=>0);
    }
    
    function getDaywiseIncome($days){
        $wh = "STR_TO_DATE(`voucher_date`,'%d/%m/%Y')"." = STR_TO_DATE('".$days."','%d/%m/%Y')";
        
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
                return 0;
            }else{
                // return $dayIncome->income;
                $rental_return = $this->getTotalRentalReturnDay($days);
                return ($dayIncome->income-$rental_return);
            }
        }
    }
    function getDaywiseExpense($date){
        
        $ignore = array(25,26,13,4,5,6,18);
        $wh = "STR_TO_DATE(`voucher_date`,'%d/%m/%Y')"." = STR_TO_DATE('".$date."','%d/%m/%Y')";

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
                return 0;
            }else{
                return $dayExpense->expense;
            }
        }
        // return (object)array('expense'=>0);
    }
    
    function vehicleIncomeByRent($current){
        $like = '/'.$current;
        $this->db->select('vehicle.vehicle_reg_no,SUM(cr_amount) as income');
        $this->db->from('transaction_header');
        $this->db->join('transaction_detail','transaction_detail.transaction_id = transaction_header.transaction_id');
        $this->db->join('ledger','ledger.id = transaction_detail.ledger_no');
        $this->db->join('vehicle','vehicle.id = transaction_header.vehicle_id');
        $this->db->where('transaction_header.vehicle_id !=',0);
        $this->db->where_in('ledger.id',13);
        $this->db->group_by('vehicle.vehicle_reg_no');
        $this->db->order_by('income','desc');  
        $this->db->like('transaction_header.voucher_date',$like,'before');
        $this->db->limit(5);
        $q = $this->db->get();
        // echo $this->db->last_query();exit;
        if($q->num_rows() > 0){
            // foreach($q->result() as $row){
                // $row1[] = $row;
            // }
            // return $row1;
            return $q->result_array();
        }
    }
    
    function vehicleIncomeByRentLeast($current){
        $like = '/'.$current;
        $this->db->select('vehicle.vehicle_reg_no,SUM(cr_amount) as incomeleast');
        $this->db->from('transaction_header');
        $this->db->join('transaction_detail','transaction_detail.transaction_id = transaction_header.transaction_id');
        $this->db->join('ledger','ledger.id = transaction_detail.ledger_no');
        $this->db->join('vehicle','vehicle.id = transaction_header.vehicle_id');
        $this->db->where('transaction_header.vehicle_id !=',0);
        $this->db->where_in('ledger.id',13);
        $this->db->group_by('vehicle.vehicle_reg_no');
        $this->db->order_by('incomeleast',"asc");  
        $this->db->like('transaction_header.voucher_date',$like,'before');
        $this->db->limit(5);
        $q = $this->db->get();
        // echo $this->db->last_query();exit;
        if($q->num_rows() > 0){
            // foreach($q->result() as $row){
                // $row1[] = $row;
            // }
            // return $row1;
            return $q->result_array();
        }
    }
    
}
?>