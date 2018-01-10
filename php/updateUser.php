<?php
include "../classes/get.php";
include "../classes/post.php";
$get = new Get();
$post = new Post();
$path = '/geotag_web/';
session_start();
$username = $_POST['username'];
$fname = $_POST['fname'];
$lname = $_POST['lname'];
$email = $_POST['email'];
$stationId = $_POST['stationId'];
$divisionId = $_POST['divisionId'];
$cuser = $_POST['cuser'];
$cemail = $_POST['cemail'];
$purpose = $_POST['purpose'];
$level = $_POST['level'];
$userId = $_POST['userId'];
$isActive = $_POST['isActive'];
$error = 'Successfull. Please wait...';


if (isset($_POST['registerMe'])) {
    $checkUsername = $get->checkValue2('tbl_users', 'username', 'userId', $username, $userId);
    $checkEmail = $get->checkValue2('tbl_users', 'email', 'userId', $email, $userId);
 
    if ($username == '' or $fname == '' or $lname == '' or $email == '' or $purpose == '') {
        $error = 'Please fill all required fields.';
    } else if ($checkUsername > 0) {
        $error = 'Please input other username.';
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL) or $checkEmail > 0) {
        $error = 'Please input other email.';
    }

    if ($error == 'Successfull. Please wait...') {
        $date = date('Y-m-d');
        $register = $post->updateUser($username, $fname, $lname, $email, $stationId, $divisionId, $date, $purpose, $level, $userId, $isActive);

        if ($register == 1) {
            ?>
            <script>
                parent.$(".alert").hide();
                parent.$("#success_log").fadeIn();
               
            </script>
            <?php
        } else {
            ?>
            <script>
                parent.$(".alert").hide();
                parent.$("#error_log").fadeIn();
                parent.$("#error_msg").text("Error in saving. Please try again.");
            </script>
            <?php
        }
    } else {
        ?>
        <script>
            parent.$(".alert").hide();
            parent.$("#error_log").fadeIn();
            parent.$("#error_msg").text("<?php echo $error ?>");
        </script>
        <?php
    }
}
?>