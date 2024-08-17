<?php
header('Content-Type: application/json');

// Database connection details
$host = "localhost";
$user = "root";
$pass = "";
$db = "item-lending-app_v1.7";
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    echo json_encode(['error' => 'Database connection failed']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    // Map the incoming data to the expected database column names
    $mappedData = [
        'timestamp' => $data['timestamp'] ?? null,
        'action' => $data['action'] ?? null,
        'id' => $data['id'] ?? null,
        'can_borrow' => $data['can_borrow'] ?? null,
        'name' => $data['name'] ?? null,
        'class' => $data['class'] ?? null,
        'class_number' => $data['class number'] ?? null,
        'date' => $data['date'] ?? null,
        'period' =>$data['period'] ?? null,
        'item_dealt_with' => $data['item dealt with'] ?? null,
        'additional_information' => $data['additional_information'] ?? null
    ];


    $sql = "INSERT INTO user_history (
        timestamp, action, id, can_borrow, name, class, class_number, date, period, item_dealt_with, additional_information
    ) VALUES (
        :timestamp, :action, :id, :can_borrow, :name, :class, :class_number, :date, :period, :item_dealt_with, :additional_information
    )";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':timestamp' => $mappedData['timestamp'],
        ':action' => $mappedData['action'],
        ':id' => $mappedData['id'],
        ':can_borrow' => $mappedData['can_borrow'],
        ':name' => $mappedData['name'],
        ':class' => $mappedData['class'],
        ':class_number' => $mappedData['class_number'],
        ':date' => $mappedData['date'],
        ':period' => $mappedData['period'],
        ':item_dealt_with' => $mappedData['item_dealt_with'],
        ':additional_information' => $mappedData['additional_information']
    ]);

    echo json_encode(['success' => true]);
} else {
    echo json_encode(['error' => 'Invalid request method']);
}
?>
