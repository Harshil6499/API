<?php
include 'connect.php';
header("Content-Type: application/json");

// Allow only GET requests
if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    echo json_encode([
        "status" => "error",
        "message" => "Only GET method allowed"
    ]);
    exit;
}

// Check if role and expense_id are provided
if (!isset($_GET['role'])) {
    echo json_encode([
        "status" => "error",
        "message" => "Role is required (admin/user)"
    ]);
    exit;
}

if (!isset($_GET['expense_id'])) {
    echo json_encode([
        "status" => "error",
        "message" => "expense_id is required"
    ]);
    exit;
}

$role = strtolower($_GET['role']);
$expense_id = $_GET['expense_id'];

// Build query
if ($role === 'admin') {
    // Admin can view any expense
    $query = "SELECT e.*, u.name AS user_name, a.account_name
              FROM expenses e
              JOIN users u ON e.user_id = u.user_id
              JOIN accounts a ON e.account_id = a.account_id
              WHERE e.expense_id = '$expense_id'";
} else {
    // User must provide user_id to ensure they can only view their own
    if (!isset($_GET['user_id'])) {
        echo json_encode([
            "status" => "error",
            "message" => "user_id is required for non-admin users"
        ]);
        exit;
    }

    $user_id = $_GET['user_id'];
    $query = "SELECT e.*, a.account_name
              FROM expenses e
              JOIN accounts a ON e.account_id = a.account_id
              WHERE e.expense_id = '$expense_id' AND e.user_id = '$user_id'";
}

$result = mysqli_query($con, $query);

if (!$result) {
    echo json_encode([
        "status" => "error",
        "message" => "Database query failed: " . mysqli_error($con)
    ]);
    exit;
}

if (mysqli_num_rows($result) === 0) {
    echo json_encode([
        "status" => "error",
        "message" => "Expense not found or unauthorized access"
    ]);
    exit;
}

$expense = mysqli_fetch_assoc($result);

echo json_encode([
    "status" => "success",
    "data" => $expense
]);
?>
