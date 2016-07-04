<?php 
    // echo '<pre>';
    // print_r($quotationData);
    // print_r($quotationDetail);
    $date = $quotationData->quotation_date;
        
    $newDate = str_replace('/', '-', $date);
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
                            <p><?php echo date('d', strtotime( $newDate));?><sup><?php echo date('S', strtotime( $newDate));?></sup> <?php echo date('F Y', strtotime( $newDate));?></p>
                    </td>
                </tr>
                <tr>
                    <td width='100%' style="padding-left:40px">
                        <address>
                            <?php echo $quotationData->en_name ?> <br/>
                            <?php echo $quotationData->en_company_name; ?><br/>
                            <?php echo $quotationData->en_local_address; ?><br/>
                            <?php echo $quotationData->en_nationality_code;?><br/>
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
                            <?php 
                                for($i=0;$i<sizeof($quotationDetail);$i++){
                            ?>
                            <tr>
                                <td><?php echo $i+1; ?></td>
                                <td><?php echo $quotationDetail[$i]['brand']; ?></td>
                                <td><?php echo $quotationDetail[$i]['model_year']; ?></td>
                                <td><?php echo $quotationDetail[$i]['engine_capacity']; ?></td>
                                <td><?php echo $quotationDetail[$i]['daily_rate']; ?></td>
                                <td><?php echo $quotationDetail[$i]['weekly_rate']; ?></td>
                                <td><?php echo $quotationDetail[$i]['monthly_rate']; ?></td>
                                <td><?php echo $quotationDetail[$i]['insurance_type']; ?></td>
                                <td><?php echo $quotationDetail[$i]['breakdown_recovery']; ?></td>
                            </tr>
                            <?php
                                }
                            ?>
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
<script>
    // window.print();
</script>