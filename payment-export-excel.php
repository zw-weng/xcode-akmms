<?php
// Load the database configuration file 
include_once 'dbconnect.php';

// Filter the excel data 
function filterData(&$str)
{
    $str = preg_replace("/\t/", "\\t", $str);
    $str = preg_replace("/\r?\n/", "\\n", $str);
    if (strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
}

// Excel file name for download 
$fileName = "akmms-payment-data_" . date('Y-m-d') . ".xls";

// Column names 
$fields = array('Payment ID', 'Order ID', 'Payment Date', 'Customer Name', 'Payment Amount', 'Payment Type', 'Proof of Payment');

// Fetch records from the database 
$query = $con->query("SELECT tb_payment.*, tb_paymenttype.payment_type_desc
                      FROM tb_payment
                      INNER JOIN tb_paymenttype ON tb_payment.payment_type_id = tb_paymenttype.payment_type_id
                      WHERE tb_payment.payment_status = 1
                      ORDER BY tb_payment.payment_id ASC");

if ($query->num_rows > 0) {
    // Output header row 
    $excelData = '<table border="1"><tr>';
    $excelData .= '<th>' . implode('</th><th>', array_values($fields)) . '</th>';
    $excelData .= '</tr>';

     // Output each row of the data 
    while ($row = $query->fetch_assoc()) {
        if ($row['payment_status'] == 1) {
            $status = 'Active';
        } else {
            $status = 'Disabled';
        }

        $lineData = array(
            $row['payment_id'],
            $row['order_id'],
            date('Y-m-d', strtotime($row['payment_date'])),
            $row['client_name'],
            $row['payment_amount'],
            $row['payment_type_desc'],
            $row['payment_proof']
        );
        array_walk($lineData, 'filterData');
        $excelData .= '<tr><td>' . implode('</td><td>', array_values($lineData)) . '</td></tr>';
    }
    $excelData .= '</table>';
} else {
    // No records found
    $excelData = "No records found...\n";
}

// Headers for download 
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=\"$fileName\"");

// Render Excel data 
echo $excelData;

exit;
?>
