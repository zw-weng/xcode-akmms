<?php
include('mysession.php');
if (!session_id()) {
    session_start();
}
include('dbconnect.php');
include('function.php');

// Check if 'id' parameter is set
if (isset($_GET['id']) && $_GET['action'] == 'activate') {
    $payment_id = $_GET['id'];

    // Update payment status to activate in the database only for the specified payment
    $sqlUpdateStatus = "UPDATE tb_payment SET payment_status = 1 WHERE payment_id = ? LIMIT 1";
    $stmtUpdateStatus = mysqli_prepare($con, $sqlUpdateStatus);

    if ($stmtUpdateStatus) {
        mysqli_stmt_bind_param($stmtUpdateStatus, "i", $payment_id);

        if (mysqli_stmt_execute($stmtUpdateStatus)) {
            // Check if any row was affected
            if (mysqli_stmt_affected_rows($stmtUpdateStatus) > 0) {
                // Redirect back to the payment bin page after updating status
                redirect('staff-payment-bin.php', 'Payment <strong>' . $payment_id . '</strong> is restored successfully');
                exit();
            } else {
                // No rows were affected (payment ID might not exist)
                redirect('staff-payment-bin.php', 'No payment found with the provided ID.');
                exit();
            }
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
    redirect('staff-payment-bin.php', 'Error in payment restoration');
}

mysqli_close($con);
exit();
?>
