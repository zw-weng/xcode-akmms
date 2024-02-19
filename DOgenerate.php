<?php 
include('mysession.php');
if (!session_id()) {
  session_start();
}
 include 'dbconnect.php'; 
 require('includes/fpdf/mc_table.php');
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
$query = "SELECT tb_product.product_id,tb_product.product_name, tb_product.product_qty, tb_product.disc, tb_product.disc_amount, tb_product.tax_code, tb_product.tax_amount, tb_product.product_price, tb_product.product_subtotal, tb_quotation.quotation_id, tb_quotation.quotation_date, tb_paymentterm.payment_term_desc, tb_customer.cust_name, CONCAT(tb_customer.cust_street, ', ', tb_customer.cust_postcode, ', ', tb_customer.cust_city, ', ', tb_customer.cust_state, ', ', tb_customer.cust_country) AS customer_address, tb_deliveryorder.delivery_id, tb_deliveryorder.order_id, tb_deliveryorder.quotation_id, tb_deliveryorder.do_date, tb_salesorder.order_id

FROM tb_product
JOIN tb_quotation ON tb_product.quotation_id = tb_quotation.quotation_id
JOIN tb_paymentterm ON tb_quotation.payment_term_id = tb_paymentterm.payment_term_id
JOIN tb_customer ON tb_quotation.cust_id = tb_customer.cust_id
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
$pdf->MultiCell(0,4,"AK MAJU RESOURCES SDN. BHD.\nNo. 39 & 41, Jalan Utama 3/2, Pusat Komersial Sri Utama,\nSegamat, Johor, Malaysia- 85000\n07-9310717, 010-2218224\nakmaju.acc@gmail.com\nCompany No : 1088436 K",0);

// Add a title (centered)
$pdf->SetFont('Arial','B',16);
$currentY = $pdf->GetY(); // Get the current y-axis position
$newY = $currentY + 4; // Add 10 to the current y-axis position
$pdf->SetY($newY); // Set the new y-axis position
$pdf->Cell(0,1,'Delivery Order',0,1,'C');
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
$pdf->Cell(50,4,'DELIVERY ORDER NO',0,1,'L');
$pdf->SetXY(130, 50);
$pdf->SetFont('Arial','',6);
$pdf->Cell(50,4,$row['delivery_id'],0,1,'R');

$pdf->SetXY(129.5, 53);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(60.7,4,'DELIVERY DATE',0,1,'L');
$pdf->SetXY(140, 53);
$pdf->SetFont('Arial','',6);
$pdf->Cell(47.5,4,$row['do_date'],0,1,'R');

$pdf->SetFont('Arial','B',8);
$pdf->SetXY(129.5, 56); 
$pdf->Cell(57.6,4,'TERMS OF  PAYMENT',0,1,'L');
$pdf->SetXY(174.7, 56); 
$pdf->SetFont('Arial','',6);
$pdf->Cell(0,4,$row['payment_term_desc'],0,1,'L');

$pdf->SetFont('Arial','B',8);
$pdf->SetXY(129.5, 59); 
$pdf->Cell(57.6,4,'PO. NO',0,1,'L');
$pdf->SetXY(174.7, 59); 
$pdf->SetFont('Arial','',6);
$pdf->Cell(0,4,$row['order_id'],0,1,'L');


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
$pdf->Cell(20,10,'ITEM CODE',1,0);
$pdf->Cell(82,10,'ITEM DESCRIPTION',1,0);
$pdf->Cell(78,10,'QUANTITY',1,0);
$pdf->Ln(); // Go to the next line
$pdf->SetFont('Arial','',8);
// Replace the following line with a loop that fetches your actual data
$result = mysqli_query($con, $query);
// Initialize S.No
$pdf->SetWidths(array(10, 20, 82, 78));

$s_no = 1;
$s_qty = 0;
while ($row = mysqli_fetch_assoc($result)) {
    $pdf->Row(array(
        $s_no,
        $row['product_id'],
        $row['product_name'],
        $row['product_qty']
    ));
    $s_qty += $row['product_qty'];
    $s_no++; // Increment S.No
}

$pdf->Cell(51,10,'',0,0);
$pdf->Cell(61,10,'TOTAL',1,0,'R');
$pdf->Cell(78,10,$s_qty,1,0,'R');
$pdf->Ln();





$pdf->SetXY(160, 270);
$pdf->Cell(0,1,'AUTHORISED SIGNATURE',0,1,'L');
$pdf->Line(159, 284, 200, 284);

$pdf->Output('deliveryorder','I');
?>

