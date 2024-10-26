<?php

require_once 'config.php';

$user_id = $_POST["user_id"];

$message = $_POST["message"];

$seen = [$user_id];
$seen = json_encode($seen);

$date_in = date('Y-m-d H:i:s');

$sql = "INSERT INTO `chats`(`user_id`, `message`, `seen`, `date_in`) VALUES (?,?,?,?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssss", $user_id, $message, $seen, $date_in);

if($stmt->execute()){
    die("success");
} else {
    die("An unknown error occured! Please try again");
}
