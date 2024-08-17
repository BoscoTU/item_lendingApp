<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "item_lending_app_v1_7";

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
$additionalInfo = $data['additionalInfo'];

// Check if user can return
$sql = "SELECT can_borrow FROM user_history WHERE id_no = ? AND item_borrowed = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("is", $id_no, $item);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    if (!$row['can_borrow']) {
        // Update borrowing record to returned
        $sql = "UPDATE user_history SET can_borrow = 1 WHERE id_no = ? AND item_borrowed = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("is", $id_no, $item);
        $stmt->execute();
        
        echo json_encode(["status" => "success", "message" => "Item returned successfully"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Item is not borrowed or already returned"]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "No such borrowing record found"]);
}

$stmt->close();
$conn->close();
?>
