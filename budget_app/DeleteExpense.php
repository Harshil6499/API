<?php
include 'connect.php';
header("Content-Type: application/json");

// Allow only POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        "status" => "error",
        "message" => "Only POST method allowed"
    ]);
    exit;
}

// Get JSON input
$data = json_decode(file_get_contents("php://input"), true);

// Validate fields
if (!isset($data['expense_id']) || !isset($data['user_id'])) {
    echo json_encode([
        "status" => "error",
        "message" => "Missing required fields"
    ]);
    exit;
}

$expense_id = $data['expense_id'];
$user_id = $data['user_id'];

// Check if expense belongs to this user
$checkQuery = "SELECT * FROM harshil_expenses WHERE expense_id = '$expense_id' AND user_id = '$user_id'";
$checkResult = mysqli_query($con, $checkQuery);

if (!$checkResult || mysqli_num_rows($checkResult) === 0) {
    echo json_encode([
        "status" => "error",
        "message" => "Expense not found or unauthorized"
    ]);
    exit;
}

// Delete expense
$deleteQuery = "DELETE FROM harshil_expenses WHERE expense_id = '$expense_id'";

if (mysqli_query($con, $deleteQuery)) {
    echo json_encode([
        "status" => "success",
        "message" => "Expense deleted successfully"
    ]);
} else {
    echo json_encode([
        "status" => "error",
        "message" => "Database error: " . mysqli_error($con)
    ]);
}
?>
