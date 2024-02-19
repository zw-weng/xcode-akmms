<?php
include('mysession.php');
if (!session_id()) {
    session_start();
}
include('dbconnect.php');
include('function.php');

// Check if 'id' parameter is set
if (isset($_GET['id']) && $_GET['action'] == 'activate') {
    $item_id = $_GET['id'];

    // Update user status to activate in the database only for the specified user
    $sqlUpdateStatus = "UPDATE tb_advertising SET item_status = 1 WHERE item_id = ? LIMIT 1";
    $stmtUpdateStatus = mysqli_prepare($con, $sqlUpdateStatus);

    if ($stmtUpdateStatus) {
        mysqli_stmt_bind_param($stmtUpdateStatus, "s", $item_id);

        if (mysqli_stmt_execute($stmtUpdateStatus)) {
            // Check if any row was affected
            if (mysqli_stmt_affected_rows($stmtUpdateStatus) > 0) {
                // Redirect back to the jkr list page after updating status
                redirect('stock-bin.php', 'Item<strong> ' . $item_id . ' </strong>is restored successfully');
                exit();
            } else {
                // No rows were affected (material ID might not exist)
                redirect('stock-bin.php', 'No item found with the provided ID.');
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
    redirect('stock-bin.php', 'Error in item restoration');
}

mysqli_close($con);
exit();
?>