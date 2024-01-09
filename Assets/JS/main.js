// Function to show the selected form based on the dropdown value
$(function () {
    $('#datetimepicker1').datetimepicker();
});

function itemQuatity(item, option) {

    // Find the corresponding textbox in the same group
    let item_quantity = item.parentElement.querySelector('#item-quantity');
    let default_price = item.parentElement.parentElement.parentElement.querySelector('#item-price');
    let total_price = item.parentElement.parentElement.parentElement.querySelector('#item-total');

    // var item_quantity = document.getElementById(item[0]);
    if (option === 'add') {
        item_quantity.value = parseInt(item_quantity.value) + 1;

        total_price.value = parseInt(item_quantity.value) * parseInt(default_price.value);
    } else if (option === 'minus') {
        if (item_quantity.value > 1) {
            item_quantity.value = parseInt(item_quantity.value) - 1;
            total_price.value = parseInt(item_quantity.value) * parseInt(default_price.value);
        } else {
            // Quantity Is Zero

        }
    }
}




function checkDate(option) {
    if (option === 'unlock-due-date') {
        if (document.getElementById("issued-date").value === "") {
            document.getElementById("due-date").disabled = true;
        } else if (document.getElementById("issued-date").value > document.getElementById("due-date").value && document.getElementById("due-date").value !== "") {
            document.getElementById("due-date").disabled = true;
            document.getElementById("due-date").value = "";
            alert("Due Date Cannot be earlier than Issued Date");
        } else {
            document.getElementById("due-date").disabled = false;
        }
    } else {
        var date = document.getElementById("issued-date").value;
        var date2 = document.getElementById("due-date").value;
        if (date2 < date) {
            alert("Due Date cannot be earlier than Issued Date");
            document.getElementById("due-date").value = "";
        }
    }
}


function deleteRow(row) {
    var i = row.parentNode.parentNode.rowIndex;
    document.getElementById('item-table').deleteRow(i);
}



function insRow() {
    var x = document.getElementById('item-table');
    var new_row = x.rows[1].cloneNode(true);
    x.appendChild(new_row);
}
