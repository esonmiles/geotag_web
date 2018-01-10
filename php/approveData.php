<?php

session_start();
$userId = $_SESSION['userId'];

include "../classes/barcode/php-barcode.php";
include "../classes/post.php";
$post = new Post();



$remarks_text = $_POST['remarks_text'];
$getSurvey = $post->getSurvey($_POST['id']);
foreach ($getSurvey as $tid => $record):
    $macAddress = $record['macAddress'];
    $survey_name = $record['survey_name'];
    $projectId = $record['projectId'];
endforeach;
if ($_POST['action'] == 2) {
    if($remarks_text == '') $remarks_text = 'Your data has been disapproved.';
    $postRemarks = $post->postRemarks($remarks_text, $_POST['id'], $projectId, $macAddress, $survey_name);
}
if ($_POST['action'] == 1) {
    $remarks_text = 'Your data has been approved.';
    $postRemarks = $post->postRemarks($remarks_text, $_POST['id'], $projectId, $macAddress, $survey_name);
}
$approve = $post->approveData($_POST['id'], $_POST['action']);
?>