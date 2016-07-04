        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/js/bootstrap-datepicker/css/datepicker-custom.css" />
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/choosen/prism.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/choosen/chosen.css">
        <script type="text/javascript">
            $(document).ready(function(){
                $('#vehicle_id.chosen-select').prop('disabled', false).trigger('chosen:updated');
                // $(".chosen-select").prop('disabled', true).trigger('chosen:updated');
                $('#payment_submit').submit(function(){
                    // alert();
                    var from_ac = $("#from_ac option:selected").text();
                    var to_ac = $("#to_ac option:selected").text();
                    
                    if(from_ac == to_ac){
                        alert('From account and to account cannot be same.');
                        return false;
                    }
                    
                    if(from_ac == 'DEPOSIT RETURN' || from_ac == 'RENTAL CHARGES RETURN'){
                        if($('#rental_id').val() == 0){
                            alert('Please select rental id.')
                            return false;
                        }
                    }
                    return true;
                    
                });
                
                $("#rental_id.chosen-select").prop('disabled', true).trigger('chosen:updated');
                $('#from_ac').change(function(){
                    // alert();
                    var from_ac = $("#from_ac option:selected").text();
                    
                    if(from_ac == 'DEPOSIT RETURN' || from_ac == 'RENTAL CHARGES RETURN'){
                        $('#vehicle_id').val(0);
                        $("#rental_id.chosen-select").prop('disabled', false).trigger('chosen:updated');
                        $("#vehicle_id.chosen-select").prop('disabled', true).trigger('chosen:updated');
                        
                    }else{
                        $('#rental_id').val(0);
                        $("#rental_id.chosen-select").prop('disabled', true).trigger('chosen:updated');
                        $("#vehicle_id.chosen-select").prop('disabled', false).trigger('chosen:updated');
                    }
                });
                
            });
            function getPaymentMode(text)
            {
                // alert(text);
                if(text == 'CHEQUE')
                {
                    document.getElementById('cheque_no_div').style.display = 'block';
                    document.getElementById('cheque_date_div').style.display = 'block';
                    document.getElementById('bank_name_div').style.display = 'block';
                }
                else
                {
                    document.getElementById('cheque_no_div').style.display = 'none';
                    document.getElementById('cheque_date_div').style.display = 'none';
                    document.getElementById('bank_name_div').style.display = 'none';
                }
                document.getElementById('mode').value = text;
            }
            function getInvoiceNo(rental_id)
            {
                var payment_ledger = $("#from_ac option:selected").text();
                if(rental_id == 0)
                {
                    alert('Please select rental id first.');
                    return false;
                }
                else
                {
                    $.ajax({
                            type: "post",
                            url: "<?php echo base_url(); ?>index.php/receipt/scanInvoiceNo",
                            cache: false,				
                            data: {rental_id: rental_id},
                            async:false,
                            success: function(json){
                            try{
                                var obj = JSON.parse(json);
                                console.log(obj);
                                var a = obj.invoice_no;
                                var v = obj.vehicle_id;
                                //alert(obj.deposit_amount);
                                //$('#invoice_no').val(a);
                                if(payment_ledger == "DEPOSIT RETURN"){
                                    $('#payment_amount').val(obj.deposit_amount);
                                }
                                else if(payment_ledger == "RENTAL CHARGES RETURN"){
                                    $('#payment_amount').val(obj.rent_amount);
                                }else{
                                    var amt = obj.km_extra_used*obj.extra_km;
                                    $('#payment_amount').val(amt);
                                }
                                $('#invoice_no').attr('value',a);
                                $('#invoice_no1').attr('value',a);
                                $('#vehicle_id12').attr('value',v);
                                
                               // alert($('#invoice_no').val());
                            }catch(e) {
                            //alert(e);
                            alert('Exception while request..');
                            }		
                        },
                        error: function(){						
                            alert('Error while request..');
                        }
                    });
                }
            }
        </script>
        <!-- page heading start-->
        <div class="page-heading">
            <h3>
                <?php echo $page_title; ?>
            </h3>
            <ul class="breadcrumb">
                <li>
                    <a href="#">Home</a>
                </li>
                <li class="active"> <?php echo $page_title; ?> </li>
            </ul>
        </div>
        <!-- page heading end-->

        <!--body wrapper start-->
        <section class="wrapper">
        <?php echo $this->session->flashdata('success');?>
        <?php echo validation_errors();?>
        <?php if(isset($error)) { echo $error; }?>
        <!-- page start-->
            <div class="row">
                <div class="col-lg-6">
                    <section class="panel">
                        <header class="panel-heading">
                            <?php echo $page_title; ?> Form
                        </header>
                        <div class="panel-body">
                            <form class="form-horizontal" role="form" method="post" action="add" id="payment_submit">
                                <div class="form-group">
                                    <label  class="col-lg-3 col-sm-3 control-label" for="payment_no">Payment Voucher No</label>
                                    <div class="col-lg-9">
                                        <input type="text" class="form-control" id="payment_no" name="payment_no" value="<?php echo $payment_voucher_no; ?>" disabled>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label col-lg-3" for="branch">Branch <span style="color:red;">*</span></label>
                                    <div class="col-lg-9">
                                        <select class="form-control" id="branch" name="branch">
                                            <?php
												$default_branch = $default_branch->default_branch_id;
												foreach($branch as $name)
												{?>
												<option value="<?php echo $name['id'];?>" <?php if($default_branch == $name['id']) {?> selected <?php } ?> ><?php echo $name['branch_name']; ?></option>
													<!--//echo "<option value='$name[id]' " . set_select('branch', $name['id']) . " >". $name['branch_name']."</option>";-->
											<?php 
											    }
											?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label col-lg-3" for="payment_voucher_date">Payment Voucher Date <span style="color:red;">*</span></label>
                                    <div class="col-lg-9">
                                        <input class="form-control form-control-inline input-medium default-date-picker"  size="16" type="text" id="payment_voucher_date" placeholder="Select Payment Voucher Date" name="payment_voucher_date" value="<?php if(!isset($receipt_voucher_date)) { echo date('d/m/Y');} else { echo set_value('payment_voucher_date'); } ?>"/>   
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label col-lg-3" for="from_ac">To A/c</label>
                                    <div class="col-lg-9">
                                        <select class="form-control" id="from_ac" name="from_ac">
                                            <?php 
                                                foreach($payment_ledger as $type)
												{
                                            ?>
												<option value="<?php echo $type['id'];?>"><?php echo $type['title']; ?></option>
											<?php 
											    }
											?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label col-lg-3" for="to_ac">From A/c</label>
                                    <div class="col-lg-9">
                                        <select class="form-control" id="to_ac" name="to_ac">
                                            <?php 
                                                foreach($payment_ledger as $type)
												{
                                            ?>
												<option value="<?php echo $type['id'];?>"><?php echo $type['title']; ?></option>
											<?php 
											    }
											?>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="col-sm-2 control-label col-lg-3" for="vehicle_id"> Vehicle</label>
                                    <div class="col-lg-9">
                                        <select class="form-control chosen-select" id="vehicle_id" name="vehicle_id1">
                                            <option value="0">--Select--</option>
                                            <?php
                                                foreach($vehicle as $name)
                                                {
                                                    echo "<option value='$name[vehicle_reg_no]' " . set_select('vehicle_reg_no', $name['vehicle_reg_no']) . " >".$name['id'].".  ".$name['vehicle_reg_no']."  ".$name['brand']."</option>";
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label col-lg-3" for="rental_id">Rental Id <span style="color:red;">*</span></label>
                                    <div class="col-lg-9">
                                        <select class="form-control chosen-select" id="rental_id" name="rental_id" onchange="getInvoiceNo(this.value);">
                                            <option value="0">--Select--</option>
                                            <?php
                                                foreach($rental_id as $ids)
                                                {
                                                    echo "<option value='$ids[rental_id]' " . set_select('rental_id', $ids['rental_id']) . " >".$ids['rental_id'].".  ".$ids['en_name']."  ".$ids['vehicle_reg_no']."</option>";
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label  class="col-lg-3 col-sm-3 control-label" for="invoice_no">Invoice No</label>
                                    <div class="col-lg-9">
                                        <input type="text" class="form-control" placeholder="Invoice No" id="invoice_no" name="invoice_no" value="<?php echo set_value('invoice_no'); ?>" readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label  class="col-lg-3 col-sm-3 control-label" for="payment_amount">Payment Amount <span style="color:red;">*</span></label>
                                    <div class="col-lg-9">
                                        <input type="text" class="form-control" placeholder="Payment Amount" id="payment_amount" name="payment_amount" value="<?php echo set_value('payment_amount'); ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label  class="col-lg-3 col-sm-3 control-label" for="description">Description</label>
                                    <div class="col-lg-9">
                                        <input type="text" class="form-control" placeholder="Description" id="description" name="description" value="<?php echo set_value('description'); ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label col-lg-3" for="payment_mode">Mode Of Payment <span style="color:red;">*</span></label>
                                    <div class="col-lg-9">
                                        <select class="form-control" id="payment_mode" name="payment_mode" onchange="getPaymentMode(this.options[this.selectedIndex].text)">
                                            <option value="CASH">CASH</option>
                                            <option value="CHEQUE">CHEQUE</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group" style="display:none;" id="cheque_no_div">
                                    <label  class="col-lg-3 col-sm-3 control-label" for="cheque_no">Cheque Number</label>
                                    <div class="col-lg-9">
                                        <input type="text" class="form-control" placeholder="Cheque Number" id="cheque_no" name="cheque_no" value="<?php echo set_value('cheque_no'); ?>">
                                    </div>
                                </div>
                                <div class="form-group" style="display:none;" id="cheque_date_div">
                                    <label  class="col-lg-3 col-sm-3 control-label" for="cheque_date">Cheque Date</label>
                                    <div class="col-lg-9">
                                        <input type="text" class="form-control form-control-inline input-medium default-date-picker" placeholder="Cheque Date" id="cheque_date" name="cheque_date" value="<?php echo set_value('cheque_date'); ?>">
                                    </div>
                                </div>
                                <div class="form-group" style="display:none;" id="bank_name_div">
                                    <label  class="col-lg-3 col-sm-3 control-label" for="bank_name">Bank Name</label>
                                    <div class="col-lg-9">
                                        <input type="text" class="form-control" placeholder="Bank Name" id="bank_name" name="bank_name" value="<?php echo set_value('bank_name'); ?>">
                                    </div>
                                </div>
                                <input type="hidden" id="vehicle_id12" name="vehicle_id">
                                <div class="panel-body">
                                    <p>
                                        <button class="btn btn-primary" type="submit">Submit</button>
                                        <a href="<?php echo base_url(); ?>index.php/payment" class="btn btn-default" type="button">Cancel</a>
                                    </p>
                                </div>
                            </form>
                        </div>
                    </section>
                </div>
            </div>
        <!-- page end-->
        </section>
        <!--body wrapper end-->
        <!--pickers plugins-->
        <!--<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>-->
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js"></script>
        <!--<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootstrap-daterangepicker/moment.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootstrap-daterangepicker/daterangepicker.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootstrap-timepicker/js/bootstrap-timepicker.js"></script>-->
        
        <!--pickers initialization-->
        <script src="<?php echo base_url(); ?>assets/js/pickers-init.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/choosen/chosen.jquery.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/js/choosen/prism.js" type="text/javascript" charset="utf-8"></script>
        <script type="text/javascript">
            var config = {
              '.chosen-select'           : {},
              '.chosen-select-deselect'  : {allow_single_deselect:true},
              '.chosen-select-no-single' : {disable_search_threshold:10},
              '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
              '.chosen-select-width'     : {width:"95%"}
            }
            for (var selector in config) {
              $(selector).chosen(config[selector]);
            }
        </script>