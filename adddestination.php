<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection settings
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "travel_db";

// Connect to database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Connection failed: ' . $conn->connect_error]);
    exit;
}

// Handle actions
$action = isset($_GET['action']) ? $_GET['action'] : '';

// FETCH destinations
if ($action === 'fetch') {
    $result = $conn->query("SELECT id, destination_name FROM destinations ORDER BY id DESC");
    $destinations = [];

    while ($row = $result->fetch_assoc()) {
        $destinations[] = $row;
    }

    // Return JSON response
    echo json_encode($destinations);
    exit;
}

if ($action === 'add' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the POST data is received correctly
    if (isset($_POST['destination_Name'])) {
        $name = trim($_POST['destination_Name']);
    } else {
        echo json_encode(['success' => false, 'message' => 'destination_Name parameter is missing']);
        exit;
    }

    if (empty($name)) {
        echo json_encode(['success' => false, 'message' => 'Name is required.']);
        exit;
    }

    // Debugging: Log the name received
    error_log("Received destination name: " . $name);

    // Insert destination into the database
    $stmt = $conn->prepare("INSERT INTO destinations (destination_name) VALUES (?)");
    $stmt->bind_param("s", $name);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Destination added successfully.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to add destination.']);
    }
    $stmt->close();
    exit;
}

// UPDATE destination
if ($action === 'update' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
    $name = isset($_POST['destination_Name']) ? trim($_POST['destination_Name']) : '';

    if (empty($name)) {
        echo json_encode(['success' => false, 'message' => 'Name is required.']);
        exit;
    }

    if ($id <= 0) {
        echo json_encode(['success' => false, 'message' => 'Invalid ID.']);
        exit;
    }

    $stmt = $conn->prepare("UPDATE destinations SET destination_name = ? WHERE id = ?");
    $stmt->bind_param("si", $name, $id);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Destination updated successfully.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to update destination.']);
    }
    $stmt->close();
    exit;
}

// DELETE destination
if ($action === 'delete' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = isset($_POST['id']) ? intval($_POST['id']) : 0;

    if ($id <= 0) {
        echo json_encode(['success' => false, 'message' => 'Invalid ID.']);
        exit;
    }

    $stmt = $conn->prepare("DELETE FROM destinations WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Destination deleted successfully.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to delete destination.']);
    }
    $stmt->close();
    exit;
}

// Close connection
$conn->close();
?>
