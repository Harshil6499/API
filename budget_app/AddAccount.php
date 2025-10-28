<?php
header("Content-Type: application/json");
include 'connect.php';

// Get POST data
$data = json_decode(file_get_contents("php://input"), true);

// Check required fields
if(!isset($data['user_id']) || !isset($data['account_name']) || !isset($data['account_type'])){
    echo json_encode([
        "status" => "error",
        "message" => "user_id, account_name, and account_type are required"
    ]);
    exit;
}

$user_id = $data['user_id'];
$account_name = $data['account_name'];
$account_type = $data['account_type'];
$balance = isset($data['balance']) ? $data['balance'] : 0.00;

// Validate account_type
$valid_types = ['bank','wallet','cash'];
if(!in_array($account_type, $valid_types)){
    echo json_encode([
        "status" => "error",
        "message" => "account_type must be one of: bank, wallet, cash"
    ]);
    exit;
}

// Check if user exists
$user_check = mysqli_query($con, "SELECT * FROM harshil_users WHERE user_id = '$user_id'");
if(mysqli_num_rows($user_check) == 0){
    echo json_encode([
        "status" => "error",
        "message" => "User not found"
    ]);
    exit;
}

// Insert account
$query = "INSERT INTO harshil_accounts (user_id, account_name, account_type, balance) 
          VALUES ('$user_id', '$account_name', '$account_type', '$balance')";

$result = mysqli_query($con, $query);

if($result){
    echo json_encode([
        "status" => "success",
        "message" => "Account added successfully"
    ]);
}else{
    echo json_encode([
        "status" => "error",
        "message" => "Database insert failed: " . mysqli_error($con)
    ]);
}
?>
