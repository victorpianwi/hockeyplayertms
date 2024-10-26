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
    <title>Settings | <?= $site["site_title"]?></title>
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
                                <h4 class="mb-sm-0">Settings</h4>

                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                    <div class="row mb-4">
                        <div class="col-xl-6">
                            <div class="card mb-0">
                                <div class="card-body">
                                    <h5 class="card-title">Change Email</h5>
                                    <form id="changeemail">
                                        <input type="number" value="<?= $user["user_id"]?>" name="user_id" hidden>
                                        <div class="mb-3">
                                            <label for="email" class="form-label">Email address</label>
                                            <input type="email" class="form-control" id="email" control-id="ControlID-5" value="<?= $user["email"]?>" name="email" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="password" class="form-label">Password</label>
                                            <input type="password" class="form-control" id="password" control-id="ControlID-6" name="password" required>
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

                                        <button type="submit" class="btn btn-primary" control-id="ControlID-7">Save Changes</button>
                                    </form>
                                </div>
                            </div>
                        </div> <!-- end col -->
                        
                        <div class="col-xl-6">
                            <div class="card mb-0">
                                <div class="card-body">
                                    <h5 class="card-title">Change Password</h5>
                                    <form id="changepassword">
                                        <input type="number" value="<?= $user["user_id"]?>" name="user_id" hidden>
                                        <div class="mb-3">
                                            <label for="oldpassword" class="form-label">Old Password</label>
                                            <input type="password" class="form-control" id="oldpassword" control-id="ControlID-4" name="oldpassword" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="newpassword" class="form-label">New Password</label>
                                            <input type="password" class="form-control" id="newpassword" control-id="ControlID-5" name="newpassword" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="confirmpassword" class="form-label">Confirm Password</label>
                                            <input type="password" class="form-control" id="confirmpassword" control-id="ControlID-6" name="confirmpassword" required>
                                        </div>
                                        <div id="success2"
                                            class="alert alert-success alert-dismissible fade show mt-2 hidden"
                                            role="alert">
                                            <i class="mdi mdi-check-all me-2"></i>
                                            <span id="success-msg2">Success</span>
                                        </div>

                                        <div id="error2"
                                            class="alert alert-danger alert-dismissible fade show mt-2 hidden"
                                            role="alert">
                                            <i class="mdi mdi-alert-circle-outline me-2"></i>
                                            <span id="error-msg2">Error</span>
                                        </div>
                                        <button type="submit" class="btn btn-primary" control-id="ControlID-7">Save Changes</button>
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
        document.querySelector("#changeemail").addEventListener("submit", (e)=>{
                e.preventDefault();

                $.ajax({
                    url: "actions/changeemail.php",
                    type: "POST",
                    data: new FormData(document.querySelector("#changeemail")),
                    contentType: false,
                    cache: false,
                    processData: false,
                    beforeSend: function() {
                            $("#success").fadeOut("fast");
                            $("#error").fadeOut("fast");
                        },
                        success: function(data) {
                            if (data.trim() == 'success') {
                                $("#success-msg").html("Email Changed");
                                $("#success").fadeIn();
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
            })

            document.querySelector("#changepassword").addEventListener("submit", (e)=>{
                e.preventDefault();

                $.ajax({
                    url: "actions/changepassword.php",
                    type: "POST",
                    data: new FormData(document.querySelector("#changepassword")),
                    contentType: false,
                    cache: false,
                    processData: false,
                    beforeSend: function() {
                            $("#success2").fadeOut("fast");
                            $("#error2").fadeOut("fast");
                        },
                        success: function(data) {
                            if (data.trim() == 'success') {
                                $("#success-msg2").html("Password Changed");
                                $("#success2").fadeIn();
                            } else {
                                $("#error-msg2").html(data);
                                $("#error2").fadeIn();
                            }
                        },
                        error: function(e) {
                            $("#error-msg2").html(e);
                            $("#error2").fadeIn();
                        }
                });
            })
    </script>

</body>

</html>