
<?php
header("Content-Type: application/json");
include 'connect.php';

// Check if role is given
if (!isset($_GET['role'])) {
    echo json_encode([
        "status" => "error",
        "message" => "role is required (admin/user)"
    ]);
    exit;
}

$role = $_GET['role'];

// If user → must send user_id
if ($role === 'user') {
    if (!isset($_GET['user_id'])) {
        echo json_encode([
            "status" => "error",
            "message" => "user_id is required for user role"
        ]);
        exit;
    }
    $user_id = $_GET['user_id'];

    // Total income
    $incomeQuery = "SELECT SUM(amount) AS total_income FROM harshil_transactions WHERE user_id='$user_id' AND type='income'";
    // Total expense
    $expenseQuery = "SELECT SUM(amount) AS total_expense FROM harshil_transactions WHERE user_id='$user_id' AND type='expense'";
} 
else if ($role === 'admin') {
    // For admin → calculate totals across all users
    $incomeQuery = "SELECT SUM(amount) AS total_income FROM harshil_transactions WHERE type='income'";
    $expenseQuery = "SELECT SUM(amount) AS total_expense FROM harshil_transactions WHERE type='expense'";
} 
else {
    echo json_encode([
        "status" => "error",
        "message" => "Invalid role"
    ]);
    exit;
}

// Run queries
$incomeResult = mysqli_query($con, $incomeQuery);
$expenseResult = mysqli_query($con, $expenseQuery);

$incomeData = mysqli_fetch_assoc($incomeResult);
$expenseData = mysqli_fetch_assoc($expenseResult);

$total_income = $incomeData['total_income'] ?? 0;
$total_expense = $expenseData['total_expense'] ?? 0;
$balance = $total_income - $total_expense;

// Response
echo json_encode([
    "status" => "success",
    "summary" => [
        "total_income" => number_format($total_income, 2),
        "total_expense" => number_format($total_expense, 2),
        "balance" => number_format($balance, 2)
    ]
]);
?>
