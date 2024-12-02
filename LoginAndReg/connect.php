<?php

$host="localhost";
$user="root:3307";
$pass="";
$db="login";
$port="3307";

$conn = new mysqli($host, $user, $pass, $db, $port);

if($conn->connect_error){
    echo "Failed".$conn->connect_error;
}
?>