<?php
include('mysession.php');
if (!session_id()) {
    session_start();
}
include('dbconnect.php');
include('function.php');

// Get electric rate id from URL
if (isset($_GET['id'])) {
    $crateId = $_GET['id'];

    // Validate and sanitize the electric rate ID to prevent SQL injection
    $crateId = mysqli_real_escape_string($con, $crateId);
    $crateId = htmlspecialchars($crateId); // Additional input sanitization
}

if (isset($_POST['update_c'])) {
    $state = validate($_POST['state']);
    $district = validate($_POST['district']);
    $group_range = validate($_POST['group_range']);
    $crate = validate($_POST['crate']);

    if ($state != '' && $district != '' && $group_range != '' && $crate != '') {

        $sql = "UPDATE tb_civil SET
            c_state = ?,
            c_district = ?,
            c_group = ?,
            c_rate = ?
            WHERE c_id = ?";

        $stmt = mysqli_prepare($con, $sql);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "sssdi", $state, $district, $group_range, $crate, $crateId);
            mysqli_stmt_execute($stmt);

            $affectedRows = mysqli_stmt_affected_rows($stmt);

            if ($affectedRows > 0) {
                // Update successful
                redirect('jkr.php', 'Civil rate charged updated successfully');
            } else {
                // Update failed
                redirect('crate-edit.php', 'No changes or error updating civil rate');
            }

            mysqli_stmt_close($stmt);
        } else {
            // Prepare statement failed
            redirect('crate-edit.php', 'Error preparing the update statement');
        }
    } else {
        // Invalid or missing data
        redirect('crate-edit.php', 'Please fill in all required fields');
    }
}

// Close DB Connection (no need to close here if you are redirecting)
mysqli_close($con);

// Redirect to the next page
header('Location: jkr.php');
?>