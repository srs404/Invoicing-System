<?php

require_once('App/Controller/external/fpdf.php');

$pdf = new FPDF();
$pdf->AddPage();

$pdf->SetFont('Arial', 'B', 20);
$pdf->Cell(71, 10, '', 0, 0);
$pdf->Cell(55, 5, 'RECEIPT', 0, 0, 'C');
$pdf->Cell(59, 10, '', 0, 1);
$pdf->Output();
