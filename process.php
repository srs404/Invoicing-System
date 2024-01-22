<?php

require_once "App/Model/Receipt.php";
session_start();

// Retrieve JSON data from the request body
$str_json = file_get_contents('php://input');

$customer_data = json_decode($str_json, true);

$receipt = new Receipt();

// Create a new receipt
$receipt->create(
    $customer_data['name'],
    $customer_data['email'],
    $customer_data['phone'],
    date("Y-m-d", strtotime($customer_data['paymentDate'])),
    date("Y-m-d", strtotime($customer_data['dueDate'])),
    json_encode($customer_data['tableData']),
    $customer_data['subtotal'],
    $customer_data['discount'],
    $customer_data['discountAmount'],
    $customer_data['totalPayable'],
    $customer_data['convenienceFee'],
    $customer_data['advancePayment'],
    $customer_data['duePayment'],
    $_SESSION['agent']['id']
);
