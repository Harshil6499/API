 <?php
header("Content-Type: application/json");
include 'connect.php';

// Allow only POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        "status" => "error",
        "message" => "Only POST method is allowed"
    ]);
    exit;
}

// Read JSON input
$data = json_decode(file_get_contents("php://input"), true);

// Check required field
if(!isset($data['account_id'])){
    echo json_encode([
        "status" => "error",
        "message" => "account_id is required"
    ]);
    exit;
}

$account_id = $data['account_id'];
$account_name = isset($data['account_name']) ? $data['account_name'] : null;
$account_type = isset($data['account_type']) ? $data['account_type'] : null;
$balance = isset($data['balance']) ? $data['balance'] : null;

// Check if account exists
$check = mysqli_query($con, "SELECT * FROM harshil_accounts WHERE account_id = '$account_id'");
if(!$check || mysqli_num_rows($check) == 0){
    echo json_encode([
        "status" => "error",
        "message" => "Account not found"
    ]);
    exit;
}

// Prepare dynamic update fields
$updates = [];

if($account_name !== null){
    $updates[] = "account_name = '" . mysqli_real_escape_string($con, $account_name) . "'";
}
if($account_type !== null){
    $valid_types = ['bank','wallet','cash'];
    if(!in_array($account_type, $valid_types)){
        echo json_encode([
            "status" => "error",
            "message" => "account_type must be one of: bank, wallet, cash"
        ]);
        exit;
    }
    $updates[] = "account_type = '$account_type'";
}
if($balance !== null){
    $updates[] = "balance = '$balance'";
}

if(empty($updates)){
    echo json_encode([
        "status" => "error",
        "message" => "No fields to update"
    ]);
    exit;
}

// Run update query
$update_query = "UPDATE harshil_accounts SET " . implode(", ", $updates) . " WHERE account_id = '$account_id'";
$result = mysqli_query($con, $update_query);

if($result){
    echo json_encode([
        "status" => "success",
        "message" => "Account updated successfully"
    ]);
}else{
    echo json_encode([
        "status" => "error",
        "message" => "Failed to update account: " . mysqli_error($con)
    ]);
}
?>
