<?php
// Retrieve JSON data from the request body
$str_json = file_get_contents('php://input');

// Display an alert with the JSON data using JavaScript
echo "<script>alert('" . addslashes($str_json) . "');</script>";

// Create a file with the JSON data as its name
$filename = "data_" . time() . ".json"; // You can use a timestamp as a unique name
$myfile = fopen($filename, "w");

// Write the JSON data to the file
if ($myfile) {
    fwrite($myfile, $str_json);
    fclose($myfile);
    echo "File '$filename' created successfully.";
} else {
    echo "Error creating the file.";
}
