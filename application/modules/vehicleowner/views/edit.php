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
            <div class="col-lg-7">
                <section class="panel">
                    <header class="panel-heading">
                        <?php echo $page_title; ?> Form
                    </header>
                    <div class="panel-body">
                        <form class="form-horizontal" role="form" method="post" action="../edit/<?php echo $id; ?>">
                            <div class="form-group">
                                <label  class="col-lg-3 col-sm-3 control-label" for="txt_owner_company_abb">Company Abbreviation <span style="color:red;">*</span></label>
                                <div class="col-lg-9">
                                    <input type="text" class="form-control" placeholder="Company Abbreviation" id="txt_owner_company_abb" name="company_abbrev" value="<?php echo $owner->company_abbrev; ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label  class="col-lg-3 col-sm-3 control-label" for="txt_owner_company">Company Name <span style="color:red;">*</span></label>
                                <div class="col-lg-9">
                                    <input type="text" class="form-control" placeholder="Company Name" id="txt_owner_company" name="company_name" value="<?php echo $owner->company_name; ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label  class="col-lg-3 col-sm-3 control-label" for="txt_owner_name">Name <span style="color:red;">*</span></label>
                                <div class="col-lg-9">
                                    <input type="text" class="form-control" placeholder="Owner Name" id="txt_owner_name" name="name" value="<?php echo $owner->name; ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label  class="col-lg-3 col-sm-3 control-label" for="txt_owner_mobile">Mobile No</label>
                                <div class="col-lg-9">
                                    <input type="text" class="form-control" placeholder="Mobile No" id="txt_owner_mobile" name="mobile_no" value="<?php echo $owner->mobile_no; ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label  class="col-lg-3 col-sm-3 control-label" for="txt_email">Email <span style="color:red;">*</span></label>
                                <div class="col-lg-9">
                                    <input type="text" class="form-control" placeholder="Email Id" id="txt_email" name="email" value="<?php echo $owner->email; ?>">
                                </div>
                            </div>
                            <div class="panel-body">
                                <p>
                                    <button class="btn btn-primary" type="submit">Submit</button>
                                    <a href="<?php echo base_url(); ?>index.php/vehicleowner" class="btn btn-default" type="button">Cancel</a>
                                </p>
                            </div>
                        </form>
                    </div>
                </section>
            </div>
        </div>
        
        <!-- page end-->
        </section>
        <!--body wrapper end-->