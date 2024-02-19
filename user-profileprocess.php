<?php
// Include necessary files
include('mysession.php');
if (!session_id()) {
    session_start();
}
include('dbconnect.php');
include('function.php');

// Get user id from session
if (isset($_SESSION['suid'])) {
    $userId = $_SESSION['suid'];
}

if (isset($_POST['saveprofile'])) {
    $fName = validate($_POST['fName']);
    $lName = validate($_POST['lName']);
    $fic = validate($_POST['fic']);
    $phone = validate($_POST['phone']);
    $email = validate($_POST['email']);

    // Validate and sanitize the user ID to prevent SQL injection
    $userId = mysqli_real_escape_string($con, $userId);
    $userId = htmlspecialchars($userId); // Additional input sanitization

    if ($fName != '' && $lName != '' && $fic != '' && $phone != '' && $email != '') {
        // Validate email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            redirect('user-profile.php', 'Invalid email format');
        }

        // Validate name (assuming it should only contain letters and spaces)
        if (!preg_match("/^[a-zA-Z ]*$/", $fName) || !preg_match("/^[a-zA-Z ]*$/", $lName)) {
            redirect('user-profile.php', 'Invalid name format');
        }

        $sql = "UPDATE tb_user SET
        u_fName = ?,
        u_lName = ?,
        user_ic = ?,
        user_phone = ?,
        user_email = ?
        WHERE user_id = ?";

        $stmt = mysqli_prepare($con, $sql);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "ssssss", $fName, $lName, $fic, $phone, $email, $userId);
            mysqli_stmt_execute($stmt);

            $affectedRows = mysqli_stmt_affected_rows($stmt);

            if ($affectedRows > 0) {
                // Update successful
                redirect('user-profile.php', 'Profile updated successfully');
            } else {
                // Update failed
                redirect('user-profile.php', 'No changes or error updating profile');
            }

            mysqli_stmt_close($stmt);
        } else {
            // Prepare statement failed
            redirect('user-profile.php', 'Error updating profile');
        }
    } else {
        // Validation failed
        redirect('user-profile.php', 'Please fill in all required fields');
    }
}

if (isset($_POST['savepwd'])) {
    $newPassword = validate($_POST['newpassword']);
    $renewPassword = validate($_POST['renewpassword']);

    // Validate and sanitize the user ID to prevent SQL injection
    $userId = mysqli_real_escape_string($con, $userId);
    $userId = htmlspecialchars($userId); // Additional input sanitization

    if ($newPassword != '' && $renewPassword != '') {
        // Validate password complexity (assuming it must have at least 12 characters with a combination of uppercase, lowercase, number, and symbol)
        if (!isValidPassword($newPassword)) {
            redirect('user-profile.php', 'Password must have at least 12 characters with a combination of uppercase, lowercase, number, and symbol');
        }

        // Check if the new password and re-entered password match
        if ($newPassword !== $renewPassword) {
            redirect('user-profile.php', 'New password and re-entered password do not match');
        }

        // Update the password
        $hashedNewPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        $sql = "UPDATE tb_user SET user_pwd = ? WHERE user_id = ?";
        $stmt = mysqli_prepare($con, $sql);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "ss", $hashedNewPassword, $userId);
            mysqli_stmt_execute($stmt);

            $affectedRows = mysqli_stmt_affected_rows($stmt);

            if ($affectedRows > 0) {
                // Password update successful
                redirect('user-profile.php', 'Password updated successfully');
            } else {
                // Password update failed
                redirect('user-profile.php', 'No changes or error updating password');
            }

            mysqli_stmt_close($stmt);
        } else {
            // Prepare statement failed
            redirect('user-profile.php', 'Error updating password');
        }
    } else {
        // Validation failed
        redirect('user-profile.php', 'Please fill in all required fields');
    }
}

// Close DB Connection
mysqli_close($con);

// Redirect to the next page
header('Location: user-profile.php');
?>