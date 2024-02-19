<?php
include('mysession.php');
if (!session_id()) {
    session_start();
}
include('dbconnect.php');
include('function.php');

// Check if 'id' parameter is set
if (isset($_GET['id']) && $_GET['action'] == 'deactivate') {
    $c_id = $_GET['id'];

    // Update material status to deactivate in the database only for the specified material
    $sqlUpdateStatus = "UPDATE tb_civil SET c_status = 0 WHERE c_id = ? LIMIT 1";
    $stmtUpdateStatus = mysqli_prepare($con, $sqlUpdateStatus);

    if ($stmtUpdateStatus) {
        mysqli_stmt_bind_param($stmtUpdateStatus, "s", $c_id);

        if (mysqli_stmt_execute($stmtUpdateStatus)) {
            // Redirect back to the user list page after updating status
            redirect('staff-jkr.php', 'Civil rate charged <strong> ' . $c_rate . ' </strong> is deleted successfully');
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
    redirect('staff-jkr.php', 'Error in rate charged deletion');
}

mysqli_close($con);
exit();
?>