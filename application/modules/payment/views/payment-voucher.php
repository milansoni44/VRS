<?php
    // echo '<pre>';
    // print_r($payment);
    // echo '</pre>';
?>
<style type="text/css" media="print">
 .boxcontainer {
    display:inline;
 }   
</style>
<?php 
    if($payment->rental_id != 0){
?>
<div class="boxcontainer" style="width:768px;height:576px;margin:30px auto 30px auto;border:1px solid #ccc;">
    <div style="width:100%;float:left;border-bottom:1px solid #ccc;">
        <div style="width:30%;float:left;">
            <div style="margin:20px 0px 20px 30px;">
                <img src="<?php echo base_url(); ?>assets/images/MSRC Logo.png" style="width:80px;" />
            </div>
        </div>
        <div style="width:70%;float:left;">
            <h1 style="margin:30px 0px 0px 0px;padding:0;">Morning Star Rent A Car</h1>
            <p style="margin:10px 0px 0px 0px;padding:0;">P.o. Box:2295, Ruwi, Postal Code: 112,Sultanate of Oman, Tel:24593177,Fax 24502469,GSM: +96899441688, C.R. No. 1782380</p>
        </div>
    </div>
    <div style="float:left;width:100%;padding-bottom:0px;">
        <div style="padding-left:20px;padding-right:20px">
            <div style="width:33.33%;float:left;">
                <div style="float:left;width:100%;margin:30px 0px 0px 0px;">
                    <?php
                        $values = explode('.',$payment->payment_amount);
                    ?>
                    <input type="text" style="text-align:center;float:left;height:40px;width:70%;" value="<?php echo "RO.".$payment->payment_amount; ?>" />
                </div>
            </div>
            <div style="width:33.33%;float:left;">
                <h2 style="font-size:19px;text-transform:uppercase;margin:35px 0px 0px 0px;text-align:center;">Payment Voucher</h2>
            </div>
            <div style="width:33.33%;float:left;">
                <h2 style="margin:35px 0px 0px 0px;float:right;">No. <?php echo $payment->payment_voucher_no; ?></h2>
            </div>
        </div>
    </div>
    <div style="float;left;width:100%;">
         <div style="padding-left:20px;padding-right:20px">
            <div style="float:right;">
                <p>Date: <?php echo $payment->payment_voucher_date; ?></p>
            </div>
         </div>
         <div style="clear:both;"></div>
    </div>
    <div style="float;left;width:100%;">
        <div style="padding-left:20px;padding-right:20px">
            <p style="wordwrap: break-word;">Paid to Mr. M/s <input type="text" size="250" style="text-align:center;border-bottom:1px solid #000;width:450px;border-top:0px; border-left:0px; border-right:0px; outline:0;margin-left:20px;" value="<?php echo $payment->en_name; ?>"></p>
        </div>
        <div style="clear:both;"></div>
    </div>
    <div style="float;left;width:100%;">
        <div style="padding-left:20px;padding-right:20px">
            <p style="wordwrap: break-word;">The Sum of Rials Omani   <input type="text" size="60" style="text-align:center;border-bottom:1px solid #000;width:450px;border-top:0px; border-left:0px; border-right:0px; outline:0;margin-left:20px;" value="<?php echo strtoupper(amount_wordings($payment->payment_amount)); ?>"></p>
        </div>
        <div style="clear:both;"></div>
    </div>
    <div style="float:left;width:100%;margin-top:-15px;">
        <div style="padding-left:20px;padding-right:20px">
            <div style="width:50%;float:left;">
                <?php 
                    if($payment->mode == 'CASH'){
                ?>
                <p><span>By Cash</span>/<span style="text-decoration:line-through;">Cheque No</span><input type="text" size="60" style="border-bottom:1px solid #000;width:70px;border-top:0px; border-left:0px; border-right:0px; outline:0;margin-left:20px;" value="<?php echo $payment->mode; ?>"></p>
                <?php
                    }else{
                ?>
                <p><span style="text-decoration:line-through;">By Cash</span>/<span>Cheque No</span><input type="text" size="60" style="border-bottom:1px solid #000;width:70px;border-top:0px; border-left:0px; border-right:0px; outline:0;margin-left:20px;" value="<?php echo $payment->cheque_no; ?>"></p>
                <?php
                    }
                ?>
            </div>
            <div style="width:50%;float:left;">
                <?php 
                    if($payment->mode == 'CASH'){
                ?>
                <p>Dated<input type="text" size="60" style="border-bottom:1px solid #000;width:150px;border-top:0px; border-left:0px; border-right:0px; outline:0;margin-left:20px;" value=""></p>
                <?php
                    }else{
                ?>
                <p>Dated<input type="text" size="60" style="border-bottom:1px solid #000;width:150px;border-top:0px; border-left:0px; border-right:0px; outline:0;margin-left:20px;" value="<?php echo $payment->cheque_date; ?>"></p>
                <?php
                    }
                ?>
            </div>
            <div style="width:100%;float:left;margin-top:-15px;">
                <?php 
                    if($payment->mode == "CASH"){
                ?>
                <p>Bank<input type="text" size="60" style="border-bottom:1px solid #000;width:420px;border-top:0px; border-left:0px; border-right:0px; outline:0;margin-left:20px;" value=""></p>
                <?php
                    }else{
                ?>
                <p>Bank<input type="text" size="60" style="border-bottom:1px solid #000;width:420px;border-top:0px; border-left:0px; border-right:0px; outline:0;margin-left:20px;" value="<?php echo $payment->bank_name; ?>"></p>
                <?php
                    }
                ?>
            </div>
        </div>
        <div style="clear:both;"></div>
    </div>
    <div style="float:left;width:100%;margin-top:-15px">
        <div style="padding-left:20px;padding-right:20px;">
            <p>Being in settlement of<input type="text" size="60" style="border-bottom:1px solid #000;width:450px;border-top:0px; border-left:0px; border-right:0px; outline:0;margin-left:20px;text-align:center;" value="<?php echo $payment->description; ?>"></p>
        </div>
    </div>
    <div style="float:left;width:100%;margin-top:25px;">
        <div style="padding-left:20px;padding-right:20px;">
            <div style="width:33.33%;float:left;">
                &emsp;&emsp;.....................................<br />
                <p style="text-align:center;">Prepared By</p>
            </div>
            <div style="width:33.33%;float:left;">
                &emsp;&emsp;.....................................<br />
                <p style="text-align:center;">Approved By</p>
            </div>
            <div style="width:33.33%;float:left;">
                &emsp;&emsp; .....................................<br />
                <p style="text-align:center;">Received By</p>
            </div>
        </div>
    </div>
    <div style="clear:both;"></div>
</div>
<?php
    }else{
?>
<div class="boxcontainer" style="width:80%;margin:30px auto 30px auto;border:1px solid #ccc;">
    <div style="width:100%;float:left;border-bottom:1px solid #ccc;">
        <div style="width:30%;float:left;">
            <div style="margin:20px 0px 20px 30px;">
                <img src="<?php echo base_url(); ?>assets/images/MSRC Logo.png" style="width:80px;" />
            </div>
        </div>
        <div style="width:70%;float:left;">
            <h1 style="margin:30px 0px 0px 0px;padding:0;">Morning Star Rent A Car</h1>
            <p style="margin:10px 0px 0px 0px;padding:0;">P.o. Box:2295, Ruwi, Postal Code: 112,Sultanate of Oman, Tel:24593177,Fax 24502469,GSM: +96899441688, C.R. No. 1782380</p>
        </div>
    </div>
    <div style="float:left;width:100%;padding-bottom:30px;">
        <div style="padding-left:20px;padding-right:20px">
            <div style="width:33.33%;float:left;">
                <div style="float:left;width:100%;margin:30px 0px 0px 0px;">
                    <?php
                        $values = explode('.',$payment->payment_amount);
                    ?>
                    <input type="text" style="text-align:center;float:left;height:40px;width:70%;" value="<?php echo "RO.".$payment->payment_amount; ?>" />
                </div>
            </div>
            <div style="width:33.33%;float:left;">
                <h2 style="font-size:19px;text-transform:uppercase;margin:35px 0px 0px 0px;text-align:center;">Payment Voucher</h2>
            </div>
            <div style="width:33.33%;float:left;">
                <h2 style="margin:35px 0px 0px 0px;float:right;">No. <?php echo $payment->payment_voucher_no; ?></h2>
            </div>
        </div>
    </div>
    <div style="float;left;width:100%;">
         <div style="padding-left:20px;padding-right:20px">
            <div style="float:right;">
                <p>Date: <?php echo $payment->payment_voucher_date; ?></p>
            </div>
         </div>
         <div style="clear:both;"></div>
    </div>
    <div style="float;left;width:100%;">
        <div style="padding-left:20px;padding-right:20px">
            <p style="wordwrap: break-word;">Paid to Mr. M/s <input type="text" size="250" style="text-align:center;border-bottom:1px solid #000;width:450px;border-top:0px; border-left:0px; border-right:0px; outline:0;margin-left:20px;" value="<?php echo 'Test';//echo $payment->en_name; ?>"></p>
        </div>
        <div style="clear:both;"></div>
    </div>
    <div style="float;left;width:100%;">
        <div style="padding-left:20px;padding-right:20px">
            <p style="wordwrap: break-word;">The Sum of Rials Omani   <input type="text" size="60" style="text-align:center;border-bottom:1px solid #000;width:450px;border-top:0px; border-left:0px; border-right:0px; outline:0;margin-left:20px;" value="<?php echo strtoupper(amount_wordings($payment->payment_amount)); ?>"></p>
        </div>
        <div style="clear:both;"></div>
    </div>
    <div style="float:left;width:100%;">
        <div style="padding-left:20px;padding-right:20px">
            <div style="width:50%;float:left;">
                <?php 
                    if($payment->mode == 'CASH'){
                ?>
                <p><span>By Cash</span>/<span style="text-decoration:line-through;">Cheque No</span><input type="text" size="60" style="border-bottom:1px solid #000;width:70px;border-top:0px; border-left:0px; border-right:0px; outline:0;margin-left:20px;" value="<?php echo $payment->mode; ?>"></p>
                <?php
                    }else{
                ?>
                <p><span style="text-decoration:line-through;">By Cash</span>/<span>Cheque No</span><input type="text" size="60" style="border-bottom:1px solid #000;width:70px;border-top:0px; border-left:0px; border-right:0px; outline:0;margin-left:20px;" value="<?php echo $payment->cheque_no; ?>"></p>
                <?php
                    }
                ?>
            </div>
            <div style="width:50%;float:left;">
                <?php 
                    if($payment->mode == 'CASH'){
                ?>
                <p>Dated<input type="text" size="60" style="border-bottom:1px solid #000;width:150px;border-top:0px; border-left:0px; border-right:0px; outline:0;margin-left:20px;" value=""></p>
                <?php
                    }else{
                ?>
                <p>Dated<input type="text" size="60" style="border-bottom:1px solid #000;width:150px;border-top:0px; border-left:0px; border-right:0px; outline:0;margin-left:20px;" value="<?php echo $payment->cheque_date; ?>"></p>
                <?php
                    }
                ?>
            </div>
            <div style="width:100%;float:left;margin-top:-15px;">
                <?php 
                    if($payment->mode == "CASH"){
                ?>
                <p>Bank<input type="text" size="60" style="border-bottom:1px solid #000;width:150px;border-top:0px; border-left:0px; border-right:0px; outline:0;margin-left:20px;" value=""></p>
                <?php
                    }else{
                ?>
                <p>Bank<input type="text" size="60" style="border-bottom:1px solid #000;width:150px;border-top:0px; border-left:0px; border-right:0px; outline:0;margin-left:20px;" value="<?php echo $payment->bank_name; ?>"></p>
                <?php
                    }
                ?>
            </div>
        </div>
        <div style="clear:both;"></div>
    </div>
    <div style="float:left;width:100%;margin-top:-15px">
        <div style="padding:20px;">
            <p>Being in settlement of<input type="text" size="60" style="border-bottom:1px solid #000;width:450px;border-top:0px; border-left:0px; border-right:0px; outline:0;margin-left:20px;text-align:center;" value="<?php echo $payment->description; ?>"></p>
        </div>
    </div>
    <div style="float:left;width:100%;margin-top:25px;">
        <div style="padding-left:20px;padding-right:20px;">
            <div style="width:33.33%;float:left;">
                &emsp;&emsp;.....................................<br />
                <p style="text-align:center;">Prepared By</p>
            </div>
            <div style="width:33.33%;float:left;">
                &emsp;&emsp;.....................................<br />
                <p style="text-align:center;">Approved By</p>
            </div>
            <div style="width:33.33%;float:left;">
                &emsp;&emsp; .....................................<br />
                <p style="text-align:center;">Received By</p>
            </div>
        </div>
    </div>
    <div style="clear:both;"></div>
</div>
<?php        
    }
