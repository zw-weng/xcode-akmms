<?php
include 'dbconnect.php';

if(isset($_POST['update_btn'])) {
    // Retrieve submitted values
    $quotationId = $_POST['quotation_id'];
    $clientId = $_POST['cust_id'];
    $orderId = $_POST['order_id'];

    // Fetch values from tb_quotation based on quotation_id
    $fetchQuotationQuery = "SELECT * FROM tb_quotation WHERE quotation_id = '$quotationId'";
    $fetchQuotationResult = mysqli_query($con, $fetchQuotationQuery);

    if ($fetchQuotationResult && $quotationRow = mysqli_fetch_assoc($fetchQuotationResult)) {
        $grandTotal = $quotationRow['grand_total'];

        // Construct and execute the SQL UPDATE query for tb_quotation
        $updateQuotationQuery = "
            UPDATE tb_quotation
            SET
                client_name = '$_POST[client_name]',
                client_street = '$_POST[client_street]',
                client_postcode = '$_POST[client_postcode]',
                client_city = '$_POST[client_city]',
                client_state = '$_POST[client_state]',
                client_country = '$_POST[client_country]',
                product_price = '$_POST[product_price]',
                product_desc = '$_POST[product_desc]',
                quantity = '$_POST[quantity]'
            WHERE
                quotation_id = '$quotationId'
        ";

        $updateQuotationResult = mysqli_query($con, $updateQuotationQuery);

        if ($updateQuotationResult) {
            echo "Update successful for tb_quotation";
        } else {
            echo "Update failed for tb_quotation: " . mysqli_error($con);
        }

        // Construct and execute the SQL UPDATE query for tb_invoice
        $updateInvoiceQuery = "
            UPDATE tb_invoice
            SET
                invoice_amount_payable = '$grandTotal',
                invoice_balance = '$_POST[invoice_balance]',
                invoice_upfront = '$_POST[invoice_upfront]',
                invoice_date = NOW()
            WHERE
                order_id = '$orderId'
        ";

        $updateInvoiceResult = mysqli_query($con, $updateInvoiceQuery);

        if ($updateInvoiceResult) {
            echo "Update successful for tb_invoice";
        } else {
            echo "Update failed for tb_invoice: " . mysqli_error($con);
        }
    } else {
        echo "Error fetching values from tb_quotation: " . mysqli_error($con);
    }
}

mysqli_close($con);
?>
