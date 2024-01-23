<?php
// fetch_data.php

// Check if the request method is GET
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Check if the receiptID and receipt_action parameters are set
    if (isset($_GET['receiptID']) && isset($_GET['receipt_action'])) {
        // Retrieve the values of receiptID and receipt_action
        $receiptID = $_GET['receiptID'];
        $receiptAction = $_GET['receipt_action'];

        // Assuming you have some logic here to fetch data based on receiptID and receipt_action
        // Replace this with your actual data retrieval logic
        $data = fetchData($receiptID, $receiptAction);

        // Check if data retrieval was successful
        if ($data !== false) {
            // Respond with success
            echo json_encode(['status' => 'success', 'data' => $data]);
            exit;
        } else {
            // Respond with an error
            echo json_encode(['status' => 'error', 'message' => 'Failed to fetch data']);
            exit;
        }
    } else {
        // Respond with an error if parameters are missing
        echo json_encode(['status' => 'error', 'message' => 'Missing parameters']);
        exit;
    }
} else {
    // Respond with an error for other request methods (e.g., POST)
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
    exit;
}

// Replace this function with your actual data retrieval logic
function fetchData($receiptID, $receiptAction)
{
    // Your data retrieval logic here
    // Example: querying a database or processing data based on receiptID and receiptAction

    // For this example, return a sample data array
    return [
        'receiptID' => $receiptID,
        'receiptAction' => $receiptAction,
        'someOtherData' => 'Sample data',
    ];
}
