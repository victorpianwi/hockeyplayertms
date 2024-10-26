<?php

session_start();

if (!isset($_SESSION["online"])) {
    header("Location: login.php");
    exit;
}

require_once 'actions/config.php';
require_once 'actions/site.php';
require_once 'actions/getaccount.php';

$sql = "SELECT * FROM `users` WHERE `admin` = 0";
$players = $conn->prepare($sql);
$players->execute();
$players = $players->get_result();

$sql = "SELECT * FROM `calendar` WHERE `date` < NOW()";
$events = $conn->prepare($sql);
$events->execute();
$events = $events->get_result();

$email = $user["email"];
$user_id = $user["user_id"];

$sql = "SELECT * FROM `tasks` WHERE `assigned` = ? AND status = 0";
$tasks = $conn->prepare($sql);
$tasks->bind_param("s", $email);
$tasks->execute();
$tasks = $tasks->get_result();

$sql = "SELECT * FROM `chats` WHERE NOT(`user_id` = ?) ORDER BY date_in ASC";
$chats = $conn->prepare($sql);
$chats->bind_param("s", $user_id);
$chats->execute();
$chats = $chats->get_result();

$total_num = 0;

if($chats->num_rows){
    $chats->fetch_assoc();

    foreach ($chats as $chat_num){

        $chatArray = json_decode($chat_num['seen'], true);

        if(!in_array($user_id, $chatArray)) {
            
            $total_num += 1;
            
        }

    }
} else {
    $total_num = 0;
}

$chats = $total_num;

?>
<!doctype html>
<html lang="en">

