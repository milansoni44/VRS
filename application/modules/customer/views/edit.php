        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/js/bootstrap-datepicker/css/datepicker-custom.css" />
        <script type="text/javascript">
            $(document).ready(function(){
                // $('.image').css("display","none"); 
                // $('.inputfile').css("display","none"); 
                $(".input-passport-image").hide();
                $(".input-national-id-image").hide();
                $(".input-driving-licence-image").hide();
                $(".input-customer-image").hide();
                $(".edit-customer-image").hide();
                /*==============for customer image ===================*/
                <?php 
                    if($customer->customer_img != null)
                    {
                ?>
                        $(".input-customer-image").hide();
                        $(".edit-customer-image").show();
                <?php
                    }
                    else
                    {
                ?>
                        $(".input-customer-image").show();
                        $(".edit-customer-image").hide();
                <?php
                    }
                ?>
                $('#cancelCustomerImg').click(function(){
                    $(".input-customer-image").show();
                    $(".edit-customer-image").hide();
                    $('#customer_edit').attr('value', '');  
                });
                /*====================================================*/
                
                /*==============for driving licence image ===================*/
                <?php 
                    if($customer->driving_licence_img != null)
                    {
                ?>
                        $(".input-driving-licence-image").hide();
                        $(".edit-driving-lecence-image").show();
                <?php
                    }
                    else
                    {
                ?>
                        $(".input-driving-licence-image").show();
                        $(".edit-driving-lecence-image").hide();
                <?php
                    }
                ?>
                $('#cancelDrivingImg').click(function(){
                    $(".input-driving-licence-image").show();
                    $(".edit-driving-lecence-image").hide();
                    $('#driving_licence_edit').attr('value', '');  
                });
                /*====================================================*/
                
                /*==============for national id image ===================*/
                <?php 
                    if($customer->national_id_img != null)
                    {
                ?>
                        $(".input-national-id-image").hide();
                        $(".edit-national-id-image").show();
                <?php
                    }
                    else
                    {
                ?>
                        $(".input-national-id-image").show();
                        $(".edit-national-id-image").hide();
                <?php
                    }
                ?>
                $('#cancelNationalIdImg').click(function(){
                    $(".input-national-id-image").show();
                    $(".edit-national-id-image").hide();
                    $('#national_id_edit').attr('value', '');  
                });
                /*====================================================*/
                
                /*==============for Passport image ===================*/
                <?php 
                    if($customer->passport_img != null)
                    {
                ?>
                        $(".input-passport-image").hide();
                        $(".edit-passport-image").show();
                <?php
                    }
                    else
                    {
                ?>
                        $(".input-passport-image").show();
                        $(".edit-passport-image").hide();
                <?php
                    }
                ?>
                $('#cancelPassportIdImg').click(function(){
                    $(".input-passport-image").show();
                    $(".edit-passport-image").hide();
                    $('#passport_edit').attr('value', '');  
                });
                /*====================================================*/
            });
        </script>
        <!-- page heading start-->
        <div class="page-heading">
            <h3>
                <?php echo $page_title; ?>
            </h3>
            <ul class="breadcrumb">
                <li>
                    <a href="<?php echo base_url(); ?>">Home</a>
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
                    <form class="form-horizontal" role="form" method="post" action="../edit/<?php echo $id; ?>" enctype= "multipart/form-data">
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
                                                        <option <?php if($customer->branch_id == $name['id']) { ?>selected <?php } ?> value=<?php echo $name['id']; ?>><?php echo $name['branch_name']; ?></option>
                                                <?php
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                        
                                    </div>
                                    <div class="form-group">
                                        <label  class="col-lg-4 col-sm-3 control-label" for="customer_name">Name <span style="color:red;">*</span></label>
                                        <div class="col-lg-4">
                                            <input type="text" class="form-control" placeholder="Customer Name" id="customer_name" name="en_name" value="<?php echo $customer->en_name; ?>">
                                        </div>
                                        <div class="col-lg-4">
                                            <input type="text" class="form-control" placeholder="Customer Name" id="customer_name" name="ar_name" value="<?php echo $customer->ar_name; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label  class="col-lg-4 col-sm-3 control-label" for="nationality_code">Nationality Code</label>
                                        <div class="col-lg-4">
                                            <input type="text" class="form-control" placeholder="Nationality Code" id="nationality_code" name="en_nationality_code" value="<?php echo $customer->en_nationality_code; ?>">
                                        </div>
                                        <div class="col-lg-4">
                                            <input type="text" class="form-control" placeholder="Nationality Code" id="nationality_code" name="ar_nationality_code" value="<?php echo $customer->ar_nationality_code; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label  class="col-lg-4 col-sm-3 control-label" for="txt_passport_no">Passport No.</label>
                                        <div class="col-lg-4">
                                            <input type="text" class="form-control" placeholder="Passport No" id="txt_passport_no" name="en_passport_no" value="<?php echo $customer->en_passport_no; ?>">
                                        </div>
                                        <div class="col-lg-4">
                                            <input type="text" class="form-control" placeholder="Passport No" id="txt_passport_no" name="ar_passport_no" value="<?php echo $customer->ar_passport_no; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label  class="col-lg-4 col-sm-3 control-label" for="txt_passport_place_issue">Passport - Place of Issue</label>
                                        <div class="col-lg-4">
                                            <input type="text" class="form-control" placeholder="Passport Place Issue" id="txt_passport_place_issue" name="en_place_issue" value="<?php echo $customer->en_place_issue; ?>">
                                        </div>
                                        <div class="col-lg-4">
                                            <input type="text" class="form-control" placeholder="Passport Place Issue" id="txt_passport_place_issue" name="ar_place_issue" value="<?php echo $customer->ar_place_issue; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-4" for="passport_date_issue">Passport  - Date of Issue</label>
                                        <div class="col-md-4 col-xs-11">
                                            <input class="form-control form-control-inline input-medium default-date-picker"  size="16" type="text" id="passport_date_issue" placeholder="Select Passport Date Issue" name="en_date_issue" value="<?php echo $customer->en_date_issue; ?>"/>
                                        </div>
                                        <div class="col-md-4 col-xs-11">
                                            <input class="form-control form-control-inline input-medium default-date-picker"  size="16" type="text" id="passport_date_issue" placeholder="Select Passport Date Issue" name="ar_date_issue" value="<?php echo $customer->ar_date_issue; ?>"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-4" for="passport_date_expire">Passport - Date of Expiry</label>
                                        <div class="col-md-4 col-xs-11">
                                            <input class="form-control form-control-inline input-medium default-date-picker"  size="16" type="text" id="passport_date_expire" placeholder="Select Passport Date of Expiry" name="en_date_expiry" value="<?php echo $customer->en_date_expiry; ?>"/>
                                        </div>
                                        <div class="col-md-4 col-xs-11">
                                            <input class="form-control form-control-inline input-medium default-date-picker"  size="16" type="text" id="passport_date_expire" placeholder="Select Passport Date of Expiry" name="ar_date_expiry" value="<?php echo $customer->ar_date_expiry; ?>"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label  class="col-lg-4 col-sm-3 control-label" for="txt_national_id">National ID / Resident Card No</label>
                                        <div class="col-lg-4">
                                            <input type="text" class="form-control" placeholder="National Id / Resident Card No" id="txt_national_id" name="en_national_id" value="<?php echo $customer->en_national_id; ?>">
                                        </div>
                                        <div class="col-lg-4">
                                            <input type="text" class="form-control" placeholder="National Id / Resident Card No" id="txt_national_id" name="ar_national_id" value="<?php echo $customer->ar_national_id; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-4" for="id_date_of_expiry">ID - Date of Expiry</label>
                                        <div class="col-md-4 col-xs-11">
                                            <input class="form-control form-control-inline input-medium default-date-picker"  size="16" type="text" id="id_date_of_expiry" placeholder="Select Passport Date of Expiry" name="en_id_date_expiry" value="<?php echo $customer->en_id_date_expiry; ?>"/>
                                        </div>
                                        <div class="col-md-4 col-xs-11">
                                            <input class="form-control form-control-inline input-medium default-date-picker"  size="16" type="text" id="id_date_of_expiry" placeholder="Select Passport Date of Expiry" name="ar_id_date_expiry" value="<?php echo $customer->ar_id_date_expiry; ?>"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label  class="col-lg-4 col-sm-3 control-label" for="txt_local_address">Local Address</label>
                                        <div class="col-lg-4">
                                            <input type="text" class="form-control" placeholder="Local Address" id="txt_local_address" name="en_local_address" value="<?php echo $customer->en_local_address; ?>">
                                        </div>
                                        <div class="col-lg-4">
                                            <input type="text" class="form-control" placeholder="Local Address" id="txt_local_address" name="ar_local_address" value="<?php echo $customer->ar_local_address; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label  class="col-lg-4 col-sm-3 control-label" for="txt_company_name">Company Name</label>
                                        <div class="col-lg-4">
                                            <input type="text" class="form-control" placeholder="Company Name" id="txt_company_name" name="en_company_name" value="<?php echo $customer->en_company_name; ?>">
                                        </div>
                                        <div class="col-lg-4">
                                            <input type="text" class="form-control" placeholder="Company Name" id="txt_company_name" name="ar_company_name" value="<?php echo $customer->ar_company_name; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label  class="col-lg-4 col-sm-3 control-label" for="txt_mailing_address">Mailing Address</label>
                                        <div class="col-lg-4">
                                            <input type="text" class="form-control" placeholder="Mailing Address" id="txt_mailing_address" name="en_mailing_address" value="<?php echo $customer->en_mailing_address; ?>">
                                        </div>
                                        <div class="col-lg-4">
                                            <input type="text" class="form-control" placeholder="Mailing Address" id="txt_mailing_address" name="ar_mailing_address" value="<?php echo $customer->ar_mailing_address; ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="panel-body">
                                    <div class="form-group">
                                        <label  class="col-lg-4 col-sm-3 control-label" for="txt_telephone_no">Telephone No</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" placeholder="Telephone No" id="txt_telephone_no" name="telephone" value="<?php echo $customer->telephone; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label  class="col-lg-4 col-sm-3 control-label" for="txt_mobile_no">Mobile No</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" placeholder="Mobile No" id="txt_mobile_no" name="mobile_no" value="<?php echo $customer->mobile_no; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label  class="col-lg-4 col-sm-3 control-label" for="txt_email">Email</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" placeholder="Email" id="txt_email" name="email" value="<?php echo $customer->email; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label  class="col-lg-4 col-sm-3 control-label" for="txt_reference_person_name">Reference Person Name</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" placeholder="Reference Person Name" id="txt_reference_person_name" name="reference_person_name" value="<?php echo $customer->reference_person_name; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label  class="col-lg-4 col-sm-3 control-label" for="txt_reference_person_mobile">Reference Person Mobile</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" placeholder="Reference Person Mobile" id="txt_reference_person_mobile" name="reference_person_mobile" value="<?php echo $customer->reference_person_mobile; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label col-lg-4" for="pass_img">Passport Image</label>
                                        <div class="input-passport-image">
                                        <input type="file" id="pass_img" name="passport_img" style="float:left;">
                                        </div>
                                        <div class="edit-passport-image">
                                        <span style="float:left"><img src="<?php echo base_url()."assets/uploads/passports/".$customer->passport_img ?>" alt="" width="50"/><i class="fa fa-edit" id="cancelPassportIdImg" style="padding-left:250px;"></i></span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label col-lg-4" for="national_id_image">National ID Image</label>
                                        <div class="input-national-id-image">
                                        <input type="file" id="national_id_image" name="national_id_img" style="float:left;">
                                        </div>
                                        <div class="edit-national-id-image">
                                            <span style="float:left"><img src="<?php echo base_url()."assets/uploads/national_ids/".$customer->national_id_img ?>" alt="" width="50"/><i class="fa fa-edit" id="cancelNationalIdImg" style="padding-left:250px;"></i></span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label col-lg-4" for="driving_lecence_image">Driving Licence Image</label>
                                        <div class="input-driving-licence-image">
                                        <input type="file" id="driving_lecence_image" name="driving_licence_img" style="float:left;">
                                        </div>
                                        <div class="edit-driving-lecence-image"> 
                                            <span style="float:left"><img src="<?php echo base_url()."assets/uploads/driving_licences/".$customer->driving_licence_img ?>" alt="" width="50"/><i class="fa fa-edit" id="cancelDrivingImg" style="padding-left:250px;"></i></span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        
                                        <label class="col-sm-2 control-label col-lg-4" for="customer_photo">Customer Photo</label>
                                        <div class="input-customer-image">
                                        <input type="file" id="customer_photo" name="customer_img" style="float:left;">
                                        </div>
                                        <div class="edit-customer-image">
                                            <span style="float:left"><img src="<?php echo base_url()."assets/uploads/customers/".$customer->customer_img ?>" alt="" width="50"/> <i class="fa fa-edit" id="cancelCustomerImg" style="padding-left:250px;"></i></span>
                                        </div>
                                        
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label col-lg-4" for="txt_reference_source">Reference Scource</label>
                                        <div class="col-lg-8">
                                            <select class="form-control" id="txt_reference_source" name="reference_source_field">
                                                <option value="0">-- Select --</option>
                                                <option <?php if($customer->reference_source_field=="Mouth") {?>selected <?php } ?>value="Mouth">Mouth</option>
                                                <option <?php if($customer->reference_source_field=="News Paper") {?>selected <?php } ?> value="News Paper">News Paper</option>
                                                <option <?php if($customer->reference_source_field=="Website") {?>selected <?php } ?> value="Website">Website</option>
                                                <option <?php if($customer->reference_source_field=="Others") {?>selected <?php } ?> value="Others">Others</option>
                                                <option <?php if($customer->reference_source_field=="Facebook") {?>selected <?php } ?> value="Facebook">Facebook</option>
                                                <option <?php if($customer->reference_source_field=="Twiiter") {?>selected <?php } ?> value="Twiiter">Twiiter</option>
                                                <option <?php if($customer->reference_source_field=="Whatsapp") {?>selected <?php } ?> value="Whatsapp">Whatsapp</option>
                                                <option <?php if($customer->reference_source_field=="SMS") {?>selected <?php } ?> value="SMS">SMS</option>
                                            </select>
                                        </div>
                                    </div>
                                    <input type="hidden" id="passport_edit" name="passport_edit" value="<?php echo $customer->passport_img; ?>" />
                                    <input type="hidden" id="national_id_edit" name="national_id_edit" value="<?php echo $customer->national_id_img; ?>" />
                                    <input type="hidden" id="driving_licence_edit" name="driving_licence_edit" value="<?php echo $customer->driving_licence_img; ?>" />
                                    <input type="hidden" id="customer_edit" name="customer_edit" value="<?php echo $customer->customer_img; ?>" />
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
        <!--<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootstrap-daterangepicker/moment.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootstrap-daterangepicker/daterangepicker.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootstrap-timepicker/js/bootstrap-timepicker.js"></script>-->
        
        <!--pickers initialization-->
        <script src="<?php echo base_url(); ?>assets/js/pickers-init.js"></script>