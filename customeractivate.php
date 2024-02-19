<?php

include('mysession.php');
if (!session_id()) {
    session_start();
}
include('dbconnect.php');

include('function.php');



// Check if 'id' parameter is set

if (isset($_GET['id']) && $_GET['action'] == 'activate') {

    $cust_id = $_GET['id'];



   


    // Update user status to activate in the database only for the specified user

    $sqlUpdateStatus = "UPDATE tb_customer SET cust_status = 1 WHERE cust_id = ? ";

    $stmtUpdateStatus = mysqli_prepare($con, $sqlUpdateStatus);



    if ($stmtUpdateStatus) {

        mysqli_stmt_bind_param($stmtUpdateStatus, "i", $cust_id);



        if (mysqli_stmt_execute($stmtUpdateStatus)) {

            // Check if any row was affected

            if (mysqli_stmt_affected_rows($stmtUpdateStatus) > 0) {

                // Redirect back to the user list page after updating status

                redirect('customer1.php', 'Customer<strong> ' . $cust_id . ' </strong>is activated successfully');

                exit();

            } else {

                // No rows were affected (user ID might not exist)

                redirect('customer1.php', 'No user found with the provided ID.');

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

    redirect('customer1.php', 'Error in user activation.');

}



mysqli_close($con);

exit();

?>