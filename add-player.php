<?php

session_start();

if (!isset($_SESSION["online"])) {
    header("Location: login.php");
    exit;
}

require_once 'actions/config.php';
require_once 'actions/site.php';
require_once 'actions/getaccount.php';

?>
<!doctype html>
<html lang="en">


<head>

    <meta charset="utf-8" />
    <title>Add Player | <?= $site["site_title"]?></title>
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
                                <h4 class="mb-sm-0">Add Player</h4>

                                <a class="btn btn-primary chat-send w-md waves-effect waves-light mt-3" href="players.php"><span class="d-none d-sm-inline-block me-2">Back</span></a>

                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                    <div class="row mb-4">
                        <div class="col-xl-12">
                            <div class="card mb-0">
                            <div class="card-body">
                                        <h4 class="card-title">Player Details</h4>
        
                                        <form class="custom-validation" id="form">

                                            <div style="width: 100%;">
                                                <div style="display: flex; justify-content:center; text-align:center">
                                                    <label for="upload">
                                                        <img id="userPass" src="assets\images\woman.png" alt="" class="rounded" style="width: 60%;">
                                                        <p class="mt-2 mb-lg-0"><code>Upload player image</code></p>
                                                        <p class="btn btn-info btn-sm">Upload now</p>
                                                        <input id="upload" style="display: none;" onchange="getUserPass()" type="file" class="form-control" name="image">

                                                    </label>
                                                </div>
                                            </div>
                                            <script>
                                                function getUserPass() {
                                                    document.getElementById('userPass').src = URL.createObjectURL(event.target.files[0])
                                                }
                                            </script>

                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="mb-3">
                                                        <label>First Name</label>
                                                        <input type="text" class="form-control parsley-success" required="" placeholder="Enter Fistname" data-parsley-id="5" name="firstname">
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="mb-3">
                                                        <label>Last Name</label>
                                                        <input type="text" class="form-control parsley-success" required="" placeholder="Enter Lastname" data-parsley-id="5" name="lastname">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="mb-3">
                                                        <label>E-Mail</label>
                                                        <div>
                                                            <input type="email" class="form-control parsley-success" required="" parsley-type="email" placeholder="Enter a valid e-mail" data-parsley-id="11" aria-describedby="parsley-id-11" name="email">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="mb-3">
                                                        <label for="validationCustom03" class="form-label">Gender</label>
                                                        <select class="form-select" id="validationCustom03" required="" name="gender">
                                                            <option selected="" disabled="" value="">Select Gender</option>
                                                            <option value="Male">Male</option>
                                                            <option value="Female">Female</option>
                                                        </select>
                                                        <div class="invalid-feedback">
                                                            Please select a valid gender.
                                                        </div>
        
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="mb-3">
                                                <label>Age</label>
                                                <div>
                                                    <input data-parsley-type="number" type="text" class="form-control parsley-success" required="" placeholder="Enter players age" data-parsley-id="17" aria-describedby="parsley-id-17" name="age">
                                                </div>
                                            </div>

                                            <div class="mb-3">
                                                <label>Position</label>
                                                <div>
                                                    <input data-parsley-type="text" type="text" class="form-control parsley-success" required="" placeholder="Enter players role" data-parsley-id="17" aria-describedby="parsley-id-17" name="role">
                                                </div>
                                            </div>

                                            <div class="mb-3">
                                                <label>Speed</label>
                                                <div>
                                                    <input data-parsley-type="number" type="number" class="form-control parsley-success" required="" placeholder="Enter players speed" data-parsley-id="17" aria-describedby="parsley-id-17" name="speed">
                                                </div>
                                            </div>

                                            <div class="mb-3">
                                                <label>Endurance Level</label>
                                                <div>
                                                    <input data-parsley-type="number" type="number" class="form-control parsley-success" required="" placeholder="Enter players endurance level" data-parsley-id="17" aria-describedby="parsley-id-17" name="endurance_level">
                                                </div>
                                            </div>

                                            <div class="mb-3">
                                                <label>Games Played</label>
                                                <div>
                                                    <input data-parsley-type="number" type="number" class="form-control parsley-success" required="" placeholder="Enter games played" data-parsley-id="17" aria-describedby="parsley-id-17" name="games_played">
                                                </div>
                                            </div>

                                            <div class="mb-3">
                                                <label>Goals</label>
                                                <div>
                                                    <input data-parsley-type="number" type="number" class="form-control parsley-success" required="" placeholder="Enter goals scored" data-parsley-id="17" aria-describedby="parsley-id-17" name="goals">
                                                </div>
                                            </div>

                                            <div class="mb-3">
                                                <label>Assists</label>
                                                <div>
                                                    <input data-parsley-type="number" type="number" class="form-control parsley-success" required="" placeholder="Enter players assist" data-parsley-id="17" aria-describedby="parsley-id-17" name="assists">
                                                </div>
                                            </div>

                                            <div class="mb-3">
                                                <label>State</label>
                                                <div>
                                                    <input data-parsley-type="text" type="text" class="form-control parsley-success" required="" placeholder="Enter players state" data-parsley-id="17" aria-describedby="parsley-id-17" name="state">
                                                </div>
                                            </div>

                                            <div class="mb-3">
                                                <label>Country</label>
                                                <div>
                                                    <input data-parsley-type="text" type="text" class="form-control parsley-success" required="" placeholder="Enter players country" data-parsley-id="17" aria-describedby="parsley-id-17" name="country">
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
                        url: "actions/addplayer.php",
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
                            let player_id = data.player_id;
                            data = data.status;

                            if (data.trim() == 'success') {
                                $("#success-msg").html("Player successfully added. Loading...");
                                $("#success").fadeIn();
                                setTimeout(()=>{
                                    window.location.assign(`profile.php?player_id=${player_id}`);
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