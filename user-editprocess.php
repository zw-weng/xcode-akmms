<?php
// Include neccessary files
include('mysession.php');
if (!session_id()) {
    session_start();
}
include('dbconnect.php');
include('function.php');

// Get user id from url
if (isset($_GET['id'])) {
    $fid = $_GET['id'];

    // Validate and sanitize the user ID to prevent SQL injection
    $fid = mysqli_real_escape_string($con, $fid);
    $fid = htmlspecialchars($fid); // Additional input sanitization
}

if (isset($_POST['saveuser'])) {
    $fid = validate($_POST['fid']);
    $fic = validate($_POST['fic']);
    $ffname = validate($_POST['ffname']);
    $flname = validate($_POST['flname']);
    $fphone = validate($_POST['fphone']);
    $femail = validate($_POST['femail']);
    $ftype = validate($_POST['ftype']);


    if ($fid != '' && $fic != '' && $ffname != '' && $flname != '' && $fphone != '' && $femail != '' && $ftype != '') {
        // Validate email
        if (!filter_var($femail, FILTER_VALIDATE_EMAIL)) {
            redirect('user-edit.php?id=' . $fid, 'Invalid email format');
        }

        // Validate name (assuming it should only contain letters and spaces)
        if (!preg_match("/^[a-zA-Z ]*$/", $ffname) || !preg_match("/^[a-zA-Z ]*$/", $flname)) {
            redirect('user-edit.php?id=' . $fid, 'Invalid name format');
        }

        $sql = "UPDATE tb_user SET
        user_ic = ?,
        u_fName = ?,
        u_lName = ?,
        user_phone = ?,
        user_email = ?,
        type_id = ?
        WHERE user_id = ?";

        $stmt = mysqli_prepare($con, $sql);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "sssssis", $fic, $ffname, $flname, $fphone, $femail, $ftype, $fid);
            mysqli_stmt_execute($stmt);

            $affectedRows = mysqli_stmt_affected_rows($stmt);

            if ($affectedRows > 0) {
                // Update successful
                redirect('user.php', 'User<strong> ' . $fid . ' </strong>updated successfully');
            } else {
                // Update failed
                redirect('user.php', 'No changes or error updating user');
            }

            mysqli_stmt_close($stmt);
        } else {
            // Prepare statement failed
            redirect('user.php', 'Error updating user');
        }
    }
}

// Close DB Connection
mysqli_close($con);

// Redirect to the next page
header('Location:user.php');
?>