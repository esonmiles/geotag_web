<?php

$purpose = $_POST['purpose'];

$exp = explode("-", $purpose);

$for = $exp[0];
$projectId = $exp[1];

if($for == 'projectList') 
    include "projects.php";
if($for == 'datamanagement') 
    include "data.php";
if($for == 'usermanagement') 
    include "users.php";
if($for == 'view_map') 
    include "view_map.php";
    
    ?>
