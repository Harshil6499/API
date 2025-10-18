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
$months = isset($_GET['months']) ? intval($_GET['months']) : 6;

// For users
if ($role === 'user' && !isset($_GET['user_id'])) {
    echo json_encode(["status" => "error", "message" => "user_id is required for user role"]);
    exit;
}
$user_id = $_GET['user_id'] ?? null;

// Prepare arrays for results
$labels = [];
$income_data = [];
$expense_data = [];

// Loop through months
for ($i = $months - 1; $i >= 0; $i--) {
    $month_start = date('Y-m-01', strtotime("-$i months"));
    $month_end = date('Y-m-t', strtotime("-$i months"));
    $label = date('M Y', strtotime($month_start));
    $labels[] = $label;

    // Income query
    $incomeWhere = "income_date BETWEEN '$month_start' AND '$month_end'";
    if ($role === 'user') $incomeWhere .= " AND user_id='$user_id'";
    $incomeQuery = "SELECT SUM(amount) as total_income FROM income WHERE $incomeWhere";
    $incomeResult = mysqli_query($con, $incomeQuery);
    $total_income = mysqli_fetch_assoc($incomeResult)['total_income'] ?? 0;
    $income_data[] = (float)$total_income;

    // Expense query
    $expenseWhere = "expense_date BETWEEN '$month_start' AND '$month_end'";
    if ($role === 'user') $expenseWhere .= " AND user_id='$user_id'";
    $expenseQuery = "SELECT SUM(amount) as total_expense FROM expenses WHERE $expenseWhere";
    $expenseResult = mysqli_query($con, $expenseQuery);
    $total_expense = mysqli_fetch_assoc($expenseResult)['total_expense'] ?? 0;
    $expense_data[] = (float)$total_expense;
}

// Return chart-ready response
echo json_encode([
    "status" => "success",
    "data" => [
        "labels" => $labels,
        "income" => $income_data,
        "expenses" => $expense_data
    ]
]);
?>
