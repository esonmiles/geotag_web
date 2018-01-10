<script>
    parent.$(document).ready(function () {
        parent.$(".alert").hide();
    });
</script>
<?php
include "../classes/get.php";
$get = new Get();
$path = '/geotag_web/';
session_start();
$username = $_POST['username'];
$password = $_POST['password'];
$check = 0;
$checkUsername = $get->checkUsername($username, 1);

if ($checkUsername > 0) {
    $getUser = $get->checkUsername($username, 2);
    foreach ($getUser as $record):
        $pass = $record['password'];
        $userId = $record['userId'];
        $isActive = $record['isActive'];
        $isVerified = $record['isVerified'];
    endforeach;
    if ($pass == md5($password)) {
        if ($isActive == 0) {
            $check = 0;
            $error = 'Your account is not yet approved.';
        } else if ($isVerified == 0) {
            $check = 0;
            $error = 'Your account is not yet verified.';
        } else {
            $check = 1;
        }
    } else {
        $check = 0;
        $error = 'Password not matched.';
    }
} else {
    $check = 0;
}

if ($check > 0) {
    $_SESSION['userId'] = $userId;
    ?>
    <script>
        parent.$(".alert").hide();
        parent.$("#success_log").fadeIn();
        parent.location.reload();
    </script>
    <?php
} else {
    ?>
    <script>
        parent.$(".alert").hide();
        parent.$("#error_log").fadeIn();
        parent.$("#error_mess").text("<?php echo $error ?>");
    </script>
    <?php
}
?>

