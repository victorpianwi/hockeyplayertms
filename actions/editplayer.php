<?php

require_once "config.php";

$player_id = $_POST["player_id"];

if(empty($_POST["firstname"])){
    die(json_encode(["status" => "Player's Firstname is required!", "player_id" => $player_id]));
} else {
    $firstname = htmlspecialchars($_POST["firstname"]);
}

if(empty($_POST["lastname"])){
    die(json_encode(["status" => "Player's Lastname is required!", "player_id" => $player_id]));
} else {
    $lastname = htmlspecialchars($_POST["lastname"]);
}

if(empty($_POST["email"])){
    die(json_encode(["status" => "Player's Email is required!", "player_id" => $player_id]));
} else {
    $email = htmlspecialchars($_POST["email"]);
}

if(empty($_POST["gender"])){
    die(json_encode(["status" => "Player's Gender is required!", "player_id" => $player_id]));
} else {
    $gender = htmlspecialchars($_POST["gender"]);
}

if(empty($_POST["age"])){
    die(json_encode(["status" => "Player's Age is required!", "player_id" => $player_id]));
} else {
    $age = htmlspecialchars($_POST["age"]);
}

if(empty($_POST["role"])){
    die(json_encode(["status" => "Player's position is required!", "player_id" => $player_id]));
} else {
    $role = htmlspecialchars($_POST["role"]);
}

if(empty($_POST["speed"])){
    die(json_encode(["status" => "Player's speed is required!", "player_id" => ""]));
} else {
    $speed = htmlspecialchars($_POST["speed"]);
}

if(empty($_POST["endurance_level"])){
    die(json_encode(["status" => "Player's endurance level is required!", "player_id" => ""]));
} else {
    $endurance_level = htmlspecialchars($_POST["endurance_level"]);
}

if(empty($_POST["games_played"])){
    die(json_encode(["status" => "The number of Games played is required!", "player_id" => $player_id]));
} else {
    $games_played = htmlspecialchars($_POST["games_played"]);
}

if(empty($_POST["goals"])){
    die(json_encode(["status" => "The number of Goals scored is required!", "player_id" => $player_id]));
} else {
    $goals = htmlspecialchars($_POST["goals"]);
}

if(empty($_POST["assists"])){
    die(json_encode(["status" => "The number of Assists is required!", "player_id" => $player_id]));
} else {
    $assists = htmlspecialchars($_POST["assists"]);
}

if(empty($_POST["state"])){
    die(json_encode(["status" => "Player's state is required!", "player_id" => ""]));
} else {
    $state = htmlspecialchars($_POST["state"]);
}

if(empty($_POST["country"])){
    die(json_encode(["status" => "Player's country is required!", "player_id" => ""]));
} else {
    $country = htmlspecialchars($_POST["country"]);
}

$sql = "SELECT * FROM users WHERE email = ? AND NOT user_id = ?;";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $email, $player_id);
$stmt->execute();
$user = $stmt->get_result();

if($user->num_rows){
    die(json_encode(["status" => "Email is already in use by another player!", "player_id" => $player_id]));
}

$sql = "SELECT * FROM `users` WHERE `user_id` = ?";
$player = $conn->prepare($sql);
$player->bind_param("s", $player_id);
$player->execute();
$player = $player->get_result();

if($player->num_rows){
    $player = $player->fetch_assoc();
} else {
    die(json_encode(["status" => "An unknown error occurred!", "player_id" => $player_id]));
}

$allowed = [
    "jpeg" => "image/jpeg",
    "jpg" => "image/jpg",
    "png" => "image/png"
];

$imagename = $_FILES["image"]["name"];
$imagetype = $_FILES["image"]["type"];
$imagesize = $_FILES["image"]["size"];

$maxsize = 100 * 1024 * 1024;

if($_FILES["image"]["size"] > 0){
    if($imagesize > $maxsize){
        die(json_encode(["status" => "Image is more than 100MB!", "player_id" => ""]));
    } else {
        if(in_array($imagetype, $allowed)){
            if(file_exists("../uploads/".$imagename)){
                $randomnumber = uniqid();
                $imagename = "img".$randomnumber.$imagename;
                move_uploaded_file($_FILES["image"]["tmp_name"], "../uploads/".$imagename);
                $imagename = "uploads/".$imagename;
            } else {
                move_uploaded_file($_FILES["image"]["tmp_name"], "../uploads/".$imagename);
                $imagename = "uploads/".$imagename;
            }
        } else {
            die(json_encode(["status" => "Allowed Files types are jpeg, jpg and png!", "player_id" => ""]));
        }
    }
} else {
    $imagename = $player["image"];
}

$sql = "UPDATE `users`SET `firstname` = ?, `lastname` = ?, `email` = ?, `age` = ?, `role` = ?, `speed` = ?, `endurance_level` = ?, `games_played` = ?, `goals` = ?, `assists` = ?, `state` = ?, `country` = ?, `gender` = ?, `image` = ? WHERE `user_id` = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssssssssssssss", $firstname, $lastname, $email, $age, $role, $speed, $endurance_level, $games_played, $goals, $assists, $state, $country, $gender, $imagename, $player_id);

if($stmt->execute()){

    echo json_encode([
        "status" => "success",
        "player_id" => $player_id
    ]);

} else {
    die("An unknown error occurred! Please try again");
}


?>