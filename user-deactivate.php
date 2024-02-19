<?php

include('mysession.php');

if (!session_id()) {

    session_start();

}

include('dbconnect.php');

include('function.php');



// Check if 'id' parameter is set

if (isset($_GET['id']) && $_GET['action'] == 'deactivate') {

    $user_id = $_GET['id'];




    // Update user status to deactivate in the database only for the specified user

    $sqlUpdateStatus = "UPDATE tb_user SET acc_status = 0 WHERE user_id = ? LIMIT 1";

    $stmtUpdateStatus = mysqli_prepare($con, $sqlUpdateStatus);



    if ($stmtUpdateStatus) {

        mysqli_stmt_bind_param($stmtUpdateStatus, "s", $user_id);



        if (mysqli_stmt_execute($stmtUpdateStatus)) {

            // Redirect back to the user list page after updating status

            redirect('user.php', 'User<strong> ' . $user_id . ' </strong>is deactivated successfully');

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

    redirect('user.php', 'Error in user deactivation.');

}



mysqli_close($con);

exit();

?>