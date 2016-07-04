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
        <div class="row">
            <div class="col-lg-6">
                <section class="panel">
                    <header class="panel-heading">
                        <?php echo $page_title; ?> Form
                    </header>
                    <div class="panel-body">
                        <form class="form-horizontal" role="form" method="post" action="../edit/<?php echo $id; ?>">
                            <div class="form-group">
                                <label class="col-lg-3 col-sm-3 control-label" for="branch">Branch <span style="color:red;">*</span></label>
                                <div class="col-lg-9">
                                    <select class="form-control" id="branch" name="branch">
                                        <option value="0">--Select--</option>
                                        <?php
                                            foreach($branch as $name)
                                            {
                                        ?>
                                                <option <?php if($garage->branch_id == $name['id']) { ?>selected <?php } ?> value=<?php echo $name['id']; ?>><?php echo $name['branch_name']; ?></option>
                                        <?php
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label  class="col-lg-3 col-sm-3 control-label" for="garage_name">Garage Name <span style="color:red;">*</span></label>
                                <div class="col-lg-9">
                                    <input type="text" class="form-control" placeholder="Garage Name" id="garage_name" name="garage_name" value="<?php echo $garage->garage_name; ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label  class="col-lg-3 col-sm-3 control-label" for="location">Location</label>
                                <div class="col-lg-9">
                                    <input type="text" class="form-control" placeholder="Location" id="location" name="location" value="<?php echo $garage->location; ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label  class="col-lg-3 col-sm-3 control-label" for="telephone">Telephone</label>
                                <div class="col-lg-9">
                                    <input type="text" class="form-control" placeholder="Telephone" id="telephone" name="telephone" value="<?php echo $garage->telephone; ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label  class="col-lg-3 col-sm-3 control-label" for="mobile_no">Mobile No</label>
                                <div class="col-lg-9">
                                    <input type="text" class="form-control" placeholder="Mobile No" id="mobile_no" name="mobile_no" value="<?php echo $garage->mobile_no; ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label  class="col-lg-3 col-sm-3 control-label" for="email">Email</label>
                                <div class="col-lg-9">
                                    <input type="text" class="form-control" placeholder="Email" id="email" name="email" value="<?php echo $garage->email; ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label  class="col-lg-3 col-sm-3 control-label" for="contact_person">Contact Person</label>
                                <div class="col-lg-9">
                                    <input type="text" class="form-control" placeholder="Contact Person" id="contact_person" name="contact_person" value="<?php echo $garage->contact_person; ?>">
                                </div>
                            </div>
                            <div class="panel-body">
                                <p>
                                    <button class="btn btn-primary" type="submit">Submit</button>
                                    <a href="<?php echo base_url(); ?>index.php/garage" class="btn btn-default" type="button">Cancel</a>
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