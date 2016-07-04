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
                        <?php echo $page_title; ?>
                        <span class="tools pull-right">
                            <a class="custom-button" href="<?php echo base_url(); ?>index.php/vehicle/edit/<?php echo $id; ?>"> Edit Vehicle</a>
                        </span>
                    </header>
                    <form class="form-horizontal" role="form" method="post" action="../edit/<?php echo $id; ?>" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="panel-body">
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label col-lg-4" for="branch">Branch</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" id="branch" name="branch" value="<?php echo $vehicle->branch_name; ?>" disabled >
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label  class="col-lg-4 col-sm-3 control-label" for="txt_vehicle_reg_no">Vehicle Reg. No</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" placeholder="Vehicle Reg. No." id="txt_vehicle_reg_no" name="vehicle_reg_no" value="<?php echo $vehicle->vehicle_reg_no; ?>" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label col-lg-4" for="owner">Owner</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" id="owner" name="owner" value="<?php echo $vehicle->name; ?>" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label  class="col-lg-4 col-sm-3 control-label" for="txt_finance_company">Finance Company</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" placeholder="Finance Company" id="txt_finance_company" name="finance_company" value="<?php echo $vehicle->finance_company; ?>" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label col-lg-4" for="brand">Brand / Model</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" id="brand" name="brand" value="<?php echo $vehicle->brand; ?>" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label col-lg-4" for="trans_type">Transmission Type</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" id="trans_type" name="trans_type" value="<?php echo $vehicle->trans_type; ?>" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group" id="hideModel" <?php if($vehicle->brand != 0) {?> style="display:block;" <?php } else { ?> style="display:none;" <?php } ?> >
                                        <label  class="col-lg-4 col-sm-3 control-label" for="txt_model">Model</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" placeholder="model" id="txt_model" name="model" value="<?php echo $vehicle->model; ?>" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label col-lg-4" for="vehicle_type">Vehicle Type</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" placeholder="Vehicle Type" id="vehicle_type" name="vehicle_type" value="<?php echo $vehicle->vehicle_type; ?>" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label  class="col-lg-4 col-sm-3 control-label" for="txt_model_year">Model Year</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" placeholder="Model Year" id="txt_model_year" name="model_year" value="<?php echo $vehicle->model_year; ?>" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-4" for="exp_date">Reg. Expiry Date</label>
                                        <div class="col-md-8 col-xs-11">
                                            <input class="form-control form-control-inline input-medium default-date-picker"  size="16" type="text" id="exp_date" placeholder="Select Reg. Expiry Date" name="reg_exp_date" value="<?php echo $vehicle->reg_expiry_date; ?>" disabled />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label col-lg-4" for="insurance_type">Insurance Type</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" placeholder="Insurance Type" id="insurance_type" name="insurance_type" value="<?php echo $vehicle->insurance_type; ?>" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label col-lg-4" for="breakdown_recovery">Breakdown Recovery</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" placeholder="Breakdown Recovery" id="breakdown_recovery" name="breakdown_recovery" value="<?php echo $vehicle->breakdown_recovery; ?>" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label  class="col-lg-4 col-sm-3 control-label" for="txt_insurance_company" value="New India Assurance">Insurance Company</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" placeholder="Insurance Company" id="txt_insurance_company" name="insurance_company" value="<?php echo $vehicle->insurance_company; ?>" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-4" for="insurance_exp_date">Insurance Expiry Date</label>
                                        <div class="col-md-8 col-xs-11">
                                            <input class="form-control form-control-inline input-medium default-date-picker"  size="16" type="text" id="insurance_exp_date" placeholder="Select Insurance Expiry Date" name="insurance_exp_date" value="<?php echo $vehicle->insurance_expiry_date; ?>" disabled />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="panel-body">
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label col-lg-4" for="availibility_status">Vehicle Availability Status</label>
                                        <div class="col-lg-8">
                                            <input class="form-control form-control-inline input-medium default-date-picker"  size="16" type="text" id="availibility_status" name="vehicle_avail_status" value="<?php echo $vehicle->vehicle_availibility; ?>" disabled />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label col-lg-4" for="image">Image</label>
                                        <div class="edit-vehicle-image">
                                            <span style="float:left;"><?php if($vehicle->image != ""){ ?><img src="<?php echo base_url()."assets/uploads/vehicles/".$vehicle->image; ?>" alt="" width="50px"/><?php } else { echo "No Image Available"; } ?></span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label  class="col-lg-4 col-sm-3 control-label" for="txt_seating_capacity">Seating Capacity</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" placeholder="Seating Capacity" id="txt_seating_capacity" name="seating_capacity" value="<?php echo $vehicle->seating_capacity; ?>" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label  class="col-lg-4 col-sm-3 control-label" for="txt_engine_capacity">Engine Capacity</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" placeholder="Engine Capacity" id="txt_engine_capacity" name="engine_capacity" value="<?php echo $vehicle->engine_capacity; ?>" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label  class="col-lg-4 col-sm-3 control-label" for="txt_daily_rate">Daily Rate</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" placeholder="Daily Rate" id="txt_daily_rate" name="daily_rate" value="<?php echo $vehicle->daily_rate; ?>" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label  class="col-lg-4 col-sm-3 control-label" for="txt_weekly_rate">Weekly Rate</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" placeholder="Weekly Rate" id="txt_weekly_rate" name="weekly_rate" value="<?php echo $vehicle->weekly_rate; ?>" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label  class="col-lg-4 col-sm-3 control-label" for="txt_month_rate">Month Rate</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" placeholder="Month Rate" id="txt_month_rate" name="month_rate" value="<?php echo $vehicle->month_rate; ?>" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label  class="col-lg-4 col-sm-3 control-label" for="txt_extra_km">Extra KM Rate</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" placeholder="Extra KM" id="txt_extra_km" name="extra_km" value="<?php echo $vehicle->extra_km; ?>" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label  class="col-lg-4 col-sm-3 control-label" for="vehicle_cost">Vehicle Cost</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" placeholder="Vehicle Cost" id="vehicle_cost" name="vehicle_cost" value="<?php echo $vehicle->vehicle_cost; ?>" disabled >
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label  class="col-lg-4 col-sm-3 control-label" for="txt_gps_id">GPS ID</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" placeholder="GPS ID" id="txt_gps_id" name="gps_id" value="<?php echo $vehicle->gps_id; ?>" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-4" for="txt_dofi">Date of Fleet Inclusion</label>
                                        <div class="col-md-8 col-xs-11">
                                            <input class="form-control form-control-inline input-medium default-date-picker"  size="16" type="text" id="txt_dofi" placeholder="Select Date of Fleet Inclusion" name="date_fleet_inclusion" value="<?php echo $vehicle->date_fleet_inclusion; ?>" disabled />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label col-lg-4" for="fuel_type">Fuel Type</label>
                                        <div class="col-lg-8">
                                            <input class="form-control form-control-inline input-medium default-date-picker"  size="16" type="text" id="fuel_type" name="fuel_type" value="<?php echo $vehicle->fuel_type; ?>" disabled />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label  class="col-lg-4 col-sm-3 control-label" for="txt_remarks">Remarks</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" placeholder="Remarks" id="txt_remarks" name="remarks" value="<?php echo $vehicle->remarks; ?>" disabled>
                                        </div>
                                    </div>
                                    <input type="hidden" id="image_edit" name="image_edit" value="<?php echo $vehicle->image; ?>" />
                                </div>
                            </div>
                        </div>
                    </form>
                    
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