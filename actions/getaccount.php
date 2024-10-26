<?php

$sql = "SELECT * FROM users WHERE user_id = ? LIMIT 1;";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $id);
$id = $_SESSION["user_id"];
$stmt->execute();
$user = $stmt->get_result();
if(!$user->num_rows){
    header("Location: login.php");
} else {
    $user = $user->fetch_assoc();
}

?>