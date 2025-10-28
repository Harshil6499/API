<?php
header("Content-Type: application/json");
include 'connect.php';

// Accept only POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        "status" => "error",
        "message" => "Only POST method is allowed"
    ]);
    exit;
}

// Read JSON body
$data = json_decode(file_get_contents("php://input"), true);

// Check required fields
if (!isset($data['category_id'])) {
    echo json_encode([
        "status" => "error",
        "message" => "category_id is required"
    ]);
    exit;
}

$category_id = $data['category_id'];
$name = isset($data['name']) ? $data['name'] : null;
$type = isset($data['type']) ? $data['type'] : null; 

// Check if category exists
$checkQuery = "SELECT * FROM harshil_categories WHERE category_id = '$category_id'";
$checkResult = mysqli_query($con, $checkQuery);

if (!$checkResult || mysqli_num_rows($checkResult) == 0) {
    echo json_encode([
        "status" => "error",
        "message" => "Category not found"
    ]);
    exit;
}

// Build dynamic update query
$updateFields = [];
if ($name !== null) $updateFields[] = "name = '$name'";
if ($type !== null) $updateFields[] = "type = '$type'";
$updateFields[] = "updated_at = NOW()";

$updateQuery = "UPDATE harshil_categories SET " . implode(", ", $updateFields) . " WHERE category_id = '$category_id'";

if (mysqli_query($con, $updateQuery)) {
    echo json_encode([
        "status" => "success",
        "message" => "Category updated successfully"
    ]);
} else {
    echo json_encode([
        "status" => "error",
        "message" => "Database error: " . mysqli_error($con)
    ]);
}
?>
