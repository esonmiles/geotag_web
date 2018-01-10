<?php
include "../classes/get.php";
$projectId = $_POST['projectId'];
$flag = $_POST['flag'];

$get = new Get();
?>
<div class="modal fade bs-example-modal-md" id="viewModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content" id="viewLoader"></div>
    </div>
</div>
<div class="modal fade bs-example-modal-md" id="viewRemarks" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content" id="remarksLoader"></div>
    </div>
</div>
<table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th class="text-center">Status</th>
            <th class="text-center">Survey Name</th>
            <th class="text-center">Serial Key</th>
            <th class="text-center">Date Gathered (mm-dd-yyyy)</th>
            <th class="text-center">Remarks</th>
            <th class="text-center">Action</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if ($flag == 3)
            $getData = $get->getDataTag("tbl_surveys", "surveyId", "surveyId", $projectId);
        else
            $getData = $get->getFiltered($flag, $projectId);
        foreach ($getData as $stid => $record) {
            if ($record['isApproved'] == 0){
                $status = 'Pending';
                $color = 'yellow';
            }
            else if ($record['isApproved'] == 1){
                $status = 'Approved';
                $color = 'green';
            }
            else{
                $status = 'Rejected';
                $color = 'red';
            }
            $isApproved = $record['isApproved'];
            if ($isApproved == 1)
                $button = '<button class="btn btn-danger btn-sm disapprove" for="' . $record['surveyId'] . '"> Disapprove </button>';
            if ($isApproved == 0)
                $button = '<button class="btn btn-info btn-sm viewDetails" for="' . $record['surveyId'] . '" data-toggle="modal" data-target="#viewModal"> View details </button> | <button class="btn btn-success btn-sm approve" for="' . $record['surveyId'] . '"> Approve </button> | <button class="btn btn-danger btn-sm disapprove" for="' . $record['surveyId'] . '"> Disapprove </button>';
            if ($isApproved == 2)
                $button = '<button class="btn btn-primary btn-sm viewRemarks" for="' . $record['surveyId'] . '" data-toggle="modal" data-target="#viewRemarks"> View Remarks </button> | <button class="btn btn-success btn-sm approve" for="' . $record['surveyId'] . '"> Approve </button>';
            ?>
            <tr>
                <td class="text-center text-<?php echo $color?>"><strong><?php echo $status; ?></strong></td>
                <td class="text-center"><?php echo $record['survey_name']; ?></td>
                <td class="text-center"><?php echo substr($record['serialKey'], 0, 100); ?></td>
                <td><?php echo $record['month'] . '-' . $record['day'] . '-' . $record['year'] . ' ' . $record['time']; ?></td>
                <td class="text-center"></td>
                <td><?php echo $button; ?></td>
            </tr>
            <?php
        }
        ?>
    </tbody>
</table>
<button style="display:none" id="confirmButton"data-toggle="modal" data-target="#viewModal"></button>
<script>
    $(".viewDetails").click(function () {
        var id = $(this).attr("for");
        $("#viewLoader").load("<?php echo $path ?>php/viewDetails.php", {surveyId: id, projectId:<?php echo $projectId; ?>}, function () {

        });
    });

    $(".viewRemarks").click(function () {
        var id = $(this).attr("for");
        var active = $("#activeFilter").val();
        $("#remarksLoader").load("<?php echo $path ?>php/remarksView.php", {surveyId: id, projectId:<?php echo $projectId; ?>, active: active}, function () {

        });

    });
    $(".disapprove").click(function () {
        var id = $(this).attr("for");
        var active = $("#activeFilter").val();
        if (confirm('Are you sure to want to disapprove this data?')) {
            $("#confirmButton").trigger("click");
            $("#viewLoader").load("<?php echo $path ?>php/remarks.php", {surveyId: id, projectId:<?php echo $projectId; ?>, active: active}, function () {

            });
        } else {
            event.preventDefault();
        }
    });
    $(".approve").click(function () {
        var id = $(this).attr("for");
        var active = $("#activeFilter").val();
        if (confirm('Are you sure to want to approve this data?')) {
            $.post("<?php echo $path ?>php/approveData.php", {id: id, action: 1}, function () {
                alert("Data successfully approved!");
                $("#optionsRadios" + active).trigger("click");
            });
        } else {
            event.preventDefault();
        }
    });
    $(document).ready(function () {
        $('#datatable-responsive').DataTable({
            "aaSorting": []
        });
    });
</script>