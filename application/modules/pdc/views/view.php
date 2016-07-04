        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/js/bootstrap-datepicker/css/datepicker-custom.css" />
        <!-- page heading start-->
        <div class="page-heading">
            <h3>
                <?php echo $page_title; ?>
            </h3>
            <ul class="breadcrumb">
                <li>
                    <a href="<?php echo base_url(); ?>">Home</a>
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
                        <span class="tools pull-right">
                            <a class="custom-button" href="<?php echo base_url(); ?>index.php/pdc/edit/<?php echo $id; ?>"> Edit PDC</a>
                        </span>
                    </header>
                    <div class="panel-body">
                        <form class="form-horizontal" role="form" method="post" action="add">
                            <div class="form-group">
                                <label class="col-lg-3 col-sm-3 control-label" for="branch">Branch</label>
                                <div class="col-lg-9">
                                    <input class="form-control form-control-inline input-medium default-date-picker"  size="16" type="text" id="branch" value="<?php echo $pdc->branch_name; ?>" name="branch" disabled />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-3 col-sm-3 control-label" for="date_of_issue">Date of Issue</label>
                                <div class="col-lg-9">
                                    <input class="form-control form-control-inline input-medium default-date-picker"  size="16" type="text" id="date_of_issue" placeholder="Select Date of issue" value="<?php echo $pdc->date_issue; ?>" name="date_issue" disabled />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-3 col-sm-3 control-label" for="date_in_cheque">Date in Cheque</label>
                                <div class="col-lg-9">
                                    <input class="form-control form-control-inline input-medium default-date-picker"  size="16" type="text" id="date_in_cheque" placeholder="Select Date in Cheque" value="<?php echo $pdc->date_cheque; ?>" name="date_cheque"disabled />
                                </div>
                            </div>
                            <div class="form-group">
                                <label  class="col-lg-3 col-sm-3 control-label" for="cheque_no">Cheque No</label>
                                <div class="col-lg-9">
                                    <input type="text" class="form-control" placeholder="Cheque No" id="cheque_no" value="<?php echo $pdc->cheque_no; ?>" name="cheque_no" disabled >
                                </div>
                            </div>
                            <div class="form-group">
                                <label  class="col-lg-3 col-sm-3 control-label" for="bank_ref">Bank Ref.</label>
                                <div class="col-lg-9">
                                    <input type="text" class="form-control" placeholder="Bank Ref." id="bank_ref" value="<?php echo $pdc->bank_ref; ?>" name="bank_ref" disabled >
                                </div>
                            </div>
                            <div class="form-group">
                                <label  class="col-lg-3 col-sm-3 control-label" for="party_favouring">Party Favouring</label>
                                <div class="col-lg-9">
                                    <input type="text" class="form-control" placeholder="Party Favouring" id="party_favouring" value="<?php echo $pdc->party_favouring; ?>" name="party_favouring" disabled >
                                </div>
                            </div>
                            <div class="form-group">
                                <label  class="col-lg-3 col-sm-3 control-label" for="reason">Reason</label>
                                <div class="col-lg-9">
                                    <input type="text" class="form-control" placeholder="Reason" id="reason" value="<?php echo $pdc->reason; ?>" name="reason" disabled>
                                </div>
                            </div>
                            <div class="form-group">
                                <label  class="col-lg-3 col-sm-3 control-label" for="cheque_amount">Cheque Amount</label>
                                <div class="col-lg-9">
                                    <input type="text" class="form-control" placeholder="Cheque Amount" id="cheque_amount" value="<?php echo $pdc->amount; ?>" name="amount" disabled>
                                </div>
                            </div>
                            <div class="form-group">
                                <label  class="col-lg-3 col-sm-3 control-label" for="bank_acc_no">Bank Account No</label>
                                <div class="col-lg-9">
                                    <input type="text" class="form-control" placeholder="Bank Account No" id="bank_acc_no" value="<?php echo $pdc->bank_account_no; ?>" name="bank_account_no" disabled>
                                </div>
                            </div>
                            <div class="form-group">
                                <label  class="col-lg-3 col-sm-3 control-label" for="vehicle_no">Vehicle No</label>
                                <div class="col-lg-9">
                                    <input type="text" class="form-control" placeholder="Vehicle No" id="vehicle_no" value="<?php echo $pdc->vehicle_no; ?>" name="vehicle_no" disabled>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-3 col-sm-3 control-label" for="payment_from">Payment From Date</label>
                                <div class="col-lg-9">
                                    <input class="form-control form-control-inline input-medium default-date-picker"  size="16" type="text" id="payment_from" placeholder="Select payment from date" value="<?php echo $pdc->payment_from_date; ?>" name="payment_from_date" disabled />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-3 col-sm-3 control-label" for="payment_to">Payment To Date</label>
                                <div class="col-lg-9">
                                    <input class="form-control form-control-inline input-medium default-date-picker"  size="16" type="text" id="payment_to" placeholder="Select payment to date" value="<?php echo $pdc->payment_to_date; ?>" name="payment_to_date" disabled />
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