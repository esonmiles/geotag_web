<?php
session_start();

include "../classes/get.php";
$path = '/geotag_web/';
$get = new Get();
$userId = $_SESSION['userId'];
?>
<div class="pagePanel" >
    <div class="modal fade bs-example-modal-md" id="updateModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content" id="updateLoader"></div>
        </div>
    </div>
    <div class="modal fade bs-example-modal-md" id="updateModal2" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content" id="updateLoader2"></div>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Users</h2>&nbsp; 
                    <button data-toggle="modal" data-target="#updateModal" class="btn btn-info btn-sm print" id="addUser"> Add User </button>
                    <div class="clearfix"></div>
                </div>

                <div class="x_content">
                    <table id="datatable-responsive2" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th class="text-center">Status</th>
                                <th class="text-center">Username</th>
                                <th class="text-center">Fullname</th>
                                <th class="text-center">Email</th>
                                <th class="text-center">Division</th>
                                <th class="text-center">Station</th>
                                <th class="text-center">Registered date</th>
                                <th class="text-center">Purpose</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $getUsers = $get->getUsers();
                            foreach ($getUsers as $sid => $projectInfo) {
                                $isActive = $projectInfo['isActive'];
                                $station = $get->getStation($projectInfo['stationId']);
                                $division = $get->getDivision($projectInfo['divisionId']);

                                if ($station == '')
                                    $station = 'N/A';
                                if ($division == '')
                                    $division = 'N/A';
                                
                                if ($isActive == 0)
                                    $status = 'Inactive';
                                else
                                    $status = 'Active';

                                if ($isActive == 0)
                                    $button2 = '<button class="btn btn-success btn-sm approveUser" for="' . $projectInfo['userId'] . '" id="app_but' . $projectInfo['userId'] . '"> Approve User </button>';
                                else
                                    $button2 = '';
                                ?>
                                <tr>
                                    <td class="text-center"><?php echo $status; ?></td>
                                    <td class="text-center"><?php echo $projectInfo['username']; ?></td>
                                    <td class="text-center"><?php echo $projectInfo['fname'] . ' ' . $projectInfo['lname']; ?></td>
                                    <td class="text-center"><?php echo $projectInfo['email']; ?></td>
                                    <td class="text-center"><?php echo $division; ?></td>
                                    <td class="text-center"><?php echo $station; ?></td>
                                    <td class="text-center"><?php echo $projectInfo['registered_date']; ?></td>
                                    <td class="text-center"><?php echo $projectInfo['purpose']; ?></td>
                                    <td class="text-center">
    <?php echo $button2; ?>
                                        <button class="btn btn-primary btn-sm updateUser" data-toggle="modal" data-target="#updateModal2" id="<?php echo $projectInfo['userId']; ?>"> Update </button>    
                                        <button class="btn btn-warning btn-sm cpass" data-toggle="modal" data-target="#changeModal" id="<?php echo $projectInfo['userId']; ?>"> Change password </button>          
                                    </td>
                                </tr>                
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <iframe name="targetSave" id="targetSave" style="display:none;"></iframe>

</div>  
<script>
    $("#addUser").click(function () {
        $("#updateLoader").load("<?php echo $path ?>php/addUser.php", {}, function () {

        });
    });
    $(".cpass").click(function () {
        var id = $(this).attr("id");
        $("#changeLoader").html("");
        $("#changeLoader").load("<?php echo $path ?>php/changePass.php", {id: id}, function () {

        });
    });

    $(".updateUser").click(function () {
        var id = $(this).attr("id");
        $("#updateLoader2").html("");
        $("#updateLoader2").load("<?php echo $path ?>php/editUser.php", {id: id}, function () {

        });
    });
    $(document).ready(function () {
        $('#datatable-responsive2').DataTable({
            "aaSorting": []
        });
    });
    $(".approveUser").click(function () {
        var id = $(this).attr("for");
        if (confirm('Are you sure to want to approve this data?')) {
            $(this).addClass("disabled");
            $.post("<?php echo $path ?>php/approveUser.php", {id: id}, function () {
                alert("Successfully approved user!");
                $("#app_but" + id).removeClass("disabled");
                $("#content_loader").addClass("disabled");
                $("#content_loader").load("<?php echo $path ?>php/load.php", {purpose: 'usermanagement'}, function () {
                    $("#content_loader").removeClass("disabled");
                });
            });
        } else {
            event.preventDefault();
        }
    });
</script>