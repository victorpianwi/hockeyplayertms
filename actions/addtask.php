<?php

require_once "config.php";

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

$date_in = date('Y-m-d H:i:s');
$status = 0;

$sql = "INSERT INTO `tasks`(`task`, `assigned`, `due_date`, `status`, `date_in`) VALUES (?,?,?,?,?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssss", $task, $assignuser, $duedate, $status, $date_in);

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