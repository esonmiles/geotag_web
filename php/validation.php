<?php

  include "../classes/get.php"; 

  $get = new Get();

  if (isset($_POST['projectNameComplete'])) {
    $projectNameComplete = $_POST['projectNameComplete'];
    $projectCount = $get->getProjectCount("project_name", $projectNameComplete);

    if ($projectCount == 0){
      echo '<p class="text-muted result">No results found (Valid)</p>';
    } else{
      echo '<p class="text-muted result">Invalid</p>';
    }
}
?>