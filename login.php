<?php

session_start();

if(isset($_SESSION["online"])){
    header("Location: index.php");
    exit;
}

require_once 'actions/config.php';
require_once 'actions/site.php';

?>
<!doctype html>
<html lang="en">

    
<head>
        
        <meta charset="utf-8" />
        <title>Login | <?= $site["site_title"]?></title>
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

    <body class="auth-body-bg">
        <div>
            <div class="container-fluid p-0">
                <div class="row g-0">
                    <div class="col-lg-4">
                        <div class="authentication-page-content p-4 d-flex align-items-center min-vh-100">
                            <div class="w-100">
                                <div class="row justify-content-center">
                                    <div class="col-lg-9">
                                        <div>
                                            <div class="text-center">
                                                <div>
                                                    <a href="" class="">
                                                        <img src="assets/images/logo-dark.jpg" alt="" height="200" class="auth-logo logo-dark mx-auto">
                                                        <img src="assets/images/logo-light.jpg" alt="" height="200" class="auth-logo logo-light mx-auto">
                                                    </a>
                                                </div>
    
                                                <h4 class="font-size-18 mt-4">Welcome Back !</h4>
                                                <p class="text-muted">Sign in to continue to Hockey Task Manager</p>
                                            </div>

                                            <div class="p-2 mt-5">
                                                <form id="form">
                    
                                                    <div class="mb-3 auth-form-group-custom mb-4">
                                                        <i class="ri-user-2-line auti-custom-input-icon"></i>
                                                        <label for="email">Email</label>
                                                        <input type="text" class="form-control" id="email" placeholder="Enter email" name="email">
                                                    </div>
                            
                                                    <div class="mb-3 auth-form-group-custom mb-4">
                                                        <i class="ri-lock-2-line auti-custom-input-icon"></i>
                                                        <label for="userpassword">Password</label>
                                                        <input type="password" class="form-control" id="userpassword" placeholder="Enter password" name="password">
                                                    </div>
                            
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input" id="customControlInline">
                                                        <label class="form-check-label" for="customControlInline">Remember me</label>
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

                                                    <div class="mt-4 text-center">
                                                        <button class="btn btn-primary w-md waves-effect waves-light" type="submit">Log In</button>
                                                    </div>

                                                    <!-- <div class="mt-4 text-center">
                                                        <a href="auth-recoverpw.html" class="text-muted"><i class="mdi mdi-lock me-1"></i> Forgot your password?</a>
                                                    </div> -->
                                                </form>
                                            </div>

                                            <div class="mt-5 text-center">
                                                <p>© <script>document.write(new Date().getFullYear())</script> Hockey Task Manager. Built with <i class="mdi mdi-heart text-danger"></i> by Boss Lady</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <div class="authentication-bg">
                            <div class="bg-overlay"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        

        <!-- JAVASCRIPT -->
        <script src="assets/libs/jquery/jquery.min.js"></script>
        <script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="assets/libs/metismenu/metisMenu.min.js"></script>
        <script src="assets/libs/simplebar/simplebar.min.js"></script>
        <script src="assets/libs/node-waves/waves.min.js"></script>

        <script src="assets/js/app.js"></script>

        <script>
            $(document).ready(function(e) {
                $("#form").on('submit', (function(e) {
                    e.preventDefault();
                    $.ajax({
                        url: "actions/login.php",
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
                            if (data.trim() == 'success') {
                                $("#success-msg").html("Sign in successful. . .");
                                $("#success").fadeIn();
                                setTimeout(()=>{
                                    window.location.assign("index.php");
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
