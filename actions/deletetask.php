<?php

require_once "config.php";

$task_id = $_GET["task_id"];

$sql = "DELETE FROM `tasks` WHERE `task_id` = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $task_id);

if($stmt->execute()){
    
    header("Location: ../tasks.php");

} else {
    die("An unknown error occurred! Please try again");
}