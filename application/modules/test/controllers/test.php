<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Test extends CI_Controller
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
		// $this->load->model('test_model');
        $this->load->library('upload');
		$this->load->library('Datatables');
        $this->load->library('Pdf');
        
	}
    
    function testPdf(){
        // create new PDF document
        $pdf = new Pdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetSubject('TCPDF Tutorial');
        $pdf->SetKeywords('TCPDF, PDF, example, test, guide');

        // set default header data
        $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, 'MORNING STAR RENT A CAR', 'Quotation No:10', array(0,64,255), array(0,64,128));
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
        <table width='100%' style="font-size:12px;">
                <tr>
                    <td width='100%' style="padding-left:40px;padding-top:10px">
                            20 th November 2015
                    </td>
                </tr>
                <tr>
                    <td width='100%' style="padding-left:40px">
                        <address>
                            Naseem Shah <br/>
                            Universal Travel & Tourism Agencies LLC<br/>
                            P.O.Box:2802, PC:112, Ruwi<br/>
                            Sultanate of Oman<br/>
                        </address>
                        <br/>
                        After Compliments: 
                    </td>
                </tr>
                <tr>
                    <td width='100%' align="center">
                        <strong>QUOTATION FOR RENTING OUR CARS</strong>
                        
                    </td>
                </tr>
                 <tr>
                    <td width='100%' align="left" style="padding-left:60px;padding-right:40px;padding-top:10px;text-indent:30px;">
                        <p>We understand that you are looking to hire vehicle for your requirement.
We would like to offer our vehicles at the following very competitive rate:</p>
                    </td>
                </tr>
                <tr>
                    <td width='100%' align="left" style="padding-left:70px;padding-right:70px;padding-top:10px;">
                        <table width='100%' border="1" cellspacing="0" style="font-size:11px;">
                            <tr align="center">
                                <td width="3%" align="center">SN</td>
                                <td width="31%" align="center">Brand</td>
                                <td width="8%" align="center">Model</td>
                                <td width="5%" align="center">Eng</td>
                                <td width="8%" align="center">Per day</td>
                                <td width="8%" align="center">Per Week</td>
                                <td width="8%" align="center">Per Month</td>
                                <td width="16%" align="center">Insurance</td>
                                <td width="15%" align="center">Breakdown Recovery</td>
                            </tr>
                            <tr>
                                <td>1</td>
                                <td>Yaris (Toyota) Fully</td>
                                <td>2013</td>
                                <td>1.6</td>
                                <td>16</td>
                                <td>85</td>
                                <td>230</td>
                                <td>Comprehensive</td>
                                <td>Yes</td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Yaris (Toyota) Fully</td>
                                <td>2013</td>
                                <td>1.6</td>
                                <td>16</td>
                                <td>85</td>
                                <td>230</td>
                                <td>Comprehensive</td>
                                <td>Yes</td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>Yaris (Toyota) Fully</td>
                                <td>2013</td>
                                <td>1.6</td>
                                <td>16</td>
                                <td>85</td>
                                <td>230</td>
                                <td>Comprehensive</td>
                                <td>Yes</td>
                            </tr>
                           <tr>
                                <td>4</td>
                                <td>Yaris (Toyota) Fully(Toyota)</td>
                                <td>2013</td>
                                <td>1.6</td>
                                <td>16</td>
                                <td>85</td>
                                <td>230</td>
                                <td>Comprehensive</td>
                                <td>Yes</td>
                            </tr>
                            <tr>
                                <td>5</td>
                                <td>Yaris (Toyota) Fully</td>
                                <td>2013</td>
                                <td>1.6</td>
                                <td>16</td>
                                <td>85</td>
                                <td>230</td>
                                <td>Comprehensive</td>
                                <td>Yes</td>
                            </tr>
                            <tr>
                                <td>5</td>
                                <td>Yaris (Toyota) Fully</td>
                                <td>2013</td>
                                <td>1.6</td>
                                <td>16</td>
                                <td>85</td>
                                <td>230</td>
                                <td>Comprehensive</td>
                                <td>Yes</td>
                            </tr>
                            <tr>
                                <td>5</td>
                                <td>Yaris (Toyota) Fully</td>
                                <td>2013</td>
                                <td>1.6</td>
                                <td>16</td>
                                <td>85</td>
                                <td>230</td>
                                <td>Comprehensive</td>
                                <td>Yes</td>
                            </tr>
                            <tr>
                                <td>5</td>
                                <td>Yaris (Toyota) Fully</td>
                                <td>2013</td>
                                <td>1.6</td>
                                <td>16</td>
                                <td>85</td>
                                <td>230</td>
                                <td>Comprehensive</td>
                                <td>Yes</td>
                            </tr>
                        </table>
                     
                    </td>
                </tr>
                <tr>
                    <td width='100%' align="left" style="padding-left:40px;padding-top:10px;padding-right:30px;text-indent:30px;">
                        <p>Please note that the above rate is for covering a total of 200 per day 1200 Km per week 4800 Km per month. In case of total mileage run exceeds the above kms, an extra per kilometre rate of OMR 0.050 and 0.100 for saloon and four wheel vehicles respectively, each will be billed to you.</p>
                        <p>If you require any further information, please do feel free to contact us any time.
