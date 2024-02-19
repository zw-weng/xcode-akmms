<?php
include('mysession.php');
if (!session_id()) {
  session_start();
}
require('includes/fpdf/mc_table.php');

include 'dbconnect.php'; 
if (isset($_GET['quotation_id'])) {
    $quotation_id = $_GET['quotation_id'];
} else {
    // Handle the case where no quotation_id is provided
    echo "No quotation_id provided";
    exit();
}

$pdf = new PDF_MC_Table();

$pdf->AddPage();

$pdf->Image('includes/logo.png', 10, 10, 30, 0);
$query = "SELECT tb_product.product_name, tb_product.product_qty, tb_product.disc, tb_product.disc_amount, tb_product.tax_code, tb_product.tax_amount, tb_product.product_price, tb_product.product_subtotal, tb_quotation.quotation_id, tb_quotation.quotation_date, tb_paymentterm.payment_term_desc, tb_customer.cust_name, CONCAT(tb_customer.cust_street, ', ', tb_customer.cust_postcode, ', ', tb_customer.cust_city, ', ', tb_customer.cust_state, ', ', tb_customer.cust_country) AS customer_address, tb_invoice.invoice_id, tb_invoice.invoice_amount_payable, tb_invoice.invoice_balance, tb_invoice.invoice_upfront, tb_invoice.invoice_date,tb_deliveryorder.delivery_id, tb_salesorder.order_id

FROM tb_product
JOIN tb_quotation ON tb_product.quotation_id = tb_quotation.quotation_id
JOIN tb_paymentterm ON tb_quotation.payment_term_id = tb_paymentterm.payment_term_id
JOIN tb_customer ON tb_quotation.cust_id = tb_customer.cust_id
JOIN tb_invoice ON tb_quotation.quotation_id = tb_invoice.quotation_id
JOIN tb_deliveryorder ON tb_quotation.quotation_id = tb_deliveryorder.quotation_id
JOIN tb_salesorder ON tb_quotation.quotation_id = tb_salesorder.quotation_id
WHERE tb_quotation.quotation_id = $quotation_id";

 // Replace $quotation_id with the actual 
$result = mysqli_query($con, $query);
$row = mysqli_fetch_assoc($result);

// Write data to PDF

// Add the address (right-aligned)
$pdf->SetFont('Arial','',8);
$pdf->SetXY(152, 10); // Set the position of the address. Adjust as needed.
$pdf->MultiCell(0,3.5,"AK MAJU RESOURCES SDN. BHD.\nMAYBANK 551052384209\nakmaju.acc@gmail.com\nNo. 39 & 41, Jalan Utama 3/2, Pusat Komersial Sri Utama,\nSegamat, Johor, Malaysia- 85000\n07-9310717, 010-2218224\nCompany No : 1088436 K",0);

// Add a title (centered)
$pdf->SetFont('Arial','B',16);
$currentY = $pdf->GetY(); // Get the current y-axis position
$newY = $currentY + 4; // Add 10 to the current y-axis position
$pdf->SetY($newY); // Set the new y-axis position
$pdf->Cell(0,1,'Invoice',0,1,'C');
$pdf->Line(0, 45, 220, 45); // Draw a line from (20,20) to (180,20)

//Add Customer Details
$pdf->SetXY(15,50); // Set the new y-axis position
$pdf->SetFont('Arial','',8);
$pdf->Cell(0,4,'To:',0,1,'L');

$pdf->SetXY(15,50); // Set the new y-axis position
$pdf->SetFont('Arial','',8);
$pdf->Cell(0,4,'To:',0,1,'L');
$pdf->SetXY(15,55);
$pdf->SetFont('Arial','B',8);
$pdf->MultiCell(0,1,$row['cust_name'],0,1);
$pdf->SetXY(15,58);
$pdf->SetFont('Arial','',6);
$pdf->MultiCell(0,1,$row['customer_address'],0,1);

$pdf->SetXY(129.5, 50);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(50,4,'INVOICE NO',0,1,'L');
$pdf->SetXY(130, 50);
$pdf->SetFont('Arial','',6);
$pdf->Cell(50,4,$row['invoice_id'],0,1,'R');

$pdf->SetXY(129.5, 53);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(60.7,4,'INVOICE DATE',0,1,'L');
$pdf->SetXY(140, 53);
$pdf->SetFont('Arial','',6);
$pdf->Cell(47.5,4,$row['invoice_date'],0,1,'R');

$pdf->SetXY(129.5, 56);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(66.4,4,'SST REGISTRATION    NO.',0,1,'L');
$pdf->SetFont('Arial','',6);
$pdf->SetXY(174.7, 56);
$pdf->Cell(0,4,'000',0,1,'L');

$pdf->SetFont('Arial','B',8);
$pdf->SetXY(129.5, 59); 
$pdf->Cell(57.6,4,'TERMS OF  PAYMENT',0,1,'L');
$pdf->SetXY(174.7, 59); 
$pdf->SetFont('Arial','',6);
$pdf->Cell(0,4,$row['payment_term_desc'],0,1,'L');

