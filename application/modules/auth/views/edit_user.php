<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
  <meta name="keywords" content="admin, dashboard, bootstrap, template, flat, modern, theme, responsive, fluid, retina, backend, html5, css, css3">
  <meta name="description" content="">
  <meta name="author" content="ThemeBucket">
  <link rel="shortcut icon" href="#" type="image/png">

  <title><?php echo "VRS | ".$page_title;?></title>

  <!--icheck-->
  <link href="<?php echo base_url(); ?>assets/js/iCheck/skins/minimal/minimal.css" rel="stylesheet">
  <link href="<?php echo base_url(); ?>assets/js/iCheck/skins/square/square.css" rel="stylesheet">
  <link href="<?php echo base_url(); ?>assets/js/iCheck/skins/square/red.css" rel="stylesheet">
  <link href="<?php echo base_url(); ?>assets/js/iCheck/skins/square/blue.css" rel="stylesheet">
  <link href="<?php echo base_url(); ?>assets/css/datatables/dataTables.bootstrap.css" rel="stylesheet">
  <script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
  <!--dashboard calendar-->
  <link href="<?php echo base_url(); ?>assets/css/clndr.css" rel="stylesheet">


  <!--common-->
  <link href="<?php echo base_url(); ?>assets/css/style.css" rel="stylesheet">
  <link href="<?php echo base_url(); ?>assets/css/style-responsive.css" rel="stylesheet">


  <script src="<?php echo base_url(); ?>assets/js/jquery-ui-1.9.2.custom.min.js"></script>

  <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!--[if lt IE 9]>
  <script src="js/html5shiv.js"></script>
  <script src="js/respond.min.js"></script>
  <![endif]-->
</head>

<body class="sticky-header">

