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
        // $this->load->helper(array('dompdf', 'file'));
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
            $data['amount'] = $this->transactions_model->getTotalAmount($start_date,$end_date,$rental_type);
            // echo '<pre>';
            // print_r($data['amount']);exit;
            $meta['page_title'] = 'VRS | Cash Book';
            $data['page_title'] = "Cash Book";
            $this->load->view('commons/header',$meta);
            $this->load->view('account_statement',$data);
            $this->load->view('commons/footer');
        }else{
            $meta['page_title'] = 'VRS | Cash Book';
            $data['page_title'] = "Cash Book";
            $this->load->view('commons/header',$meta);
            $this->load->view('account_statement',$data);
            $this->load->view('commons/footer');
        }
    }
    
    function account_statement_details(){
        
        $start_date = $this->input->get('start_date');
        $end_date = $this->input->get('end_date');
        $rental_type = $this->input->get('rental_type');
        
        $wh = "STR_TO_DATE(`transaction_date`,'%d/%m/%Y')"." between STR_TO_DATE('".$start_date."','%d/%m/%Y') and STR_TO_DATE('".$end_date."','%d/%m/%Y')";
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
        $end_date = $this->input->get('end_date');
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
        $accountStatement = $this->transactions_model->getAccountStatementPeriod($start_date,$end_date,$rental_type);
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
            
            $data['ledger'] = $this->transactions_model->getLedger();
            $meta['page_title'] = 'VRS | Ledger wise transaction';
            $data['page_title'] = "Ledger wise transaction";
            $this->load->view('commons/header',$meta);
            $this->load->view('ledger_wise_transaction',$data);
            $this->load->view('commons/footer');
        }else{
            $data['ledger'] = $this->transactions_model->getLedger();
            $meta['page_title'] = 'VRS | Ledger wise transaction';
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
                $title[] = explode('|',$transaction[$i]);
                // $title1[] = $title[0];
                // array_push($ledgerWiseTransaction,$title[0]);
                // $t = explode('*',$title[1]);
                // for($j=0;$j<sizeof($t);$j++){
                    // $x[] = explode('+',$t[$j]);
                    // for($k=0;$k<sizeof($x);$k++){
                        
                    // }
                // }
            }
            echo '<pre>';
            print_r($title);exit;
        }else{
            $ledgerWiseTransaction = $this->transactions_model->getHeaderDetailArray($start_date,$end_date,$ledger);
        }
        // echo '<pre>';
        // print_r($ledgerWiseTransaction);exit;
        foreach ($ledgerWiseTransaction as $row){
            $exceldata[] = $row;
        }
        
        $this->excel->getActiveSheet()->fromArray($exceldata, null, 'A4');
         
        $this->excel->getActiveSheet()->getStyle('A4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $this->excel->getActiveSheet()->getStyle('B4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $this->excel->getActiveSheet()->getStyle('C4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        
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
}
?>