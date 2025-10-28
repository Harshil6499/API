<?php
include 'connect.php';
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["status" => "error", "message" => "Only POST method allowed"]);
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['user_id']) || !isset($data['account_id']) || !isset($data['category']) || !isset($data['amount']) || !isset($data['income_date'])) {
    echo json_encode(["status" => "error", "message" => "Missing required fields"]);
    exit;
}

$user_id    = $data['user_id'];
$account_id = $data['account_id'];
$category   = $data['category'];
$amount     = $data['amount'];
$note       = isset($data['note']) ? $data['note'] : '';
$income_date = $data['income_date'];

// Optional: Check if account exists
$checkAccount = mysqli_query($con, "SELECT account_id FROM harshil_accounts WHERE account_id = '$account_id'");
if (mysqli_num_rows($checkAccount) === 0) {
    echo json_encode(["status" => "error", "message" => "Invalid account_id"]);
    exit;
}

// Insert income
$query = "INSERT INTO harshil_income (user_id, account_id, category, amount, note, income_date)
          VALUES ('$user_id', '$account_id', '$category', '$amount', '$note', '$income_date')";

if (mysqli_query($con, $query)) {
    echo json_encode(["status" => "success", "message" => "Income added successfully"]);
} else {
    echo json_encode(["status" => "error", "message" => "Database error: " . mysqli_error($con)]);
}
?>
