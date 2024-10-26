<?php

session_start();

require_once "config.php";

require_once "site.php";

if(empty($_POST["email"])){
    die("Email address is required!");
} else {
    $email = htmlspecialchars($_POST["email"]);
}

if(empty($_POST["password"])){
    die("Password is required!");
} else {
    $password = htmlspecialchars($_POST["password"]);
}

$sql = "SELECT * FROM users WHERE email = ?;";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $mail);
$mail = $email;
$stmt->execute();
$user = $stmt->get_result();

if($user->num_rows){
    $user = $user->fetch_assoc();
    $password_hash = $user["password"];
    if(password_verify($password, $password_hash)){

        $_SESSION["online"] = "active";
        $_SESSION["active_mail"] = $email;
        $_SESSION["user_id"] = $user["user_id"];

        if($user["admin"]){
            $_SESSION["admin"] = true;
        } else {
            $_SESSION["admin"] = false;  
        }

        echo "success";
        
    } else {
        die("Incorrect password!");
    }
} else {
    die("Invalid email address!");
}



?>