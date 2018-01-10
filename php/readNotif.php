<?php

session_start();
$userId = $_SESSION['userId'];

    include "../classes/barcode/php-barcode.php";
    include "../classes/post.php";
    $post = new Post();

    $flag = $_POST['flag'];
    $surveyId = $_POST['id'];

    if ($flag == 1)
        $update = $post->readNotif($userId);
    if ($flag == 2)
        $update = $post->readNotif2($surveyId);
    
    $countNotif = $post->countNotif($userId);

    echo $countNotif;
?>