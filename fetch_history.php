<?php
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

$sql = "SELECT * FROM user_history ORDER BY timestamp DESC";
$stmt = $pdo->query($sql);
$history = $stmt->fetchAll();

header('Content-Type: application/json');
echo json_encode($history);
?>
