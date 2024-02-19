<?php
include('mysession.php');
if (!session_id()) {
    session_start();
}
include('dbconnect.php');
include('function.php');

// Get electric rate id from URL
if (isset($_GET['id'])) {
    $erateId = $_GET['id'];

    // Validate and sanitize the electric rate ID to prevent SQL injection
    $erateId = mysqli_real_escape_string($con, $erateId);
    $erateId = htmlspecialchars($erateId); // Additional input sanitization
}

if (isset($_POST['update_e'])) {
    $state = validate($_POST['state']);
    $district = validate($_POST['district']);
    $group_range = validate($_POST['group_range']);
    $erate = validate($_POST['erate']);

    if ($state != '' && $district != '' && $group_range != '' && $erate != '') {

        $sql = "UPDATE tb_electric SET
            e_state = ?,
            e_district = ?,
            e_group = ?,
            e_rate = ?
            WHERE e_id = ?";

        $stmt = mysqli_prepare($con, $sql);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "sssdi", $state, $district, $group_range, $erate, $erateId);
            mysqli_stmt_execute($stmt);

            $affectedRows = mysqli_stmt_affected_rows($stmt);

            if ($affectedRows > 0) {
                // Update successful
                redirect('staff-jkr.php', 'Electric rate charged updated successfully');
            } else {
                // Update failed
                redirect('staff-erate-edit.php', 'No changes or error updating electric rate');
            }

            mysqli_stmt_close($stmt);
        } else {
            // Prepare statement failed
            redirect('staff-erate-edit.php', 'Error preparing the update statement');
        }
    } else {
        // Invalid or missing data
        redirect('staff-erate-edit.php', 'Please fill in all required fields');
    }
}

// Close DB Connection (no need to close here if you are redirecting)
mysqli_close($con);

// Redirect to the next page
header('Location: staff-jkr.php');
?>