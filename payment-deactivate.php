<?php
include('mysession.php');
if (!session_id()) {
    session_start();
}
include('dbconnect.php');
include('function.php');

// Check if 'id' parameter is set
if (isset($_GET['id']) && $_GET['action'] == 'deactivate') {
    $payment_id = $_GET['id'];

    // Update payment status to deactivate in the database only for the specified payment
    $sqlUpdateStatus = "UPDATE tb_payment SET payment_status = 0 WHERE payment_id = ? LIMIT 1";
    $stmtUpdateStatus = mysqli_prepare($con, $sqlUpdateStatus);

    if ($stmtUpdateStatus) {
        mysqli_stmt_bind_param($stmtUpdateStatus, "s", $payment_id);

        if (mysqli_stmt_execute($stmtUpdateStatus)) {
            // Redirect back to the payment list page after updating status
            redirect('payment.php', 'Payment <strong>' . $payment_id . '</strong> is moved to the recycle bin successfully');
            exit();
        } else {
            // Debugging error
            die("Execution failed: " . mysqli_stmt_error($stmtUpdateStatus));
        }

        mysqli_stmt_close($stmtUpdateStatus);
    } else {
        // Debugging error
        die("Prepare statement failed: " . mysqli_error($con));
    }
} else {
    // Redirect to an error page or handle the situation as needed
    redirect('payment.php', 'Error in payment deactivation');
}

mysqli_close($con);
exit();
?>
