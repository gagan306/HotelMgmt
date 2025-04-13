<?php
header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "travel_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(['success' => false, 'message' => 'Connection failed: ' . $conn->connect_error]));
}

// Fetch Hotels
if (isset($_GET['action']) && $_GET['action'] == 'fetch') {
    $query = "SELECT h.id, h.hotel_name, h.address, h.price, h.city_id, c.destination_name AS city_name
              FROM hotels h
              JOIN destinations c ON h.city_id = c.id";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $hotels = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $hotels[] = $row;
        }
        echo json_encode($hotels);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error fetching hotels']);
    }
    exit;
}

// Get single hotel data for editing
if (isset($_GET['action']) && $_GET['action'] == 'getHotel') {
    $hotelId = $_GET['id'];
    $query = "SELECT id, hotel_name, address, price, city_id FROM hotels WHERE id = $hotelId";
    $result = mysqli_query($conn, $query);

    if ($result && $row = mysqli_fetch_assoc($result)) {
        echo json_encode($row);
    } else {
        echo json_encode(['success' => false, 'message' => 'Hotel not found']);
    }
    exit;
}

// Handle POST actions (add, update, delete)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action']) && $_POST['action'] == 'add') {
        $hotelName = $_POST['hotel_name'];
        $cityId = $_POST['city'];
        $address = $_POST['address'];
        $price = $_POST['price'];

        $query = "INSERT INTO hotels (hotel_name, city_id, address, price) VALUES ('$hotelName', '$cityId', '$address', '$price')";
        if (mysqli_query($conn, $query)) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error adding hotel']);
        }
    }

    if (isset($_POST['action']) && $_POST['action'] == 'update') {
        $hotelId = $_POST['id'];
        $hotelName = $_POST['hotel_name'];
        $cityId = $_POST['city'];
        $address = $_POST['address'];
        $price = $_POST['price'];

        $query = "UPDATE hotels SET hotel_name = '$hotelName', city_id = '$cityId', address = '$address', price = '$price' WHERE id = $hotelId";
        if (mysqli_query($conn, $query)) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error updating hotel']);
        }
    }

    if (isset($_POST['action']) && $_POST['action'] == 'delete') {
        $hotelId = $_POST['id'];
        $query = "DELETE FROM hotels WHERE id = $hotelId";
        if (mysqli_query($conn, $query)) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error deleting hotel']);
        }
    }
}

$conn->close();
?>
