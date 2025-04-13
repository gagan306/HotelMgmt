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
}

$hotelId = $_GET['id'];
$query = "SELECT id, hotel_name, address, price, city_id FROM hotels WHERE id = $hotelId";
$result = mysqli_query($conn, $query);

if ($row = mysqli_fetch_assoc($result)) {
    echo json_encode($row);
} else {
    echo json_encode(['success' => false, 'message' => 'Hotel not found']);
}
?>
