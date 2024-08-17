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
$have_additional_info = $data['have_additional_info'];
$additional_info_type = $data['additional_info_type'];
$input_description = $data['input_description'];

// Insert item into the database
$sql = "INSERT INTO item_input (item, have_additional_info, additional_info_type, input_description) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param('siss', $item, $have_additional_info, $additional_info_type, $input_description);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Item added successfully']);
} else {
    echo json_encode(['success' => false, 'message' => 'Error adding item: ' . $stmt->error]);
}

$stmt->close();
$conn->close();
?>
