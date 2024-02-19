<?php
// Include necessary files
include('mysession.php');
if (!session_id()) {
    session_start();
}
include('dbconnect.php');
include('function.php');

if (isset($_POST['saveuser'])) {
    $fid = validate($_POST['fid']);
    $fic = validate($_POST['fic']);
    $ffname = validate($_POST['ffname']);
    $flname = validate($_POST['flname']);
    $fpwd = validate($_POST['fpwd']);
    $fphone = validate($_POST['fphone']);
    $femail = validate($_POST['femail']);
    $ftype = validate($_POST['ftype']);

    if ($fid != '' || $fic != '' || $ffname != '' || $flname != '' || $fpwd != '' || $fphone != '' || $femail != '' || $ftype != '') {
        // Validate email
        if (!filter_var($femail, FILTER_VALIDATE_EMAIL)) {
            redirect('user-create.php?id=' . $fid, 'Invalid email format');
        }

        // Validate name (assuming it should only contain letters and spaces)
        if (!preg_match("/^[a-zA-Z ]*$/", $ffname) || !preg_match("/^[a-zA-Z ]*$/", $flname)) {
            redirect('user-create.php?id=' . $fid, 'Invalid name format');
        }

        // Validate password
        if (!isValidPassword($fpwd)) {
            redirect('user-create.php?id=' . $fid, 'Password must have at least 12 characters with a combination of uppercase, lowercase, number, and symbol.');
        }

        // Check if user ID already exists
        $checkUserIdQuery = "SELECT COUNT(*) FROM tb_user WHERE user_id = ?";
        $checkUserIdStmt = mysqli_prepare($con, $checkUserIdQuery);
        mysqli_stmt_bind_param($checkUserIdStmt, "s", $fid);
        mysqli_stmt_execute($checkUserIdStmt);
        mysqli_stmt_bind_result($checkUserIdStmt, $userCount);
        mysqli_stmt_fetch($checkUserIdStmt);
        mysqli_stmt_close($checkUserIdStmt);

        if ($userCount > 0) {
            redirect('user-create.php', 'User ID<strong> ' . $fid . ' </strong> already exists. Please choose a different one.');
        }

        $hashedPassword = password_hash($fpwd, PASSWORD_BCRYPT);

        // Use prepared statement to prevent SQL injection
        $sql = "INSERT INTO tb_user(user_id, user_ic, user_pwd, u_fName, u_lName, user_phone, user_email, type_id, acc_status)
                VALUES(?, ?, ?, ?, ?, ?, ?, ?, '1')";

        $stmt = mysqli_prepare($con, $sql);

        if ($stmt) {
            // Bind parameters
            mysqli_stmt_bind_param($stmt, "ssssssss", $fid, $fic, $hashedPassword, $ffname, $flname, $fphone, $femail, $ftype);

            // Execute the statement
            $result = mysqli_stmt_execute($stmt);

            if ($result) {
                redirect('user.php', 'User<strong> ' . $fid . ' </strong>added successfully');
            } else {
                redirect('user.php', 'Something went wrong');
            }

            // Close the statement
            mysqli_stmt_close($stmt);
        } else {
            // Prepare statement failed
            redirect('user.php', 'Error preparing statement');
        }
    } else {
        redirect('user-create.php', 'Please fill all the input fields');
    }
}

// Close DB Connection
mysqli_close($con);

// Redirect to the next page
header('Location:user.php');
?>