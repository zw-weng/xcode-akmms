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


    // Colored table
    function FancyTable($header, $data)
    {
        // Colors, line width and bold font
        $this->SetFillColor(255,0,0);
        $this->SetTextColor(255);

        $this->SetFont('','B');
        // Header
        $w = array(60, 40, 40);
        for ($i=0; $i<count($header); $i++)
            $this->Cell($w[$i], 7, $header[$i], 0, 0, 'C', true);
        $this->Ln();
        // Color and font restoration
        $this->SetFillColor(224,235,255);
        $this->SetTextColor(0);
        $this->SetFont('');
        // Data
        $fill = false;
         
        // Predefined values for the first column
        $firstColumnValues[] = array('SALES', 'COST OF SALES', 'GROSS PROFIT', 'OTHER EXPENSES', 'NET PROFIT');

        foreach ($data as $key => $row)
        {
            $row[0] = isset($firstColumnValues[$key]) ? $firstColumnValues[$key] : '';
        $this->Cell($w[1],6,$row[1],'LR',0,'L',0);
        $this->Cell($w[2],6,$row[2],'LR',0,'L',0);
        
        $this->Ln();
        $fill = !$fill;
        }
        // Closing line
        $this->Cell(array_sum($w), 0, '', 'T');
    }
}

if (isset($_GET['startdate']) && isset($_GET['enddate'])) {
    // Get the selected start date and end date
    $startDate = $_GET['startdate'];
    $endDate = $_GET['enddate'];

$sql = "SELECT SUM(item_cost) AS total1 FROM tb_advertising";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_assoc($result);

$sqla = "SELECT SUM(payment_amount) AS total2 FROM tb_payment WHERE payment_date BETWEEN '$startDate' AND '$endDate'";
$resulta = mysqli_query($con, $sqla);
$rowa = mysqli_fetch_assoc($resulta);
}

if (isset($_GET['startyeardate']) && isset($_GET['endyeardate'])) {
    // Get the selected start date and end date
    $startyearDate = $_GET['startyeardate'];
    $endyearDate = $_GET['endyeardate'];

$sqlb = "SELECT SUM(payment_amount) AS total3 FROM tb_payment WHERE payment_date BETWEEN '$startyearDate' AND '$endyearDate'";
$resultb = mysqli_query($con, $sqlb);
$rowb = mysqli_fetch_assoc($resultb);

}

$sales = $rowa['total2'];
$yearsales = $rowb['total3'];
$cost = $row['total1'];
$profit = $sales - $cost;
$profit1 = $yearsales - $cost;
$other = 0.00;
$netprofit = $profit - $other;
$netprofit1 = $profit1 - $other;
$formattedNetProfit = number_format($netprofit, 2);
$formattedNetProfit1 = number_format($netprofit1, 2);

$pdf = new FPDF();
$pdf->AddPage();

// Add a logo (adjust the width and height as needed)
$pdf->Image('includes/logo.png', 10, 10, 40, 0);

// Add the address (right-aligned)
$pdf->SetFont('Arial','',8);
$pdf->SetXY(152, 10); // Set the position of the address. Adjust as needed.
$pdf->MultiCell(0,4,"AK MAJU RESOURCES SDN. BHD.\nNo. 39 & 41, Jalan Utama 3/2, Pusat Komersial Sri Utama,\nSegamat, Johor, Malaysia- 85000\n07-9310717, 010-2218224\n\nEmail : akmaju.acc@gmail.com\nCompany No : 1088436 K",0);

// Add a title (centered)
$pdf->SetFont('Arial','B',16);
$currentY = $pdf->GetY(); // Get the current y-axis position
$newY = $currentY + 15; // Add 10 to the current y-axis position
$pdf->SetY($newY); // Set the new y-axis position
$pdf->Cell(0,1,'PROFIT AND LOSS (SUMMARY)',0,1,'C');
$pdf->Line(0, 60, 220, 60); // Draw a line from (20,20) to (180,20)

//Add Customer Details
// Add customer details on the left side


// Add invoice details on the right side

// Add a greeting (left-aligned)
$pdf->SetFont('Arial','',8);
$pdf->Cell(0,10,'Dear Sir/Madam,',0,1,'L');
$pdf->Cell(0,10,'Here is our Sales Report generated for your personal usage.',0,1,'L');

// Add item details in a table
$pdf->SetFillColor(255,0,0);
$pdf->Cell(50,10);
$pdf->Cell(70,10,'MONTHLY AMOUNT (RM)', 1, 0, 'C', 1);
$pdf->Cell(70,10,'YEARLY AMOUNT (RM)', 1, 1, 'C', 1); // End of row

// Replace the following line with a loop that fetches your actual data

$pdf->Cell(50,10,'SALES',1);
$pdf->Cell(70,10,$sales,1);
$pdf->Cell(70,10,$yearsales,1,1); // End of row

// Replace the following line with a loop that fetches your actual data

$pdf->Cell(50,10,'COST OF SALES',1);
$pdf->Cell(70,10,$cost,1);
$pdf->Cell(70,10,$cost,1,1); // End of row

// Replace the following line with a loop that fetches your actual data

$pdf->Cell(50,10,'GROSS PROFIT',1);
$pdf->Cell(70,10,$profit,1);
$pdf->Cell(70,10,$profit1,1,1); // End of row

// Replace the following line with a loop that fetches your actual data

$pdf->Cell(50,10,'OTHER EXPENSES',1);
$pdf->Cell(70,10,'0.00',1);
$pdf->Cell(70,10,'0.00',1,1); // End of row

// Replace the following line with a loop that fetches your actual data

$pdf->Cell(50,10,'NET PROFIT',1);
$pdf->Cell(70,10,$formattedNetProfit,1);
$pdf->Cell(70,10,$formattedNetProfit1,1,1); // End of row

// Output the PDF with a name based on the delivery_id
$delivery_id = 'YOUR_DELIVERY_ID_HERE';
$pdf->Output();
?>
