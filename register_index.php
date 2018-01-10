<!DOCTYPE html>
<?php
include "classes/get.php";
$get = new Get();
session_start();
$path = '/geotag_web/';
$root = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/';
?>
<html lang="en">

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <!-- Meta, title, CSS, favicons, etc. -->
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />

        <title>PhilRice GeoTagging Tool Web</title>

        <!-- Bootstrap -->
        <link href="<?php echo $path ?>vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet"/>
        <link href="<?php echo $path ?>css/style.css" rel="stylesheet" />
        <!-- Font Awesome -->
        <link rel="shortcut icon" type="image/x-icon" href="<?php echo $path; ?>images/app_logo.png" />
        <link href="<?php echo $path ?>vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet" />

        <!-- Custom Theme Style -->
        <link href="<?php echo $path ?>build/css/custom.min.css" rel="stylesheet" />
        <script src="<?php echo $path ?>vendors/jquery/dist/jquery.min.js"></script>
        <!-- Bootstrap -->
        <script src="<?php echo $path ?>vendors/bootstrap/dist/js/bootstrap.min.js"></script>
        <!-- FastClick -->
    </head>

    <body class="login">
        <div>
            <a class="hiddenanchor" id="signup"></a>
            <a class="hiddenanchor" id="signin"></a>

            <div class="login_wrapper" id="registration_div">
                <div class="animate form login_form">
                    <section class="login_content">
                        <div class="x_content" >
                            <iframe id="log_target" name="log_target" style="display: none"></iframe>
                            <form  action="<?php echo $path ?>php/register.php" method="post" target="log_target" class="form-horizontal form-label-left">

                                <h1 class="login_title"><img src="<?php echo $path ?>images/app_logo.png">User Registration</h1>
                                <div class="alert alert-danger alert-dismissible fade in hid" role="alert" id="error_log">
                                    <button id="hideAlert" type="button" class="close" aria-label="Close"><span aria-hidden="true">×</span>
                                    </button>
                                    <strong>Registration Error!</strong> <span id="error_msg">Username and password not matched.</span>
                                </div>
                                <div class="alert alert-success alert-dismissible fade in hid" role="alert" id="success_log">
                                    <button type="button" class="close" aria-label="Close"><span aria-hidden="true">×</span>
                                    </button>
                                    <strong>Successfully Registered!</strong> Please wait...
                                </div>
                                <div style="text-align: left;"><code>* Required Fields.</code></div>
                                <br>
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Username <code>*</code></label>
                                    <div class="col-md-9 col-sm-9 col-xs-12">
                                        <input type="text" class="form-control" placeholder="Username" required="" id="username" name="username"/>
                                    </div>
                                    <div class="col-xs-12" id="checkUsername"></div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Password <code>*</code></label>
                                    <div class="col-md-9 col-sm-9 col-xs-12">
                                        <input type="password" class="form-control" placeholder="Password" required=""  id="password" name="password"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Confirm Password <code>*</code></label>
                                    <div class="col-md-9 col-sm-9 col-xs-12">
                                        <input type="password" class="form-control" placeholder="Confirm Password" required=""  id="cpassword" name="cpassword"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">First name <code>*</code></label>
                                    <div class="col-md-9 col-sm-9 col-xs-12">
                                        <input type="text" class="form-control" placeholder="First name" required=""  id="fname" name="fname"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Last name <code>*</code></label>
                                    <div class="col-md-9 col-sm-9 col-xs-12">
                                        <input type="text" class="form-control" placeholder="Last name" required=""  id="lname" name="lname"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Email <code>*</code></label>
                                    <div class="col-md-9 col-sm-9 col-xs-12">
                                        <input type="text" class="form-control" placeholder="Email" required=""  id="email" name="email"/>
                                    </div>
                                    <div class="col-xs-12" id="checkEmail"></div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Station</label>
                                    <div class="col-md-9 col-sm-9 col-xs-12">
                                        <select id="stationId" name="stationId" class="form-control">
                                            <option value="0">Select station</option>
                                            <?php
                                            $getData = $get->getData("tbl_station", "stationName", "stationId");
                                            foreach ($getData as $id => $record):
                                                echo '<option value="' . $record['stationId'] . '">' . $record['stationName'] . ' (' . $record['station_abbr'] . ')</option>';
                                            endforeach;
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Division</label>
                                    <div class="col-md-9 col-sm-9 col-xs-12">
                                        <select id="divisionId" name="divisionId" class="form-control">
                                            <option value="0">Select division</option>
                                            <?php
                                            $getData = $get->getData("tbl_division", "divisionName", "divisionId");
                                            foreach ($getData as $id => $record):
                                                echo '<option value="' . $record['divisionId'] . '">' . $record['divisionName'] . ' (' . $record['division_abbr'] . ')</option>';
                                            endforeach;
                                            ?>
                                        </select>
                                    </div>
                                </div>
                               
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Purpose <code>*</code></label>
                                    <div class="col-md-9 col-sm-9 col-xs-12">
                                        <textarea class="form-control" name="purpose" id="purpose"></textarea>
                                    </div>
                                </div>
                                <div style="text-align: left;"><i class="fa fa-question-circle"></i><em>The system administrator will approve your account first. You will receive an email once approved.</em></div>
                                <br>
                                <div>
                                    <button name="registerMe" type="submit" class="btn btn-default submit" href="">Register</button>
                                    <!--<input type="submit" name="registerMe" id="registerMe" class="hid">-->
                                </div>
                                <div class="clearfix"></div>

                                <div class="separator">
                                    <p class="change_link">Already have an account?
                                        <a href="login" class="to_register"> <strong>Proceed to login </strong> </a>
                                    </p>

                                    <div class="clearfix"></div>
                                    <br />

                                    <div>
                                        <h1><i class="fa fa-map"></i> PhilRice GeoTagging Tool!</h1>
                                        <p>©2017 All Rights Reserved. Philippine Rice Research Institute. Privacy and Terms</p>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </section>
                </div>
            </div>

            <div class="login_wrapper hid" id="redirect">
                <div class="animate form login_form">
                    <section class="login_content">
                        <div class="x_content" >
                            <h1 class="login_title"><img src="<?php echo $path ?>images/app_logo.png">Registration Complete</h1>
                            <div class="separator">
                                <div style="text-align: left;"><i class="fa fa-question-circle"></i><em>The system administrator will approve your account first. You will receive an email once approved.</em></div>
                                <p class="change_link">Already have an account?
                                    <a href="login" class="to_register"> <strong>Proceed to login </strong> </a>
                                </p>

                                <div class="clearfix"></div>
                                <br />

                                <div>
                                    <h1><i class="fa fa-map"></i> PhilRice GeoTagging Tool!</h1>
                                    <p>©2017 All Rights Reserved. Philippine Rice Research Institute. Privacy and Terms</p>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </body>
