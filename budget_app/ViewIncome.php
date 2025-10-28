<?php
include 'connect.php';
header("Content-Type: application/json");

if (!isset($_GET['role'])) {
    echo json_encode(["status" => "error", "message" => "role is required (admin/user)"]);
    exit;
}

$role = strtolower($_GET['role']);

if ($role === 'admin') {
    $query = "SELECT i.*, u.name AS user_name, a.account_name
              FROM harshil_income i
              JOIN harshil_users u ON i.user_id = u.user_id
              JOIN harshil_accounts a ON i.account_id = a.account_id
              ORDER BY i.income_date DESC";
} else {
    if (!isset($_GET['user_id'])) {
        echo json_encode(["status" => "error", "message" => "user_id is required for non-admin users"]);
        exit;
    }
    $user_id = $_GET['user_id'];
    $query = "SELECT i.*, a.account_name
              FROM harshil_income i
              JOIN harshil_accounts a ON i.account_id = a.account_id
              WHERE i.user_id = '$user_id'
              ORDER BY i.income_date DESC";
}

$result = mysqli_query($con, $query);
if (!$result) {
    echo json_encode(["status" => "error", "message" => "Database query failed: " . mysqli_error($con)]);
    exit;
}

$income_list = [];
while ($row = mysqli_fetch_assoc($result)) {
    $income_list[] = $row;
}

echo json_encode([
    "status" => "success",
    "data" => $income_list
]);
?>
