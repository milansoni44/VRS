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
                $(".input-vehicle-image").hide();
                /*==============for vehicle image ===================*/
                <?php 
                    if($vehicle->image != null)
                    {
                ?>
                        $(".input-vehicle-image").hide();
                        $(".edit-vehicle-image").show();
                <?php
                    }
                    else
                    {
                ?>
                        $(".input-vehicle-image").show();
                        $(".edit-vehicle-image").hide();
                <?php
                    }
                ?>
                $('#cancelVehicleImg').click(function(){
                    $(".input-vehicle-image").show();
                    $(".edit-vehicle-image").hide();
                    $('#image_edit').attr('value', '');  
                });
                /*====================================================*/
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
                    <form class="form-horizontal" role="form" method="post" action="../edit/<?php echo $id; ?>" enctype="multipart/form-data" id="vehicleForm">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="panel-body">
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label col-lg-4" for="branch">Branch <span style="color:red;">*</span></label>
                                        <div class="col-lg-8">
                                            <select class="form-control" id="branch" name="branch">
                                                <option value="0">--Select--</option>
                                                <?php
                                                    foreach($branch as $name)
                                                    {
                                                ?>
                                                        <option <?php if($vehicle->branch_id == $name['id']) { ?>selected <?php } ?> value=<?php echo $name['id']; ?>><?php echo $name['branch_name']; ?></option>
                                                <?php
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label  class="col-lg-4 col-sm-3 control-label" for="txt_vehicle_reg_no">Vehicle Reg. No <span style="color:red;">*</span></label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" placeholder="Vehicle Reg. No." id="txt_vehicle_reg_no" name="vehicle_reg_no" value="<?php echo $vehicle->vehicle_reg_no; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label col-lg-4" for="owner">Owner <span style="color:red;">*</span></label>
                                        <div class="col-lg-8">
                                            <select class="form-control" id="owner" name="owner">
                                                <?php
                                                    foreach($owner as $name1)
                                                    {
                                                ?>
                                                        <option <?php if($vehicle->owner_id == $name1['id']) { ?>selected <?php } ?> value=<?php echo $name1['id']; ?>><?php echo $name1['name']; ?></option>
                                                <?php
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label  class="col-lg-4 col-sm-3 control-label" for="txt_finance_company">Finance Company</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" placeholder="Finance Company" id="txt_finance_company" name="finance_company" value="<?php echo $vehicle->finance_company; ?>">
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
                                                <option <?php if($value['brand'] == $vehicle->model){?> selected <?php } ?> value="<?php echo $value['brand'] ?>"><?php echo $value['brand']; ?></option>
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
                                                <option <?php if($vehicle->trans_type=="Automatic") {?>selected <?php } ?> value="Automatic">Automatic</option>
                                                <option <?php if($vehicle->trans_type=="Manual") {?>selected <?php } ?> value="Manual">Manual</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label col-lg-4" for="vehicle_type">Vehicle Type <span style="color:red;">*</span></label>
                                        <div class="col-lg-8">
                                            <select class="form-control" id="vehicle_type" name="vehicle_type" onchange="getExtraKMRate(this.value);">
                                                <option <?php if($vehicle->vehicle_type=="4 x 4") {?>selected <?php } ?> value="4 x 4">4 x 4</option>
                                                <option <?php if($vehicle->vehicle_type=="Saloon Car") {?>selected <?php } ?> value="Saloon Car">Saloon Car</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group" id="hideModel" <?php if($vehicle->brand != 0) {?> style="display:block;" <?php } else { ?> style="display:none;" <?php } ?> >
                                        <label  class="col-lg-4 col-sm-3 control-label" for="txt_model">Model</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" placeholder="model" id="txt_model" name="model" value="<?php echo $vehicle->model; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label  class="col-lg-4 col-sm-3 control-label" for="txt_model_year">Model Year</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" placeholder="Model Year" id="txt_model_year" name="model_year" value="<?php echo $vehicle->model_year; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-4" for="exp_date">Reg. Expiry Date</label>
                                        <div class="col-md-8 col-xs-11">
                                            <input class="form-control form-control-inline input-medium default-date-picker"  size="16" type="text" id="exp_date" placeholder="Select Reg. Expiry Date" name="reg_exp_date" value="<?php echo $vehicle->reg_expiry_date; ?>"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label col-lg-4" for="insurance_type">Insurance Type</label>
                                        <div class="col-lg-8">
                                            <select class="form-control" id="insurance_type" name="insurance_type">
                                                <option <?php if($vehicle->insurance_type=="Comprehensive") {?>selected <?php } ?> value="Comprehensive">Comprehensive</option>
                                                <option <?php if($vehicle->insurance_type=="Third Party") {?>selected <?php } ?> value="Third Party">Third Party</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label col-lg-4" for="breakdown_recovery">Breakdown Recovery</label>
                                        <div class="col-lg-8">
                                            <select class="form-control" id="breakdown_recovery" name="breakdown_recovery">
                                                <option value="0">--Select--</option>
                                                <option <?php if($vehicle->breakdown_recovery=="yes") {?>selected <?php } ?> value="yes">Yes</option>
                                                <option <?php if($vehicle->breakdown_recovery=="no") {?>selected <?php } ?> value="no">No</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label  class="col-lg-4 col-sm-3 control-label" for="txt_insurance_company" value="New India Assurance">Insurance Company</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" placeholder="Insurance Company" id="txt_insurance_company" name="insurance_company" value="<?php echo $vehicle->insurance_company; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-4" for="insurance_exp_date">Insurance Expiry Date</label>
                                        <div class="col-md-8 col-xs-11">
                                            <input class="form-control form-control-inline input-medium default-date-picker"  size="16" type="text" id="insurance_exp_date" placeholder="Select Insurance Expiry Date" name="insurance_exp_date" value="<?php echo $vehicle->insurance_expiry_date; ?>"/>
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
                                                <option style="color:green;" <?php if($vehicle->vehicle_availibility=="Available") {?>selected <?php } ?> value="Available">Available</option>
                                                <option style="color:blue;" <?php if($vehicle->vehicle_availibility=="Rented") {?>selected <?php } ?> value="Rented">Rented</option>
                                                <option style="color:red;" <?php if($vehicle->vehicle_availibility=="Repair") {?>selected <?php } ?> value="Repair">Repair</option>
                                                <option <?php if($vehicle->vehicle_availibility=="Other") {?>selected <?php } ?> value="Other">Other</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label col-lg-4" for="image">Image</label>
                                        <div class="input-vehicle-image">
                                        <input type="file" id="image" name="image" style="float:left">
                                        </div>
                                        <div class="edit-vehicle-image">
                                            <span style="float:left;"><img src="<?php echo base_url()."assets/uploads/vehicles/".$vehicle->image; ?>" alt="" width="50px"/><i class="fa fa-edit" id="cancelVehicleImg" style="padding-left:250px;"></i></span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label  class="col-lg-4 col-sm-3 control-label" for="txt_seating_capacity">Seating Capacity</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" placeholder="Seating Capacity" id="txt_seating_capacity" name="seating_capacity" value="<?php echo $vehicle->seating_capacity; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label  class="col-lg-4 col-sm-3 control-label" for="txt_engine_capacity">Engine Capacity</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" placeholder="Engine Capacity" id="txt_engine_capacity" name="engine_capacity" value="<?php echo $vehicle->engine_capacity; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label  class="col-lg-4 col-sm-3 control-label" for="txt_daily_rate">Daily Rate</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" placeholder="Daily Rate" id="txt_daily_rate" name="daily_rate" value="<?php echo $vehicle->daily_rate; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label  class="col-lg-4 col-sm-3 control-label" for="txt_weekly_rate">Weekly Rate</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" placeholder="Weekly Rate" id="txt_weekly_rate" name="weekly_rate" value="<?php echo $vehicle->weekly_rate; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label  class="col-lg-4 col-sm-3 control-label" for="txt_month_rate">Month Rate</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" placeholder="Month Rate" id="txt_month_rate" name="month_rate" value="<?php echo $vehicle->month_rate; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label  class="col-lg-4 col-sm-3 control-label" for="txt_extra_km">Extra KM Rate</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" placeholder="Extra KM Rate" id="txt_extra_km" name="extra_km" value="<?php echo $vehicle->extra_km; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label  class="col-lg-4 col-sm-3 control-label" for="vehicle_cost">Vehicle Cost</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" placeholder="Vehicle Cost" id="vehicle_cost" name="vehicle_cost" value="<?php echo $vehicle->vehicle_cost; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label  class="col-lg-4 col-sm-3 control-label" for="txt_gps_id">GPS ID</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" placeholder="GPS ID" id="txt_gps_id" name="gps_id" value="<?php echo $vehicle->gps_id; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-4" for="txt_dofi">Date of Fleet Inclusion</label>
                                        <div class="col-md-8 col-xs-11">
                                            <input class="form-control form-control-inline input-medium default-date-picker"  size="16" type="text" id="txt_dofi" placeholder="Select Date of Fleet Inclusion" name="date_fleet_inclusion" value="<?php echo $vehicle->date_fleet_inclusion; ?>"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label col-lg-4" for="fuel_type">Fuel Type</label>
                                        <div class="col-lg-8">
                                            <select class="form-control" id="fuel_type" name="fuel_type">
                                                <option <?php if($vehicle->fuel_type=="Petrol") {?>selected <?php } ?> value="Petrol">Petrol</option>
                                                <option <?php if($vehicle->fuel_type=="Diesel") {?>selected <?php } ?> value="Diesel">Diesel</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label  class="col-lg-4 col-sm-3 control-label" for="txt_remarks">Remarks</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" placeholder="Remarks" id="txt_remarks" name="remarks" value="<?php echo $vehicle->remarks; ?>">
                                        </div>
                                    </div>
                                    <input type="hidden" id="image_edit" name="image_edit" value="<?php echo $vehicle->image; ?>" />
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