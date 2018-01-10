<?php
include "../classes/get.php";
session_start();
$get = new Get();
$path = '/geotag_web/';

$fieldId = $_POST['id'];

$getField = $get->getField($fieldId);

foreach ($getField as $id => $record):
    $field_name = $record['field_name'];
    $isRequired = $record['isRequired'];
    $isActive = $record['isActive'];

    if ($isRequired == 1)
        $isChecked = 'checked';
    else
        $isChecked = '';
endforeach;
?>
<div class="modal-content" id="updateDiv">
    <div class="modal-header">
        <button type="button" class="close" id="closeModal2" data-dismiss="modal"><span aria-hidden="true"></span></button>
        <h4 class="modal-title" id="myModalLabel">Update Field</h4>
    </div>
    <div class="modal-body">
        <span class="fa fa-exclamation"></span> <code>required fields</code>
        <div class="form-group"></div>
        <div class="form-group">
            <div class="input-group">
                <div class="input-group-addon"><span class="fa fa-exclamation"></span></div>
                <input id="field_name" type="text" class="form-control input-lg" placeholder="Field Name" required value="<?php echo $field_name; ?>">
            </div>                      
        </div>
        <div class="form-group">
            <div class="input-group">
                <input style="margin-left: 30px;" type="checkbox" value="1" id="isRequired" name="isRequired" <?php echo $isChecked; ?>> Required
            </div>
        </div> 
        <div class="form-group">
            <div class="input-group">
                <div class="input-group-addon"><span class="fa fa-exclamation"></span></div>
                <select class="form-control" id="isActive">
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
                </select>
            </div>                      
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="updateField">Update</button>
    </div>
</div>

<script>
    $("#isActive").val("<?php echo $isActive ?>");

    $("#updateField").click(function () {
        var field_name = $("#field_name").val();
        var isActive = $("#isActive").val();
        var isRequired = document.getElementById("isRequired").checked;
        if (isRequired == true)
            isRequired = 1;
        else
            isRequired = 0;

        if (field_name != '') {
            $(this).addClass("disabled");
            $.post("<?php echo $path ?>php/updateField.php", {id:<?php echo $fieldId ?>, field_name: field_name, isRequired: isRequired, isActive: isActive}, function () {
                alert("Updated!");
                $('#updateModal2').modal('toggle');
                $("#updateField").removeClass("disabled");
                $("#content_loader").addClass("disabled");

                setTimeout(function () {
                    $(".pagePanel").load("<?php echo $path ?>php/viewFieldRecords.php", {projectId: <?php echo $_POST['projectId']; ?>}, function () {
                        $("#content_loader").removeClass("disabled");
                    });
                }, 1000);

            });
        } else {
            alert("Enter field name!");

        }

    });
</script>