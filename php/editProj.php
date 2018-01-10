<?php
include "../classes/get.php";
session_start();
$get = new Get();
$path = '/geotag_web/';

$projectId = $_POST['id'];

$getProject = $get->getProject($projectId);

foreach ($getProject as $id => $record):
    $project_name = $record['project_name'];
    $abbr = $record['abbr'];
    $project_code = $record['project_code'];
    $survey_prefix = $record['survey_prefix'];
    $isActive = $record['isActive'];
    $project_key = $record['project_key'];
endforeach;
?>
<div class="modal-content" id="updateDiv">
    <div class="modal-header">
        <button type="button" class="close" id="closeModal2" data-dismiss="modal"><span aria-hidden="true">×</span></button>
        <h4 class="modal-title" id="myModalLabel">Update Project</h4>
    </div>
    <div class="modal-body">
        <span class="fa fa-exclamation"></span> <code>required fields</code>
        <div class="form-group"></div>
        <div class="form-group">
            <div class="input-group">
                <div class="input-group-addon"><span class="fa fa-exclamation"></span></div>
                <input id="proj_name2" type="text" class="form-control input-lg" placeholder="Project Name" required value="<?php echo $project_name; ?>">
            </div>                      
        </div>

        <div class="form-group">
            <div class="input-group">
                <div class="input-group-addon"><span class="fa fa-exclamation"></span></div>
                <input id="proj_abb2" type="text" class="form-control input-lg" placeholder="Project Abbreviation" required value="<?php echo $abbr; ?>">
            </div>
        </div>

        <div class="form-group">
            <div class="input-group">
                <div class="input-group-addon"><span class="fa fa-exclamation"></span></div>
                <input id="proj_code2" type="text" class="form-control input-lg" placeholder="Project Code" value="<?php echo $project_code; ?>">
            </div>                      
        </div>

        <div class="form-group">
            <div class="input-group">
                <div class="input-group-addon"><span class="fa fa-gear"></span></div>
                <input id="proj_pref2"  type="text" class="form-control input-lg" placeholder="Project Prefix (optional)" value="<?php echo $survey_prefix; ?>">
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
        <div class="form-group">
            <div class="input-group">
                <div class="input-group-addon"><span class="fa fa-gear"></span></div>
                <input id="proj_key"  disabled="" type="text" class="form-control input-lg" placeholder="Project Key" value="<?php echo $project_key; ?>">
            </div>                      
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="updateProj">Submit</button>
    </div>
</div>

<script>
    $("#isActive").val("<?php echo $isActive ?>");

    $("#updateProj").click(function () {
        var proj_name = $("#proj_name2").val();
        var proj_abb = $("#proj_abb2").val();
        var proj_code = $("#proj_code2").val();
        var proj_pref = $("#proj_pref2").val();
        var isActive = $("#isActive").val();
        if (proj_name != '' && proj_abb != '' && proj_code != '') {
            $(this).addClass("disabled");
            $("#updateDiv").addClass("disabled");
            $.post("<?php echo $path ?>php/updateProj.php", {id:<?php echo $projectId; ?>, proj_name: proj_name, proj_abb: proj_abb, proj_code: proj_code, proj_pref: proj_pref, isActive: isActive}, function (msg) {
                $("#updateProj").removeClass("disabled");
                $("#updateDiv").removeClass("disabled");
                if (msg == 1) {
                    alert("Project code already exist.");
                } else if (msg == 2) {
                    alert("Project name already exist.");
                } else {
                    alert("Project record updated!");
                    $('#updateModal').modal('toggle');
                    $("#content_loader").addClass("disabled");
                    $("#content_loader").load("<?php echo $path ?>php/load.php", {purpose: 'projectList'}, function () {
                        $("#content_loader").removeClass("disabled");
                    });

                }
            });
        } else {
            alert("Fill required fields!");

        }

    });
</script>