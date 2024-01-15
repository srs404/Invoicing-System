// Function to show the selected form based on the dropdown value
$(function () {
    $('#datetimepicker1').datetimepicker();
    subtotalCalculator();
});

// PreventDefault on form submit
$("#item-form").submit(function (e) {
    return false;
});


// NOTE: This function is used to check if user gave discount or total payable amount and disable the other input field and calculate the discounted price
function handleDiscount(option) {
    // Get references to input elements
    var discountInput = document.getElementById('discount');
    var totalPayableInput = document.getElementById('total-payable');
    var subtotalInput = document.getElementById('subtotal');
    var discountAmountInput = document.getElementById('discountAmount');
    var duePaymentInput = document.getElementById('due-payment');

    if (option === 'discount') {
        // Get the discount value from the discount input
        var discountValue = parseFloat(discountInput.value);

        // Check if the discountValue is a valid number between 0 and 100
        if (!isNaN(discountValue) && discountValue >= 0 && discountValue <= 100) {
            // Get the original price from the subtotal input
            var originalPrice = parseFloat(subtotalInput.value);

            // Calculate the discount amount and update the input
            var discountAmount = (discountValue / 100) * originalPrice;
            discountAmountInput.value = discountAmount.toFixed(2);

            // Calculate the total payable price and update the input
            totalPayableInput.value = (originalPrice - discountAmount).toFixed(2);

            // Disable the discount amount and total payable inputs
            discountAmountInput.disabled = true;
            totalPayableInput.disabled = true;
        } else {
            // Clear input fields and enable them
            discountInput.value = '';
            totalPayableInput.value = '';
            discountAmountInput.value = '';


            discountAmountInput.disabled = false;
            totalPayableInput.disabled = false;
        }
    } else if (option === 'discountAmount') {
        // Get the discount amount from the discountAmount input
        var discountAmount = parseFloat(discountAmountInput.value);

        // Check if the discountAmount is a valid number between 0 and the subtotal
        if (!isNaN(discountAmount) && discountAmount >= 0 && discountAmount <= parseFloat(subtotalInput.value)) {
            // Get the original price from the subtotal input
            var originalPrice = parseFloat(subtotalInput.value);

            // Calculate the discount percentage and update the discount input
            var discountPercentage = (discountAmount / originalPrice) * 100;
            discountInput.value = discountPercentage.toFixed(2);

            // Calculate the total payable price and update the input
            totalPayableInput.value = (originalPrice - discountAmount).toFixed(2);

            // Disable the discount input and total payable inputs
            discountInput.disabled = true;
            totalPayableInput.disabled = true;
        } else {
            // Clear input fields and enable them
            discountAmountInput.value = '';
            discountInput.value = '';
            totalPayableInput.value = '';

            discountInput.disabled = false;
            totalPayableInput.disabled = false;
        }
    } else if (option === 'total-payable') {
        // Get the total payable value from the totalPayableInput
        var totalPayableValue = parseFloat(totalPayableInput.value);

        // Check if the totalPayableValue is a valid number between 0 and the subtotal
        if (!isNaN(totalPayableValue) && totalPayableValue >= 0 && totalPayableValue <= parseFloat(subtotalInput.value)) {
            // Get the original price from the subtotal input
            var originalPrice = parseFloat(subtotalInput.value);

            // Calculate the discount percentage based on the total payable and update the discount input
            var discountPercentage = ((originalPrice - totalPayableValue) / originalPrice) * 100;
            discountInput.value = discountPercentage.toFixed(2);

            // Disable the discount input
            discountInput.disabled = true;
        } else {
            // Clear input fields and enable them
            totalPayableInput.value = '';
            discountInput.value = '';
            discountAmountInput.value = '';

            discountInput.disabled = false;
            discountAmountInput.disabled = false;
        }
    } else if (option === 'due-payment') {
        // Get the due payment value from the duePaymentInput
        var totalPayableValue = parseFloat(totalPayableInput.value);
        var duePaymentInput = document.getElementById('due-payment');

        // Check if the duePaymentValue is a valid number between 0 and the subtotal
        if (!isNaN(totalPayableValue) && totalPayableValue >= 0 && totalPayableValue <= parseFloat(subtotalInput.value)) {
            // Get the original price from the subtotal input
            var originalPrice = totalPayableValue;

            // Calculate the total payable price and update the input
            duePaymentInput.value = (originalPrice - duePaymentValue).toFixed(2);

            // Disable the total payable input
            totalPayableInput.disabled = true;
        } else {
            // Clear input fields and enable them
            totalPayableInput.value = '';

            totalPayableInput.disabled = false;
        }
    }
}

