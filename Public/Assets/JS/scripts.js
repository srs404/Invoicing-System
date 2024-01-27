// ! =============================== START Variable Space ===============================
/** 
 * Title: All Variables
 * ~ Description: This section will contain all the variables
 */

var currentPageNumber = 1; // Variable to store the current page number
var iframe_preview_first_time = true; // Variable to store the iframe
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
        render: function (data, type, full, meta) {
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
$('#mySearch').on('keyup', function () {
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
$('#previewInvoiceBTN').click(function () {
    if (document.getElementById('advance-payment').value == "" || document.getElementById('advance-payment').value == null || document.getElementById('advance-payment').value == 0) {
        var payment_status_x = "Paid";
    } else {
        var payment_status_x = "Partially Paid";
    }
    alert(payment_status_x);
    var data = {
        customer_name: document.getElementById('name').value,
        customer_email: document.getElementById('email').value,
        customer_phone: document.getElementById('phone-number').value,
        payment_date: document.getElementById('payment-date').value,
        due_date: document.getElementById('due-date').value,
        subtotal: parseFloat(document.getElementById('subtotal').value) || 0,
        discount_percentage: parseFloat(document.getElementById('discount').value) || 0,
        discount_amount: parseFloat(document.getElementById('discountAmount').value) || 0,
        payable: parseFloat(document.getElementById('total-payable').value) || 0,
        convenience_fee: parseFloat(document.getElementById('convenience-fee').value) || 0,
        advance_payment: parseFloat(document.getElementById('advance-payment').value) || 0,
        due_payment: parseFloat(document.getElementById('due-payment').value) || 0,
        payment_status: payment_status_x,
        item_list: tableBodyToJson(document.getElementById('item-table')), // Parse the table JSON
        receipt_id: document.getElementById('receipt_number_1').innerHTML
    };
    dynamicIframeUpdateOption(data);
    wspFrameGlobal.focus();
    wspFrameGlobal.print();
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
    xhr.onreadystatechange = function () {
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
 * ~ Description: This function will fetch data and populate the table
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
 */

function fetchDataAndPopulateTable() {
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "process.php", true);
    xhr.onreadystatechange = function () {
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
                data.forEach(function (item) {
                    table.row.add([
                        item.receipt_id,
                        item.customer_name,
                        item.payment_date, // Corrected property name
                        item.subtotal,
                        item.payment_status,
                        // 'Paid',
                        '<button id="primaryPrintPreviewBTN" class="btn btn-primary btn-sm"><span class="fa fa-magnifying-glass"></span></button> <button id="getReceiptInformation" class="btn btn-success btn-sm"><span class="fa fa-pencil"></span></button> <button id="deleteReceipt" class="btn btn-danger btn-sm"><span class="fa fa-x"></span></button>'
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
$(document).on('click', '#deleteReceipt', function () {
    var receipt_id = $(this).closest('tr').find('td:eq(0)').text();

    if (confirm("Are you sure you want to delete '" + receipt_id + "' receipt?")) {
        // Send data to PHP using AJAX (or any other method)
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "process.php", true);
        xhr.setRequestHeader("Content-Type", "application/json");
        xhr.onreadystatechange = function () {
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
$('#submitReceiptBTN').click(function () {
    if (document.getElementById('item-table').rows.length > 2) {
        $('#createNewModal').modal('hide');
        handleSubmit();

        fetchDataAndPopulateTable();
    } else {
        alert("Please add at least one item to the table");
    }
});

/**
 * TITLE: Primary Preview Button
 * ~ Description: This will get data using receipt ID and trigger the print function
 * 
 * @return void
 */
$(document).on('click', '#primaryPrintPreviewBTN', function () {
    var receipt_id = $(this).closest('tr').find('td:eq(0)').text();

    // Send data to PHP using AJAX (or any other method)
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "process.php", true);
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                // Handle response from PHP
                var response = JSON.parse(xhr.responseText);
                if (response.status === "success") {
                    // Send Data To Preview Print
                    dynamicIframeUpdateOption(response.data);
                    wspFrameGlobal.focus();
                    wspFrameGlobal.print();
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
 * Title: Update Receipt Functionality
 * ~ Description: This will take receipt ID and update the receipt
 * 
 * @return void
 */
$(document).on('click', '#getReceiptInformation', function () {
    var receipt_id = $(this).closest('tr').find('td:eq(0)').text();

    flag_update_page_receipt_id_fixed = true;

    // Send data to PHP using AJAX (or any other method)
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "process.php", true);
    xhr.onreadystatechange = function () {
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
                    for (var i = rowCount - 1; i > 1; i--) {
                        table.deleteRow(i);
                    }

                    // Populate the table
                    itemData.forEach(function (item) {
                        insRow(item.item_name, item.item_description, item.item_price);
                    });

                    // Send Data To Preview Print
                    dynamicIframeUpdateOption(response.data);

                    $('#customerInformationModal').modal('show');
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
$("#updateReceiptBTN").on("click", function () {

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
        tableData: tableBodyToJson(document.getElementById('item-table')) // Parse the table JSON
    };

    // Send data to PHP using AJAX (or any other method)
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "process.php", true);
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                // Handle response from PHP
                var response = JSON.parse(xhr.responseText);
                if (response.status === "success") {
                    alert("Receipt updated successfully");
                    $('#createNewModal').modal('hide');
                    document.getElementById('updateReceiptBTN').style.display = "none";
                    document.getElementById('submitReceiptBTN').style.display = "block";
                    flag_update_page_receipt_id_fixed = false;
                } else {
                    alert("Receipt update failed");
                }
            }
        }
    };
    var requestData = JSON.stringify(formData);
    xhr.send(requestData);
});

$('#newInvoice, #sidebarCreateNew, #createNewNavBtn').on('click', function () {
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

$('#phone-number').on('input', function () {
    if (this.value.length > 10) {
        this.value = this.value.slice(0, 10);
    }
});

dynamicIframeUpdateOption(data = {
    "receipt_id": "TRIPUP-0001",
    "customer_name": "SRS",
    "customer_email": "demo",
    "customer_phone": "demo",
    "payment_date": "demo",
    "due_date": "demo",
    "subtotal": "demo",
    "discount_percentage": "demo",
    "discount_amount": "demo",
    "payable": "demo",
    "convenience_fee": "demo",
    "advance_payment": "demo",
    "due_payment": "demo",
    "item_list": "[{\"item_name\":\"Hotel/Resort\",\"item_description\":\"demo\",\"item_price\":\"demo\"},{\"item_name\":\"Ship\",\"item_description\":\"demo\",\"item_price\":\"demo\"},{\"item_name\":\"Flight\",\"item_description\":\"demo\",\"item_price\":\"demo\"},{\"item_name\":\"Package\",\"item_description\":\"demo\",\"item_price\":\"demo\"},{\"item_name\":\"Bus\",\"item_description\":\"demo\",\"item_price\":\"demo\"}]"

});
var wspFrameGlobal;

function dynamicIframeUpdateOption(data, preview = false) {
    var container = document.getElementById('iframeModal');
    var iframe = document.createElement('iframe');
    var html = dynamicIframeHTML(data);

    // Set iframe attributes
    iframe.id = 'frame';
    iframe.style.visibility = 'hidden';
    iframe.style.width = '0px';
    iframe.style.border = '0';
    iframe.style.height = '0px';
    iframe.src = 'about:blank'; // Set a default blank page to avoid security issues

    container.innerHTML = ''; // Clear any existing content
    container.appendChild(iframe);

    // Access the iframe's contentWindow
    var wspFrame = iframe.contentWindow;

    // Open, write, and close the document
    wspFrame.document.open();
    wspFrame.document.write(html);
    wspFrame.document.close();

    wspFrameGlobal = wspFrame;
}

function formatDate(inputDate) {
    const options = {
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    };
    const date = new Date(inputDate);
    return date.toLocaleDateString('en-GB', options);
}

function formatCurrency(inputString) {
    // Parse the input string as a number
    const number = parseFloat(inputString);

    // Check if the parsed number is a valid number
    if (isNaN(number)) {
        return "Invalid Number";
    }

    // Use the toLocaleString() method to format as currency
    return number.toLocaleString('en-US');
}

function dynamicIframeHTML(data) {
    var tableHTMLcode = "";
    tableRowItems = JSON.parse(data.item_list);
    tableRowItems.forEach(function (item) {
        tableHTMLcode += '<tr><td class="border-0" id="dynamicItemQuantity">' + item.item_name + '</td><td class="border-0" id="dynamicItemUnitPrice">' + item.item_description + '</td><td class="border-0" id="dynamicItemSubtotal"><span class="dynamicItemSubtotalAmount">' + item.item_price + '</span> BDT</td></tr>';
    });
    var htmlcode = '<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1.0"><title>Print</title><link href="https://fonts.googleapis.com/css2?family=Rubik:wght@400;600&display=swap" rel="stylesheet"><meta name="viewport" content="width=device-width,initial-scale=1.0"/><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous"><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer"/><link rel="stylesheet" href="Assets/CSS/receipt.css"></head><body><div class="mainCircleLogo"><img src="Assets/Images/tripupappicon.png" width="400px"></div><div class="receiptTopPart"><div class="receiptTopLeftPart"><img src="Assets/Images/tripupmainlogo.png" loading="lazy" width="200px" alt="TripUp Logo"><p style="font-weight:bold;margin-top:10px;color:#1965af;">Address:<span id="dynamicAddress" style="font-weight:normal;color:black;">143,Road 01,Avenue 01,Mirpur DOHS.</span></p><p style="margin-top:20px;text-align:left;"><h3 style="font-weight:bold;">Customer Details</h3><table class="table customerDetailsTable" style="width:250px;"><tr class="border-0"><td class="noborder" style="font-weight:bold;">Name:</td><td class="noborder" id="dynamicCustomerName" style="font-weight:normal;">' + data.customer_name + '</td></tr><tr class="border-0"><td class="noborder" style="font-weight:bold;">Contact:</td><td class="noborder" id="dynamicCustomerContact" style="font-weight:normal;">' + data.customer_phone + '</td></tr><tr class="border-0"><td class="noborder" style="font-weight:bold;">Email:</td><td class="noborder" id="dynamicCustomerEmail" style="font-weight:normal;">' + data.customer_email + '</td></tr></table></p></div><div class="receiptTopRightPart"><div style="text-align:right;margin-top:30px;"><h3 style="font-size:34px;font-weight:bold;">RECEIPT</h3><h3 style="font-weight:500;" id="DynamicReceiptNumber">' + data.receipt_id + '</h3></div><div style="margin-top:20px;" class="table-responsive-sm"><table class="table"><tr><td style="font-weight:bold;border:none;text-align:right;">Payment Date:</td><td class="border-0" id="dynamicPaymentDate">' + formatDate(data.payment_date) + '</td></tr><tr><td style="font-weight:bold;border:none;text-align:right;">Due Date:</td><td class="border-0" id="dynamicDueDate">' + formatDate(data.due_date) + '</td></tr><tr><td style="font-weight:bold;border:none;text-align:right;">Payment Status:</td><td class="border-0" id="dynamicPaymentMethod">' + data.payment_status + '</td></tr></table></div></div></div><div class="receiptMiddlePart"><table class="table itemReceiptTable"><thead><tr><th style="width:25%;">Item Name</th><th style="width:50%;">Item Description</th><th style="width:25%;">Amount</th></tr></thead><tbody>' + tableHTMLcode + '</tbody></table><div class="col-12 d-flex justify-content-end" style="background-color:transparent!important;"><div class="card border-0" style="background-color:transparent!important;"><div class="card-body" style="background-color:transparent!important;"><table class="table subtotalTable" style="background-color:transparent!important;"><tbody><tr><td>Subtotal :</td><td style="text-align: right;"><span style="font-weight:normal;"> ' + formatCurrency(data.subtotal) + '</span> BDT</td></tr><tr><td>Discount :</td><td style="text-align: right;"><span style="font-weight:normal;">' + formatCurrency(data.discount_amount) + ' (' + data.discount_percentage + '%)</span> BDT</td></tr><tr><td>Convenience Fee :</td><td style="text-align: right;"><span style="font-weight:normal;">' + formatCurrency(data.convenience_fee) + '</span> BDT</td></tr><tr><td>Total :</td><td style="text-align: right;"><span style="font-weight:normal;">' + formatCurrency(data.payable) + '</span> BDT</td></tr><tr><td style="border-top:1px solid black;">Advance Paid :</td><td style="border-top:1px solid black; text-align: right;"><span style="font-weight:normal;">' + formatCurrency(data.advance_payment) + '</span> BDT</td></tr><tr><td>Due :</td><td style="text-align: right;"><span style="font-weight:normal;">' + formatCurrency(data.due_payment) + '</span> BDT</td></tr></tbody></table></div></div></div></div><div class="disclaimer"><p style="font-weight:bold;">Terms & Policy:</p><ul><li>The due amount must be paid at the time of check-in.</li><li>Booking money is not refundable.</li><li>In the event of political turmoil or natural disaster, we will reconsider the policy and shift (booking date) based on the circumstances.</li><li>If guests want to change their reservation date, may be moved to the next available date. However, you must let us know a week before your scheduled booking. If you choose to shift, 30% of your reservation fee will be deducted automatically.</li></ul></div><div class="receiptFooterDiv col-12"><div class="row justify-content-between col-12"><div class="col-4">info@tripup.io</div><div class="col-4 text-center">01897713000<span style="font-weight:bold;"></div><div class="col-4 text-right" style="text-align:right;">www.tripup.io</div></div></div><!-- <table class="table receiptFooter"><thead><tr><th style="width:25%;">Item Name</th><th style="width:50%;">Item Description</th><th style="width:25%;">Amount</th></tr></thead></table> --></body></html>';
    // var htmlcode = '<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>Print</title><link href="https://fonts.googleapis.com/css2?family=Rubik:wght@400;600&display=swap" rel="stylesheet"><meta name="viewport" content="width=device-width, initial-scale=1.0" /><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous"><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" /><link rel="stylesheet" href="Assets/CSS/receipt.css"></head><body><div class="mainCircleLogo"><img src="Assets/Images/tripupappicon.png" width="400px"></div><div class="receiptTopPart"><div class="receiptTopLeftPart"><img src="Assets/Images/tripupmainlogo.png" loading="lazy" width="200px" alt="TripUp Logo"><p style="font-weight: bold; margin-top: 10px; color: #1965af;">Address: <span id="dynamicAddress" style="font-weight: normal; color: black;">143, Road 01, Avenue 01, Mirpur DOHS.</span><br>Contact: <span id="dynamicContact" style="color: black; font-weight: normal;">+880 1234 567 890</span></p><p style="margin-top: 20px; text-align: left;"><h3 style="font-weight: bold;">Customer Details</h3><table class="table customerDetailsTable" style="width: 250px;"><tr class="border-0"><td class="noborder" style="font-weight: bold;">Name:</td><td class="noborder" id="dynamicCustomerName" style="font-weight: normal;">' + data.customer_name + '</td></tr><tr class="border-0"><td class="noborder" style="font-weight: bold;">Contact:</td><td class="noborder" id="dynamicCustomerContact" style="font-weight: normal;">+880 ' + data.customer_phone + '</td></tr><tr class="border-0"><td class="noborder" style="font-weight: bold;">Email:</td><td class="noborder" id="dynamicCustomerEmail" style="font-weight: normal;">' + data.customer_email + '</td></tr></table></p></div><div class="receiptTopRightPart"><div style="text-align: right; margin-top: 30px;"><h3 style="font-size: 34px; font-weight: bold;">RECEIPT</h3><h3 style="font-weight: 500;" id="DynamicReceiptNumber">' + data.receipt_id + '</h3></div><div style="margin-top: 20px;" class="table-responsive-sm"><table class="table"><tr><td style="font-weight: bold; border: none; text-align: right;">Payment Date:</td><td class="border-0" id="dynamicPaymentDate">' + formatDate(data.payment_date) + '</td></tr><tr><td style="font-weight: bold; border: none; text-align: right;">Due Date:</td><td class="border-0" id="dynamicDueDate">' + formatDate(data.due_date) + '</td></tr><tr><td style="font-weight: bold; border: none; text-align: right;">Payment Status:</td><td class="border-0" id="dynamicPaymentMethod">' + data.payment_status + '</td></tr></table></div></div></div><div class="receiptMiddlePart"><table class="table itemReceiptTable"><thead class=""><tr><th style="width: 25%;">Item Name</th><th style="width: 50%;">Item Description</th><th style="width: 25%;">Amount</th></tr></thead><tbody>' + tableHTMLcode + '</tbody></table><div class="col-12 d-flex justify-content-end" style="background-color: transparent !important;"><div class="card border-0" style="background-color: transparent !important;"><div class="card-body" style="background-color: transparent !important;"><table class="table subtotalTable" style="background-color: transparent !important;"><tbody><tr><td>Subtotal</td><td><span class="dynamicSubtotalAmount" style="font-weight: normal;">: ' + formatCurrency(data.subtotal) + '</span> BDT</td></tr><tr><td>Advance Paid</td><td><span class="dynamicAdvanceAmount" style="font-weight: normal;">: ' + formatCurrency(data.advance_payment) + '</span> BDT</td></tr><tr><td>Due</td><td><span class="dynamicDueAmount" style="font-weight: normal;">: ' + formatCurrency(data.due_payment) + '</span> BDT</td></tr></tbody></table></div></div></div><div class="disclaimer"><p style="font-weight: bold;">Terms & Policy:</p><ul><li>The due amount must be paid at the time of check-in.</li><li>Booking money is not refundable.</li><li>In the event of political turmoil or natural disaster, we will reconsider the policy and shift (booking date) based on the circumstances.</li><li>If guests want to change their reservation date, may be moved to the next available date. However, you must let us know a week before your scheduled booking. If you choose to shift, 30% of your reservation fee will be deducted automatically.</li></ul></div></div></body></html>';
    return htmlcode;
}