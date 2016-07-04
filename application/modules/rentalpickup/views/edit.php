        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/js/bootstrap-datetimepicker/css/datetimepicker-custom.css" />
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/choosen/prism.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/choosen/chosen.css">
        <script type="text/javascript">
            function calculateDate(date1, date2){
                if(date1 == "")
                {
                    alert("Please select rental date");
                    document.getElementById('date_rental').focus();
                    document.getElementById('expected_return_date').value = "";
                    return false;
                }
                //our custom function with two parameters, each for a selected date
                var d1 = date1.split("/");
                var d2 = date2.split("/");
                
                //for date1 convert to mm/dd/yyyy
                var temp = d1[1];
                d1[1] = d1[0];
                d1[0] = temp;
                
                //for date2 convert to mm/dd/yyyy
                var temp1 = d2[1];
                d2[1] = d2[0];
                d2[0] = temp1;
                
                var newDate1 = new Date(temp+"/"+d1[1]+"/"+d1[2]);
                var newDate2 = new Date(temp1+"/"+d2[1]+"/"+d2[2]);
                
                diffc = newDate1.getTime() - newDate2.getTime();
                //getTime() function used to convert a date into milliseconds. This is needed in order to perform calculations.
             
                days = Math.round(Math.abs(diffc/(1000*60*60*24)));
                //this is the actual equation that calculates the number of days.
                return days;
            }
            function getRentAmount(a,b)
            {
                if(a == 0)
                {
                    alert('Please select vehicle number first.');
                    return false;
                }
                else
                {
                    $.ajax({
                            type: "post",
                            url: "<?php echo base_url(); ?>index.php/rentalpickup/scanRentAmount",
                            cache: false,				
                            // data: $('#userForm').serialize(),
                            data: {vehicle_no: a,rental_type:b},
                            async:false,
                            success: function(json){
                            try{
                                var obj = JSON.parse(json);
                                console.log(obj);
                                $('#rent_amount').val(obj.rate);
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
            function getPlace(a)
            {
                if(a == 0)
                {
                    alert('Please select branch first.');
                    return false;
                }
                else
                {
                    $.ajax({
                            type: "post",
                            url: "<?php echo base_url(); ?>index.php/rentalpickup/scanPlace",
                            cache: false,				
                            // data: $('#userForm').serialize(),
                            data: {branch_id: a},
                            async:false,
                            success: function(json){
                            try{
                                var obj = JSON.parse(json);
                                console.log(obj);
                                $('#pickup_from_place').val(obj.place);
                                $('#drop_off_place').val(obj.place);
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
            
            function getExtraKM(a)
            {
                if(a == 0)
                {
                    alert('Please select vehicle number first.');
                    return false;
                }
                else
                {
                    $.ajax({
                            type: "post",
                            url: "<?php echo base_url(); ?>index.php/rentalpickup/scanExtraKM",
                            cache: false,				
                            // data: $('#userForm').serialize(),
                            data: {vehicle_no: a},
                            async:false,
                            success: function(json){
                            try{
                                var obj = JSON.parse(json);
                                console.log(obj);
                                $('#extra_km_rate').val(obj.extra_km);
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
            function getKMUsed(a)
			{
                //alert(a);
				if(a == "Daily")
				{
					document.getElementById("km_allowed").value = 200;
				}
				else if(a == "Weekly")
				{
					document.getElementById("km_allowed").value = 1200;
				}
				else if(a == "Monthly")
				{
					document.getElementById("km_allowed").value = 4800;
				}
                
                var pickUP_date = document.getElementById('date_rental').value;
                var return_date = document.getElementById('expected_return_date').value;
                var vehicle_no = document.getElementById('vehicle_no').value;
                //alert(vehicle_no);
                if(return_date == '' || return_date == null)
                {
                    alert('Please select expected return date.');
                    return false;
                }
                var days = calculateDate(pickUP_date,return_date);
                var total_days = days;
                if(a == 0)
                {
                    alert('Please select rental type first.');
                    return false;
                }
                else if(document.getElementById('vehicle_no').value == 0)
                {
                    alert('Please select vehicle first.');
                    return false;
                }
                else
                {
                    $.ajax({
                            type: "post",
                            url: "<?php echo base_url(); ?>index.php/rentalpickup/calculateTotalRent",
                            cache: false,				
                            data: {vehicle_no: vehicle_no, rent_type: a,days: total_days},
                            async:false,
                            success: function(json){
                            try{
                                var obj = JSON.parse(json);
                                console.log(obj);
                                $('#rent_amount').val(obj.totalRentalAmount);
                            }catch(e) {		
                            alert(e);
                            alert('Exception while request..');
                            }		
                        },
                        error: function(){						
                            alert('Error while request..');
                        }
                    });
                }
			}
			/*function getKMUsed(a)
			{
				//alert(a);
				if(a == "Daily")
				{
					document.getElementById("km_allowed").value = 200;
				}
				else if(a == "Weekly")
				{
					document.getElementById("km_allowed").value = 1200;
				}
				else if(a == "Monthly")
				{
					document.getElementById("km_allowed").value = 4800;
				}
			}*/
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
        <?php 
            // echo '<pre>';
            // print_r($rental_pickup);
            // echo '</pre>';
        ?>
        <div class="row">
            <div class="col-lg-12">
                <section class="panel">
                    <header class="panel-heading">
                        <?php echo $page_title; ?> Form
                    </header>
                    <form class="form-horizontal" role="form" method="post" action="../edit/<?php echo $id; ?>">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="panel-body">
                                    <div class="form-group">
                                        <label  class="col-lg-4 col-sm-3 control-label" for="rental_no">Rental Id</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" id="rental_no" name="rental_no" value="<?php echo $id; ?>" disabled >
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label col-lg-4" for="branch">Branch <span style="color:red;">*</span></label>
                                        <div class="col-lg-8">
                                            <select class="form-control" id="branch" name="branch" onchange="getPlace(this.value);">
                                                <option value="0">--Select Branch--</option>
                                                <?php
                                                    foreach($branch as $name)
                                                    {
                                                ?>
                                                        <option <?php if($rental_pickup->branch_id == $name['id']) { ?>selected <?php } ?> value=<?php echo $name['id']; ?>><?php echo $name['branch_name']; ?></option>
                                                <?php
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label col-lg-4" for="customer">Customer <span style="color:red;">*</span></label>
                                        <div class="col-lg-8">
                                            <select class="form-control chosen-select" id="customer" name="customer">
                                                <?php
                                                    foreach($customer as $name1)
                                                    {
                                                ?>
                                                        <option <?php if($rental_pickup->customer_id == $name1['id']) { ?>selected <?php } ?> value=<?php echo $name1['id']; ?>><?php echo $name1['id'].".  ".$name1['en_name']; ?></option>
                                                <?php
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label col-lg-4" for="date_rental">Date of Rental <span style="color:red;">*</span></label>
                                        <div class="col-lg-8">
                                            <input class="form-control form_datetime"  size="16" type="text" id="date_rental" name="date_rental" placeholder="Select Date of Rental" value="<?php echo $rental_pickup->date_rental; ?>"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label col-lg-4" for="expected_return_date">Expected Return Date <span style="color:red;">*</span></label>
                                        <div class="col-lg-8">
                                            <input class="form-control form_datetime"  size="16" type="text"id="expected_return_date" placeholder="Select expected return date" name="expected_return_date" value="<?php echo $rental_pickup->expected_return_date; ?>"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label col-lg-4" for="vehicle_no">Vehicle <span style="color:red;">*</span></label>
                                        <div class="col-lg-8">
                                            <select class="form-control" id="vehicle_no" name="vehicle_no" onchange="getExtraKM(this.value);">
                                                <option value="0">--Select Vehicle--</option>
                                                <?php
                                                    foreach($vehicle as $name2)
                                                    {
                                                ?>
                                                        <option <?php if($rental_pickup->vehicle_id == $name2['id']) { ?>selected <?php } ?> value=<?php echo $name2['id']; ?>><?php echo $name2['vehicle_reg_no']." ".$name2['brand']; ?></option>
                                                <?php
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label col-lg-4" for="rental_type">Rental Type <span style="color:red;">*</span></label>
                                        <div class="col-lg-8">
                                            <!--<select class="form-control" id="rental_type" name="rental_type" onchange="getRentAmount(document.getElementById('vehicle_no').value,this.value);">-->
											<select class="form-control" id="rental_type" name="rental_type" onchange="getKMUsed(this.value);">
                                                <option value="0">--Select--</option>
                                                <option value="Daily" <?php if($rental_pickup->rental_type == "Daily") {?> selected <?php } ?>>Daily</option>
                                                <option value="Weekly" <?php if($rental_pickup->rental_type == "Weekly") {?> selected <?php } ?>>Weekly</option>
                                                <option value="Monthly" <?php if($rental_pickup->rental_type == "Monthly") {?> selected <?php } ?>>Monthly</option>
                                                <!--<option value="Others">Others</option>-->
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label  class="col-lg-4 col-sm-3 control-label" for="rent_amount">Rent Amount</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" placeholder="Rent Amount" id="rent_amount" name="rent_amount" value="<?php echo $rental_pickup->rent_amount; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label  class="col-lg-4 col-sm-3 control-label" for="deposit_amount">Deposit Amount</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" placeholder="Deposit Amount" id="deposit_amount" name="deposit_amount" value="<?php echo $rental_pickup->deposit_amount; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label  class="col-lg-4 col-sm-3 control-label" for="pickup_from_place">Pickup From Place</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" placeholder="Pick up from place" id="pickup_from_place" name="pickup_from_place" value="<?php echo $rental_pickup->pickup_from_place; ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="panel-body">
                                    <div class="form-group">
                                        <label  class="col-lg-4 col-sm-3 control-label" for="drop_off_place">Drop Off Place</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" placeholder="Drop off place" id="drop_off_place" name="drop_off_place" value="<?php echo $rental_pickup->drop_off_place; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label  class="col-lg-4 col-sm-3 control-label" for="km_allowed">KM Allowed</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" placeholder="KM Allowed" id="km_allowed" name="km_allowed" value="<?php echo $rental_pickup->km_allowed; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label  class="col-lg-4 col-sm-3 control-label" for="extra_km_rate">Extra KM Rate</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" placeholder="Extra KM Rate" id="extra_km_rate" name="extra_km_rate" value="<?php echo $rental_pickup->extra_km_rate; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label  class="col-lg-4 col-sm-3 control-label" for="km_reading_out">KM Reading - Out</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" placeholder="KM Reading Out" id="km_reading_out" name="km_reading_out" value="<?php echo $rental_pickup->km_reading_out; ?>">
                                        </div>
                                    </div>
                                    <!--<div class="form-group">
                                        <label  class="col-lg-4 col-sm-3 control-label" for="km_reading_in">KM Reading - In</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" placeholder="KM Reading In" id="km_reading_in" name="km_reading_in" value="<?php echo $rental_pickup->km_reading_in; ?>">
                                        </div>
                                    </div>-->
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label col-lg-4" for="fuel_level">Fuel Level</label>
                                        <div class="col-lg-8">
                                            <select class="form-control" id="fuel_level" name="fuel_level">
                                                <option value="Quarter" <?php if($rental_pickup->fuel_level == "Quarter") {?> selected <?php } ?>>Quarter</option>
                                                <option value="Quarter" <?php if($rental_pickup->fuel_level == "GT Quarter") {?> selected <?php } ?>> > Quarter</option>
                                                <option value="LT Quarter" <?php if($rental_pickup->fuel_level == "LT Quarter") {?> selected <?php } ?>> LT Quarter</option>
                                                <option value="Half" <?php if($rental_pickup->fuel_level == "Half") {?> selected <?php } ?>>Half</option>
                                                <option value="Half" <?php if($rental_pickup->fuel_level == "GT Half") {?> selected <?php } ?>> > Half</option>
                                                <option value="LT Half" <?php if($rental_pickup->fuel_level == "LT Half") {?> selected <?php } ?>>LT Half</option>
                                                <option value="3 Quarter" <?php if($rental_pickup->fuel_level == "3 Quarter") {?> selected <?php } ?>>3 Quarter</option>
                                                <option value="3 Quarter" <?php if($rental_pickup->fuel_level == "GT 3 Quarter") {?> selected <?php } ?>> > 3 Quarter</option>
                                                <option value="LT 3 Quarter" <?php if($rental_pickup->fuel_level == "LT 3 Quarter") {?> selected <?php } ?>>LT 3 Quarter</option>
                                                <option value="Full" <?php if($rental_pickup->fuel_level == "Full") {?> selected <?php } ?>>Full</option>
                                                <option value="Full" <?php if($rental_pickup->fuel_level == "GT Full") {?> selected <?php } ?>> > Full</option>
                                                <option value="LT Full" <?php if($rental_pickup->fuel_level == "LT Full") {?> selected <?php } ?>>LT Full</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label  class="col-lg-4 col-sm-3 control-label" for="gps_km">GPS KM</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" placeholder="GPS KM" id="gps_km" name="gps_km" value="<?php echo $rental_pickup->gps_km; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label  class="col-lg-4 col-sm-3 control-label" for="actual_km">Actual KM</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" placeholder="Actual KM" id="actual_km" name="actual_km" value="<?php echo $rental_pickup->actual_km; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label  class="col-lg-4 col-sm-3 control-label" for="total_km">Total KM</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" placeholder="Total KM" id="total_km" name="total_km" value="<?php echo $rental_pickup->total_km; ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel-body">
                            <p>
                                <button class="btn btn-primary" type="submit" onclick="return confirm('Are you sure?');">Submit</button>
                                <a href="<?php echo base_url(); ?>index.php/rentalpickup" class="btn btn-default" type="button">Cancel</a>
                            </p>
                        </div>
                    </form>
                    
                </section>
            </div>
        </div>
        
        <!--pickers plugins-->
        <!--<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>-->
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js"></script>
        <!--<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootstrap-daterangepicker/moment.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootstrap-daterangepicker/daterangepicker.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootstrap-timepicker/js/bootstrap-timepicker.js"></script>-->
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
        <!--pickers initialization-->
        <script src="<?php echo base_url(); ?>assets/js/pickers-init.js"></script>