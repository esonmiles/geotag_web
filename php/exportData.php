<?php

include "../classes/get.php";
$path = '/geotag_web/';
$get = new Get();
session_start();
$userId = $_SESSION['userId'];
$projectId = $_GET['id'];
$getProj = $get->getProject($projectId);
foreach ($getProj as $id => $record):
    $proj_name = $record['project_name'];
endforeach;
$proj_name = str_ireplace(" ", "_", $proj_name);
if (isset($userId)) {
    $getFields = $get->getFields($projectId);
    $getFieldCount = $get->getFieldCount($projectId);
    $y = 1;
    $header[] = '#,Survey_name,Latitude,Longitude,Date,';
    foreach ($getFields as $id => $record):
        $field = $record['field_name'];
        $field = str_ireplace(" ", "_", $field);
        $field = str_ireplace(",", "_", $field);
        $field = str_ireplace(".", "_", $field);
        $field = str_ireplace("-", "_", $field);
        if ($getFieldCount != $y) {
            $header[] .= $field . ',';
        } else
            $header[] .= $field;
        $y++;
    endforeach;
    $delimiter = ' ';
    $filename = $proj_name . "_data" . time() . '.csv';
    $fp = fopen('php://output', 'w');
    fputcsv($fp, $header, $delimiter);

    header('Content-type: application/csv');
    header('Content-Disposition: attachment; filename=' . $filename);
    $getSurveys = $get->getSurveysApproved($projectId);
    $counter = 1;
    foreach ($getSurveys as $id => $record):
        $date = $record['year'] . '/' . $record['month'] . '/' . $record['day'];
		$sname = $record['survey_name'];
        $sname = str_ireplace(" ", "_", $sname);
        $sname = str_ireplace(",", "_", $sname);
        $sname = str_ireplace(".", "_", $sname);
        $sname = str_ireplace("-", "_", $sname);
        $body = '';
        $body[] .= $counter . ',' . $sname . ',' . $record['latitude'] . ',' . $record['longitude'] . ',' . $date . ',';
        $getFields = $get->getFields($projectId);
        foreach ($getFields as $id => $record2):
            $fieldId = $record2['fieldId'];
            $getValue = $get->getValue($record['surveyId'], $fieldId);
            $getValue = str_ireplace(" ", "_", $getValue);
            $getValue = str_ireplace(",", "_", $getValue);
            $body[] .= $getValue . ',';
        endforeach;
        fputcsv($fp, $body, $delimiter);
        $counter++;
    endforeach;
    exit;
} else {
    echo 'You are not allowed to visit this page.';
}
?>