$pdf->SetFont('Arial','B',8);
$pdf->SetXY(129.5, 62); 
$pdf->Cell(57.6,4,'PO. NO',0,1,'L');
$pdf->SetXY(174.7, 62); 
$pdf->SetFont('Arial','',6);
$pdf->Cell(0,4,$row['order_id'],0,1,'L');

$pdf->SetFont('Arial','B',8);
$pdf->SetXY(129.5, 65); 
$pdf->Cell(57.6,4,'DO. NO',0,1,'L');
$pdf->SetXY(174.7, 65); 
$pdf->SetFont('Arial','',6);
$pdf->Cell(0,4,$row['delivery_id'],0,1,'L');

$pdf->SetXY(157,88);
$pdf->SetFont('Arial','B',8);
 $pdf->MultiCell(15,4,'TAX AMOUNT',0,'C');
$pdf->SetXY(128,88);
$pdf->SetFont('Arial','B',8);
 $pdf->MultiCell(15,4,'DISC AMOUNT',0,'C');

$pdf->SetXY(15,58);
$pdf->SetFont('Arial','',6);
// Add a greeting (left-aligned)
$pdf->SetFont('Arial','',8);
$pdf->Cell(0,25,'Dear Sir/Madam,',0,1,'L');
$pdf->SetXY(15, 73); 
$pdf->Cell(0,4,'Here is your Invoice generated for your perusal.',0,1,'L');

// Add item details in a table
$pdf->SetFont('Arial','B',8);
$pdf->Cell(0,10,'ITEM DETAILS',1,1); // Table header
$pdf->Cell(10,10,'S.NO',1);
$pdf->Cell(52,10,'ITEM DESCRIPTION',1,0);
$pdf->Cell(16.5,10,'QUANTITY',1,0);
$pdf->Cell(26,10,'UNIT PRICE(RM)',1,0);
$pdf->Cell(12.5,10,'DISC %',1,0);
$pdf->Cell(17,10,'',1,0);
$pdf->Cell(12,10,'TAX',1,0,'C');
$pdf->Cell(17,10,'',1,0,'C');
$pdf->Cell(27,10,'TOTAL INCL. TAX',1,0);
$pdf->SetFont('Arial','',8);
$pdf->Ln(); // Go to the next line
// Replace the following line with a loop that fetches your actual data
$result = mysqli_query($con, $query);
// Initialize S.No
$s_no = 1;
$grandTotalTax = 0;
$grandTotalInclTax = 0;
$invoice_upfront = 0;
$invoice_id = 0;


// Set column widths
$pdf->SetWidths(array(10, 52, 16.5, 26, 12.5, 17, 12, 17, 27));

while ($row = mysqli_fetch_assoc($result)) {
    
    $pdf->Row(array(
        $s_no,
        $row['product_name'],
        $row['product_qty'],
        $row['product_price'],
        $row['disc'],
        $row['disc_amount'],
        $row['tax_code'],
        $row['tax_amount'],
        $row['product_subtotal']
    ));
    $grandTotalTax += $row['tax_amount'];
    $grandTotalInclTax += $row['product_subtotal'];
    $invoice_upfront = $row['invoice_upfront'];
    $invoice_id = $row['invoice_id'];
    $s_no++; // Increment S.No
}

$pdf->Cell(104.5,18,'',0,0);
$pdf->Cell(41.5,18,'GRAND TOTAL',1,0,'R');
$pdf->Cell(17,18,$grandTotalTax,1,0,'R');
$pdf->Cell(27,18,$grandTotalInclTax,1,0,'R');
$pdf->Ln();

// Add amount payable
$pdf->Cell(104.5,18,'',0,0);
$pdf->Cell(58.5,10,'AMOUNT PAYABLE',1, 0, 'R');
$pdf->Cell(27,10,$grandTotalInclTax,1,1,'R');

// Add upfront amount
$pdf->Cell(104.5,18,'',0,0);
$pdf->Cell(58.5,10,'UP FRONT',1, 0, 'R');
$pdf->Cell(27,10,$invoice_upfront,1,1,'R');


$formatted_balance = number_format($grandTotalInclTax - $invoice_upfront, 2, '.', '');

// Add balance
$pdf->Cell(104.5,18,'',0,0);
$pdf->Cell(58.5,10,'BALANCE',1, 0, 'R');
$pdf->Cell(27,10,$formatted_balance,1,1,'R');


$pdf->SetXY(25, 270);
$pdf->Cell(0,1,'PREPARED BY',0,1,'L');
$pdf->Line(23, 265, 45, 265);
$pdf->SetXY(70, 270);
$pdf->Line(68, 265, 90, 265);
$pdf->Cell(0,1,'CHECKED BY',0,1,'L');
$pdf->SetXY(115, 270);
$pdf->Line(112, 265, 135, 265);
$pdf->Cell(0,1,'APPROVED BY',0,1,'L');
$pdf->SetXY(160, 270);
$pdf->Line(158, 265, 178, 265);
$pdf->Cell(0,1,'RECEIVED BY',0,1,'L');
$pdf->Line(0, 290, 210, 290);

$pdf->Output($invoice_id,'I');
?>

