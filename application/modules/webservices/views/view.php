        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/js/bootstrap-datepicker/css/datepicker-custom.css" />
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/choosen/prism.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/choosen/chosen.css">
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
                            <a class="custom-button" href="<?php echo base_url(); ?>index.php/vehicleservice/edit/<?php echo $id; ?>"> Edit Vehicle Service</a>
                        </span>
                    </header>
                    <form class="form-horizontal" role="form" method="post" action="../edit/<?php echo $id; ?>">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="panel-body">
                                    <div class="form-group">
                                        <label  class="col-lg-4 col-sm-3 control-label" for="service_no">Service Id</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" id="service_no" name="service_no" value="<?php echo $id; ?>" disabled >
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label col-lg-4" for="branch">Branch</label>
                                        <div class="col-lg-8">
                                            <input class="form-control"  size="16" type="text" id="branch" name="branch" value="<?php echo $vehicle_service->branch_name; ?>" disabled />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label col-lg-4" for="vehicle_no">Vehicle</label>
                                        <div class="col-lg-8">
                                            <input class="form-control"  size="16" type="text" id="vehicle_no" name="vehicle_no" value="<?php echo $vehicle_service->vehicle_reg_no." ".$vehicle_service->brand; ?>" disabled />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label col-lg-4" for="date_service">Date of Service</label>
                                        <div class="col-lg-8">
                                            <input class="form-control form-control-inline input-medium default-date-picker"  size="16" type="text" id="date_service" name="date_service" placeholder="Select Date of Service" value="<?php echo $vehicle_service->date_service; ?>" disabled />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label col-lg-4" for="service_type">Service Type</label>
                                        <div class="col-lg-8">
                                            <input class="form-control"  size="16" type="text" id="service_type" name="service_type" value="<?php echo $vehicle_service->service_type; ?>" disabled />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label  class="col-lg-4 col-sm-3 control-label" for="service_required">Service Required</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" placeholder="Service Required" id="service_required" name="service_required" value="<?php echo $vehicle_service->service_required; ?>" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label  class="col-lg-4 col-sm-3 control-label" for="km_at_service">KM at Service</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" placeholder="KM at Service" id="km_at_service" name="km_at_service" value="<?php echo $vehicle_service->km_at_service; ?>" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label  class="col-lg-4 col-sm-3 control-label" for="voucher_date">Voucher Date</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" placeholder="Voucher Date" id="voucher_date" name="voucher_date" value="<?php echo $vehicle_service->voucher_date; ?>" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label col-lg-4" for="garage">Garage</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" placeholder="Garage" id="garage" name="garage" value="<?php echo $vehicle_service->garage_name; ?>" disabled>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="panel-body">
                                    <div class="form-group">
                                        <label  class="col-lg-4 col-sm-3 control-label" for="service_done">Service Done</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" placeholder="Service Done" id="service_done" name="service_done" value="<?php echo $vehicle_service->service_done; ?>" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label  class="col-lg-4 col-sm-3 control-label" for="service_amount">Service Amount</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" placeholder="Service Amount" id="service_amount" name="service_amount" value="<?php echo $vehicle_service->service_amount; ?>" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label  class="col-lg-4 col-sm-3 control-label" for="sparepart_dealer_charges">Spare part Dealer Charge</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" placeholder="Spare part Dealer Charge" id="sparepart_dealer_charges" name="sparepart_dealer_charges" value="<?php echo $vehicle_service->sparepart_dealer_charges; ?>" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label  class="col-lg-4 col-sm-3 control-label" for="sparepart_shop_charges">Spare part Shop Charge</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" placeholder="Spare part Shop Charge" id="sparepart_shop_charges" name="sparepart_shop_charges" value="<?php echo $vehicle_service->sparepart_shop_charges; ?>" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label  class="col-lg-4 col-sm-3 control-label" for="labour_charges">Labour Charges</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" placeholder="Labour Charges" id="labour_charges" name="labour_charges" value="<?php echo $vehicle_service->labour_charges; ?>" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label col-lg-4" for="date_serviceout">Date of ServiceOut</label>
                                        <div class="col-lg-8">
                                            <input class="form-control form-control-inline input-medium default-date-picker"  size="16" type="text" id="date_service" name="date_serviceout" placeholder="Select Date of Service Out" value="<?php echo $vehicle_service->date_serviceout; ?>" disabled />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label  class="col-lg-4 col-sm-3 control-label" for="washing_charge">Magic Touch Washing Charge</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" placeholder="Magic Touch Washing Charge" id="washing_charge" name="washing_charge" value="<?php echo $vehicle_service->washing_charge; ?>" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label  class="col-lg-4 col-sm-3 control-label" for="observation">Observation</label>
                                        <div class="col-lg-8">
                                            <textarea rows="4" id="observation" name="observation" class="form-control" disabled ><?php echo $vehicle_service->observation; ?></textarea>
                                        </div>
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