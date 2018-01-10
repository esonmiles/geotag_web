<?php
include "../classes/get.php";
include "../classes/post.php";
$get = new Get();
$post = new Post();
$path = '/geotag_web/';
session_start();
$username = $_POST['username'];
$password = $_POST['password'];
$cpassword = $_POST['cpassword'];
$fname = $_POST['fname'];
$lname = $_POST['lname'];
$email = $_POST['email'];
$stationId = $_POST['stationId'];
$divisionId = $_POST['divisionId'];
$cuser = $_POST['cuser'];
$cemail = $_POST['cemail'];
$purpose = $_POST['purpose'];
$error = 'Successfull. Please wait...';


if (isset($_POST['registerMe'])) {
    $checkUsername = $get->checkValue('tbl_users', 'username', 'userId', $username);
    $checkEmail = $get->checkValue('tbl_users', 'email', 'email', $email);

    if ($username == '' or $password == '' or $fname == '' or $lname == '' or $email == '' or $purpose == '') {
        $error = 'Please fill all required fields.';
    } else if ($password != $cpassword) {
        $error = 'Password not matched.';
    } else if ($checkUsername > 0) {
        $error = 'Please input other username.';
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL) or $checkEmail > 0) {
        $error = 'Please input other email.';
    }

    if ($error == 'Successfull. Please wait...') {
        $date = date('Y-m-d');
        $register = $post->register($username, $password, $fname, $lname, $email, $stationId, $divisionId, $date, $purpose);

        if ($register == 1) {
            ?>
            <script>
                parent.$(".alert").hide();
                parent.$("#success_log").fadeIn();
                parent.$("#registration_div").hide();
                parent.$("#redirect").show();
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