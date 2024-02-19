<?php
include('mysession.php');

// Start the session
if (!session_id()) {
    session_start();
}

// Include database connection
include('dbconnect.php');

// Form Submission Handling Section
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['save_btn'])) {
    // Save button clicked
    saveData();
}

function saveData() {
    global $con;

    // Retrieve data from the form
    $order_ids = isset($_POST['order_id']) ? $_POST['order_id'] : [];
    $payment_types = isset($_POST['payment_type']) ? $_POST['payment_type'] : [];
    $payment_amounts = isset($_POST['payment_amount']) ? $_POST['payment_amount'] : [];
    $staff_incharges = isset($_POST['staff_incharge']) ? $_POST['staff_incharge'] : [];
    $remarks = isset($_POST['remark']) ? $_POST['remark'] : [];
    $payment_statuses = isset($_POST['payment_status']) ? $_POST['payment_status'] : [];
    $order_statuses = isset($_POST['order_status']) ? $_POST['order_status'] : [];

// Debugging: Dump payment amounts
    var_dump($payment_amounts);
    // Update the database with the new data
    // Update the database with the new data
$sql = "UPDATE tb_salesorder
        INNER JOIN tb_payment ON tb_salesorder.payment_id = tb_payment.payment_id
        SET 
            tb_salesorder.payment_type_id = ?,
            tb_payment.payment_amount = ?,
            tb_salesorder.staff_incharge = ?,
            tb_salesorder.remark = ?,
            tb_salesorder.payment_status_id = ?,
            tb_salesorder.order_status_id = ?
        WHERE tb_salesorder.order_id = ?";


    $stmt = mysqli_prepare($con, $sql);

    if ($stmt) {
        for ($i = 0; $i < count($order_ids); $i++) {
            mysqli_stmt_bind_param($stmt, "isssiii", $payment_types[$i], $payment_amounts[$i], $staff_incharges[$i], $remarks[$i], $payment_statuses[$i], $order_statuses[$i], $order_ids[$i]);
            mysqli_stmt_execute($stmt);

            if (mysqli_stmt_affected_rows($stmt) > 0) {
                $_SESSION['order_message'] = "Data for order ID " . $order_ids[$i] . " saved successfully!";
            } else {
                $_SESSION['order_message'] = "No changes made or an error occurred for order ID " . $order_ids[$i] . ".";
            }
        }

        mysqli_stmt_close($stmt);
    } else {
        $_SESSION['order_message'] = "Prepare statement failed: " . mysqli_error($con);
    }

    mysqli_close($con);

    // Redirect to the order list page
    header("Location: staff-order.php");
    exit();
}
?>
