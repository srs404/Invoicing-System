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

if ($data['receipt_action'] == 'create') {
    /**
     * TITLE: Create Receipt
     * ~ Description: Create a new receipt
     * ~ Retrieve JSON data from the request body
     */
    $receipt = new Receipt();

    // Create a new receipt
    $receipt->create(
        $data['name'],
        $data['email'],
        $data['phone'],
        date("Y-m-d", strtotime($data['paymentDate'])),
        date("Y-m-d", strtotime($data['dueDate'])),
        json_encode($data['tableData']),
        $data['subtotal'],
        $data['discount'],
        $data['discountAmount'],
        $data['totalPayable'],
        $data['convenienceFee'],
        $data['advancePayment'],
        $data['duePayment'],
        $_SESSION['agent']['id']
    );

    // Send the response
    header('Content-Type: application/json');
    echo json_encode(['status' => 'success']);
} else if ($data['receipt_action'] == 'delete') {
    /**
     * TITLE: Delete Receipt
     * ~ Description: Delete a receipt
     * ~ Retrieve JSON data from the request body
     */

    $receipt = new Receipt();
    $receipt->delete($data['receiptID']);

    // Send the response
    header('Content-Type: application/json');
    echo json_encode(['status' => 'success']);
} else if ($data['receipt_action'] == 'edit') {
    // TODO: Edit receipt
} else {
    // Send the response
    header('Content-Type: application/json');
    echo json_encode(['status' => 'error']);
}
