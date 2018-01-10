<!DOCTYPE html>
<?php
include "classes/get.php";
$get = new Get();
session_start();
$path = '/geotag_web/';
$root = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/';
if (isset($_SESSION['userId']))
    header('Location:' . $root . 'geotag_web/');
?>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <!-- Meta, title, CSS, favicons, etc. -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>PhilRice GeoTagging Tool Web</title>

        <!-- Bootstrap -->
        <link href="<?php echo $path ?>vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="<?php echo $path ?>css/style.css" rel="stylesheet">
        <!-- Font Awesome -->
        <link rel="shortcut icon" type="image/x-icon" href="<?php echo $path; ?>images/app_logo.png" />
        <link href="<?php echo $path ?>vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">

        <!-- Custom Theme Style -->
        <link href="<?php echo $path ?>build/css/custom.min.css" rel="stylesheet">
        <script src="<?php echo $path ?>vendors/jquery/dist/jquery.min.js"></script>
        <!-- Bootstrap -->
        <script src="<?php echo $path ?>vendors/bootstrap/dist/js/bootstrap.min.js"></script>
        <!-- FastClick -->
    </head>

    <body class="login">
        <div>
            <a class="hiddenanchor" id="signup"></a>
            <a class="hiddenanchor" id="signin"></a>

            <div class="login_wrapper">
                <div class="animate form login_form">
                    <section class="login_content">
                        <iframe id="log_target" name="log_target" style="display: none"></iframe>
                        <form  action="<?php echo $path ?>php/login.php" method="post" target="log_target">

                            <h1 class="login_title"><img src="<?php echo $path ?>images/app_logo.png">Project Management</h1>
                            <div class="alert alert-danger alert-dismissible fade in hid" role="alert" id="error_log">
                                <button id="hideAlert" type="button" class="close" aria-label="Close"><span aria-hidden="true">×</span>
                                </button>
                                <strong>Login Error!</strong> <span id="error_mess">Username and password not matched.</span>
                            </div>
                            <div class="alert alert-success alert-dismissible fade in hid" role="alert" id="success_log">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                                </button>
                                <strong>Login Successful!</strong> Please wait...
                            </div>
                            <div>
                                <input type="text" class="form-control" placeholder="Username" required="" id="username" name="username"/>
                            </div>
                            <div>
                                <input type="password" class="form-control" placeholder="Password" required=""  id="password" name="password"/>
                            </div>
                            <div>
                                <button type="submit" class="btn btn-default submit">Log in</button>
<!--                                <a class="reset_pass" href="#">Lost your password?</a>-->
                            </div>

                            <div class="clearfix"></div>

                            <div class="separator">
                                <p class="change_link">New to site?
                                    <a href="register" class="to_register"> <strong> Create Account </strong></a>
                                </p>

                                <div class="clearfix"></div>
                                <br />

                                <div>
                                    <h1><i class="fa fa-map"></i> PhilRice GeoTagging Tool!</h1>
                                    <p>©2017 All Rights Reserved. Philippine Rice Research Institute. Privacy and Terms</p>
                                </div>
                            </div>
                        </form>
                    </section>
                </div>
            </div>
        </div>
    </body>
</html>
<script>
    $(document).ready(function () {
        $("#username").focus();
    });
    $("#hideAlert").click(function () {
        $("#error_log").fadeOut();
    });
</script>