<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Reports extends CI_Controller
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
		$this->load->model('reports_model');
        $this->load->library('upload');
		$this->load->library('Datatables');
        $this->load->library('excel');
	}

    //vehicle list
    function vehicle_details()
    {
        $this->datatables->select('vehicle.id,vehicle_reg_no, brand, model_year, daily_rate,weekly_rate,month_rate,extra_km,vehicle_availibility')
        //->unset_column('vehicle.id')
        ->from('vehicle')
        ->join('branch', 'branch.id=vehicle.branch_id', 'INNER')
        ->where('branch.id',DEFAULT_BRANCH)
        ->join('vehicle_owner', 'vehicle_owner.id=vehicle.owner_id', 'INNER');
        
        echo $this->datatables->generate();
    }
    
    function export_vehicle(){
        $this->excel->setActiveSheetIndex(0);
        //name the worksheet
        $this->excel->getActiveSheet()->setTitle('Vehicle List');
        //set cell A1 content with some text
        $this->excel->getActiveSheet()->setCellValue('A1', 'Vehicle list report');
        $this->excel->getActiveSheet()->setCellValue('A3', 'S.No.');
        $this->excel->getActiveSheet()->setCellValue('B3', 'Reg No.');
        $this->excel->getActiveSheet()->setCellValue('C3', 'Brand / Model');
        $this->excel->getActiveSheet()->setCellValue('D3', 'Model Year');
        $this->excel->getActiveSheet()->setCellValue('E3', 'Daily');
        $this->excel->getActiveSheet()->setCellValue('F3', 'Weekly');
        $this->excel->getActiveSheet()->setCellValue('G3', 'Monthly');
        $this->excel->getActiveSheet()->setCellValue('H3', 'Extra KM Rate');
        $this->excel->getActiveSheet()->setCellValue('I3', 'Status');
        //merge cell A1 until C1
        $this->excel->getActiveSheet()->mergeCells('A1:I1');
        //set aligment to center for that merged cell (A1 to I1)
        $this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        //make the font become bold
        $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(16);
        $this->excel->getActiveSheet()->getStyle('A1')->getFill()->getStartColor()->setARGB('#333');
        for($col = ord('A'); $col <= ord('I'); $col++){
                //set column dimension
                $this->excel->getActiveSheet()->getColumnDimension(chr($col))->setAutoSize(true);
                 //change the font size
                $this->excel->getActiveSheet()->getStyle(chr($col))->getFont()->setSize(12);
                 
                $this->excel->getActiveSheet()->getStyle(chr($col))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        }
        //retrive contries table data
        $rs = $this->reports_model->getVehicleList();
        $exceldata="";
        foreach ($rs as $row){
                $exceldata[] = $row;
        }
        //Fill data 
        $this->excel->getActiveSheet()->fromArray($exceldata, null, 'A4');
         
        $this->excel->getActiveSheet()->getStyle('A4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $this->excel->getActiveSheet()->getStyle('B4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $this->excel->getActiveSheet()->getStyle('C4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
         
        $filename='vehicle.xls'; //save our workbook as this file name
        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache

        //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
        //if you want to save it as .XLSX Excel 2007 format
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
        //force user to download the Excel file without writing it to server's HD
        $objWriter->save('php://output');
        
    }
    
    function vehicle_list(){
        if (!$this->ion_auth->logged_in())
	  	{
			redirect('auth/login');
	  	}
        $meta['page_title'] = 'Vehicle List';
		$data['page_title'] = "Vehicle List";
		$this->load->view('commons/header',$meta);
		$this->load->view('vehicle_list',$data);
		$this->load->view('commons/footer');
    }
    
    function vehicle_service(){
		if (!$this->ion_auth->logged_in())
	  	{
			redirect('auth/login');
	  	}
        //validation for date
        $this->form_validation->set_rules('start_date','Start Date','required|trim');
        $this->form_validation->set_rules('end_date','End Date','required|trim');
        $this->form_validation->set_rules('garage','Garage','trim|xss_clean');
        
        if($this->form_validation->run() == true){
            $data['garage'] = $this->reports_model->getGarage();
            $meta['page_title'] = 'Vehicle Service List Between Period';
            $data['page_title'] = "Vehicle Service List Between Period";
            $this->load->view('commons/header',$meta);
            $this->load->view('vehicle_service',$data);
            $this->load->view('commons/footer');
        }else{
            $data['garage'] = $this->reports_model->getGarage();
            // echo '<pre>';
            // print_r($data['garage']);exit;
            $meta['page_title'] = 'Vehicle Service';
            $data['page_title'] = "Vehicle Service";
            $this->load->view('commons/header',$meta);
            $this->load->view('vehicle_service',$data);
            $this->load->view('commons/footer');
        }
    }
    
    //vehicle service list for a period
    function vehicle_service_details()
    {
        $start_date = $this->input->get('start_date');
        $end_date = $this->input->get('end_date');
        $garage = $this->input->get('garage');
        
        if($garage == 0){
            
            $this->datatables->select('service_no,date_service,vehicle.vehicle_reg_no,garage.garage_name as garageName,service_done,service_amount')
            ->from('vehicle_service_view')
            ->join('branch', 'branch.id=vehicle_service_view.branch_id', 'INNER')
            ->join('garage', 'garage.id=vehicle_service_view.garage_id', 'INNER')
            ->join('vehicle', 'vehicle.id = vehicle_service_view.vehicle_id', 'INNER')
            ->where('branch.id',DEFAULT_BRANCH)
            ->where('date_service >=',$start_date)
            ->where('date_service <=',$end_date);
            
        }else{
            $this->datatables->select('service_no,date_service,vehicle.vehicle_reg_no,garage.garage_name as garageName,service_done,service_amount')
            ->from('vehicle_service_view')
            ->join('branch', 'branch.id=vehicle_service_view.branch_id', 'INNER')
            ->join('garage', 'garage.id=vehicle_service_view.garage_id', 'INNER')
            ->join('vehicle', 'vehicle.id = vehicle_service_view.vehicle_id', 'INNER')
            ->where('date_service >=',$start_date)
            ->where('date_service <=',$end_date)
            ->where('branch.id',DEFAULT_BRANCH)
            ->where('garage_id',$garage);
            
        }
        echo $this->datatables->generate();
    }
    
    function vehicle_service_export(){
        $start_date = $this->input->get('start_date');
        $end_date = $this->input->get('end_date');
        $garage = $this->input->get('garage');
        
        $this->excel->setActiveSheetIndex(0);
        //name the worksheet
        $this->excel->getActiveSheet()->setTitle('Vehicle Service List Period');
        //set cell A1 content with some text
        $this->excel->getActiveSheet()->setCellValue('A1', "Vehicle Service List for a Period $start_date and $end_date");
        $this->excel->getActiveSheet()->setCellValue('A3', 'Service.No.');
        $this->excel->getActiveSheet()->setCellValue('B3', 'Service Date');
        $this->excel->getActiveSheet()->setCellValue('C3', 'VehicleRegNo.');
        $this->excel->getActiveSheet()->setCellValue('D3', 'Garage');
        $this->excel->getActiveSheet()->setCellValue('E3', 'Service Done');
        $this->excel->getActiveSheet()->setCellValue('F3', 'Service Amount');
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
        $vehicleServiceresult = $this->reports_model->getVehicleServiceListPeriod($start_date,$end_date,$garage);
        
        $exceldata="";
        foreach ($vehicleServiceresult as $row){
                $exceldata[] = $row;
        }
        //Fill data 
        $this->excel->getActiveSheet()->fromArray($exceldata, null, 'A4');
         
        $this->excel->getActiveSheet()->getStyle('A4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $this->excel->getActiveSheet()->getStyle('B4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $this->excel->getActiveSheet()->getStyle('C4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
         
        $filename='vehicle_service_list.xls'; //save our workbook as this file name
        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache

        //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
        //if you want to save it as .XLSX Excel 2007 format
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
        //force user to download the Excel file without writing it to server's HD
        $objWriter->save('php://output');
    }
    
    function vehicle_registration_due()
    {
        if (!$this->ion_auth->logged_in())
	  	{
			redirect('auth/login');
	  	}
        
        //validation for date
        $this->form_validation->set_rules('start_date','Start Date','required|trim');
        $this->form_validation->set_rules('end_date','End Date','required|trim');
        $this->form_validation->set_rules('due_renewal','Due Renewal','trim|xss_clean');
        
        if($this->form_validation->run() == true){
            $meta['page_title'] = 'Vehicle Registration Due Details';
            $data['page_title'] = "Vehicle Registration Due details";
            $this->load->view('commons/header',$meta);
            $this->load->view('vehicle_registration_due_renewal',$data);
            $this->load->view('commons/footer');
        }else{
            $meta['page_title'] = 'Vehicle Registration Due Details';
            $data['page_title'] = "Vehicle Registration Due details";
            $this->load->view('commons/header',$meta);
            $this->load->view('vehicle_registration_due_renewal',$data);
            $this->load->view('commons/footer');
        }
    }
    
    function vehicle_registration_due_renewal()
    {
        $start_date = $this->input->get('start_date');
        $end_date = $this->input->get('end_date');
        $due = $this->input->get('due');
        
        if($due == 1){
            $wh = "`reg_expiry_date` between '".$start_date."' and '".$end_date."'";
        
            $this->datatables->select('vehicle_view.id,vehicle_reg_no,insurance_company,insurance_expiry_date,reg_expiry_date')
            //->unset_column('vehicle.id')
            ->from('vehicle_view')
            ->join('branch', 'branch.id=vehicle_view.branch_id', 'INNER')
            ->join('vehicle_owner', 'vehicle_owner.id=vehicle_view.owner_id', 'INNER')
            ->where('branch.id',DEFAULT_BRANCH)
            ->where($wh);
        }else if($due == 2){
            $wh = "`insurance_expiry_date` between '".$start_date."' and '".$end_date."'";
        
            $this->datatables->select('vehicle_view.id,vehicle_reg_no,insurance_company,insurance_expiry_date,reg_expiry_date')
            //->unset_column('vehicle_view.id')
            ->from('vehicle_view')
            ->join('branch', 'branch.id=vehicle_view.branch_id', 'INNER')
            ->join('vehicle_owner', 'vehicle_owner.id=vehicle_view.owner_id', 'INNER')
            ->where('branch.id',DEFAULT_BRANCH)
            ->where($wh);
        }else{
            $wh = "`insurance_expiry_date` between '".$start_date."' and '".$end_date."'";
            
            $wh1 = "`reg_expiry_date` between '".$start_date."' and '".$end_date."'";
        
            $this->datatables->select('vehicle_view.id,vehicle_reg_no,insurance_company,insurance_expiry_date,reg_expiry_date')
            //->unset_column('vehicle_view.id')
            ->from('vehicle_view')
            ->join('branch', 'branch.id=vehicle_view.branch_id', 'INNER')
            ->join('vehicle_owner', 'vehicle_owner.id=vehicle_view.owner_id', 'INNER')
            ->where('branch.id',DEFAULT_BRANCH)
            ->where($wh)
            ->or_where($wh1);
        }
        echo $this->datatables->generate();
    }
    
    function vehicle_due_renewal_export(){
        $start_date = $this->input->get('start_date');
        $end_date = $this->input->get('end_date');
        $due = $this->input->get('due');
        
        $this->excel->setActiveSheetIndex(0);
        //name the worksheet
        $this->excel->getActiveSheet()->setTitle('Vehicle registration renewal');
        //set cell A1 content with some text
        $this->excel->getActiveSheet()->setCellValue('A1', "Vehicle Registration Due Renewal for a Period $start_date and $end_date");
        $this->excel->getActiveSheet()->setCellValue('A3', 'SNo.');
        $this->excel->getActiveSheet()->setCellValue('B3', 'VehicleRegNo.');
        $this->excel->getActiveSheet()->setCellValue('C3', 'Insurance Company');
        $this->excel->getActiveSheet()->setCellValue('D3', 'Date of Insurance Renewal');
        $this->excel->getActiveSheet()->setCellValue('E3', 'Date of Registration Renewal');
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
        $vehicleDueRenewal = $this->reports_model->getVehicleRenewal($start_date,$end_date,$due);
        $exceldata="";
        foreach ($vehicleDueRenewal as $row){
                $exceldata[] = $row;
        }
        //Fill data 
        $this->excel->getActiveSheet()->fromArray($exceldata, null, 'A4');
         
        $this->excel->getActiveSheet()->getStyle('A4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $this->excel->getActiveSheet()->getStyle('B4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $this->excel->getActiveSheet()->getStyle('C4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
         
        $filename='vehicleRegRenewal.xls'; //save our workbook as this file name
        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache

        //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
        //if you want to save it as .XLSX Excel 2007 format
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
        //force user to download the Excel file without writing it to server's HD
        $objWriter->save('php://output');
    }
    
    function vehicle_insurance_due()
    {
        if (!$this->ion_auth->logged_in())
	  	{
			redirect('auth/login');
	  	}
        
        //validation for date
        $this->form_validation->set_rules('start_date','Start Date','required|trim');
        $this->form_validation->set_rules('end_date','End Date','required|trim');
        
        if($this->form_validation->run() == true){
            $meta['page_title'] = 'Vehicle Insurance Due Details';
            $data['page_title'] = "Vehicle Insurance Due details";
            $this->load->view('commons/header',$meta);
            $this->load->view('vehicle_insurance_due_renewal',$data);
            $this->load->view('commons/footer');
        }else{
            $meta['page_title'] = 'Vehicle Insurance Due Details';
            $data['page_title'] = "Vehicle Insurance Due details";
            $this->load->view('commons/header',$meta);
            $this->load->view('vehicle_insurance_due_renewal',$data);
            $this->load->view('commons/footer');
        }
    }
    
    function vehicle_insurance_due_renewal()
    {
        $start_date = $this->input->get('start_date');
        $end_date = $this->input->get('end_date');
        
        $wh = "STR_TO_DATE(`insurance_expiry_date`,'%d/%m/%Y')"." between STR_TO_DATE('".$start_date."','%d/%m/%Y') and STR_TO_DATE('".$end_date."','%d/%m/%Y')";
        
        $this->datatables->select('vehicle.id,vehicle_reg_no,insurance_company,insurance_expiry_date,reg_expiry_date')
        //->unset_column('vehicle.id')
        ->from('vehicle')
        ->join('branch', 'branch.id=vehicle.branch_id', 'INNER')
        ->join('vehicle_owner', 'vehicle_owner.id=vehicle.owner_id', 'INNER')
        ->where('branch.id',DEFAULT_BRANCH)
        ->where($wh);
        
        echo $this->datatables->generate();
    }
    
    function vehicle_insurance_due_export(){
        $start_date = $this->input->get('start_date');
        $end_date = $this->input->get('end_date');
        
        $this->excel->setActiveSheetIndex(0);
        //name the worksheet
        $this->excel->getActiveSheet()->setTitle('Vehicle insurance renewal');
        //set cell A1 content with some text
        $this->excel->getActiveSheet()->setCellValue('A1', "Vehicle insurance due renewal for a Period $start_date and $end_date");
        $this->excel->getActiveSheet()->setCellValue('A3', 'SNo.');
        $this->excel->getActiveSheet()->setCellValue('B3', 'VehicleRegNo.');
        $this->excel->getActiveSheet()->setCellValue('C3', 'Insurance Company');
        $this->excel->getActiveSheet()->setCellValue('D3', 'Date of Insurance Renewal');
        $this->excel->getActiveSheet()->setCellValue('E3', 'Date of Registration Renewal');
        //merge cell A1 until C1
        $this->excel->getActiveSheet()->mergeCells('A1:G1');
        //set aligment to center for that merged cell (A1 to C1)
        $this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        //make the font become bold
        $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
        // $this->excel->getActiveSheet()->getStyle('A3')->getFont()->setBold(true);
        // $this->excel->getActiveSheet()->getStyle('B3')->getFont()->setBold(true);
        // $this->excel->getActiveSheet()->getStyle('C3')->getFont()->setBold(true);
        // $this->excel->getActiveSheet()->getStyle('D3')->getFont()->setBold(true);
        // $this->excel->getActiveSheet()->getStyle('E3')->getFont()->setBold(true);
        // $this->excel->getActiveSheet()->getStyle('F3')->getFont()->setBold(true);
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
        $vehicleDueRenewal = $this->reports_model->getVehicleInsuranceRenewal($start_date,$end_date);
        $exceldata="";
        foreach ($vehicleDueRenewal as $row){
                $exceldata[] = $row;
        }
        //Fill data 
        $this->excel->getActiveSheet()->fromArray($exceldata, null, 'A4');
         
        $this->excel->getActiveSheet()->getStyle('A4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $this->excel->getActiveSheet()->getStyle('B4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $this->excel->getActiveSheet()->getStyle('C4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
         
        $filename='vehicleInsuranceRenewal.xls'; //save our workbook as this file name
        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache

        //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
        //if you want to save it as .XLSX Excel 2007 format
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
        //force user to download the Excel file without writing it to server's HD
        $objWriter->save('php://output');
    }
    
    function reciept_period()
    {
        if (!$this->ion_auth->logged_in())
	  	{
			redirect('auth/login');
	  	}
        
        //validation for date
        $this->form_validation->set_rules('start_date','Start Date','required|trim');
        $this->form_validation->set_rules('end_date','End Date','required|trim');
        
        if($this->form_validation->run() == true){
            $meta['page_title'] = 'Receipts for a period';
            $data['page_title'] = "Receipts for a period";
            $this->load->view('commons/header',$meta);
            $this->load->view('receipt_period',$data);
            $this->load->view('commons/footer');
        }else{
            $meta['page_title'] = 'Receipts for a period';
            $data['page_title'] = "Receipts for a period";
            $this->load->view('commons/header',$meta);
            $this->load->view('receipt_period',$data);
            $this->load->view('commons/footer');
        }
    }
    
    function receipt_details()
    {
        $start_date = $this->input->get('start_date');
        $starting = explode('/',$start_date);
        $start = $starting[2]."-".$starting[1]."-".$starting[0];
        $end_date = $this->input->get('end_date');
        $ending = explode('/',$end_date);
        $end = $ending[2]."-".$ending[1]."-".$ending[0];
        $rental_type = $this->input->get('rental_type');
        
        $wh = "`receipt_voucher_date` between '".$start."' and '".$end."'";
        if($rental_type == 'rental'){
            $this->datatables->select('receipt_view.receipt_voucher_no,receipt_voucher_date,vehicle.vehicle_reg_no,description,ledger.title as title,receipt_amount')
            ->from('receipt_view')
            ->join('rental_pickup','rental_pickup.rental_id = receipt_view.rental_id')
            ->join('vehicle','vehicle.id = rental_pickup.vehicle_id')
            ->join('branch','branch.id = receipt_view.branch_id', 'INNER')
            ->join('ledger','ledger.id = receipt_view.reciept_ledger')
            ->where('branch.id',DEFAULT_BRANCH)
            ->where('receipt_view.status','A')
            ->where($wh);
        }else{
            $this->datatables->select('receipt_view.receipt_voucher_no,receipt_voucher_date,description,ledger.title as title,receipt_amount')
            ->from('receipt_view')
            //->join('rental_pickup','rental_pickup.rental_id = receipts.rental_id')
            //->join('vehicle','vehicle.id = rental_pickup.vehicle_id')
            ->join('branch','branch.id = receipt_view.branch_id', 'INNER')
            ->join('ledger','ledger.id = receipt_view.reciept_ledger')
            ->where('branch.id',DEFAULT_BRANCH)
            ->where('receipt_view.status','A')
            ->where('receipt_view.rental_id',0)
            ->where('receipt_view.invoice_no',0)
            ->where($wh);
        }
            
        echo $this->datatables->generate();
    }
    
    function receipt_renewal_period(){
        $start_date = $this->input->get('start_date');
        $end_date = $this->input->get('end_date');
        $rental_type = $this->input->get('rental_type');
        
        $this->excel->setActiveSheetIndex(0);
        //name the worksheet
        $this->excel->getActiveSheet()->setTitle("Receipt");
        //set cell A1 content with some text
        $this->excel->getActiveSheet()->setCellValue('A1', "Receipt for a Period $start_date and $end_date");
        $this->excel->getActiveSheet()->setCellValue('A3', 'Voucher No.');
        $this->excel->getActiveSheet()->setCellValue('B3', 'Vehicle No.');
        $this->excel->getActiveSheet()->setCellValue('C3', 'Voucher Date');
        $this->excel->getActiveSheet()->setCellValue('D3', 'Description');
        $this->excel->getActiveSheet()->setCellValue('E3', 'Receipt Ledger');
        $this->excel->getActiveSheet()->setCellValue('F3', 'Receipt Amount');
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
        $receiptPeriod = $this->reports_model->getReceiptPeriod($start_date,$end_date,$rental_type);
        if($receiptPeriod == false){
            $receiptPeriod = array(array('No data to display'));
        }
        $exceldata="";
        foreach ($receiptPeriod as $row){
                $exceldata[] = $row;
        }
        //Fill data 
        $this->excel->getActiveSheet()->fromArray($exceldata, null, 'A4');
         
        $this->excel->getActiveSheet()->getStyle('A4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $this->excel->getActiveSheet()->getStyle('B4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $this->excel->getActiveSheet()->getStyle('C4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
         
        $filename='Receipt_for_a_period.xls'; //save our workbook as this file name
        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache

        //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
        //if you want to save it as .XLSX Excel 2007 format
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
        //force user to download the Excel file without writing it to server's HD
        $objWriter->save('php://output');
    }
    
    function payment_period()
    {
        if (!$this->ion_auth->logged_in())
	  	{
			redirect('auth/login');
	  	}
        
        //validation for date
        $this->form_validation->set_rules('start_date','Start Date','required|trim');
        $this->form_validation->set_rules('end_date','End Date','required|trim');
        $this->form_validation->set_rules('rental_type','Rental Type','trim');
        
        if($this->form_validation->run() == true){
            $meta['page_title'] = 'Payment for a Period';
            $data['page_title'] = "Payment for a period";
            $this->load->view('commons/header',$meta);
            $this->load->view('payment_period',$data);
            $this->load->view('commons/footer');
        }else{
            $meta['page_title'] = 'Payment for a Period';
            $data['page_title'] = "Payment for a period";
            $this->load->view('commons/header',$meta);
            $this->load->view('payment_period',$data);
            $this->load->view('commons/footer');
        }
    }
    
    function payment_details()
    {
        $start_date = $this->input->get('start_date');
        $starting = explode('/',$start_date);
        $start = $starting[2]."-".$starting[1]."-".$starting[0];
        $end_date = $this->input->get('end_date');
        $ending = explode('/',$end_date);
        $end = $ending[2]."-".$ending[1]."-".$ending[0];
        $rental_type = $this->input->get('rental_type');
        $wh = "`payment_voucher_date` between '".$start."' and '".$end."'";
        
        if($rental_type == "rental"){
        
            $this->datatables->select('payment_view.payment_voucher_no,payment_voucher_date,vehicle_reg_no,description,ledger.title as payment_ledger,payment_amount')
            ->from('payment_view')
            ->join('rental_pickup','rental_pickup.rental_id = payment_view.rental_id')
            ->join('vehicle','vehicle.id = rental_pickup.vehicle_id')
            ->join('branch','branch.id = payment_view.branch_id', 'INNER')
            ->join('ledger','ledger.id = payment_view.payment_ledger', 'INNER')
            ->where('branch.id',DEFAULT_BRANCH)
            ->where('status','A')
            ->where($wh);
        }else{
            $this->datatables->select('payment_view.payment_voucher_no,payment_voucher_date,payment_view.vehicle_id,description,ledger.title as payment_ledger,payment_amount')
            ->from('payment_view')
            //->join('rental_pickup','rental_pickup.rental_id = payment_view.rental_id')
            //->join('vehicle','vehicle.id = rental_pickup.vehicle_id')
            ->join('branch','branch.id = payment_view.branch_id', 'INNER')
            ->join('ledger','ledger.id = payment_view.payment_ledger', 'INNER')
            ->where('status','A')
            ->where('branch.id',DEFAULT_BRANCH)
            ->where($wh)
            ->where('payment_view.rental_id',0)
            ->where('payment_view.invoice_no',0);
        }
        
        echo $this->datatables->generate();
    }
    
    function payment_for_period(){
        $start_date = $this->input->get('start_date');
        $end_date = $this->input->get('end_date');
        $rental_type = $this->input->get('rental_type');
        $this->excel->setActiveSheetIndex(0);
        //name the worksheet
        $this->excel->getActiveSheet()->setTitle('Payment for a Period');
        //set cell A1 content with some text
        $this->excel->getActiveSheet()->setCellValue('A1', "Payment for a Period $start_date and $end_date");
        $this->excel->getActiveSheet()->setCellValue('A3', 'Voucher No.');
        $this->excel->getActiveSheet()->setCellValue('B3', 'Vehicle No.');
        $this->excel->getActiveSheet()->setCellValue('C3', 'Voucher Date');
        $this->excel->getActiveSheet()->setCellValue('D3', 'Description');
        $this->excel->getActiveSheet()->setCellValue('E3', 'Payment Ledger');
        $this->excel->getActiveSheet()->setCellValue('F3', 'Payment Amount');
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
        $paymentPeriod = $this->reports_model->getPaymentPeriod($start_date,$end_date,$rental_type);
        if($paymentPeriod == false){
           $paymentPeriod = array(array('No data to display'));
        }
        $exceldata="";
        foreach ($paymentPeriod as $row){
                $exceldata[] = $row;
        }
        //Fill data 
        $this->excel->getActiveSheet()->fromArray($exceldata, null, 'A4');
         
        $this->excel->getActiveSheet()->getStyle('A4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $this->excel->getActiveSheet()->getStyle('B4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $this->excel->getActiveSheet()->getStyle('C4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
         
        $filename='Payment_for_a_period.xls'; //save our workbook as this file name
        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache

        //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
        //if you want to save it as .XLSX Excel 2007 format
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
        //force user to download the Excel file without writing it to server's HD
        $objWriter->save('php://output');
    }
    
    function cheque_due_payment()
    {
        if (!$this->ion_auth->logged_in())
	  	{
			redirect('auth/login');
	  	}
        
        //validation for date
        $this->form_validation->set_rules('start_date','Start Date','required|trim');
        $this->form_validation->set_rules('end_date','End Date','required|trim');
        
        if($this->form_validation->run() == true){
            $meta['page_title'] = 'Cheques due for payment for a period';
            $data['page_title'] = "Cheques due for payment for a period";
            $this->load->view('commons/header',$meta);
            $this->load->view('cheque_due_payment',$data);
            $this->load->view('commons/footer');
        }else{
            $meta['page_title'] = 'Cheques due for payment for a period';
            $data['page_title'] = "Cheques due for payment for a period";
            $this->load->view('commons/header',$meta);
            $this->load->view('cheque_due_payment',$data);
            $this->load->view('commons/footer');
        }
    }
    
    function cheque_due_payment_details()
    {
        $start_date = $this->input->get('start_date');
        $end_date = $this->input->get('end_date');
        
        $wh = "STR_TO_DATE(`date_issue`,'%d/%m/%Y')"." between STR_TO_DATE('".$start_date."','%d/%m/%Y') and STR_TO_DATE('".$end_date."','%d/%m/%Y')";
        
        $this->datatables->select('vehicle_no,date_issue,cheque_no,bank_ref,amount,reason')
        ->from('pdc')
        // ->where('mode','CHEQUE')
        ->where($wh);
        
        echo $this->datatables->generate();
    }
    
    function cheques_due_for_period(){
        $start_date = $this->input->get('start_date');
        $end_date = $this->input->get('end_date');
        
        $this->excel->setActiveSheetIndex(0);
        //name the worksheet
        $this->excel->getActiveSheet()->setTitle('Cheque due for a Period');
        //set cell A1 content with some text
        $this->excel->getActiveSheet()->setCellValue('A1', "Cheque due for a Period $start_date and $end_date");
        $this->excel->getActiveSheet()->setCellValue('A3', 'Vehicle No');
        $this->excel->getActiveSheet()->setCellValue('B3', 'Date');
        $this->excel->getActiveSheet()->setCellValue('C3', 'Cheque No.');
        $this->excel->getActiveSheet()->setCellValue('D3', 'Company');
        $this->excel->getActiveSheet()->setCellValue('E3', 'Amount');
        $this->excel->getActiveSheet()->setCellValue('F3', 'Purpose');
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
        $chequeDuePeriod = $this->reports_model->getChequeDuePeriod($start_date,$end_date);
        $exceldata="";
        foreach ($chequeDuePeriod as $row){
                $exceldata[] = $row;
        }
        //Fill data 
        $this->excel->getActiveSheet()->fromArray($exceldata, null, 'A4');
         
        $this->excel->getActiveSheet()->getStyle('A4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $this->excel->getActiveSheet()->getStyle('B4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $this->excel->getActiveSheet()->getStyle('C4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
         
        $filename='cheque_due_period.xls'; //save our workbook as this file name
        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache

        //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
        //if you want to save it as .XLSX Excel 2007 format
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
        //force user to download the Excel file without writing it to server's HD
        $objWriter->save('php://output');
    }
    
    function vehicle_rented(){
        if (!$this->ion_auth->logged_in())
	  	{
			redirect('auth/login');
	  	}
        
        //validation for date
        $this->form_validation->set_rules('start_date','Start Date','required|trim');
        $this->form_validation->set_rules('end_date','End Date','required|trim');
        $this->form_validation->set_rules('vehicle','Vehicle','trim|xss_clean');
        
        if($this->form_validation->run() == true){
            $data['vehicle'] = $this->reports_model->getVehicle();
            $meta['page_title'] = 'Vehicle Rented for a period';
            $data['page_title'] = "Vehicle Rented for a period";
            $this->load->view('commons/header',$meta);
            $this->load->view('vehicle_rented',$data);
            $this->load->view('commons/footer');
        }else{
            $data['vehicle'] = $this->reports_model->getVehicle();
            // echo '<pre>';
            // print_r($data['vehicle']);exit;
            $meta['page_title'] = 'Vehicle Rented for a period';
            $data['page_title'] = "Vehicle Rented for a period";
            $this->load->view('commons/header',$meta);
            $this->load->view('vehicle_rented',$data);
            $this->load->view('commons/footer');
        }    
    }
    
    function vehicle_rented_details(){
        
        $start_date = $this->input->get('start_date');
		$starting = explode('/',$start_date);
		$start = $starting[2]."-".$starting[1]."-".$starting[0];
        $end_date = $this->input->get('end_date');
		$ending = explode("/",$end_date);
		$end = $ending[2]."-".$ending[1]."-".$ending[0];
        $vehicle = $this->input->get('vehicle');
        
        if($vehicle == 0){
            $wh = "`date_rental` between '".$start."' and '".$end."'";
        
            $this->datatables->select('rental_pickup_view.rental_id as id,vehicle.vehicle_reg_no,vehicle.brand,customer.en_name,rental_pickup_view.date_rental,rental_return_view.return_date,rental_return_view.total_rented_days,rental_pickup_view.rental_type,rental_return_view.rate_per_day,rental_pickup_view.deposit_amount,rental_return_view.misc_charges,rental_return_view.deduction,rental_return_view.total_rent_charges')
            ->from('rental_pickup_view')
            ->join('vehicle','vehicle.id = rental_pickup_view.vehicle_id')
            ->join('customer','customer.id = rental_pickup_view.customer_id')
            ->join('rental_return_view','rental_return_view.rental_id = rental_pickup_view.rental_id')
            ->where($wh);
        }else{
            $wh = "`date_rental` between '".$start."' and '".$end."'";
        
            $this->datatables->select('rental_pickup_view.rental_id as id,vehicle.vehicle_reg_no,vehicle.brand,customer.en_name,rental_pickup_view.date_rental,rental_return_view.return_date,rental_return_view.total_rented_days,rental_pickup_view.rental_type,rental_return_view.rate_per_day,rental_pickup_view.deposit_amount,rental_return_view.misc_charges,rental_return_view.deduction,rental_return_view.total_rent_charges')
            ->from('rental_pickup_view')
            ->join('vehicle','vehicle.id = rental_pickup_view.vehicle_id')
            ->join('customer','customer.id = rental_pickup_view.customer_id')
            ->join('rental_return_view','rental_return_view.rental_id = rental_pickup_view.rental_id')
            ->where($wh)
            ->where('rental_pickup_view.vehicle_id',$vehicle);
        }
        
        echo $this->datatables->generate();
    }
    
    function vehicle_rented_for_period(){
        $start_date = $this->input->get('start_date');
        $end_date = $this->input->get('end_date');
        $vehicle = $this->input->get('vehicle');
        
        $this->excel->setActiveSheetIndex(0);
        //name the worksheet
        $this->excel->getActiveSheet()->setTitle('Vehicle Rented for a Period');
        //set cell A1 content with some text
        $this->excel->getActiveSheet()->setCellValue('A1', "Vehicle Rented for a Period $start_date and $end_date");
        $this->excel->getActiveSheet()->setCellValue('A3', 'SNo');
        $this->excel->getActiveSheet()->setCellValue('B3', 'VEHICLE Reg.No');
        $this->excel->getActiveSheet()->setCellValue('C3', 'Brand/ Model');
        $this->excel->getActiveSheet()->setCellValue('D3', 'Rented By');
        $this->excel->getActiveSheet()->setCellValue('E3', 'Start Date');
        $this->excel->getActiveSheet()->setCellValue('F3', 'End Date');
        $this->excel->getActiveSheet()->setCellValue('G3', 'Total Days');
        $this->excel->getActiveSheet()->setCellValue('H3', 'Rent Type');
        $this->excel->getActiveSheet()->setCellValue('I3', 'Rate');
        $this->excel->getActiveSheet()->setCellValue('J3', 'Deposit');
        $this->excel->getActiveSheet()->setCellValue('K3', 'Other Charges');
        $this->excel->getActiveSheet()->setCellValue('L3', 'Deduction');
        $this->excel->getActiveSheet()->setCellValue('M3', 'Total Rent');
        //merge cell A1 until C1
        $this->excel->getActiveSheet()->mergeCells('A1:M1');
        //set aligment to center for that merged cell (A1 to M1)
        $this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        //make the font become bold
        $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
        
        $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(16);
        $this->excel->getActiveSheet()->getStyle('A1')->getFill()->getStartColor()->setARGB('#333');
        for($col = ord('A'); $col <= ord('M'); $col++){
                //set column dimension
                $this->excel->getActiveSheet()->getColumnDimension(chr($col))->setAutoSize(true);
                 //change the font size
                $this->excel->getActiveSheet()->getStyle(chr($col))->getFont()->setSize(12);
                 
                $this->excel->getActiveSheet()->getStyle(chr($col))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        }
        //retrive vehicle_service table data
        $vehicleRentedPeriod = $this->reports_model->getVehicleRentedPeriod($start_date,$end_date,$vehicle);
        $exceldata="";
        foreach ($vehicleRentedPeriod as $row){
                $exceldata[] = $row;
        }
        //Fill data 
        $this->excel->getActiveSheet()->fromArray($exceldata, null, 'A4');
         
        $this->excel->getActiveSheet()->getStyle('A4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $this->excel->getActiveSheet()->getStyle('B4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $this->excel->getActiveSheet()->getStyle('C4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
         
        $filename='vehicle_rented_period.xls'; //save our workbook as this file name
        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache

        //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
        //if you want to save it as .XLSX Excel 2007 format
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
        //force user to download the Excel file without writing it to server's HD
        $objWriter->save('php://output');
    }
    
    function vehicle_expected_return(){
        if (!$this->ion_auth->logged_in())
	  	{
			redirect('auth/login');
	  	}
        
        //validation for date
        $this->form_validation->set_rules('start_date','Start Date','required|trim');
        $this->form_validation->set_rules('end_date','End Date','required|trim');
        $this->form_validation->set_rules('vehicle','Vehicle','trim|xss_clean');
        
        if($this->form_validation->run() == true){
            $data['vehicle'] = $this->reports_model->getVehicle();
            $meta['page_title'] = 'Vehicle expected return for a period';
            $data['page_title'] = "Vehicle expected return for a period";
            $this->load->view('commons/header',$meta);
            $this->load->view('vehicle_expected_return',$data);
            $this->load->view('commons/footer');
        }else{
            $data['vehicle'] = $this->reports_model->getVehicle();
            // echo '<pre>';
            // print_r($data['vehicle']);exit;
            $meta['page_title'] = 'Vehicle expected return for a period';
            $data['page_title'] = "Vehicle expected return for a period";
            $this->load->view('commons/header',$meta);
            $this->load->view('vehicle_expected_return',$data);
            $this->load->view('commons/footer');
        }    
    }
    
    function vehicle_expected_return_details(){
        
        $start_date = $this->input->get('start_date');
		$starting = explode('/',$start_date);
		$start = $starting[2]."-".$starting[1]."-".$starting[0];
        $end_date = $this->input->get('end_date');
		$ending = explode("/",$end_date);
		$end = $ending[2]."-".$ending[1]."-".$ending[0];
        $vehicle = $this->input->get('vehicle');
        
        if($vehicle == 0){
            $wh = "`expected_return_date` between '".$start."' and '".$end."'";
        
            $this->datatables->select('rental_pickup_view.rental_id as id,vehicle.vehicle_reg_no,vehicle.brand,customer.en_name,rental_pickup_view.date_rental,rental_pickup_view.expected_return_date,rental_return_view.total_rented_days,rental_pickup_view.rental_type,rental_return_view.rate_per_day,rental_pickup_view.deposit_amount,rental_return_view.misc_charges,rental_return_view.deduction,rental_return_view.total_rent_charges')
            ->from('rental_pickup_view')
            ->join('vehicle','vehicle.id = rental_pickup_view.vehicle_id')
            ->join('customer','customer.id = rental_pickup_view.customer_id')
            ->join('rental_return_view','rental_return_view.rental_id = rental_pickup_view.rental_id')
            ->where($wh);
        }else{
            $wh = "`expected_return_date` between '".$start."' and '".$end."'";
        
            $this->datatables->select('rental_pickup_view.rental_id as id,vehicle.vehicle_reg_no,vehicle.brand,customer.en_name,rental_pickup_view.date_rental,rental_pickup_view.expected_return_date,rental_return_view.total_rented_days,rental_pickup_view.rental_type,rental_return_view.rate_per_day,rental_pickup_view.deposit_amount,rental_return_view.misc_charges,rental_return_view.deduction,rental_return_view.total_rent_charges')
            ->from('rental_pickup_view')
            ->join('vehicle','vehicle.id = rental_pickup_view.vehicle_id')
            ->join('customer','customer.id = rental_pickup_view.customer_id')
            ->join('rental_return_view','rental_return_view.rental_id = rental_pickup_view.rental_id')
            ->where($wh)
            ->where('rental_pickup_view.vehicle_id',$vehicle);
        }
        
        echo $this->datatables->generate();
    }
    
    function vehicle_expected_return_for_period(){
        $start_date = $this->input->get('start_date');
        $end_date = $this->input->get('end_date');
        $vehicle = $this->input->get('vehicle');
        
        $this->excel->setActiveSheetIndex(0);
        //name the worksheet
        $this->excel->getActiveSheet()->setTitle('Vehicle Expected return');
        //set cell A1 content with some text
        $this->excel->getActiveSheet()->setCellValue('A1', "Vehicle Expected return for a Period $start_date and $end_date");
        $this->excel->getActiveSheet()->setCellValue('A3', 'SNo');
        $this->excel->getActiveSheet()->setCellValue('B3', 'VEHICLE Reg.No');
        $this->excel->getActiveSheet()->setCellValue('C3', 'Brand/ Model');
        $this->excel->getActiveSheet()->setCellValue('D3', 'Rented By');
        $this->excel->getActiveSheet()->setCellValue('E3', 'Start Date');
        $this->excel->getActiveSheet()->setCellValue('F3', 'End Date');
        $this->excel->getActiveSheet()->setCellValue('G3', 'Total Days');
        $this->excel->getActiveSheet()->setCellValue('H3', 'Rent Type');
        $this->excel->getActiveSheet()->setCellValue('I3', 'Rate');
        $this->excel->getActiveSheet()->setCellValue('J3', 'Deposit');
        $this->excel->getActiveSheet()->setCellValue('K3', 'Other Charges');
        $this->excel->getActiveSheet()->setCellValue('L3', 'Deduction');
        $this->excel->getActiveSheet()->setCellValue('M3', 'Total Rent');
        //merge cell A1 until C1
        $this->excel->getActiveSheet()->mergeCells('A1:M1');
        //set aligment to center for that merged cell (A1 to M1)
        $this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        //make the font become bold
        $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
        
        $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(16);
        $this->excel->getActiveSheet()->getStyle('A1')->getFill()->getStartColor()->setARGB('#333');
        for($col = ord('A'); $col <= ord('M'); $col++){
                //set column dimension
                $this->excel->getActiveSheet()->getColumnDimension(chr($col))->setAutoSize(true);
                 //change the font size
                $this->excel->getActiveSheet()->getStyle(chr($col))->getFont()->setSize(12);
                 
                $this->excel->getActiveSheet()->getStyle(chr($col))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        }
        //retrive vehicle_service table data
        $vehicleExpectedReturnPeriod = $this->reports_model->getVehicleExpectedReturnPeriod($start_date,$end_date,$vehicle);
        $exceldata="";
        foreach ($vehicleExpectedReturnPeriod as $row){
                $exceldata[] = $row;
        }
        //Fill data 
        $this->excel->getActiveSheet()->fromArray($exceldata, null, 'A4');
         
        $this->excel->getActiveSheet()->getStyle('A4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $this->excel->getActiveSheet()->getStyle('B4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $this->excel->getActiveSheet()->getStyle('C4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
         
        $filename='vehicle_expected_return_period.xls'; //save our workbook as this file name
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