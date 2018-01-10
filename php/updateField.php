<?php
session_start();
$userId = $_SESSION['userId'];
if (isset($_POST) && !empty($_POST)) {
    include "../classes/barcode/php-barcode.php";
    include "../classes/post.php";
    $post = new Post();

    $field_name = $_POST['field_name'];
    $isRequired = $_POST['isRequired'];
    $isActive = $_POST['isActive'];
    $fieldId = $_POST['id'];
    
    $update = $post->updateField($fieldId, $field_name, $isRequired, $isActive);
}
?>