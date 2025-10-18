<?php
header("Content-Type: application/json");
include 'connect.php';

// Allow only POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        "status" => "error",
        "message" => "Only POST method allowed"
    ]);
    exit;
}

// Read JSON input
$data = json_decode(file_get_contents("php://input"), true);

// Check required field
if (!isset($data['transaction_id'])) {
    echo json_encode([
        "status" => "error",
        "message" => "transaction_id is required"
    ]);
    exit;
}

$transaction_id = $data['transaction_id'];

// Check if transaction exists
$check = mysqli_query($con, "SELECT * FROM transactions WHERE transaction_id = '$transaction_id'");
if (!$check || mysqli_num_rows($check) == 0) {
    echo json_encode([
        "status" => "error",
        "message" => "Transaction not found"
    ]);
    exit;
}

// Delete transaction
$deleteQuery = "DELETE FROM transactions WHERE transaction_id = '$transaction_id'";
if (mysqli_query($con, $deleteQuery)) {
    echo json_encode([
        "status" => "success",
        "message" => "Transaction deleted successfully"
    ]);
} else {
    echo json_encode([
        "status" => "error",
        "message" => "Database delete failed: " . mysqli_error(mysql: $con)
    ]);
}
?>
