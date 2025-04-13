<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "travel_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} // Make sure to include your DB connection file

$query = "SELECT h.id, h.hotel_name, h.address, h.price, h.city_id, c.destination_name AS city_name
          FROM hotels h
          JOIN destinations c ON h.city_id = c.id";
$result = mysqli_query($conn, $query);

$hotels = [];
while ($row = mysqli_fetch_assoc($result)) {
    $hotels[] = $row;
}

echo json_encode($hotels); // Return hotels as JSON
?>
