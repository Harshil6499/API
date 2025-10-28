<?php
header("Content-Type: application/json");
include 'connect.php';


// Read JSON data from POST
$data = json_decode(file_get_contents("php://input"), true);

// Check if category_id is provided
if (!isset($data['category_id'])) {
    echo json_encode([
        "status" => "error",
        "message" => "category_id is required"
    ]);
    exit;
}

$category_id = $data['category_id'];

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

// Delete category
$deleteQuery = "DELETE FROM harshil_categories WHERE category_id = '$category_id'";
if (mysqli_query($con, $deleteQuery)) {
    echo json_encode([
        "status" => "success",
        "message" => "Category deleted successfully"
    ]);
} else {
    echo json_encode([
        "status" => "error",
        "message" => "Failed to delete category: " . mysqli_error($con)
    ]);
}
?>
