<?php

require_once('App/Controller/external/fpdf.php');

$pdf = new FPDF();
$pdf->AddPage();

// Logo
$pdf->Image('Assets/Images/tripuplogo.png', 10, 6, 30); // Path to logo image file

// Invoice title
$pdf->SetFont('Arial', 'B', 24);
$pdf->Cell(0, 20, 'INVOICE', 0, 1, 'C');

// Company Info
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 6, 'TripUp', 0, 1);
$pdf->Cell(0, 6, 'Address: 143, Road 01, Avenue 01, Mirpur DOHS.', 0, 1);
$pdf->Cell(0, 6, 'Contact: 01897713000', 0, 1);

// Invoice Info
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 6, 'Payment Date: January 7, 2024', 0, 1);
$pdf->Cell(0, 6, 'Payment Status: Partially Paid (Bkash)', 0, 1);
$pdf->Cell(0, 6, 'Due Date: February 3, 2024', 0, 1);

// Customer Details
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 6, 'Customer Details', 0, 1);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 6, 'Name: Md Tarequr Rahman', 0, 1);
$pdf->Cell(0, 6, 'Contact: 01923680581', 0, 1);
$pdf->Cell(0, 6, 'Email: tfrak9786@gmail.com', 0, 1);

// Items Table
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 10, 'Item Details', 0, 1);
// Headers
$pdf->Cell(50, 7, 'Item Name', 1, 0);
$pdf->Cell(65, 7, 'Details', 1, 0);
$pdf->Cell(30, 7, 'Trip Date', 1, 0);
$pdf->Cell(20, 7, 'Person', 1, 0);
$pdf->Cell(25, 7, 'Amount', 1, 1);
// Data
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(50, 7, 'Saint Martin', 1, 0);
$pdf->Cell(65, 7, 'Dwipantor Beach Resort', 1, 0);
$pdf->Cell(30, 7, 'Jan 3rd - Jan 4th', 1, 0);
$pdf->Cell(20, 7, '2', 1, 0);
$pdf->Cell(25, 7, '6450', 1, 1);

// Totals
$pdf->Cell(165, 7, 'Total', 1, 0);
$pdf->Cell(25, 7, '6450', 1, 1);
$pdf->Cell(165, 7, 'Advance Paid', 1, 0);
$pdf->Cell(25, 7, '3300', 1, 1);
$pdf->Cell(165, 7, 'Due', 1, 0);
$pdf->Cell(25, 7, '3150', 1, 1);

// Terms & Policy
$pdf->Ln(10);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 10, 'Terms & Policy', 0, 1);
$pdf->SetFont('Arial', '', 10);
$pdf->MultiCell(0, 10, "• The due amount must be paid at the time of check-in.\n• Booking money is not refundable.\n• In the event of political turmoil or natural disaster, we will reconsider the policy and shift (booking date) based on the circumstances.\n• If guests want to change their reservation date, may be moved to the next available date. However, you must let us know a week before your scheduled booking. If you choose to shift, 30% of your reservation fee will be deducted automatically.");

$pdf->Output();




// ==============================================


// $pdf = new FPDF();
// $pdf->AddPage();

// $pdf->SetFont('Arial', 'B', 20);
// $pdf->Cell(71, 10, '', 0, 0);
// $pdf->Cell(55, 5, 'RECEIPT', 0, 0, 'C');
// $pdf->Cell(59, 10, '', 0, 1);

// $pdf->SetFont('Arial', 'B', 15);
// $pdf->Cell(71, 5, 'WET', 0, 0);
// $pdf->Cell(59, 5, '', 0, 0);
// $pdf->Cell(59, 5, 'Details', 0, 1);

// $pdf->SetFont('Arial', '', 10);

// $pdf->Cell(130, 5, 'Near DAV', 0, 0);
// $pdf->Cell(25, 5, 'Customer ID', 0, 0);
// $pdf->Cell(34, 5, '0012', 0, 1);

