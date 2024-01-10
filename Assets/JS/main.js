// Function to show the selected form based on the dropdown value
$(function () {
    $('#datetimepicker1').datetimepicker();
});

// NOTE: Onchange Discount will disable the Payable Amount Input Field And Calculate the Discounted Price
$('#discount').on('input', function () {
    if ($(this).val() !== '' && $(this).val() !== null && $(this).val() !== 0 && $(this).val() !== '0') {
        let originalPrice = parseInt(document.getElementById('subtotal').value);
        var discountAmount = (parseInt(document.getElementById('discount').value) / 100) * originalPrice;
        var discountedPrice = originalPrice - discountAmount;
        document.getElementById('total-payable').value = discountedPrice;
        document.getElementById('total-payable').disabled = true;
    } else {
        document.getElementById('discount').value = '';
        document.getElementById('total-payable').value = '';
        document.getElementById('total-payable').disabled = false;
    }
});

// NOTE: Onchange Payable Amount will disable the Discount Input Field And Calculate the Discounted Price
$('#total-payable').on('input', function () {
    if ($(this).val() !== '' && $(this).val() !== null && $(this).val() !== 0 && $(this).val() !== '0') {
        let originalPrice = parseFloat(document.getElementById('subtotal').value);
        var discountValue = parseFloat(document.getElementById('total-payable').value);

        // Convert discount value to percentage
        var discountPercentage = (discountValue / originalPrice) * 100;

        // Calculate discounted price
        var discountedPrice = discountPercentage.toFixed(2);
        document.getElementById('discount').value = discountedPrice;
        document.getElementById('discount').disabled = true;
    } else {
        document.getElementById('total-payable').value = '';
        document.getElementById('discount').value = '';
        document.getElementById('discount').disabled = false;
    }
});

// TODO: Subtotal Calculator
function subtotalCalculator(option) {
    if (option === 'new') {
        document.getElementById('subtotal').value = parseInt(document.getElementById('subtotal').value) + 9600;
    } else {
        if (this.value < 1) {
            this.value = '100';
        }
        let sum = 0;
        let prices = document.querySelectorAll('#item-price');

        for (let i = 0; i < prices.length; i++) {
            sum += parseInt(prices[i].value) || 0; // Ensure to add 0 if the value is not a valid number
        }

        document.getElementById('subtotal').value = sum;
    }

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
function insRow() {
    var table = document.getElementById('item-table');

    var x = table.rows.length;
    var id = "tbl" + x;
    var row = table.insertRow(x);
    row.id = id;
    var cell1 = row.insertCell(0);
    var cell2 = row.insertCell(1);
    var cell3 = row.insertCell(2);
    var cell4 = row.insertCell(3);
    cell1.outerHTML = `<td style="width: 250px;">
    <select class="form-select" id="formType" required>
        <option selected disabled value="">Choose...</option>
        <option value="hotel-resort">Hotel/Resort</option>
        <option value="Ship">Ship</option>
        <option value="Flight">Flight</option>
        <option value="Package">Package</option>
        <option value="Bus">Bus</option>
    </select>
</td>`;
    cell2.innerHTML = '<td><textarea type="text" class="form-control" style="height: 2px;" id="item-description" placeholder="Item Description" required></textarea></td>';
    cell3.innerHTML = `<td>
    <div class="input-group mb-3">
        <span class="input-group-text">BDT</span>
        <input type="number" class="form-control" style="text-align: right;" onchange="subtotalCalculator()"
            id="item-price" value="9600" disabled aria-label="Item Quantity">
        <span class="input-group-text">৳</span>
    </div>
</td>`;
    cell4.innerHTML = `<td>
    <button class="btn btn-danger btn-sm" onclick="deleteRow(this)"><span
            class="fa fa-trash"></span></button>
    <button class="btn btn-success btn-sm" onclick="subtotalCalculator('new'); insRow()"><span
            class="fa fa-plus"></span></button>
</td>`;

    x.appendChild(new_row);
}


// Delete Row
// Additional: Don't delete the first row
function deleteRow(row) {
    var i = row.parentNode.parentNode.rowIndex;
    if (i == 1) {
        return;
    } else {
        document.getElementById('item-table').deleteRow(i);
    }
    subtotalCalculator();
}