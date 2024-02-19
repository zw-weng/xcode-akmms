<?php
// Includes neccessary files

include('dbconnect.php');
include('function.php');

// Get user id from url
if (isset($_GET['cust_id'])) {
    $fcustid = $_GET['cust_id'];

    // Validate and sanitize the user ID to prevent SQL injection
    $fcustid = mysqli_real_escape_string($con, $fcustid);
    $fcustid = htmlspecialchars($fcustid); // Additional input sanitization

    // Use prepared statement to delete the user
    $sql = "DELETE FROM tb_customer WHERE cust_id = ? LIMIT 1";
    $stmt = mysqli_prepare($con, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "s", $fcustid);
        $success=mysqli_stmt_execute($stmt);

        if($success){
        $affectedRows = mysqli_stmt_affected_rows($stmt);

        if ($affectedRows > 0) {
            // Deletion successful
            redirect('customer1.php', 'User deleted successfully');
        } else {
            // Deletion failed
            redirect('customer1.php', 'No user found or error deleting user');
        }
        } else {
        // Execution of statement failed
        redirect('customer1.php', 'Error executing deletion query: ' . mysqli_error($con));
    }

        mysqli_stmt_close($stmt);
    } else {
        // Prepare statement failed
        redirect('customer1.php', 'Error deleting user');
    }
}

// Close DB Connection
mysqli_close($con);

// Redirect to the next page
header('Location:customer1.php');
?>

