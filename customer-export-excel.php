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
$fileName = "akmms-customer-data_" . date('Y-m-d') . ".xls";

// Column names 
$fields = array('Customer ID', 'Name', 'Phone No.', 'Email', 'Street', 'Postcode', 'City', 'State', 'Country');

// Fetch records from the database 
$query = $con->query("SELECT * FROM tb_customer ORDER BY cust_id ASC");

if ($query->num_rows > 0) {
    // Output header row 
    $excelData = '<table border="1"><tr>';
    $excelData .= '<th>' . implode('</th><th>', array_values($fields)) . '</th>';
    $excelData .= '</tr>';

    // Output each row of the data 
    while ($row = $query->fetch_assoc()) {
        $lineData = array(
            $row['cust_id'],
            $row['cust_name'],
            $row['cust_phone'],
            $row['cust_email'],
            $row['cust_street'],
            $row['cust_postcode'],
            $row['cust_city'],
            $row['cust_state'],
            $row['cust_country']
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
