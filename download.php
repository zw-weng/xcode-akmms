<?php
// Include database connection
include('dbconnect.php');

// Check if payment_id is provided in the query string
if (isset($_GET['payment_id'])) {
    $payment_id = $_GET['payment_id'];

    // Retrieve the file path from the database based on payment_id
    $sql = "SELECT payment_proof FROM tb_payment WHERE payment_id = ?";
    $stmt = mysqli_prepare($con, $sql);

    // Check for SQL preparation error
    if (!$stmt) {
        die('Error in preparing statement: ' . mysqli_error($con));
    }

    // Bind the parameter
    mysqli_stmt_bind_param($stmt, "i", $payment_id);

    // Execute the statement
    if (!mysqli_stmt_execute($stmt)) {
        die('Error in executing statement: ' . mysqli_error($con));
    }

    // Get the result
    $result = mysqli_stmt_get_result($stmt);

    // Fetch the row
    $row = mysqli_fetch_assoc($result);

    // Check if the result is not empty
    if ($row && isset($row['payment_proof'])) {
        $file_path = $row['payment_proof'];

        // Set the appropriate headers for a PDF file
        header('Content-Type: application/pdf');
        header('Content-Disposition: inline; filename="downloaded.pdf"');

        // Output the PDF content
        readfile($file_path);

        // Close the database connection
        mysqli_close($con);
        exit;
    }
}

// If payment_id is not provided or PDF is not found, redirect to some error page
header("Location: error_page.php");
exit;
?>
