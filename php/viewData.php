<?php
$projectId = $_POST['projectId'];

include "../classes/get.php";
$path = '/geotag_web/';
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
                <a class="btn btn-default"><?php echo $selectedProject; ?></a>
            </div>
        </div>      
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

            <div class="x_title">
                <div class="form-group" id="radios">
                    <div class="radio">
                        <label>
                            <input name="optionsRadios" id="optionsRadios3" value="3" checked="" type="radio" class="filtered">
                            All
                        </label>
                        <label>
                            <input name="optionsRadios" id="optionsRadios0" value="0" type="radio" class="filtered">
                            Pending
                        </label>
                        <label>
                            <input name="optionsRadios" id="optionsRadios1" value="1" type="radio" class="filtered">
                            Approved
                        </label>
                        <label>
                            <input name="optionsRadios" id="optionsRadios2" value="2" type="radio" class="filtered">
                            Rejected
                        </label>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="x_content" id="resultPost">        

            </div>
        </div>
    </div>
</div>
<input type="hidden" value="3" id="activeFilter">
<script>
    $(".filtered").click(function () {
        var val = $(this).val();
        $("#activeFilter").val(val);
        $("#radios").addClass("disabled");
        $("#resultPost").addClass("disabled");
        $("#resultPost").load("<?php echo $path ?>php/loadData.php", {flag: val, projectId:<?php echo $projectId ?>}, function () {
            $("#radios").removeClass("disabled");
            $("#resultPost").removeClass("disabled");
        });
    });
    $(document).ready(function () {
        $("#resultPost").load("<?php echo $path ?>php/loadData.php", {flag: 3, projectId:<?php echo $projectId ?>}, function () {

        });
    });
    $(".home").click(function () {
        $("#content_loader").addClass("disabled");
        $("#content_loader").load("<?php echo $path ?>php/load.php", {purpose: 'datamanagement'}, function () {
            $("#content_loader").removeClass("disabled");
        });
    });
</script>