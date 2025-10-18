<?php
// Database connection details
$host = "localhost";      // server name
$username = "root";       
$password = "";          
$database = "budget_app"; // Your database name

// Create connection
$con = new mysqli($host, $username, $password, $database);

// Check connection
if ($con->connect_error) {
    die(json_encode([
        "status" => "error",
        "message" => "Connection failed: " . $con->connect_error
    ]));
} else {
    
}
?>
