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
                            <a class="custom-button" href="<?php echo base_url(); ?>index.php/ledger/edit/<?php echo $id; ?>"> Edit Ledger</a>
                        </span>
                        </header>
                        <div class="panel-body">
                            <form class="form-horizontal" role="form" method="post" action="../edit/<?php echo $id ?>">
                                <div class="form-group">
                                    <label class="col-sm-2 control-label col-lg-3" for="branch">Branch</label>
                                    <div class="col-lg-9">
                                        <input type="text" class="form-control" placeholder="Group Title" id="branch" name="branch" value="<?php echo $ledger->branch_name; ?>" disabled>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label col-lg-3" for="type">type</label>
                                    <div class="col-lg-9">
                                        <input type="text" class="form-control" id="type" name="type" value="<?php echo $ledger->type; ?>" disabled>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label  class="col-lg-3 col-sm-3 control-label" for="title">Title</label>
                                    <div class="col-lg-9">
                                        <input type="text" class="form-control" id="title" name="title" value="<?php echo $ledger->title; ?>" disabled>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label col-lg-3" for="accountgroup">Account Group</label>
                                    <div class="col-lg-9">
                                        <input type="text" class="form-control" id="accountgroup" name="accountgroup" value="<?php echo $ledger->group_title; ?>" disabled>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label  class="col-lg-3 col-sm-3 control-label" for="opening_balance">Opening Balance Amount</label>
                                    <div class="col-lg-9">
                                        <input type="text" class="form-control" id="opening_balance" name="opening_balance" value="<?php echo $ledger->opening_balance; ?>" disabled>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label  class="col-lg-3 col-sm-3 control-label" for="closing_balance">Closing Balance Amount</label>
                                    <div class="col-lg-9">
                                        <input type="text" class="form-control" id="closing_balance" name="closing_balance" value="<?php echo $ledger->closing_balance; ?>" disabled>
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