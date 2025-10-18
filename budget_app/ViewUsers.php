<?php
header("Content-Type: application/json");
include 'connect.php'; 

// SQL query 
$sql = "SELECT * FROM users";
$result = $con->query($sql);

if ($result->num_rows > 0) {
    $users = array();
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }

    echo json_encode([
        "status" => "success",
        "message" => "User data fetched successfully",
        "data" => $users
    ]);
} else {
    echo json_encode([
        "status" => "error",
        "message" => "No users found"
    ]);
}

$con->close();
?>