<?php
// Connect to DB
include('dbconnect.php');
include('function.php');

// Get user id from url
if (isset($_GET['id'])) {
    $fid = $_GET['id'];

    // Validate and sanitize the user ID to prevent SQL injection
    $fid = mysqli_real_escape_string($con, $fid);
    $fid = htmlspecialchars($fid); // Additional input sanitization

    // Use prepared statement to delete the user
    $sql = "DELETE FROM tb_user WHERE user_id = ? LIMIT 1";
    $stmt = mysqli_prepare($con, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $fid);
        mysqli_stmt_execute($stmt);

        $affectedRows = mysqli_stmt_affected_rows($stmt);

        if ($affectedRows > 0) {
            // Deletion successful
            redirect('user.php', 'User deleted successfully');
        } else {
            // Deletion failed
            redirect('user.php', 'No user found or error deleting user');
        }

        mysqli_stmt_close($stmt);
    } else {
        // Prepare statement failed
        redirect('user.php', 'Error deleting user');
    }
}

// Close DB Connection
mysqli_close($con);

// Redirect to the next page
header('Location:user.php');
?>