// $pdf->Cell(130, 5, '', 0, 0);
// $pdf->Cell(25, 5, 'Invoice No:', 0, 0);
// $pdf->Cell(34, 5, '123456', 0, 1);

// $pdf->SetFont('Arial', 'B', 15);
// $pdf->Cell(130, 5, 'Bill To', 0, 0);
// $pdf->Cell(59, 5, '', 0, 0);
// $pdf->SetFont('Arial', 'B', 10);
// $pdf->Cell(189, 10, '', 0, 1);

// $pdf->Cell(50, 10, '', 0, 1);

// $pdf->SetFont('Arial', 'B', 10);
// // Header starts ///
// $pdf->Cell(30, 6, 'ID', 1, 0, 'C');
// $pdf->Cell(40, 6, 'Item Name', 1, 0, 'C');
// $pdf->Cell(90, 6, 'Item Description', 1, 0, 'C');
// $pdf->Cell(30, 6, 'Amount', 1, 1, 'C');
// // Header ends ///

// $pdf->SetFont('Arial', '', 10);
// for ($i = 1; $i <= 15; $i++) {
//     $pdf->Cell(30, 6, $i, 1, 0, 'C');
//     $pdf->Cell(40, 6, 'Item Name', 1, 0, 'C');
//     $pdf->Cell(90, 6, 'Item Description', 1, 0, 'C');
//     $pdf->Cell(30, 6, '10000 BDT', 1, 1, 'R');
// }

// $pdf->SetFont('Arial', 'B', 10);
// $pdf->Cell(160, 6, 'Total:', 0, 0, 'R');
// $pdf->Cell(30, 6, '300000 BDT', 0, 1, 'R');

// $pdf->Cell(160, 6, 'Advance Paid:', 0, 0, 'R');
// $pdf->Cell(30, 6, '10000 BDT', 0, 1, 'R');

// $pdf->Cell(160, 6, 'Due:', 0, 0, 'R');
// $pdf->Cell(30, 6, '290000 BDT', 0, 1, 'R');




$pdf->Output();


/*
<?php

require_once('App/Controller/external/fpdf.php');

$pdf = new FPDF();
$pdf->AddPage();

// Title
$pdf->SetFont('Arial', 'B', 20);
$pdf->Cell(0, 10, 'RECEIPT', 0, 1, 'C');

// Company Name
$pdf->SetFont('Arial', 'B', 15);
$pdf->Cell(0, 10, 'WET', 0, 1, 'C');

// Details
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 5, 'Near DAV', 0, 1);
$pdf->Cell(0, 5, 'Customer ID: 0012', 0, 1);
$pdf->Cell(0, 5, 'Invoice No: 123456', 0, 1);

// Spacing
$pdf->Ln(10);

// Header
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(30, 6, 'ID', 1, 0, 'C');
$pdf->Cell(40, 6, 'Item Name', 1, 0, 'C');
$pdf->Cell(90, 6, 'Item Description', 1, 0, 'C');
$pdf->Cell(30, 6, 'Amount', 1, 1, 'C');

// Items
$pdf->SetFont('Arial', '', 10);
for ($i = 1; $i <= 15; $i++) {
    $pdf->Cell(30, 6, $i, 1, 0, 'C');
    $pdf->Cell(40, 6, 'Item Name', 1, 0);
    $pdf->Cell(90, 6, 'Item Description', 1, 0);
    $pdf->Cell(30, 6, '10000 BDT', 1, 1, 'R');
}

// Totals
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(160, 6, 'Total:', 0, 0, 'R');
$pdf->Cell(30, 6, '300000 BDT', 0, 1, 'R');

$pdf->Cell(160, 6, 'Advance Paid:', 0, 0, 'R');
$pdf->Cell(30, 6, '10000 BDT', 0, 1, 'R');

$pdf->Cell(160, 6, 'Due:', 0, 0, 'R');
$pdf->Cell(30, 6, '290000 BDT', 0, 1, 'R');

$pdf->Output();

*/