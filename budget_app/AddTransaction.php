<?php
header("Content-Type: application/json");
include 'connect.php';

//only POST 
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        "status" => "error",
        "message" => "Only POST method is allowed"
    ]);
    exit;
}

// Read JSON data
$data = json_decode(file_get_contents("php://input"), true);

// Check required fields
$required = ['user_id', 'account_id', 'type', 'category', 'amount', 'date'];
foreach ($required as $field) {
    if (!isset($data[$field]) || $data[$field] === '') {
        echo json_encode([
            "status" => "error",
            "message" => "$field is required"
        ]);
        exit;
    }
}

$user_id = $data['user_id'];
$account_id = $data['account_id'];
$type = $data['type'];
$category = $data['category'];
$amount = $data['amount'];
$note = isset($data['note']) ? $data['note'] : '';
$date = $data['date'];

// Validate type
if (!in_array($type, ['income', 'expense'])) {
    echo json_encode([
        "status" => "error",
        "message" => "type must be 'income' or 'expense'"
    ]);
    exit;
}

// Check if user and account exist
$userCheck = mysqli_query($con, "SELECT * FROM harshil_users WHERE user_id = '$user_id'");
$accountCheck = mysqli_query($con, "SELECT * FROM harshil_accounts WHERE account_id = '$account_id'");

if (mysqli_num_rows($userCheck) == 0) {
    echo json_encode(["status" => "error", "message" => "User not found"]);
    exit;
}
if (mysqli_num_rows($accountCheck) == 0) {
    echo json_encode(["status" => "error", "message" => "Account not found"]);
    exit;
}

// Insert transaction
$query = "INSERT INTO harshil_transactions (user_id, account_id, type, category, amount, note, date)
          VALUES ('$user_id', '$account_id', '$type', '$category', '$amount', '$note', '$date')";

if (mysqli_query($con, $query)) {
    echo json_encode([
        "status" => "success",
        "message" => "Transaction added successfully"
    ]);
} else {
    echo json_encode([
        "status" => "error",
        "message" => "Failed to add transaction: " . mysqli_error($con)
    ]);
}
?>
