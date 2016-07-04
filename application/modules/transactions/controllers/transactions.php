<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Transactions extends CI_Controller
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
		$this->load->model('transactions_model');
        $this->load->library('upload');
		$this->load->library('Datatables');
        $this->load->library('excel');
    }
    
    function account_statement(){
        
        if (!$this->ion_auth->logged_in())
	  	{
			redirect('auth/login');
	  	}
        //validation for date
        $this->form_validation->set_rules('start_date','Start Date','required|trim');
        $this->form_validation->set_rules('end_date','End Date','required|trim');
        
        if($this->form_validation->run() == true){
            $start_date = $this->input->post('start_date');
            $end_date = $this->input->post('end_date');
            $rental_type = $this->input->post('rental_type');
            // $data['amount'] = $this->transactions_model->getTotalAmount($start_date,$end_date,$rental_type);
            // echo '<pre>';
            // print_r($data['amount']);exit;
            $meta['page_title'] = 'Cash Book';
            $data['page_title'] = "Cash Book";
            $this->load->view('commons/header',$meta);
            $this->load->view('account_statement',$data);
            $this->load->view('commons/footer');
        }else{
            $meta['page_title'] = 'Cash Book';
            $data['page_title'] = "Cash Book";
            $this->load->view('commons/header',$meta);
            $this->load->view('account_statement',$data);
            $this->load->view('commons/footer');
        }
    }
    
    function account_statement_details(){
        
        $start_date = $this->input->get('start_date');
        $starting = explode('/',$start_date);
        $start = $starting[2]."-".$starting[1]."-".$starting[0];
        $end_date = $this->input->get('end_date');
        $ending = explode('/',$end_date);
        $end = $ending[2]."-".$ending[1]."-".$ending[0];
        $rental_type = $this->input->get('rental_type');
        
        $wh = "`transaction_date` between '".$start."' and '".$end."'";
        if($rental_type == "rental"){
            $this->datatables->select('transaction_id,transaction_date,vehicle.vehicle_reg_no,narration,CrAmount,DrAmount')
            ->from('account_statement')
            ->join('vehicle','vehicle.id = account_statement.vehicle_id')
            ->where($wh);
        }else{
            $this->datatables->select('transaction_id,transaction_date,vehicle_no,narration,CrAmount,DrAmount')
            ->from('account_statement')
            ->where('vehicle_id',0)
            ->where($wh);
        }
        
        echo $this->datatables->generate();
    }
    
    function export_account_statement(){
        $start_date = $this->input->get('start_date');
        $starting = explode('/',$start_date);
        $start = $starting[2]."-".$starting[1]."-".$starting[0];
        $end_date = $this->input->get('end_date');
        $ending = explode('/',$end_date);
        $end = $ending[2]."-".$ending[1]."-".$ending[0];
        $rental_type = $this->input->get('rental_type');
        
        $this->excel->setActiveSheetIndex(0);
        //name the worksheet
        $this->excel->getActiveSheet()->setTitle('Account Statement List Period');
        //set cell A1 content with some text
        if($rental_type == "rental"){
            $this->excel->getActiveSheet()->setCellValue('A1', "Account Statement for a Period $start_date and $end_date");
            $this->excel->getActiveSheet()->setCellValue('A3', 'Transaction No');
            $this->excel->getActiveSheet()->setCellValue('B3', 'Vehicle No');
            $this->excel->getActiveSheet()->setCellValue('C3', 'Transaction Date');
            $this->excel->getActiveSheet()->setCellValue('D3', 'Description');
            $this->excel->getActiveSheet()->setCellValue('E3', 'Dr Amount');
            $this->excel->getActiveSheet()->setCellValue('F3', 'Cr Amount');
        }else{
            $this->excel->getActiveSheet()->setCellValue('A1', "Account Statement for a Period $start_date and $end_date");
            $this->excel->getActiveSheet()->setCellValue('A3', 'Transaction No');
            $this->excel->getActiveSheet()->setCellValue('B3', 'Transaction Date');
            $this->excel->getActiveSheet()->setCellValue('C3', 'Description');
            $this->excel->getActiveSheet()->setCellValue('D3', 'Dr Amount');
            $this->excel->getActiveSheet()->setCellValue('E3', 'Cr Amount');
        }
        
        //merge cell A1 until C1
        $this->excel->getActiveSheet()->mergeCells('A1:F1');
        //set aligment to center for that merged cell (A1 to C1)
        $this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        //make the font become bold
        $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
        
        $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(16);
        $this->excel->getActiveSheet()->getStyle('A1')->getFill()->getStartColor()->setARGB('#333');
        for($col = ord('A'); $col <= ord('F'); $col++){
                //set column dimension
                $this->excel->getActiveSheet()->getColumnDimension(chr($col))->setAutoSize(true);
                 //change the font size
                $this->excel->getActiveSheet()->getStyle(chr($col))->getFont()->setSize(12);
                 
                $this->excel->getActiveSheet()->getStyle(chr($col))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        }
        //retrive vehicle_service table data
        $accountStatement = $this->transactions_model->getAccountStatementPeriod($start,$end,$rental_type);
        // echo '<pre>';
        // print_r($accountStatement);exit;
        $sumDr = 0;
        $sumCr = 0;
        $count = 0;
        $exceldata="";
        foreach ($accountStatement as $row){
                $exceldata[] = $row;
                $sumCr += $row['CrAmount'];
                $sumDr += $row['DrAmount'];
                $count++;
        }
        $count += 5;
        if($rental_type == 'rental'){
            $cellIdDr = "E".$count;
            $cellIdCr = "F".$count;
        }else{
            $cellIdDr = "D".$count;
            $cellIdCr = "E".$count;
        }
        // echo $cellId;exit;
        $this->excel->getActiveSheet()->setCellValue($cellIdDr,"$sumCr");
        $this->excel->getActiveSheet()->setCellValue($cellIdCr,"$sumDr");
        //Fill data 
        $this->excel->getActiveSheet()->fromArray($exceldata, null, 'A4');
         
        $this->excel->getActiveSheet()->getStyle('A4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $this->excel->getActiveSheet()->getStyle('B4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $this->excel->getActiveSheet()->getStyle('C4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $this->excel->getActiveSheet()->getStyle($cellIdDr)->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle($cellIdCr)->getFont()->setBold(true);
         
        $filename='account_statement.xls'; //save our workbook as this file name
        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache

        //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
        //if you want to save it as .XLSX Excel 2007 format
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
        //force user to download the Excel file without writing it to server's HD
        $objWriter->save('php://output');
    }
    
    function ledger_wise_transaction(){
        if (!$this->ion_auth->logged_in())
	  	{
			redirect('auth/login');
	  	}
        //validation for date
        $this->form_validation->set_rules('start_date','Start Date','required|trim');
        $this->form_validation->set_rules('end_date','End Date','required|trim');
        $this->form_validation->set_rules('ledger','Ledger','trim');
        
        if($this->form_validation->run() == true){
            $start_date = $this->input->post('start_date');
            $end_date = $this->input->post('end_date');
            $ledger = $this->input->post('ledger');
           
            
            if($ledger ==0){
                    $unique_ledger =  $this->transactions_model->unique_ledger_from_transaction( $start_date,$end_date);
                    // echo '<pre>';
                    // print_r($unique_ledger);exit;
                    $transaction_details = array();
                    
                    for($i=0; $i<sizeof($unique_ledger); $i++){
                        
                        $ledger_name = $this->transactions_model->getLedgerTitle($unique_ledger[$i]['Ledger']);
                        $single_transaction_details = $ledger_name. "|". $this->transactions_model->transaction_of_single_ledger($unique_ledger[$i]['Ledger'], $start_date, $end_date );; 
                        // $transaction_detail[] = $single_transaction_details;
                        $data['transaction'][] = $single_transaction_details;
                    }
                    // echo '<pre>';
                    // print_r($data['transaction']);exit;
            }else{
                
            }

            //$data['header_detail'] = $this->transactions_model->getHeaderDetail($start_date,$end_date,$ledger);
            // echo '<pre>';
            // print_r($data['header_detail']);exit;
            $data['total']  = $this->transactions_model->getTotalLedger($ledger,$start_date,$end_date);
            // echo '<pre>';
            // print_r($data['total']);exit;
            $data['ledger'] = $this->transactions_model->getLedger();
            $meta['page_title'] = 'Ledger wise transaction';
            $data['page_title'] = "Ledger wise transaction";
            $this->load->view('commons/header',$meta);
            $this->load->view('ledger_wise_transaction',$data);
            $this->load->view('commons/footer');
        }else{
            $data['ledger'] = $this->transactions_model->getLedger();
            $meta['page_title'] = 'Ledger wise transaction';
            $data['page_title'] = "Ledger wise transaction";
            $this->load->view('commons/header',$meta);
            $this->load->view('ledger_wise_transaction',$data);
            $this->load->view('commons/footer');
        }
    }
   
    function ledger_wise_transaction_details(){
        
        $start_date = $this->input->get('start_date');
        $end_date = $this->input->get('end_date');
        $ledger = $this->input->get('ledger');
        
        $wh = "STR_TO_DATE(`TransactionDate`,'%d/%m/%Y')"." between STR_TO_DATE('".$start_date."','%d/%m/%Y') and STR_TO_DATE('".$end_date."','%d/%m/%Y')";
        
        if($ledger == 0){
            $this->datatables->select('TransactionId,TransactionDate,,vehicle_reg_no,ledger.title,Description,CrAmount,DrAmount')
            ->from('header_detail')
            ->join('ledger','ledger.id = header_detail.Ledger')
            ->where($wh);
        }else{
            $this->datatables->select('TransactionId,TransactionDate,,vehicle_reg_no,ledger.title,Description,CrAmount,DrAmount')
            ->from('header_detail')
            ->join('ledger','ledger.id = header_detail.Ledger')
            ->where($wh)
            ->where('header_detail.Ledger',$ledger);
        }
        
        echo $this->datatables->generate();
    }
    
    function export_ledger_wise_transaction(){
        $start_date = $this->input->get('start_date');
        $end_date = $this->input->get('end_date');
        $ledger = $this->input->get('ledger');
        
        $this->excel->setActiveSheetIndex(0);
        //name the worksheet
        $this->excel->getActiveSheet()->setTitle('Ledger wise transaction Period');
        //set cell A1 content with some text
        $this->excel->getActiveSheet()->setCellValue('A1', "Ledger wise transaction for a Period $start_date and $end_date");
        $this->excel->getActiveSheet()->setCellValue('A3', 'TransactionId');
        $this->excel->getActiveSheet()->setCellValue('B3', 'Transaction Date');
        $this->excel->getActiveSheet()->setCellValue('C3', 'Vehicle No');
        $this->excel->getActiveSheet()->setCellValue('D3', 'Ledger');
        $this->excel->getActiveSheet()->setCellValue('E3', 'Description');
        $this->excel->getActiveSheet()->setCellValue('F3', 'Dr Amount');
        $this->excel->getActiveSheet()->setCellValue('G3', 'Cr Amount');
        //merge cell A1 until C1
        $this->excel->getActiveSheet()->mergeCells('A1:G1');
        //set aligment to center for that merged cell (A1 to C1)
        $this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        //make the font become bold
        $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
        
        $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(16);
        $this->excel->getActiveSheet()->getStyle('A1')->getFill()->getStartColor()->setARGB('#333');
        for($col = ord('A'); $col <= ord('G'); $col++){
                //set column dimension
                $this->excel->getActiveSheet()->getColumnDimension(chr($col))->setAutoSize(true);
                 //change the font size
                $this->excel->getActiveSheet()->getStyle(chr($col))->getFont()->setSize(12);
                 
                $this->excel->getActiveSheet()->getStyle(chr($col))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        }
        //retrive table data
        if($ledger == 0){
            
            //set cell A1 content with some text
            $this->excel->getActiveSheet()->setCellValue('A1', "Ledger wise transaction for a Period $start_date and $end_date");
            $this->excel->getActiveSheet()->setCellValue('A3', 'Ledger');
            $this->excel->getActiveSheet()->setCellValue('B3', 'Transaction Id');
            $this->excel->getActiveSheet()->setCellValue('C3', 'Transaction Date');
            $this->excel->getActiveSheet()->setCellValue('D3', 'Vehicle No');
            $this->excel->getActiveSheet()->setCellValue('E3', 'Description');
            $this->excel->getActiveSheet()->setCellValue('F3', 'Dr Amount');
            $this->excel->getActiveSheet()->setCellValue('G3', 'Cr Amount');
            //merge cell A1 until C1
            $this->excel->getActiveSheet()->mergeCells('A1:G1');
            //set aligment to center for that merged cell (A1 to C1)
            $this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            //make the font become bold
            $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
            
            $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(16);
            $this->excel->getActiveSheet()->getStyle('A1')->getFill()->getStartColor()->setARGB('#333');
            for($col = ord('A'); $col <= ord('G'); $col++){
                    //set column dimension
                    $this->excel->getActiveSheet()->getColumnDimension(chr($col))->setAutoSize(true);
                     //change the font size
                    $this->excel->getActiveSheet()->getStyle(chr($col))->getFont()->setSize(12);
                     
                    $this->excel->getActiveSheet()->getStyle(chr($col))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            }
            
            $unique_ledger =  $this->transactions_model->unique_ledger_from_transaction( $start_date,$end_date);
            // echo '<pre>';
            // print_r($unique_ledger);exit;
            $transaction_details = array();
            
            for($i=0; $i<sizeof($unique_ledger); $i++){
                
                $ledger_name = $this->transactions_model->getLedgerTitle($unique_ledger[$i]['Ledger']);
                $single_transaction_details = $ledger_name. "|". $this->transactions_model->transaction_of_single_ledger($unique_ledger[$i]['Ledger'], $start_date, $end_date );; 
                // $transaction_detail[] = $single_transaction_details;
                $transaction[] = $single_transaction_details;
            }
            $ledgerWiseTransaction = array();
            $new = array();
            for($i=0;$i<sizeof($transaction);$i++){
                $title = explode('|',$transaction[$i]);
                $ledgerName = $title[0];
                // $title1[] = $title[0];
                // array_push($ledgerWiseTransaction,$title[0]);
                $t = explode('*',$title[1]);
                for($j=0;$j<sizeof($t);$j++){
                    $x = explode('+',$t[$j]);
                    for($k=0;$k<sizeof($x);$k++){
                        $finalArray = $ledgerName;
                        // if($k = 0){
                            $ledgerWiseTransaction1[] = array($ledgerName,$x[0],$x[1],$x[2],$x[3],$x[4],$x[5]);
                        // }else{
                            // $ledgerWiseTransaction1[] = array(' ',$x[$k][0],$x[$k][1],$x[$k][2],$x[$k][3],$x[$k][4],$x[$k][5]);
                        // }
                        
                    }
                }
            }
            // echo '<pre>';
            // print_r($ledgerWiseTransaction1);exit;
            $ledgerWiseTransaction = array_unique($ledgerWiseTransaction1, SORT_REGULAR);
            $sumCr = 0;
            $sumDr = 0;
            $count = 0;
            foreach ($ledgerWiseTransaction as $row){
                $exceldata[] = $row;
                $sumCr += $row[6];
                $sumDr += $row[5];
                $count++;
            }
        }else{
            $ledgerWiseTransaction = $this->transactions_model->getHeaderDetailArray($start_date,$end_date,$ledger);
            $sumCr = 0;
            $sumDr = 0;
            $count = 0;
            foreach ($ledgerWiseTransaction as $row){
                $exceldata[] = $row;
                $sumCr += $row['DrAmount'];
                $sumDr += $row['CrAmount'];
                $count++;
            }
        }
        
        $count += 5;
        $cellIdDr = "F".$count;
        $cellIdCr = "G".$count;
        // echo '<pre>';
        // print_r($ledgerWiseTransaction);exit;
        $this->excel->getActiveSheet()->setCellValue($cellIdCr,"$sumCr");
        $this->excel->getActiveSheet()->setCellValue($cellIdDr,"$sumDr");
        
        $this->excel->getActiveSheet()->fromArray($exceldata, null, 'A4');
         
        $this->excel->getActiveSheet()->getStyle('A4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $this->excel->getActiveSheet()->getStyle('B4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $this->excel->getActiveSheet()->getStyle('C4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $this->excel->getActiveSheet()->getStyle($cellIdDr)->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle($cellIdCr)->getFont()->setBold(true);
        
        $filename='ledger_wise_transaction.xls'; //save our workbook as this file name
        
        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache

        //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
        //if you want to save it as .XLSX Excel 2007 format
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
        //force user to download the Excel file without writing it to server's HD
        $objWriter->save('php://output');
    }
    
    function vehicle_wise_income_expense(){
        if (!$this->ion_auth->logged_in())
	  	{
			redirect('auth/login');
	  	}
        
        //validation for date
        $this->form_validation->set_rules('start_date','Start Date','required|trim');
        $this->form_validation->set_rules('end_date','End Date','required|trim');
        $this->form_validation->set_rules('vehicle','Vehicle','trim|xss_clean');
        $this->form_validation->set_rules('type','Type','trim|xss_clean');
        
        if($this->form_validation->run() == true){
            $data['vehicle'] = $this->transactions_model->getVehicle();
            $meta['page_title'] = 'Vehicle Wise Income & Expense Summary';
            $data['page_title'] = "Vehicle Wise Income & Expense Summary";
            $this->load->view('commons/header',$meta);
            $this->load->view('vehicle_income_expense',$data);
            $this->load->view('commons/footer');
        }else{
            $data['vehicle'] = $this->transactions_model->getVehicle();
            // echo '<pre>';
            // print_r($data['vehicle']);exit;
            $meta['page_title'] = 'Vehicle Wise Income & Expense Sumaary';
            $data['page_title'] = "Vehicle Wise Income & Expense Sumaary";
            $this->load->view('commons/header',$meta);
            $this->load->view('vehicle_income_expense',$data);
            $this->load->view('commons/footer');
        }
    }
    
    function vehicle_income_expense_details(){
        $start_date = $this->input->get('start_date');
        $starting = explode('/',$start_date);
        $start = $starting[2]."-".$starting[1]."-".$starting[0];
        $end_date = $this->input->get('end_date');
        $ending = explode('/',$end_date);
        $end = $ending[2]."-".$ending[1]."-".$ending[0];
        $vehicle = $this->input->get('vehicle');
        
        $wh = "`transaction_date` between '".$start."' and '".$end."'";
        
        if($vehicle == 0){
            $this->datatables->select('income_expense.vehicle_reg_no,income_expense.brand,vehicle_owner.name,SUM(income),SUM(expense)')
            ->from('income_expense')
            ->join('vehicle','vehicle.id = income_expense.id')
            ->join('vehicle_owner','vehicle_owner.id = vehicle.owner_id')
            ->where($wh)
            ->group_by('income_expense.id');
        }else{
            $this->datatables->select('income_expense.vehicle_reg_no,income_expense.brand,vehicle_owner.name,SUM(income),SUM(expense)')
            ->from('income_expense')
            ->join('vehicle','vehicle.id = income_expense.id')
            ->join('vehicle_owner','vehicle_owner.id = vehicle.owner_id')
            ->where($wh)
            ->where('income_expense.id',$vehicle);
        }
        echo $this->datatables->generate();
    }
    
    function vehicle_wise_income_expense_detail(){
        if (!$this->ion_auth->logged_in())
	  	{
			redirect('auth/login');
	  	}
        
        //validation for date
        $this->form_validation->set_rules('start_date','Start Date','required|trim');
        $this->form_validation->set_rules('end_date','End Date','required|trim');
        $this->form_validation->set_rules('vehicle','Vehicle','trim|xss_clean');
        
        if($this->form_validation->run() == true){
            $data['vehicle'] = $this->transactions_model->getVehicle();
            $meta['page_title'] = 'Vehicle Wise Income & Expense Detail';
            $data['page_title'] = "Vehicle Wise Income & Expense Detail";
            $this->load->view('commons/header',$meta);
            $this->load->view('vehicle_income_expense_detail',$data);
            $this->load->view('commons/footer');
        }else{
            $data['vehicle'] = $this->transactions_model->getVehicle();
            // echo '<pre>';
            // print_r($data['vehicle']);exit;
            $meta['page_title'] = 'Vehicle Wise Income & Expense Detail';
            $data['page_title'] = "Vehicle Wise Income & Expense Detail";
            $this->load->view('commons/header',$meta);
            $this->load->view('vehicle_income_expense_detail',$data);
            $this->load->view('commons/footer');
        }
    }
	
	function export_vehicle_income_expens(){
		$start_date = $this->input->get('start_date');
        $starting = explode('/',$start_date);
        $start = $starting[2]."-".$starting[1]."-".$starting[0];
        $end_date = $this->input->get('end_date');
        $ending = explode('/',$end_date);
        $end = $ending[2]."-".$ending[1]."-".$ending[0];
        $vehicle = $this->input->get('vehicle');
        $this->excel->setActiveSheetIndex(0);
        //name the worksheet
        $this->excel->getActiveSheet()->setTitle('Vehcle Income & Expense');
        //set cell A1 content with some text
        $this->excel->getActiveSheet()->setCellValue('A1', "Vehicle wise Inc. & Exp. $start_date and $end_date");
        $this->excel->getActiveSheet()->setCellValue('A3', 'Vehicle No.');
        $this->excel->getActiveSheet()->setCellValue('B3', 'Brand');
        $this->excel->getActiveSheet()->setCellValue('C3', 'Brand');
        $this->excel->getActiveSheet()->setCellValue('D3', 'Income');
        $this->excel->getActiveSheet()->setCellValue('E3', 'Expense');
        //merge cell A1 until C1
        $this->excel->getActiveSheet()->mergeCells('A1:F1');
        //set aligment to center for that merged cell (A1 to C1)
        $this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        //make the font become bold
        $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
        
        $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(16);
        $this->excel->getActiveSheet()->getStyle('A1')->getFill()->getStartColor()->setARGB('#333');
        for($col = ord('A'); $col <= ord('E'); $col++){
                //set column dimension
                $this->excel->getActiveSheet()->getColumnDimension(chr($col))->setAutoSize(true);
                 //change the font size
                $this->excel->getActiveSheet()->getStyle(chr($col))->getFont()->setSize(12);
                 
                $this->excel->getActiveSheet()->getStyle(chr($col))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        }
        //retrive vehicle_service table data
        $vehicleIncomeExpense = $this->transactions_model->getVehicleIncomeExpense($start,$end,$vehicle);
		// echo '<pre>';
		// print_r($vehicleIncomeExpense);exit;
        if($vehicleIncomeExpense == false){
           $vehicleIncomeExpense = array(array('No data to display'));
        }
        $sumIncome = 0;
        $sumExpense = 0;
        $count = 0;
        $exceldata="";
        foreach ($vehicleIncomeExpense as $row){
                $exceldata[] = $row;
                $name[] = $row['name'];
                $sumIncome += $row['Income'];
                $sumExpense += $row['Expense'];
                $count++;
        }
        // echo '<pre>';
        // print_r(array_unique($name));exit;
        $count += 5;
        $cellIdIncome = "D".$count;
        $cellIdExpense = "E".$count;
        // echo '<pre>';
        // print_r($ledgerWiseTransaction);exit;
        $this->excel->getActiveSheet()->setCellValue($cellIdIncome,"$sumIncome");
        $this->excel->getActiveSheet()->setCellValue($cellIdExpense,"$sumExpense");
        //Fill data 
        $this->excel->getActiveSheet()->fromArray($exceldata, null, 'A4');
         
        $this->excel->getActiveSheet()->getStyle('A4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $this->excel->getActiveSheet()->getStyle('B4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $this->excel->getActiveSheet()->getStyle('C4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $this->excel->getActiveSheet()->getStyle($cellIdIncome)->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle($cellIdExpense)->getFont()->setBold(true);
         
        $filename='vehicle_income_expense.xls'; //save our workbook as this file name
        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache

        //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
        //if you want to save it as .XLSX Excel 2007 format
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
        //force user to download the Excel file without writing it to server's HD
        $objWriter->save('php://output');
	}
    
    function vehicle_income_expense_details1(){
        $start_date = $this->input->get('start_date');
        $starting = explode('/',$start_date);
        $start = $starting[2]."-".$starting[1]."-".$starting[0];
        $end_date = $this->input->get('end_date');
        $ending = explode('/',$end_date);
        $end = $ending[2]."-".$ending[1]."-".$ending[0];
        $vehicle = $this->input->get('vehicle');
        
        $wh = "`transaction_date` between '".$start."' and '".$end."'";
        
        if($vehicle == 0){
            $this->datatables->select('transaction_id,transaction_date,vehicle_reg_no,brand,description,income,expense')
            ->from('income_expense')
            ->where($wh);
            // ->group_by('id');
        }else{
            $this->datatables->select('transaction_id,transaction_date,vehicle_reg_no,brand,description,income,expense')
            ->from('income_expense')
            ->where($wh)
            ->where('id',$vehicle);
        }
        echo $this->datatables->generate();
    }
	
	function export_vehicle_income_expens_details(){
		$start_date = $this->input->get('start_date');
        $starting = explode('/',$start_date);
        $start = $starting[2]."-".$starting[1]."-".$starting[0];
        $end_date = $this->input->get('end_date');
        $ending = explode('/',$end_date);
        $end = $ending[2]."-".$ending[1]."-".$ending[0];
        $vehicle = $this->input->get('vehicle');
        $this->excel->setActiveSheetIndex(0);
        //name the worksheet
        $this->excel->getActiveSheet()->setTitle('Vehcle Income & Expense Details');
        //set cell A1 content with some text
        $this->excel->getActiveSheet()->setCellValue('A1', "Vehicle wise Inc. & Exp. Details $start_date and $end_date");
        $this->excel->getActiveSheet()->setCellValue('A3', 'Transaction No.');
        $this->excel->getActiveSheet()->setCellValue('B3', 'Transaction Date');
        $this->excel->getActiveSheet()->setCellValue('C3', 'Vehicle No');
        $this->excel->getActiveSheet()->setCellValue('D3', 'Brand');
        $this->excel->getActiveSheet()->setCellValue('E3', 'Description');
        $this->excel->getActiveSheet()->setCellValue('F3', 'Income');
        $this->excel->getActiveSheet()->setCellValue('G3', 'Expense');
        //merge cell A1 until C1
        $this->excel->getActiveSheet()->mergeCells('A1:G1');
        //set aligment to center for that merged cell (A1 to C1)
        $this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        //make the font become bold
        $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
        
        $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(16);
        $this->excel->getActiveSheet()->getStyle('A1')->getFill()->getStartColor()->setARGB('#333');
        for($col = ord('A'); $col <= ord('G'); $col++){
                //set column dimension
                $this->excel->getActiveSheet()->getColumnDimension(chr($col))->setAutoSize(true);
                 //change the font size
                $this->excel->getActiveSheet()->getStyle(chr($col))->getFont()->setSize(12);
                 
                $this->excel->getActiveSheet()->getStyle(chr($col))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        }
        //retrive vehicle_service table data
        $vehicleIncomeExpenseDetail = $this->transactions_model->getVehicleIncomeExpenseDetail($start,$end,$vehicle);
		// echo '<pre>';
		// print_r($vehicleIncomeExpenseDetail);exit;
        if($vehicleIncomeExpenseDetail == false){
           $vehicleIncomeExpenseDetail = array(array('No data to display'));
        }
        $exceldata="";
        $sumIncome = 0;
        $sumExpense = 0;
        $count = 0;
        foreach ($vehicleIncomeExpenseDetail as $row){
            $exceldata[] = $row;
            $sumIncome += $row['income'];
            $sumExpense += $row['expense'];
            $count++;
        }
        $count += 5;
        $cellIdIncome = "F".$count;
        $cellIdExpense = "G".$count;
        
        $this->excel->getActiveSheet()->setCellValue($cellIdIncome,"$sumIncome");
        $this->excel->getActiveSheet()->setCellValue($cellIdExpense,"$sumExpense");
        //Fill data 
        $this->excel->getActiveSheet()->fromArray($exceldata, null, 'A4');
         
        $this->excel->getActiveSheet()->getStyle('A4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $this->excel->getActiveSheet()->getStyle('B4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $this->excel->getActiveSheet()->getStyle('C4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $this->excel->getActiveSheet()->getStyle($cellIdIncome)->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle($cellIdExpense)->getFont()->setBold(true);
         
        $filename='vehicle_income_expense_detail.xls'; //save our workbook as this file name
        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache

        //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
        //if you want to save it as .XLSX Excel 2007 format
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
        //force user to download the Excel file without writing it to server's HD
        $objWriter->save('php://output');
	}
}
?>