<?php

session_start();

if (!isset($_SESSION["online"])) {
    header("Location: login.php");
    exit;
}

require_once 'actions/config.php';
require_once 'actions/site.php';
require_once 'actions/getaccount.php';

if($_SESSION["admin"] == true) {
    $sql = "SELECT * FROM `tasks` ORDER BY `date_in` DESC";
    $tasks = $conn->prepare($sql);
} else {
    $sql = "SELECT * FROM `tasks` WHERE assigned = ? ORDER BY `date_in` DESC";
    $tasks = $conn->prepare($sql);
    $tasks->bind_param("s", $user["email"]);
}

$tasks->execute();
$tasks = $tasks->get_result();

?>
<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8" />
    <title>Tasks | <?= $site["site_title"]?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesdesign" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.jpg">

    <!-- Plugin css -->
    <link rel="stylesheet" href="assets/libs/%40fullcalendar/core/main.min.css" type="text/css">
    <link rel="stylesheet" href="assets/libs/%40fullcalendar/daygrid/main.min.css" type="text/css">
    <link rel="stylesheet" href="assets/libs/%40fullcalendar/bootstrap/main.min.css" type="text/css">
    <link rel="stylesheet" href="assets/libs/%40fullcalendar/timegrid/main.min.css" type="text/css">

    <!-- Bootstrap Css -->
    <link href="assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />

</head>

<body data-sidebar="dark">

    <!-- <body data-layout="horizontal" data-topbar="dark"> -->

    <!-- Begin page -->
    <div id="layout-wrapper">


        <?php require_once 'components/header.php'; ?>

        <?php require_once 'components/leftsidebar.php'; ?>



        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">

            <div class="page-content">
                <div class="container-fluid">

                    <!-- start page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                <h4 class="mb-sm-0">Task Manager</h4>

                                <a class="btn btn-primary chat-send w-md waves-effect waves-light mt-3" href="add-task.php"><span class="d-none d-sm-inline-block me-2">Add Task</span></a>

                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                    <div class="row mb-4">
                        <div class="col-xl-12">
                            <div class="card mb-0">
                                <div class="card-body">

                                    <h4 class="card-title mb-4">Tasks</h4>

                                    <div class="table-responsive">
                                        <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <table class="table table-centered datatable dt-responsive nowrap dataTable no-footer dtr-inline collapsed" data-bs-page-length="5" style="border-collapse: collapse; border-spacing: 0px; width: 100%;" id="DataTables_Table_0" role="grid" aria-describedby="DataTables_Table_0_info">
                                                        <thead class="table-light">
                                                            <tr role="row">
                                                                <th class="sorting_asc" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 0px;" aria-sort="ascending" aria-label="Order ID: activate to sort column descending">ID</th>
                                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 403px;" aria-label="Date: activate to sort column ascending">Task</th>
                                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 0px;" aria-label="Date: activate to sort column ascending">Assigned</th>
                                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 0px;" aria-label="Billing Name: activate to sort column ascending">Due Date</th>
                                                                <th style="width: 0px;" class="sorting_disabled" rowspan="1" colspan="1" aria-label="Action">Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        <?php if($tasks->num_rows){
                                                            $tasks->fetch_assoc();

                                                            $no = 1;

                                                            foreach($tasks as $task){

                                                                $email = $task["assigned"];

                                                                $sql = "SELECT * FROM users WHERE email = ?;";
                                                                $stmt = $conn->prepare($sql);
                                                                $stmt->bind_param("s", $mail);
                                                                $mail = $email;
                                                                $stmt->execute();
                                                                $user = $stmt->get_result();
                                                                $user = $user->fetch_assoc();
                                                            ?>
                                                            <tr class="odd">

                                                                <td class="sorting_1"><a href="javascript: void(0);" class="text-dark fw-bold"></a><?= $no ?> </td>
                                                                <td><?= $task["task"] ?></td>
                                                                <td><?= $user["firstname"]." ".$user["lastname"]?></td>
                                                                <td>
                                                                    <?php if($task["status"] >= 1) { ?>
                                                                        Done
                                                                    <?php } else { ?>
                                                                        <?= $task["due_date"] ?>
                                                                    <?php } ?>
                                                                </td>
                                                                <td id="tooltip-container9">
                                                                <a class="btn btn-primary btn-sm chat-send w-md waves-effect waves-light mt-3" href="task.php?task_id=<?= $task["task_id"]?>"><span class="d-none d-sm-inline-block me-2">View Task</span></a>
                                                                </td>
                                                            </tr>
                                                        <?php $no+=1; } ?>
                                                        <?php } else { ?>
                                                            <tr class="odd">

                                                                <td>No task assigned</td>
                                                                <td></td>
                                                                <td></td>
                                                                <td></td>
                                                                <td></td>
                                                            </tr>
                                                        <?php }?>











                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> <!-- end col -->
                    </div> <!-- end row-->
                    <div style='clear:both'></div>
                </div> <!-- container-fluid -->
            </div>
            <!-- End Page-content -->


            <?php require_once 'components/footer.php'; ?>
        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->

    <!-- JAVASCRIPT -->
    <script src="assets/libs/jquery/jquery.min.js"></script>
    <script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/libs/metismenu/metisMenu.min.js"></script>
    <script src="assets/libs/simplebar/simplebar.min.js"></script>
    <script src="assets/libs/node-waves/waves.min.js"></script>

    <!-- plugin js -->
    <script src="assets/libs/moment/min/moment.min.js"></script>
    <script src="assets/libs/jquery-ui-dist/jquery-ui.min.js"></script>

    <script src="assets/js/app.js"></script>

</body>

</html>