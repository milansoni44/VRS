<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Quotationheader extends CI_Controller 
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
		$this->load->model('quotationheader_model');
		$this->load->library('Datatables');
        $this->load->library('Pdf');
	}
    
    function index()
    {
        if (!$this->ion_auth->logged_in())
	  	{
			redirect('auth/login');
	  	}
        $meta['page_title'] = 'Quotation';
		$data['page_title'] = "Quotations";
		$this->load->view('commons/header',$meta);
		$this->load->view('index',$data);
		$this->load->view('commons/footer');
    }
    
    function quotation_details()
    {
        $this->datatables->select('quotation_header.quotation_id,branch.branch_name as branchName,quotation_date,customer.en_name as CustomerName,validity_upto,status')
        ->from('quotation_header')
        ->join('branch','branch.id = quotation_header.branch_id', 'INNER')
        ->join('customer','customer.id = quotation_header.customer_id', 'INNER')
        ->add_column("Actions", "<a href='quotationheader/view/$1'><i class='fa fa-eye'></i></a> &nbsp; <a href='quotationheader/edit/$1'><i class='fa fa-pencil-square-o'></i></a> &nbsp; <a href='quotationheader/delete/$1' onclick=\"return confirm('Are you sure you want to delete?');\"><i class='fa fa-trash-o'></i></a> &nbsp; <a href='quotationheader/quotation_pdf/$1'>Print</a>", "quotation_header.quotation_id");
		
        echo $this->datatables->generate();
    }
    
    function view($quotation_id){
        $data['quotation_header'] = $this->quotationheader_model->getQuotationHeaderWithJoin($quotation_id);
        $data['quotation_details'] = $this->quotationheader_model->getQuotationHeaderDetails($quotation_id);
        // echo '<pre>';
        // print_r($data['quotation_details']);exit;
        // $data['branch'] = $this->quotationheader_model->getBranch();
        // $data['customer'] = $this->quotationheader_model->getCustomer();
        $vehicle = $this->quotationheader_model->getVehicle();
        $vehicleID = $this->quotationheader_model->getVehicleId();
        $brand = $this->array_flatten($vehicle);
        $vehicle_id = $this->array_flatten($vehicleID);
        $vehicleNo = $this->quotationheader_model->getVehicleRegNo();
        $vehicleRegNo = $this->array_flatten($vehicleNo);
        $data['id'] = $quotation_id;
        $data['vehicle_id'] = $vehicle_id;
        $data['vehicle_reg_no'] = $vehicleRegNo;
        $data['brand'] = $brand;
        
        $meta['page_title'] = 'View Quotation';
        $data['page_title'] = "View Quotation";
        $this->load->view('commons/header', $meta);
        $this->load->view('view', $data);
        $this->load->view('commons/footer');
    }
    
    function add()
    {
        //quotation header form validation
        /* ==============VALIDATION FOR SELECTBOX branch ================ */
        $this->form_validation->set_rules('branch','Branch','required|callback_check_default');
        $this->form_validation->set_message('check_default', 'You need to select branch other than the default.');
        /* --------------*/
        /* ==============VALIDATION FOR SELECTBOX customer ================ */
        $this->form_validation->set_rules('customer','Customer','required|callback_check_default1');
        $this->form_validation->set_message('check_default1', 'You need to select customer other than the default.');
        /* --------------*/
        $this->form_validation->set_rules('quotation_date', 'Date of Quotation', 'trim|required|xss_clean');
        $this->form_validation->set_rules('validity', 'Validity in Days', 'trim|required|xss_clean');
        
        if ($this->form_validation->run() == true)
        {
            $quotationHeader = array(
                    'branch_id'	            =>	$this->input->post('branch'),
                    'customer_id'	        =>	$this->input->post('customer'),
                    'quotation_date'        =>  $this->input->post('quotation_date'),
                    'validity_upto'         =>  $this->input->post('validity'),
                    'status'                =>  'Sent',
                );
            
            $noOfDetails = $this->input->post('seq');
            // echo $noOfDetails;
            // exit;
            $vehicleDetails = explode(',',$noOfDetails);
            $brand = array();
            $model = array();
            $engine = array();
            $daily_rate = array();
            $weekly_rate = array();
            $monthly_rate = array();
            $insurance = array();
            $breakdown = array();
            $general_remarks = array();
            
            for($i=0; $i<sizeof($vehicleDetails); $i++){
                $quotationDetail = array(
                    'vehicle_id' =>	  $this->input->post('brand'.$vehicleDetails[$i]),                    
                    'engine_capacity' =>  $this->input->post('engine'.$vehicleDetails[$i]),
                    'model_year' =>  $this->input->post('model'.$vehicleDetails[$i]),
                    'daily_rate' =>  $this->input->post('daily_rate'.$vehicleDetails[$i]),
                    'weekly_rate' =>  $this->input->post('weekly_rate'.$vehicleDetails[$i]),
                    'monthly_rate' =>  $this->input->post('monthly_rate'.$vehicleDetails[$i]),
                    'insurance_type' =>  $this->input->post('insurance'.$vehicleDetails[$i]),
                    'breakdown_recovery' =>  $this->input->post('breakdown'.$vehicleDetails[$i]),
                    'remarks' =>  $this->input->post('general_remarks'.$vehicleDetails[$i]),
                );
                
                $quotationDetails[] =$quotationDetail;
            }
            
            // echo '<pre>';
            // print_r($quotationDetails);
            // exit;
            
            
					   // echo '<pre>';
					   // print_r($quotationHeader);exit;
        }
        
        if ( ($this->form_validation->run() == true) && $this->quotationheader_model->addQuotationDetail($quotationHeader,$quotationDetails))
		{  
			$this->session->set_flashdata('success', 'Quotation Details added successfully.');
			redirect("quotationheader",'refresh');
		}
		else
		{
        
            $data['branch'] = $this->quotationheader_model->getBranch();
            $data['customer'] = $this->quotationheader_model->getCustomer();
            $data['vehicle'] = $this->quotationheader_model->getVehicle1();
            $vehicleID = $this->quotationheader_model->getVehicleId();
            $vehicleNo = $this->quotationheader_model->getVehicleRegNo();
            //$brand = $this->array_flatten($vehicle);
            //$vehicle_id = $this->array_flatten($vehicleID);
            //$vehicleRegNo = $this->array_flatten($vehicleNo);
            // echo '<pre>';
            // print_r($vehicleRegNo);
            // exit;
            //$data['vehicle_id'] = $vehicle_id;
            //$data['brand'] = $brand;
            //$data['vehicle_reg_no'] = $vehicleRegNo;
            
            $meta['page_title'] = 'Add Quotation';
            $data['page_title'] = "Add Quotation";
            $this->load->view('commons/header', $meta);
            $this->load->view('add', $data);
            $this->load->view('commons/footer');
        }
    }
    
    function edit($quotation_id)
    {
        $id = $quotation_id;
        
        if($post = $this->input->post())
        {
            //quotation header form validation
            /* ==============VALIDATION FOR SELECTBOX branch ================ */
            $this->form_validation->set_rules('branch','Branch','required|callback_check_default');
            $this->form_validation->set_message('check_default', 'You need to select branch other than the default.');
            /* --------------*/
            /* ==============VALIDATION FOR SELECTBOX customer ================ */
            $this->form_validation->set_rules('customer','Customer','required|callback_check_default1');
            $this->form_validation->set_message('check_default1', 'You need to select customer other than the default.');
            /* --------------*/
            $this->form_validation->set_rules('quotation_date', 'Date of Quotation', 'trim|required|xss_clean');
            $this->form_validation->set_rules('validity', 'Validity in Days', 'trim|required|xss_clean');
            
            if ($this->form_validation->run() == true)
            {
                $quotationHeader = array(
                    'branch_id'	            =>	$this->input->post('branch'),
                    'customer_id'	        =>	$this->input->post('customer'),
                    'quotation_date'        =>  $this->input->post('quotation_date'),
                    'validity_upto'         =>  $this->input->post('validity'),
                    'status'                =>  $this->input->post('status'),
                );
            // print_r($quotationHeader);    exit;
                $noOfDetails = $this->input->post('seq');
            // echo $noOfDetails;
            // exit;
            $vehicleDetails = explode(',',$noOfDetails);
            $brand = array();
            $model = array();
            $engine = array();
            $daily_rate = array();
            $weekly_rate = array();
            $monthly_rate = array();
            $insurance = array();
            $breakdown = array();
            $general_remarks = array();
            
            for($i=0; $i<sizeof($vehicleDetails); $i++){
                $quotationDetail = array(
                    'vehicle_id' =>	  $this->input->post('brand'.$vehicleDetails[$i]),                    
                    'engine_capacity' =>  $this->input->post('engine'.$vehicleDetails[$i]),
                    'model_year' =>  $this->input->post('model'.$vehicleDetails[$i]),
                    'daily_rate' =>  $this->input->post('daily_rate'.$vehicleDetails[$i]),
                    'weekly_rate' =>  $this->input->post('weekly_rate'.$vehicleDetails[$i]),
                    'monthly_rate' =>  $this->input->post('monthly_rate'.$vehicleDetails[$i]),
                    'insurance_type' =>  $this->input->post('insurance'.$vehicleDetails[$i]),
                    'breakdown_recovery' =>  $this->input->post('breakdown'.$vehicleDetails[$i]),
                    'remarks' =>  $this->input->post('general_remarks'.$vehicleDetails[$i]),
                );
                
                $quotationDetails[] =$quotationDetail;
            }
                // echo '<pre>';
                // print_r($quotationHeader);exit;
                
                // echo '<pre>';
                // print_r($quotationDetails);exit;
            }
            if (($this->form_validation->run() == true) && $this->quotationheader_model->updateQuotationHeader($quotationHeader,$quotationDetails,$quotation_id))
            {  
                $this->session->set_flashdata('success', 'Quotation Details edited successfully.');
                redirect("quotationheader",'refresh');
            }
            else
            {
                $data['quotation_header'] = $this->quotationheader_model->getQuotationHeader($quotation_id);
                $data['quotation_details'] = $this->quotationheader_model->getQuotationHeaderDetails($quotation_id);
                $data['branch'] = $this->quotationheader_model->getBranch();
                $data['customer'] = $this->quotationheader_model->getCustomer();
                $vehicle = $this->quotationheader_model->getVehicle();
                $vehicleID = $this->quotationheader_model->getVehicleId();
                $vehicleNo = $this->quotationheader_model->getVehicleRegNo();
                $vehicleRegNo = $this->array_flatten($vehicleNo);
                $brand = $this->array_flatten($vehicle);
                $vehicle_id = $this->array_flatten($vehicleID);
                // echo '<pre>';
                // print_r($vehicle_id);
                // exit;
                $data['vehicle_id'] = $vehicle_id;
                $data['brand'] = $brand;
                $data['vehicle_reg_no'] = $vehicleRegNo;
                
                $meta['page_title'] = 'Add Quotation';
                $data['page_title'] = "Add Quotation";
                $this->load->view('commons/header', $meta);
                $this->load->view('add', $data);
                $this->load->view('commons/footer');
            
            }
        }
        else
        {
            $data['quotation_header'] = $this->quotationheader_model->getQuotationHeader($quotation_id);
            $data['quotation_details'] = $this->quotationheader_model->getQuotationHeaderDetails($quotation_id);
            // echo '<pre>';
            // print_r($data['quotation_details']);exit;
            $data['branch'] = $this->quotationheader_model->getBranch();
            $data['customer'] = $this->quotationheader_model->getCustomer();
            $vehicle = $this->quotationheader_model->getVehicle();
            $vehicleID = $this->quotationheader_model->getVehicleId();
            $vehicleNo = $this->quotationheader_model->getVehicleRegNo();
            $vehicleRegNo = $this->array_flatten($vehicleNo);
            $brand = $this->array_flatten($vehicle);
            $vehicle_id = $this->array_flatten($vehicleID);
            $data['id'] = $quotation_id;
            // echo '<pre>';
            // print_r($vehicleRegNo);
            // exit;
            $data['vehicle_id'] = $vehicle_id;
            $data['brand'] = $brand;
            $data['vehicle_reg_no'] = $vehicleRegNo;
            
            $meta['page_title'] = 'Edit Quotation';
            $data['page_title'] = "Edit Quotation";
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
    
    /* =====================VALIDATION FOR customer ======================== */
    function check_default1($post_string)
    {
        return $post_string == '0' ? FALSE : TRUE;
    }
    
    //for converting multidimensional array into single array
    function array_flatten($array) { 
        if (!is_array($array)) { 
            return FALSE; 
        } 
        //$result = array(); 
        foreach ($array as $key => $value) { 
            // if (is_array($value)) { 
                // $result = array_merge($result, $this->array_flatten($value)); 
            // } 
            // else { 
                // $result[$key] = $value; 
            // }
            foreach($value as $val)
            {
                $result[] = $val;
                //echo '<br/>';
            }
        }
        return $result; 
    }     
    
    function scanVehicle()
    {
        if($this->input->post('vehicle_id')){
            $vehicle_id = $this->input->post('vehicle_id');
        }
        // echo $vehicle_id;
        $vehicle_data = $this->quotationheader_model->getVehicleData($vehicle_id);
        echo json_encode($vehicle_data);
    }
    
    function quotation_pdf($quotation_id){
        $id = $quotation_id;
        $quotationData = $this->quotationheader_model->getQuotation($id);
        $quotationDetail = $this->quotationheader_model->getQuotationDetails($id);
        // echo '<pre>';
        // print_r($quotationData);
        $date = $quotationData->quotation_date;
        
        $newDate = str_replace('/', '-', $date);
        // create new PDF document
        $pdf = new Pdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetSubject('TCPDF Tutorial');
        $pdf->SetKeywords('TCPDF, PDF, example, test, guide');

        // set default header data
        $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, 'MORNING STAR RENT A CAR', '', array(0,64,255), array(0,64,128));
        $pdf->setFooterData(array(0,64,0), array(0,64,128));

        // set header and footer fonts
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', 15));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        // set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        // set some language-dependent strings (optional)
        if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
            require_once(dirname(__FILE__).'/lang/eng.php');
            $pdf->setLanguageArray($l);
        }

        // ---------------------------------------------------------

        // set default font subsetting mode
        $pdf->setFontSubsetting(true);

        // Set font
        // dejavusans is a UTF-8 Unicode font, if you only need to
        // print standard ASCII chars, you can use core fonts like
        // helvetica or times to reduce file size.
        $pdf->SetFont('dejavusans', '', 14, '', true);

        // Add a page
        // This method has several options, check the source code documentation for more information.
        $pdf->AddPage();

        // set text shadow effect
        $pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));
        ob_start();
        ?>
        <table style="font-size:12px;" cellspacing="0">
            <tr>
                <td>
                    <table width="100%">
                        <tr>
                            <td align='left' width="50%" style="margin-left:-10px !important;">
                                <table>
                                    <tr>
                                        <td>
                                         <p><?php echo date('d', strtotime( $newDate));?><sup><?php echo date('S', strtotime( $newDate));?></sup> <?php echo date('F Y', strtotime( $newDate));?></p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <?php echo ""; ?><br/>
                                            <?php echo $quotationData->en_name; ?><br/>
                                            <?php echo $quotationData->en_company_name; ?><br/>
                                            <?php echo $quotationData->en_local_address; ?><br/>
                                            <?php echo $quotationData->en_nationality_code;?><br/>
                                            <br/>
                                            After Compliments: 
                                        </td>
                                    </tr>
                                    
                                    
                                </table>
                                
                                
                            </td>
                            <td align='right' width="40%" style="text-align:right;">
                                <p style="color: black;float:right;"><?php echo 'Quotation No:' .$quotation_id; ?> </p>
                            </td>
                            <td width="10%"></td>
                        </tr>
                        
                        
                    </table>
                </td>
            </tr>
          
            <tr>
                <td align="center">
                    <strong>QUOTATION FOR RENTING OUR CARS</strong>
                    
                </td>
            </tr>
             <tr>
                <td align="left" style="padding-left:20px !important;">
                    <p>We understand that you are looking to hire vehicle for your requirement.
