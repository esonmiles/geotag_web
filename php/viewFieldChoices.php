<?php
$fieldId = $_POST['fieldId'];
$projectId = $_POST['projectId'];

include "../classes/get.php";

$get = new Get();

$selectedProject = $get->getSelectedProjectInfo($projectId);
$selectedField = $get->getSelectedField($projectId, $fieldId);
$getSelectedFieldChoices = $get->getSelectedFieldChoices($projectId, $fieldId);
?>
<div class="page-title">
    <div class="headerTitle" style="text-align:center;">
        <h4>Philippine Rice Research Institute</h4>
        <h6>Maligaya, Science City of Muñoz Nueva Ecija</h6>
        <h6>Telephone (044) 456-0113, 0285, - 0277, - 0354   Email: prri@philrice.gov.ph</h6>

        <h4>Geotag Management System</h4>
    </div>

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
                <a href="#" class="btn btn-primary"><i class="glyphicon glyphicon-home"></i></a>
                <a href="#" class="btn btn-primary">Projects</a>
                <a href="#" class="btn btn-primary">View Project Fields</a>
                <a href="#" class="btn btn-primary">View Field Choices</a>
            </div>
        </div>      
    </div>
</div>

<div class="clearfix"></div>

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><?php echo $selectedProject; ?> / Field Records / <?php echo $selectedField; ?> </h2>
                <div class="clearfix"></div>
            </div>

            <div class="x_content" id="resultPost">        
                <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th class="text-center">Date Created</th>
                            <th class="text-center">Field Name</th>
                            <th class="text-center">Field Type</th>
                            <th class="text-center">Sub-Field Type / Choices Option</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($getSelectedFieldChoices as $stid => $selectedFieldInfo) {
                            ?>
                            <tr>
                                <td><?php echo date("F d, Y", strtotime($selectedFieldInfo['dateCreated'])); ?></td>
                                <td class="text-center"><?php echo $selectedFieldInfo['field_name']; ?></td>
                                <td class="text-center"><?php echo $selectedFieldInfo['fieldTypeDisplay']; ?></td>
                                <td class="text-center"><?php echo ucwords(strtolower($selectedFieldInfo['choiceName'])); ?></td>
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

