<style type="text/css" media="all">
.container {
	width:80%;
	margin:20px auto 20px auto;		
	border:1px solid #ccc;
}
.header {
	
}
.headerleftbox {
	float:left;
	width:70%;	
}
.headerrightbox {
	float:left;
	width:30%;	
}
.logo {
	float:left;
}
.logo img {
	height:80px;
	margin:30px 30px 30px 30px;	
}
.companyname {
	margin:10px 0px 0px 0px;
}
.content {
	margin:30px 0px 30px 0px;
	float:left;	
}
.clear {
	clear:both;	
}
.col-6 {
	width:50%;
	float:left;	
}
.contenttable {
	width:100%;
	margin:0px 0px 10px 0px;
}
.contenttable td {
	border:1px solid #ccc;	
	padding:10px;
	width:100%;
}
.col-3 {
	width:30%;
	float:left;	
}
.col-9 {
	width:70%;
	float:left;	
}
</style>
<style type="text/css" media="print">
.container {
	display:inline;	
}
</style>
<div class="container">
	<div class="header">
		<div class="headerleftbox">
        	<div class="logo">
            	<img src="<?php echo base_url(); ?>assets/images/MSRC Logo.png" />
            </div>
            <div class="companyname">
            	<h1>Morning Star National Enterprises</h1>
           	 	<h3>Morning Star Rent A Car</h3>
            </div>
            <p>P.O. Box: 2295, Postal Code: 112, Sultanate of Oman, Tel: 24478589,24478505, Fax:24593177, GSM:94475478, C.R:1782380</p>
        </div>
        <div class="headerrightbox">
        	<div class="toprightbox">
            	<p>R.A. No. 0<?php echo $agreement->rental_id; ?></p>
                <p>Contd. from R.A. No.</p>
                <p>Contd. to R.A. No.</p>
            </div>
            <div class="toprightboxbelow">
            	<h3>Vehicle Rental Agreement</h3>
            </div>
        </div>
        <div class="clear"></div>
    </div>
    <div class="content">
    	<div class="col-6">
        	<table border="0" class="contenttable" cellpadding="0" cellspacing="0" width="100%">
            	<tr>
                	<td>Renter Name: <?php echo $agreement->en_name; ?></td>
                </tr>
                <tr>
                	<td>Nationality: <?php echo $agreement->en_nationality_code; ?></td>
                </tr>
                <tr>
                	<td>Passport No.:<?php echo $agreement->en_passport_no ?></td>
                </tr>
                <tr>
                	<td>Place and Date of Issue: <?php echo $agreement->en_place_issue."&nbsp;".$agreement->en_date_issue; ?></td>
                </tr>
                <tr>
                	<td>Local Address: <?php echo $agreement->en_local_address; ?></td>
                </tr>
                <tr>
                	<td>Telephone: <?php echo $agreement->mobile_no; ?></td>
                </tr>
                <tr>
                	<td>Mailing Address: <?php echo $agreement->en_mailing_address; ?></td>
                </tr>
                <tr>
                	<td>&nbsp;</td>
                </tr>
                <tr>
                	<td>Fax <span style="float:right;">Telephone:<?php echo $agreement->telephone; ?></span></td>
                </tr>
            </table>
            <table border="0" class="contenttable" cellpadding="0" cellspacing="0" width="100%">
            	<tr>
                	<td>Driver Name</td>
                </tr>
                <tr>
                	<td>License No.: American <span style="float:right;">Issued At:</span></td>
                </tr>
                <tr>
                	<td>Date of Issue: <span style="float:right;">Date of Expiry:</span></td>
                </tr>
            </table>
            <table border="0" class="contenttable" cellpadding="0" cellspacing="0" width="100%">
            	<tr>
                	<td>Additional Driver's Name</td>
                </tr>
                <tr>
                	<td>License No.: American <span style="float:right;">Issued At:</span></td>
                </tr>
                <tr>
                	<td>Date of Issue: <span style="float:right;">Date of Expiry:</span></td>
                </tr>
            </table>
            <table border="0" class="contenttable" cellpadding="0" cellspacing="0" width="100%">
            	<tr>
                	<td>&nbsp;</td>
                    <td>Rate</td>
                    <td>Accept</td>
                    <td>Decline</td>
                </tr>
                <tr>
                	<td>Loss Damage Waiver(LDW)</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                	<td>Theft Protection(TF)</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                	<td>Personal Accident Insurance(PAI)</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </table>
            <div class="col-3">
            	<p style="margin-left:30px; margin-top:0;">Accessories</p>
            </div>
            <div class="col-9">
            	<table>
                	<tr>
                    	<td><input type="checkbox" /> Additional Spare Type</td>
                        <td><input type="checkbox" /></td>
                    </tr>
                    <tr>
                    	<td><input type="checkbox" /> Roof Rack</td>
                        <td><input type="checkbox" /></td>
                    </tr>
                    <tr>
                    	<td><input type="checkbox" /> Babby Seat</td>
                        <td><input type="checkbox" /></td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="col-6">
        	<table border="0" class="contenttable" cellpadding="0" cellspacing="0">
            	<tr>
                	<td>Previous Rental Agreement No.</td>
                </tr>
            </table>
            <table border="0" class="contenttable" cellpadding="0" cellspacing="0">
            	<tr>
                	<td colspan="5" align="center">Payment</td>
                </tr>
                <tr>
                	<td>Cash</td>
                    <td>Cheque</td>
                    <td>Credit Card</td>
                    <td>Car Code No.</td>
                    <td>Credit.....Days</td>
                </tr>
                <tr>
                	<td colspan="5">Letter/LPO Number <span style="float:right;">Date:</span></td>
                </tr>
            </table>
            <table border="0" class="contenttable" cellpadding="0" cellspacing="0">
            	<tr>
                	<td>Rented Date <?php echo $agreement->date_rental; ?><span style="float:right;">Time:</span></td>
                </tr>
                <tr>
                	<td>Expected Return Date <?php echo $agreement->expected_return_date; ?><span style="float:right;">Time:</span></td>
                </tr>
                <tr>
                	<td>Return Date <span style="float:right;">Time:</span></td>
                </tr>
            </table>
            <table border="0" class="contenttable" cellpadding="0" cellspacing="0">
            	<tr>
                	<td>Vehicle No. <?php echo $agreement->vehicle_reg_no; ?></td>
                </tr>
            </table>
            <table border="0" class="contenttable" cellpadding="0" cellspacing="0">
            	<tr>
                	<td>Rental Rate R.O. <?php echo $agreement->rent_amount; ?></td>
                </tr>
            </table>
            
            <table border="0" class="contenttable" cellpadding="0" cellspacing="0">
            	<tr>
                	<td style="width:25%;">K.M. In </td>
                    <td style="width:25%;"><?php echo $agreement->km_reading_in; ?></td>
                    <td style="width:25%;">&nbsp;</td>
                    <td style="width:25%;">&nbsp;</td>
                </tr>
                <tr>
                	<td style="width:25%;">K.M. Out</td>
                    <td style="width:25%;"><?php echo $agreement->km_reading_out; ?></td>
                    <td style="width:25%;">&nbsp;</td>
                    <td style="width:25%;">&nbsp;</td>
                </tr>
                <tr>
                	<td style="width:25%;">K.M. Used</td>
                    <td style="width:25%;">&nbsp;</td>
                    <td style="width:25%;">&nbsp;</td>
                    <td style="width:25%;">&nbsp;</td>
                </tr>
                <tr>
                	<td style="width:25%;">K.M. Allowed</td>
                    <td style="width:25%;"><?php echo $agreement->km_allowed; ?></td>
                    <td style="width:25%;">&nbsp;</td>
                    <td style="width:25%;">&nbsp;</td>
                </tr>
                <tr>
                	<td style="width:25%;">K.M. Extra</td>
                    <td style="width:25%;">&nbsp;</td>
                    <td style="width:25%;">&nbsp;</td>
                    <td style="width:25%;">&nbsp;</td>
                </tr>
            </table>
            <div style="height:19px;"></div>
            <table border="0" class="contenttable" cellpadding="0" cellspacing="0">
            	<tr>
                	<td style="width:30%;">
                    	<p>K.M. Allowed:</p>
                        <p style="position:relative;"><?php if($agreement->rental_type == 'Daily') { ?><span style="top:-10;position:absolute;z-index:999"><img width="40" src="<?php echo base_url()."assets/img/tick_16.png"; ?>" /></span><?php } ?>200 K.M. Daily</p>
                        <p style="position:relative;"><?php if($agreement->rental_type == 'Weekly') { ?><span style="top:-10;position:absolute;z-index:999"><img width="40" src="<?php echo base_url()."assets/img/tick_16.png"; ?>" /></span><?php } ?>1200 K.M. Weekly</p>
                        <p style="position:relative;"><?php if($agreement->rental_type == 'Monthly') { ?><span style="top:-10;position:absolute;z-index:999"><img width="40" src="<?php echo base_url()."assets/img/tick_16.png"; ?>" /></span><?php } ?>4800 K.M. Monthly</p>
                    </td>
                    <td colspan="2" style="padding:0;margin:0;" style="width:40%;">
                    	<table width="100%">
                        	<tr>
                            	<td style="width:50%;">&nbsp;</td>
                                <td style="width:50%;">&nbsp;</td>
                            </tr>
                            <tr>
                            	<td>&nbsp;</td>
                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                            	<td>&nbsp;</td>
                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                            	<td>&nbsp;</td>
                                <td>&nbsp;</td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                	<td style="width:60%;">No. of Days</td>
                    <td style="width:20%;">&nbsp;</td>
                    <td style="width:20%;">&nbsp;</td>
                </tr>
                <tr>
                	<td>Extra KM</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                	<td>Additional Driver</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                	<td>Chauffer Charges</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                	<td>Sub Total</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                	<td>Fuel</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                	<td>Refuelling Services</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                	<td>Sub Total</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                	<td>Traffic Fines</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                	<td>Additional Insurance</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                	<td>PAI</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                	<td>Deposit Depodit Advance</td>
                    <td><?php echo $agreement->deposit_amount; ?></td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                	<td>Total Charges</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                	<td>Deductions</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
            </table>
            <h4>Total Amount Paybale in Rials Omani</h4>
            
            <table border="0" class="contenttable" cellpadding="0" cellspacing="0">
            	<tr>
                	<td>For Morning Star Rent A Car</td>
                </tr>
                <tr>
                	<td>Date & Time &nbsp; &nbsp; <?php echo date('d/m/Y h:m A'); ?></td>
                </tr>
            </table>
            
            <p>Customer - Please read terms & conditions</p>
        </div>
    </div>
    <div class="clear"></div>
</div>