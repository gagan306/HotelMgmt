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

$data = json_decode(file_get_contents('php://input'), true);
$hotelId = $data['id'];

$query = "DELETE FROM hotels WHERE id = $hotelId";

if (mysqli_query($conn, $query)) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Error deleting hotel']);
}
?>
