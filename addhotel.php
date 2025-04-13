<?php
// Database connection settings
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "travel_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Connection failed: ' . $conn->connect_error]);
    exit;
}

// Handle actions
$action = isset($_GET['action']) ? $_GET['action'] : '';

// Fetch destinations
if ($action === 'fetch_destinations') {
    $result = $conn->query("SELECT id, destination_name FROM destinations ORDER BY destination_name");
    $destinations = [];

    while ($row = $result->fetch_assoc()) {
        $destinations[] = $row;
    }

    echo json_encode($destinations);
    exit;
}

// Add hotel
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['hotel_name'], $_POST['hotel_address'], $_POST['suit_type'], $_POST['hotel_category'], $_POST['hotel_price'], $_POST['hotel_rooms'], $_POST['destination_id'])) {
        $hotelName = $_POST['hotel_name'];
        $hotelAddress = $_POST['hotel_address'];
        $suitType = $_POST['suit_type'];
        $hotelCategory = $_POST['hotel_category'];
        $hotelPrice = $_POST['hotel_price'];
        $hotelRooms = $_POST['hotel_rooms'];
        $destinationId = $_POST['destination_id'];

        $stmt = $conn->prepare("INSERT INTO hotels (hotel_name, hotel_address, suit_type, hotel_category, hotel_price, hotel_rooms, destination_id) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssdis", $hotelName, $hotelAddress, $suitType, $hotelCategory, $hotelPrice, $hotelRooms, $destinationId);

        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Hotel added successfully.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to add hotel.']);
        }

        $stmt->close();
        exit;
    }
}

// Close connection
$conn->close();
?>
