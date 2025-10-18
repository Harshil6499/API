<?php
include 'connect.php';
header("Content-Type: application/json");

// Only GET allowed
if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    echo json_encode(["status" => "error", "message" => "Only GET method allowed"]);
    exit;
}

// Validate role
if (!isset($_GET['role'])) {
    echo json_encode(["status" => "error", "message" => "role is required"]);
    exit;
}

$role = strtolower($_GET['role']);
$type = isset($_GET['type']) ? strtolower($_GET['type']) : 'all';

// For users
if ($role === 'user' && !isset($_GET['user_id'])) {
    echo json_encode(["status" => "error", "message" => "user_id is required for user role"]);
    exit;
}

$user_id = $_GET['user_id'] ?? null;

// Build date filter
$today = date('Y-m-d');
switch ($type) {
    case 'monthly':
        $start_date = date('Y-m-01'); // first day of current month
        break;
    case '6months':
        $start_date = date('Y-m-d', strtotime('-6 months'));
        break;
    case 'yearly':
        $start_date = date('Y-01-01'); // first day of current year
        break;
    default:
        $start_date = null; // all-time
}

// Build query filters
$incomeWhere = $expenseWhere = "";

if ($role === 'user') {
    $incomeWhere .= " WHERE user_id='$user_id'";
    $expenseWhere .= " WHERE user_id='$user_id'";
}

if ($start_date) {
    $incomeWhere .= ($incomeWhere ? " AND " : " WHERE ") . "income_date >= '$start_date'";
    $expenseWhere .= ($expenseWhere ? " AND " : " WHERE ") . "expense_date >= '$start_date'";
}

// Queries
$incomeQuery = "SELECT SUM(amount) as total_income FROM income $incomeWhere";
$expenseQuery = "SELECT SUM(amount) as total_expense FROM expenses $expenseWhere";

// Execute queries
$incomeResult = mysqli_query($con, $incomeQuery);
$expenseResult = mysqli_query($con, $expenseQuery);

if (!$incomeResult || !$expenseResult) {
    echo json_encode(["status" => "error", "message" => "Database query failed"]);
    exit;
}

$total_income = mysqli_fetch_assoc($incomeResult)['total_income'] ?? 0;
$total_expense = mysqli_fetch_assoc($expenseResult)['total_expense'] ?? 0;
$balance = $total_income - $total_expense;

// Response
echo json_encode([
    "status" => "success",
    "data" => [
        "type" => $type,
        "total_income" => (float)$total_income,
        "total_expense" => (float)$total_expense,
        "balance" => (float)$balance
    ]
]);
?>
