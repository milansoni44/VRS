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
            <div class="col-lg-6">
                <section class="panel">
                    <header class="panel-heading">
                        <?php echo $page_title; ?>
                        <span class="tools pull-right">
                            <a class="custom-button" href="<?php echo base_url(); ?>index.php/vehicleowner/edit/<?php echo $id; ?>"> Edit Vehicle Owner</a>
                        </span>
                    </header>
                    <div class="panel-body">
                        <form class="form-horizontal" role="form" method="post" action="add">
                            <div class="form-group">
                                <label  class="col-lg-3 col-sm-3 control-label" for="txt_owner_company_abb">Company Abbreviation</label>
                                <div class="col-lg-9">
                                    <input type="text" class="form-control" placeholder="Company Abbreviation" id="txt_owner_company_abb" name="company_abbrev" value="<?php echo $owner->company_abbrev; ?>" disabled>
                                </div>
                            </div>
                            <div class="form-group">
                                <label  class="col-lg-3 col-sm-3 control-label" for="txt_owner_company">Company Name</label>
                                <div class="col-lg-9">
                                    <input type="text" class="form-control" placeholder="Company Name" id="txt_owner_company" name="company_name" value="<?php echo $owner->company_name; ?>" disabled>
                                </div>
                            </div>
                            <div class="form-group">
                                <label  class="col-lg-3 col-sm-3 control-label" for="txt_owner_name">Name</label>
                                <div class="col-lg-9">
                                    <input type="text" class="form-control" placeholder="Owner Name" id="txt_owner_name" name="name" value="<?php echo $owner->name; ?>" disabled>
                                </div>
                            </div>
                            <div class="form-group">
                                <label  class="col-lg-3 col-sm-3 control-label" for="txt_owner_mobile">Mobile No</label>
                                <div class="col-lg-9">
                                    <input type="text" class="form-control" placeholder="Mobile No" id="txt_owner_mobile" name="mobile_no" value="<?php echo $owner->mobile_no; ?>" disabled>
                                </div>
                            </div>
                            <div class="form-group">
                                <label  class="col-lg-3 col-sm-3 control-label" for="txt_email">Email</label>
                                <div class="col-lg-9">
                                    <input type="text" class="form-control" placeholder="Email Id" id="txt_email" name="email" value="<?php echo $owner->email; ?>" disabled>
                                </div>
                            </div>
                        </form>
                    </div>
                </section>
            </div>
        </div>
        
        <!-- page end-->
        </section>
        <!--body wrapper end-->