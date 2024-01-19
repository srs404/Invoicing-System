<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print </title>
    <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@400;600&display=swap" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- Stylesheet -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../Assets/CSS/receipt-main.css">
</head>

<body>

    <div class="mainCircleLogo">
        <img src="tripuplogocircle.png" loading="lazy" width="400px">
    </div>

    <div class="receiptTopPart">
        <div class="receiptTopLeftPart">
            <img src="data:image/png;base64,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" width="200px" alt="TripUp Logo">

            <p style="font-weight: bold; margin-top: 25px; color: #1965af;">Address: <span id="dynamicAddress" style="font-weight: normal; color: black;">143,
                    Road 01, Avenue 01,
                    Mirpur DOHS.</span>
                <br>Contact: <span id="dynamicContact" style="color: black; font-weight: normal;">+880
                    1234 567 890</span>
            </p>
            <p style="margin-top: 20px; text-align: left;">
            <h3 style="font-weight: bold;">Customer Details</h3>
            <table class="table customerDetailsTable" style="width: 250px;">
                <tr class="border-0">
                    <td class="noborder" style="font-weight: bold;">Name:</td>
                    <td class="noborder" id="dynamicCustomerName" style="font-weight: normal;">
                        Anisul Hoque
                    </td>
                </tr>
                <tr class="border-0">
                    <td class="noborder" style="font-weight: bold;">Contact:
                    </td>
                    <td class="noborder" id="dynamicCustomerContact" style="font-weight: normal;">
                        +880 1234
                        567 890</td>
                </tr>
                <tr class="border-0">
                    <td class="noborder" style="font-weight: bold;">Email:</td>
                    <td class="noborder" id="dynamicCustomerEmail" style="font-weight: normal;">
                        demo@email.com</td>
                </tr>
            </table>
            </p>
        </div>
        <div class="receiptTopRightPart">
            <div style="text-align: right; margin-top: 30px;">
                <h3 style="font-size: 34px; font-weight: bold;">RECEIPT</h3>
                <h3 style="font-weight: 500;" id="DynamicInvoiceNumber">070124-001
                </h3>
            </div>
            <div style="margin-top: 20px;" class="table-responsive-sm">
                <table class="table">
                    <tr>
                        <td style="font-weight: bold; border: none; text-align: right;">
                            Payment Date:
                        </td>
                        <td class="border-0" id="dynamicPaymentDate">07 January 2021</td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold; border: none; text-align: right;">
                            Payment Status:
                        </td>
                        <td class="border-0" id="dynamicPaymentMethod">Partially Paid (Bkash)</td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold; border: none; text-align: right;">
                            Due Date:</td>
                        <td class="border-0" id="dynamicDueDate">15 February 2024</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>


    <div class="receiptMiddlePart">
        <table class="table itemReceiptTable">
            <thead class="">
                <tr>
                    <th style="max-width: 10%;">#</th>
                    <th style="max-width: 30%;">Item Name</th>
                    <th style="max-width: 40%;">Item Description</th>
                    <th style="max-width: 20%;">Amount</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="border-0" id="dynamicItemDescription">1</td>
                    <td class="border-0" id="dynamicItemQuantity">Hotel/Resort</td>
                    <td class="border-0" id="dynamicItemUnitPrice">Demo Description</td>
                    <td class="border-0" id="dynamicItemSubtotal"><span class="dynamicItemSubtotalAmount">5000</span> BDT</td>
                </tr>
                <tr>
                    <td class="border-0" id="dynamicItemDescription">2</td>
                    <td class="border-0" id="dynamicItemQuantity">Ship</td>
                    <td class="border-0" id="dynamicItemUnitPrice">Dwipantor Beach Resort
                        Premium Couple Cottage (Sea
                        View)
                        BDT 6450 per night</td>
                    <td class="border-0" id="dynamicItemSubtotal"><span class="dynamicItemSubtotalAmount">5000</span> BDT</td>
                </tr>
            </tbody>
        </table>

        <div class="col-12 d-flex justify-content-end">
            <div class="card border-0">
                <div class="card-body">
                    <table class="table subtotalTable">
                        <tbody>
                            <tr>
                                <td>
                                    Subtotal</td>
                                <td><span class="dynamicSubtotalAmount" style="font-weight: normal;">: 5,000</span> BDT</td>
                            </tr>
                            <tr>
                                <td>
                                    Advance Paid</td>
                                <td><span class="dynamicAdvanceAmount" style="font-weight: normal;">: 3,300</span> BDT</td>
                            </tr>
                            <tr>
                                <td>Due
                                </td>
                                <td><span class="dynamicDueAmount" style="font-weight: normal;">: 1,700</span> BDT</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>


        <p style="font-weight: bold;">Terms & Policy:</p>
        <ul>
            <li>The due amount must be paid at the time of check-in.</li>
            <li>Booking money is not refundable.</li>
            <li>In the event of political turmoil or natural disaster, we will
                reconsider the policy and shift (booking date)
                based on the circumstances.</li>
            <li>If guests want to change their reservation date, may be moved to the
                next available date. However, you
                must let us know a week before your scheduled booking. If you choose to
                shift, 30% of your reservation
                fee will be deducted automatically.</li>
        </ul>
    </div>






    <!-- Bootstrap JS and Popper.js (optional) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="../Assets/JS/pdf.js"></script>
</body>

</html>