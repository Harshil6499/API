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

// Validate required GET parameters
if (!isset($_GET['role']) || !isset($_GET['income_id'])) {
    echo json_encode([
        "status" => "error",
        "message" => "role and income_id are required"
    ]);
    exit;
}

$role = strtolower($_GET['role']);
$income_id = $_GET['income_id'];

// Build query
if ($role === 'admin') {
    // Admin can view any income
    $query = "SELECT i.*, u.name AS user_name, a.account_name
              FROM harshil_income i
              JOIN harshil_users u ON i.user_id = u.user_id
              JOIN harshil_accounts a ON i.account_id = a.account_id
              WHERE i.income_id = '$income_id'";
} else {
    // User must provide user_id to view their own income
    if (!isset($_GET['user_id'])) {
        echo json_encode([
            "status" => "error",
            "message" => "user_id is required for non-admin users"
        ]);
        exit;
    }
    $user_id = $_GET['user_id'];

    $query = "SELECT i.*, a.account_name
              FROM harshil_income i
              JOIN harshil_accounts a ON i.account_id = a.account_id
              WHERE i.income_id = '$income_id' AND i.user_id = '$user_id'";
}

// Execute query
$result = mysqli_query($con, $query);

if (!$result || mysqli_num_rows($result) === 0) {
    echo json_encode([
        "status" => "error",
        "message" => "Income not found or unauthorized"
    ]);
    exit;
}

$income = mysqli_fetch_assoc($result);

// Return response
echo json_encode([
    "status" => "success",
    "data" => $income
]);
?>
