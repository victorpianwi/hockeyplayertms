<?php

session_start();

if (!isset($_SESSION["online"])) {
    header("Location: login.php");
    exit;
}

require_once 'actions/config.php';
require_once 'actions/site.php';
require_once 'actions/getaccount.php';

$session_user_id = $_SESSION["user_id"];

$sql = "SELECT * FROM `chats` ORDER BY date_in ASC";
$chats = $conn->prepare($sql);
$chats->execute();
$chats = $chats->get_result();

$sql = "SELECT * FROM `chats` WHERE NOT(`user_id` = ?) ORDER BY date_in ASC";
$chats_num = $conn->prepare($sql);
$chats_num->bind_param("s", $session_user_id);
$chats_num->execute();
$chats_num = $chats_num->get_result();

$total_num = 0;

if($chats_num->num_rows){
    $chats_num->fetch_assoc();

    foreach ($chats_num as $chat_num){

        $chatArray = json_decode($chat_num['seen'], true);

        if(!in_array($session_user_id, $chatArray)) {
            
            $total_num += 1;
            
        }

    }
} else {
    $total_num = 0;
}

$chats_num = $total_num;


?>
<!doctype html>
<html lang="en">

<head>
        
        <meta charset="utf-8" />
        <title>Chat | <?= $site["site_title"]?></title>
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
                                    <h4 class="mb-sm-0">Chat</h4>

                                </div>
                            </div>
                        </div>
                        <!-- end page title -->

                        <div class="row">
                            <div class="col-lg-10">
                                <div class="card">
                                    <div class="card-body border-bottom">
    
                                        <div class="user-chat-border">
                                            <div class="row">
                                                <div class="col-md-5 col-9">
                                                    <h5 class="font-size-15 mb-1">Communication Hub</h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="chat-widget">
                                            <div class="chat-conversation" data-simplebar style="max-height: 295px;">
                                                <ul id="chatlist" class="list-unstyled mb-0 pe-3">

                                                    <?php

                                                    // Helper function to format date
                                                    function format_date($date) {
                                                        return date('Y-m-d', strtotime($date));
                                                    }

                                                    $today = format_date(date('Y-m-d'));
                                                    $yesterday = format_date(date('Y-m-d', strtotime('-1 day')));
                                                    $current_group = '';
                                                    $new_chat_display = false;

                                                    if($chats->num_rows){
                                                        $total_chats = $chats->num_rows;
                                                        $chat_count = 0;
                                                        $chats->fetch_assoc();
                                                        foreach($chats as $chat){

                                                            $chat_count += 1;

                                                            $message_date = format_date($chat["date_in"]);
                                                            $formatted_time = date('H:i', strtotime($chat["date_in"]));
                                                            $exploded_time = explode(":", $formatted_time);
                                                            if($exploded_time[0] > 12){
                                                                $formatted_time = number_format($exploded_time[0] - 12).':'.$exploded_time[1].' pm';
                                                            } else {
                                                                $formatted_time = number_format($exploded_time[0]).':'.$exploded_time[1].' am';
                                                            }

                                                            if ($message_date == $today) {
                                                                $group = 'Today';
                                                            } elseif ($message_date == $yesterday) {
                                                                $group = 'Yesterday';
                                                            } else {
                                                                $group = date('F j, Y', strtotime($chat["date_in"]));
                                                            }

                                                            if($user["user_id"] == $chat["user_id"]){
                                                                $by_user = true;
                                                            } else {
                                                                $by_user = false;
                                                            }

                                                            $sql = "SELECT * FROM users WHERE user_id = ? LIMIT 1;";
                                                            $stmt = $conn->prepare($sql);
                                                            $stmt->bind_param("s", $id);
                                                            $id = $chat["user_id"];
                                                            $stmt->execute();
                                                            $chat_user = $stmt->get_result();
                                                            $chat_user = $chat_user->fetch_assoc();


                                                    ?>
                                                    <?php if ($current_group != $group) { ?>
                                                    <li> 
                                                        <div class="chat-day-title">
                                                            <span class="title"><?= $group ?></span>
                                                        </div>
                                                    </li>
                                                    <?php $current_group = $group; } ?>
                                                    <?php if ($chats_num && $new_chat_display == false) { ?>
                                                    <li id="newChat"> 
                                                        <div class="chat-day-title">
                                                            <span class="title"><?= number_format($chats_num) ?> Unread Messages</span>
                                                        </div>
                                                    </li>
                                                    <?php $new_chat_display = true; } ?>
                                                    <li <?= $new_chat_display == false && $chat_count == $total_chats ? 'id="newChat"' : ''?> <?= $by_user == true ? 'class="right"' : ''?>>
                                                        <div class="conversation-list">
                                                            <?php if( $by_user == false){ ?>
                                                            <div class="chat-avatar">
                                                                <img src="<?= $chat_user["image"]?>" alt="avatar-2">
                                                            </div>
                                                            <?php } ?>
                                                            <div class="ctext-wrap">
                                                                <?php if( $by_user == false){ ?>
                                                                    <div class="conversation-name"><?= $chat_user["firstname"]." ".$chat_user["lastname"] ?></div>
                                                                <?php } ?>
                                                                <div class="ctext-wrap-content">
                                                                    <p class="mb-0">
                                                                        <?= $chat["message"] ?>
                                                                    </p>
                                                                </div>
        
                                                                <p class="chat-time mb-0"><i class="mdi mdi-clock-outline align-middle me-1"></i> <?= $formatted_time ?></p>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <?php } } else { ?>
                                                        <li>
                                                            <div id="noMessage" class="conversation-list">
                                                                <div class="ctext-wrap">
                                                                    <div class="ctext-wrap-content">
                                                                        <p class="mb-0">
                                                                            No Messages yet
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                                
                                                            </div>
                                                        </li>
                                                    <?php } ?>
                                                    
                                                    
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="p-3 chat-input-section border-top">
                                        <form class="row" id="form">
                                            <div class="col">
                                                <div>
                                                    <input type="text" class="form-control rounded chat-input ps-3" placeholder="Enter Message..." name="message" required>
                                                    <input type="text" hidden readonly required value="<?= $user["user_id"] ?>" name="user_id">
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <button type="submit" class="btn btn-primary chat-send w-md waves-effect waves-light"><span class="d-none d-sm-inline-block me-2">Send</span> <i class="mdi mdi-send"></i></button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end row -->

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

        <script src="assets/js/app.js"></script>

        <script>
            let idleTime = 0;
            const updateChat = () => {
                $.ajax({
                    url: "actions/getchat.php",
                    type: "POST",
                    data: new FormData(document.querySelector("#form")),
                    contentType: false,
                    cache: false,
                    processData: false,
                    beforeSend: function() {},
                    success: function(data) {

                        document.querySelector("#chatlist").innerHTML = JSON.parse(data).join(" ");
                        
                        document.querySelector("#newChat").scrollIntoView({
                            behavior: 'smooth',
                            block: 'start',
                            inline: 'nearest'
                        });
                        
                    },
                    error: function(e) {
                    }
                });
            }

            document.querySelector("#chatlist").addEventListener('mousemove', ()=>{
                idleTime = 0;
            })

            document.querySelector("#chatlist").addEventListener('keydown', ()=>{
                idleTime = 0;
            })

            document.querySelector("#chatlist").addEventListener('touchstart', ()=>{
                idleTime = 0;
            })

            setInterval(()=>{
                idleTime += 1;

                if(idleTime >= 120){
                    updateChat();
                }
            }, 1000);

            document.querySelector("#form").addEventListener("submit", (e)=>{
                e.preventDefault();

                $.ajax({
                    url: "actions/chat.php",
                    type: "POST",
                    data: new FormData(document.querySelector("#form")),
                    contentType: false,
                    cache: false,
                    processData: false,
                    beforeSend: function() {},
                    success: function(data) {

                        if(data == "success"){
                            document.querySelector("#form").reset();
                            updateChat();
                        } else {

                        }
                        
                    },
                    error: function(e) {
                    }
                });
            })

            window.onload = () => {
                document.querySelector("#newChat").scrollIntoView({
                    behavior: 'smooth',
                    block: 'start',
                    inline: 'nearest'
                });
            }
            
        </script>

        <?php

            $sql = "SELECT * FROM `chats`";
            $chatUpdate = $conn->prepare($sql);
            $chatUpdate->execute();
            $chatUpdate = $chatUpdate->get_result();

            if($chatUpdate->num_rows){
                $chatUpdate->fetch_assoc();

                foreach ($chatUpdate as $update){

                    $chatArray = json_decode($update["seen"], true);
                    $chat_id = $update["chat_id"];

                    if(!in_array($session_user_id, $chatArray)) {
                        
                        $chatArray[] = $session_user_id;
                        
                        $updatedChatArray = json_encode($chatArray);

                        $sql = "UPDATE `chats` SET `seen` = ? WHERE chat_id = ?";
                        $update_chat = $conn->prepare($sql);
                        $update_chat->bind_param("ss", $updatedChatArray, $chat_id);
                        $update_chat->execute();
                        
                    }

                }
            }

        ?>

    </body>

</html>
