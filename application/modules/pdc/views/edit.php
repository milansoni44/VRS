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
                        <?php echo $page_title; ?> Form
                    </header>
                    <div class="panel-body">
                        <form class="form-horizontal" role="form" method="post" action="../edit/<?php echo $id; ?>">
                            <div class="form-group">
                                <label class="col-lg-3 col-sm-3 control-label" for="branch">Branch <span style="color:red;">*</span></label>
                                <div class="col-lg-9">
                                    <select class="form-control" id="branch" name="branch">
                                        <option value="0">--Select--</option>
                                        <?php
                                            foreach($branch as $name)
                                            {
                                        ?>
                                                <option <?php if($pdc->branch_id == $name['id']) { ?>selected <?php } ?> value=<?php echo $name['id']; ?>><?php echo $name['branch_name']; ?></option>
                                        <?php
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-3 col-sm-3 control-label" for="date_of_issue">Date of Issue <span style="color:red;">*</span></label>
                                <div class="col-lg-9">
                                    <input class="form-control form-control-inline input-medium default-date-picker"  size="16" type="text" id="date_of_issue" placeholder="Select Date of issue" value="<?php echo $pdc->date_issue; ?>" name="date_issue"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-3 col-sm-3 control-label" for="date_in_cheque">Date in Cheque <span style="color:red;">*</span></label>
                                <div class="col-lg-9">
                                    <input class="form-control form-control-inline input-medium default-date-picker"  size="16" type="text" id="date_in_cheque" placeholder="Select Date in Cheque" value="<?php echo $pdc->date_cheque; ?>" name="date_cheque"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label  class="col-lg-3 col-sm-3 control-label" for="cheque_no">Cheque No <span style="color:red;">*</span></label>
                                <div class="col-lg-9">
                                    <input type="text" class="form-control" placeholder="Cheque No" id="cheque_no" value="<?php echo $pdc->cheque_no; ?>" name="cheque_no">
                                </div>
                            </div>
                            <div class="form-group">
                                <label  class="col-lg-3 col-sm-3 control-label" for="bank_ref">Bank Ref.</label>
                                <div class="col-lg-9">
                                    <input type="text" class="form-control" placeholder="Bank Ref." id="bank_ref" value="<?php echo $pdc->bank_ref; ?>" name="bank_ref">
                                </div>
                            </div>
                            <div class="form-group">
                                <label  class="col-lg-3 col-sm-3 control-label" for="party_favouring">Party Favouring</label>
                                <div class="col-lg-9">
                                    <input type="text" class="form-control" placeholder="Party Favouring" id="party_favouring" value="<?php echo $pdc->party_favouring; ?>" name="party_favouring">
                                </div>
                            </div>
                            <div class="form-group">
                                <label  class="col-lg-3 col-sm-3 control-label" for="reason">Reason</label>
                                <div class="col-lg-9">
                                    <input type="text" class="form-control" placeholder="Reason" id="reason" value="<?php echo $pdc->reason; ?>" name="reason">
                                </div>
                            </div>
                            <div class="form-group">
                                <label  class="col-lg-3 col-sm-3 control-label" for="cheque_amount">Cheque Amount <span style="color:red;">*</span></label>
                                <div class="col-lg-9">
                                    <input type="text" class="form-control" placeholder="Cheque Amount" id="cheque_amount" value="<?php echo $pdc->amount; ?>" name="amount">
                                </div>
                            </div>
                            <div class="form-group">
                                <label  class="col-lg-3 col-sm-3 control-label" for="bank_acc_no">Bank Account No <span style="color:red;">*</span></label>
                                <div class="col-lg-9">
                                    <input type="text" class="form-control" placeholder="Bank Account No" id="bank_acc_no" value="<?php echo $pdc->bank_account_no; ?>" name="bank_account_no">
                                </div>
                            </div>
                            <div class="form-group">
                                <label  class="col-lg-3 col-sm-3 control-label" for="vehicle_no">Vehicle No <span style="color:red;">*</span></label>
                                <div class="col-lg-9">
                                    <input type="text" class="form-control" placeholder="Vehicle No" id="vehicle_no" value="<?php echo $pdc->vehicle_no; ?>" name="vehicle_no">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-3 col-sm-3 control-label" for="payment_from">Payment From Date</label>
                                <div class="col-lg-9">
                                    <input class="form-control form-control-inline input-medium default-date-picker"  size="16" type="text" id="payment_from" placeholder="Select payment from date" value="<?php echo $pdc->payment_from_date; ?>" name="payment_from_date"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-3 col-sm-3 control-label" for="payment_to">Payment To Date</label>
                                <div class="col-lg-9">
                                    <input class="form-control form-control-inline input-medium default-date-picker"  size="16" type="text" id="payment_to" placeholder="Select payment to date" value="<?php echo $pdc->payment_to_date; ?>" name="payment_to_date"/>
                                </div>
                            </div>
                            <div class="panel-body">
                                <p>
                                    <button class="btn btn-primary" type="submit">Submit</button>
                                    <a href="<?php echo base_url(); ?>index.php/pdc" class="btn btn-default" type="button">Cancel</a>
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
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootstrap-daterangepicker/moment.min.js"></script>
        <!--<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootstrap-daterangepicker/daterangepicker.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootstrap-timepicker/js/bootstrap-timepicker.js"></script>-->
        
        <!--pickers initialization-->
        <script src="<?php echo base_url(); ?>assets/js/pickers-init.js"></script>