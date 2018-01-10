<?php
$projectId = $_POST['projectId'];
echo '<iframe id="the_iframe" src="' . $path . 'php/view.php?time=' . time() . '&projectId=' . $projectId . '" style="width: 100%;"></iframe>';
?>
