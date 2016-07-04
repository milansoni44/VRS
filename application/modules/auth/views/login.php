<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="ThemeBucket">
        <link rel="shortcut icon" href="#" type="<?php echo base_url(); ?>image/png">

        <title>Login</title>

        <link href="<?php echo base_url(); ?>assets/css/style.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>assets/css/style-responsive.css" rel="stylesheet">

        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
        <script src="js/html5shiv.js"></script>
        <script src="js/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="login-body">
        <div class="container">
            <?php $attributes = array('class' => 'form-signin'); ?>
            <?php echo form_open("auth/login",$attributes);?>
                <div class="form-signin-heading text-center">
                    <!--<h1 class="sign-title">Sign In</h1>-->
                    <img src="<?php echo base_url(); ?>assets/images/MSRC Logo.png" width="80px" alt=""/>
                </div>
                <p style="color:#000; font-weight:bold;text-align:center;"><?php echo strtoupper('Morning Star'); ?></p>
                <p style="color:red; font-weight:bold;text-align:center;"><?php echo strtoupper('Rent A Car'); ?></p>
                <div class="login-wrap">
                    <p><?php echo lang('login_subheading');?></p>
					<div><?php echo $message;?></div>
                    <input type="text" name="identity" class="form-control" placeholder="User ID" autofocus id="identity">
                    <input type="password" name="password" class="form-control" placeholder="Password" id="pass">

                    <input class="btn btn-lg btn-login btn-block" type="submit" value="Login">
                        <!--<i class="fa fa-check"></i>
                    </button>-->

                    <!--<div class="registration">
                        Not a member yet?
                        <a class="" href="registration.html">
                            Signup
                        </a>
                    </div>-->
                    <label class="checkbox">
                        <?php echo form_checkbox('remember', '1', FALSE, 'id="remember"');?> Remember me
                        <span class="pull-right">
                            <!--<a data-toggle="modal" href="#myModal"> Forgot Password?</a>-->

                        </span>
                    </label>

                </div>
            <?php echo form_close();?>
        </div>
        
        <!-- Modal -->
        <!--<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal" class="modal fade">
            <div class="modal-dialog">
                <h1><?php echo lang('forgot_password_heading');?></h1>
                <p><?php echo sprintf(lang('forgot_password_subheading'), $identity_label);?></p>
                <div id="infoMessage"><?php echo $message;?></div>
                <?php echo form_open("auth/forgot_password");?>
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Forgot Password ?</h4>
                    </div>
                    <div class="modal-body">
                        <p>Enter your e-mail address below to reset your password.</p>
                        <input type="text" name="email" placeholder="Email" autocomplete="off" class="form-control placeholder-no-fix">

                    </div>
                    <div class="modal-footer">
                        <button data-dismiss="modal" class="btn btn-default" type="button">Cancel</button>
                        <button class="btn btn-primary" type="button">Submit</button>
                    </div>
                </div>
                <?php echo form_close();?>
            </div>
        </div>-->
        <!-- modal -->
    <!-- Placed js at the end of the document so the pages load faster -->

    <!-- Placed js at the end of the document so the pages load faster -->
    <script src="<?php echo base_url(); ?>assets/js/jquery-1.10.2.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/modernizr.min.js"></script>      
    <script>
        $(function() {
            if (localStorage.chkbx && localStorage.chkbx != '') {
                $('#remember').attr('checked', 'checked');
                $('#identity').val(localStorage.usrname);
                $('#pass').val(localStorage.pass);
            } else {
                $('#remember').removeAttr('checked');
                $('#username').val('');
                $('#pass').val('');
            }

            $('#remember').click(function() {
                
                if ($('#remember').is(':checked')) {
                    // save username and password
                    localStorage.usrname = $('#identity').val();
                    localStorage.pass = $('#pass').val();
                    localStorage.chkbx = $('#remember').val();
                } else {
                    localStorage.usrname = '';
                    localStorage.pass = '';
                    localStorage.chkbx = '';
                }
            });
        });
    </script>
    </body>
</html>