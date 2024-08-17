<?php
header('Content-Type: application/json');

// Database connection details
$host = 'localhost';
$user = 'root';
$password = '';
$database = 'item-lending-app_v1.7';

// Create connection
$conn = new mysqli($host, $user, $password, $database);

// Check connection
if ($conn->connect_error) {
    die(json_encode(['success' => false, 'message' => 'Database connection failed: ' . $conn->connect_error]));
}

// Get JSON input
$data = json_decode(file_get_contents('php://input'), true);

$item = $data['item'];

if (empty($item)) {
    echo json_encode(['success' => false, 'message' => 'Item name is required']);
    exit;
}

// Delete item from the database
$sql = "DELETE FROM item_input WHERE item = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $item);

if ($stmt->execute()) {
    if ($stmt->affected_rows > 0) {
        echo json_encode(['success' => true, 'message' => 'Item deleted successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Item not found']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Error deleting item: ' . $stmt->error]);
}

$stmt->close();
$conn->close();
?>
