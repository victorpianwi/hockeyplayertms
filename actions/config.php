<?php

if($_SERVER["HTTP_HOST"] == "localhost"){

    $host = "localhost";
    $username = "root";
    $password = "";
    $db = "hockeytms";

} else {

    $host = "localhost";
    $username = "";
    $password = "";
    $db = "";

}

$conn = new mysqli($host, $username, $password, $db);

?>