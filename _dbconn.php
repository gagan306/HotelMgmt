<?php

$servername = "localhost";
$username = "root";
$password = ""; 
$database = "user_db"; 


$conn = new mysqli($servername, $username, $password, $database);


if ($conn->connect_error) {
   
    die("error".$conn->connect_error);

}
 $conn->close();
?>