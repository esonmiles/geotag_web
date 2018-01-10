<?php
$projectId = $_POST['projectId'];

include "../classes/get.php";
$path = '/geotag_web/';
$get = new Get();
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
<div class="page-title">
    <hr>
    <div class="title_left">
        <div class="row pull-right">          
            <div class="btn-group btn-breadcrumb">

            </div>
        </div>
    </div>
    <div class="title_right">
        <div class="row pull-right">          
            <div class="btn-group btn-breadcrumb">
                <a href="#" class="btn btn-primary home"><i class="glyphicon glyphicon-home"></i></a>
                <a class="btn btn-primary home" id="bread_proj">Projects</a>
                <a href="#" class="btn btn-default" style="cursor:default">Add Project Field</a>
                <!-- <a href="#" class="btn btn-primary">Primary</a> -->
            </div>
        </div>      
    </div>
</div>

<div class="clearfix"></div>

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Add Field Record | <?php echo $project_name; ?></h2>
                <div class="clearfix"></div>
            </div>       

            <div class="x_content" id="resultPost">        
                <form class="form-horizontal form-label-left input_mask" method="POST" data-parsley-validate id="fieldForm" action="php/saveFieldRecord.php" target="targetSave">
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Field Name <span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" class="form-control has-feedback-left" id="field_name" name="field_name" placeholder="Field Name" required>
                            <span class="fa fa-tags form-control-feedback left" aria-hidden="true"></span>
                        </div>
                    </div>           
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12"><span class="required"></span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="checkbox" value="1" id="isRequired" name="isRequired"> Required
                        </div>
                    </div>  
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Field Type <span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select class="form-control" id="fieldType" name="fieldType" required>
                                <option value=""> Select Field Type </option>;
                                <?php
                                $getFieldTypes = $get->getFieldTypes();
                                foreach ($getFieldTypes as $ftid => $fieldTypes) {
                                    echo '<option value="' . $fieldTypes['fieldTypeId'] . '"> ' . $fieldTypes['fieldTypeDisplay'] . ' </option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group" id="subFieldTypeGroup">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Sub Field Type <span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select class="form-control" id="subFieldType" name="subFieldType" required>
                                <option value=""> Select Sub-Field Type </option>;
                                <?php
                                $getSubFieldTypes = $get->getSubFieldTypes();
                                foreach ($getSubFieldTypes as $sftid => $subFieldTypes) {
                                    echo '<option value="' . $subFieldTypes['subFieldTypeId'] . '"> ' . ucfirst($subFieldTypes['subFieldType']) . ' </option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group choicesGroup">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Choices <span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" class="form-control has-feedback-left choiceTextbox" id="choiceName1" name="choiceName1" placeholder="(1) Choices" required>
                            <span class="fa fa-list form-control-feedback left" aria-hidden="true"></span>
                        </div>
                    </div>

                    <div class="ln_solid" id="line"></div>

                    <div class="form-group" id="buttonGroup">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                            <input type="hidden" name="projectId" value="<?php echo $projectId; ?>">
                            <button class="btn btn-primary" type="button" id="cancelAdd">Cancel</button>
                            <button class="btn btn-primary addOption" id="addChoicesBtn">Add Option</button>
                            <button type="submit" class="btn btn-success" id="submitFieldForm">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<iframe name="targetSave" id="targetSave" style="display:none;"></iframe>

<script>
	$("#cancelAdd").click(function () {
        $("#content_loader").addClass("disabled");
        $("#content_loader").load("<?php echo $path ?>php/load.php", {purpose: 'projectList'}, function () {
            $("#content_loader").removeClass("disabled");
        });
    });
    $(".home").click(function () {
        $("#content_loader").addClass("disabled");
        $("#content_loader").load("<?php echo $path ?>php/load.php", {purpose: 'projectList'}, function () {
            $("#content_loader").removeClass("disabled");
        });
    });
    $("#submitFieldForm").click(function (event) {
        //event.preventDefault();
        if (confirm('Are you sure to save this record?')) {
            
            var value = $("#fieldType").val();

            if (value == 1) {
                $("#subFieldTypeGroup").prop('disabled', false);
                $(".addOption").prop('disabled', true);
            } else {
                $("#subFieldTypeGroup").prop('disabled', true);
                $(".addOption").prop('disabled', false);
            }
        } else {
            event.preventDefault();
        }
    });


    $(".choicesGroup").hide();
    $("#subFieldTypeGroup").hide();
    $("#addChoicesBtn").hide();



    $("#fieldType").change(function () {
        var value = $(this).val();
        if (value == 1) {
            $("#subFieldTypeGroup").show();
            $(".choicesGroup").hide();

            $(".addOption").hide();

            $("#subFieldType").prop('disabled', false);
            $(".choiceTextbox").prop('disabled', true);


        } else {
            $("#subFieldTypeGroup").hide();
            $(".choicesGroup").show();
            $(".addOption").show();

            $("#subFieldType").prop('disabled', true);
            $(".choiceTextbox").prop('disabled', false);

        }
    });

    $("#addChoicesBtn").click(function (event) {
        event.preventDefault();

    });

    $(".addOption").click(function (event) {

        var id = $(this).attr("id");
        var count = parseInt($('.choicesGroup').length + 1);

        var buttonAddChoices = '';

        buttonAddChoices = '<div class="form-group choicesGroup" id="choice_' + count + '">';
        buttonAddChoices += '<label class="control-label col-md-3 col-sm-3 col-xs-12"></label>';
        buttonAddChoices += '<div class="col-md-6 col-sm-6 col-xs-10">';
        buttonAddChoices += '<input type="text" class="form-control has-feedback-left choiceTextbox" id="choiceName' + count + '" name="choiceName' + count + '" placeholder="(' + count + ') Choice " >';
        buttonAddChoices += '<span class="fa fa-list form-control-feedback left" aria-hidden="true"></span>';
        buttonAddChoices += '</div>';
        buttonAddChoices += '<div class="deleteOption" title="delete" for="' + count + '" style="float: left;font-size: 18px;color: #da4040;cursor: pointer;">x</div>';
        buttonAddChoices += '</div>';

        $('#line').before(buttonAddChoices);

    });


</script>