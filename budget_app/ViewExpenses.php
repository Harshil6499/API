<?php
include 'connect.php';
header("Content-Type: application/json");

// Ensure request is GET
if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    echo json_encode(["status" => "error", "message" => "Only GET method allowed"]);
    exit;
}

// Check role
if (!isset($_GET['role'])) {
    echo json_encode(["status" => "error", "message" => "Role is required (admin/user)"]);
    exit;
}

$role = strtolower($_GET['role']);

if ($role === 'admin') {
    // Admin can see all expenses with user & account info
    $query = "SELECT e.*, u.name AS user_name, a.account_name 
              FROM expenses e
              JOIN users u ON e.user_id = u.user_id
              JOIN accounts a ON e.account_id = a.account_id
              ORDER BY e.expense_date DESC";
} else {
    // User can only see their own expenses
    if (!isset($_GET['user_id'])) {
        echo json_encode(["status" => "error", "message" => "user_id is required for non-admin users"]);
        exit;
    }
    $user_id = $_GET['user_id'];

    $query = "SELECT e.*, a.account_name 
              FROM expenses e
              JOIN accounts a ON e.account_id = a.account_id
              WHERE e.user_id = '$user_id'
              ORDER BY e.expense_date DESC";
}

$result = mysqli_query($con, $query);

if (!$result) {
    echo json_encode(["status" => "error", "message" => "Database query failed: " . mysqli_error($con)]);
    exit;
}

$expenses = [];
while ($row = mysqli_fetch_assoc($result)) {
    $expenses[] = $row;
}

if (empty($expenses)) {
    echo json_encode(["status" => "success", "message" => "No expenses found"]);
} else {
    echo json_encode(["status" => "success", "data" => $expenses]);
}
?>
