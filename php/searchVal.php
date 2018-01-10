<?php
session_start();

include "../classes/getLoc.php";

$path = "/riceBIS/questionnaire/";
$projectId = $_SESSION['projectId'];
$userId = $_SESSION['userId'];

$fieldId = $_POST['fieldId'];
$val = $_POST['val'];

$get = new GetLoc();

$getRes = $get->search($fieldId, $val, $projectId);
$ctr = 0;
foreach ($getRes as $id => $record){
    $surveyId = $record['surveyId'];
    $getText = $get->getInfo($surveyId);
    $text = '';
    foreach ($getText as $id2 => $record2){
        $text .= $record2['value'] . ' > ';
    }

    //$text .= $record2['durationSurvey'] . ' > ' .$record2['yearSurvey'];
    
    $text = rtrim($text, "> ");
    echo '<p for="' . $record['surveyId'] . '" class="text-muted result selectRes">' . $text . '</p>';
    $ctr ++;
}

if ($ctr == 0)
    echo '<p class="text-muted result">No results found</p>';
?>

<script>
    $(".selectRes").click(function () {
        var surveyId = $(this).attr("for");
        var text = $(this).text();
        $("#surveyId").val(surveyId);
        $("#searchField").val(text);
        $("#results").hide();
    });
</script>