<head>
        
        <meta charset="utf-8" />
        <title>Home | <?= $site["site_title"]?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="<?= $site["meta_desc"]?>" name="description" />
        <meta content="Boss Lady" name="author" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="assets/images/favicon.jpg">

        <!-- jquery.vectormap css -->
        <link href="assets/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css" rel="stylesheet" type="text/css" />

        <!-- DataTables -->
        <link href="assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />

        <!-- Responsive datatable examples -->
        <link href="assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />  

        <!-- Bootstrap Css -->
        <link href="assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />

    </head>

    <body data-sidebar="dark">

        <!-- Begin page -->
        <div id="layout-wrapper">

            
            <?php require_once 'components/header.php';?>

            <?php require_once 'components/leftsidebar.php';?>

            

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
                                    <h4 class="mb-sm-0">Home</h4>


                                </div>
                            </div>
                        </div>
                        <!-- end page title -->

                        <div class="row">
                            <div class="col-xl-12">

                                <?php if($_SESSION["admin"] == true) { ?>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="d-flex">
                                                        <div class="flex-1 overflow-hidden">
                                                            <p class="text-truncate font-size-14 mb-2">Total Players</p>
                                                            <h6 class="mb-0">You have <?= $players->num_rows ?> Hockey Players</h6>
                                                        </div>
                                                        <div class="text-primary ms-auto">
                                                            <i class="ri-file-user-line font-size-24"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card-body border-top py-3">
                                                    <div class="text-truncate">
                                                    <button class="btn btn-primary chat-send w-md waves-effect waves-light" control-id="ControlID-5" onclick="window.location.assign('players.php')"><span class="d-none d-sm-inline-block me-2">View Players</span></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="d-flex">
                                                        <div class="flex-1 overflow-hidden">
                                                            <p class="text-truncate font-size-14 mb-2">Upcoming Events</p>
                                                            <h6 class="mb-0">You've scheduled <?= $events->num_rows ?> activities</h6>
                                                        </div>
                                                        <div class="text-primary ms-auto">
                                                            <i class="ri-calendar-line font-size-24"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card-body border-top py-3">
                                                    <div class="text-truncate">
                                                    <button class="btn btn-primary chat-send w-md waves-effect waves-light" control-id="ControlID-5" onclick="window.location.assign('admincalendar.php')"><span class="d-none d-sm-inline-block me-2">View Calendar</span></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="d-flex">
                                                        <div class="flex-1 overflow-hidden">
                                                            <p class="text-truncate font-size-14 mb-2">Recent Notifications</p>
                                                            <h6 class="mb-0">You have <?= $chats ?> new messages</h6>
                                                        </div>
                                                        <div class="text-primary ms-auto">
                                                            <i class="ri-message-line font-size-24"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card-body border-top py-3">
                                                    <div class="text-truncate">
                                                    <button class="btn btn-primary chat-send w-md waves-effect waves-light" control-id="ControlID-5" onclick="window.location.assign('chat.php')"><span class="d-none d-sm-inline-block me-2">View Messages</span></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                <?php } else { ?>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="d-flex">
                                                        <div class="flex-1 overflow-hidden">
                                                            <p class="text-truncate font-size-14 mb-2">Upcoming Task</p>
                                                            <h6 class="mb-0">You have <?= $tasks->num_rows ?> task pending</h6>
                                                        </div>
                                                        <div class="text-primary ms-auto">
                                                            <i class="ri-calendar-todo-fill font-size-24"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card-body border-top py-3">
                                                    <div class="text-truncate">
                                                    <button class="btn btn-primary chat-send w-md waves-effect waves-light" control-id="ControlID-5" onclick="window.location.assign('tasks.php')"><span class="d-none d-sm-inline-block me-2">View Tasks</span></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="d-flex">
                                                        <div class="flex-1 overflow-hidden">
                                                            <p class="text-truncate font-size-14 mb-2">Upcoming Events</p>
                                                            <h6 class="mb-0"><?= $events->num_rows ?> activities scheduled</h6>
                                                        </div>
                                                        <div class="text-primary ms-auto">
                                                            <i class="ri-calendar-line font-size-24"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card-body border-top py-3">
                                                    <div class="text-truncate">
                                                    <button class="btn btn-primary chat-send w-md waves-effect waves-light" control-id="ControlID-5" onclick="window.location.assign('calendar.php')"><span class="d-none d-sm-inline-block me-2">View Calendar</span></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="d-flex">
                                                        <div class="flex-1 overflow-hidden">
                                                            <p class="text-truncate font-size-14 mb-2">Recent Notifications</p>
                                                            <h6 class="mb-0">You have <?= $chats ?> new messages</h6>
                                                        </div>
                                                        <div class="text-primary ms-auto">
                                                            <i class="ri-message-line font-size-24"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card-body border-top py-3">
                                                    <div class="text-truncate">
                                                    <button class="btn btn-primary chat-send w-md waves-effect waves-light" control-id="ControlID-5" onclick="window.location.assign('chat.php')"><span class="d-none d-sm-inline-block me-2">View Messages</span></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                <?php } ?>
                                <!-- end row -->
                            </div>
                        </div>
                        <!-- end row -->
                    </div>
                    
                </div>
                <!-- End Page-content -->
               
                <?php require_once 'components/footer.php';?>
                
            </div>
            <!-- end main content-->

        </div>
        <!-- END layout-wrapper -->

        <!-- Right bar overlay-->
        <div class="rightbar-overlay"></div>

        <!-- JAVASCRIPT -->
        <script src="assets/libs/jquery/jquery.min.js"></script>
        <script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="assets/libs/metismenu/metisMenu.min.js"></script>
        <script src="assets/libs/simplebar/simplebar.min.js"></script>
        <script src="assets/libs/node-waves/waves.min.js"></script>

        
        <!-- apexcharts -->
        <script src="assets/libs/apexcharts/apexcharts.min.js"></script>

        <!-- jquery.vectormap map -->
        <script src="assets/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.min.js"></script>
        <script src="assets/libs/admin-resources/jquery.vectormap/maps/jquery-jvectormap-us-merc-en.js"></script>

        <!-- Required datatable js -->
        <script src="assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
        <script src="assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
        
        <!-- Responsive examples -->
        <script src="assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
        <script src="assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>

        <script src="assets/js/pages/dashboard.init.js"></script>

        <!-- App js -->
        <script src="assets/js/app.js"></script>

    </body>

</html>