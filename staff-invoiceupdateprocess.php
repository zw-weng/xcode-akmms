<?php
include('mysession.php');
if (!session_id()) {
    session_start();
}
include 'dbconnect.php';
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_invoice'])) {
    $quotation_id = $_POST['quotation_id'];
    $invoice_upfront = $_POST['invoice_upfront'];

    // Fetch current values of invoice_amount_payable and invoice_balance
    $selectQuery = "SELECT invoice_amount_payable, invoice_balance FROM tb_invoice WHERE quotation_id = '$quotation_id'";
    $result = mysqli_query($con, $selectQuery);

    if ($result && $row = mysqli_fetch_assoc($result)) {
        $currentAmountPayable = $row['invoice_amount_payable'];
        $currentBalance = $row['invoice_balance'];

        // Calculate new values based on invoice_upfront
        $newBalance = ($currentAmountPayable - $invoice_upfront);

        // Update the invoice_upfront, invoice_amount_payable, and invoice_balance in the database
        $updateQuery = "UPDATE tb_invoice SET invoice_upfront = '$invoice_upfront', invoice_amount_payable = '$currentAmountPayable', invoice_balance = '$newBalance' WHERE quotation_id = '$quotation_id'";

        if (mysqli_query($con, $updateQuery)) {
            // Redirect to the invoice list page after successful update
            header("Location: staff-invoicelist.php");
            exit();
        } else {
            echo "Error updating invoice: " . mysqli_error($con);
        }
    } else {
        echo "Error fetching current invoice details: " . mysqli_error($con);
    }
} else {
    echo "Invalid request";
}
?>
