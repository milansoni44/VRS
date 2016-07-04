<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
  <meta name="keywords" content="admin, dashboard, bootstrap, template, flat, modern, theme, responsive, fluid, retina, backend, html5, css, css3">
  <meta name="description" content="">
  <meta name="author" content="ThemeBucket">
  <link rel="shortcut icon" href="#" type="image/png">

  <title><?php echo SITE_NAME; ?> | <?php echo $page_title;?></title>
    <style>
        .custom-nav .menu-list .sub-sub-menu-list {
  color: #fff;
  font-size: 13px;
  display: block;
  padding: 10px 5px 10px 50px;
  -moz-transition: all 0.2s ease-out 0s;
  -webkit-transition: all 0.2s ease-out 0s;
  transition: all 0.2s ease-out 0s;
}
.custom-nav .menu-list .sub-sub-menu-list li{
    list-style:none;
}
    </style>
  <!--icheck-->
  <link href="<?php echo base_url(); ?>assets/js/iCheck/skins/minimal/minimal.css" rel="stylesheet">
  <link href="<?php echo base_url(); ?>assets/js/iCheck/skins/square/square.css" rel="stylesheet">
  <link href="<?php echo base_url(); ?>assets/js/iCheck/skins/square/red.css" rel="stylesheet">
  <link href="<?php echo base_url(); ?>assets/js/iCheck/skins/square/blue.css" rel="stylesheet">
  <link href="<?php echo base_url(); ?>assets/css/datatables/dataTables.bootstrap.css" rel="stylesheet">
  <script src="<?php echo base_url(); ?>assets/js/jquery-latest.min.js" type="text/javascript"></script>
  <!--dashboard calendar-->
  <link href="<?php echo base_url(); ?>assets/css/clndr.css" rel="stylesheet">

  <!--C3 Chart-->
  <link href="<?php echo base_url(); ?>assets/js/c3-chart/c3.css" rel="stylesheet"/>
  <!--Morris Chart CSS -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/js/morris-chart/morris.css">
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
            <a href="<?php echo base_url(); ?>"><!--<img src="<?php echo base_url(); ?>assets/images/MSRC Logo.png" width="50px" alt="">--><span style="font-size:23px; font-weight:bold;padding-left:18px;padding-top:5px;"><?php echo COMPANY_NAME; ?><span></a>
        </div>

        <!--<div class="logo-icon text-center">
            <a href="index.html"><img src="<?php echo base_url(); ?>assets/images/MSRC Logo.png" width="100px" alt=""></a>
        </div>-->
        <!--logo and iconic logo end-->

        <div class="left-side-inner">

            <!-- visible to small devices only -->
            <div class="visible-xs hidden-sm hidden-md hidden-lg">
                <div class="media logged-user">
                    <img alt="" src="<?php echo base_url(); ?>assets/uploads/users/<?php echo USER_IMAGE; ?>" class="media-object">
                    <div class="media-body">
                        <h4><a href="#"><?php echo FIRST_NAME; ?></a></h4>
                        <!--<span>"Hello There..."</span>-->
                    </div>
                </div>

                <!--<h5 class="left-nav-title">Account Information</h5>-->
                <ul class="nav nav-pills nav-stacked custom-nav">
                  <!--<li><a href="#"><i class="fa fa-user"></i> <span>Profile</span></a></li>
                  <li><a href="#"><i class="fa fa-cog"></i> <span>Settings</span></a></li>-->
                  <li><a href="<?php echo base_url(); ?>index.php/auth/logout"><i class="fa fa-sign-out"></i> <span>Sign Out</span></a></li>
                </ul>
            </div>
            
            <!--sidebar nav start-->
            <ul class="nav nav-pills nav-stacked custom-nav">
                <!--<li class="menu-list nav-active"><a href="index.html"><i class="fa fa-home"></i> <span>Dashboard</span></a>
                    <ul class="sub-menu-list">
                        <li><a href="index_alt.html"> Dashboard 1</a></li>
                        <li class="active"><a href="index.html"> Dashboard 2</a></li>
                    </ul>
                </li>-->
                <li class="active"><a href="<?php echo base_url(); ?>index.php/home"><i class="fa fa-home"></i> Dashboard</a></li>
                <li class="menu-list"><a href="#"><i class="fa fa-cogs"></i> <span>Settings</span></a>
                    <ul class="sub-menu-list">
                        <li><a href="<?php echo base_url(); ?>index.php/branch"> Branch</a></li>
                        <li><a href="<?php echo base_url(); ?>index.php/vehicleowner"> Owner</a></li>
                        <li><a href="<?php echo base_url(); ?>index.php/accountgroup"> Account Group</a></li>
                        <li><a href="<?php echo base_url(); ?>index.php/ledger"> Ledger</a></li>
                        <li><a href="<?php echo base_url(); ?>index.php/pdc"> PDC</a></li>
                        <li><a href="<?php echo base_url(); ?>index.php/customer"> Customer</a></li>
                        <li><a href="<?php echo base_url(); ?>index.php/garage"> Garage</a></li>
                        <li><a href="<?php echo base_url(); ?>index.php/auth/users"> User</a></li>
                        <li><a href="<?php echo base_url(); ?>index.php/settings"> System Settings</a></li>
                    </ul>
                </li>
                <li class="menu-list"><a href="#"><i class="fa fa-ambulance"></i> <span>Vehicles</span></a>
                    <ul class="sub-menu-list">
                        <li><a href="<?php echo base_url(); ?>index.php/vehicle"> Vehicle</a></li>
                    </ul>
                </li>
                <li class="menu-list"><a href="#"><i class="fa fa-heart"></i> <span>Transaction</span></a>
                    <ul class="sub-menu-list">
                        <li><a href="<?php echo base_url(); ?>index.php/rentalpickup"> Rental PickUp</a></li>
                        <li><a href="<?php echo base_url(); ?>index.php/rentalreturn"> Rental Return</a></li>
                        <li><a href="<?php echo base_url(); ?>index.php/receipt"> Receipts</a></li>
                        <li><a href="<?php echo base_url(); ?>index.php/payment"> Payments</a></li>
                        <li><a href="<?php echo base_url(); ?>index.php/vehicleservice"> Vehicle Service</a></li>
                        <li><a href="<?php echo base_url(); ?>index.php/quotationheader"> Quotation</a></li>
                    </ul>
                </li>
                <li class="menu-list"><a href="#"><i class="fa fa-flag-o"></i> <span>Vehicle Reports</span></a>
                    <ul class="sub-menu-list">
                        <li><a href="<?php echo base_url(); ?>index.php/reports/vehicle_list"> List</a></li>
                        <li><a href="<?php echo base_url(); ?>index.php/reports/vehicle_service"> Service</a></li>
                        <li><a href="<?php echo base_url(); ?>index.php/reports/vehicle_registration_due"> Renewal</a></li>
                        <li><a href="<?php echo base_url(); ?>index.php/reports/vehicle_rented"> Rentals</a></li>
                        <li><a href="<?php echo base_url(); ?>index.php/reports/vehicle_expected_return"> Return Due</a></li>
                    </ul>
                </li>
                <li class="menu-list"><a href="#"><i class="fa fa-flag-checkered"></i> <span>Accounts Reports</span></a>
                    <ul class="sub-menu-list">
                        <li><a href="<?php echo base_url(); ?>index.php/reports/reciept_period"> Receipts</a></li>
                        <li><a href="<?php echo base_url(); ?>index.php/reports/payment_period"> Payments</a></li>
                        <li><a href="<?php echo base_url(); ?>index.php/reports/cheque_due_payment"> Cheques Due</a></li>
                        <li><a href="<?php echo base_url(); ?>index.php/transactions/account_statement"> Cash Book</a></li>
                        <li><a href="<?php echo base_url(); ?>index.php/transactions/ledger_wise_transaction"> Ledger</a></li>
                        <li><a href="<?php echo base_url(); ?>index.php/transactions/vehicle_wise_income_expense_detail">Inc & Exp Detail</a></li>
                        <li><a href="<?php echo base_url(); ?>index.php/transactions/vehicle_wise_income_expense"> Inc & Exp Summary</a></li>
                    </ul>
                </li>    
                <li><a href="http://morningstarrentacar.com/VRS/doc/" target="__blank"><i class="fa fa-info-circle"></i> <span>Help</span></a></li>
                <li><a href="<?php echo base_url(); ?>index.php/about"><i class="fa fa-info"></i> <span>About Us</span></a></li>
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
            <!--<form class="searchform" action="index.html" method="post">
                <input type="text" class="form-control" name="keyword" placeholder="Search here..." />
            </form>-->
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
                            <!--<li><a href="<?php echo base_url(); ?>index.php/auth/edit_user/<?php echo USER_ID; ?>"><i class="fa fa-user"></i>  Profile</a></li>
                            <li><a href="#"><i class="fa fa-cog"></i>  Settings</a></li>-->
                            <li><a href="<?php echo base_url(); ?>index.php/auth/logout"><i class="fa fa-sign-out"></i> Log Out</a></li>
                        </ul>
                    </li>

                </ul>
            </div>
            <!--notification menu end -->

        </div>
        <!-- header section end-->