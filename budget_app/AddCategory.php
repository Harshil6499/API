<?php

header("Content-Type: application/json");
include 'connect.php';


// Allow only POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        "status" => "error",
        "message" => "Only POST method allowed"
    ]);
    exit;
}

// Read JSON input
$data = json_decode(file_get_contents("php://input"), true);

// Validate required fields
if (!isset($data['user_id']) || !isset($data['name']) || !isset($data['type'])) {
    echo json_encode([
        "status" => "error",
        "message" => "user_id, name, and type are required"
    ]);
    exit;
}

$user_id = $data['user_id'];
$name = mysqli_real_escape_string($con, $data['name']);
$type = strtolower($data['type']); // income or expense

// Validate category type
if (!in_array($type, ['income', 'expense'])) {
    echo json_encode([
        "status" => "error",
        "message" => "type must be 'income' or 'expense'"
    ]);
    exit;
}

// Check if category already exists for the same user and type
$checkQuery = "SELECT * FROM categories WHERE user_id='$user_id' AND name='$name' AND type='$type'";
$check = mysqli_query($con, $checkQuery);

if (mysqli_num_rows($check) > 0) {
    echo json_encode([
        "status" => "error",
        "message" => "Category already exists"
    ]);
    exit;
}

// Insert category
$query = "INSERT INTO categories (user_id, name, type) VALUES ('$user_id', '$name', '$type')";
if (mysqli_query($con, $query)) {
    echo json_encode([
        "status" => "success",
        "message" => "Category added successfully"
    ]);
} else {
    echo json_encode([
        "status" => "error",
        "message" => "Database insert failed: " . mysqli_error($con)
    ]);
}
?>
