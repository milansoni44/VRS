        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/js/bootstrap-datepicker/css/datepicker-custom.css" />
        <script type="text/javascript">
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
                        <span class="tools pull-right">
                            <a class="custom-button" href="<?php echo base_url(); ?>index.php/rentalpickup/edit/<?php echo $id; ?>"> Edit Rental PickUp</a>
                        </span>
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
                                        <label class="col-sm-2 control-label col-lg-4" for="branch">Branch</label>
                                        <div class="col-lg-8">
                                            <!--<select class="form-control" id="branch" name="branch">
                                                <option value="0">--Select Branch--</option>
                                                <?php
                                                    foreach($branch as $name)
                                                    {
                                                ?>
                                                        <option <?php if($rental_pickup->branch_id == $name['id']) { ?>selected <?php } ?> value=<?php echo $name['id']; ?>><?php echo $name['branch_name']; ?></option>
                                                <?php
                                                    }
                                                ?>
                                            </select>-->
                                            <input type="text" class="form-control" id="branch" name="branch" value="<?php echo $rental_pickup->branch_name; ?>" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label col-lg-4" for="customer">Customer</label>
                                        <div class="col-lg-8">
                                            <!--<select class="form-control" id="customer" name="customer">
                                                <option value="0">--Select Customer--</option>
                                                <?php
                                                    foreach($customer as $name1)
                                                    {
                                                ?>
                                                        <option <?php if($rental_pickup->customer_id == $name1['id']) { ?>selected <?php } ?> value=<?php echo $name1['id']; ?>><?php echo $name1['en_name']; ?></option>
                                                <?php
                                                    }
                                                ?>
                                            </select>-->
                                            <input type="text" class="form-control" id="customer" name="customer" value="<?php echo $rental_pickup->en_name; ?>" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label col-lg-4" for="date_rental">Date of Rental</label>
                                        <div class="col-lg-8">
                                            <input class="form-control form-control-inline input-medium default-date-picker"  size="16" type="text" id="date_rental" name="date_rental" placeholder="Select Date of Rental" value="<?php echo $rental_pickup->date_rental; ?>" disabled />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label col-lg-4" for="vehicle_no">Vehicle</label>
                                        <div class="col-lg-8">
                                            <!--<select class="form-control" id="vehicle_no" name="vehicle_no">
                                                <option value="0">--Select Vehicle--</option>
                                                <?php
                                                    foreach($vehicle as $name2)
                                                    {
                                                ?>
                                                        <option <?php if($rental_pickup->branch_id == $name2['id']) { ?>selected <?php } ?> value=<?php echo $name2['id']; ?>><?php echo $name2['vehicle_reg_no']; ?></option>
                                                <?php
                                                    }
                                                ?>
                                            </select>-->
                                            <input type="text" class="form-control" id="vehicle_no" name="vehicle_no" value="<?php echo $rental_pickup->vehicle_reg_no; ?>" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label col-lg-4" for="rental_type">Rental Type</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" id="rental_type" name="rental_type" value="<?php echo $rental_pickup->rental_type; ?>" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label  class="col-lg-4 col-sm-3 control-label" for="rent_amount">Rent Amount</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" placeholder="Rent Amount" id="rent_amount" name="rent_amount" value="<?php echo $rental_pickup->rent_amount; ?>" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label  class="col-lg-4 col-sm-3 control-label" for="deposit_amount">Deposit Amount</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" placeholder="Deposit Amount" id="deposit_amount" name="deposit_amount" value="<?php echo $rental_pickup->deposit_amount; ?>" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label col-lg-4" for="expected_return_date">Expected Return Date</label>
                                        <div class="col-lg-8">
                                            <input class="form-control form-control-inline input-medium default-date-picker"  size="16" type="text"id="expected_return_date" placeholder="Select expected return date" name="expected_return_date" value="<?php echo $rental_pickup->expected_return_date; ?>" disabled/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label  class="col-lg-4 col-sm-3 control-label" for="pickup_from_place">Pickup From Place</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" placeholder="Pick up from place" id="pickup_from_place" name="pickup_from_place" value="<?php echo $rental_pickup->pickup_from_place; ?>" disabled>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="panel-body">
                                    <div class="form-group">
                                        <label  class="col-lg-4 col-sm-3 control-label" for="drop_off_place">Drop Off Place</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" placeholder="Drop off place" id="drop_off_place" name="drop_off_place" value="<?php echo $rental_pickup->drop_off_place; ?>" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label  class="col-lg-4 col-sm-3 control-label" for="km_allowed">KM Allowed</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" placeholder="KM Allowed" id="km_allowed" name="km_allowed" value="<?php echo $rental_pickup->km_allowed; ?>" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label  class="col-lg-4 col-sm-3 control-label" for="extra_km_rate">Extra KM Rate</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" placeholder="Extra KM Rate" id="extra_km_rate" name="extra_km_rate" value="<?php echo $rental_pickup->extra_km_rate; ?>" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label  class="col-lg-4 col-sm-3 control-label" for="km_reading_out">KM Reading - Out</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" placeholder="KM Reading Out" id="km_reading_out" name="km_reading_out" value="<?php echo $rental_pickup->km_reading_out; ?>" disabled>
                                        </div>
                                    </div>
                                    <!--<div class="form-group">
                                        <label  class="col-lg-4 col-sm-3 control-label" for="km_reading_in">KM Reading - In</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" placeholder="KM Reading In" id="km_reading_in" name="km_reading_in" value="<?php echo $rental_pickup->km_reading_in; ?>" disabled>
                                        </div>
                                    </div>-->
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label col-lg-4" for="fuel_level">Fuel Level</label>
                                        <div class="col-lg-8">
                                            <!--<select class="form-control" id="fuel_level" name="fuel_level">
                                                <option value="Quarter" <?php if($rental_pickup->fuel_level == "Quarter") {?> selected <?php } ?>>Quarter</option>
                                                <option value="LT Quarter" <?php if($rental_pickup->fuel_level == "LT Quarter") {?> selected <?php } ?>> LT Quarter</option>
                                                <option value="Half" <?php if($rental_pickup->fuel_level == "Half") {?> selected <?php } ?>>Half</option>
                                                <option value="LT Half" <?php if($rental_pickup->fuel_level == "LT Half") {?> selected <?php } ?>>LT Half</option>
                                                <option value="3 Quarter" <?php if($rental_pickup->fuel_level == "3 Quarter") {?> selected <?php } ?>>3 Quarter</option>
                                                <option value="LT 3 Quarter" <?php if($rental_pickup->fuel_level == "LT 3 Quarter") {?> selected <?php } ?>>LT 3 Quarter</option>
                                                <option value="Full" <?php if($rental_pickup->fuel_level == "Full") {?> selected <?php } ?>>Full</option>
                                                <option value="LT Full" <?php if($rental_pickup->fuel_level == "LT Full") {?> selected <?php } ?>>LT Full</option>
                                            </select>-->
                                            <input type="text" class="form-control" id="fuel_level" name="fuel_level" value="<?php echo $rental_pickup->fuel_level; ?>" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label  class="col-lg-4 col-sm-3 control-label" for="gps_km">GPS KM</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" placeholder="GPS KM" id="gps_km" name="gps_km" value="<?php echo $rental_pickup->gps_km; ?>" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label  class="col-lg-4 col-sm-3 control-label" for="actual_km">Actual KM</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" placeholder="Actual KM" id="actual_km" name="actual_km" value="<?php echo $rental_pickup->actual_km; ?>" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label  class="col-lg-4 col-sm-3 control-label" for="total_km">Total KM</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" placeholder="Total KM" id="total_km" name="total_km" value="<?php echo $rental_pickup->total_km; ?>" disabled>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--<div class="panel-body">
                            <p>
                                <button class="btn btn-primary" type="submit">Submit</button>
                                <a href="<?php echo base_url(); ?>index.php/rentalpickup" class="btn btn-default" type="button">Cancel</a>
                            </p>
                        </div>-->
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
        
        <!--pickers initialization-->
        <script src="<?php echo base_url(); ?>assets/js/pickers-init.js"></script>