<?php
session_start();
$userId = $_SESSION['userId'];
if (isset($_POST) && !empty($_POST)) {
    include "../classes/barcode/php-barcode.php";
    include "../classes/post.php";
    $post = new Post();

    $activeSearch = $_POST['activeSearch'];
    $proj_name = $_POST['proj_name'];
    $proj_abb = $_POST['proj_abb'];
    $proj_code = $_POST['proj_code'];
    $proj_pref = $_POST['proj_pref'];
    $error = 0;
    $checkCode = $post->checkCode($proj_code, $userId);
    $checkName = $post->checkName($proj_name, $userId);
    if ($checkCode > 0) {
        $error = 1;
    }
    else if ($checkName > 0) {
        $error = 2;
    }
    else $error = 3;
    if ($error == 3) {
        $post->postProjectTemplate($proj_name, $proj_abb, $proj_code, $proj_pref, $userId, $activeSearch);
    }
    echo $error;
}
?>