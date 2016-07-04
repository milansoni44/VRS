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
                    <form class="form-horizontal" role="form" method="post" action="add" enctype= "multipart/form-data">
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
                                                        echo "<option value='$name[id]' " . set_select('branch', $name['id']) . " >". $name['branch_name']."</option>";
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                        
                                    </div>
                                    <div class="form-group">
                                        <label  class="col-lg-4 col-sm-3 control-label" for="customer_name">Name <span style="color:red;">*</span></label>
                                        <div class="col-lg-4">
                                            <input type="text" class="form-control" placeholder="Customer Name" id="customer_name" name="en_name" value="<?php echo set_value('en_name'); ?>">
                                        </div>
                                        <div class="col-lg-4">
                                            <input type="text" class="form-control" placeholder="Customer Name" id="customer_name" name="ar_name" value="<?php echo set_value('ar_name'); ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label  class="col-lg-4 col-sm-3 control-label" for="nationality_code">Nationality Code</label>
                                        <div class="col-lg-4">
                                            <input type="text" class="form-control" placeholder="Nationality Code" id="nationality_code" name="en_nationality_code" value="<?php echo set_value('en_nationality_code'); ?>">
                                        </div>
                                        <div class="col-lg-4">
                                            <input type="text" class="form-control" placeholder="Nationality Code" id="nationality_code" name="ar_nationality_code" value="<?php echo set_value('ar_nationality_code'); ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label  class="col-lg-4 col-sm-3 control-label" for="txt_passport_no">Passport No.</label>
                                        <div class="col-lg-4">
                                            <input type="text" class="form-control" placeholder="Passport No" id="txt_passport_no" name="en_passport_no" value="<?php echo set_value('en_passport_no'); ?>">
                                        </div>
                                        <div class="col-lg-4">
                                            <input type="text" class="form-control" placeholder="Passport No" id="txt_passport_no" name="ar_passport_no" value="<?php echo set_value('ar_passport_no'); ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label  class="col-lg-4 col-sm-3 control-label" for="txt_passport_place_issue">Passport - Place of Issue</label>
                                        <div class="col-lg-4">
                                            <input type="text" class="form-control" placeholder="Passport Place Issue" id="txt_passport_place_issue" name="en_place_issue" value="<?php echo set_value('en_place_issue'); ?>">
                                        </div>
                                        <div class="col-lg-4">
                                            <input type="text" class="form-control" placeholder="Passport Place Issue" id="txt_passport_place_issue" name="ar_place_issue" value="<?php echo set_value('ar_place_issue'); ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-4" for="passport_date_issue">Passport  - Date of Issue</label>
                                        <div class="col-md-4 col-xs-11">
                                            <input class="form-control form-control-inline input-medium default-date-picker"  size="16" type="text" id="passport_date_issue" placeholder="Select Passport Date Issue" name="en_date_issue" value="<?php echo set_value('en_date_issue'); ?>"/>
                                        </div>
                                        <div class="col-md-4 col-xs-11">
                                            <input class="form-control form-control-inline input-medium default-date-picker"  size="16" type="text" id="passport_date_issue" placeholder="Select Passport Date Issue" name="ar_date_issue" value="<?php echo set_value('ar_date_issue'); ?>"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-4" for="passport_date_expire">Passport - Date of Expiry</label>
                                        <div class="col-md-4 col-xs-11">
                                            <input class="form-control form-control-inline input-medium default-date-picker"  size="16" type="text" id="passport_date_expire" placeholder="Select Passport Date of Expiry" name="en_date_expiry" value="<?php echo set_value('en_date_expiry'); ?>"/>
                                        </div>
                                        <div class="col-md-4 col-xs-11">
                                            <input class="form-control form-control-inline input-medium default-date-picker"  size="16" type="text" value="" id="passport_date_expire" placeholder="Select Passport Date of Expiry" name="ar_date_expiry" value="<?php echo set_value('ar_date_expiry'); ?>"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label  class="col-lg-4 col-sm-3 control-label" for="txt_national_id">National ID / Resident Card No</label>
                                        <div class="col-lg-4">
                                            <input type="text" class="form-control" placeholder="National Id / Resident Card No" id="txt_national_id" name="en_national_id" value="<?php echo set_value('en_national_id'); ?>">
                                        </div>
                                        <div class="col-lg-4">
                                            <input type="text" class="form-control" placeholder="National Id / Resident Card No" id="txt_national_id" name="ar_national_id" value="<?php echo set_value('ar_national_id'); ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-4" for="id_date_of_expiry">ID - Date of Expiry</label>
                                        <div class="col-md-4 col-xs-11">
                                            <input class="form-control form-control-inline input-medium default-date-picker"  size="16" type="text" id="id_date_of_expiry" placeholder="Select Passport Date of Expiry" name="en_id_date_expiry" value="<?php echo set_value('en_id_date_expiry'); ?>"/>
                                        </div>
                                        <div class="col-md-4 col-xs-11">
                                            <input class="form-control form-control-inline input-medium default-date-picker"  size="16" type="text" id="id_date_of_expiry" placeholder="Select Passport Date of Expiry" name="ar_id_date_expiry" value="<?php echo set_value('ar_id_date_expiry'); ?>"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label  class="col-lg-4 col-sm-3 control-label" for="txt_local_address">Local Address</label>
                                        <div class="col-lg-4">
                                            <input type="text" class="form-control" placeholder="Local Address" id="txt_local_address" name="en_local_address" value="<?php echo set_value('en_local_address'); ?>">
                                        </div>
                                        <div class="col-lg-4">
                                            <input type="text" class="form-control" placeholder="Local Address" id="txt_local_address" name="ar_local_address" value="<?php echo set_value('ar_local_address'); ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label  class="col-lg-4 col-sm-3 control-label" for="txt_company_name">Company Name</label>
                                        <div class="col-lg-4">
                                            <input type="text" class="form-control" placeholder="Company Name" id="txt_company_name" name="en_company_name" value="<?php echo set_value('en_company_name'); ?>">
                                        </div>
                                        <div class="col-lg-4">
                                            <input type="text" class="form-control" placeholder="Company Name" id="txt_company_name" name="ar_company_name" value="<?php echo set_value('ar_company_name'); ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label  class="col-lg-4 col-sm-3 control-label" for="txt_mailing_address">Mailing Address</label>
                                        <div class="col-lg-4">
                                            <input type="text" class="form-control" placeholder="Mailing Address" id="txt_mailing_address" name="en_mailing_address" value="<?php echo set_value('en_mailing_address'); ?>">
                                        </div>
                                        <div class="col-lg-4">
                                            <input type="text" class="form-control" placeholder="Mailing Address" id="txt_mailing_address" name="ar_mailing_address" value="<?php echo set_value('ar_mailing_address'); ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="panel-body">
                                    <div class="form-group">
                                        <label  class="col-lg-4 col-sm-3 control-label" for="txt_telephone_no">Telephone No</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" placeholder="Telephone No" id="txt_telephone_no" name="telephone" value="<?php echo set_value('telephone'); ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label  class="col-lg-4 col-sm-3 control-label" for="txt_mobile_no">Mobile No</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" placeholder="Mobile No" id="txt_mobile_no" name="mobile_no" value="<?php echo set_value('mobile_no'); ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label  class="col-lg-4 col-sm-3 control-label" for="txt_email">Email</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" placeholder="Email" id="txt_email" name="email" value="<?php echo set_value('email'); ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label  class="col-lg-4 col-sm-3 control-label" for="txt_reference_person_name">Reference Person Name</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" placeholder="Reference Person Name" id="txt_reference_person_name" name="reference_person_name" value="<?php echo set_value('reference_person_name'); ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label  class="col-lg-4 col-sm-3 control-label" for="txt_reference_person_mobile">Reference Person Mobile</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" placeholder="Reference Person Mobile" id="txt_reference_person_mobile" name="reference_person_mobile" value="<?php echo set_value('reference_person_mobile'); ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label col-lg-4" for="pass_img">Passport Image</label>
                                        <input type="file" id="pass_img" name="passport_img">
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label col-lg-4" for="national_id_image">National ID Image</label>
                                        <input type="file" id="national_id_image" name="national_id_img">
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label col-lg-4" for="driving_lecence_image">Driving Licence Image</label>
                                        <input type="file" id="driving_lecence_image" name="driving_licence_img">
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label col-lg-4" for="customer_photo">Customer Photo</label>
                                        <input type="file" id="customer_photo" name="customer_img">
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label col-lg-4" for="reference_source_field">Reference Scource</label>
                                        <div class="col-lg-8">
                                            <select class="form-control" id="reference_source_field" name="reference_source_field">
                                                <option value="0">-- Select --</option>
                                                <option value="Mouth">Mouth</option>
                                                <option value="News Paper">News Paper</option>
                                                <option value="Website">Website</option>
                                                <option value="Others">Others</option>
                                                <option value="Others">Facebook</option>
                                                <option value="Others">Twiiter</option>
                                                <option value="Others">Whatsapp</option>
                                                <option value="Others">SMS</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel-body">
                            <p>
                                <button class="btn btn-primary" type="submit">Submit</button>
                                <a href="<?php echo base_url(); ?>index.php/customer" class="btn btn-default" type="button">Cancel</a>
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
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootstrap-daterangepicker/moment.min.js"></script>
        <!--<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootstrap-daterangepicker/daterangepicker.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootstrap-timepicker/js/bootstrap-timepicker.js"></script>-->
        
        <!--pickers initialization-->
        <script src="<?php echo base_url(); ?>assets/js/pickers-init.js"></script>