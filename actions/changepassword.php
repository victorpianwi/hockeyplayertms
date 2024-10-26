<?php

require_once "config.php";

$user_id = $_POST["user_id"];

$oldpassword = $_POST["oldpassword"];
$newpassword = $_POST["newpassword"];
$confirmpassword = $_POST["confirmpassword"];

if($newpassword != $confirmpassword){
    die("Passwords does not match!");
}

$sql = "SELECT * FROM users WHERE user_id = ?;";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $user_id);
$stmt->execute();
$user = $stmt->get_result();
$user = $user->fetch_assoc();
$password_hash = $user["password"];

if(password_verify($oldpassword, $password_hash)){

    $password = password_hash($newpassword, PASSWORD_DEFAULT);

    $sql = "UPDATE users SET `password` = ? WHERE user_id = ?;";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $password, $user_id);

    if($stmt->execute()){
        echo "success";
    } else {
        die("An unknown error occurred! Please try again");
    }
    
} else {
    die("Incorrect old password!");
}