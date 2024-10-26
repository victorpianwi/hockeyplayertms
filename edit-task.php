<?php

session_start();

if (!isset($_SESSION["online"])) {
    header("Location: login.php");
    exit;
}

require_once 'actions/config.php';
require_once 'actions/site.php';
require_once 'actions/getaccount.php';

$task_id = $_GET["task_id"];

$sql = "SELECT * FROM `tasks` WHERE `task_id` = ?";
$task = $conn->prepare($sql);
$task->bind_param("s", $task_id);
$task->execute();
$task = $task->get_result();

if($task->num_rows){
    $task = $task->fetch_assoc();

    $taskdate = explode(" ", $task["date_in"]);
} else {
    header("Location: tasks.php");
}

$sql = "SELECT * FROM `users` WHERE `admin` = 0 ORDER BY `date_in` DESC";
$players = $conn->prepare($sql);
$players->execute();
$players = $players->get_result();

?>
<!doctype html>
<html lang="en">


<head>

    <meta charset="utf-8" />
    <title>Edit Task | <?= $site["site_title"]?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="<?= $site["meta_desc"]?>" name="description" />
    <meta content="Boss Lady" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.jpg">

    <!-- Bootstrap Css -->
    <link href="assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />

    <style>
        .hidden{
            display: none;
        }
    </style>

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
                                <h4 class="mb-sm-0">Edit Task</h4>

                                <a class="btn btn-primary chat-send w-md waves-effect waves-light mt-3" href="task.php?task_id=<?= $task_id ?>"><span class="d-none d-sm-inline-block me-2">Back</span></a>

                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                    <div class="row mb-4">
                        <div class="col-xl-12">
                            <div class="card mb-0">
                            <div class="card-body">
                                        <h4 class="card-title">Task Details</h4>
        
                                        <form class="custom-validation" id="form">

                                            <input type="number" name="task_id" value="<?= $task["task_id"] ?>" hidden>

                                            <div class="mb-3 mt-5">
                                                <label>Task</label>
                                                <div>
                                                    <textarea data-parsley-type="number" type="text" class="form-control parsley-success" required="" placeholder="Enter task here" data-parsley-id="17" aria-describedby="parsley-id-17" name="task"><?= $task["task"]?></textarea>
                                                </div>
                                            </div>

                                            <?php

                                                $email = $task["assigned"];

                                                $sql = "SELECT * FROM users WHERE email = ?;";
                                                $stmt = $conn->prepare($sql);
                                                $stmt->bind_param("s", $mail);
                                                $mail = $email;
                                                $stmt->execute();
                                                $user = $stmt->get_result();
                                                $user = $user->fetch_assoc();
                                            
                                            ?>


                                            <div class="mb-3">
                                                <label for="assignuserinput" class="form-label">Assign User</label>
                                                <input class="form-control parsley-success" list="assignuser" id="assignuserinput" name="assignuser" value="<?= $user["email"] ?>">
                                                <datalist id="assignuser">
                                                <option value="<?= $user["email"] ?>"><?= $user["firstname"]." ".$user["lastname"] ?></option>
                                                    <?php if($players->num_rows){
                                                        $players->fetch_assoc();
                                                        
                                                        foreach($players as $player){
                                                    
                                                        ?>
                                                        <option value="<?= $player["email"] ?>"><?= $player["firstname"]." ".$player["lastname"]?></option>
                                                        <?php } ?>
                                                    <?php } else { ?>
                                                        <option disabled="" value="">No player available</option>
                                                    <?php }?>
                                                </datalist>
                                                <div class="invalid-feedback">
                                                    Please select user to assign.
                                                </div>

                                            </div>

                                            <div class="mb-3">
                                                <label>Due Date</label>
                                                <div>
                                                    <input type="date" class="form-control parsley-success" required="" placeholder="Enter players age" data-parsley-id="17" aria-describedby="parsley-id-17" name="duedate" value="<?= $task["due_date"]?>">
                                                </div>
                                            </div>

                                            <div id="success"
                                                class="alert alert-success alert-dismissible fade show mt-2 hidden"
                                                role="alert">
                                                <i class="mdi mdi-check-all me-2"></i>
                                                <span id="success-msg">Success</span>
                                            </div>

                                            <div id="error"
                                                class="alert alert-danger alert-dismissible fade show mt-2 hidden"
                                                role="alert">
                                                <i class="mdi mdi-alert-circle-outline me-2"></i>
                                                <span id="error-msg">Error</span>
                                            </div>

                                            <div class="mb-0">
                                                <div>
                                                    <button type="submit" class="btn btn-primary waves-effect waves-light me-1">
                                                        Submit
                                                    </button>
                                                    <button type="reset" class="btn btn-secondary waves-effect">
                                                        Cancel
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
        
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

    <script>
            $(document).ready(function(e) {
                $("#form").on('submit', (function(e) {
                    e.preventDefault();
                    $.ajax({
                        url: "actions/edittask.php",
                        type: "POST",
                        data: new FormData(this),
                        contentType: false,
                        cache: false,
                        processData: false,
                        beforeSend: function() {
                            $("#success").fadeOut("fast");
                            $("#error").fadeOut("fast");
                        },
                        success: function(data) {
                            data = JSON.parse(data);
                            let task_id = data.task_id;
                            data = data.status;

                            if (data.trim() == 'success') {
                                $("#success-msg").html("Task successfully edited. Loading...");
                                $("#success").fadeIn();
                                setTimeout(()=>{
                                    window.location.assign(`task.php?task_id=${task_id}`);
                                }, 3000);
                            } else {
                                $("#error-msg").html(data);
                                $("#error").fadeIn();
                            }
                        },
                        error: function(e) {
                            $("#error-msg").html(e);
                            $("#error").fadeIn();
                        }
                    });
                }));
            });
        </script>

</body>

</html>