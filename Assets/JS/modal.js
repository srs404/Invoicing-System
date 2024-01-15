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
    $('#createNewModal').modal('show');
});

// Close modal
$('#modalCloseBtn, #modalDiscardBtn').on('click', function () {
    $('#createNewModal').modal('hide');
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
    $('#createNewModal').modal('hide');
});

// Close Modal
$('#modalItemCloseBtn, #modalItemDiscardBtn').on('click', function () {
    $('#addNewTableItem').modal('hide');
    $('#createNewModal').modal('show');
});