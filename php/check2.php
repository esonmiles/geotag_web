<?php
include "../classes/get.php";
$get = new Get();
session_start();
$path = '/geotag_web/';
$root = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/';

$flag = $_POST['flag'];
$val = $_POST['val'];
$userId = $_POST['id'];

if($flag == 1) {
    $table = 'tbl_users';
    $col = 'username';
    $id = 'userId';
}

if($flag == 2) {
    $table = 'tbl_users';
    $col = 'email';
    $id = 'userId';
}
$check = $get->checkValue2($table, $col, $id, $val, $userId);

echo $check;
?>
