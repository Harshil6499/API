<?php
header("Content-Type: application/json");
include 'connect.php';

// Allow only POST method
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        "status" => "error",
        "message" => "Only POST method allowed"
    ]);
    exit;
}

// Get input data
$data = json_decode(file_get_contents("php://input"), true);

// Check required fields
if (
    !isset($data['expense_id']) ||
    !isset($data['user_id']) ||
    !isset($data['category']) ||
    !isset($data['amount']) ||
    !isset($data['expense_date'])
) {
    echo json_encode([
        "status" => "error",
        "message" => "Missing required fields"
    ]);
    exit;
}

$expense_id   = $data['expense_id'];
$user_id      = $data['user_id'];
$category     = $data['category'];
$amount       = $data['amount'];
$note         = isset($data['note']) ? $data['note'] : '';
$expense_date = $data['expense_date'];

// Check if expense exists and belongs to this user
$checkQuery = "SELECT * FROM harshil_expenses WHERE expense_id = '$expense_id' AND user_id = '$user_id'";
$checkResult = mysqli_query($con, $checkQuery);

if (!$checkResult || mysqli_num_rows($checkResult) === 0) {
    echo json_encode([
        "status" => "error",
        "message" => "Expense not found or unauthorized"
    ]);
    exit;
}

// Update expense
$updateQuery = "UPDATE harshil_expenses 
                SET category = '$category',
                    amount = '$amount',
                    note = '$note',
                    expense_date = '$expense_date',
                    updated_at = NOW()
                WHERE expense_id = '$expense_id'";

if (mysqli_query($con, $updateQuery)) {
    echo json_encode([
        "status" => "success",
        "message" => "Expense updated successfully"
    ]);
} else {
    echo json_encode([
        "status" => "error",
        "message" => "Database error: " . mysqli_error($con)
    ]);
}
?>
