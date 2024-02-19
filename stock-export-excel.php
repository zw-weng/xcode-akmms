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
$fileName = "akmms-stock-data_" . date('Y-m-d') . ".xls";

// Column names 
$fields = array('Item ID', 'Item Name', 'Description', 'Cost', 'Price', 'Quantity', 'Category');

// Fetch records from database 
$query = $con->query("SELECT tb_advertising.*, tb_itemcategory.item_category_desc
                      FROM tb_advertising
                      JOIN tb_itemcategory ON tb_advertising.item_category_id = tb_itemcategory.item_category_id
                      ORDER BY tb_advertising.item_id ASC");

if ($query->num_rows > 0) {
    // Output header row 
    $excelData = '<table border="1"><tr>';
    $excelData .= '<th>' . implode('</th><th>', array_values($fields)) . '</th>';
    $excelData .= '</tr>';

    // Output each row of the data 
    while ($row = $query->fetch_assoc()) {
        $lineData = array($row['item_id'], $row['item_name'], $row['item_desc'], '"' . $row['item_cost'] . '"', $row['item_qty'], $row['item_price'], $row['item_category_desc']);
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

// Render excel data 
echo $excelData;

exit;
