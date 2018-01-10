<!DOCTYPE html>
<?php
include "classes/get.php";
session_start();
$get = new Get();
$path = '/geotag_web/';
$root = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/';
if (!isset($_SESSION['userId']))
    header('Location:' . $root . 'geotag_web/login');
$userId = $_SESSION['userId'];
$getUser = $get->getUser($_SESSION['userId']);
foreach ($getUser as $id => $record):
    $full_name = $record['fname'] . ' ' . $record['lname'];
    $level = $record['level'];
endforeach;

if ($level == 2) {
    $button = '<li class="dashboard" id="section_user" for="usermanagement"><a href="#"><i class="fa fa-user"></i> User management </a><ul class="nav child_menu" style="display: none;"></ul></li>';
}
?>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <!-- Meta, title, CSS, favicons, etc. -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>PhilRice GeoTagging Tool </title>

        <!-- Bootstrap -->
        <link href="<?php echo $path ?>vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
        <!-- Font Awesome -->
        <link rel="shortcut icon" type="image/x-icon" href="<?php echo $path; ?>images/philrice_presence_logo.png" />
        <link href="<?php echo $path ?>vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">

        <!-- Custom Theme Style -->
        <link href="<?php echo $path ?>build/css/custom.min.css" rel="stylesheet">
        <link href="<?php echo $path ?>css/style.css" rel="stylesheet">
        <script src="<?php echo $path ?>vendors/jquery/dist/jquery.min.js"></script>
        <!-- Bootstrap -->
        <script src="<?php echo $path ?>vendors/bootstrap/dist/js/bootstrap.min.js"></script>
        <script src="<?php echo $path ?>vendors/datatables.net/js/jquery.dataTables.min.js"></script>
        <script src="<?php echo $path ?>vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
        <script src="<?php echo $path ?>vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
        <script src="<?php echo $path ?>vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>
        <script src="<?php echo $path ?>vendors/datatables.net-buttons/js/buttons.flash.min.js"></script>
        <script src="<?php echo $path ?>vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>
        <script src="<?php echo $path ?>vendors/datatables.net-buttons/js/buttons.print.min.js"></script>
        <script src="<?php echo $path ?>vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>
        <script src="<?php echo $path ?>vendors/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
        <script src="<?php echo $path ?>vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
        <script src="<?php echo $path ?>vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>
        <script src="<?php echo $path ?>vendors/datatables.net-scroller/js/dataTables.scroller.min.js"></script>
        <!-- FastClick -->
    </head>

    <div class="modal fade bs-example-modal-md" id="changeModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content" id="changeLoader"></div>
        </div>
    </div>
    <body class="nav-md">
        <div class="container body">
            <div class="main_container">
                <div class="col-md-3 left_col">
                    <div class="left_col scroll-view">
                        <div class="navbar nav_title" style="border: 0;height:100px;">
                            <a href="index.html" class="site_title" style="text-align: center;height:100%;background: #ededed;border-right: 1px solid #e3e3e3;">
                                <img style="width: 45%;margin-left: 0;border-radius: 0;background: #ededed;border: none;margin-top: 0;" src="images/app_logo.png" alt="..." class="img-circle profile_img"></i></a>
                        </div>
                        <div class="clearfix"></div>
                        <br />

                        <!-- sidebar menu -->
                        <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
                            <div class="menu_section">
                                <ul class="nav side-menu">
                                    <li class="dashboard" id="section_ProjectList" for="projectList"><a href="#"><i class="fa fa-list"></i> Project List </a><ul class="nav child_menu" style="display: none;"></ul></li>
                                    <li class="dashboard" id="section_Data" for="datamanagement"><a href="#"><i class="fa fa-database"></i> Data management </a><ul class="nav child_menu" style="display: none;"></ul></li>
                                    <?php echo $button; ?>
                                </ul>
                                <h3>Projects (ongoing)</h3>
                                <ul class="nav side-menu">
                                    <?php
                                    $getProj = $get->getProjects($userId);
                                    foreach ($getProj as $id => $record):
                                        $proj_name = $record['project_name'];
                                        $image = $record['image'];
                                        if ($image == '')
                                            $image = 'pr.png';
                                        echo '<li>
                                                <a title="' . $record['project_name'] . '"><img src="images/' . $image . '" class="small" style="width: 15%;max-height:35px;"> ' . $record['abbr'] . ' <span class="fa fa-chevron-down"></span></a>';
                                        echo '
                                                <ul class="nav child_menu">
                                                    <li class="menu_dynamic" for="view_map-' . $record['projectId'] . '"><a>View Map</a></li>
                                                </ul>
                                            </li>';
                                    endforeach;
                                    ?>

                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <!--<li class="menu_dynamic" for="web_analytics-' . $record['projectId'] . '"><a>Web Analytics</a></li>-->
                <!-- top navigation -->
                <div class="top_nav">
                    <div class="nav_menu">
                        <nav>
                            <div class="nav toggle">
                                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
                            </div>

                            <ul class="nav navbar-nav navbar-right">
                                <li class="">
                                    <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                        <img src="images/img.jpg" alt=""><?php echo $full_name; ?>
                                        <span class=" fa fa-angle-down"></span>
                                    </a>
                                    <ul class="dropdown-menu dropdown-usermenu pull-right">
                                        <li><a href="javascript:;"> Profile</a></li>
                                        <li id="changePass" data-toggle="modal" data-target="#changeModal"><a><i class="fa fa-gear pull-right"></i> Change Password</a></li>
                                        <li id="logMeOut"><a><i class="fa fa-sign-out pull-right"></i> Log Out</a></li>
                                    </ul>
                                </li>
                                <?php
                                $countNotif = $get->countNotif($userId);
                                ?>
                                <li role="presentation" class="dropdown">
                                    <a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">
                                        <i class="fa fa-envelope-o"></i>
                                        <span class="badge bg-green" id="notifCount"><?php echo $countNotif ?></span>
                                    </a>
                                    <ul id="menu1" class="dropdown-menu list-unstyled msg_list" role="menu">
                                        <?php
                                        $getNotif = $get->getNotif($userId);
                                        foreach ($getNotif as $id => $record):
                                            echo '
                                            <li class="readNotifs" for="' . $record['surveyId'] . '">
                                                <a>
                                                    <span class="image"><img src="images/img.jpg" alt="Profile Image" /></span>
                                                    <span>
                                                        <span>System</span>
                                                        <span class="time"></span>
                                                    </span>
                                                    <span class="message">
                                                        New pending data from project ' . $record['project_name'] . '
                                                    </span>
                                                </a>
                                            </li>';
                                        endforeach;
                                        ?>

                                        <li id="seeAll">
                                            <div class="text-center">
                                                <a>
                                                    <strong>See All Alerts</strong>
                                                    <i class="fa fa-angle-right"></i>
                                                </a>
                                            </div>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
                <!-- /top navigation -->
                <div class="right_col" role="main" id="content_loader">
                    <!-- top tiles -->
                    <div><h2></h2></div>
                </div>
                <!-- /page content -->

                <!-- footer content -->
                <footer>
                    <div class="pull-right">
                        Information Systems Division. PhilRice Science City of Muñoz Nueva Ecija
                    </div>
                    <div class="clearfix"></div>
                </footer>
                <!-- /footer content -->
            </div>
        </div>

        <!-- jQuery -->
        <!-- Flot plugins -->

        <!-- Custom Theme Scripts -->
        <script src="<?php echo $path ?>build/js/custom.min.js"></script>

    </body>
