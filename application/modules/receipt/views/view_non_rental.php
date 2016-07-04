        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/js/bootstrap-datepicker/css/datepicker-custom.css" />
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
                        <?php echo $page_title; ?>
                        <!--<span class="tools pull-right">
                            <a class="custom-button" href="<?php echo base_url(); ?>index.php/receipt/edit/<?php echo $id; ?>"> Edit Receipt</a>
                        </span>-->
                    </header>
                    <div class="panel-body">
                        <form class="form-horizontal" role="form" method="post" action="add">
                            <div class="form-group">
                                <label  class="col-lg-3 col-sm-3 control-label" for="receipt_no">Receipt Voucher No</label>
                                <div class="col-lg-9">
                                    <input type="text" class="form-control" id="receipt_no" name="receipt_no" value="<?php echo $id; ?>" disabled>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-3 col-sm-3 control-label" for="branch">Branch</label>
                                <div class="col-lg-9">
                                    <input class="form-control form-control-inline input-medium default-date-picker"  size="16" type="text" id="branch" value="<?php echo $receipt->branch_name; ?>" name="branch" disabled />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-3 col-sm-3 control-label">Receipt Voucher Date</label>
                                <div class="col-lg-9">
                                    <input class="form-control form-control-inline input-medium default-date-picker"  size="16" type="text" id="date_of_issue" value="<?php echo $receipt->receipt_voucher_date; ?>" disabled />
                                </div>
                            </div>
                            <div class="form-group">
                                <label  class="col-lg-3 col-sm-3 control-label" >Receipt Ledger</label>
                                <div class="col-lg-9">
                                    <input type="text" class="form-control" id="cheque_no" value="<?php echo $receipt->reciept_ledger; ?>" disabled >
                                </div>
                            </div>
                            <div class="form-group">
                                <label  class="col-lg-3 col-sm-3 control-label">Invoice No</label>
                                <div class="col-lg-9">
                                    <input type="text" class="form-control" value="<?php echo $receipt->invoice_no; ?>" disabled >
                                </div>
                            </div>
                            <div class="form-group">
                                <label  class="col-lg-3 col-sm-3 control-label">Rental ID</label>
                                <div class="col-lg-9">
                                    <input type="text" class="form-control" placeholder="Party Favouring" id="party_favouring" value="<?php echo $receipt->rental_id; ?>" disabled >
                                </div>
                            </div>
                            <div class="form-group">
                                <label  class="col-lg-3 col-sm-3 control-label">Receipt Amount</label>
                                <div class="col-lg-9">
                                    <input type="text" class="form-control" value="<?php echo $receipt->receipt_amount; ?>" name="reason" disabled>
                                </div>
                            </div>
                            <div class="form-group">
                                <label  class="col-lg-3 col-sm-3 control-label">Description</label>
                                <div class="col-lg-9">
                                    <input type="text" class="form-control" value="<?php echo $receipt->description; ?>" name="amount" disabled>
                                </div>
                            </div>
                            <div class="form-group">
                                <label  class="col-lg-3 col-sm-3 control-label">Mode of Receipt</label>
                                <div class="col-lg-9">
                                    <input type="text" class="form-control" value="<?php echo $receipt->mode_of_receipt; ?>" disabled>
                                </div>
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