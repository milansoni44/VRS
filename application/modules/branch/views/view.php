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
                            <a class="custom-button" href="<?php echo base_url(); ?>index.php/branch/edit/<?php echo $id; ?>"> Edit Branch</a>
                        </span>
                    </header>
                    <div class="panel-body">
                        <form class="form-horizontal" role="form" action="add" method="post">
                            <div class="form-group">
                                <label  class="col-lg-3 col-sm-3 control-label" for="branch_name">Branch Name</label>
                                <div class="col-lg-9">
                                    <input type="text" class="form-control" placeholder="Branch Name" id="branch_name" name="branch_name" value="<?php echo $branch->branch_name; ?>" disabled>
                                </div>
                            </div>
                            <div class="form-group">
                                <label  class="col-lg-3 col-sm-3 control-label" for="po_box">PO Box</label>
                                <div class="col-lg-9">
                                    <input type="text" class="form-control" placeholder="Po Box" id="po_box" name="po_box" value="<?php echo $branch->po_box; ?>" disabled>
                                </div>
                            </div>
                            <div class="form-group">
                                <label  class="col-lg-3 col-sm-3 control-label" for="postal_code">Postal Code</label>
                                <div class="col-lg-9">
                                    <input type="text" class="form-control" placeholder="Postal Code" id="postal_code" name="postal_code" value="<?php echo $branch->postal_code; ?>" disabled>
                                </div>
                            </div>
                            <div class="form-group">
                                <label  class="col-lg-3 col-sm-3 control-label" for="city">City</label>
                                <div class="col-lg-9">
                                    <input type="text" class="form-control" placeholder="City" id="city" name="city" value="<?php echo $branch->city; ?>" disabled>
                                </div>
                            </div>
                            <div class="form-group">
                                <label  class="col-lg-3 col-sm-3 control-label" for="telephone">Telephone</label>
                                <div class="col-lg-9">
                                    <input type="text" class="form-control" placeholder="Telephone" id="telephone" name="telephone" value="<?php echo $branch->telephone; ?>" disabled>
                                </div>
                            </div>
                            <div class="form-group">
                                <label  class="col-lg-3 col-sm-3 control-label" for="mobile">Mobile No.</label>
                                <div class="col-lg-9">
                                    <input type="text" class="form-control" placeholder="Mobile No." id="mobile" name="mobile" value="<?php echo $branch->mobile; ?>" disabled>
                                </div>
                            </div>
                            <div class="form-group">
                                <label  class="col-lg-3 col-sm-3 control-label" for="email">Email</label>
                                <div class="col-lg-9">
                                    <input type="text" class="form-control" placeholder="Email" id="email" name="email" value="<?php echo $branch->email; ?>" disabled>
                                </div>
                            </div>
                            <div class="form-group">
                                <label  class="col-lg-3 col-sm-3 control-label" for="incharge_name">Incharge Name</label>
                                <div class="col-lg-9">
                                    <input type="text" class="form-control" placeholder="Incharge Name" id="incharge_name" name="incharge" value="<?php echo $branch->incharge; ?>" disabled>
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