?>
<?php 
    function amount_wordings($amount)
	{
		$amountdiff = explode('.',$amount);
		if($amountdiff[1]!='000') 
		{
			$bz = " AND BZ ".$amountdiff[1]."/1000"; 
            $amountstring = convert_number($amountdiff[0]).$bz." ONLY";
            return $amountstring;
		}else{
            $amountstring = convert_number($amountdiff[0])." ONLY";
            return $amountstring;
		}
	}
    
    function convert_number($number) 
	{
        if (($number < 0) || ($number > 999999999)) 
		{ 
		throw new Exception("Number is out of range");
		} 

		$Gn = floor($number / 1000000);  /* Millions (giga) */ 
		$number -= $Gn * 1000000; 
		$kn = floor($number / 1000);     /* Thousands (kilo) */ 
		$number -= $kn * 1000; 
		$Hn = floor($number / 100);      /* Hundreds (hecto) */ 
		$number -= $Hn * 100; 
		$Dn = floor($number / 10);       /* Tens (deca) */ 
		$n = $number % 10;               /* Ones */ 

		$res = ""; 

		if ($Gn) 
		{ 
			$res .= convert_number($Gn) . " Million"; 
		} 

		if ($kn) 
		{ 
			$res .= (empty($res) ? "" : " ") . 
				convert_number($kn) . " Thousand"; 
		} 

		if ($Hn) 
		{ 
			$res .= (empty($res) ? "" : " ") . 
				convert_number($Hn) . " Hundred"; 
		} 

		$ones = array("", "One", "Two", "Three", "Four", "Five", "Six", 
			"Seven", "Eight", "Nine", "Ten", "Eleven", "Twelve", "Thirteen", 
			"Fourteen", "Fifteen", "Sixteen", "Seventeen", "Eightteen", 
			"Nineteen"); 
		$tens = array("", "", "Twenty", "Thirty", "Fourty", "Fifty", "Sixty", 
			"Seventy", "Eigthy", "Ninety"); 

		if ($Dn || $n) 
		{ 
			if (!empty($res)) 
			{ 
				$res .= " "; 
			} 

			if ($Dn < 2) 
			{ 
				$res .= $ones[$Dn * 10 + $n]; 
			} 
			else 
			{ 
				$res .= $tens[$Dn]; 

				if ($n) 
				{ 
					$res .= " " . $ones[$n]; 
				} 
			} 
		} 

		if (empty($res)) 
		{ 
			$res = "zero"; 
		} 

		return $res; 
	}
?>
<script>
    // window.print();
</script>