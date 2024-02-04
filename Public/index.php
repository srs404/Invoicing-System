<?php

session_start();
require_once "autoloader.php";
if (isset($_SESSION['agent']['loggedin'])) {
    if ($_SESSION['agent']['loggedin']) {
        include_once "../Server/View/invoice.php";
    } else {
        include_once "../Server/View/login.php";
    }
} else {
    include_once "../Server/View/login.php";
}
