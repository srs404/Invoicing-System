<?php
// Your database connection code goes here

if (isset($_POST['receipt_id'])) {
    $receipt_id = $_POST['receipt_id'];
    fopen("testfile.txt", "w");
    fwrite($myfile, $receipt_id);
    fclose($myfile);
    // Perform the row deletion operation in your database here
} else {
    echo json_encode(['status' => 'error']);
}
