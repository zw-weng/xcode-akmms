<?php
// Include required files
include_once 'dbconnect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_info'])) {
    // Get data from the form
    $quotationId = $_POST['quotationId'];
    $paymentTermId = $_POST['paymentTerm'];
    $customerId = $_POST['customerId'];
    // ... (add other form fields as needed)

    // Update quotation details in the database
    $updateQuotationQuery = "UPDATE tb_quotation SET
                            payment_term_id = $paymentTermId,
                            customer_id = $customerId
                            -- ... (add other fields)
                            WHERE quotation_id = $quotationId";

    mysqli_query($con, $updateQuotationQuery);

    // Update order items in the database
    $orderItemsCount = count($_POST['item_id']);
    for ($i = 0; $i < $orderItemsCount; $i++) {
        $itemId = $_POST['item_id'][$i];
        $quantity = $_POST['quantity'][$i];
        $unitPrice = $_POST['unit_price'][$i];
        $discount = $_POST['disc'][$i];
        $discountAmount = $_POST['disc_amount'][$i];
        $taxCode = $_POST['tax_code'][$i];
        $taxAmount = $_POST['tax_amount'][$i];
        $subTotal = $_POST['sub_total'][$i];

        // Update or insert order items based on your logic
        // You may need to check if the item already exists and update it, or insert a new record
        $updateOrderItemQuery = "UPDATE tb_order_item SET
                                quantity = $quantity,
                                unit_price = $unitPrice,
                                discount = $discount,
                                discount_amount = $discountAmount,
                                tax_code = '$taxCode',
                                tax_amount = $taxAmount,
                                sub_total = $subTotal
                                WHERE item_id = $itemId AND quotation_id = $quotationId";

        mysqli_query($con, $updateOrderItemQuery);
    }

    // Redirect to the quotation details page or any other page as needed
    header('Location: quotation-details.php?quotationId=' . $quotationId);
    exit();
} else {
    // Redirect to an error page or any other page as needed
    header('Location: error.php');
    exit();
}

mysqli_close($con);
?>
