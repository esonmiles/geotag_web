<?php
session_start();

include "../classes/get.php";
$path = '/geotag_web/';
$get = new Get();
$userId = $_SESSION['userId'];

$getLatestApp = $get->getLatestApp();
$exp = explode("-", $getLatestApp);
?>
<div class="pagePanel" >
    <div class="page-title">
        <hr>
        <div class="title_left">
            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#addProjectModal">Add Project Record</button>
            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#useProjectModal">Use Existing Project Record</button>
            <a class="btn btn-primary" href="<?php echo $path ?>app/<?php echo $exp[0]; ?>" download target="_blank">Download latest App (v. <?php echo $exp[1] ?>)</a>
            <div class="modal fade bs-example-modal-md" id="updateModal" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-md">
                    <div class="modal-content" id="updateLoader"></div>
                </div>
            </div>
            <div class="modal fade bs-example-modal-md" id="useProjectModal" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-md">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" id="closeModal2" data-dismiss="modal"><span aria-hidden="true">×</span></button>
                            <h4 class="modal-title" id="myModalLabel">Search Project</h4>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-addon"><span class="fa fa-search"></span></div>
                                    <input name="searchText" id="searchText" type="text" class="form-control input-lg" placeholder="Search Project name / Code" autocomplete="off">

                                </div>        
                                <div id="result"></div>
                                <div id="resTable"></div>
                                <input type="hidden" value="0" id="activeSearch">
                            </div>

                            <div class="modal-body">
                                <span class="fa fa-exclamation"></span> <code>required fields</code>
                                <div class="form-group"></div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon"><span class="fa fa-exclamation"></span></div>
                                        <input id="proj_name" type="text" class="form-control input-lg" placeholder="Project Name" required>
                                    </div>                      
                                </div>

                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon"><span class="fa fa-exclamation"></span></div>
                                        <input id="proj_abb" type="text" class="form-control input-lg" placeholder="Project Abbreviation" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon"><span class="fa fa-exclamation"></span></div>
                                        <input id="proj_code" type="text" class="form-control input-lg" placeholder="Project Code">
                                    </div>                      
                                </div>

                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon"><span class="fa fa-gear"></span></div>
                                        <input id="proj_pref"  type="text" class="form-control input-lg" placeholder="Project Prefix (optional)">
                                    </div>                      
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary" id="submitSearch">Submit</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade bs-example-modal-md" id="addProjectModal" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-md">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" id="closeModal" data-dismiss="modal"><span aria-hidden="true">×</span></button>
                            <h4 class="modal-title" id="myModalLabel">Add Project Record</h4>
                        </div>
                        <div id="results" style="border: 1px solid #e1e1e1;margin-bottom:30px;display:none;max-height: 150px;">
                            <div id="slim">
                                <div id="res"></div>
                            </div>
                        </div>

                        <form method="POST" id="projectForm">
                            <div class="modal-body">
                                <span class="fa fa-exclamation"></span> <code>required fields</code>
                                <div class="form-group"></div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon"><span class="fa fa-exclamation"></span></div>
                                        <input name="projectNameComplete" id="projectNameComplete" type="text" class="form-control input-lg" placeholder="Project Name" required>
                                    </div>                      
                                </div>

                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon"><span class="fa fa-exclamation"></span></div>
                                        <input name="projectNameShort" id="projectNameShort" type="text" class="form-control input-lg" placeholder="Project Abbreviation" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon"><span class="fa fa-exclamation"></span></div>
                                        <input name="projectCode" id="projectCode" type="text" class="form-control input-lg" placeholder="Project Code">
                                    </div>                      
                                </div>

                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon"><span class="fa fa-gear"></span></div>
                                        <input name="prefix" id="projectPref" type="text" class="form-control input-lg" placeholder="Project Prefix (optional)">
                                    </div>                      
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary" id="submitModal">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="title_right">

            <div class="row pull-right">
                <div class="btn-group btn-breadcrumb">
                    <a href="#" class="btn btn-primary"><i class="glyphicon glyphicon-home"></i></a>
                    <a style="cursor:default" class="btn btn-default">Projects</a>
                    <!-- <a href="#" class="btn btn-primary">Breadcrumbs</a>
                    <a href="#" class="btn btn-primary">Primary</a> -->
                </div>
            </div>
        </div>
    </div>

    <div class="clearfix"></div>

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Projects</h2>&nbsp; 
                    <button data-toggle="modal" data-target="#updateModal" class="btn btn-info btn-sm print" id="print"> Print codes </button>
                    <div class="clearfix"></div>
                </div>

                <div class="x_content">
                    <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th class="text-center">Status</th>
                                <th class="text-center">Project Code</th>
                                <th class="text-center">Project Key</th>
                                <th class="text-center">Project Name</th>
                                <th class="text-center">Abbreviation</th>
                                <th class="text-center"># of Active Fields</th>
                                <th class="text-center">Date Created</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $getProjectInfo = $get->getProjectInfo($userId);
                            foreach ($getProjectInfo as $sid => $projectInfo) {
                                $fieldCount = $get->getCountProjectFields($projectInfo['projectId']);
                                $isActive = $projectInfo['isActive'];
                                if ($fieldCount > 0) {
                                    $disabled = '';
                                } else {
                                    $disabled = 'disabled';
                                }

                                if ($isActive == 0)
                                    $status = 'Inactive';
                                else
                                    $status = 'Active';
                                ?>
                                <tr>
                                    <td class="text-center"><?php echo $status; ?></td>
                                    <td class="text-center"><?php echo $projectInfo['project_code']; ?></td>
                                    <td class="text-center"><?php echo $projectInfo['project_key']; ?></td>
                                    <td><?php echo ucwords(strtolower($projectInfo['project_name'])); ?></td>
                                    <td><?php echo $projectInfo['abbr']; ?></td>
                                    <td class="text-center"><?php echo $fieldCount; ?></td>
                                    <td><?php echo date("F d, Y", strtotime($projectInfo['dateCreated'])); ?></td>
                                    <td class="text-center">
                                        <button data-toggle="modal" data-target="#updateModal" class="btn btn-info btn-sm editProj" id="<?php echo $projectInfo['projectId']; ?>"> Update Project </button> |
                                        <button class="btn btn-primary btn-sm view-fields" id="<?php echo $projectInfo['projectId']; ?>" <?php echo $disabled; ?>> View Fields </button> |
                                        <button class="btn btn-success btn-sm add-fields" id="<?php echo $projectInfo['projectId']; ?>">Add Field/s</button> | 
                                        <button data-toggle="modal" data-target="#updateModal" class="btn btn-info btn-sm view-code" id="<?php echo $projectInfo['projectId']; ?>"> View Barcode </button>
                                    </td>
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

    <iframe name="targetSave" id="targetSave" style="display:none;"></iframe>

</div>  
<script>
    $(document).ready(function () {

        $(".alert").alert();


        $("#fieldType").change(function () {
            var value = $(this).val();

        });
        $(".view-code").click(function () {
            var id = $(this).attr("id");
            $("#updateLoader").load("<?php echo $path ?>php/viewCode.php", {projectId: id}, function () {

            });
        });
        $(".editProj").click(function () {
            var id = $(this).attr("id");
            $("#updateLoader").load("<?php echo $path ?>php/editProj.php", {id: id}, function () {

            });
        });
        $("#submitSearch").click(function () {
            var activeSearch = $("#activeSearch").val();
            var proj_name = $("#proj_name").val();
            var proj_abb = $("#proj_abb").val();
            var proj_code = $("#proj_code").val();
            var proj_pref = $("#proj_pref").val();

            if (activeSearch != 0 && proj_name != '' && proj_abb != '' && proj_code != '') {
                $(this).addClass("disabled");
                $.post("<?php echo $path ?>php/saveTemplate.php", {activeSearch: activeSearch, proj_name: proj_name, proj_abb: proj_abb, proj_code: proj_code, proj_pref: proj_pref}, function (msg) {
                    $("#submitSearch").removeClass("disabled");
                    if (msg == 1) {
                        alert("Project code already exist.");
                    } else if (msg == 2) {
                        alert("Project name already exist.");
                    } else {
                        $('#useProjectModal').modal('toggle');
						setTimeout(function(){ 
							alert("Project record successfully saved!");
							$("#content_loader").addClass("disabled");
							$("#content_loader").load("<?php echo $path ?>php/load.php", {purpose: 'projectList'}, function () {
								$("#content_loader").removeClass("disabled");
							});
						}, 1000);
                    }
                });
            } else {
                if (activeSearch == 0) {
                    alert("Please select project template.");
                } else {
                    alert("Fill required fields!");
                }
            }

        });

        $(".add-fields").click(function () {
            var id = $(this).attr("id");
            $("#content_loader").addClass("disabled");
            $(".pagePanel").load("<?php echo $path ?>php/addFieldRecord.php", {projectId: id}, function () {
                $("#content_loader").removeClass("disabled");
            });

        });

        $(".view-fields").click(function () {
            var id = $(this).attr("id");
            $("#content_loader").addClass("disabled");
            $(".pagePanel").load("<?php echo $path ?>php/viewFieldRecords.php", {projectId: id}, function () {
                $("#content_loader").removeClass("disabled");
            });
        });

        $("#submitModal").click(function (event) {
            var projectNameComplete = $("#projectNameComplete").val();
            var projectNameShort = $("#projectNameShort").val();
            var projectCode = $("#projectCode").val();
            var projectPref = $("#projectPref").val();
            if (projectNameComplete != '' && projectNameShort != '' && projectCode != '') {
                if (confirm('Are you sure to save this record?')) {


                    if (projectNameComplete != '' && projectNameShort != '' && projectCode != '') {

                        $(this).addClass("disabled");
                        event.preventDefault();

                        $.ajax({
                            type: "POST",
                            url: "<?php echo $path ?>php/saveProjectRecord.php",
                            data: {'form': $("#projectForm").serialize(), 'projectNameComplete': projectNameComplete, 'projectNameShort': projectNameShort, 'projectCode': projectCode, 'projectPref': projectPref},
                            success: function (msg) {
                                $("#submitModal").removeClass("disabled");
                                if (msg == 1) {
                                    alert("Project code already exist.");
                                } else if (msg == 2) {
                                    alert("Project name already exist.");
                                } else {
                                    $('#addProjectModal').modal('toggle');
									setTimeout(function(){ 
										alert("Project record successfully saved!");
										$("#content_loader").addClass("disabled");
										$("#content_loader").load("<?php echo $path ?>php/load.php", {purpose: 'projectList'}, function () {
											$("#content_loader").removeClass("disabled");
										});
									}, 1000);
                                    
                                }
                            }
                        });
                    } else {
                        return true;
                    }
                } else {
                    event.preventDefault();
                }
            } else {
                event.preventDefault();
                alert("Fill required fields!");
            }
        });

        var typingTimer;                //timer identifier
        var doneTypingInterval = 500;  //time in ms, 5 second for example

        $("#searchText").on('keyup', function () {
            clearTimeout(typingTimer);
            typingTimer = setTimeout(doneTyping, doneTypingInterval);
        });

        $("#searchText").on('keydown', function () {
            clearTimeout(typingTimer);
        });

        function doneTyping() {
            var val = $("#searchText").val();

            if (val != '') {
                $("#result").slideDown();
                $("#result").load("<?php echo $path ?>php/searchProjects.php", {search: val});
            } else {
                $("#result").slideUp();
            }
        }
        $(".signOut").click(function () {
            $.post("../logout.php", {}, function () {
                window.location = "<?php echo $root . 'geotag/' ?>";
            });
        });
    });
    $(document).ready(function () {
        $('#datatable-responsive').DataTable();
    });
</script>