Assuring you of our best attention and services always and looking forward to your valued patronage and order.</p>
                        
                                                 
                        Yours faithfully<br>
                        for MORNING STAR RENT A CAR<br><br>
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
        $pdf->Output('Quotation.pdf', 'I');
        
    }
    
    function index(){
        $data['rs'] =  $this->db->get('countries');
        $this->load->view('index',$data);
    }
    
    public function excel()
    {
        $this->excel->setActiveSheetIndex(0);
        //name the worksheet
        $this->excel->getActiveSheet()->setTitle('Countries');
        //set cell A1 content with some text
        $this->excel->getActiveSheet()->setCellValue('A1', 'Country Excel Sheet');
        $this->excel->getActiveSheet()->setCellValue('A4', 'S.No.');
        $this->excel->getActiveSheet()->setCellValue('B4', 'Country Code');
        $this->excel->getActiveSheet()->setCellValue('C4', 'Country Name');
        //merge cell A1 until C1
        $this->excel->getActiveSheet()->mergeCells('A1:C1');
        //set aligment to center for that merged cell (A1 to C1)
        $this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        //make the font become bold
        $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(16);
        $this->excel->getActiveSheet()->getStyle('A1')->getFill()->getStartColor()->setARGB('#333');
        for($col = ord('A'); $col <= ord('C'); $col++){
                //set column dimension
                $this->excel->getActiveSheet()->getColumnDimension(chr($col))->setAutoSize(true);
                 //change the font size
                $this->excel->getActiveSheet()->getStyle(chr($col))->getFont()->setSize(12);
                 
                $this->excel->getActiveSheet()->getStyle(chr($col))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        }
        //retrive contries table data
        $rs = $this->db->get('countries');
        $exceldata="";
        foreach ($rs->result_array() as $row){
                $exceldata[] = $row;
        }
        //Fill data 
        $this->excel->getActiveSheet()->fromArray($exceldata, null, 'A4');
         
        $this->excel->getActiveSheet()->getStyle('A4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->getStyle('B4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->getStyle('C4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
         
        $filename='PHPExcelDemo.xls'; //save our workbook as this file name
        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache

        //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
        //if you want to save it as .XLSX Excel 2007 format
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
        //force user to download the Excel file without writing it to server's HD
        $objWriter->save('php://output');
                 
    }
    
    function pdf()
    {
        $this->load->helper(array('dompdf', 'file'));
        $data['rs'] =  $this->db->get('countries');
        $html = $this->load->view('index',$data,TRUE);
        pdf_create($html, 'milan');
        // or
        // $data = pdf_create($html, '', false);
        // write_file('name', $data);
        //if you want to write it to disk and/or send it as an attachment    
    }
    
    function quotation_pdf(){
        $this->load->helper('dompdf');
        ob_start();
        ?>
        <table width='100%' border=1 align="center" cellspacing="0">
    <tr>
        <td width='30%'></td>
        <td style="font-size:25px; padding-top:40px;letter-spacing: 1.5px;color:#0099CC" align='center'> MORNING STAR NATIONAL ENTERPRISE </td>
    </tr>
    <tr>
        <td width='100%' colspan='2'>
            <table width='100%'>
                <tr>
                    <td width='100%' style="padding-left:40px;padding-top:10px">
                            20 th November 2015
                    </td>
                </tr>
                <tr>
                    <td width='100%' style="padding-left:40px">
                        <address>
                            Naseem Shah <br/>
                            Universal Travel & Tourism Agencies LLC<br/>
                            P.O.Box:2802, PC:112, Ruwi<br/>
                            Sultanate of Oman<br/>
                        </address>
                        <br/>
                        After Compliments: 
                    </td>
                </tr>
                <tr>
                    <td width='100%' align="center">
                        <strong>QUOTATION FOR RENTING OUR CARS</strong>
                        
                    </td>
                </tr>
                 <tr>
                    <td width='100%' align="left" style="padding-left:40px;padding-right:40px;padding-top:10px;text-indent:30px;">
                        <p>We understand that you are looking to hire vehicle for your service departments
We would like to offer our vehicles at the following very competitive rate:</p>
                    </td>
                </tr>
                <tr>
                    <td width='100%' align="left" style="padding-left:70px;padding-right:70px;padding-top:10px;">
                        <table width='100%' border="1" cellspacing="0">
                            <tr>
                                <td width="2%" align="center">SN</td>
                                <td width="30%" align="center">Brand</td>
                                <td width="5%" align="center">Model</td>
                                <td width="5%" align="center">Eng</td>
                                <td width="8%" align="center">Per day</td>
                                <td width="10%" align="center">Per Week</td>
                                <td width="10%" align="center">Per Month</td>
                                <td width="15%" align="center">Insurance</td>
                                <td width="15%" align="center">Breakdown Recovery</td>
                            </tr>
                            <tr>
                                <td>1</td>
                                <td>Yaris (Toyota) Fully</td>
                                <td>2013</td>
                                <td>1.6</td>
                                <td>16</td>
                                <td>85</td>
                                <td>230</td>
                                <td>Comprehensive</td>
                                <td>Yes</td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Yaris (Toyota) Fully</td>
                                <td>2013</td>
                                <td>1.6</td>
                                <td>16</td>
                                <td>85</td>
                                <td>230</td>
                                <td>Comprehensive</td>
                                <td>Yes</td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>Yaris (Toyota) Fully</td>
                                <td>2013</td>
                                <td>1.6</td>
                                <td>16</td>
                                <td>85</td>
                                <td>230</td>
                                <td>Comprehensive</td>
                                <td>Yes</td>
                            </tr>
                           <!--  <tr>
                                <td>4</td>
                                <td>Yaris (Toyota) Fully(Toyota) Fully(Toyota) Fully(Toyota) Fully</td>
                                <td>2013</td>
                                <td>1.6</td>
                                <td>16</td>
                                <td>85</td>
                                <td>230</td>
                                <td>Comprehensive</td>
                                <td>Yes</td>
                            </tr>
                            <tr>
                                <td>5</td>
                                <td>Yaris (Toyota) Fully</td>
                                <td>2013</td>
                                <td>1.6</td>
                                <td>16</td>
                                <td>85</td>
                                <td>230</td>
                                <td>Comprehensive</td>
                                <td>Yes</td>
                            </tr> -->
                        </table>
                     
                    </td>
                </tr>
                <tr>
                    <td width='100%' align="left" style="padding-left:40px;padding-top:10px;padding-right:30px;text-indent:30px;">
                        <p>Please note that the above rate is for convering a total of 200 per day 1200 Km per week 4800 Km per month. In case of thtal mileage run exceeds the abvoe kms, an extra per kilometer rate of OMR 0.050 and 0.100 for salon and four wheel vehicles respectively, each will be billed to you.</p>
                        <p>If you require any further information, please do feel free to contact us any time.
Assuring you of our best attention and services always and looking forward to your valued patronage and order.</p>
                        
                                                 
                        Yours faithfully<br>
                        for MORNING STAR RENT-A-CAR<br><br>
                        <div style="border-bottom:1px solid black; height:30px; width:200px"></div>
                        
                        Authorised Signatory
                        <br/>
                        <br/>
                        <br/>
                    </td>
                </tr>
                <tr >
                    <td width='80%' align="center" style="padding-left:40px;padding-top:10px;padding-right:30px;text-indent:30px;border-top:1px solid black;">
                    
                     
                        <p>
                         P.O. Box 2295 Ruwi, Postal Code 112, Sultanate of Oman, Tel. : 24593177, GSM: 99441688, CR No.: 178280
                        </p>
                    </td>
                </tr>
                
               
                
            </table>
        </td>
    </tr>

</table>
        <?php
            $content = ob_get_contents();
            ob_end_clean();
            pdf_create($content, 'test');
    }
}
?>