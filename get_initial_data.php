<?php
// Database connection details
$host = "localhost";
$dbname = "item-lending-app_v1.7";
$username = "root";
$password = "";

// Create a connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query to get the most recent history for each ID where can_borrow = 0
$sql = "
SELECT t1.*
FROM user_history t1
INNER JOIN (
    SELECT id, MAX(timestamp) as latest_timestamp
    FROM user_history
    GROUP BY id
) t2 
ON t1.id = t2.id AND t1.timestamp = t2.latest_timestamp";

// Execute the query
$result = $conn->query($sql);

$data = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
} else {
    $data['error'] = "No data found";
}

// Close the connection
$conn->close();

// Return the data as JSON
header('Content-Type: application/json');
echo json_encode($data);
?>
