<?php
session_start();
$userId = $_SESSION['userId'];
if (isset($_POST) && !empty($_POST)) {
    include "../classes/barcode/php-barcode.php";
    include "../classes/post.php";
    $post = new Post();

    $proj_name = $_POST['proj_name'];
    $proj_abb = $_POST['proj_abb'];
    $proj_code = $_POST['proj_code'];
    $proj_pref = $_POST['proj_pref'];
    $projectId = $_POST['id'];
    $isActive = $_POST['isActive'];
    $error = 0;
    $checkCode = $post->checkCode2($proj_code, $userId, $projectId);
    $checkName = $post->checkName2($proj_name, $userId, $projectId);
    if ($checkCode > 0) {
        $error = 1;
    }
    else if ($checkName > 0) {
        $error = 2;
    }
    else $error = 3;
    if ($error == 3) {
        $post->updateProj($proj_name, $proj_abb, $proj_code, $proj_pref, $projectId, $isActive);
    }
    echo $error;
}
?>