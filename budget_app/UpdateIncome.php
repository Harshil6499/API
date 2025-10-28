<?php
include 'connect.php';
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["status" => "error", "message" => "Only POST method allowed"]);
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['income_id']) || !isset($data['user_id']) || !isset($data['category']) || !isset($data['amount']) || !isset($data['income_date'])) {
    echo json_encode(["status" => "error", "message" => "Missing required fields"]);
    exit;
}

$income_id = $data['income_id'];
$user_id = $data['user_id'];
$category = $data['category'];
$amount = $data['amount'];
$note = isset($data['note']) ? $data['note'] : '';
$income_date = $data['income_date'];

$check = mysqli_query($con, "SELECT * FROM harshil_income WHERE income_id='$income_id' AND user_id='$user_id'");
if (!$check || mysqli_num_rows($check) === 0) {
    echo json_encode(["status" => "error", "message" => "Income not found or unauthorized"]);
    exit;
}

$updateQuery = "UPDATE harshil_income SET category='$category', amount='$amount', note='$note', income_date='$income_date', updated_at=NOW() WHERE income_id='$income_id'";
if (mysqli_query($con, $updateQuery)) {
    echo json_encode(["status" => "success", "message" => "Income updated successfully"]);
} else {
    echo json_encode(["status" => "error", "message" => "Database error: " . mysqli_error($con)]);
}
?>
