<?php
header("Content-Type: application/json");
include 'connect.php';


if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        "status" => "error",
        "message" => "Only POST method allowed"
    ]);
    exit;
}

// Read POST data
$data = json_decode(file_get_contents("php://input"), true);

// Check required fields
if(!isset($data['transaction_id'])){
    echo json_encode([
        "status" => "error",
        "message" => "transaction_id is required"
    ]);
    exit;
}

$transaction_id = $data['transaction_id'];
$category = isset($data['category']) ? $data['category'] : null;
$amount = isset($data['amount']) ? $data['amount'] : null;
$note = isset($data['note']) ? $data['note'] : null;
$date = isset($data['date']) ? $data['date'] : null;

// Check if transaction exists
$check = mysqli_query($con, "SELECT * FROM transactions WHERE transaction_id = '$transaction_id'");
if(!$check || mysqli_num_rows($check) == 0){
    echo json_encode([
        "status" => "error",
        "message" => "Transaction not found"
    ]);
    exit;
}

// Build update query dynamically
$fields = [];
if($category !== null) $fields[] = "category = '$category'";
if($amount !== null) $fields[] = "amount = '$amount'";
if($note !== null) $fields[] = "note = '$note'";
if($date !== null) $fields[] = "date = '$date'";

if(empty($fields)){
    echo json_encode([
        "status" => "error",
        "message" => "No fields to update"
    ]);
    exit;
}

$updateQuery = "UPDATE transactions SET " . implode(", ", $fields) . ", updated_at = CURRENT_TIMESTAMP WHERE transaction_id = '$transaction_id'";

if(mysqli_query($con, $updateQuery)){
    echo json_encode([
        "status" => "success",
        "message" => "Transaction updated successfully"
    ]);
} else {
    echo json_encode([
        "status" => "error",
        "message" => "Database update failed: " . mysqli_error($con)
    ]);
}
?>
