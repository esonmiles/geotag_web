<?php
include "../classes/get.php";
session_start();
$get = new Get();
$path = '/geotag_web/';

$search = $_POST['search'];

$getSearch = $get->searchProj($search);
$ctr = 0;
foreach ($getSearch as $id => $record):
    echo '<p class="lead results" for="' . $record['projectId'] . '">' . $record['project_name'] . ' (' . $record['project_code'] . ')</p>';
    $ctr++;
endforeach;
if ($ctr == 0)
    echo '<p class="lead">No results found</p>';
?>

<script>

    $(".results").click(function () {
        var val = $(this).text();
        var id = $(this).attr("for");
        $("#searchText").val(val);
        $("#activeSearch").val(id);
        $("#result").hide();
        $("#resTable").load("<?php echo $path ?>php/loadTable.php",{id:id});
    });
</script>