<?php

session_start();

if (isset($_SESSION['agent']['loggedin'])) {
    if ($_SESSION['agent']['loggedin']) {
        include_once "../Server/View/invoice.php";
    } else {
        session_destroy();
        include_once "../Server/View/login.php";
    }
} else {
    session_destroy();
    include_once "../Server/View/login.php";
}
