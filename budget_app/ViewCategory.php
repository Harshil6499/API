<?php
header("Content-Type: application/json");
include 'connect.php';

// Check if role is provided
if (!isset($_GET['role'])) {
    echo json_encode([
        "status" => "error",
        "message" => "role is required (admin/user)"
    ]);
    exit;
}

$role = strtolower($_GET['role']);

if ($role === 'admin') {
    // Admin: can view all categories
    $query = "SELECT c.*, u.name AS user_name 
              FROM categories c 
              JOIN users u ON c.user_id = u.user_id 
              ORDER BY c.created_at DESC";
} elseif ($role === 'user') {
    // User: must provide user_id
    if (!isset($_GET['user_id'])) {
        echo json_encode([
            "status" => "error",
            "message" => "user_id is required for user role"
        ]);
        exit;
    }
    $user_id = $_GET['user_id'];
    $query = "SELECT * FROM categories WHERE user_id = '$user_id' ORDER BY created_at DESC";
} else {
    echo json_encode([
        "status" => "error",
        "message" => "Invalid role"
    ]);
    exit;
}

$result = mysqli_query($con, $query);

if (!$result) {
    echo json_encode([
        "status" => "error",
        "message" => "Database query failed: " . mysqli_error($con)
    ]);
    exit;
}

$categories = [];
while ($row = mysqli_fetch_assoc($result)) {
    $categories[] = $row;
}

echo json_encode([
    "status" => "success",
    "data" => $categories
]);
?>
