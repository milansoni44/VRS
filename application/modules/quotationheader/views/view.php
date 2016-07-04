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
            <div class="col-lg-12">
                <section class="panel">
                    <header class="panel-heading">
                        <?php echo $page_title; ?> Form
                    </header>
                    <form class="form-horizontal" role="form" method="post" action="../edit/<?php echo $id; ?>">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="panel-body">
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label col-lg-2" for="branch">Branch</label>
                                        <div class="col-lg-4">
                                            <!--<select class="form-control" id="branch" name="branch">
                                                <option value="0">--Select Branch--</option>
                                                <?php 
                                                    foreach($branch as $name)
                                                    {
                                                ?>  
                                                <option <?php if($quotation_header->branch_id == $name['id']) {?> Selected <?php } ?> value="<?php echo $name['id'] ?>"><?php echo $name['branch_name'] ?></option>
                                                <?php 
                                                    }
                                                ?>
                                            </select>-->
                                            <input type="text" class="form-control" id="branch" name="branch" value="<?php echo $quotation_header->branch_name; ?>" disabled>
                                        </div>
                                        <label class="col-sm-2 control-label col-lg-2" for="quotation_date">Quotation Date</label>
                                        <div class="col-lg-4">
                                            <input class="form-control form-control-inline input-medium default-date-picker"  size="16" type="text" id="quotation_date" placeholder="Select Quotation Date" name="quotation_date" value="<?php echo $quotation_header->quotation_date; ?>" disabled />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label col-lg-2" for="customer_id">Customer</label>
                                        <div class="col-lg-4">
                                            <input type="text" class="form-control" id="customer" name="customer" value="<?php echo $quotation_header->en_name; ?>" disabled>
                                        </div>
                                        <label  class="col-lg-2 col-sm-2 control-label" for="validity">Validity Upto</label>
                                        <div class="col-lg-4">
                                            <input type="text" class="form-control" placeholder="Validity in Days" id="validity" name="validity" value="<?php echo $quotation_header->validity_upto; ?>" disabled>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <table class="table" id="myTable">
                                            <tr>
                                                <td><label>Brand / Model</label></td>
                                                <td><label>Model</label></td>
                                                <td><label>Engine</label></td>
                                                <td><label>Daily Rate</label></td>
                                                <td><label>Weekly Rate</label></td>
                                                <td><label>Monthly Rate</label></td>
                                                <td><label>Insurance</label></td>
                                                <td><label>Breakdown Recovery</label></td>
                                                <td><label>General Remarks</label></td>
                                            </tr>
                                            <?php 
                                                // echo '<pre>';
                                                // print_r($quotation_details);
                                                // echo '</pre>';
                                                $k=0;
                                                for($j=1;$j<=sizeof($quotation_details);$j++){
                                            ?>
                                            <tr id="<?php echo $j; ?>">
                                                <td>
                                                    <select class="form-control" id="brand-<?php echo $j; ?>" name="brand<?php echo $j; ?>" onchange="getVehicle(this);">
                                                        <option value="0">-- Select --</option>
                                                        <?php 
                                                            for($i = 0;$i < sizeof($brand); $i++){
                                                        ?>
                                                        <option <?php if($quotation_details[$k]['vehicle_id'] == $vehicle_id[$i]) { ?>selected <?php } ?> value="<?php echo $vehicle_id[$i];?>"><?php echo $vehicle_reg_no[$i]." ".$brand[$i]; ?></option>
                                                        <?php
                                                            }
                                                        ?>
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" placeholder="Model Year" id="model-<?php echo $j; ?>" name="model<?php echo $j; ?>" value="<?php echo $quotation_details[$k]['model_year']; ?>" disabled>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" placeholder="Engine" id="engine-<?php echo $j; ?>" name="engine<?php echo $j; ?>" value="<?php echo $quotation_details[$k]['engine_capacity']; ?>" disabled>
                                                </td>    
                                                <td>
                                                    <input type="text" class="form-control" placeholder="Daily Rate" id="daily_rate-<?php echo $j; ?>" name="daily_rate<?php echo $j; ?>" value="<?php echo $quotation_details[$k]['daily_rate']; ?>" disabled>
                                                </td>    
                                                <td>
                                                    <input type="text" class="form-control" placeholder="Weekly Rate" id="weekly_rate-<?php echo $j; ?>" name="weekly_rate<?php echo $j; ?>" value="<?php echo $quotation_details[$k]['weekly_rate']; ?>" disabled>
                                                </td>    
                                                <td>
                                                    <input type="text" class="form-control" placeholder="Monthly Rate" id="monthly_rate-<?php echo $j; ?>" name="monthly_rate<?php echo $j; ?>" value="<?php echo $quotation_details[$k]['monthly_rate']; ?>" disabled>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" placeholder="General Remarks" id="insurance-<?php echo $j; ?>" name="insurance<?php echo $j; ?>" value="<?php echo $quotation_details[$k]['insurance_type']; ?>" disabled>
                                                </td>
                                                <td>
                                                    <select class="form-control" id="breakdown-<?php echo $j; ?>" name="breakdown<?php echo $j; ?>">
                                                        <option value="0">-- Select --</option>
                                                        <option <?php if($quotation_details[$k]['breakdown_recovery'] == 'yes') { ?>selected <?php } ?> value="yes">Yes</option>
                                                        <option <?php if($quotation_details[$k]['breakdown_recovery'] == 'no') { ?>selected <?php } ?> value="no">No</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" placeholder="General Remarks" id="general_remarks-<?php echo $j; ?>" name="general_remarks<?php echo $j; ?>" value="<?php echo $quotation_details[$k]['remarks']; ?>" disabled>
                                                </td>   
                                            </tr>
                                            <?php
                                                $k++;
                                                }
                                            ?>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    
                </section>
            </div>
        </div>
        <!--pickers plugins-->
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootstrap-daterangepicker/moment.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootstrap-daterangepicker/daterangepicker.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootstrap-timepicker/js/bootstrap-timepicker.js"></script>
        
        <script src="<?php echo base_url(); ?>assets/js/pickers-init.js"></script>