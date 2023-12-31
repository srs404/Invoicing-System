// Function to show the selected form based on the dropdown value
function showForm() {
    var formType = document.getElementById("formType").value;
    var dynamicFormContainer = document.getElementById("identifier");

    // Clear previous form content
    // dynamicFormContainer.innerHTML = "";

    // Dynamically add the selected form
    if (formType === "invoice") {
        // alert("Invoice form is not available yet");
        dynamicFormContainer.value = "INV-2021-0001";
    } else if (formType === "receipt") {
        dynamicFormContainer.value = "2023-0001";
    } else if (formType === "Quotation") {
        dynamicFormContainer.innerHTML = `
        <form class="row g-3 needs-validation" novalidate>
            <div class="col-md-4 position-relative">
                <label for="validationTooltip01" class="form-label">First name</label>
                <input type="text" class="form-control" id="validationTooltip01" placeholder="Sami" required>
                <div class="valid-tooltip">
                    Looks good!
                </div>
            </div>
            <div class="col-md-4 position-relative">
                <label for="validationTooltip02" class="form-label">Last name</label>
                <input type="text" class="form-control" id="validationTooltip02" placeholder="Rahman" required>
                <div class="valid-tooltip">
                    Looks good!
                </div>
            </div>
            <div class="col-md-4 position-relative">
                <label for="validationTooltipUsername" class="form-label">Username</label>
                <div class="input-group has-validation">
                    <span class="input-group-text" id="validationTooltipUsernamePrepend">+880</span>
                    <input type="number" max="1999999999" placeholder="1625469920" class="form-control" id="validationTooltipUsername" aria-describedby="validationTooltipUsernamePrepend" required>
                    <div class="invalid-tooltip">
                        Please choose a unique and valid username.
                    </div>
                </div>
            </div>
        </form>
    `;

    }
    // Add more conditions for additional form types
}