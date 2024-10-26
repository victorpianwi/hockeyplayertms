<?php

require_once "config.php";

$user_id = $_POST["user_id"];

$email = $_POST["email"];

$password = $_POST["password"];

$sql = "SELECT * FROM users WHERE email = ? AND NOT(user_id = ?);";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $mail, $user_id);
$mail = $email;
$stmt->execute();
$email_exits = $stmt->get_result();

if($email_exits->num_rows){
    die("Email already used!");
}

$sql = "SELECT * FROM users WHERE user_id = ?;";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $user_id);
$stmt->execute();
$user = $stmt->get_result();
$user = $user->fetch_assoc();
$password_hash = $user["password"];

if(password_verify($password, $password_hash)){

    $sql = "UPDATE users SET email = ? WHERE user_id = ?;";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $email, $user_id);

    if($stmt->execute()){
        echo "success";
    } else {
        die("An unknown error occurred! Please try again");
    }
    
} else {
    die("Incorrect password!");
}