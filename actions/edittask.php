<?php

require_once "config.php";

$task_id = $_POST["task_id"];

if(empty($_POST["task"])){
    die(json_encode(["status" => "Please enter task", "task_id" => ""]));
} else {
    $task = htmlspecialchars($_POST["task"]);
}

if(empty($_POST["assignuser"])){
    die(json_encode(["status" => "Please select user to assign", "task_id" => ""]));
} else {
    $assignuser = htmlspecialchars($_POST["assignuser"]);
}

if(empty($_POST["duedate"])){
    die(json_encode(["status" => "Please select due date", "task_id" => ""]));
} else {
    $duedate = htmlspecialchars($_POST["duedate"]);
}

$sql = "UPDATE `tasks` SET `task` = ?, `assigned` = ?, `due_date` = ? WHERE `task_id` = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssss", $task, $assignuser, $duedate, $task_id);

if($stmt->execute()){

    $sql = "SELECT * FROM `tasks` WHERE `assigned` = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $assignuser);
    $stmt->execute();
    $stmt = $stmt->get_result();
    $stmt = $stmt->fetch_assoc();
    $task_id = $stmt["task_id"];

    echo json_encode([
        "status" => "success",
        "task_id" => $task_id
    ]);
} else {
    die("An unknown error occurred! Please try again");
}