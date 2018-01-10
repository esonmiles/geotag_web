<?php
$path = '/geotag_web/';
include "../classes/get.php";
$get = new Get();
$getProject = $get->getProject($projectId);
foreach ($getProject as $id => $record):
    $proj_name = $record['project_name'];
    $proj_key = $record['project_key'];
    $image = $record['image'];
    $project_code = $record['project_code'];
    $prefix = $record['survey_prefix'];
    $date_created = $record['dateCreated'];
endforeach;
$root = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/';
if ($image == '')
    $image = 'proj.JPG';

$counter = $get->countData($projectId);
if ($counter > 0) {
    $disabled = '';
} else {
    $disabled = 'disabled';
}
echo '
<div class="col-md-6" style="height: 100%;" id="mapLoader">
    <iframe id="the_iframe" src="' . $path . 'php/view.php?time=' . time() . '&projectId=' . $projectId . '" style="width: 100%;"></iframe>
</div>';
?>
<div class="col-md-6">
    <div class="row user-infos cyruxx" style="display: block;">
        <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10 col-xs-offset-0 col-sm-offset-0 col-md-offset-1 col-lg-offset-1">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Project Profile</h3>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-3 col-lg-3 hidden-xs hidden-sm">
                            <img class="img-circle projectImg" src="<?php echo $path ?>images/<?php echo $image ?>" alt="User Pic">
                        </div>
                        <div class="col-xs-2 col-sm-2 hidden-md hidden-lg">
                            <img class="img-circle projectImg" src="<?php echo $path ?>images/<?php echo $image ?>" alt="User Pic">
                        </div>
                        <div class=" col-md-9 col-lg-9 hidden-xs hidden-sm">
                            <strong><?php echo $proj_name ?></strong><br>
                            <table class="table table-user-information">
                                <tbody>
                                    <tr>
                                        <td>Project Key:</td>
                                        <td><?php echo $proj_key ?></td>
                                    </tr>
                                    <tr>
                                        <td>Project Code</td>
                                        <td><?php echo $project_code ?></td>
                                    </tr>
                                    <tr>
                                        <td>Survey Prefix</td>
                                        <td><?php echo $prefix ?></td>
                                    </tr>
                                    <tr>
                                        <td>Date Created</td>
                                        <td><?php echo $date_created ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="panel-footer">
                    <span style="font-size:18px;margin-right:10px;">Total # of surveys: <span id="total_survey"></span></span>
                    <button id="export" title="Export Data" class="btn btn-sm btn-success <?php echo $disabled;?>" type="button" data-toggle="tooltip" data-original-title="Export to CSV"><i class="glyphicon glyphicon-export"></i></button>
                </div>
            </div>
        </div>
    </div>
    <div class="box-header">
        <h4 class="box-title">Project Surveys <a id="viewAll" style="cursor: pointer;font-size:12px;margin-left:10px;">View All markers</a></h4>
    </div>
    <div class="box-body">
        <table id="example2" class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>View</th>
                    <th>Survey name</th>
                    <th>Survey Key</th>
                    <th>Date Created</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $ctr = 1;
                $getSurveys = $get->getSurveysApproved($id);
                foreach ($getSurveys as $id => $record):
                    $date_name = date("M-d-Y", mktime(0, 0, 0, $record['month'], $record['day'], $record['year']));
                    echo '
                        <tr>
                            <td>' . $ctr . '</td>
                            <td title="View location"><i for="' . $record['surveyId'] . '" class="viewLink fa fa-fw fa-eye"></i></td>
                            <td>' . $record['survey_name'] . '</td>
                            <td>' . $record['serialKey'] . '</td>
                            <td>' . $date_name . '</td>
                        </tr>';
                    $ctr++;
                endforeach;
                ?>
            </tbody>
        </table>
    </div>
</div>

<script type="text/javascript">

    $("#export").click(function () {
        window.open(
                '<?php echo $root; ?>geotag_web/php/exportData.php?id=' + <?php echo $projectId; ?>,
                '_blank' // <- This is what makes it open in a new window.
                );
    });
    $("#viewAll").click(function () {
        $("#mapLoader").addClass("disabled");
        $("#mapLoader").load("<?php echo $path ?>php/loadMapAll.php", {projectId: <?php echo $projectId; ?>}, function () {
            $("#mapLoader").removeClass("disabled");
        });
    });
    $(".viewLink").click(function () {
        var id = $(this).attr("for");
        $("#mapLoader").addClass("disabled");
        $("#mapLoader").load("<?php echo $path ?>php/loadMap.php", {projectId: <?php echo $projectId; ?>, surveyId: id}, function () {
            $("#mapLoader").removeClass("disabled");
        });
    });
    $("#total_survey").text("<?php echo $ctr - 1; ?>");
    $(function () {
        $('#example2').DataTable({
            "paging": true,
            "lengthChange": false,
            "aaSorting": [],
            "pageLength": 5,
            "searching": false,
            "ordering": true,
            "info": true,
            "autoWidth": false
        });
    });
</script>
<style>
    iframe {
        display: block;       /* iframes are inline by default */
        background: #000;
        border: none;         /* Reset default border */
        height: 86vh;        /* Viewport-relative units */
        width: 100vw;
        overflow:  hidden;
    }
</style>