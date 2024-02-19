<?php 
include('mysession.php');
  if(!session_id())
  {
    session_start();
  }
include('includes/fpdf/fpdf.php');                                       
include('dbconnect.php');

class PDF extends FPDF
{
// Load data
function LoadData($file)
{
    // Read file lines
    $lines = file($file);
    $data = array();
    foreach($lines as $line)
        $data[] = explode(';',trim($line));
    return $data;
}  

// Colored table
function FancyTable($header, $data)
{
    // Colors, line width and bold font
    $this->SetFillColor(255,0,0);
    $this->SetTextColor(255);
    $this->SetDrawColor(128,0,0);
    $this->SetLineWidth(.3);
    $this->SetFont('','B');
    // Header
    $w = array(25, 40, 40, 40, 45);
    for($i=0;$i<count($header);$i++)
        $this->Cell($w[$i],7,$header[$i],1,0,'C',true);
    $this->Ln();
    // Color and font restoration
    $this->SetFillColor(224,235,255);
    $this->SetTextColor(0);
    $this->SetFont('');
    // Data
    $fill = false;
    foreach($data as $row)
    {
        $this->Cell($w[0],6,$row[0],'LR',0,'L',$fill);
        $this->Cell($w[1],6,$row[1],'LR',0,'L',$fill);
        $this->Cell($w[2],6,$row[2],'LR',0,'L',$fill);
        $this->Cell($w[3],6,number_format($row[3]),'LR',0,'R',$fill);
        $this->Cell($w[4],6,$row[4],'LR',0,'R',$fill);
        $this->Ln();
        $fill = !$fill;
    }
    // Closing line
    $this->Cell(array_sum($w),0,'','T');
}
}





if (isset($_GET['start_date']) && isset($_GET['end_date'])) {
    // Get the selected start date and end date
    $startDate = $_GET['start_date'];
    $endDate = $_GET['end_date'];


 $sqlc = "SELECT payment_date FROM tb_payment
          WHERE payment_date BETWEEN '$startDate' AND '$endDate'";

    $resultc = mysqli_query($con, $sqlc);
    
$sql = "SELECT * FROM tb_payment
JOIN tb_paymenttype ON tb_payment.payment_type_id = tb_paymenttype.payment_type_id
WHERE payment_date BETWEEN '$startDate' AND '$endDate' AND payment_status=1"; // Replace $quotation_id with the actual quotation ID
$result = mysqli_query($con, $sql);

if (!$result) {
    die("Query failed: " . mysqli_error($con));
}
}

$pdf = new PDF(); 
$pdf -> AddPage();
// Add a logo (adjust the width and height as needed)
$pdf->Image('includes/logo.png', 10, 10, 40, 0);

// Add the address (right-aligned)
$pdf->SetFont('Arial','',10);
$pdf->SetXY(130, 10); // Set the position of the address. Adjust as needed.
$pdf->MultiCell(0,4,"AK MAJU RESOURCES SDN. BHD.\nNo. 39 & 41, Jalan Utama 3/2, Pusat \nKomersial Sri Utama,Segamat, \nJohor, Malaysia- 85000\n07-9310717, 010-2218224\n\nEmail : akmaju.acc@gmail.com\nCompany No : 1088436 K",0);

// Add a title (centered)
$pdf->SetFont('Arial','B',16);
$currentY = $pdf->GetY(); // Get the current y-axis position
$newY = $currentY + 13; // Add 10 to the current y-axis position
$pdf->SetY($newY); // Set the new y-axis position
$pdf->Cell(0,1,'Transaction Listing By Payment ID',0,1,'C');
$pdf->Line(0, 60, 220, 60); // Draw a line from (20,20) to (180,20)


$currentY = $pdf->GetY(); // Get the current y-axis position
$newY = $currentY + 8; // Add 10 to the current y-axis position
$pdf->SetY($newY); // Set the new y-axis position
$header = array('Payment ID', 'Customer Name', 'Payment Type', 'Payment Amount','Payment Date');
// Data loading

if ($result) {
    $data = array();
    if ($resultc){
        $rowc = mysqli_fetch_assoc($resultc);

    // Fetch each row from the result set
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = array(
            $row['payment_id'],
            $row['client_name'],
            $row['payment_type_desc'],
            $row['payment_amount'],
            $row['payment_date']
        );
    }
    
}else{
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = array(
            $row['payment_id'],
            $row['client_name'],
            $row['payment_type_desc'],
            $row['payment_amount'],
            $row['payment_date']
        );
}
}
}
$pdf->SetFont('Arial','',12);
$pdf->FancyTable($header,$data);
$pdf->Output();

?>