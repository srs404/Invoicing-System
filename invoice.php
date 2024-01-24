<?php

/**
 * Title: Check User Login Session
 * ~ Description: This function will check if the user is logged in or not
 * ~ This function is called when the page is loaded
 */
if (!isset($_SESSION['agent']['loggedin'])) {
    if (!$_SESSION['agent']['loggedin']) {
        include_once "index.php";
    }
}

/**
 * Title: Logout
 * ~ Description: This function will logout the user
 * ~ This function is called when the logout button is clicked
 */
if (isset($_GET['logout'])) {
    if ($_GET['logout'] == true) {
        session_destroy();
        header("Refresh:0");
    }
}

require_once "App/Model/Receipt.php";

/**
 * Title: Generate Receipt Object
 * ~ Description: This function will generate a new receipt object
 */
$receipt = new Receipt();

/**
 * Title: Generate Receipt ID
 * ~ Description: This function will generate a new receipt ID
 */
$receipt_id = $receipt->generateReceiptID();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>TripUp Invoice</title>
    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@400;600&display=swap" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- Stylesheet -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="Assets/CSS/main.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="Assets/CSS/receipt.css">

    <input type="hidden" id="agent_id" value="<?php echo $_SESSION['agent']['id']; ?>">

    <!-- Modal: 1 -->
    <!-- Title: Customer Information Modal -->
    <!-- ~ Description: This is the infomation page of the modal or first page -->

    <div class="modal fade" id="customerInformationModal" tabindex="-1" aria-labelledby="customerInformationModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="customerInformationModal">Receipt No: <span id="receipt_number_1"></span></h1>
                    <button type="button" id="modalCloseBtn" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-3">
                    <form class="row g-3">

                        <div class="col-md-4 position-relative">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" placeholder="Sami Rahman">
                        </div>
                        <div class="col-md-4 position-relative">
                            <label for="email" class="form-label">Email</label>
                            <input type="text" class="form-control" id="email" placeholder="sami@rahman.dev">
                        </div>
                        <div class="col-md-4 position-relative">
                            <label for="phone-number" class="form-label">Phone Number</label>
                            <div class="input-group">
                                <span class="input-group-text" id="phone-Number-Prepend">+880</span>
                                <input type="number" max="1999999999" placeholder="1625469920" class="form-control" id="phone-number" aria-describedby="phone-Number-Prepend">
                            </div>
                        </div>
                        <div class="col-md-6 position-relative">
                            <label for="payment-date" class="form-label">Payment Date</label><input class="form-check-input bg-dark" type="checkbox" style="margin-left: 10px;" id="payment-date-checkbox" onchange="enableCurrentDateCheckbox(this)">
                            <input type="date" id="payment-date" class="form-control" onchange="checkDate('unlock-due-date')" disabled>

                        </div>
                        <div class="col-md-6 position-relative">
                            <label for="due-date" class="form-label">Due Date</label>
                            <input type="date" id="due-date" class="form-control" onchange="checkDate('')">
                        </div>

                        <!-- 
                            // Title Payment Status: 
                            // ~ Uncomment If Needed. Remember to change col-md-3 for both payment-date and due-date 
                        -->
                        <!-- <div class="col-md-3 position-relative">
                            <label for="payment-method" class="form-label">Payment Method</label>
                            <select class="form-select" id="payment-method">
                                <option selected disabled value="">Choose...</option>
                                <option value="Bkash">Bkash</option>
                                <option value="Nagad">Nagad</option>
                                <option value="Rocket">Rocket</option>
                                <option value="Bank-transfer">Bank Transfer</option>
                                <option value="Cash">Cash</option>
                            </select>
                        </div>
                        <div class="col-md-3 position-relative">
                            <label for="payment-status" class="form-label">Payment Status</label>
                            <select class="form-select" id="payment-status">
                                <option selected disabled value="">Choose...</option>
                                <option value="Paid">Paid</option>
                                <option value="Unpaid">Unpaid</option>
                                <option value="Partially-paid">Partially Paid</option>
                            </select>
                        </div> -->
                </div>
                </form>
                <div class="modal-footer">
                    <button type="button" id="modalDiscardBtn" class="btn btn-danger" data-bs-dismiss="modal" style="position: absolute; left: 10px;">Discard</button>
                    <button type="submit" id="nextModalBtn" class="btn btn-outline-dark"><span class="fa fa-arrow-right"></span></button>
                </div>

            </div>
        </div>
    </div>

    <!-- 
        ! ==========================================
        ! END: customerInformationModal
        ! ==========================================
    -->


    <!-- Modal: 2 -->
    <!-- 
        Title: Item Modal
        ~ Description: This is the primary modal for creating new invoice
    -->
    <div class="modal fade" id="createNewModal" tabindex="-1" aria-labelledby="createNewLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="createNewLabel">Receipt No: <span id="receipt_number_2"></span></h1>
                    <button type="button" id="tableModalCloseBtn" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-3" style="height: 400px;">
                    <div class="col-md-12" style="text-align: right; margin-bottom: 10px;">
                        <button class="btn btn-primary" id="addNewItemBtn"><span class="fa fa-plus"></span> New
                            Item</button>
                    </div>
                    <form id="item-form" class="row g-3">
                        <div class="col-md-12">
                            <div class="table-responsive-sm" style="max-height: 400px; margin-bottom: 10px; min-height: 300px; border-bottom: 1px solid black; overflow-y: auto;">
                                <table class="table text-center" id="item-table">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>Item Name</th>
                                            <th>Item Description</th>
                                            <th><label for="price-checkbox">Price</label> <input class="form-check-input" type="checkbox" value="" id="price-checkbox">
                                            </th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr></tr>
                                    </tbody>
                                </table>
                            </div>
                    </form>
                </div>

                <!-- Subtotal Input Form -->
                <div id="row" style="margin-bottom: 10px;">
                    <div class="input-group">
                        <div class="form-floating">
                            <input style="text-align: right; cursor: not-allowed;" type="number" disabled class="form-control" id="subtotal" name="subtotal" placeholder="0000" onchange="if(document.getElementById('discount').disabled) { handleDiscount('total-payable'); } else if(document.getElementById('discountAmount').disabled) {handleDiscount('total-payable')} else { handleDiscount('discount'); }">
                            <label for="discount">Subtotal</label>
                        </div>
                        <span class="input-group-text" style="cursor: not-allowed;">BDT</span>
                    </div>
                </div>

                <!-- Discount Input Form -->
                <div class="col-md-12 position-relative">
                    <div class="col-md-12 position-absolute top-0 end-0">
                        <div class="row" style="margin-bottom: 10px;">
                            <div class="input-group">
                                <div class="form-floating">
                                    <input style="text-align: right;" type="number" class="form-control" min="0" max="100" oninput="handleDiscount('discount')" id="discount" name="discount" placeholder="Discount"> <label for="discount">Discount</label>
                                </div>
                                <span class="input-group-text" style="cursor: not-allowed;"><span class="fa fa-percent"></span></span>
                                <div class="form-floating">
                                    <input style="text-align: right;" type="number" class="form-control" id="discountAmount" oninput="handleDiscount('discountAmount')" placeholder="1000">
                                    <label for="discountAmount">Amount</label>
                                </div>
                                <span class="input-group-text" style="cursor: not-allowed; width: 55px;">BDT</span>
                            </div>
                        </div>


                        <!-- Payable Input Form -->
                        <div id="row" style="margin-bottom: 10px;">
                            <div class="input-group">
                                <div class="form-floating">
                                    <input style="text-align: right;" type="number" class="form-control" min="0" oninput="handleDiscount('total-payable')" id="total-payable" name="total-payable" placeholder="0000"> <label for="total-payable">Payable</label>
                                </div>
                                <span class="input-group-text" style="cursor: not-allowed;">BDT</span>
                            </div>
                        </div>
                        <!-- Convenience fee Input Form -->
                        <div id="row" style="margin-bottom: 10px;">
                            <div class="input-group">
                                <div class="form-floating">
                                    <input style="text-align: right;" type="number" class="form-control" id="convenience-fee" placeholder="0000"> <label for="convenience-fee" oninput="duePaymentCalculator()">Convenience
                                        Fee</label>
                                </div>
                                <span class="input-group-text" style="cursor: not-allowed;">BDT</span>
                            </div>
                        </div>

                        <!-- Advance Payment Input Form -->
                        <div id="row" style="margin-bottom: 10px;">
                            <div class="input-group">
                                <div class="form-floating">
                                    <input style="text-align: right;" type="number" class="form-control" id="advance-payment" placeholder="0000"> <label for="advance-payment" oninput="duePaymentCalculator()">Advance
                                        Payment</label>
                                </div>
                                <span class="input-group-text" style="cursor: not-allowed;">BDT</span>
                            </div>
                        </div>

                        <!-- Due Payment Input Form -->
                        <div id="row" style="margin-bottom: 10px;">
                            <div class="input-group">
                                <div class="form-floating">
                                    <input style="text-align: right;" type="number" class="form-control" id="due-payment" disabled value="0" name="due-payment"> <label for="due-payment">Due
                                        Payment</label>
                                </div>
                                <span class="input-group-text" style="cursor: not-allowed;">BDT</span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="modal-footer">

                <button id="previewInvoiceBTN" class="btn btn-info text-white"><span class="fa fa-eye"></span></button>
                <button id="backModalBtn" class="btn btn-outline-dark" style="position: absolute; left: 10px; bottom: 10px;"><span class="fa fa-arrow-left"></span></button>
                <button id="submitReceiptBTN" class="btn btn-primary">Create</button>
                <button id="updateReceiptBTN" style="display: none;" class="btn btn-primary">Update</button>
            </div>

        </div>
    </div>
    </div>

    <!-- 
        ! ==========================================
        ! END: Item Modal
        ! ==========================================
    -->


    <!-- Modal 3 -->
    <!-- 
        Title: Item Input Modal
        ~ Description: This is the modal to get table content information
    -->

    <div class="modal fade" id="addNewTableItem" tabindex="-1" data-backdrop="static" data-keyboard="false" aria-labelledby="addNewTableItem" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
            <div class="modal-content">
                <div class="modal-header bg-dark text-white">
                    <h1 class="modal-title fs-5" id="addNewTableItem">Add New Item</h1>
                    <button type="button" id="modalItemCloseBtn" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-3">
                    <div class="mb-3">
                        <label for="item-nameModal" class="form-label">Item Name</label>
                        <select class="form-select" id="item-nameModal">
                            <option selected disabled value="">Choose...</option>
                            <option value="Hotel/Resort">Hotel/Resort</option>
                            <option value="Ship">Ship</option>
                            <option value="Flight">Flight</option>
                            <option value="Package">Package</option>
                            <option value="Bus">Bus</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="item-description-modal" class="form-label">Item Description</label>
                        <textarea class="form-control" id="item-description-modal" rows="6"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="item-price-modal" class="form-label">Item Price</label>
                        <div class="input-group" id="item-price-container-modal">
                            <span class="input-group-text">BDT</span>
                            <input type="number" class="form-control" style="text-align: right;" id="item-price-modal" oninput="subtotalCalculator()" placeholder="0" aria-label="Item Quantity">
                            <span class="input-group-text">৳</span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-dark text-bold">
                    <button type="button" id="modalItemClearBtn" class="btn btn-outline-danger" data-bs-dismiss="modal" style="position: absolute; font-weight: bold; left: 10px; bottom: 10px;">Discard</button>
                    <button type="button" class="btn btn-primary" id="modalItemSubmitBtn" data-bs-dismiss="modal">Insert</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <!-- 
        ! ==========================================
        ! END: Item Input Modal
        ! ==========================================
    -->


    <!-- PRINT PREVIEW IFRAME -->
    <!-- 
        Title: Receipt Preview IFRAME
        ~ Description: This is the modal to preview the receipt
    -->

    <div class="modal">
        <iframe id="frame" style="visibility: hidden; width: 0px; border: 0; height: 0px;" src="print/"></iframe>
    </div>



    <!-- 
        ! ==========================================
        ! END: PRINT PREVIEW IFRAME
        ! ==========================================
    -->


