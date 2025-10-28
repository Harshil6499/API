<?php
header("Content-Type: application/json");
include 'connect.php';

// Only POST
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
if (empty($data['email']) || empty($data['password'])) {
    echo json_encode([
        "status" => "error",
        "message" => "Email and password are required"
    ]);
    exit;
}

$email = $data['email'];
$password = $data['password'];

// Fetch user
$sql = "SELECT * FROM harshil_users WHERE email='$email'";
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

    // Compare plain passwords
    if ($password === $user['password']) {
        echo json_encode([
            "status" => "success",
            "message" => "Login successful",
            "data" => [
                "user_id" => $user['user_id'],
                "name" => $user['name'],
                "surname" => $user['surname'],
                "email" => $user['email'],
                "phone" => $user['phone'],
                "profile_image" => $user['profile_image'],
                "role" => $user['role'],
                "DOB" => $user['DOB']
            ]
        ]);
    } else {
        echo json_encode([
            "status" => "error",
            "message" => "Incorrect password"
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