We would like to offer our vehicles at the following very competitive rate:</p>
                    <br/>
                </td>
            </tr>
            <tr>
                <td align="left" style="padding-left:70px;padding-right:70px;padding-top:10px;">
                    <table border="1" cellspacing="0">
                        <tr align="center">
                            <td width="3%" align="center">SN</td>
                            <td width="30%" align="center">Brand</td>
                            <td width="8%" align="center">Model</td>
                            <td width="5%" align="center">Eng</td>
                            <td width="8%" align="center">Per day</td>
                            <td width="8%" align="center">Per Week</td>
                            <td width="9%" align="center">Per Month</td>
                            <td width="16%" align="center">Insurance</td>
                            <td width="15%" align="center">Breakdown Recovery</td>
                        </tr>
                        <?php 
                            for($i=0;$i<sizeof($quotationDetail);$i++){
                        ?>
                        <tr align="center">
                            <td><?php echo $i+1; ?></td>
                            <td><?php echo $quotationDetail[$i]['brand']; ?></td>
                            <td><?php echo $quotationDetail[$i]['model_year']; ?></td>
                            <td style="padding:4px;"><?php echo $quotationDetail[$i]['engine_capacity']; ?></td>
                            <td><?php echo $quotationDetail[$i]['daily_rate']; ?></td>
                            <td><?php echo $quotationDetail[$i]['weekly_rate']; ?></td>
                            <td><?php echo $quotationDetail[$i]['monthly_rate']; ?></td>
                            <td><?php echo $quotationDetail[$i]['insurance_type']; ?></td>
                            <td align="center"><?php echo $quotationDetail[$i]['breakdown_recovery']; ?></td>
                        </tr>
                        <?php
                            }
                        ?>
                    </table>
                 
                </td>
            </tr>
            <tr>
                <td width='100%' align="left">
                    <p>Please note that the above rate is for covering a total of 200 per day 1200 Km per week 4800 Km per month. In case of total mileage run exceeds the above kms, an extra per kilometre rate of OMR 0.050 and 0.100 for saloon and four wheel vehicles respectively, each will be billed to you.</p>
                    <p>If you require any further information, please do feel free to contact us any time.
Assuring you of our best attention and services always and looking forward to your valued patronage and order.</p>
                    
                                             
                    Yours faithfully<br>
                    <span style="margin-left:100px;">for MORNING STAR RENT A CAR</span><br><br>
                    <div style="border-bottom:1px solid black;width:5%;display:inline-block;"></div>
                    
                    Office Administrator
                    <br/>
                    <br/>
                    <br/>
                </td>
            </tr>
        </table>
        <?php
            $html = ob_get_contents();
            ob_end_clean();
            // Print text using writeHTMLCell()
            $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

            // ---------------------------------------------------------

            // Close and output PDF document
            // This method has several options, check the source code documentation for more information.
            $pdf->Output('Quotation_'.$quotation_id.'.pdf', 'D');
    }
    
}