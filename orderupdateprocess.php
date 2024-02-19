<?php
include('mysession.php');
if (!session_id()) {
    session_start();
}
include 'dbconnect.php';
include('function.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data
    $order_id = $_POST['order_id'];
    $staff_incharge = mysqli_real_escape_string($con, $_POST['staff_incharge']);
    $remark = mysqli_real_escape_string($con, $_POST['remark']);
    $payment_status_id = $_POST['payment_status_id'];
    $order_status_id = $_POST['order_status_id'];

    $sql = "UPDATE tb_salesorder SET staff_incharge = '$staff_incharge', remark = '$remark', payment_status_id = $payment_status_id, order_status_id = $order_status_id WHERE order_id = $order_id";
}

// Attempt to execute the SQL statement
if (mysqli_query($con, $sql)) {
    if ($order_status_id == 2) {
        // Records updated successfully. Now insert into tb_deliveryorder
        // Check if a delivery order already exists for this order_id
        $sql = "SELECT * FROM tb_deliveryorder WHERE order_id = $order_id";
        $result = mysqli_query($con, $sql);
        if (mysqli_num_rows($result) == 0) {
            // No delivery order exists, so create one
            // Fetch the quotation_id from tb_salesorder
            $sql = "SELECT quotation_id FROM tb_salesorder WHERE order_id = $order_id";
            $result = mysqli_query($con, $sql);
            $row = mysqli_fetch_assoc($result);
            $quotation_id = $row['quotation_id'];
            // Get the current date
            $do_date = date('Y-m-d H:i:s');
            // Prepare the SQL statement
            $sql = "INSERT INTO tb_deliveryorder (order_id, quotation_id, do_date, product_id) VALUES ($order_id, $quotation_id, '$do_date', 0)";
            if (mysqli_query($con, $sql)) {
                redirect('order.php', 'Order status updated successfully');
                exit();
            } else {
                echo "Error inserting into tb_deliveryorder: " . mysqli_error($con);
            }
        }
    } else if ($order_status_id == 3) {
        $iv_date = date('Y-m-d H:i:s');
        // Fetch the quotation_id from tb_salesorder
        $sql = "SELECT quotation_id FROM tb_salesorder WHERE order_id = $order_id";
        $result = mysqli_query($con, $sql);
        if ($result) {
            $row = mysqli_fetch_assoc($result);
            $quotation_id = $row['quotation_id'];
            $sql = "SELECT delivery_id FROM tb_deliveryorder WHERE order_id = $order_id";
            $result = mysqli_query($con, $sql);
            $row = mysqli_fetch_assoc($result);
            $delivery_id = $row['delivery_id'];
            $sql = "SELECT grand_total FROM tb_quotation WHERE quotation_id = $quotation_id";
            $result = mysqli_query($con, $sql);
            $row = mysqli_fetch_assoc($result);
            $grand_total = $row['grand_total'];

            // Prepare the SQL statement
            $sql = "INSERT INTO tb_invoice (invoice_amount_payable, invoice_balance, invoice_upfront, order_id, quotation_id, delivery_id, invoice_date, product_id) VALUES ($grand_total, $grand_total, 0, $order_id, $quotation_id, $delivery_id, '$iv_date', 0)";

            // Attempt to execute the SQL statement
            if (mysqli_query($con, $sql)) {
                // Records inserted successfully. Redirect to landing page
                redirect('order.php', 'Order status successfully');
                exit();
            } else {
                echo "Error inserting into tb_invoice: " . mysqli_error($con);
            }
        }
    }
} else {
    echo "Error updating order: " . mysqli_error($con);
}

if ($payment_status_id != 1) {
    // Check if inventory has been updated for this order
    $sql_check = "SELECT inventory_updated FROM tb_salesorder WHERE order_id = $order_id";
    $result_check = mysqli_query($con, $sql_check);
    $row_check = mysqli_fetch_assoc($result_check);
    $inventory_updated = $row_check['inventory_updated'];

    // Only update inventory if it hasn't been updated yet
    if ($inventory_updated == 0) {
        $sql = "SELECT quotation_id FROM tb_salesorder WHERE order_id = $order_id";
        $result = mysqli_query($con, $sql);
        $row = mysqli_fetch_assoc($result);
        $quotation_id = $row['quotation_id'];
        // Retrieve the product_qty and item_id from tb_product where quotation_id is the same as $quotation_id
        $sql = "SELECT product_qty, item_id FROM tb_product WHERE quotation_id = $quotation_id";
        $result = mysqli_query($con, $sql);
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $product_qty = $row['product_qty'];
                $item_id = $row['item_id'];
                // Subtract the product_qty from the item_qty in tb_advertising where item_id is the same
                $sql_update = "UPDATE tb_advertising SET item_qty = item_qty - $product_qty WHERE item_id = $item_id";
                if (!mysqli_query($con, $sql_update)) {
                    echo "Error updating tb_advertising: " . mysqli_error($con);
                }
            }
            $sql_update_flag = "UPDATE tb_salesorder SET inventory_updated = 1 WHERE order_id = $order_id";
            if (!mysqli_query($con, $sql_update_flag)) {
                echo "Error updating inventory_updated flag: " . mysqli_error($con);
            }
        }
    }
} else {
    mysqli_close($con);
    exit();
}

// Close connection
mysqli_close($con);
exit();
?>