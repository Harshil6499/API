<?php
header("Content-Type: application/json");
include 'connect.php';

// Check if role is provided
if (!isset($_GET['role'])) {
    echo json_encode([
        "status" => "error",
        "message" => "role is required (admin or user)"
    ]);
    exit;
}

$role = $_GET['role'];

// Admin → view all transactions
if ($role === 'admin') {
    $query = "SELECT t.*, 
                     u.name AS user_name, 
                     u.email AS user_email, 
                     a.account_name 
              FROM transactions t
              JOIN users u ON t.user_id = u.user_id
              JOIN accounts a ON t.account_id = a.account_id

              ORDER BY t.created_at DESC";
} else {
    // User → must provide user_id
    if (!isset($_GET['user_id'])) {
        echo json_encode([
            "status" => "error",
            "message" => "user_id is required for non-admin users"
        ]);
        exit;
    }

    $user_id = $_GET['user_id'];
    $query = "SELECT t.*, a.account_name 
              FROM transactions t
              JOIN accounts a ON t.account_id = a.account_id
              WHERE t.user_id = '$user_id'
              ORDER BY t.created_at DESC";
}

$result = mysqli_query($con, $query);

if (!$result) {
    echo json_encode([
        "status" => "error",
        "message" => "Database query failed: " . mysqli_error($con)
    ]);
    exit;
}

// Fetch transactions
$transactions = [];
while ($row = mysqli_fetch_assoc($result)) {
    $transactions[] = $row;
}

// Response
echo json_encode([
    "status" => "success",
    "data" => $transactions
]);
?>
