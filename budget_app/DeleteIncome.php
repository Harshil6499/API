<?php
include 'connect.php';
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["status" => "error", "message" => "Only POST method allowed"]);
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);
if (!isset($data['income_id']) || !isset($data['user_id'])) {
    echo json_encode(["status" => "error", "message" => "Missing required fields"]);
    exit;
}

$income_id = $data['income_id'];
$user_id = $data['user_id'];

$check = mysqli_query($con, "SELECT * FROM income WHERE income_id='$income_id' AND user_id='$user_id'");
if (!$check || mysqli_num_rows($check) === 0) {
    echo json_encode(["status" => "error", "message" => "Income not found or unauthorized"]);
    exit;
}

if (mysqli_query($con, "DELETE FROM income WHERE income_id='$income_id'")) {
    echo json_encode(["status" => "success", "message" => "Income deleted successfully"]);
} else {
    echo json_encode(["status" => "error", "message" => "Database error: " . mysqli_error($con)]);
}
?>
