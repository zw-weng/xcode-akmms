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
$fileName = "akmms-user-data_" . date('Y-m-d') . ".xls";

// Column names 
$fields = array('User ID', 'First Name', 'Last Name', 'IC No.', 'Phone No.', 'Email', 'Account Status', 'User Type');

// Fetch records from database 
$query = $con->query("SELECT tb_user.*, tb_usertype.type_desc
                      FROM tb_user
                      JOIN tb_usertype ON tb_user.type_id = tb_usertype.type_id
                      ORDER BY tb_user.user_id ASC");

if ($query->num_rows > 0) {
    // Output header row 
    $excelData = '<table border="1"><tr>';
    $excelData .= '<th>' . implode('</th><th>', array_values($fields)) . '</th>';
    $excelData .= '</tr>';

    // Output each row of the data 
    while ($row = $query->fetch_assoc()) {
        if ($row['acc_status'] == 1) {
            $status = 'Active';
        } else {
            $status = 'Disabled';
        }
        $lineData = array($row['user_id'], $row['u_fName'], $row['u_lName'], '"' . $row['user_ic'] . '"', '"' . $row['user_phone'] . '"', $row['user_email'], $status, $row['type_desc']);
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
?>