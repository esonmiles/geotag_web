<?php
session_start();
$userId = $_SESSION['userId'];
if (isset($_POST) && !empty($_POST)) {
    include "../classes/barcode/php-barcode.php";
    include "../classes/post.php";
    $post = new Post();

    $projectNameComplete = $_POST['projectNameComplete'];
    $projectNameShort = $_POST['projectNameShort'];
    $projectCode = $_POST['projectCode'];
    $projectPref = $_POST['projectPref'];
    $error = 0;
    $checkCode = $post->checkCode($projectCode, $userId);
    $checkName = $post->checkName($projectNameComplete, $userId);
    if ($checkCode > 0) {
        $error = 1;
    }
    else if ($checkName > 0) {
        $error = 2;
    }
    else $error = 3;
    if ($error == 3) {
        $post->postInsertProjectInfo($projectNameComplete, $projectNameShort, $projectCode, $projectPref, $userId);
    }
    echo $error;
}
?>