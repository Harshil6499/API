<?php
header("Content-Type: application/json");
include 'connect.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["status" => "error", "message" => "Only POST method allowed"]);
    exit;
}

// Try to read raw JSON input
$rawData = file_get_contents("php://input");
$data = json_decode($rawData, true);

// If JSON decode failed, try $_POST (for form-data fallback)
if (!$data) {
    $data = $_POST;
}

if (empty($data['user_id']) || empty($data['account_id']) || empty($data['category']) || empty($data['amount']) || empty($data['expense_date'])) {
    echo json_encode(["status" => "error", "message" => "Missing required fields"]);
    exit;
}

$user_id = $data['user_id'];
$account_id = $data['account_id'];
$category = $data['category'];
$amount = $data['amount'];
$note = isset($data['note']) ? $data['note'] : '';
$expense_date = $data['expense_date'];

$query = "INSERT INTO harshil_expenses (user_id, account_id, category, amount, note, expense_date)
          VALUES ('$user_id', '$account_id', '$category', '$amount', '$note', '$expense_date')";

if (mysqli_query($con, $query)) {
    echo json_encode(["status" => "success", "message" => "Expense added successfully"]);
} else {
    echo json_encode(["status" => "error", "message" => "Database error: " . mysqli_error($con)]);
}
?>
