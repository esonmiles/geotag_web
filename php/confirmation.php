<!DOCTYPE html>
<?php
include "../classes/post.php";
$post = new Post();
session_start();
$path = '/geotag_web/';
$root = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/';

$encrypt_id = $_GET['id'];

$verify = $post->verify($encrypt_id);
?>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <!-- Meta, title, CSS, favicons, etc. -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Confirmation - PhilRice GeoTagging Tool Web</title>

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

                            <h1 class="login_title"><img src="<?php echo $path ?>images/app_logo.png">Account Verified</h1>
                            
                            <div class="separator">

                                <div class="clearfix"></div>
                                <br />

                                <div>
                                    <h1><i class="fa fa-thumbs-o-up"></i> Your Account has been verified. You can now use your account.</h1>
                                    <h2><strong><i class="fa fa-link"></i> <a href="<?php echo $root?>geotag_web/login">Click this link to login.</a></strong></h2>
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
</script>