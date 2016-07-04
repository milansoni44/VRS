        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/js/bootstrap-datepicker/css/datepicker-custom.css" />
        <script type="text/javascript">
            function changeModel(val)
            {
                //alert(val);
                if(val == 0)
                {
                    document.getElementById('hideModel').style.display = 'block';
                }
                else
                {
                    document.getElementById('hideModel').style.display = 'none';
                }
            }
			function getExtraKMRate(vehicle_type)
			{
				if(vehicle_type == "4 x 4")
				{
					document.getElementById("txt_extra_km").value = "0.100";
				}
				else if(vehicle_type == "Saloon Car")
				{
					document.getElementById("txt_extra_km").value = "0.050";
				}
			}
            $(document).ready(function(){
                $('#vehicleForm').submit(function(){
                    var brand = $('#brand').val();
                    if(brand == 0)
                    {
                        if($('#txt_model').val() == ''){
                            alert('Please Enter model.');
                            return false;
                        }
                    }
                    else
                    {
                        return true;
                    }
                });
            });
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
            <div class="col-lg-12">
                <section class="panel">
                    <header class="panel-heading">
                        <?php echo $page_title; ?> Form
                    </header>
                    <form class="form-horizontal" role="form" method="post" action="add" enctype="multipart/form-data" id="vehicleForm">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="panel-body">
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label col-lg-4" for="branch">Branch <span style="color:red;">*</span></label>
                                        <div class="col-lg-8">
                                            <select class="form-control" id="branch" name="branch">
                                                <?php
													$default_branch1 = $default_branch->default_branch_id;
                                                    foreach($branch as $name)
                                                    {?>
													<option value="<?php echo $name['id'];?>" <?php if($default_branch1 == $name['id']) {?> selected <?php } ?> ><?php echo $name['branch_name']; ?></option>
                                                  <?php }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label  class="col-lg-4 col-sm-3 control-label" for="txt_vehicle_reg_no">Vehicle Reg. No <span style="color:red;">*</span></label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" placeholder="Vehicle Reg. No." id="txt_vehicle_reg_no" name="vehicle_reg_no">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label col-lg-4" for="owner">Owner <span style="color:red;">*</span></label>
                                        <div class="col-lg-8">
                                            <select class="form-control" id="owner" name="owner">
                                                <?php
													$default_owner = $default_branch->default_vehicle_owner_id;
                                                    foreach($owner as $name1)
                                                    {
                                                ?>
													<option value="<?php echo $name1['id'];?>" <?php if($default_owner == $name1['id']) {?> selected <?php } ?> ><?php echo $name1['name']; ?></option>
                                                <?php 
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label  class="col-lg-4 col-sm-3 control-label" for="txt_finance_company">Finance Company</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" placeholder="Finance Company" id="txt_finance_company" name="finance_company">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label col-lg-4" for="brand">Brand / Model <span style="color:red;">*</span></label>
                                        <div class="col-lg-8">
                                            <select class="form-control" id="brand" name="brand" onChange="changeModel(this.value);">
                                                <option value="0">-- Select --</option>
                                                <?php 
                                                    foreach($brand as $value)
                                                    {
                                                ?>        
                                                <option value="<?php echo $value['brand']; ?>"><?php echo $value['brand'] ?></option>
                                                <?php         
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label col-lg-4" for="trans_type">Transmission Type</label>
                                        <div class="col-lg-8">
                                            <select class="form-control" id="trans_type" name="trans_type">
                                                <option>Automatic</option>
                                                <option>Manual</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label col-lg-4" for="vehicle_type">Vehicle Type <span style="color:red;">*</span></label>
                                        <div class="col-lg-8">
                                            <select class="form-control" id="vehicle_type" name="vehicle_type" onchange="getExtraKMRate(this.value);">
                                                <option value="0">--Select--</option>
                                                <option value="4 x 4">4 x 4</option>
                                                <option value="Saloon Car">Salon Car</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group" id="hideModel">
                                        <label  class="col-lg-4 col-sm-3 control-label" for="txt_model">Model</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" placeholder="model" id="txt_model" name="model">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label  class="col-lg-4 col-sm-3 control-label" for="txt_model_year">Model Year</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" placeholder="Model Year" id="txt_model_year" name="model_year">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-4" for="exp_date">Reg. Expiry Date</label>
                                        <div class="col-md-8 col-xs-11">
                                            <input class="form-control form-control-inline input-medium default-date-picker"  size="16" type="text" id="exp_date" placeholder="Select Reg. Expiry Date" name="reg_exp_date"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label  class="col-lg-4 col-sm-3 control-label" for="txt_insurance_type">Insurance Type</label>
                                        <div class="col-lg-8">
                                            <select class="form-control" id="txt_insurance_type" name="insurance_type">
                                                <option value="Comprehensive">Comprehensive</option>
                                                <option value="Third Party">Third Party</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label  class="col-lg-4 col-sm-3 control-label" for="breakdown_recovery">Breakdown Recovery</label>
                                        <div class="col-lg-8">
                                            <select class="form-control" id="breakdown_recovery" name="breakdown_recovery">
                                                <option value="yes">Yes</option>
                                                <option value="no">No</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label  class="col-lg-4 col-sm-3 control-label" for="txt_insurance_company" value="New India Assurance">Insurance Company</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" placeholder="Insurance Company" id="txt_insurance_company" name="insurance_company">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-4" for="insurance_exp_date">Insurance Expiry Date</label>
                                        <div class="col-md-8 col-xs-11">
                                            <input class="form-control form-control-inline input-medium default-date-picker"  size="16" type="text" id="insurance_exp_date" placeholder="Select Insurance Expiry Date" name="insurance_exp_date"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="panel-body">
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label col-lg-4" for="availibility_status">Vehicle Availability Status</label>
                                        <div class="col-lg-8">
                                            <select class="form-control" id="availibility_status" name="vehicle_avail_status">
                                                <option style="color:green;">Available</option>
                                                <option style="color:blue;">Rented</option>
                                                <option style="color:red;">Repair</option>
                                                <option>Other</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label col-lg-4" for="image">Image</label>
                                        <input type="file" id="image" name="image">
                                    </div>
                                    <div class="form-group">
                                        <label  class="col-lg-4 col-sm-3 control-label" for="txt_seating_capacity">Seating Capacity</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" placeholder="Seating Capacity" id="txt_seating_capacity" name="seating_capacity">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label  class="col-lg-4 col-sm-3 control-label" for="txt_engine_capacity">Engine Capacity</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" placeholder="Engine Capacity" id="txt_engine_capacity" name="engine_capacity">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label  class="col-lg-4 col-sm-3 control-label" for="txt_daily_rate">Daily Rate</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" placeholder="Daily Rate" id="txt_daily_rate" name="daily_rate">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label  class="col-lg-4 col-sm-3 control-label" for="txt_weekly_rate">Weekly Rate</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" placeholder="Weekly Rate" id="txt_weekly_rate" name="weekly_rate">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label  class="col-lg-4 col-sm-3 control-label" for="txt_month_rate">Month Rate</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" placeholder="Month Rate" id="txt_month_rate" name="month_rate">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label  class="col-lg-4 col-sm-3 control-label" for="txt_extra_km">Extra KM Rate</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" placeholder="Extra KM Rate" id="txt_extra_km" name="extra_km" value="">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label  class="col-lg-4 col-sm-3 control-label" for="vehicle_cost">Vehicle Cost</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" placeholder="Vehicle Cost" id="vehicle_cost" name="vehicle_cost" value="<?php echo set_value('vehicle_cost'); ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label  class="col-lg-4 col-sm-3 control-label" for="txt_gps_id">GPS ID</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" placeholder="GPS ID" id="txt_gps_id" name="gps_id">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-4" for="txt_dofi">Date of Fleet Inclusion</label>
                                        <div class="col-md-8 col-xs-11">
                                            <input class="form-control form-control-inline input-medium default-date-picker"  size="16" type="text" id="txt_dofi" placeholder="Select Date of Fleet Inclusion" name="date_fleet_inclusion"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label col-lg-4" for="fuel_type">Fuel Type</label>
                                        <div class="col-lg-8">
                                            <select class="form-control" id="fuel_type" name="fuel_type">
                                                <option>Petrol</option>
                                                <option>Diesel</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label  class="col-lg-4 col-sm-3 control-label" for="txt_remarks">Remarks</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" placeholder="Remarks" id="txt_remarks" name="remarks">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel-body">
                            <p>
                                <button class="btn btn-primary" type="submit">Submit</button>
                                <a href="<?php echo base_url(); ?>index.php/vehicle" class="btn btn-default" type="button">Cancel</a>
                            </p>
                        </div>
                    </form>
                    
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