<?php

session_start();

if (isset($_SESSION['agent']['loggedin'])) {
    if ($_SESSION['agent']['loggedin']) {
        include_once "invoice.php";
    } else {
        include_once "login.php";
    }
} else {
    include_once "login.php";
}
