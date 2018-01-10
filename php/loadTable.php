<?php
include "../classes/get.php";
session_start();
$get = new Get();
$path = '/geotag_web/';

$projectId = $_POST['id'];


$getTextField = $get->getTextField($projectId);
$getOptions = $get->getOptions($projectId);
?>
<div class="scrolled">
    <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th style="width:33%" class="text-center">Field name</th>
                <th style="width:33%" class="text-center">Type</th>
                <th class="text-center">Remarks</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($getTextField as $id => $record):
                if($record['isRequired'] == 1) $isReq = 'Required';
                else $isReq = '';
                echo '
                <tr>
                    <td style="width:33%;">' . $record['field_name'] . '</td>
                    <td style="width:33%" class="text-center">' . $record['fieldTypeDisplay'] . '</td>
                    <td class="text-center">' . $isReq . '</td>
                </tr>';
            endforeach;
            
            foreach ($getOptions as $id => $record):
                if($record['isRequired'] == 1) $isReq = 'Required';
                else $isReq = '';
                echo '
                <tr>
                    <td style="width:33%;">' . $record['field_name'] . '</td>
                    <td style="width:33%" class="text-center">' . $record['fieldTypeDisplay'] . '</td>
                    <td class="text-center">' . $isReq . '</td>
                </tr>';
            endforeach;
            ?>
        </tbody>

    </table>
</div>
