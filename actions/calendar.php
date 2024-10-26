<?php

require_once "config.php";

if(isset($_POST["cal_id"])){
    $cal_id = $_POST["cal_id"];
}

$opp_type = trim($_POST["opp_type"]);

if(empty($_POST["title"])){
    die("Event's title is required!");
} else {
    $title = htmlspecialchars($_POST["title"]);
}

if(empty($_POST["date"])){
    die("Event's date is required!");
} else {
    $date = htmlspecialchars($_POST["date"]);
}

$category = trim($_POST["category"]);

if($opp_type == "Create"){
    $sql = "INSERT INTO `calendar`(`title`, `date`, `category`) VALUES (?,?,?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $title, $date, $category);
} else if ($opp_type == "Edit") {
    $sql = "UPDATE `calendar` SET `title`= ?,`date`= ?,`category`= ? WHERE `cal_id` = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $title, $date, $category, $cal_id);
} else {
    $sql = "DELETE FROM `calendar` WHERE `cal_id` = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $cal_id);
}

if($stmt->execute()){
    echo "success";
} else {
    die("An unknown error occurred! Please try again");
}


?>