function duePaymentCalculator() {

}


// Usage example:
// For discount input change
// handleDiscount('discount');

// For total payable input change
// handleDiscount('total-payable');


// TODO: Subtotal Calculator
function subtotalCalculator() {
    let sum = 0;
    let prices = document.querySelectorAll('#item-price');

    for (let i = 0; i < prices.length; i++) {
        sum += parseInt(prices[i].value) || 0; // Ensure to add 0 if the value is not a valid number
    }

    document.getElementById('subtotal').value = sum.toFixed(2);
}

// Enable/Disable the item-price input field
$('#price-checkbox').on('change', function () {
    if (this.checked) {
        for (var i = 0; i < document.querySelectorAll('#item-price').length; i++) {
            document.querySelectorAll('#item-price')[i].disabled = false;
            subtotalCalculator();
        }
    } else {
        for (var i = 0; i < document.querySelectorAll('#item-price').length; i++) {
            document.querySelectorAll('#item-price')[i].disabled = true;
            subtotalCalculator();
        }
    }

});


// Validate Date Input
function checkDate(option) {
    if (option === 'unlock-due-date') {
        if (document.getElementById("payment-date").value === "") {
            document.getElementById("due-date").disabled = true;
        } else if (document.getElementById("payment-date").value > document.getElementById("due-date").value && document.getElementById("due-date").value !== "") {
            document.getElementById("due-date").disabled = true;
            document.getElementById("due-date").value = "";
            alert("Due Date Cannot be earlier than Issued Date");
        } else {
            document.getElementById("due-date").disabled = false;
        }
    } else {
        var date = document.getElementById("payment-date").value;
        var date2 = document.getElementById("due-date").value;
        if (date2 < date) {
            alert("Due Date cannot be earlier than Issued Date");
            document.getElementById("due-date").value = "";
        }
    }
}

// Toggle Payment Date Enable/Disable: Checkbox
function enableCurrentDateCheckbox(object) {
    if (object.checked) {
        object.parentElement.parentElement.querySelector('#payment-date').disabled = false;
    } else {
        object.parentElement.parentElement.querySelector('#payment-date').disabled = true;
    }
}

// Set Default Date of Payment Date to Today
window.addEventListener("load", function () {
    var now = new Date();
    var offset = now.getTimezoneOffset() * 60000;
    var adjustedDate = new Date(now.getTime() - offset);
    var formattedDate = adjustedDate.toISOString().substring(0, 16); // For minute precision
    var datetimeField = document.getElementById("payment-date");
    datetimeField.value = formattedDate;
});


// Insert New Row: With Custom CSS
// TODO: Fix the css
function insRow(item_name, item_description, item_price) {
    var table = document.getElementById('item-table');
    var x = table.rows.length;

    var row = table.insertRow(x);
    var id = "tbl" + x;
    row.id = id;

    var cell1 = row.insertCell(0);
    var cell2 = row.insertCell(1);
    var cell3 = row.insertCell(2);
    var cell4 = row.insertCell(3);

    cell1.innerHTML = '<td><input style="min-width: 175px;" class="form-control" id="formType" disabled value="' + item_name + '"></td>';
    cell2.innerHTML = '<td><textarea type="text" disabled class="form-control" style="min-width: 355px; height: 2px;" id="item-description" placeholder="Item Description" required>' + item_description + '</textarea></td>';
    cell3.innerHTML = '<td><div style="min-width: 190px;" class="input-group mb-3" id="item-price-container"><span class="input-group-text">BDT</span><input type="number" class="form-control" style="text-align: right;" id="item-price" oninput="subtotalCalculator()" value="' + item_price + '" disabled aria-label="Item Quantity"><span class="input-group-text">৳</span></div></td>';
    cell4.innerHTML = '<td><div style="min-width: max-content;"><button class="btn btn-outline-primary" onclick="insRow()" style="margin-right: 5px;"><span class="fa fa-pencil"></span></button><button class="btn btn-danger" onclick="deleteRow(this); subtotalCalculator()"><span class="fa fa-trash"></span></button></div></td>';

    subtotalCalculator();
    clearModal('item');
}


