<?php
$surveyId = $_POST['surveyId'];
$projectId = $_POST['projectId'];

include "../classes/get.php";

$get = new Get();

$getSurvey = $get->getSurvey($surveyId);

foreach($getSurvey as $id=>$record):
    $survey_name = $record['survey_name'];
    $surveyKey = $record['serialKey'];
    $lat = $record['latitude'];
    $lng = $record['longitude'];
    $macAddress = $record['macAddress'];
endforeach;
?>

<div class="modal-content" id="updateDiv">
    <div class="modal-header">
        <button type="button" class="close" id="closeModal2" data-dismiss="modal"><span aria-hidden="true"></span></button>
        <h4 class="modal-title" id="myModalLabel">View Data</h4>
    </div>
    <div class="modal-body">
        <div class="form-group">
            <input type="text" value="Survey Name: <?php echo $survey_name?>" disabled class="form-control">
        </div>
        <div class="form-group">
            <input type="text" value="Key: <?php echo $surveyKey?>" disabled class="form-control">
        </div>
        <div class="form-group">
            <input type="text" value="Latitude: <?php echo $lat?>" disabled class="form-control">
        </div>
        <div class="form-group">
            <input type="text" value="Longitude: <?php echo $lng?>" disabled class="form-control">
        </div>
        <div class="form-group">
            <input type="text" value="MacAddress: <?php echo $macAddress?>" disabled class="form-control">
        </div>
        <table id="datatable-responsive2" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th class="text-center">Field name</th>
                    <th class="text-center">Value</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $getFields = $get->getFields($projectId);
                foreach ($getFields as $id => $record):
                    $getValue = $get->getValue($surveyId, $record['fieldId']);
                    echo '<tr>
                            <td>' . $record['field_name'] . '</td>
                            <td>' . $getValue . '</td>';
                    echo '</tr>';
                endforeach;
                ?>
            </tbody>
        </table>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    </div>
</div>

<script>

    $(document).ready(function () {
        $('#datatable-responsive2').DataTable({
            "aaSorting": [],
            bFilter: false
        });
    });
</script>