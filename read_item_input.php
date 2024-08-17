<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";  // Replace with your actual password if needed
$dbname = "item-lending-app_v1.7";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


// Get data from POST request
$data = json_decode(file_get_contents("php://input"), true);


header('Content-Type: application/json');

$sql = "SELECT * FROM item_input";
$result = $conn->query($sql);

$data = array();

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

echo json_encode($data);

$conn->close();
?>
