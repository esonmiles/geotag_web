<?php
session_start();

include "../classes/get.php";
$path = '/geotag_web/';
$root = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/';
$get = new Get();
$userId = $_SESSION['userId'];
?>
<div class="pagePanel" >

    <div class="clearfix"></div>

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Projects</h2>
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
                                <th class="text-center"># of Pending data</th>
                                <th class="text-center"># of Approved data</th>
                                <th class="text-center"># of Rejected data</th>
                                <th class="text-center">Total received data</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $getProjectInfo = $get->getProjectInfo($userId);
                            foreach ($getProjectInfo as $sid => $projectInfo) {
                                $isActive = $projectInfo['isActive'];

                                if ($isActive == 0)
                                    $status = 'Inactive';
                                else
                                    $status = 'Active';
                                
                                $counter = $get->countData($projectInfo['projectId']);
                                if ($counter > 0) {
                                    $disabled = '';
                                } else {
                                    $disabled = 'disabled';
                                }
                                
                                $total = $get->getTotal($projectInfo['projectId']);
                                $accepted = $get->getFilteredData($projectInfo['projectId'], 1);
                                $pending = $get->getFilteredData($projectInfo['projectId'], 0);
                                $rejected = $get->getFilteredData($projectInfo['projectId'], 2);
                                ?>
                                <tr>
                                    <td class="text-center"><?php echo $status; ?></td>
                                    <td class="text-center"><?php echo $projectInfo['project_code']; ?></td>
                                    <td class="text-center"><?php echo $projectInfo['project_key']; ?></td>
                                    <td class="text-center"><?php echo ucwords(strtolower($projectInfo['project_name'])); ?></td>
                                    <td class="text-center text-green"><?php echo $pending; ?></td>
                                    <td class="text-center"><?php echo $accepted; ?></td>
                                    <td class="text-center"><?php echo $rejected; ?></td>
                                    <td><?php echo $total; ?></td>
                                    <td class="text-center">
                                        <button class="btn btn-info btn-sm viewData" id="<?php echo $projectInfo['projectId']; ?>"> View Data </button> |
                                        <button class="btn btn-primary btn-sm export" id="<?php echo $projectInfo['projectId']; ?>" <?php echo $disabled; ?>> Export Data (CSV) </button>                  
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
    $(".export").click(function () {
        var id = $(this).attr("id");
        window.open(
                        '<?php echo $root; ?>geotag_web/php/exportData.php?id=' + id,
                        '_blank' // <- This is what makes it open in a new window.
                        );
    });
    $(".viewData").click(function () {
        var id = $(this).attr("id");
        $("#content_loader").addClass("disabled");
        $(".pagePanel").load("<?php echo $path ?>php/viewData.php", {projectId: id}, function () {
            $("#content_loader").removeClass("disabled");
        });
    });

    $(document).ready(function () {
        $('#datatable-responsive').DataTable({
            "aaSorting": []
        });
    });
</script>