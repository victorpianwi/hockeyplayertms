<?php

session_start();

if (!isset($_SESSION["online"])) {
    header("Location: login.php");
    exit;
}

require_once 'actions/config.php';
require_once 'actions/site.php';
require_once 'actions/getaccount.php';

$sql = "SELECT * FROM `users` WHERE `admin` = 0 ORDER BY `date_in` DESC";
$players = $conn->prepare($sql);
$players->execute();
$players = $players->get_result();

?>
<!doctype html>
<html lang="en">

<head>
        
        <meta charset="utf-8" />
        <title>Players | <?= $site["site_title"]?></title>
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

    </head>

    <body data-sidebar="dark">
    
    <!-- <body data-layout="horizontal" data-topbar="dark"> -->

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
                                    <h4 class="mb-sm-0">Players</h4>

                                    <a class="btn btn-primary chat-send w-md waves-effect waves-light mt-3" href="add-player.php"><span class="d-none d-sm-inline-block me-2">Add Player</span></a>

                                </div>
                            </div>
                        </div>
                        <!-- end page title -->
                        
                        <div class="row mb-4">
                            <div class="col-xl-12">
                                <div class="card mb-0">
                                <div class="card-body">
                                        <div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div>
                                                        <h5>All Players</h5>
                                                    </div>
                                                </div>
                                                
                                            </div>

                                            <div class="row g-0">
                                                <?php if($players->num_rows){
                                                    $players->fetch_assoc();

                                                    foreach($players as $player){
                                                    
                                                    ?>
                                                    <div class="col-xl-3 col-sm-6">
                                                        <div class="product-box">
                                                            <div class="product-img">
                                                                <img src="<?= $player["image"]?>" alt="img-1" class="img-fluid mx-auto d-block">
                                                            </div>
                                                            
                                                            <div class="text-center">
                                                                <p class="font-size-12 mb-1"><?= $player["role"]?></p>
                                                                <h5 class="font-size-15"><a href="#" class="text-dark"><?= $player["firstname"]." ".$player["lastname"]?></a></h5>

                                                                <a class="btn btn-primary chat-send w-md waves-effect waves-light mt-3" href="profile.php?player_id=<?= $player["user_id"]?>"><span class="d-none d-sm-inline-block me-2">View Player</span></a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php } ?>
                                                <?php } else { ?>
                                                    <div class="col-xl-3 col-sm-6">
                                                        <div class="product-box">
                                                            
                                                            <div class="text-center">
                                                                <h5 class="font-size-15"><a href="#" class="text-dark"> No player added</a></h5>

                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php }?>
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

                
                <?php require_once 'components/footer.php';?>
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