</head>

<body>
    <div id="editor"></div>
    <div id="mainBodyDiv">
        <!--Main Navigation-->
        <header>
            <!-- Sidebar -->
            <nav id="sidebarMenu" class="collapse d-lg-block sidebar collapse bg-white">

                <div class="position-sticky">

                    <div class="list-group list-group-flush mx-3 mt-4">

                        <a href="#" class="list-group-item list-group-item-action py-2 ripple" id="sidebarCreateNew">
                            <i class="fas fa-chart-area fa-book me-3"></i><span>Create New</span>
                        </a><br><br>
                        <a href="#" class="list-group-item list-group-item-action py-2 ripple active" aria-current="true">
                            <i class="fas fa-tachometer-alt fa-fw me-3"></i><span>Main Dashboard</span>
                        </a>

                        <a href="#" class="list-group-item list-group-item-action py-2 ripple"><i class="fas fa-chart-line fa-fw me-3"></i><span>Analytics (Soon)</span></a>
                        <a href="#" class="list-group-item list-group-item-action py-2 ripple"><i class="fas fa-users fa-fw me-3"></i><span>User Settings</span></a>

                    </div>

                </div>
                <a href="<?php echo $_SERVER['PHP_SELF'] ?>?logout=true" class="btn btn-danger" style="position: absolute; bottom: 0px; padding: 15px; width: 100%; border-radius: 0px;"><i class="fas fa-money-bill fa-power-off me-3"></i><span>Logout</span></a>
            </nav>
            <!-- Sidebar -->


            <!-- Navbar -->
            <nav id="main-navbar" class="navbar navbar-expand-lg navbar-light bg-white fixed-top">
                <!-- Container wrapper -->
                <div class="container-fluid">
                    <!-- Toggle button -->
                    <button class="navbar-toggler" type="button" data-mdb-toggle="collapse" data-mdb-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
                        <i class="fas fa-bars"></i>
                    </button>

                    <!-- Brand -->
                    <a class="navbar-brand" href="#" style="position: fixed; left: 20px; top: 10px;">
                        <img src="Assets/Images/tripupmainlogo.png" height="55" alt="" loading="lazy" />
                    </a>

                    <!-- Right links -->
                    <ul class="navbar-nav ms-auto d-flex flex-row">
                        <!-- Search form -->

                        <li class="nav-item">
                            <a class="nav-link me-3 me-lg-3" href="#" id="createNewNavBtn" role="button">
                                <i class="fas fa-folder-plus"></i>
                            </a>
                        </li>

                        <!-- Icon -->
                        <li class="nav-item">
                            <a class="nav-link me-3 me-lg-3" href="#">
                                <i class="fas fa-user-pen"></i>
                            </a>
                        </li>

                        <!-- Icon -->
                        <li class="nav-item">
                            <a class="nav-link me-3 me-lg-3" href="<?php echo $_SERVER['PHP_SELF'] ?>?logout=true'">
                                <i class="fas fa-power-off"></i>
                            </a>
                        </li>
                    </ul>
                </div>
                <!-- Container wrapper -->
            </nav>
            <!-- Navbar -->

        </header>
        <!--Main layout-->
        <main id="mainBody" style="min-height: calc(100vh - 58px);">


            <div class="card" style="max-height:600px !important; overflow: auto;">
                <div class="card-body">
                    <div class="d-flex justify-content-between" style="padding-left: 12px; padding-bottom: 10px; padding-right: 12px;">
                        <form class="input-group w-25">
                            <input id="mySearch" id="myTable_filter" autocomplete="off" type="search" class="form-control rounded border-3" placeholder='Search (ctrl + "/" to focus)' />
                        </form>
                        <button class="btn btn-primary" id="newInvoice"><span class="fa fa-plus"></span> New</button>
                    </div>
                    <div class="container">
                        <div class="table-responsive text-center">
                            <table class="table table-striped" id="myTable">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Invoice Number</th>
                                        <th>Name</th>
                                        <th>Date</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </main>


        <!--Main layout-->

        <footer id="footerMenu" class="bg-light text-center shadow-lg border-top">
            <!-- Copyright -->
            <div class="text-center p-3">
                © 2024 Copyright:
                <a class="text-dark" href="https://www.linkedin.com/in/srs404">TripUp Inc.</a>
                | All Rights Reserved
            </div>
            <!-- Copyright -->
        </footer>
    </div>


    <!-- Bootstrap JS and Popper.js (optional) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="Assets/JS/main.js"></script>

    <script>
        $(document).ready(function() {
            // ! =============================== START Variable Space ===============================
            /** 
             * Title: All Variables
             * ~ Description: This section will contain all the variables
             */

            var currentPageNumber = 1; // Variable to store the current page number
            var flag_update_page_receipt_id_fixed = false;
            // ! =============================== END Variable Space ===============================

            /**
             * Title: DataTables [COMPLETED]
             * ~ Description: This function will initialize the DataTables
             * ~ This function is called when the page is loaded
             * 
             * @return void
             * 
             * @uses DataTables
             * 
             * @uses jQuery
             * 
             * @uses Bootstrap
             */
            var myTable = $('#myTable').DataTable({
                "lengthMenu": [
                    [5, 10, 25, 50, -1],
                    [5, 10, 25, 50, "All"]
                ],
                responsive: true,
                lengthChange: false,
                pageLength: 9,
                language: {
                    search: "Find",
                },
                info: false,
                columnDefs: [{
                    targets: 0, // First column (change this to the correct column index)
                    type: 'num', // Set the data type to 'num' for numeric sorting
                    render: function(data, type, full, meta) {
                        if (type === 'sort') {
                            // Extract the numeric part after "-"
                            return parseInt(data.split('-')[1]);
                        }
                        return data;
                    }
                }]
            });



            /**
             * Title: Hide Default DataTable Search Field [COMPLETED]
             * ~ Description: This function will hide the default search field
             * ~ This function is called when the page is loaded
             * 
             * @return void
             * 
             * @uses DataTables
             */
            $(".dataTables_filter").parent().hide();

            /**
             * Title: Main Table Search Field [COMPLETED]
             * ~ Description: This function will search the table
             * ~ This function is called when the mySearch input is changed
             * 
             * @return void
             * 
             * @uses myTable
             * 
             * @uses DataTables
             * 
             * @uses jQuery
             * 
             * @uses Bootstrap
             */
            $('#mySearch').on('keyup', function() {
                myTable.search(this.value).draw();
            });

            /**
             * Title: Print Preview Functionality [COMPLETED]
             * ~ Description: This function will print the receipt
             * ~ This function is called when the printPreviewBTN is clicked
             * 
             * ~ This function will collect all the data from the input fields
             * 
             * @return void
             */
            // Print PDF Preview
            $('#previewInvoiceBTN').click(function() {
                let wspFrame = document.getElementById('frame').contentWindow;
                wspFrame.focus();
                wspFrame.print();
            });

            /**
             * Title: tableBodyToJson
             * ~ Description: This function will convert the table body to JSON
             * ~ This function is called when the submitReceiptBTN is clicked
             * 
             * ~ This function will return JSON as string
             * 
             * @param table
             * 
             * @return string
             * 
             * @uses handleSubmit
             */
            function tableBodyToJson(table) {
                var data = [];
                var headerText = ['item_name', 'item_description', 'item_price'];

                // Iterate through rows in the table body
                var rows = table.querySelectorAll("tbody tr");

                for (var i = 1; i < rows.length; i++) {
                    var row = rows[i];
                    var rowData = {};
                    var cells = row.querySelectorAll("td");

                    // Assuming that the IDs are unique within each row
                    var item_name = row.querySelector("#item-name");
                    var item_description = row.querySelector("#item-description");
                    var item_price = row.querySelector("#item-price");

                    // Check if the elements exist before accessing their values
                    if (item_name && item_description && item_price) {
                        rowData[headerText[0]] = item_name.value; // Use .value for select input
                        rowData[headerText[1]] = item_description.textContent;
                        rowData[headerText[2]] = item_price.value; // Use .value for number input
                    }

                    data.push(rowData);
                }

                return JSON.stringify(data);
            }

            /**
             * Title: handleSubmit
             * ~ Description: This function will submit values to process.php
             * ~ This function is called when the submitReceiptBTN is clicked
             * 
             * ~ This function will send the data to PHP using AJAX
             * ~ This function will handle the response from PHP
             * 
             * @return void
             * 
             * @uses tableBodyToJson
             */
            function handleSubmit() {
                // Collect input field data
                var formData = {
                    name: document.getElementById('name').value,
                    email: document.getElementById('email').value,
                    phone: document.getElementById('phone-number').value,
                    paymentDate: document.getElementById('payment-date').value,
                    dueDate: document.getElementById('due-date').value,
                    subtotal: parseFloat(document.getElementById('subtotal').value) || 0,
                    discount: parseFloat(document.getElementById('discount').value) || 0,
                    discountAmount: parseFloat(document.getElementById('discountAmount').value) || 0,
                    totalPayable: parseFloat(document.getElementById('total-payable').value) || 0,
                    convenienceFee: parseFloat(document.getElementById('convenience-fee').value) || 0,
                    advancePayment: parseFloat(document.getElementById('advance-payment').value) || 0,
                    duePayment: parseFloat(document.getElementById('due-payment').value) || 0,
                    receipt_action: "create",
                    agent_id: document.getElementById('agent_id').value,
                    tableData: JSON.parse(tableBodyToJson(document.getElementById('item-table'))) // Parse the table JSON
                };

                // Send data to PHP using AJAX (or any other method)
                var xhr = new XMLHttpRequest();
                xhr.open("POST", "process.php", true);
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        // Handle response from PHP
                        var response = JSON.parse(xhr.responseText);
                        if (response.status === "success") {
                            alert("Receipt created successfully");
                        } else {
                            alert("Receipt creation failed");
                        }
                    }
                };
                var requestData = JSON.stringify(formData);
                xhr.send(requestData);
            }

            /** 
             * Title: fetchDataAndPopulateTable
             * ~ Description: This function will fetch data from fetch_all.php and populate the table
             * ~ This function is called when the page is loaded
             * ~ This function is called when the deleteReceipt button is clicked
             * 
             * @return void
             * 
             * @uses incrementLastNumber
             * 
             * @uses DataTables
             * 
             * @uses jQuery
             * 
             * @uses Bootstrap
             * 
             * @uses fetch_all.php
             */

            function fetchDataAndPopulateTable() {
                var xhr = new XMLHttpRequest();
                xhr.open("POST", "process.php", true);
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === 4) {
                        if (xhr.status === 200) {
                            var data = JSON.parse(xhr.responseText);
                            var table = $('#myTable').DataTable();

                            // Store the current page number
                            var pageInfo = table.page.info();
                            currentPageNumber = pageInfo.page + 1;

                            // Clear existing table rows
                            table.clear().draw();

                            // Populate the table with the retrieved data
                            data.forEach(function(item) {
                                table.row.add([
                                    item.receipt_id,
                                    item.customer_name,
                                    item.payment_date, // Corrected property name
                                    item.subtotal,
                                    "Paid",
                                    '<button class="btn btn-primary btn-sm"><span class="fa fa-magnifying-glass"></span></button> <button id="getReceiptInformation" class="btn btn-success btn-sm"><span class="fa fa-pencil"></span></button> <button id="deleteReceipt" class="btn btn-danger btn-sm"><span class="fa fa-x"></span></button>'
                                ]).draw(false);
                                if (!flag_update_page_receipt_id_fixed) {
                                    document.getElementById('receipt_number_1').innerHTML = incrementLastNumber(item.receipt_id);
                                    document.getElementById('receipt_number_2').innerHTML = incrementLastNumber(item.receipt_id);
                                }
                            });

                            // Restore the current page after redrawing
                            table.page(currentPageNumber - 1).draw('page');
                        }
                    }
                };
                var requestData = JSON.stringify({
                    receipt_action: "getAll"
                });
                xhr.send(requestData);
            }

            // Call the function initially to populate the table
            fetchDataAndPopulateTable();

            // Set an interval to refresh the data periodically (e.g., every 5 seconds)
            setInterval(fetchDataAndPopulateTable, 1000);

            /**
             * Title: Increment Receipt ID Number
             * ~ Description: This function will increment the receipt ID Last Number
             * ~ This function is called when the fetchDataAndPopulateTable is called
             * 
             * @param inputString
             * 
             * @return string
             */
            function incrementLastNumber(inputString) {
                // Use a regular expression to find the last number in the string
                var regex = /(\d+)$/;
                var match = inputString.match(regex);

                if (match) {
                    // Extract the last number and increment it
                    var lastNumber = parseInt(match[0]);
                    var incrementedNumber = lastNumber + 1;

                    // Replace the last number in the string with the incremented value
                    var result = inputString.replace(regex, incrementedNumber.toString());

                    return result;
                } else {
                    // If there's no number at the end, return the original string
                    return inputString;
                }
            }

            /**
             * Title: Receipt Delete
             * ~ Description: Delete Individual Receipts according to their delete button
             */
            $(document).on('click', '#deleteReceipt', function() {
                var receipt_id = $(this).closest('tr').find('td:eq(0)').text();

                if (confirm("Are you sure you want to delete '" + receipt_id + "' receipt?")) {
                    // Send data to PHP using AJAX (or any other method)
                    var xhr = new XMLHttpRequest();
                    xhr.open("POST", "process.php", true);
                    xhr.setRequestHeader("Content-Type", "application/json");
                    xhr.onreadystatechange = function() {
                        if (xhr.readyState === 4 && xhr.status === 200) {
                            // Handle response from PHP
                            var response = JSON.parse(xhr.responseText);
                            if (response.status === "success") {
                                fetchDataAndPopulateTable();
                            } else {
                                alert("Receipt deletion failed");
                            }
                        }
                    };

                    var requestData = JSON.stringify({
                        receiptID: receipt_id,
                        receipt_action: "delete"
                    }); // Wrap the receipt_id in an object
                    xhr.send(requestData);
                }
            });


            /**
             * Title: Final Receipt Submit Functionality
             * ~ Description: This will trigger the handleSubmit function
             * 
             * @return void
             * 
             * @uses handleSubmit
             */
            $('#submitReceiptBTN').click(function() {
                if (document.getElementById('item-table').rows.length > 2) {
                    $('#createNewModal').modal('hide');
                    handleSubmit();

                    fetchDataAndPopulateTable();
                } else {
                    alert("Please add at least one item to the table");
                }
            });

            /**
             * Title: Update Receipt Functionality
             * ~ Description: This will take receipt ID and update the receipt
             * 
             * @return void
             */
            $(document).on('click', '#getReceiptInformation', function() {
                var receipt_id = $(this).closest('tr').find('td:eq(0)').text();

                flag_update_page_receipt_id_fixed = true;

                // Send data to PHP using AJAX (or any other method)
                var xhr = new XMLHttpRequest();
                xhr.open("POST", "process.php", true);
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === 4) {
                        if (xhr.status === 200) {
                            // Handle response from PHP
                            var response = JSON.parse(xhr.responseText);
                            if (response.status === "success") {
                                // Set the flag to true
                                document.getElementById('updateReceiptBTN').style.display = "block";
                                document.getElementById('submitReceiptBTN').style.display = "none";

                                $('#name').val(response.data.customer_name);
                                $('#email').val(response.data.customer_email);
                                $('#phone-number').val(response.data.customer_phone);
                                $('#payment-date').val(response.data.payment_date);
                                $('#due-date').val(response.data.due_date);
                                $('#subtotal').val(response.data.subtotal);
                                $('#discount').val(response.data.discount_percentage);
                                $('#discountAmount').val(response.data.discount_amount);
                                $('#total-payable').val(response.data.payable);
                                $('#convenience-fee').val(response.data.convenience_fee);
                                $('#advance-payment').val(response.data.advance_payment);
                                $('#due-payment').val(response.data.due_payment);
                                $('#receipt_number_1').html(response.data.receipt_id);
                                $('#receipt_number_2').html(response.data.receipt_id);

                                var itemData = JSON.parse(response.data.item_list); // Assuming item_list is an array of objects

                                // Delete all rows from the table
                                var table = document.getElementById('item-table');
                                var rowCount = table.rows.length;
                                for (var i = rowCount - 1; i > 2; i--) {
                                    table.deleteRow(i);
                                }

                                // Populate the table with the retrieved data
                                for (var i = 0; i < itemData.length; i++) {
                                    insRow(itemData[i].item_name, itemData[i].item_description, itemData[i].item_price);
                                }

                                $('#createNewModal').modal('show');

                                // $('#customerInformationModal').modal('show');
                            } else {
                                alert("Receipt retrieval failed: " + response.message);
                            }
                        } else {
                            console.error("Request failed with status code: " + xhr.status);
                            alert("An error occurred while retrieving the receipt information.");
                        }
                    }
                };

                var requestData = JSON.stringify({
                    receiptID: receipt_id,
                    receipt_action: "get"
                });
                xhr.send(requestData);
            });

            /**
             * Title: Update Receipt Button Functionality
             * ~ Description: This will take receipt ID and update the receipt
             * 
             * @return void
             */
            $("#updateReceiptBTN").on("click", function() {

                var formData = {
                    name: document.getElementById('name').value,
                    email: document.getElementById('email').value,
                    phone: document.getElementById('phone-number').value,
                    paymentDate: document.getElementById('payment-date').value,
                    dueDate: document.getElementById('due-date').value,
                    subtotal: parseFloat(document.getElementById('subtotal').value) || 0,
                    discount: parseFloat(document.getElementById('discount').value) || 0,
                    discountAmount: parseFloat(document.getElementById('discountAmount').value) || 0,
                    totalPayable: parseFloat(document.getElementById('total-payable').value) || 0,
                    convenienceFee: parseFloat(document.getElementById('convenience-fee').value) || 0,
                    advancePayment: parseFloat(document.getElementById('advance-payment').value) || 0,
                    duePayment: parseFloat(document.getElementById('due-payment').value) || 0,
                    receipt_action: "edit",
                    receiptID: document.getElementById('receipt_number_1').innerHTML,
                    agent_id: document.getElementById('agent_id').value,
                    tableData: JSON.parse(tableBodyToJson(document.getElementById('item-table'))) // Parse the table JSON
                };

                // Send data to PHP using AJAX (or any other method)
                var xhr = new XMLHttpRequest();
                xhr.open("POST", "process.php", true);
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === 4) {
                        if (xhr.status === 200) {
                            // Handle response from PHP
                            var response = JSON.parse(xhr.responseText);
                            if (response.status === "success") {
                                alert("Receipt updated successfully");
                            } else {
                                alert("Receipt update failed");
                            }
                        }
                    }
                };
                var requestData = JSON.stringify(formData);
                xhr.send(requestData);



                $('#createNewModal').modal('hide');
                alert("Update Receipt Button Clicked");
                document.getElementById('updateReceiptBTN').style.display = "none";
                document.getElementById('submitReceiptBTN').style.display = "block";
                flag_update_page_receipt_id_fixed = false;
            });

            $('#newInvoice, #sidebarCreateNew, #createNewNavBtn').on('click', function() {
                // Clear All Input Fields
                flag_update_page_receipt_id_fixed = false;

                // Delete all rows from the table
                var table = document.getElementById('item-table');
                var rowCount = table.rows.length;
                for (var i = rowCount - 1; i > 1; i--) {
                    table.deleteRow(i);
                }

                $("#name").val("");
                $("#email").val("");
                $("#phone-number").val("");
                setDefaultDate();
                $("#due-date").val("");
                $("#subtotal").val("");
                $("#discount").val("");
                $("#discountAmount").val("");
                $("#total-payable").val("");
                $("#advance-payment").val("");
                $("#due-payment").val("");
                $("#convenience-fee").val("");
                $("#payment-date-checkbox").checked = false;
                $("#payment-date").disabled = true;
                fetchDataAndPopulateTable();

                document.getElementById("updateReceiptBTN").style.display = "none";
                document.getElementById("submitReceiptBTN").style.display = "block";

                $('#customerInformationModal').modal('show');
            });


            /**
             * Title: setDefaultDate
             * ~Description: This function sets the default date to the current date
             *  ~ This function is called when the page is loaded
             *  ~ This function is called when the payment-date-checkbox is checked
             *  ~ This function is called when the payment-date is changed
             *  ~ This function is called when the due-date is changed
             */
            setDefaultDate();

            function setDefaultDate() {
                // Create a new date object with the current date
                var today = new Date();

                // Format the date to YYYY-MM-DD
                var date = today.getFullYear() + '-' + (today.getMonth() + 1).toString().padStart(2, '0') + '-' + today.getDate().toString().padStart(2, '0');

                // Set the value of the input to the formatted date
                document.getElementById('payment-date').value = date;
            }

            $('#phone-number').on('input', function() {
                if (this.value.length > 10) {
                    this.value = this.value.slice(0, 10);
                }
            });

        });
    </script>

</body>

</html>