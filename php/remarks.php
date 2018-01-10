<?php
$surveyId = $_POST['surveyId'];
$projectId = $_POST['projectId'];
$active = $_POST['active'];

include "../classes/get.php";
?>

<div class="modal-content" id="remarks">
    <div class="modal-header">
        <button type="button" class="close" id="closeModal2" data-dismiss="modal"><span aria-hidden="true"></span></button>
        <h4 class="modal-title" id="myModalLabel">Add Remarks</h4>
    </div>
    <div class="modal-body">
        <div class="form-group">
            <textarea class="form-control" id="remarks_text"></textarea>
        </div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="addRemark">Submit</button>
    </div>
</div>

<script>
    $("#addRemark").click(function () {
        $(this).addClass("disabled");
        var remarks_text = $("#remarks_text").val();
        $.post("<?php echo $path ?>php/approveData.php", {action: 2, remarks_text: remarks_text, id:<?php echo $surveyId ?>, projectId:<?php echo $projectId ?>}, function () {
            alert("Data successfully disapproved!");
            $("#addRemark").removeClass("disabled");
            $("#viewModal").modal('toggle');
            setTimeout(function () {
                $("#optionsRadios<?php echo $active; ?>").trigger("click");
            }, 1000);
        });
    });

</script>
