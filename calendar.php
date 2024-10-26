<?php

session_start();

if (!isset($_SESSION["online"])) {
    header("Location: login.php");
    exit;
}

require_once 'actions/config.php';
require_once 'actions/site.php';
require_once 'actions/getaccount.php';

$sql = "SELECT * FROM `calendar`";
$calendar = $conn->prepare($sql);
$calendar->execute();
$calendar = $calendar->get_result();

$events = [];

if($calendar->num_rows){
    $calendar->fetch_assoc();
    foreach ($calendar as $event) {
        $title = $event["title"];
        $datetime = $event["date"];
        $datetime = explode(" ", $datetime);
        $date = explode("-", $datetime[0]);
        $y = $date[0];
        $m = $date[1];
        $d = $date[2];
        $time = explode(":", $datetime[1]);
        $h = $time[0];
        $i = $time[1];
        $start = "$y-$m-$d"."T"."$h:$i";
        
        $className = $event["category"];
        array_push($events, [
            "title" => $title,
            "start" => $start,
            "allDay" => false,
            "className" => $className
        ]);
    }
    $events = json_encode($events);
}

?>
<!doctype html>
<html lang="en">

<head>
        
        <meta charset="utf-8" />
        <title>Calendar | <?= $site["site_title"]?></title>
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
                                    <h4 class="mb-sm-0">Calendar</h4>

                                    

                                </div>
                            </div>
                        </div>
                        <!-- end page title -->
                        
                        <div class="row mb-4">
                            <div class="col-xl-10">
                                <div class="card mb-0">
                                    <div class="card-body">
                                        <div id="calendar"></div>
                                    </div>
                                </div>
                            </div> <!-- end col -->
                        </div> <!-- end row-->
                        <div style='clear:both'></div>
            
                        <!-- Add New Event MODAL -->
                        <div class="modal fade" id="event-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                            aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header py-3 px-4">
                                        <h5 class="modal-title" id="modal-title">Event</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
            
                                    <div class="modal-body p-4">
                                        <form class="needs-validation" name="event-form" id="form-event" novalidate onsubmit="return false">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="mb-3">
                                                        <label class="form-label">Event Name</label>
                                                        <input class="form-control" placeholder="Insert Event Name" type="text"
                                                            name="title" id="event-title" readonly>
                                                        <div class="invalid-feedback">Please provide a valid event name
                                                        </div>
                                                    </div>
                                                </div> <!-- end col-->
                                                <div class="col-12">
                                                    <div class="mb-3">
                                                        <label class="form-label">Event Date</label>
                                                        <input class="form-control" type="datetime-local" name="date" id="event-date" readonly>
                                                        </div>
                                                    </div>
                                            </div> <!-- end col-->
                                            </div> <!-- end row-->
                                            <div class="row mt-2 ps-4 pe-4 pb-4">
                                                <div class="col-12 text-center">
                                                    <button type="button" class="btn btn-light"
                                                        data-bs-dismiss="modal">Close</button>
                                                </div> <!-- end col-->
                                            </div> <!-- end row-->
                                        </form>
                                    </div>
                                </div>
                                <!-- end modal-content-->
                            </div>
                            <!-- end modal dialog-->
                        </div>
                        <!-- end modal-->
                        
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
        <script src="assets/libs/%40fullcalendar/core/main.min.js"></script>
        <script src="assets/libs/%40fullcalendar/bootstrap/main.min.js"></script>
        <script src="assets/libs/%40fullcalendar/daygrid/main.min.js"></script>
        <script src="assets/libs/%40fullcalendar/timegrid/main.min.js"></script>
        <script src="assets/libs/%40fullcalendar/interaction/main.min.js"></script>

        <script>
            !function (g) {
                "use strict";
            
                function e() { }

                e.prototype.init = function () {

                    var l = g("#event-modal"), t = g("#modal-title"), z = g("#modal-date"), a = g("#form-event"), i = null, r = null, s = document.getElementsByClassName("needs-validation"), i = null, r = null, e = new Date, n = e.getDate(), d = e.getMonth(), o = e.getFullYear(), date = null, year = null, month = null, day = null, hours = null, minutes = null, formattedDateTime = null;

                    var c = <?= !empty($events) ? "$events" : "[]" ?>,v = (document.getElementById("external-events"), document.getElementById("calendar"));

                    function u(e) {
                        l.modal("show"),
                        a.removeClass("was-validated"),
                        a[0].reset(),
                        g("#event-title").val(),
                        g("#event-date").val(),
                        g("#event-category").val(),
                        t.text("Add Event"),
                        r = e
                    }

                    var m = new FullCalendar.Calendar(v, {

                            plugins: ["bootstrap", "interaction", "dayGrid", "timeGrid"],
                            editable: 0,
                            droppable: 0,
                            selectable: 0,
                            defaultView: "dayGridMonth",
                            themeSystem: "bootstrap",
                            header: { 
                                left: "prev,next today", 
                                center: "title", 
                                right: "dayGridMonth,timeGridWeek,timeGridDay,listMonth"
                            },

                            eventClick: function (e) {
                                l.modal("show"), a[0].reset(), i = e.event,
                                g("#event-title").val(i.title),
                                date = new Date(i._instance.range.start),
                                year = date.getFullYear(), month = ('0' + (date.getMonth() + 1)).slice(-2),
                                day = ('0' + date.getDate()).slice(-2), hours = (('0' + date.getHours()).slice(-2) - 1),
                                minutes = ('0' + date.getMinutes()).slice(-2),
                                formattedDateTime = `${year}-${month}-${day}T${hours}:${minutes}`;
                                g("#event-date").val(formattedDateTime),
                                r = null, t.text("Event Details"), r = null
                            }, events: c
                        });
                        
                        m.render()
                },
                g.CalendarPage = new e, g.CalendarPage.Constructor = e
            }(window.jQuery), function () {
                "use strict";
                window.jQuery.CalendarPage.init()
            }();
        </script>

        <script src="assets/js/app.js"></script>

    </body>

</html>