</html>
<script>
    $(".readNotifs").click(function () {
        var id = $(this).attr("for");
        $.post("<?php echo $path ?>php/readNotif.php", {flag: 2, id: id}, function (data) {
            $("#section_Data").trigger("click");
            if (data == 0)
                data = '';
            else
                data = data;
            $("#notifCount").text(data);
        });
    });
    
    $(".menu_dynamic").click(function () {
        var purpose = $(this).attr("for");
        $("#content_loader").load("<?php echo $path ?>php/load.php", {purpose: purpose});
    });
    $("#seeAll").click(function () {
        $.post("<?php echo $path ?>php/readNotif.php", {flag: 1}, function (data) {
            $("#section_Data").trigger("click");
            if (data == 0)
                data = '';
            else
                data = data;
            $("#notifCount").text(data);
        });
    });
    $("#changePass").click(function () {
        $("#changeLoader").html("");
        $("#changeLoader").load("<?php echo $path ?>php/changePass.php", {id: <?php echo $userId; ?>}, function () {

        });
    });
    $(".dashboard").click(function () {
        var purpose = $(this).attr("for");
        $("#content_loader").addClass("disabled");
        $("#content_loader").load("<?php echo $path ?>php/load.php", {purpose: purpose}, function () {
            $("#content_loader").removeClass("disabled");
        });
    });

    $("#logMeOut").click(function () {
        $.post("<?php echo $path ?>php/logout.php", {}, function () {
            location.reload();
        });
    });
    $(document).ready(function () {
        $("#section_ProjectList").trigger("click");
    });
</script>