<section>
    <!-- left side start-->
    <div class="left-side sticky-left-side">

        <!--logo and iconic logo start-->
        <div class="logo">
            <a href="index.html"><img src="<?php echo base_url(); ?>assets/images/logo.png" alt=""></a>
        </div>

        <div class="logo-icon text-center">
            <a href="index.html"><img src="<?php echo base_url(); ?>assets/images/logo_icon.png" alt=""></a>
        </div>
        <!--logo and iconic logo end-->

        <div class="left-side-inner">

            <!-- visible to small devices only -->
            <div class="visible-xs hidden-sm hidden-md hidden-lg">
                <div class="media logged-user">
                    <img alt="" src="<?php echo base_url(); ?>assets/images/photos/user-avatar.png" class="media-object">
                    <div class="media-body">
                        <h4><a href="#">John Doe</a></h4>
                        <span>"Hello There..."</span>
                    </div>
                </div>

                <h5 class="left-nav-title">Account Information</h5>
                <ul class="nav nav-pills nav-stacked custom-nav">
                  <li><a href="#"><i class="fa fa-user"></i> <span>Profile</span></a></li>
                  <li><a href="#"><i class="fa fa-cog"></i> <span>Settings</span></a></li>
                  <li><a href="#"><i class="fa fa-sign-out"></i> <span>Sign Out</span></a></li>
                </ul>
            </div>
            
            <!--sidebar nav start-->
            <ul class="nav nav-pills nav-stacked custom-nav">
                <li class="active"><a href="<?php echo base_url(); ?>index.php/home"><i class="fa fa-home"></i> Dashboard</a></li>
                <li class="menu-list"><a href="#"><i class="fa fa-cogs"></i> <span>Settings</span></a>
                    <ul class="sub-menu-list">
                        <li><a href="<?php echo base_url(); ?>index.php/branch"> Branch</a></li>
                        <li><a href="<?php echo base_url(); ?>index.php/vehicleowner"> Owner</a></li>
                        <li><a href="<?php echo base_url(); ?>index.php"> Account Group</a></li>
                        <li><a href="<?php echo base_url(); ?>index.php"> Ledger</a></li>
                        <li><a href="<?php echo base_url(); ?>index.php/pdc"> PDC</a></li>
                        <li><a href="<?php echo base_url(); ?>index.php/customer"> Customer</a></li>
                        <li><a href="<?php echo base_url(); ?>index.php/garage"> Garage</a></li>
                        <li><a href="<?php echo base_url(); ?>index.php/auth/users"> User</a></li>
                    </ul>
                </li>
                <li class="menu-list"><a href="#"><i class="fa fa-ambulance"></i> <span>Vehicles</span></a>
                    <ul class="sub-menu-list">
                        <li><a href="<?php echo base_url(); ?>index.php/vehicle"> Vehicle</a></li>
                    </ul>
                </li>
                <li class="menu-list"><a href="#"><i class="fa fa-cogs"></i> <span>Transaction</span></a>
                    <ul class="sub-menu-list">
                        <li><a href="<?php echo base_url(); ?>index.php/rentalpickup"> Rental PickUp</a></li>
                        <li><a href="<?php echo base_url(); ?>index.php/rentalreturn"> Rental Return</a></li>
                        <li><a href="<?php echo base_url(); ?>index.php/receipt"> Receipts</a></li>
                        <li><a href="<?php echo base_url(); ?>index.php/payment"> Payments</a></li>
                        <li><a href="<?php echo base_url(); ?>index.php/vehicleservice"> Vehicle Service</a></li>
                        <li><a href="<?php echo base_url(); ?>index.php/quotationheader"> Quotation</a></li>
                    </ul>
                </li>
                <li class="menu-list"><a href="#"><i class="fa fa-cogs"></i> <span>Vehicle Reports</span></a>
                    <ul class="sub-menu-list">
                        <li><a href="<?php echo base_url(); ?>index.php/reports/vehicle_list"> List</a></li>
                        <li><a href="<?php echo base_url(); ?>index.php/reports/vehicle_service"> Service</a></li>
                        <li><a href="<?php echo base_url(); ?>index.php/reports/vehicle_registration_due"> Renewal</a></li>
                        <li><a href="<?php echo base_url(); ?>index.php/reports/vehicle_rented"> Rentals</a></li>
                        <li><a href="<?php echo base_url(); ?>index.php/reports/vehicle_expected_return"> Return Due</a></li>
                    </ul>
                </li>
                <li class="menu-list"><a href="#"><i class="fa fa-cogs"></i> <span>Accounts Reports</span></a>
                    <ul class="sub-menu-list">
                        <li><a href="<?php echo base_url(); ?>index.php/reports/reciept_period"> Receipts</a></li>
                        <li><a href="<?php echo base_url(); ?>index.php/reports/payment_period"> Payments</a></li>
                        <li><a href="<?php echo base_url(); ?>index.php/reports/cheque_due_payment"> Cheques Due</a></li>
                        <li><a href="<?php echo base_url(); ?>index.php/transactions/account_statement"> Cash Book</a></li>
                        <li><a href="<?php echo base_url(); ?>index.php/transactions/ledger_wise_transaction"> Ledger</a></li>
                    </ul>
                </li>
            </ul>
            <!--sidebar nav end-->

        </div>
    </div>
    <!-- left side end-->
    
    <!-- main content start-->
    <div class="main-content" >

        <!-- header section start-->
        <div class="header-section">

            <!--toggle button start-->
            <a class="toggle-btn"><i class="fa fa-bars"></i></a>
            <!--toggle button end-->

            <!--search start-->
            <form class="searchform" action="index.html" method="post">
                <input type="text" class="form-control" name="keyword" placeholder="Search here..." />
            </form>
            <!--search end-->

            <!--notification menu start -->
            <div class="menu-right">
                <ul class="notification-menu">
                    <li>
                        <a href="#" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                            <img src="<?php echo base_url(); ?>assets/uploads/users/<?php echo USER_IMAGE; ?>" alt="" />
                            <?php echo FIRST_NAME; ?>
                            <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-usermenu pull-right">
                            <li><a href="#"><i class="fa fa-user"></i>  Profile</a></li>
                            <li><a href="#"><i class="fa fa-cog"></i>  Settings</a></li>
                            <li><a href="<?php echo base_url(); ?>index.php/auth/logout"><i class="fa fa-sign-out"></i> Log Out</a></li>
                        </ul>
                    </li>

                </ul>
            </div>
            <!--notification menu end -->

        </div>
        <!-- header section end-->		
        <div class="page-heading">
            <h3>
                <?php echo lang('edit_user_heading');?>
            </h3>
            <ul class="breadcrumb">
                <li>
                    <a href="<?php echo base_url(); ?>">Home</a>
                </li>
                <li class="active"> <?php echo lang('edit_user_heading');?> </li>
            </ul>
        </div><!-- Page heading end -->
		<div id="infoMessage"><?php echo $message;?></div>
        
        <!--body wrapper start-->
        <section class="wrapper">
        <!-- page start-->
        <div class="row">
            <div class="col-lg-12">
                <section class="panel">
                    <header class="panel-heading">
                        <?php echo lang('edit_user_heading');?>
                    </header>
                    <?php echo form_open_multipart(uri_string(),array('class'=>'form-horizontal'));?>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="panel-body">
                                    <div class="form-group">
                                        <div class="col-lg-4 col-sm-3 control-label"><?php echo lang('edit_user_fname_label', 'first_name');?> <span style="color:red;">*</span></div>
                                        <div class="col-lg-8">
                                            <?php echo form_input($first_name);?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-lg-4 col-sm-3 control-label"><?php echo lang('edit_user_lname_label', 'last_name');?> <span style="color:red;">*</span></div>
                                        <div class="col-lg-8">
                                            <?php echo form_input($last_name);?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-2 control-label col-lg-4"><?php echo lang('edit_user_company_label', 'company');?> <span style="color:red;">*</span></div>
                                        <div class="col-lg-8">
                                            <?php echo form_input($company);?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div  class="col-lg-4 col-sm-3 control-label"><?php echo lang('edit_user_phone_label', 'phone');?> <span style="color:red;">*</span></div>
                                        <div class="col-lg-8">
                                            <?php echo form_input($phone);?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-2 control-label col-lg-4"><?php echo lang('edit_user_password_label', 'password');?></div>
                                        <div class="col-lg-8">
                                            <?php echo form_input($password);?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-2 control-label col-lg-4"><?php echo lang('edit_user_password_confirm_label', 'password_confirm');?></div>
                                        <div class="col-lg-8">
                                            <?php echo form_input($password_confirm);?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label col-lg-4">Branch</label>
                                        <div class="col-lg-8">
                                        <?php
                                            $optionBR = array(''=>'--Select--');
                                            if(!empty($branch)){
                                                foreach($branch as $rowBR){
                                                    $optionBR[$rowBR->id] = $rowBR->branch_name;
                                                }
                                            }
                                            echo form_dropdown('branch_id',$optionBR,isset($_POST['branch_id'])?$_POST['branch_id']:$user->branch_id,'class="form-control"');
                                        ?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label col-lg-4" for="user_image">User Image:</label>
                                        <div class="col-lg-8">
                                            <input type="file" id="user_image" name="user_image"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                    <?php if ($this->ion_auth->is_admin()): ?>
                                      <div class="col-sm-2 control-label col-lg-4"><strong><?php echo lang('edit_user_groups_heading');?></strong></div>
                                        <div class="col-lg-8">
                                            <?php foreach ($groups as $group):?>
                                                <label class="checkbox">
                                                <?php
                                                    $gID=$group['id'];
                                                    $checked = null;
                                                    $item = null;
                                                    foreach($currentGroups as $grp) {
                                                        if ($gID == $grp->id) {
                                                            $checked= ' checked="checked"';
                                                        break;
                                                        }
                                                    }
                                                ?>
                                                <input type="radio" name="groups" value="<?php echo $group['id'];?>"<?php echo $checked;?>>
                                                <?php echo htmlspecialchars($group['name'],ENT_QUOTES,'UTF-8');?>
                                                </label>
                                            <?php endforeach?>
                                        </div>
                                    <?php endif ?>
                                    </div>
                                    <?php echo form_hidden('id', $user->id);?>
                                    <?php echo form_hidden('edit_user_image', $user->user_image);?>
                                    <?php echo form_hidden($csrf); ?>
                                </div>
                            </div>
                        </div>
                        <div class="panel-body">
                            <p>
                                <?php echo form_submit('submit', lang('edit_user_submit_btn'),"class='btn btn-primary'");?>
                            </p>
                        </div>
                    <?php echo form_close();?>
                    
                </section>
            </div>
        </div>
        <!-- page end-->
        </section>
        <!--body wrapper end-->