<?php
// Connect to DB
include('dbconnect.php');
include('function.php');

if (isset($_POST['create_quotation'])) {
    $cust_id = validate($_POST['cust_id']);
    $item_id = validate($_POST['item_id']);
    $dic = validate($_POST['dic']);
    $disc_amount = calculateDiscountAmount($_POST['dic']); // Assuming a function to calculate discount amount
    $tax_code = validate($_POST['tax_code']);
    $tax_amount = calculateTaxAmount($_POST['tax_code']); // Assuming a function to calculate tax amount
    $quotation_type_id = validate($_POST['quotation_type_id']);
    $quotation_status_id = 1; // Assuming default status is "Confirmed"
    $payment_term_id = validate($_POST['payment_term_id']);
    $quotation_date = date('Y-m-d');

    // Calculate grand total
    $grand_total = calculateGrandTotal($item_id, $disc_amount, $tax_amount); // Assuming a function to calculate grand total

    // Use prepared statement to prevent SQL injection
    $sql = "INSERT INTO tb_quotation (cust_id, item_id, dic, disc_amount, tax_code, tax_amount, grand_total, quotation_type_id, quotation_status_id, payment_term_id, quotation_date)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($con, $sql);

    if ($stmt) {
        // Bind parameters
        mysqli_stmt_bind_param($stmt, "iiddsdiiiss", $cust_id, $item_id, $dic, $disc_amount, $tax_code, $tax_amount, $grand_total, $quotation_type_id, $quotation_status_id, $payment_term_id, $quotation_date);

        // Execute the statement
        $result = mysqli_stmt_execute($stmt);

        if ($result) {
            redirect('quotation.php', 'Quotation created successfully');
        } else {
            redirect('quotation-advertising-create.php', 'Something went wrong');
        }

        // Close the statement
        mysqli_stmt_close($stmt);
    } else {
        // Prepare statement failed
        redirect('quotation-advertising-create.php', 'Error preparing statement');
    }
} else {
    redirect('quotation-advertising-create.php', 'Invalid request');
}

// Close DB Connection
mysqli_close($con);

// Redirect to the next page
header('Location:quotation.php');
?>
