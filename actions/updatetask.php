<?php

require_once "config.php";

$task_id = $_POST["task_id"];

if(empty($_POST["comments"])){
    die(json_encode(["status" => "Please enter task comment", "task_id" => ""]));
} else {
    $comments = htmlspecialchars($_POST["comments"]);
}

if(empty($_POST["status"])){
    die(json_encode(["status" => "Please select status", "task_id" => ""]));
} else {
    $status = htmlspecialchars($_POST["status"]);
}

if($status == 2){
    $status = 0;
}

$sql = "UPDATE `tasks` SET `comments` = ?, `status` = ? WHERE `task_id` = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $comments, $status, $task_id);

if($stmt->execute()){

    echo json_encode([
        "status" => "success",
        "task_id" => $task_id
    ]);
} else {
    die("An unknown error occurred! Please try again");
}