        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/js/bootstrap-datetimepicker/css/datetimepicker-custom.css" />
        <script>
            $(document).ready(function(){
                $(window).load(function(){
                   var rent_charge = $('#total_rent_charge').val();
                   //alert(<?php echo $rental_return->net_amount; ?>);
                   if(<?php echo $rental_return->net_amount; ?> != rent_charge){
                       $('#net_amount').val(<?php echo $rental_return->net_amount; ?>);
                   }
                   else{  
                       var deduction = $('#deduction').val();
                       net = parseFloat(Math.round((rent_charge - deduction)*100)/100).toFixed(3);
                       $('#net_amount').val(net);
                   }
                });
                
                /*$("#rental_return_date").datepicker({
                    dateFormat: 'dd/mm/yy',
                    onSelect: function(dateText) {
                        $(this).change();
                    }
                }).on("change", function() {
                       //display("Got change event from field");
                        // alert();
                        var start = $('#pickup_date').val();
                        var last = $('#rental_return_date').val();
                        var rental_id = '<?php echo $id; ?>';
                        var startDate = start.split('/');
                        var temp = startDate[1];
                        startDate[1] = startDate[0];
                        startDate[0] = temp;
                        
                        var endDate = last.split('/');
                        var temp1 = endDate[1];
                        endDate[1] = endDate[0];
                        endDate[0] = temp1;
                        //alert(temp+"/"+startDate[1]+"/"+startDate[2]);
                        var final_start = temp+"/"+startDate[1]+"/"+startDate[2];
                        var final_last = temp1+"/"+endDate[1]+"/"+endDate[2];
                        
                        var startDay = new Date(final_start);
                        var endDay = new Date(final_last);
                        var millisecondsPerDay = 1000 * 60 * 60 * 24;

                        var millisBetween = endDay.getTime() - startDay.getTime();
                        var days = millisBetween / millisecondsPerDay;

                        // Round down.
                        $('#total_rented_days').val(Math.floor(days));
                        $('#hidden_rented_days').val(Math.floor(days));
                        
                        $.ajax({
                                type: "post",
                                url: "<?php echo base_url(); ?>index.php/rentalreturn/scanDailyRent",
                                cache: false,				
                                // data: $('#userForm').serialize(),
                                data: {rental_id: rental_id, days:Math.floor(days)},
                                async:false,
                                success: function(json){
                                try{
                                    var obj = JSON.parse(json);
                                    console.log(json);
                                    $('#total_rent_charge').val(obj.rent_charge);
                                    //$('#rent_charge').val(obj.rent_charge);
                                    $('#rate_per_day').val(obj.rent_per_day);
                                }catch(e) {		
                                    alert('Exception while request..');
                                }		
                            },
                            error: function(){						
                                alert('Error while request..');
                            }
                        });
                        
                  });*/
                $('#rental_return_date').change(function(){
                    var start = $('#pickup_date').val();
                    var last = $('#rental_return_date').val();
                    var rental_id = '<?php echo $id; ?>';
                    var startDate = start.split('/');
                    var temp = startDate[1];
                    startDate[1] = startDate[0];
                    startDate[0] = temp;
                    
                    var endDate = last.split('/');
                    var temp1 = endDate[1];
                    endDate[1] = endDate[0];
                    endDate[0] = temp1;
                    //alert(temp+"/"+startDate[1]+"/"+startDate[2]);
                    var final_start = temp+"/"+startDate[1]+"/"+startDate[2];
                    var final_last = temp1+"/"+endDate[1]+"/"+endDate[2];
                    
                    var startDay = new Date(final_start);
                    var endDay = new Date(final_last);
                    var millisecondsPerDay = 1000 * 60 * 60 * 24;

                    var millisBetween = endDay.getTime() - startDay.getTime();
                    var days = millisBetween / millisecondsPerDay;

                    // Round down.
                    $('#total_rented_days').val(Math.floor(days));
                    $('#hidden_rented_days').val(Math.floor(days));
                    
                    $.ajax({
                            type: "post",
                            url: "<?php echo base_url(); ?>index.php/rentalreturn/scanDailyRent",
                            cache: false,				
                            // data: $('#userForm').serialize(),
                            data: {rental_id: rental_id, days:Math.floor(days)},
                            async:false,
                            success: function(json){
                            try{
                                var obj = JSON.parse(json);
                                console.log(json);
                                $('#total_rent_charge').val(obj.rent_charge);
                                //$('#rent_charge').val(obj.rent_charge);
                                $('#rate_per_day').val(obj.rent_per_day);
                            }catch(e) {		
                                alert('Exception while request..');
                            }		
                        },
                        error: function(){						
                            alert('Error while request..');
                        }
                    });
                });
                $("#km_in").change(function(){
                    var km_in = $('#km_in').val();
                    var km_out = '<?php echo $km_out->km_reading_out;?>';
                    var km_used = km_in - km_out;
                    $('#km_used').val(km_used);
                    var days = $('#total_rented_days').val();
                    var rental_id = '<?php echo $id; ?>';
                    
                    $.ajax({
                            type: "post",
                            url: "<?php echo base_url(); ?>index.php/rentalreturn/scanExtraKmUsed",
                            cache: false,				
                            // data: $('#userForm').serialize(),
                            data: {rental_id: rental_id, days: days, km_in: km_in, km_out: km_out, km_used: km_used},
                            async:false,
                            success: function(json){
                            try{
                                var obj = JSON.parse(json);
                                console.log(json);
                                var total_rent_charge = (obj.rent_charge).toFixed(3);
                                var net_payble = (parseFloat(obj.rent_charge) + parseFloat(obj.extra_km_rate_used)).toFixed(3);
                                $('#km_extra_used').val((obj.extra_km_used).toFixed(0));
                                $('#total_rent_charge').val(total_rent_charge);
                                //$('#rent_charge').val(total_rent_charge);
                                $('#km_extra_used_rate').val(obj.extra_km_rate_used);
                                $('#extra_rate').val(obj.extra_km_rate_used);
                                $('#net_amount').val(net_payble);
                            }catch(e) {		
                            alert('Exception while request..');
                            }		
                        },
                        error: function(){						
                            alert('Error while request..');
                        }
                    });
                    
                });
                  
                  
            });
            function calculateNetAmount()
            {
                var extra_km_rate_used = document.getElementById("km_extra_used_rate").value;
                var total_rent_charge = document.getElementById("total_rent_charge").value;
                var net_amount = document.getElementById("net_amount").value;
                // var rate_per_day = document.getElementById("rate_per_day").value;
                // var total_rented_days = document.getElementById("total_rented_days").value;
                // // alert(rate_per_day);
                // total_rent_charge = parseFloat(rate_per_day)*total_rented_days;
                // alert(total_rent_charge);
                var fuel_refil_charges = document.getElementById("fuel_refil_charges").value;
                var traffic_fine = document.getElementById("traffic_fine").value;
                var additional_driver_charge = document.getElementById("additional_driver_charge").value;
                var chauffer_charges = document.getElementById("chauffer_charges").value;
                var additional_insurance = document.getElementById("additional_insurance").value;
                var pai_charge = document.getElementById("pai_charge").value;
                var misc_charges = document.getElementById("misc_charges").value;
                var deduction = document.getElementById("deduction").value;
                
                var charges = parseFloat(extra_km_rate_used)+ +parseFloat(fuel_refil_charges) + +parseFloat(traffic_fine) + +parseFloat(additional_driver_charge) + +parseFloat(chauffer_charges) + +parseFloat(additional_insurance) + +parseFloat(pai_charge) + +parseFloat(misc_charges);
                
                var net = parseFloat(total_rent_charge)+ +parseFloat(charges)-parseFloat(deduction);
                var discount_type = document.getElementById("discount_type").value;
                
                var net_amount_payable;
                //alert(discount_type);
                if(discount_type == 0)
                {
                    var discount_percentage = document.getElementById("discount").value;
                    var discount_val = (parseFloat(total_rent_charge)*parseFloat(discount_percentage))/100;
                    var discount = net - discount_val;
                    net_amount_payable = parseFloat(net) - parseFloat(discount);
                    net = net - net_amount_payable;
                    //net_amount_payable =(parseFloat(total_rent_charge) - parseFloat(Math.round((net - discount)*100)/100)).toFixed(3) ;
                }else{
                    var discount = document.getElementById("discount").value;
                    net = parseFloat(Math.round((net - discount)*100)/100);
                }
                
                // alert(net);
                document.getElementById("net_amount").value = (net).toFixed(3);
            }
            
            function calculateNetAmount1(a)
            {
                // alert(a);
                var extra_km_rate_used = document.getElementById("km_extra_used_rate").value;
                var total_rent_charge = a;
                var fuel_refil_charges = document.getElementById("fuel_refil_charges").value;
                var traffic_fine = document.getElementById("traffic_fine").value;
                var additional_driver_charge = document.getElementById("additional_driver_charge").value;
                var chauffer_charges = document.getElementById("chauffer_charges").value;
                var additional_insurance = document.getElementById("additional_insurance").value;
                var pai_charge = document.getElementById("pai_charge").value;
                var misc_charges = document.getElementById("misc_charges").value;
                var deduction = document.getElementById("deduction").value;
                
                var charges = parseFloat(total_rent_charge) + +parseFloat(extra_km_rate_used)+ +parseFloat(fuel_refil_charges) + +parseFloat(traffic_fine) + +parseFloat(additional_driver_charge) + +parseFloat(chauffer_charges) + +parseFloat(additional_insurance) + +parseFloat(pai_charge) + +parseFloat(misc_charges);
                
                var net = parseFloat(charges)-parseFloat(deduction);
                
                var discount_type = document.getElementById("discount_type").value;
                
                var net_amount_payable;
                //alert(discount_type);
                if(discount_type == 0)
                {
                    var discount_percentage = document.getElementById("discount").value;
                    var discount_val = (parseFloat(total_rent_charge)*parseFloat(discount_percentage))/100;
                    var discount = net - discount_val;
                    net_amount_payable = parseFloat(net) - parseFloat(discount);
                    net = net - net_amount_payable;
                    //net_amount_payable =(parseFloat(total_rent_charge) - parseFloat(Math.round((net - discount)*100)/100)).toFixed(3) ;
                }else{
                    var discount = document.getElementById("discount").value;
                    net = parseFloat(Math.round((net - discount)*100)/100);
                }
                
                // alert(net);
                document.getElementById("net_amount").value = (net).toFixed(3);
            }
            
            function calculateNetAmount2(){
                var extra_km_rate_used = document.getElementById("km_extra_used_rate").value;
                var rate_per_day = document.getElementById("rate_per_day").value;
                var total_rented_days = document.getElementById("total_rented_days").value;
                
                var total_rent_charge = total_rented_days*parseFloat(rate_per_day);
                document.getElementById('total_rent_charge').value = (total_rent_charge).toFixed(3);
                var fuel_refil_charges = document.getElementById("fuel_refil_charges").value;
                var traffic_fine = document.getElementById("traffic_fine").value;
                var additional_driver_charge = document.getElementById("additional_driver_charge").value;
                var chauffer_charges = document.getElementById("chauffer_charges").value;
                var additional_insurance = document.getElementById("additional_insurance").value;
                var pai_charge = document.getElementById("pai_charge").value;
                var misc_charges = document.getElementById("misc_charges").value;
                var deduction = document.getElementById("deduction").value;
                
                var charges = parseFloat(total_rent_charge) + +parseFloat(extra_km_rate_used)+ +parseFloat(fuel_refil_charges) + +parseFloat(traffic_fine) + +parseFloat(additional_driver_charge) + +parseFloat(chauffer_charges) + +parseFloat(additional_insurance) + +parseFloat(pai_charge) + +parseFloat(misc_charges);
                
                var net = parseFloat(charges)-parseFloat(deduction);
                
                var discount_type = document.getElementById("discount_type").value;
                
                var net_amount_payable;
                //alert(discount_type);
                if(discount_type == 0)
                {
                    var discount_percentage = document.getElementById("discount").value;
                    var discount_val = (parseFloat(total_rent_charge)*parseFloat(discount_percentage))/100;
                    var discount = net - discount_val;
                    net_amount_payable = parseFloat(net) - parseFloat(discount);
                    net = net - net_amount_payable;
                    //net_amount_payable =(parseFloat(total_rent_charge) - parseFloat(Math.round((net - discount)*100)/100)).toFixed(3) ;
                }else{
                    var discount = document.getElementById("discount").value;
                    net = parseFloat(Math.round((net - discount)*100)/100);
                }
                
                // alert(net);
                document.getElementById("net_amount").value = (net).toFixed(3);
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
        <!-- page start-->
        <div class="row">
            <div class="col-lg-12">
                <section class="panel">
                    <header class="panel-heading">
                        <?php echo $page_title; ?>
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
                                        <label class="col-sm-2 control-label col-lg-4" for="pickup_date">PickUp Date <span style="color:red;">*</span></label>
                                        <div class="col-lg-8">
                                            <input class="form-control form-control-inline input-medium default-date-picker"  size="16" type="text" value="<?php echo $rental_return->pickup_date; ?>" id="pickup_date" placeholder="Select Date of Rental PickUp" name="pickup_date" disabled />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label col-lg-4" for="rental_return_date">Return Date <span style="color:red;">*</span></label>
                                        <div class="col-lg-8">
                                            <input class="form-control form_datetime"  size="16" type="text" value="<?php echo $rental_return->return_date; ?>" id="rental_return_date" placeholder="Select Date of Rental Return" name="rental_return_date" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label col-lg-4" for="km_in">KM In</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" placeholder="KM In" id="km_in" name="km_in" <?php echo $rental_return->km_in; ?>/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label col-lg-4" for="km_used">KM Used</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" placeholder="KM Used" value="<?php echo $rental_return->km_used; ?>" id="km_used" name="km_used">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label col-lg-4" for="km_extra_used">KM Extra Used</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" placeholder="KM Extra Used" value="<?php echo $rental_return->km_extra_used; ?>" id="km_extra_used" name="km_extra_used">
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
                                            <input type="text" class="form-control" placeholder="Total Rented Days" id="total_rented_days" name="total_rented_days" value="<?php echo $rental_return->total_rented_days; ?>" onkeyup="calculateNetAmount2();">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label col-lg-4" for="rate_per_day">Rate Per Day <span style="color:red;">*</span></label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" placeholder="Rate Per Day" id="rate_per_day" name="rate_per_day" value="<?php echo $rental_return->rate_per_day; ?>" onkeyup="calculateNetAmount2();">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label col-lg-4" for="total_rent_charge">Total Rent Charge</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" placeholder="Total Rent Charge" id="total_rent_charge" name="total_rent_charge" value="<?php echo $rental_return->total_rent_charges; ?>" onkeyup="calculateNetAmount1(this.value);" >
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label col-lg-4" for="fuel_level">Fuel Level</label>
                                        <div class="col-lg-8">
                                            <select class="form-control" id="fuel_level" name="fuel_level">
                                                <option value="Quarter"> Quarter</option>
                                                <option value="LT Quarter"> < Quarter</option>
                                                <option value="GT Quarter"> > Quarter</option>
                                                <option value="Half">Half</option>
                                                <option value="LT Half"> > Half</option>
                                                <option value="GT Half"> > Half</option>
                                                <option value="3 Quarter">3 Quarter</option>
                                                <option value="LT 3 Quarter"> < 3 Quarter</option>
                                                <option value="GT 3 Quarter"> > 3 Quarter</option>
                                                <option value="Full">Full</option>
                                                <option value="LT Full"> < Full </option>
                                                <option value="GT Full"> > Full </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label  class="col-lg-4 col-sm-3 control-label" for="fuel_refil_charges">Fuel Refil Charges</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" placeholder="Fuel Refil Charges" id="fuel_refil_charges" name="fuel_refil_charges" value="<?php echo $rental_return->fuel_refil_charges; ?>" onkeyup="calculateNetAmount(this.value)">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label  class="col-lg-4 col-sm-3 control-label" for="traffic_fine">Traffic Fine</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" placeholder="Traffic Fine" id="traffic_fine" name="traffic_fine" value="<?php echo $rental_return->traffic_fine; ?>" onkeyup="calculateNetAmount(this.value)">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label  class="col-lg-4 col-sm-3 control-label" for="additional_driver_charge">Additional Driver Charge</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" placeholder="Additional Driver Charge" id="additional_driver_charge" name="additional_driver_charge" value="<?php echo $rental_return->additional_driver_charges; ?>" onkeyup="calculateNetAmount(this.value)">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="panel-body">
                                    <div class="form-group">
                                        <label  class="col-lg-4 col-sm-3 control-label" for="chauffer_charges">Chauffer charges</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" placeholder="Chauffer charges" id="chauffer_charges" name="chauffer_charges" value="<?php echo $rental_return->chauffer_charges; ?>" onkeyup="calculateNetAmount(this.value)">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label  class="col-lg-4 col-sm-3 control-label" for="additional_insurance">Additional insurance</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" placeholder="Additional insurance" id="additional_insurance" name="additional_insurance" value="<?php echo $rental_return->additional_insurance; ?>" onkeyup="calculateNetAmount(this.value)">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label  class="col-lg-4 col-sm-3 control-label" for="pai_charge">PAI Charge</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" placeholder="PAI Charge" id="pai_charge" name="pai_charge" value="<?php echo $rental_return->pai_charges; ?>" onkeyup="calculateNetAmount(this.value)">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label  class="col-lg-4 col-sm-3 control-label" for="misc_charges">Miscellaneous Charges</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" placeholder="Miscellaneous Charges" id="misc_charges" name="misc_charges" value="<?php echo $rental_return->misc_charges; ?>" onkeyup="calculateNetAmount(this.value)">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label  class="col-lg-4 col-sm-3 control-label" for="deduction">Deduction</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" placeholder="Deductions" id="deduction" name="deduction" onkeyup="calculateNetAmount(this.value)" value=<?php echo $deduction;?>>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label  class="col-lg-4 col-sm-3 control-label" for="discount_type">Discount Type</label>
                                        <div class="col-lg-8">
                                            <select class="form-control" id="discount_type" name="discount_type">
                                                <option value="1" <?php if($rental_return->discount_type == 1){?>selected<?php } ?>> Discount By Amount</option>
                                                <option value="0" <?php if($rental_return->discount_type == 0){?>selected<?php } ?>>Discount By Percentage</option>
                                            </select>
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
                                            } ?>" onkeyup="calculateNetAmount();">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label  class="col-lg-4 col-sm-3 control-label" for="invoice_no">Invoice No</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" placeholder="Invoice No" id="invoice_no" name="invoice_no" value="<?php echo $rental_return->invoice_no; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label col-lg-4" for="invoice_date">Invoice Date</label>
                                        <div class="col-lg-8">
                                            <input class="form-control form-control-inline input-medium default-date-picker"  size="16" type="text" id="invoice_date" placeholder="Select Invoice Date" name="invoice_date" value="<?php echo $rental_return->invoice_date; ?>"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label col-lg-4" for="invoice_status">Invoice Status</label>
                                        <div class="col-lg-8">
                                            <select class="form-control" id="invoice_status" name="invoice_status">
                                                <option>Paid</option>
                                                <option> Invoiced</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label  class="col-lg-4 col-sm-3 control-label" for="gps_km">GPS KM</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" placeholder="GPS KM" id="gps_km" name="gps_km" value="<?php echo $rental_return->gps_km; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label  class="col-lg-4 col-sm-3 control-label" for="actual_km">Actual KM</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" placeholder="Actual KM" id="actual_km" name="actual_km" value="<?php echo $rental_return->actual_km; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label  class="col-lg-4 col-sm-3 control-label" for="total_km">Total KM</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" placeholder="Total KM" id="total_km" name="total_km" value="<?php echo $rental_return->total_km; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label  class="col-lg-4 col-sm-3 control-label" for="net_amount">Net Amount Payable</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" placeholder="Net Amount Payable" id="net_amount" name="net_amount" value="">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label  class="col-lg-4 col-sm-3 control-label" for="remarks">Remarks</label>
                                        <div class="col-lg-8">
                                            <textarea class="form-control" id="remarks" name="remarks"></textarea>
                                        </div>
                                    </div>
                                    <!--<input type="hidden" value="<?php echo $rental_return->total_rent_charges; ?>" name="rent_charge" id="rent_charge"/>-->
                                    <!--<input type="hidden" value="<?php echo $rental_return->total_rented_days; ?>" name="rented_days" id="hidden_rented_days"/>-->
                                    <input type="hidden" value="<?php echo $rental_return->pickup_date; ?>" name="pickUP_date" />
                                    <input type="hidden" value="<?php echo $rental_return->rate_per_day; ?>" name="per_day_rate" />
                                    <input type="hidden" name="extra_km_rate" id="extra_rate"/>
                                </div>
                            </div>
                        </div>
                        <div class="panel-body">
                            <p>
                                <button class="btn btn-primary" type="submit" id="submit" onclick="return confirm('Are you sure?');">Submit</button>
                                <a href="<?php echo base_url(); ?>index.php/rentalreturn" class="btn btn-default" type="button">Cancel</a>
                            </p>
                        </div>
                    </form>
                    
                </section>
            </div>
        </div>
        <!-- main content end-->
    </section>
    
        <!--pickers plugins-->
        <!--<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>-->
        <!--<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js"></script>-->
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js"></script>
        <!--<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootstrap-daterangepicker/moment.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootstrap-daterangepicker/daterangepicker.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootstrap-timepicker/js/bootstrap-timepicker.js"></script>-->
        
        <!--pickers initialization-->
        <script src="<?php echo base_url(); ?>assets/js/pickers-init.js"></script>