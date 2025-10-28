<?php
header("Content-Type: application/json");
include 'connect.php';

// Only allow POST method
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        "status" => "error",
        "message" => "Invalid request method. Use POST."
    ]);
    exit;
}

// Get JSON input
$data = json_decode(file_get_contents("php://input"), true);

// Check required fields
if (empty($data['user_id'])) {
    echo json_encode([
        "status" => "error",
        "message" => "User ID is required"
    ]);
    exit;
}

$id = $data['user_id'];
$name = isset($data['name']) ? $data['name'] : null;
$surname = isset($data['surname']) ? $data['surname'] : null;
$phone = isset($data['phone']) ? $data['phone'] : null;
$DOB = isset($data['DOB']) ? $data['DOB'] : null;
$profile_image = isset($data['profile_image']) ? $data['profile_image'] : null;

// Build update query dynamically
$fields = [];
if ($name !== null) $fields[] = "name='$name'";
if ($surname !== null) $fields[] = "surname='$surname'";
if ($phone !== null) $fields[] = "phone='$phone'";
if ($DOB !== null) $fields[] = "DOB='$DOB'";
if ($profile_image !== null) $fields[] = "profile_image='$profile_image'";

if (empty($fields)) {
    echo json_encode([
        "status" => "error",
        "message" => "No fields to update"
    ]);
    exit;
}

$update_query = "UPDATE harshil_users SET " . implode(", ", $fields) . " WHERE user_id ='$id'";

if ($con->query($update_query) === TRUE) {
    echo json_encode([
        "status" => "success",
        "message" => "Profile updated successfully"
    ]);
} else {
    echo json_encode([
        "status" => "error",
        "message" => "Database error: " . $con->error
    ]);
}

$con->close();
?>
