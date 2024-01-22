<?php
// session_start();
require_once "App/Model/Receipt.php";
// if (!isset($_SESSION['agent']['loggedIn'])) {
//     header("Location: index.php");
// }

$receipt = new Receipt();

// Create a new database connection
$all_receipts = $receipt->getAll();
// $myfile = fopen("testfile.txt", "w");
// $myfile2 = fopen("testfile2.txt", "w");

// foreach ($all_receipts as $row) {
//     fwrite($myfile, $row['receipt_id']);
//     fwrite($myfile, "\n");
//     fwrite($myfile, $row['customer_name']);
//     fwrite($myfile, "\n");
//     fwrite($myfile, $row['customer_email']);
//     fwrite($myfile, "\n");
//     fwrite($myfile, $row['customer_phone']);
//     fwrite($myfile, "\n");
//     fwrite($myfile, $row['payment_date']);
//     fwrite($myfile, "\n");
//     fwrite($myfile, $row['due_date']);
//     fwrite($myfile, "\n");
//     fwrite($myfile, $row['item_list']);
//     fwrite($myfile, "\n");
//     fwrite($myfile, $row['subtotal']);
//     fwrite($myfile, "\n");
//     fwrite($myfile, $row['discount_percentage']);
//     fwrite($myfile, "\n");
//     fwrite($myfile, $row['discount_amount']);
//     fwrite($myfile, "\n");
//     fwrite($myfile, $row['payable']);
//     fwrite($myfile, "\n");
//     fwrite($myfile, $row['convenience_fee']);
//     fwrite($myfile, "\n");
//     fwrite($myfile, $row['advance_payment']);
//     fwrite($myfile, "\n");
//     fwrite($myfile, $row['due_payment']);
//     fwrite($myfile, "\n");
//     fwrite($myfile, $row['agent_id']);
//     fwrite($myfile, "\n");
// }
// fclose($myfile);

// Create an array to store all receipts
$allData = array();

foreach ($all_receipts as $row) {
    $data = array(
        'receipt_id' => $row['receipt_id'],
        'customer_name' => $row['customer_name'],
        'customer_email' => $row['customer_email'],
        'customer_phone' => $row['customer_phone'],
        'payment_date' => $row['payment_date'],
        'due_date' => $row['due_date'],
        'item_list' => json_decode($row['item_list']),
        'subtotal' => $row['subtotal'],
        'discount_percentage' => $row['discount_percentage'],
        'discount_amount' => $row['discount_amount'],
        'payable' => $row['payable'],
        'convenience_fee' => $row['convenience_fee'],
        'advance_payment' => $row['advance_payment'],
        'due_payment' => $row['due_payment'],
        'agent_id' => $row['agent_id']
    );

    // Append the data for the current receipt to the array
    $allData[] = $data;
}

header('Content-Type: application/json');
echo json_encode($allData);
exit; // or die;
