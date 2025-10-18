<?php
header("Content-Type: application/json");
include 'connect.php';

// POST 
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        "status" => "error",
        "message" => "Only POST method is allowed"
    ]);
    exit;
}


$data = json_decode(file_get_contents("php://input"), true);

// Check if account_id is provided
if (!isset($data['account_id'])) {
    echo json_encode([
        "status" => "error",
        "message" => "account_id is required"
    ]);
    exit;
}

$account_id = $data['account_id'];

// Check if account exists
$check = mysqli_query($conn, "SELECT * FROM accounts WHERE account_id = '$account_id'");
if (!$check || mysqli_num_rows($check) == 0) {
    echo json_encode([
        "status" => "error",
        "message" => "Account not found"
    ]);
    exit;
}

// Delete account
$delete = mysqli_query($con, "DELETE FROM accounts WHERE account_id = '$account_id'");

if ($delete) {
    echo json_encode([
        "status" => "success",
        "message" => "Account deleted successfully"
    ]);
} else {
    echo json_encode([
        "status" => "error",
        "message" => "Failed to delete account: " . mysqli_error($con)
    ]);
}
?>
