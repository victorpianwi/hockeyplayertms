<?php

session_start();

require_once 'config.php';

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

        if(!in_array("$session_user_id", $chatArray)) {
            
            $total_num += 1;
            
        }

    }
} else {
    $total_num = 0;
}

$chats_num = $total_num;

$user_id = $_POST["user_id"];

$all_chats = [];

// Helper function to format date
function format_date($date)
{
    return date('Y-m-d', strtotime($date));
}

$today = format_date(date('Y-m-d'));
$yesterday = format_date(date('Y-m-d', strtotime('-1 day')));
$current_group = '';
$new_chat_display = false;

if ($chats->num_rows) {
    $total_chats = $chats->num_rows;
    $chat_count = 0;
    $chats->fetch_assoc();
    foreach ($chats as $chat) {

        $chat_count += 1;

        $message_date = format_date($chat["date_in"]);
        $formatted_time = date('H:i', strtotime($chat["date_in"]));
        $exploded_time = explode(":", $formatted_time);
        if ($exploded_time[0] > 12) {
            $formatted_time = number_format($exploded_time[0] - 12) . ':' . $exploded_time[1] . ' pm';
        } else {
            $formatted_time = number_format($exploded_time[0]) . ':' . $exploded_time[1] . ' am';
        }

        if ($message_date == $today) {
            $group = 'Today';
        } elseif ($message_date == $yesterday) {
            $group = 'Yesterday';
        } else {
            $group = date('F j, Y', strtotime($chat["date_in"]));
        }

        if ($user_id == $chat["user_id"]) {
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


        if ($current_group != $group) {
            array_push($all_chats,
            '
            <li>
                <div class="chat-day-title">
                    <span class="title">' . $group . '</span>
                </div>
            </li>');
            $current_group = $group;
        }

        if ($chats_num && $new_chat_display == false) {
            array_push($all_chats,
            '
            <li id="newChat">
                <div class="chat-day-title">
                    <span class="title">' . number_format($chats_num) . ' Unread Messages</span>
                </div>
            </li>');
            $new_chat_display = true;
        }

        if ($by_user == false) {
            $right = '';
            $user_image = '
                <div class="chat-avatar">
                    <img src="' . $chat_user["image"] . '" alt="avatar-2">
                </div>
            ';
            $user_detail = '
                <div class="conversation-name">' . $chat_user["firstname"] . ' ' . $chat_user["lastname"] . '</div>
            ';
        } else {
            $right = 'class="right"';
            $user_image = '';
            $user_detail = '';
        }

        if($new_chat_display == false && $chat_count == $total_chats){
            $chatId = 'id="newChat"';
        } else {
            $chatId = '';
        }

        array_push($all_chats,
        '
        <li ' . $chatId . ' ' . $right . '>
            <div class="conversation-list">
                ' . $user_image . '
                <div class="ctext-wrap">
                    ' . $user_detail . '
                    <div class="ctext-wrap-content">
                        <p class="mb-0">
                            ' . $chat["message"] . '
                        </p>
                    </div>

                    <p class="chat-time mb-0"><i class="mdi mdi-clock-outline align-middle me-1"></i>' . $formatted_time . '</p>
                </div>
            </div>
        </li>
        ');
    }
} else {
    array_push($all_chats,
    '
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
    ');
}

die(json_encode($all_chats));