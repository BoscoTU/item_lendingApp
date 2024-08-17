<?php
// get_user_detail.php

header('Content-Type: application/json');

// Database connection details
$host = "localhost";
$user = "root";
$pass = "";
$db = "item-lending-app_v1.7";

$charset = 'utf8mb4';

// DSN (Data Source Name) for PDO
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

// Options for PDO
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

if (isset($_GET['userid']) && isset($_GET['type'])) {
    $userid = $_GET['userid'];
    $type = $_GET['type'];

    try {
        // Fetch the most recent history based on datetime
        $stmt = $pdo->prepare('SELECT * FROM user_history WHERE id = ? ORDER BY timestamp DESC LIMIT 1');
        $stmt->execute([$userid]);
        $history = $stmt->fetch();

        if ($history && array_key_exists($type, $history)) {
            echo json_encode([$type => $history[$type]]);
        } else {
            echo json_encode(['error' => 'User or type not found']);
        }
    } catch (PDOException $e) {
        echo json_encode(['error' => 'Database query failed']);
    }
} else {
    echo json_encode(['error' => 'Invalid parameters']);
}
?>
