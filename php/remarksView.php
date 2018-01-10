<?php
$surveyId = $_POST['surveyId'];
$projectId = $_POST['projectId'];
$active = $_POST['active'];

include "../classes/get.php";
$get = new Get();
$getRemarks = $get->getRemarks($surveyId);
foreach ($getRemarks as $id=>$record):
    $msg = $record['fb_message'];
    $remarks = $record['fb_remarks'];
endforeach;

if($msg != '') $final = $msg;
else if($remarks !='') $final = $remarks;
else $final = 'No Available Remarks.';
?>

<div class="modal-content" id="remarks">
    <div class="modal-header">
        <button type="button" class="close" id="closeModal2" data-dismiss="modal"><span aria-hidden="true"></span></button>
        <h4 class="modal-title" id="myModalLabel">Remarks</h4>
    </div>
    <div class="modal-body">
        <div class="form-group">
            <textarea class="form-control" id="remarks_text" disabled=""><?php echo $final?></textarea>
        </div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    </div>
</div>

<script>

</script>
