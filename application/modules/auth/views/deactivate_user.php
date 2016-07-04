        <!-- Content Header (Page header) -->
	<div class="page-heading">
        <h3>
            <?php echo lang('deactivate_heading');?>
        </h3>
        <ul class="breadcrumb">
            <li>
                <a href="<?php echo base_url(); ?>">Home</a>
            </li>
            <li class="active"> <?php echo lang('deactivate_heading');?> </li>
        </ul>
    </div><!-- Page heading end -->
    
    <!--body wrapper start-->
    <section class="wrapper">
    <p><?php echo sprintf(lang('deactivate_subheading'), $user->username);?></p>
    <!-- page start-->
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    <?php echo lang('deactivate_heading');?>
                </header>
                <!-- form start -->
                <?php echo form_open("auth/deactivate/".$user->id,array('class'=>'form-horizontal'));?>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="panel-body">
                                <p>
                                <?php echo lang('deactivate_confirm_y_label', 'confirm');?>
                                <input type="radio" name="confirm" value="yes" checked="checked" />
                                <?php echo lang('deactivate_confirm_n_label', 'confirm');?>
                                <input type="radio" name="confirm" value="no" />
                                </p>

                                <?php echo form_hidden($csrf); ?>
                                <?php echo form_hidden(array('id'=>$user->id)); ?>

                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <p>
                            <?php echo form_submit('submit', lang('deactivate_submit_btn'),"class='btn btn-primary'");?>
                        </p>
                    </div>
                <?php echo form_close();?>
                
            </section>
        </div>
    </div>
    <!-- page end-->
    </section>
    <!--body wrapper end-->