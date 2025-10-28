<?php
header("Content-Type: application/json");
include 'connect.php';

$role = isset($_GET['role']) ? strtolower($_GET['role']) : 'user';

if($role === 'admin'){
    $query = "SELECT a.*, u.name AS user_name, u.email AS user_email 
              FROM harshil_accounts a 
              JOIN harshil_users u ON a.user_id = u.user_id";
} else {
    if(!isset($_GET['user_id'])){
        echo json_encode([
            "status"=>"error",
            "message"=>"user_id is required for non-admin users"
        ]);
        exit;
    }
    $user_id = $_GET['user_id'];
    $query = "SELECT * FROM harshil_accounts WHERE user_id = '$user_id'";
}

$result = mysqli_query($con, $query);

if(!$result){
    echo json_encode([
        "status"=>"error",
        "message"=>"Database query failed: " . mysqli_error($con)
    ]);
    exit;
}

$accounts = [];
while($row = mysqli_fetch_assoc($result)){
    $accounts[] = $row;
}

echo json_encode([
    "status"=>"success",
    "data"=>$accounts
]);
?>