</html>
<script>
    var typingTimer;                //timer identifier
    var doneTypingInterval = 500;  //time in ms, 5 second for example

    var typingTimer2;                //timer identifier
    var doneTypingInterval = 500;  //time in ms, 5 second for example

    $("#username").on('keyup', function () {
        clearTimeout(typingTimer);
        typingTimer = setTimeout(doneTyping, doneTypingInterval);
    });

    $("#username").on('keydown', function () {
        clearTimeout(typingTimer);
    });

    function doneTyping() {
        var val = $("#username").val();
        if (val != '') {
            $("#checkUsername").show();
            $("#checkUsername").html('<img class="small_img" src="<?php echo $path ?>images/search.gif"> checking ' + val);
            $.post("<?php echo $path ?>php/check.php", {val: val, flag: 1}, function (data) {
                if (data == 1) {
                    $("#checkUsername").html(' <span class="text-red"><i class="fa fa-times"></i>' + val + ' already in use.</span>');
                    $("#cuser").val(0);
                }
                if (data == 0) {
                    $("#checkUsername").html('<span class="text-green"><i class="fa fa-check"></i>' + val + ' is available</span>');
                    $("#cuser").val(1);
                }
            });
        } else {
            $("#checkUsername").hide();
            $("#cuser").val(0);
        }
    }
    $("#email").on('keyup', function () {
        clearTimeout(typingTimer2);
        typingTimer2 = setTimeout(doneTyping2, doneTypingInterval);
    });

    $("#email").on('keydown', function () {
        clearTimeout(typingTimer2);
    });

    function validateEmail(email) {
        var re = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
        return re.test(email);
    }
    function doneTyping2() {
        var val = $("#email").val();
        var validate = validateEmail(val);

        if (val != '') {
            $("#checkEmail").show();
            if (validate == true) {
                $("#checkEmail").html('<img class="small_img" src="<?php echo $path ?>images/search.gif"> checking ' + val);
                $.post("<?php echo $path ?>php/check.php", {val: val, flag: 2}, function (data) {
                    if (data == 1) {
                        $("#cemail").val(0);
                        $("#checkEmail").html(' <span class="text-red"><i class="fa fa-times"></i>' + val + ' already in use.</span>');
                    }
                    if (data == 0) {
                        $("#checkEmail").html('<span class="text-green"><i class="fa fa-check"></i>' + val + ' is available</span>');
                        $("#cemail").val(1);
                    }
                });
            } else {
                $("#checkEmail").html('<span class="text-red"><i class="fa fa-times"></i>' + val + ' is not a valid email</span>');
                $("#cemail").val(0);
            }
        } else {
            $("#checkEmail").hide();
            $("#cemail").val(0);
        }
    }

    $(document).ready(function () {
        $("#username").focus();
    });

    $("#hideAlert").click(function () {
        $("#error_log").fadeOut();
    });
</script>