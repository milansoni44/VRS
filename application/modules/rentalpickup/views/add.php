        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/js/bootstrap-datetimepicker/css/datetimepicker-custom.css" />
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/choosen/prism.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/choosen/chosen.css">
        <script type="text/javascript">
        
            $( document ).ready(function() {
                $(window).load(function(){
                   
                    $("#pickup_from_place").val( $("#branch option:selected").text()) ; 
                    $("#drop_off_place").val( $("#branch option:selected").text()) ; 
                    
                   // alert( $("#branch option:selected").text());
                });
            });
            function calculateDate(date1, date2){
                if(date1 == "")
                {
                    alert("Please select rental date");
                    document.getElementById('date_rental').focus();
                    document.getElementById('expected_return_date').value = "";
                    return false;
                }
                //our custom function with two parameters, each for a selected date
                var d11 = date1.split(" ");
                var d12 = date2.split(" ");
                var d1 = d11[0].split("/");
                var d2 = d12[0].split("/");
                
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
                                if(obj.vehicle_type == "4 x 4")
                                {
                                    $('#deposit_amount').val(100);
                                }
                                if(obj.vehicle_type == "Saloon Car")
                                {
                                    $('#deposit_amount').val(50);
                                }
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
                                var totalRentalAmount = (obj.totalRentalAmount).toFixed(3);
                                $('#rent_amount').val(totalRentalAmount);
                            }catch(e) {		
                            //alert(e);
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
            <div class="col-lg-12">
                <section class="panel">
                    <header class="panel-heading">
                        <?php echo $page_title; ?> Form
                    </header>
                    <form class="form-horizontal" role="form" method="post" action="add">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="panel-body">
                                    <div class="form-group">
                                        <label  class="col-lg-4 col-sm-3 control-label" for="rental_no">Rental Id</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" id="rental_no" name="rental_no" value="<?php echo $last_id; ?>" disabled >
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label col-lg-4" for="branch">Branch <span style="color:red;">*</span></label>
                                        <div class="col-lg-8">
                                            <select class="form-control" id="branch" name="branch" onchange="getPlace(this.value);">
                                                <?php
													$default_branch = $default_branch->default_branch_id;
                                                    $firstbranch;
                                                    foreach($branch as $name)
                                                    {?>
													<option value="<?php echo $name['id'];?>" <?php if($default_branch == $name['id']){ ?> selected <?php } ?> ><?php echo $name['branch_name']; ?></option>
                                                  <?php }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label col-lg-4" for="customer">Customer <span style="color:red;">*</span></label>
                                        <div class="col-lg-8">
                                            <select class="form-control chosen-select" id="customer" name="customer">
                                                <option value="0">--Select Customer--</option>
                                                <?php
                                                    foreach($customer as $customer_name)
                                                    {
                                                        echo "<option value='$customer_name[id]' " . set_select('customer', $customer_name['id']) . " >".$customer_name[id].".  ".$customer_name['en_name']."</option>";
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label col-lg-4" for="date_rental">Date of Rental <span style="color:red;">*</span></label>
                                        <div class="col-lg-8">
                                            <input class="form-control form_datetime"  size="16" type="text" id="date_rental" name="date_rental" placeholder="Select Date of Rental" value="<?php echo date('d/m/Y h:i'); ?>" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label col-lg-4" for="expected_return_date">Expected Return Date <span style="color:red;">*</span></label>
                                        <div class="col-lg-8">
                                            <input class="form-control form_datetime"  size="16" type="text"id="expected_return_date" placeholder="Select expected return date" name="expected_return_date" value="<?php echo set_value('expected_return_date'); ?>" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label col-lg-4" for="vehicle_no">Vehicle <span style="color:red;">*</span></label>
                                        <div class="col-lg-8">
                                            <select class="form-control" id="vehicle_no" name="vehicle_no" onchange="getExtraKM(this.value);">
                                                <option value="0">--Select Vehicle--</option>
                                                <?php
                                                    foreach($vehicle as $no)
                                                    {
                                                        echo "<option value='$no[id]' " . set_select('vehicle_no', $no['id']) . " >". $no['vehicle_reg_no']." ".$no['brand']."</option>";
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label col-lg-4" for="rental_type">Rental Type <span style="color:red;">*</span></label>
                                        <div class="col-lg-8">
                                            <select class="form-control" id="rental_type" name="rental_type" onchange="getKMUsed(this.value);">
                                                <option value="0">--Select--</option>
                                                <option value="Daily">Daily</option>
                                                <option value="Weekly">Weekly</option>
                                                <option value="Monthly">Monthly</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label  class="col-lg-4 col-sm-3 control-label" for="rent_amount">Total Rent Amount</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" placeholder="Rent Amount" id="rent_amount" name="rent_amount" value="<?php echo set_value('rent_amount'); ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label  class="col-lg-4 col-sm-3 control-label" for="deposit_amount">Deposit Amount</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" placeholder="Deposit Amount" id="deposit_amount" name="deposit_amount" value="<?php echo set_value('deposit_amount'); ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label  class="col-lg-4 col-sm-3 control-label" for="pickup_from_place">Pickup From Place</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" placeholder="Pick up from place" id="pickup_from_place" name="pickup_from_place" value="<?php echo set_value('pickup_from_place'); ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="panel-body">
                                    <div class="form-group">
                                        <label  class="col-lg-4 col-sm-3 control-label" for="drop_off_place">Drop Off Place</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" placeholder="Drop off place" id="drop_off_place" name="drop_off_place" value="<?php echo set_value('drop_off_place'); ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label  class="col-lg-4 col-sm-3 control-label" for="km_allowed">KM Allowed</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" placeholder="KM Allowed" id="km_allowed" name="km_allowed" value="<?php echo set_value('km_allowed'); ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label  class="col-lg-4 col-sm-3 control-label" for="extra_km_rate">Extra KM Rate</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" placeholder="Extra KM Rate" id="extra_km_rate" name="extra_km_rate" value="<?php echo set_value('extra_km_rate'); ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label  class="col-lg-4 col-sm-3 control-label" for="km_reading_out">KM Reading - Out</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" placeholder="KM Reading Out" id="km_reading_out" name="km_reading_out" value="<?php echo set_value('km_reading_out'); ?>">
                                        </div>
                                    </div>
                                    <!--<div class="form-group">
                                        <label  class="col-lg-4 col-sm-3 control-label" for="km_reading_in">KM Reading - In</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" placeholder="KM Reading In" id="km_reading_in" name="km_reading_in" value="<?php echo set_value('km_reading_in'); ?>">
                                        </div>
                                    </div>-->
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label col-lg-4" for="fuel_level">Fuel Level</label>
                                        <div class="col-lg-8">
                                            <select class="form-control" id="fuel_level" name="fuel_level">
                                                <option value="Quarter"> Quarter</option>
                                                <option value="GT Quarter"> > Quarter</option>
                                                <option value="LT Quarter"> < Quarter</option>
                                                <option value="Half"> Half</option>
                                                <option value="GT Half"> > Half</option>
                                                <option value="LT Half"> < Half</option>
                                                <option value="3 Quarter"> 3 Quarter</option>
                                                <option value="GT 3 Quarter"> > 3 Quarter</option>
                                                <option value="LT 3 Quarter"> < 3 Quarter</option>
                                                <option value="Full"> Full</option>
                                                <option value="GT Full"> > Full</option>
                                                <option value="LT Full"> < Full</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label  class="col-lg-4 col-sm-3 control-label" for="gps_km">GPS KM</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" placeholder="GPS KM" id="gps_km" name="gps_km" value="<?php echo set_value('gps_km'); ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label  class="col-lg-4 col-sm-3 control-label" for="actual_km">Actual KM</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" placeholder="Actual KM" id="actual_km" name="actual_km" value="<?php echo set_value('actual_km'); ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label  class="col-lg-4 col-sm-3 control-label" for="total_km">Total KM</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" placeholder="Total KM" id="total_km" name="total_km" value="<?php echo set_value('total_km'); ?>">
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