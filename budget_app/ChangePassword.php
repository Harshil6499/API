<?php
header("Content-Type: application/json");
include 'connect.php';

// Only allow POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        "status" => "error",
        "message" => "Use POST method"
    ]);
    exit;
}

// Get JSON input
$data = json_decode(file_get_contents("php://input"), true);

// Check required fields
if (empty($data['user_id']) || empty($data['old_password']) || empty($data['new_password'])) {
    echo json_encode([
        "status" => "error",
        "message" => "User ID, old password, and new password are required"
    ]);
    exit;
} 

$id = $data['user_id'];
$old_password = $data['old_password'];
$new_password = $data['new_password'];

// Fetch current password from database
$sql = "SELECT password FROM users WHERE user_id='$id'";
$result = $con->query($sql);

if ($result === false) {
    echo json_encode([
        "status" => "error",
        "message" => "Database error: " . $con->error
    ]);
    exit;
}

if ($result->num_rows == 1) {
    $user = $result->fetch_assoc();

    // Check old password
    if ($old_password === $user['password']) {
        
        // Update with new password
        $update_sql = "UPDATE users SET password='$new_password' WHERE user_id='$id'";
        if ($con->query($update_sql) === TRUE) {
            echo json_encode([
                "status" => "success",
                "message" => "Password changed successfully"
            ]);
        } else {
            echo json_encode([
                "status" => "error",
                "message" => "Database error: " . $con->error
            ]);
        }
    } else {
        echo json_encode([
            "status" => "error",
            "message" => "Old password is incorrect"
        ]);
    }
} else {
    echo json_encode([
        "status" => "error",
        "message" => "User not found"
    ]);
}

$con->close();
?>
