        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/js/bootstrap-datepicker/css/datepicker-custom.css" />
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/choosen/prism.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/choosen/chosen.css">
        <script type="text/javascript">
            // $(document).ready(function(){
                // $('#invoice_no').prop('disabled',true); 
            // });
            function getInvoiceNo(rental_id)
            {
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
                                //$('#invoice_no').val(a);
                                $('#invoice_no').attr('value',a);
                                $('#invoice_no1').attr('value',a);
                               // alert($('#invoice_no').val());
                            }catch(e) {		
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
                            <form class="form-horizontal" role="form" method="post" action="../edit/<?php echo $id; ?>">
                                <div class="form-group">
                                    <label  class="col-lg-3 col-sm-3 control-label" for="receipt_no">Receipt Voucher No</label>
                                    <div class="col-lg-9">
                                        <input type="text" class="form-control" id="receipt_no" name="receipt_no" value="<?php echo $id; ?>" disabled>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-3 col-sm-3 control-label" for="branch">Branch <span style="color:red;">*</span></label>
                                    <div class="col-lg-9">
                                        <select class="form-control" id="branch" name="branch">
                                            <option value="0">--Select--</option>
                                            <?php
                                                foreach($branch as $name)
                                                {
                                            ?>
                                                    <option <?php if($receipt->branch_id == $name['id']) { ?>selected <?php } ?> value=<?php echo $name['id']; ?>><?php echo $name['branch_name']; ?></option>
                                            <?php
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label col-lg-3" for="receipt_voucher_date">Receipt Voucher Date <span style="color:red;">*</span></label>
                                    <div class="col-lg-9">
                                        <input class="form-control form-control-inline input-medium default-date-picker"  size="16" type="text" id="receipt_voucher_date" placeholder="Select Receipt Voucher Date" name="receipt_voucher_date" value="<?php echo $receipt->receipt_voucher_date; ?>"/>   
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label col-lg-3" for="receipt_ledger">Receipt Ledger</label>
                                    <div class="col-lg-9">
                                        <select class="form-control" id="receipt_ledger" name="receipt_ledger">
                                            <?php
                                            foreach($receipt_ledger as $type)
                                            {
                                            ?>
                                                <option <?php if($receipt->reciept_ledger == $type['id']) { ?>selected <?php } ?> value=<?php echo $type['id']; ?>><?php echo $type['title']; ?></option>
                                            <?php
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
                                            ?>
                                                    <option <?php if($receipt->rental_id == $ids['rental_id']) { ?>selected <?php } ?> value=<?php echo $ids['rental_id']; ?>><?php echo $ids['rental_id'].".  ".$ids['en_name']." ".$ids['vehicle_reg_no']; ?></option>
                                            <?php 
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label  class="col-lg-3 col-sm-3 control-label" for="invoice_no">Invoice No</label>
                                    <div class="col-lg-9">
                                        <input type="text" class="form-control" placeholder="Invoice No" id="invoice_no" name="invoice_no" value="<?php echo $receipt->invoice_no; ?>" readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label  class="col-lg-3 col-sm-3 control-label" for="receipt_amount">Receipt Amount</label>
                                    <div class="col-lg-9">
                                        <input type="text" class="form-control" placeholder="Receipt Amount" id="receipt_amount" name="receipt_amount" value="<?php echo $receipt->receipt_amount; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label  class="col-lg-3 col-sm-3 control-label" for="description">Description</label>
                                    <div class="col-lg-9">
                                        <input type="text" class="form-control" placeholder="Description" id="description" name="description" value="<?php echo $receipt->description; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label col-lg-3" for="receipt_mode">Mode Of Receipt <span style="color:red;">*</span></label>
                                    <div class="col-lg-9">
                                        <select class="form-control" id="receipt_mode" name="receipt_mode">
                                            <?php
                                            foreach($receipt_ledger as $type)
                                            {
                                            ?>
                                                <option <?php if($receipt->reciept_ledger == $type['id']) { ?>selected <?php } ?> value=<?php echo $type['id']; ?>><?php echo $type['title']; ?></option>
                                            <?php
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>
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
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootstrap-daterangepicker/moment.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootstrap-daterangepicker/daterangepicker.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootstrap-timepicker/js/bootstrap-timepicker.js"></script>
        
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