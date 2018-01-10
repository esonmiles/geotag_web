<?php
include "../classes/get.php";

$userId = $_POST['id'];
$get = new Get();
$path = '/geotag_web/';
?>

<div class="modal-content" id="updateDiv">
    <div class="modal-header">
        <button type="button" class="close" id="closeModal2" data-dismiss="modal"><span aria-hidden="true"></span></button>
        <h4 class="modal-title" id="myModalLabel">Update Password</h4>
    </div>
    <div class="modal-body">
        <div class="form-group">
            <input type="password" id="password" class="form-control" placeholder="New Password">
        </div>
        <div class="form-group">
            <input type="password" id="cpassword" class="form-control" placeholder="Confirm Password">
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal" id="closeMe">Close</button>
        <button id="changePass" type="button" class="btn btn-primary">Update</button>
    </div>
</div>

<script>
    $("#changePass").click(function () {
        var pass = $("#password").val();
        var cpass = $("#cpassword").val();

        if (pass == cpass && pass != '') {
        $(this).addClass("disabled");
            $.post("<?php echo $path ?>php/changePassAction.php", {id:<?php echo $userId ?>, pass: pass}, function () {
                alert("Password changed!");
                $("#closeMe").trigger('click');
                 $("#changePass").removeClass("disabled");
            });
        } else {
            alert("Password not matched");
        }
    });

</script>