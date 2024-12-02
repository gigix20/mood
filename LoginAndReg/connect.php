<?php

$host="localhost";
$user="root";
$pass="";
$db="login";
$port=3306;

$conn = new mysqli($host, $user, $pass, $db, $port);

if($conn->connect_error){
    echo "Failed".$conn->connect_error;
}
?>