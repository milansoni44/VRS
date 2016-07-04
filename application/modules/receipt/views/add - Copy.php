        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/js/bootstrap-datepicker/css/datepicker-custom.css" />
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/choosen/prism.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/choosen/chosen.css">
        <script type="text/javascript">
            $( document ).ready(function() {
                
                $("#receipt_ledger").change(function(){
                    $("#description").val( 'Towards '+$("#receipt_ledger option:selected").text());
                    var receipt_ledger = $("#receipt_ledger option:selected").text();
                    var rental_id = $("#rental_id").val();
                    
                    //for rent amount
                    // if(($('#rental_id').val() == 0))
                    // {
                        // alert("Please select rental id.");
                    // }
                    // else{
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
                                    var b = obj.vehicle_type;
                                    
                                    if(receipt_ledger == "DEPOSIT"){
                                        $('#receipt_amount').val(obj.deposit_amount);
                                    }
                                    else if(receipt_ledger == "RENTAL CHARGES"){
                                        $('#receipt_amount').val(obj.rent_amount);
                                    }
                                    else{
                                        $('#receipt_amount').val(obj.rent_amount);
                                    }
                                    $('#invoice_no').attr('value',a);
                                }catch(e) {		
                                alert('Exception while request..');
                                }		
                            },
                            error: function(){						
                                alert('Error while request..');
                            }
                        });
                    // }
                });
            });
            function getReceiptMode(text)
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
            function getLedgerType(branch_id)
            {
                // alert(branch_id);
                $.ajax({
                        type: "post",
                        url: "<?php echo base_url(); ?>index.php/receipt/scanLedgerType",
                        cache: false,				
                        data: {branch_id: branch_id},
                        async:false,
                        success: function(json){
                        try{
                            var obj = JSON.parse(json);
                            console.log(obj);
                            var count = 0;
                            var selectValueStart = '<select class="form-control" id="receipt_ledger" name="receipt_ledger">';
                             var selectValueEnd = '</select>';
                             var optionValue = "";  
                            for (var x in obj){
                                if(obj.hasOwnProperty(x)){
                                  count++;
                                }
                            }
                            // alert(obj[0].id);
                            for(var i = 0; i < count; i++)
                            {
                                optionValue += '<option value="'+obj[i].id+'">'+obj[i].title+'</option>';  
                                alert(obj[i].id);
                            }
                            var select = selectValueStart +optionValue +selectValueEnd;
                            $('.receipt_ledger1 select').replaceWith(select);
                            alert(select);
                        }catch(e) {		
                        alert('Exception while request..');
                        }		
                    },
                    error: function(){						
                        alert('Error while request..');
                    }
                });
            }
            function getInvoiceNo(rental_id)
            {
                var receipt_ledger = $("#receipt_ledger option:selected").text();
                // if(rental_id == 0)
                // {
                    // alert('Please select rental id first.');
                    // return false;
                // }
                // else
                // {
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
                                var b = obj.vehicle_type;
                                
                                if(receipt_ledger == "DEPOSIT"){
                                    $('#receipt_amount').val(obj.deposit_amount);
                                }
                                else{
                                    $('#receipt_amount').val(obj.rent_amount);
                                }
                                $('#invoice_no').attr('value',a);
                            }catch(e) {		
                            alert('Exception while request..');
                            }		
                        },
                        error: function(){						
                            alert('Error while request..');
                        }
                    });
                // }
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
                <div class="col-lg-7">
                    <section class="panel">
                        <header class="panel-heading">
                            <?php echo $page_title; ?> Form
                        </header>
                        <div class="panel-body">
                            <form class="form-horizontal" role="form" method="post" action="add">
                                <div class="form-group">
                                    <label  class="col-lg-3 col-sm-3 control-label" for="receipt_no">Receipt Voucher No</label>
                                    <div class="col-lg-9">
                                        <input type="text" class="form-control" id="receipt_no" name="receipt_no" value="<?php echo $receipt_voucher_no; ?>" disabled>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label col-lg-3" for="branch">Branch <span style="color:red;">*</span></label>
                                    <div class="col-lg-9">
                                        <select class="form-control" id="branch" name="branch" onchange="getLedgerType(this.value);">
                                            <?php
												$default_branch = $default_branch->default_branch_id;
                                                
												foreach($branch as $name)
												{?>
												<option value="<?php echo $name['id'];?>" <?php if($default_branch == $name['id']) {?> selected <?php } ?> ><?php echo $name['branch_name']; ?></option>
											<?php 
											    }
											?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label col-lg-3" for="receipt_voucher_date">Receipt Voucher Date <span style="color:red;">*</span></label>
                                    <div class="col-lg-9">
                                        <input class="form-control form-control-inline input-medium default-date-picker"  size="16" type="text" id="receipt_voucher_date" placeholder="Select Receipt Voucher Date" name="receipt_voucher_date" value="<?php if(!isset($receipt_voucher_date)) { echo date('d/m/Y');} else { echo set_value('receipt_voucher_date'); } ?>"/> 
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label col-lg-3" for="from_ac">From A/C </label>
                                    <div class="col-lg-9 receipt_ledger1">
                                        <select class="form-control" id="from_ac" name="from_ac">
                                            <?php 
                                                foreach($default_branch_ledger as $ledger){
                                            ?>
                                            <option value="<?php echo $ledger['id']; ?>"><?php echo $ledger['title']; ?></option>
                                            <?php    
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label col-lg-3" for="to_ac">To A/C </label>
                                    <div class="col-lg-9 receipt_ledger1">
                                        <select class="form-control" id="to_ac" name="to_ac">
                                            <?php 
                                                foreach($default_branch_ledger as $ledger){
                                            ?>
                                            <option value="<?php echo $ledger['id']; ?>"><?php echo $ledger['title']; ?></option>
                                            <?php    
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label col-lg-3" for="rental_id">Rental Id</label>
                                    <div class="col-lg-9">
                                        <!--<select class="form-control" id="rental_id" name="rental_id" onchange="getInvoiceNo(this.value);">
                                            <option value="0">--Select--</option>
                                            <?php
                                                foreach($rental_id as $ids)
                                                {
                                                    echo "<option value='$ids[rental_id]' " . set_select('rental_id', $ids['rental_id']) . " >". $ids['rental_id']."</option>";
                                                }
                                            ?>
                                        </select>-->
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
                                    <label  class="col-lg-3 col-sm-3 control-label" for="receipt_amount">Receipt Amount</label>
                                    <div class="col-lg-9">
                                        <input type="text" class="form-control" placeholder="Receipt Amount" id="receipt_amount" name="receipt_amount" value="<?php echo set_value('receipt_amount'); ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label  class="col-lg-3 col-sm-3 control-label" for="description">Description</label>
                                    <div class="col-lg-9">
                                        <input type="text" class="form-control" placeholder="Description" id="description" name="description" value="<?php echo set_value('description'); ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label col-lg-3" for="receipt_mode">Mode Of Receipt <span style="color:red;">*</span></label>
                                    <div class="col-lg-9">
                                        <select class="form-control" id="receipt_mode" name="receipt_mode" onchange="getReceiptMode(this.options[this.selectedIndex].text)">
                                            <option value="CASH">CASH</option>
                                            <option value="CHEQUE">CHEQUE</option>
                                            <option value="CREDIT CARD">CREDIT CARD</option>
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
                                <input type="hidden" name="mode" id="mode"/>
                                <div class="panel-body">
                                    <p>
                                        <button class="btn btn-primary" type="submit">Submit</button>
                                        <a href="<?php echo base_url(); ?>index.php/receipt" class="btn btn-default" type="button">Cancel</a>
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