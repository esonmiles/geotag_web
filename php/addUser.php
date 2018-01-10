<?php
include "../classes/get.php";

$get = new Get();
?>

<div class="modal-content" id="updateDiv">
    <div class="modal-header">
        <button type="button" class="close" id="closeModal2" data-dismiss="modal"><span aria-hidden="true"></span></button>
        <h4 class="modal-title" id="myModalLabel">Add User</h4>
    </div>
    <div class="modal-body">
        <iframe id="log_target" name="log_target" style="display: none"></iframe>
        <form  action="<?php echo $path ?>php/saveUser.php" method="post" target="log_target" class="form-horizontal form-label-left">
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
                <label class="control-label col-md-3 col-sm-3 col-xs-12">User Level</label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                    <select id="level" name="level" class="form-control">
                        <option value="1">Regular User</option>
                        <option value="2">Administrator</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Purpose <code>*</code></label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                    <textarea class="form-control" name="purpose" id="purpose"></textarea>
                </div>
            </div>

            <div class="pull-right">
                <button name="registerMe" type="submit" class="btn btn-primary submit" href="">Register</button>
                <input type="submit" name="registerMe" id="registerMe" class="hid">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </form>
    </div>
</div>

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
            $("#checkUsername").html('<img style="margin-left: 26%;" class="small_img" src="<?php echo $path ?>images/search.gif"> checking ' + val);
            $.post("<?php echo $path ?>php/check.php", {val: val, flag: 1}, function (data) {
                if (data == 1) {
                    $("#checkUsername").html(' <span class="text-red" style="margin-left: 26%;"><i class="fa fa-times"></i>' + val + ' already in use.</span>');
                    $("#cuser").val(0);
                }
                if (data == 0) {
                    $("#checkUsername").html('<span class="text-green" style="margin-left: 26%;"><i class="fa fa-check"></i>' + val + ' is available</span>');
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
                $("#checkEmail").html('<img style="margin-left: 26%;" class="small_img" src="<?php echo $path ?>images/search.gif"> checking ' + val);
                $.post("<?php echo $path ?>php/check.php", {val: val, flag: 2}, function (data) {
                    if (data == 1) {
                        $("#cemail").val(0);
                        $("#checkEmail").html(' <span class="text-red" style="margin-left: 26%;"><i class="fa fa-times"></i>' + val + ' already in use.</span>');
                    }
                    if (data == 0) {
                        $("#checkEmail").html('<span class="text-green" style="margin-left: 26%;"><i class="fa fa-check"></i>' + val + ' is available</span>');
                        $("#cemail").val(1);
                    }
                });
            } else {
                $("#checkEmail").html('<span class="text-red" style="margin-left: 26%;"><i class="fa fa-times"></i>' + val + ' is not a valid email</span>');
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