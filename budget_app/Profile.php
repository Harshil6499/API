<?php
header("Content-Type: application/json");
include 'connect.php';

// Check if 'id' parameter exists
if (!isset($_GET['user_id'])) {
    echo json_encode([
        "status" => "error",
        "message" => "User ID parameter is required"
    ]);
    exit;
}

$id = $_GET['user_id'];

// Fetch user by ID
$sql = "SELECT user_id, email, phone, profile_image, name, surname, DOB, role FROM users WHERE user_id='$id'";
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
    echo json_encode([
        "status" => "success",
        "message" => "Profile fetched successfully",
        "data" => $user
    ]);
} else {
    echo json_encode([
        "status" => "error",
        "message" => "User not found"
    ]);
}

$con->close();
?>
