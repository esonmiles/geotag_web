<?php

session_start();
$userId = $_SESSION['userId'];
if (isset($_POST) && !empty($_POST)) {
    include "../classes/barcode/php-barcode.php";
    include "../classes/post.php";
    $post = new Post();

    $userId = $_POST['id'];
    $pass = md5($_POST['pass']);

    $update = $post->updatePass($userId, $pass);
}
?>