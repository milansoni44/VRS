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
        <!-- page start-->
        <div class="row">
            <div class="col-lg-12">
                <section class="panel">
                    <header class="panel-heading">
                        <?php echo $page_title; ?>
                        <span class="tools pull-right">
                            <a class="custom-button" href="<?php echo base_url(); ?>index.php/rentalreturn/edit/<?php echo $id; ?>"> Edit Rental Return</a>
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
                                        <label class="col-sm-2 control-label col-lg-4" for="pickup_date">PickUp Date</label>
                                        <div class="col-lg-8">
                                            <input class="form-control form-control-inline input-medium default-date-picker"  size="16" type="text" value="<?php echo $rental_return->pickup_date; ?>" id="pickup_date" placeholder="Select Date of Rental PickUp" name="pickup_date" disabled />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label col-lg-4" for="rental_return_date">Return Date</label>
                                        <div class="col-lg-8">
                                            <input class="form-control form-control-inline input-medium default-date-picker"  size="16" type="text" value="<?php echo $rental_return->return_date; ?>" id="rental_return_date" placeholder="Select Date of Rental Return" name="rental_return_date" disabled />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label col-lg-4" for="km_used">KM Used</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" placeholder="KM Used" value="<?php echo $rental_return->km_used; ?>" id="km_used" name="km_used" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label col-lg-4" for="km_extra_used">KM Extra Used</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" placeholder="KM Extra Used" value="<?php echo $rental_return->km_extra_used; ?>" id="km_extra_used" name="km_extra_used" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label col-lg-4" for="km_extra_used_rate">KM Extra Rate</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" placeholder="KM Extra Used Rate" id="km_extra_used_rate" name="km_extra_used_rate" value="<?php echo $rental_return->km_extra_rate; ?>" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label col-lg-4" for="total_rented_days">Total Rented Days</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" placeholder="Total Rented Days" id="total_rented_days" name="total_rented_days" value="<?php echo $rental_return->total_rented_days; ?>" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label col-lg-4" for="rate_per_day">Rate Per Day</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" placeholder="Rate Per Day" id="rate_per_day" name="rate_per_day" value="<?php echo $rental_return->rate_per_day; ?>" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label col-lg-4" for="total_rent_charge">Total Rent Charge</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" placeholder="Rate Per Day" id="total_rent_charge" name="total_rent_charge" value="<?php echo $rental_return->total_rent_charges; ?>" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label col-lg-4" for="fuel_level">Fuel Level</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" id="fuel_level" name="fuel_level" value="<?php echo $rental_return->fuel_level; ?>" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label  class="col-lg-4 col-sm-3 control-label" for="fuel_refil_charges">Fuel Refil Charges</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" placeholder="Fuel Refil Charges" id="fuel_refil_charges" name="fuel_refil_charges" value="<?php echo $rental_return->fuel_refil_charges; ?>" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label  class="col-lg-4 col-sm-3 control-label" for="traffic_fine">Traffic Fine</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" placeholder="Traffic Fine" id="traffic_fine" name="traffic_fine" value="<?php echo $rental_return->traffic_fine; ?>" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label  class="col-lg-4 col-sm-3 control-label" for="additional_driver_charge">Additional Driver Charge</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" placeholder="Additional Driver Charge" id="additional_driver_charge" name="additional_driver_charge" value="<?php echo $rental_return->additional_driver_charges; ?>" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label  class="col-lg-4 col-sm-3 control-label" for="chauffer_charges">Chauffer charges</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" placeholder="Chauffer charges" id="chauffer_charges" name="chauffer_charges" value="<?php echo $rental_return->chauffer_charges; ?>" disabled>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="panel-body">
                                    <div class="form-group">
                                        <label  class="col-lg-4 col-sm-3 control-label" for="additional_insurance">Additional insurance</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" placeholder="Additional insurance" id="additional_insurance" name="additional_insurance" value="<?php echo $rental_return->additional_insurance; ?>" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label  class="col-lg-4 col-sm-3 control-label" for="pai_charge">PAI Charge</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" placeholder="PAI Charge" id="pai_charge" name="pai_charge" value="<?php echo $rental_return->pai_charges; ?>" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label  class="col-lg-4 col-sm-3 control-label" for="misc_charges">Miscellaneous Charges</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" placeholder="Miscellaneous Charges" id="misc_charges" name="misc_charges" value="<?php echo $rental_return->misc_charges; ?>" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label  class="col-lg-4 col-sm-3 control-label" for="deduction">Deductions</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" placeholder="Deductions" id="deduction" name="deduction" value="<?php echo $rental_return->deduction; ?>" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label  class="col-lg-4 col-sm-3 control-label" for="discount_type">Discount Type</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" placeholder="Discount Type" id="discount_type" name="discount_by_percent" value="<?php if($rental_return->discount_type==0){ echo "Discount By Percentage";} else{ echo "Discount By Amount";} ?>" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label  class="col-lg-4 col-sm-3 control-label" for="discount">Discount</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" placeholder="Discount" id="discount" name="discount" value="<?php 
                                            if($rental_return->discount_type == 0)
                                            {
                                                echo round($rental_return->discount);
                                            }
                                            else
                                            {
                                                echo $rental_return->discount;    
                                            } ?>" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label  class="col-lg-4 col-sm-3 control-label" for="invoice_no">Invoice No</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" placeholder="Invoice No" id="invoice_no" name="invoice_no" value="<?php echo $rental_return->invoice_no; ?>" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label col-lg-4" for="invoice_date">Invoice Date</label>
                                        <div class="col-lg-8">
                                            <input class="form-control form-control-inline input-medium default-date-picker"  size="16" type="text" id="invoice_date" placeholder="Select Invoice Date" name="invoice_date" value="<?php echo $rental_return->invoice_date; ?>" disabled />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label col-lg-4" for="invoice_status">Invoice Status</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" id="invoice_status" name="invoice_status" value="<?php echo $rental_return->invoice_status; ?>" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label  class="col-lg-4 col-sm-3 control-label" for="gps_km">GPS KM</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" placeholder="GPS KM" id="gps_km" name="gps_km" value="<?php echo $rental_return->gps_km; ?>" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label  class="col-lg-4 col-sm-3 control-label" for="actual_km">Actual KM</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" placeholder="Actual KM" id="actual_km" name="actual_km" value="<?php echo $rental_return->actual_km; ?>" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label  class="col-lg-4 col-sm-3 control-label" for="total_km">Total KM</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" placeholder="Total KM" id="total_km" name="total_km" value="<?php echo $rental_return->total_km; ?>" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label  class="col-lg-4 col-sm-3 control-label" for="net_amount">Net Amount Payable</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" placeholder="Net Amount Payable" id="net_amount" name="net_amount" value="<?php echo $rental_return->net_amount; ?>" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label  class="col-lg-4 col-sm-3 control-label" for="remarks">Remarks</label>
                                        <div class="col-lg-8">
                                            <textarea class="form-control" id="remarks" name="remarks" disabled><?php echo $rental_return->remarks; ?></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--<div class="panel-body">
                            <p>
                                <button class="btn btn-primary" type="submit">Submit</button>
                                <button class="btn btn-primary" type="button">Cancel</button>
                            </p>
                        </div>-->
                    </form>
                    
                </section>
            </div>
        </div>
        <!-- main content end-->
    </section>
    
        <!--pickers plugins-->
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootstrap-daterangepicker/moment.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootstrap-daterangepicker/daterangepicker.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootstrap-timepicker/js/bootstrap-timepicker.js"></script>
        
        <!--pickers initialization-->
        <script src="<?php echo base_url(); ?>assets/js/pickers-init.js"></script>