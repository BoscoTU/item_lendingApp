<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "item_lending_app_v1.7";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get data from POST request
$data = json_decode(file_get_contents("php://input"), true);

$id_no = $data['id_no'];
$name = $data['name'];
$class_name = $data['class_name'];
$class_no = $data['class_no'];
$item = $data['item'];
$period = $data['period'];
$additionalInfo = $data['additionalInfo'];
$can_borrow = false; // User cannot borrow until checked

// Check if user can borrow
$sql = "SELECT can_borrow FROM user_history WHERE id_no = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_no);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    if ($row['can_borrow']) {
        $can_borrow = true;
    }
}

if ($can_borrow) {
    // Insert borrowing record
    $sql = "INSERT INTO user_history (id_no, name, class, class_number, item_borrowed, action_datetime, can_borrow, basketball_number, have_badminton, have_plug) VALUES (?, ?, ?, ?, ?, NOW(), ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $basketball_number = $item === 'basketball' ? $additionalInfo['basketball_number'] : null;
    $have_badminton = $item === 'badminton racket' ? $additionalInfo['have_badminton'] : null;
    $have_plug = $item === 'portable battery' ? $additionalInfo['have_plug'] : null;
    $stmt->bind_param("ississiii", $id_no, $name, $class_name, $class_no, $item, 0, $basketball_number, $have_badminton, $have_plug);
    $stmt->execute();
    
    echo json_encode(["status" => "success", "message" => "Item borrowed successfully"]);
} else {
    echo json_encode(["status" => "error", "message" => "User cannot borrow items"]);
}

$stmt->close();
$conn->close();
?>
