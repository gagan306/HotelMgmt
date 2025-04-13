<?php
// add_hotel.php

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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $hotel_name = $_POST['hotel_name'];
    $city = $_POST['city'];
    $address = $_POST['address'];
    $price = $_POST['price'];

    if (empty($hotel_name) || empty($city) || empty($address) || empty($price)) {
        echo json_encode(['success' => false, 'message' => 'All fields are required.']);
        exit;
    }

    $stmt = $conn->prepare("INSERT INTO hotel (hotel_name, city, address, price) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sisd", $hotel_name, $city, $address, $price);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Hotel added successfully.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to add hotel.']);
    }

    $stmt->close();
}

$conn->close();
?>
