<?php
// updateuser.php

include('mysession.php');
if (!session_id()) {
    session_start();
}

// Include database connection
include('dbconnect.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Assuming form fields are posted using POST method

    // Sanitize and retrieve data from the form
    $fid = intval($_POST['fid']);  // Convert to integer
    $fic = mysqli_real_escape_string($con, $_POST['fic']);
    $ffname = mysqli_real_escape_string($con, $_POST['ffname']);
    $flname = mysqli_real_escape_string($con, $_POST['flname']);
    $fpwd = mysqli_real_escape_string($con, $_POST['fpwd']);
    $fphone = mysqli_real_escape_string($con, $_POST['fphone']);
    $femail = mysqli_real_escape_string($con, $_POST['femail']);
    $fadd = mysqli_real_escape_string($con, $_POST['fadd']);
    $fposition = mysqli_real_escape_string($con, $_POST['fposition']);
    $ftype = intval($_POST['ftype']);  // Convert to integer

    // Update user in the database
    $sqlUpdate = "UPDATE tb_user SET user_ic=?, u_fName=?, u_lName=?, user_pwd=?, user_phone=?, user_email=?, user_address=?, user_position=?, type_id=? WHERE user_id=?";
    $stmt = mysqli_prepare($con, $sqlUpdate);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "ssssssssii", $fic, $ffname, $flname, $fpwd, $fphone, $femail, $fadd, $fposition, $ftype, $fid);
        mysqli_stmt_execute($stmt);

        if (mysqli_stmt_affected_rows($stmt) > 0) {
            // Update successful
            header("Location: userlist.php"); // Redirect to userlist.php or any other page
            exit();
        } else {
            // No rows were updated, handle the case if needed
            echo "No rows were updated.";
        }

        mysqli_stmt_close($stmt);
    } else {
        // Prepare statement failed
        echo "Prepare statement failed: " . mysqli_error($con);
    }

    mysqli_close($con);
} else {
    // If the form is not submitted via POST, redirect to an error page or handle accordingly
    header("Location: error.php");
    exit();
}
?>