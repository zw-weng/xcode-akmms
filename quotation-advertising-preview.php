<?php
require_once('includes/fpdf/fpdf.php');

$pdf = new FPDF();
$pdf->AddPage();

// Add a logo (adjust the width and height as needed)
$pdf->Image('C:/xampp/htdocs/akmms/includes/logo.png', 10, 10, 50, 0);

// Add the address (right-aligned)
$pdf->SetFont('Arial','',8);
$pdf->SetXY(152, 10); // Set the position of the address. Adjust as needed.
$pdf->MultiCell(0,4,"AK MAJU RESOURCES SDN. BHD.\nNo. 39 & 41, Jalan Utama 3/2, Pusat Komersial Sri Utama,\nSegamat, Johor, Malaysia- 85000\n07-9310717, 010-2218224\nakmaju.acc@gmail.com\nCompany No : 1088436 K",0);

// Add a title (centered)
$pdf->SetFont('Arial','B',16);
$currentY = $pdf->GetY(); // Get the current y-axis position
$newY = $currentY + 4; // Add 10 to the current y-axis position
$pdf->SetY($newY); // Set the new y-axis position
$pdf->Cell(0,1,'Quotation',0,1,'C');
$pdf->Line(0, 45, 220, 45); // Draw a line from (20,20) to (180,20)

//Add Customer Details


// Add a greeting (left-aligned)
$pdf->SetFont('Arial','',8);
$pdf->Cell(0,10,'Dear Sir/Madam,',0,1,'L');
$pdf->Cell(0,10,'Here is our Quotation generated for your perusal.',0,1,'L');

// Add item details in a table
$pdf->Cell(0,10,'ITEM DETAILS',1,1); // Table header
$pdf->Cell(30,10,'S.NO',1);
$pdf->Cell(50,10,'ITEM CODE',1);
$pdf->Cell(80,10,'DESCRIPTION',1);
$pdf->Cell(30,10,'QUANTITY',1,1); // End of row


// Replace the following line with a loop that fetches your actual data
$pdf->Cell(30,10,'1',1);
$pdf->Cell(50,10,'1',1);
$pdf->Cell(80,10,'Book printing',1);
$pdf->Cell(30,10,'400',1,1); // End of row

$pdf->Cell(30,10,'2',1);
$pdf->Cell(50,10,'2',1);
$pdf->Cell(80,10,'Poster of competition',1);
$pdf->Cell(30,10,'10',1,1); // End of row

// Output the PDF with a name based on the delivery_id
$delivery_id = 'YOUR_DELIVERY_ID_HERE';
$pdf->Output($delivery_id . '.pdf', 'I');
?>
