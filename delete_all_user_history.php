<?php
// Database connection settings
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "item-lending-app_v1.7"; // Update with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query to delete all records from the user history table
$sql = "DELETE FROM `user_history`"; // Update with your table name

if ($conn->query($sql) === TRUE) {
    echo "All records deleted successfully";
} else {
    echo "Error deleting records: " . $conn->error;
}

// Close the database connection
$conn->close();
?>
