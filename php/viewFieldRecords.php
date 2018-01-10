<?php
$projectId = $_POST['projectId'];

include "../classes/get.php";

$get = new Get();

$selectedProject = $get->getSelectedProjectInfo($projectId);
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
                <a class="btn btn-primary home"><i class="glyphicon glyphicon-home"></i></a>
                <a class="btn btn-primary home">Projects</a>
                <a href="#" class="btn btn-default">View Project Fields</a>
                <!-- <a href="#" class="btn btn-primary">Primary</a> -->
            </div>
        </div>      
    </div>
</div>
<div class="modal fade bs-example-modal-md" id="updateModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content" id="updateLoader"></div>
    </div>
</div>
<div class="modal fade bs-example-modal-md" id="updateModal2" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content" id="updateLoader2"></div>
    </div>
</div>
<div class="clearfix"></div>

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><?php echo $selectedProject; ?> / Field Records</h2>
                <div class="clearfix"></div>
            </div>

            <div class="x_content" id="resultPost">        
                <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th class="text-center">Status</th>
                            <th class="text-center">Field Name</th>
                            <th class="text-center">Field Type</th>
                            <th class="text-center">Date Created</th>
                            <th class="text-center">Sub-Field Type / Choices Option</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $getFieldTypeSubType = $get->getFieldTypeSubType($projectId);
                        foreach ($getFieldTypeSubType as $stid => $fieldTypeSubType) {
                            if ($fieldTypeSubType['isActive'] == 0)
                                $isActive = 'Inactive';
                            else
                                $isActive = 'Active';
                            ?>
                            <tr>
                                <td class="text-center"><?php echo $isActive; ?></td>
                                <td class="text-center"><?php echo $fieldTypeSubType['field_name']; ?></td>
                                <td class="text-center"><?php echo $fieldTypeSubType['fieldTypeDisplay']; ?></td>
                                <td><?php echo date("F d, Y", strtotime($fieldTypeSubType['dateCreated'])); ?></td>
                                <td class="text-center"><?php echo ucwords(strtolower($fieldTypeSubType['subFieldType'])); ?></td>
                                <td>
                                    <button data-toggle="modal" data-target="#updateModal2" class="btn btn-info btn-sm editField" id="<?php echo $fieldTypeSubType['fieldId']; ?>"> Update Field </button>

                                </td>
                            </tr>
                            <?php
                        }
                        $getFieldTypeChoices = $get->getFieldTypeChoices($projectId);
                        foreach ($getFieldTypeChoices as $cid => $fieldTypeChoices) {
                        $choices = '';
                            $getChoices = $get->getChoices($fieldTypeChoices['fieldId']);
                            foreach ($getChoices as $id => $record):
                                $choices .= $record['choiceName'] . ', ';
                            
                            endforeach;
                            $choices = rtrim($choices, ', ');
                            ?>
                            <tr>
                                <td class="text-center"><?php echo $isActive; ?></td>
                                <td class="text-center"><?php echo $fieldTypeChoices['field_name']; ?></td>
                                <td class="text-center"><?php echo $fieldTypeChoices['fieldTypeDisplay']; ?></td>
                                <td><?php echo date("F d, Y", strtotime($fieldTypeChoices['dateCreated'])); ?></td>
                                <td class="text-center"><?php echo $choices; ?></td>
                                <td><button data-toggle="modal" data-target="#updateModal2" class="btn btn-info btn-sm editField" id="<?php echo $fieldTypeSubType['fieldId']; ?>"> Update Field </button></td>

                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    $(".deleteField").click(function (event) {
        var id = $(this).attr("id");

        if (confirm('Are you sure to delete this field?')) {
            $.post("<?php echo $path ?>php/deleteField.php", function () {

            });
        } else {
            event.preventDefault();
        }
    });
    $(".editField").click(function () {
        var id = $(this).attr("id");
        $("#updateLoader2").load("<?php echo $path ?>php/editField.php", {id: id, projectId:<?php echo $projectId ?>}, function () {

        });
    });
    $(".home").click(function () {
        $("#content_loader").addClass("disabled");
        $("#content_loader").load("<?php echo $path ?>php/load.php", {purpose: 'projectList'}, function () {
            $("#content_loader").removeClass("disabled");
        });
    });
    $(".view-choices").click(function () {
        var id = $(this).attr("id");
        $(".pagePanel").load("php/viewFieldChoices.php", {fieldId: id, projectId:<?php echo $projectId; ?>});
        //alert(id);
    });

    $(document).ready(function () {
        $('#datatable-responsive').DataTable({
            "aaSorting": []
        });
    });
</script>