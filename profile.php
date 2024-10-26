<?php

session_start();

if (!isset($_SESSION["online"])) {
    header("Location: login.php");
    exit;
}

require_once 'actions/config.php';
require_once 'actions/site.php';
require_once 'actions/getaccount.php';

$user_id = $_GET["player_id"];

$sql = "SELECT * FROM `users` WHERE `user_id` = ?";
$player = $conn->prepare($sql);
$player->bind_param("s", $user_id);
$player->execute();
$player = $player->get_result();

if($player->num_rows){
    $player = $player->fetch_assoc();
    $email = $player["email"];

    $sql = "SELECT * FROM `tasks` WHERE assigned = ? ORDER BY `date_in` DESC";
    $tasks = $conn->prepare($sql);
    $tasks->bind_param("s", $email);
    $tasks->execute();
    $tasks = $tasks->get_result();

} else {
    header("Location: players.php");
}

?>
<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8" />
    <title><?= $player["firstname"]." ".$player["lastname"]?> | <?= $site["site_title"]?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.jpg">

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
                                <h4 class="mb-sm-0">Profile</h4>

                                <a class="btn btn-primary chat-send w-md waves-effect waves-light mt-3" href="players.php"><span class="d-none d-sm-inline-block me-2">Back</span></a>

                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                    <div class="row mb-4">
                        <div class="col-xl-12">
                            <div class="card mb-0">
                                <div class="card-body">
                                    <h5 class="card-title">Player Profile</h5>
                                    <div class="row">
                                        <div class="col-md-8 col-lg-6">
                                            <div class="product-img">
                                                <img src="<?= $player["image"]?>" alt="img-1" class="img-fluid mx-auto d-block">
                                            </div>
                                        </div>
                                    </div>
                                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link active" id="details-tab" data-bs-toggle="tab" data-bs-target="#details" type="button" role="tab">Details</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="stats-tab" data-bs-toggle="tab" data-bs-target="#stats" type="button" role="tab">Stats</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="tasks-tab" data-bs-toggle="tab" data-bs-target="#tasks" type="button" role="tab">Tasks</button>
                                        </li>
                                    </ul>
                                    <div class="tab-content" id="myTabContent">
                                        <div class="tab-pane fade show active" id="details" role="tabpanel">
                                            <h6 class="mt-3">Player Details</h6>
                                            <p>Name: <?= $player["firstname"]." ".$player["lastname"]?></p>
                                            <p>Email: <?= $player["email"]?></p>
                                            <p>Age: <?= $player["age"]?></p>
                                            <p>Position: <?= $player["role"]?></p>
                                            <p>State: <?= $player["state"]?></p>
                                            <p>Country: <?= $player["country"]?></p>
                                        </div>
                                        <div class="tab-pane fade" id="stats" role="tabpanel">
                                            <h6 class="mt-3">Player Stats</h6>
                                            <p>Games Played: <?= $player["games_played"]?></p>
                                            <p>Goals: <?= $player["goals"]?></p>
                                            <p>Assists: <?= $player["assists"]?></p>
                                            <p>Speed: <?= $player["speed"]?></p>
                                            <p>Endurance Level: <?= $player["endurance_level"]?></p>
                                        </div>
                                        <div class="tab-pane fade" id="tasks" role="tabpanel">
                                            <h6 class="mt-3">Player Tasks</h6>
                                            <ul>
                                                <?php if($tasks->num_rows){
                                                    $tasks->fetch_assoc();
                                                    foreach($tasks as $task){ ?>
                                                        <li><?= $task["task"]?> - Due <?= $task["due_date"]?></li>
                                                    <?php } ?>
                                                <?php } else { ?>
                                                    <li>No assigned tasks</li>
                                                <?php }?>
                                            </ul>
                                        </div>
                                    </div>
                                    <?php if($_SESSION["admin"] == true) { ?>
                                        <a class="btn btn-primary chat-send w-md waves-effect waves-light mt-2" href="edit-player.php?player_id=<?= $player["user_id"]?>"><span class="d-none d-sm-inline-block me-2">Edit Player</span></a>
                                    <?php } else { ?>
                                        <?php if($user_id == $user["user_id"]) { ?>
                                            <a class="btn btn-primary chat-send w-md waves-effect waves-light mt-2" href="edit-player.php?player_id=<?= $player["user_id"]?>"><span class="d-none d-sm-inline-block me-2">Edit My Account</span></a>
                                        <?php } ?>
                                    <?php } ?>
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