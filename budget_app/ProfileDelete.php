<?php
header("Content-Type: application/json");
include 'connect.php';

// Only POST 
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        "status" => "error",
        "message" => "Use POST method"
    ]);
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);

// Check required field: id
if (empty($data['user_id'])) {
    echo json_encode([
        "status" => "error",
        "message" => "User ID is required"
    ]);
    exit;
}

$id = $data['user_id'];

// Delete user
$sql = "DELETE FROM harshil_users WHERE user_id='$id'";

if ($con->query($sql) === TRUE) {
    if ($con->affected_rows > 0) {
        echo json_encode([
            "status" => "success",
            "message" => "User deleted successfully"
        ]);
    } else {
        echo json_encode([
            "status" => "error",
            "message" => "User not found"
        ]);
    }
} else {
    echo json_encode([
        "status" => "error",
        "message" => "Database error: " . $con->error
    ]);
}

$con->close();
?>
