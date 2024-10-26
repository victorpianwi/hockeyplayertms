<?php

$sql = "SELECT * FROM setup LIMIT 1";
$site = $conn->prepare($sql);
$site->execute();
$site = $site->get_result();
$site = $site->fetch_assoc();

?>