<?php
// Path: delete_data.php
require_once "App/Model/Receipt.php";
session_start();
if (!isset($_SESSION['agent']['loggedIn'])) {
    header("Location: index.php");
}

// Read JSON data from the request body
$str_json = file_get_contents('php://input');
$data = json_decode($str_json, true);

if (isset($data['receiptID'])) {
    // Perform the row deletion operation in your database here
    $receipt = new Receipt();
    $receipt->delete($data['receiptID']);

    // Respond with success
    echo json_encode(['status' => 'success']);
} else {
    // Respond with an error
    echo json_encode(['status' => 'error']);
}
