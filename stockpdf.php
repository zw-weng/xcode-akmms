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
    $w = array(25, 60, 40, 35, 35);
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
        $this->Cell($w[3],6,number_format($row[3],2),'LR',0,'R',$fill);
        $this->Cell($w[4],6,$row[4],'LR',0,'R',$fill);
        $this->Ln();
        $fill = !$fill;
    }
    // Closing line
    $this->Cell(array_sum($w),0,'','T');
}

}
/*
$pdf = new PDF();
// Column headings
$header = array('Country', 'Capital', 'Area (sq km)', 'Pop. (thousands)');
// Data loading
$data = [['America','Washington',123,346],
['Spain','Idunno',1123,3346],
];
$pdf->AddPage();
$pdf->SetFont('Arial','',14);
$pdf->FancyTable($header,$data);
$pdf->Output();
?>

<?php  */
//require_once('includes/fpdf/fpdf.php');

$sql = "SELECT item_id, item_name, item_qty, item_cost, item_price FROM tb_advertising WHERE item_status=1";
$result = mysqli_query($con, $sql);

$sql1 = "SELECT material_id, material_name, material_unit, material_cost FROM tb_construction";
$result1 = mysqli_query($con, $sql1);

$sqld = "SELECT SUM(item_qty) AS total FROM tb_advertising WHERE item_status=1";
$resultc = mysqli_query($con,$sqld);
$rowc = mysqli_fetch_assoc($resultc);

$sqle = "SELECT SUM(item_cost) AS total1 FROM tb_advertising WHERE item_status=1";
$resulte = mysqli_query($con,$sqle);
$rowe = mysqli_fetch_assoc($resulte);

$pdf = new PDF();
$pdf->AddPage();

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
$pdf->Cell(0,1,'Stock Balance',0,1,'C');
$pdf->Line(0, 60, 220, 60); // Draw a line from (20,20) to (180,20)

// Set the Y-axis position below the line
$pdf->SetY(65); // Adjust the Y-axis position based on your needs

// Change font for the total stock information
$pdf->SetFont('Arial', '', 10);

// Assuming $totalStock contains the total stock value
$totalstock = $rowc['total']; // Replace with your actual total stock value

// Add the total stock information
$pdf->Cell(0, 1, 'Balance Quantity: ' . $totalstock, 0, 1, 'L');

// Set the Y-axis position below the line
$pdf->SetY(65); // Adjust the Y-axis position based on your needs

// Change font for the total stock information
$pdf->SetFont('Arial', '', 10);

// Assuming $totalStock contains the total stock value
$stockvalue = $rowe['total1']; // Replace with your actual total stock value

// Add the total stock information
$pdf->Cell(0, 1, 'Balance Stock Value: RM ' . $stockvalue, 0, 1, 'R');

$currentY = $pdf->GetY(); // Get the current y-axis position
$newY = $currentY + 3; // Add 10 to the current y-axis position
$pdf->SetY($newY); // Set the new y-axis position
$header = array('Item ID', 'Item Name', 'Stock Level', 'Buying Price','Selling Price');
// Data loading
if ($result) {
    $data = array();

    // Fetch each row from the result set
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = array(
            $row['item_id'],
            $row['item_name'],
            $row['item_qty'],
            $row['item_cost'],
            $row['item_price']
        );
    }
}



$pdf->SetFont('Arial','',12);
$pdf->FancyTable($header,$data);

$pdf->Output();
?>