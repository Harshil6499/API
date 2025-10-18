<?php
header("Content-Type: application/json");
include 'connect.php';

// Allow only POST requests
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
if (
    empty($data['name']) ||
    empty($data['surname']) ||
    empty($data['email']) ||
    empty($data['phone']) ||
    empty($data['password']) ||
    empty($data['confirm_password']) ||
    empty($data['DOB'])
) {
    echo json_encode([
        "status" => "error",
        "message" => "Missing required fields"
    ]);
    exit;
}

$name = $data['name'];
$surname = $data['surname'];
$email = $data['email'];
$phone = $data['phone'];
$password = $data['password'];
$confirm_password = $data['confirm_password'];
$DOB = $data['DOB'];
$profile_image = isset($data['profile_image']) ? $data['profile_image'] : '';
$role = isset($data['role']) ? $data['role'] : 'user';

// Check password match
if ($password !== $confirm_password) {
    echo json_encode([
        "status" => "error",
        "message" => "Passwords do not match"
    ]);
    exit;
}

// Insert user without hashing
$sql = "INSERT INTO users (name, surname, email, phone, password, confirm_password, DOB, profile_image, role)
        VALUES ('$name', '$surname', '$email', '$phone', '$password', '$confirm_password', '$DOB', '$profile_image', '$role')";

if ($con->query($sql) === TRUE) {
    echo json_encode([
        "status" => "success",
        "message" => "User registered successfully"
    ]);
} else {
    echo json_encode([
        "status" => "error",
        "message" => "Database error: " . $con->error
    ]);
}

$con->close();
?>
