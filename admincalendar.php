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
        $cal_id = $event["cal_id"];
        
        $className = $event["category"];
        array_push($events, [
            "title" => $title,
            "start" => $start,
            "allDay" => false,
            "className" => $className,
            "extendedProps" => [
                "id" => $cal_id,
                "opp_type" => "Create"
            ]
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
                            <div class="col-xl-3">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <button type="button" class="btn font-16 btn-primary waves-effect waves-light w-100"
                                            id="btn-new-event" data-bs-toggle="modal" data-bs-target="#event-modal">
                                            Create New Event
                                        </button>
            
                                        <div id="external-events">
                                            <br>
                                            <p class="text-muted">Drag and drop your event or click in the calendar</p>
                                            <div class="external-event fc-event bg-success" data-class="bg-success">
                                                <i class="mdi mdi-checkbox-blank-circle font-size-11 me-2"></i>New Event
                                                Planning
                                            </div>
                                            <div class="external-event fc-event bg-info" data-class="bg-info">
                                                <i class="mdi mdi-checkbox-blank-circle font-size-11 me-2"></i>Meeting
                                            </div>
                                            <div class="external-event fc-event bg-warning" data-class="bg-warning">
                                                <i class="mdi mdi-checkbox-blank-circle font-size-11 me-2"></i>Generating
                                                Reports
                                            </div>
                                            <div class="external-event fc-event bg-danger" data-class="bg-danger">
                                                <i class="mdi mdi-checkbox-blank-circle font-size-11 me-2"></i>Create
                                                New theme
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div> <!-- end col-->
                            <div class="col-xl-9">
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
                                        <form class="needs-validation" name="event-form" id="form-event" novalidate>
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="mb-3" id="id_store">
                                                        <label class="form-label">Event Name</label>
                                                        <input class="form-control" placeholder="Insert Event Name" type="text"
                                                            name="title" id="event-title" required value="">
                                                        <div class="invalid-feedback">Please provide a valid event name
                                                        </div>
                                                    </div>
                                                </div> <!-- end col-->
                                                <div class="col-12">
                                                    <div class="mb-3">
                                                        <label class="form-label">Event Date</label>
                                                        <input class="form-control" type="datetime-local" name="date" id="event-date" required>
                                                        <!-- <div class="invalid-feedback2">Please provide a valid event date -->
                                                        </div>
                                                    </div>
                                            </div> <!-- end col-->
                                                <div class="col-12">
                                                    <div class="mb-3">
                                                        <label class="form-label">Category</label>
                                                        <select class="form-select" name="category" id="event-category">
                                                            <option value="bg-info" selected> --Select-- </option>
                                                            <option value="bg-danger">Danger</option>
                                                            <option value="bg-success">Success</option>
                                                            <option value="bg-primary">Primary</option>
                                                            <option value="bg-info">Info</option>
                                                            <option value="bg-dark">Dark</option>
                                                            <option value="bg-warning">Warning</option>
                                                        </select>
                                                        <div class="invalid-feedback">Please select a valid event
                                                            category</div>
                                                    </div>
                                                </div> <!-- end col-->
                                            </div> <!-- end row-->
                                            <div class="ps-4 pe-4">
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
                                            </div>
                                            <div class="row mt-2 ps-4 pe-4 pb-4">
                                                <div class="col-6">
                                                    <button type="button" class="btn btn-danger"
                                                        id="btn-delete-event">Delete</button>
                                                </div> <!-- end col-->
                                                <div class="col-6 text-end">
                                                    <button type="button" class="btn btn-light me-1"
                                                        data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-success" id="btn-save-event">Save</button>
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

                    new FullCalendarInteraction.Draggable(document.getElementById("external-events"),{ 
                            itemSelector: ".external-event",
                            eventData: function (e) {
                                return {title: e.innerText, className: g(e).data("class")}
                            }
                        }
                    );

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

                        let OppType = document.querySelector('[name=opp_type]');
                        if(!OppType){
                            OppType = document.createElement('input');
                            OppType.setAttribute('name', 'opp_type');
                            OppType.setAttribute('value', 'Create');
                            OppType.setAttribute('hidden', '');
                            document.querySelector("#id_store").insertBefore(OppType, document.querySelector("#event-title"));
                        } else {
                            OppType.setAttribute('value', 'Edit');
                        }
                    }

                    var m = new FullCalendar.Calendar(v, {

                            plugins: ["bootstrap", "interaction", "dayGrid", "timeGrid"],
                            editable: !0,
                            droppable: !0,
                            selectable: !0,
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
                                day = ('0' + date.getDate()).slice(-2), hours = ('0' + date.getHours()).slice(-2),
                                minutes = ('0' + date.getMinutes()).slice(-2),
                                formattedDateTime = `${year}-${month}-${day}T${hours}:${minutes}`;
                                g("#event-date").val(formattedDateTime),
                                g("#event-category").val(i.classNames[0]),
                                r = null, t.text("Edit Event"), r = null

                                let calId = document.querySelector('[name=cal_id]');
                                if(!calId){
                                    calId = document.createElement('input');
                                    calId.setAttribute('name', 'cal_id');
                                    calId.setAttribute('value', `${i.extendedProps.id}`);
                                    calId.setAttribute('hidden', '');
                                    document.querySelector("#id_store").insertBefore(calId, document.querySelector("#event-title"));
                                } else {
                                    calId.setAttribute('value', `${i.extendedProps.id}`);
                                }

                                let OppType = document.querySelector('[name=opp_type]');
                                if(!OppType){
                                    OppType = document.createElement('input');
                                    OppType.setAttribute('name', 'opp_type');
                                    OppType.setAttribute('value', 'Edit');
                                    OppType.setAttribute('hidden', '');
                                    document.querySelector("#id_store").insertBefore(OppType, document.querySelector("#event-title"));
                                } else {
                                    OppType.setAttribute('value', 'Edit');
                                }

                            },

                            dateClick: function (e) {
                                u(e)
                                date = new Date(e.dateStr),
                                year = date.getFullYear(), month = ('0' + (date.getMonth() + 1)).slice(-2),
                                day = ('0' + date.getDate()).slice(-2), hours = ('0' + date.getHours()).slice(-2),
                                minutes = ('0' + date.getMinutes()).slice(-2),
                                formattedDateTime = `${year}-${month}-${day}T${hours}:${minutes}`;
                                g("#event-date").val(formattedDateTime)
                            }, events: c
                        });
                        
                        m.render(),
                        g(a).on("submit", function (e) {
                            e.preventDefault();
                            g("#form-event :input");
                            var t, a = g("#event-title").val(), z = g("#event-date").val(),
                            n = g("#event-category").val(), carryOn = true;

                            $.ajax({
                                url: "actions/calendar.php",
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
                                        let OppType = document.querySelector('[name=opp_type]');
                                        if(OppType.value == "Create"){
                                            $("#success-msg").html("Event created. Loading...");
                                        } else {
                                            $("#success-msg").html("Event edited. Loading...");
                                        }
                                        $("#success").fadeIn();
                                    } else {
                                        $("#error-msg").html(data);
                                        $("#error").fadeIn();
                                        carryOn = false;
                                    }
                                },
                                error: function(e) {
                                    $("#error-msg").html(e);
                                    $("#error").fadeIn();
                                    carryOn = false;
                                }
                            });

                            if(carryOn){
                                setTimeout(()=> {
                                    !1 === s[0].checkValidity() ? (event.preventDefault(), event.stopPropagation(), s[0].classList.add("was-validated")) : (i ? (i.setProp("title", a),
                                    i.setProp("classNames", [n])) : (t = { title: a, start: z, allDay: r.allDay, className: n }, m.addEvent(t)), l.modal("hide"));
                                    $("#success").fadeOut("fast");
                                    $("#error").fadeOut("fast");
                                }, 3000);
                            }

                            
                        }),

                        g("#btn-delete-event").on("click", function (e) {
                            let carryOn = true, OppType = document.querySelector('[name=opp_type]');
                            if(!OppType){
                                OppType = document.createElement('input');
                                OppType.setAttribute('name', 'opp_type');
                                OppType.setAttribute('value', 'Delete');
                                OppType.setAttribute('hidden', '');
                                document.querySelector("#id_store").insertBefore(OppType, document.querySelector("#event-title"));
                            } else {
                                OppType.setAttribute('value', 'Delete');
                            }
                            
                            if(confirm("Do you want to delete event?")){

                                $.ajax({
                                    url: "actions/calendar.php",
                                    type: "POST",
                                    data: new FormData(document.querySelector("#form-event")),
                                    contentType: false,
                                    cache: false,
                                    processData: false,
                                    beforeSend: function() {
                                        $("#success").fadeOut("fast");
                                        $("#error").fadeOut("fast");
                                    },
                                    success: function(data) {

                                        if (data.trim() == 'success') {
                                            $("#success-msg").html("Event deleted. Loading...");
                                            $("#success").fadeIn();
                                        } else {
                                            $("#error-msg").html(data);
                                            $("#error").fadeIn();
                                            carryOn = false;
                                        }
                                    },
                                    error: function(e) {
                                        $("#error-msg").html(e);
                                        $("#error").fadeIn();
                                        carryOn = false;
                                    }
                                });

                                if(carryOn){
                                    setTimeout(()=> {
                                        i && (i.remove(), i = null, l.modal("hide"))
                                    }, 3000);
                                }
                            }
                        }),

                        g("#btn-new-event").on("click", function (e) {
                            u({ date: new Date, allDay: !0 })
                        })
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
