<?php
// Include necessary files
include('mysession.php');
if (!session_id()) {
    session_start();
}
include('dbconnect.php');
include('function.php');

// Get stock item id from url
if (isset($_GET['id'])) {
    $stockItemId = $_GET['id'];
}

if (isset($_POST['save_stock'])) {
    $item_name = validate($_POST['item_name']);
    $item_desc = validate($_POST['item_desc']);
    $item_cost = validate($_POST['item_cost']);
    $item_qty = validate($_POST['item_qty']);
    $item_markup = validate($_POST['item_markup']);
    $item_category = validate($_POST['item_category']);

    if ($item_name != '' && $item_desc != '' && $item_cost != '' && $item_qty != '' && $item_markup != '' && $item_category != '') {
        // Assuming your markup rate is stored as a decimal value in the database, you may need to adjust this part accordingly
        $actual_markup = $item_markup / 100;

        // Calculate the current price based on the markup
        $current_price = $item_cost * (1 + $actual_markup);

        $sql = "UPDATE tb_advertising SET
            item_name = ?,
            item_desc = ?,
            item_cost = ?,
            item_qty = ?,
            markup_rate = ?,
            item_price = ?,  -- Corrected variable name here
            item_category_id = ?
            WHERE item_id = ?";

        $stmt = mysqli_prepare($con, $sql);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "ssdddssi", $item_name, $item_desc, $item_cost, $item_qty, $actual_markup, $current_price, $item_category, $stockItemId);  // Corrected variable name here
            mysqli_stmt_execute($stmt);

            $affectedRows = mysqli_stmt_affected_rows($stmt);

            if ($affectedRows > 0) {
                // Update successful
                redirect('stock.php', '<strong>' .$item_name. ' - ' .$item_desc. '</strong> updated successfully');
            } else {
                // Update failed
                redirect('stock.php', 'No changes or error updating stock item');
            }

            mysqli_stmt_close($stmt);
        } else {
            // Prepare statement failed
            redirect('stock.php', 'Error updating stock item');
        }
    }
}

// Close DB Connection
mysqli_close($con);

// Redirect to the next page
header('Location: stock.php');
?>