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

$hotelId = $_POST['id'];
$hotelName = $_POST['hotel_name'];
$cityId = $_POST['city'];
$address = $_POST['address'];
$price = $_POST['price'];

$query = "UPDATE hotels 
          SET hotel_name = '$hotelName', city_id = '$cityId', address = '$address', price = '$price'
          WHERE id = $hotelId";

if (mysqli_query($conn, $query)) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Error updating hotel']);
}
?>
