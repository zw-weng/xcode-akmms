<?php
include('mysession.php');
if (!session_id()) {
    session_start();
}
include('dbconnect.php');
include('function.php');

// Check if 'id' parameter is set
if (isset($_GET['id']) && $_GET['action'] == 'deactivate') {
    $item_id = $_GET['id'];

    // Update material status to deactivate in the database only for the specified material
    $sqlUpdateStatus = "UPDATE tb_advertising SET item_status = 0 WHERE item_id = ? LIMIT 1";
    $stmtUpdateStatus = mysqli_prepare($con, $sqlUpdateStatus);

    if ($stmtUpdateStatus) {
        mysqli_stmt_bind_param($stmtUpdateStatus, "s", $item_id);

        if (mysqli_stmt_execute($stmtUpdateStatus)) {
            // Redirect back to the user list page after updating status
            redirect('stock.php', 'Item <strong> ' . $item_id . ' </strong> is deleted successfully');
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
    redirect('stock.php', 'Error in item deletion');
}

mysqli_close($con);
exit();
?>