// Delete Row
// Additional: Don't delete the first row
function deleteRow(button) {
    var row = button.parentNode.parentNode.parentNode;
    if (row.rowIndex > 1) {
        document.getElementById('item-table').deleteRow(row.rowIndex);
        subtotalCalculator();
    }
}

// ================================
// Title: All Clear Functions
// ================================

// Clear: Modals
function clearModal(option) {
    if (option === 'customer-information') {
        $('#name').val('');
        $('#email').val('');
        $('#phone-number').val('');
        $('#payment-date').val('');
        $('#due-date').val('');
        $('#payment-method').val('');
        $('#payment-status').val('');
    } else if (option === 'invoice') {
        $('#invoice-number').val('');
        $('#invoice-date').val('');
        $('#invoice-due-date').val('');
        $('#invoice-payment-method').val('');
        $('#invoice-payment-status').val('');
    } else if (option === 'item') {
        $('#formTypeModal').val('');
        $('#item-description-modal').val('');
        $('#item-price-modal').val('');
    }
}


// ================================
// ~ End Clear Function Block
// ================================

// Modal: 1st
// Title: Customer Information Modal
/*
    ~ Description:
    This modal provides functionalities for adding customer information.
    It allows the user to input data for the customer and submit it to be added to the table.
    The modal includes the following functionalities:
    - Input fields for entering data
    - Validation of input data
    - Submit button to add the new customer
    - Cancel button to close the modal without adding the customer
*/
$('#nextModalBtn').on('click', function () {
    // ! THIS IS COMPLETED. UNCOMMENT IT AFTER WORK DONE
    // var fields = ['#name', '#email', '#phone-number', '#payment-date', '#due-date', '#payment-method', '#payment-status'];

    // if (fields.some(field => $(field).val() === '') || fields.some(field => $(field).val() === null)) {
    //     alert('Please fill in all the fields');
    // } else {
    //     $('#createNewModal').modal('show');
    //     $('#customerInformationModal').modal('hide');
    // }

    // Remove These After Uncommenting the previous codes
    $('#createNewModal').modal('show');
    $('#customerInformationModal').modal('hide');
});

$('#backModalBtn').on('click', function () {
    $('#createNewModal').modal('hide');
    $('#customerInformationModal').modal('show');
});

$('#tableModalCloseBtn').on('click', function () {
    $('#createNewModal').modal('hide');
});

// Modal: 2nd
// Title: Invoice modal
/*
    ~ Description:
    This modal provides functionalities for creating a new invoice.
    It allows the user to input data for the new invoice and submit it to be added to the table.
    The modal includes the following functionalities:
    - Input fields for entering data
    - Validation of input data
    - Submit button to add the new invoice
    - Cancel button to close the modal without adding the invoice
*/
$('#newInvoice, #sidebarCreateNew, #createNewNavBtn').on('click', function () {
    $('#customerInformationModal').modal('show');
});

// Close modal
$('#modalCloseBtn, #modalDiscardBtn').on('click', function () {
    $('#customerInformationModal').modal('hide');
});


// Title : Item Modal
/*    
    ~ Description:
    This modal provides functionalities for adding a new table item.
    It allows the user to input data for the new item and submit it to be added to the table.
    The modal includes the following functionalities:
    - Input fields for entering data
    - Validation of input data
    - Submit button to add the new item
    - Cancel button to close the modal without adding the item
*/
$('#addNewItemBtn').on('click', function () {
    $('#addNewTableItem').modal('show');
    $('#customerInformationModal').modal('hide');
    $('#createNewModal').modal('hide');
});

// Close Modal
$('#modalItemCloseBtn').on('click', function () {
    $('#addNewTableItem').modal('hide');
    $('#createNewModal').modal('show');
});

$('#modalItemClearBtn').on('click', function () {
    $('#addNewTableItem').modal('hide');
    $('#createNewModal').modal('show');
    clearModal('item');
});

// Functionalities: Add new item to table
$('#modalItemSubmitBtn').on('click', function () {
    // Get values from input fields
    let item_name = $('#formTypeModal').val();
    let item_description = $('#item-description-modal').val();
    let item_price = $('#item-price-modal').val();

    // Validate input fields
    if (item_name === '' || item_description === '' || item_price === '') {
        alert('Please fill in all the fields');
    } else {
        // After Executing Every Tasks
        $('#addNewTableItem').modal('hide');
        $('#createNewModal').modal('show');
        // Add new item to table
        insRow(item_name, item_description, item_price);
    }
});