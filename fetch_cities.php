<?php
// fetch_cities.php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "travel_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}



$query = "SELECT id, destination_name FROM destinations";
$result = mysqli_query($conn, $query);

$cities = [];
while ($row = mysqli_fetch_assoc($result)) {
    $cities[] = $row;
}

echo json_encode($cities); // Return cities as JSON
?>

