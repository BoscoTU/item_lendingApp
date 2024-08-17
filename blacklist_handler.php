<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "item-lending-app_v1.7";

$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['method'])) {
    $method = $data['method'];
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        echo json_encode(['success' => false, 'message' => 'Connection failed: ' . $conn->connect_error]);
        exit();
    }

    if ($method === 'add') {
        if (isset($data['id']) && isset($data['name']) && isset($data['class']) && isset($data['class_number'])) {
            $id = intval($data['id']);
            $name = $data['name'];
            $class = $data['class'];
            $class_number = intval($data['class_number']);

            $stmt = $conn->prepare("INSERT INTO black_list (id, name, class, class_number) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("issi", $id, $name, $class, $class_number);

            if ($stmt->execute()) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Error: ' . $stmt->error]);
            }

            $stmt->close();
        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid input']);
        }
    } elseif ($method === 'delete' && isset($data['id'])) {
        $id = intval($data['id']);

        $stmt = $conn->prepare("DELETE FROM black_list WHERE id = ?");
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error: ' . $stmt->error]);
        }

        $stmt->close();
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid method']);
    }

    $conn->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Method not specified']);
}
?>
