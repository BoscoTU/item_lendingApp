<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "item-lending-app_v1.7";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the request method
$method = $_SERVER['REQUEST_METHOD'];

// Switch based on request method
switch ($method) {
    case 'GET':
        // Retrieve blacklist entries
        $sql = "SELECT * FROM black_list";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $blacklist = array();
            while ($row = $result->fetch_assoc()) {
                $blacklist[] = $row;
            }
            echo json_encode($blacklist);
        } else {
            echo json_encode([]);
        }
        break;

        case 'DELETE':
            // Delete all entries in the blacklist table
            $sql = "DELETE FROM black_list";
            if ($conn->query($sql) === TRUE) {
                echo json_encode(["message" => "All blacklist entries deleted successfully."]);
            } else {
                echo json_encode(["message" => "Failed to delete all blacklist entries."]);
            }
            break;
        

    default:
        http_response_code(405);
        echo json_encode(["message" => "Method not allowed"]);
        break;
}

// Close connection
$conn->close();
?>
