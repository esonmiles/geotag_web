<?php
$projectId = $_POST['projectId'];
$surveyId = $_POST['surveyId'];
echo '<iframe id="the_iframe" src="' . $path . 'php/viewOne.php?time=' . time() . '&projectId=' . $projectId . '&surveyId=' . $surveyId . '" style="width: 100%;"></iframe>';
?>
