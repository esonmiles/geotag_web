<?php
$projectId = $_POST['projectId'];

include "../classes/get.php";

$get = new Get();
$path = '/geotag_web/';
$getProject = $get->getProject($projectId);

foreach($getProject as $id=>$record):
    $project_name = $record['project_name'];
    $project_key = $record['project_key'];
endforeach;
?>

<div class="modal-content" id="updateDiv">
    <div class="modal-header">
        <button type="button" class="close" id="closeModal2" data-dismiss="modal"><span aria-hidden="true"></span></button>
        <h4 class="modal-title" id="myModalLabel">View Barcode</h4>
    </div>
    <div class="modal-body" style="text-align: center;">
        <img style="width:80%;" src="<?php echo $path?>barcodes/projectkey/<?php echo $project_key;?>.png">
        <div class="text-muted"><?php echo $project_key?></div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    </div>
</div>

<script>
</script>