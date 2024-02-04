<?php

/**
 * TITLE: SET PUBLISH MODE [true/false][Server/Localhost]
 * ~ Description: Set the publish mode to true or false
 * 
 * @var string $publish
 * @var string $server_addr
 */
$publish = "false"; // Set to "true" to publish

session_start(); // Start the session

if ($publish === "false") {
    $server_addr = "../Server/"; // Localhost Server directory
} else {
    $server_addr = "../../Server/"; // Public Server directory
}

// Include the autoloader
require_once "autoloader.php";

if (isset($_SESSION['agent']['loggedin'])) {
    if ($_SESSION['agent']['loggedin']) {
        include_once $server_addr . "View/invoice.php";
    } else {
        include_once $server_addr . "View/login.php";
    }
} else {
    include_once $server_addr . "View/login.php";
}
