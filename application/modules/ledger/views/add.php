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
                            <?php echo $page_title; ?> Form
                        </header>
                        <div class="panel-body">
                            <form class="form-horizontal" role="form" method="post" action="add">
                                <div class="form-group">
                                    <label class="col-sm-2 control-label col-lg-3" for="branch">Branch <span style="color:red;">*</span></label>
                                    <div class="col-lg-9">
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
                                    <label class="col-sm-2 control-label col-lg-3" for="type">Type <span style="color:red;">*</span></label>
                                    <div class="col-lg-9">
                                        <select class="form-control" id="type" name="type">
                                            <option value="0">-- Select --</option>
                                            <option value="Income">Income</option>
                                            <option value="Expenditure">Expenditure</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label  class="col-lg-3 col-sm-3 control-label" for="title">Title <span style="color:red;">*</span></label>
                                    <div class="col-lg-9">
                                        <input type="text" class="form-control" placeholder="Title" id="title" name="title" value="<?php echo set_value('title'); ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label col-lg-3" for="group">Group <span style="color:red;">*</span></label>
                                    <div class="col-lg-9">
                                        <select class="form-control" id="accountgroup" name="accountgroup">
                                            <option value="0">--Select--</option>
                                            <?php
                                                foreach($accountgroup as $name1)
                                                {
                                                    echo "<option value='$name1[id]' " . set_select('accountgroup', $name1['id']) . " >". $name1['group_title']."</option>";
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label  class="col-lg-3 col-sm-3 control-label" for="opening_balance">Opening Balance</label>
                                    <div class="col-lg-9">
                                        <input type="text" class="form-control" placeholder="Opening Balance" id="opening_balance" name="opening_balance" value="<?php echo set_value('opening_balance'); ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label  class="col-lg-3 col-sm-3 control-label" for="closing_balance">Closing Balance</label>
                                    <div class="col-lg-9">
                                        <input type="text" class="form-control" placeholder="Closing Balance" id="closing_balance" name="closing_balance" value="<?php echo set_value('closing_balance'); ?>">
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <p>
                                        <button class="btn btn-primary" type="submit">Submit</button>
                                        <a href="<?php echo base_url(); ?>index.php/ledger" class="btn btn-default" type="button">Cancel</a>
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