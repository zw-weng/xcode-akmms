<?php
// Include neccessary files
include('mysession.php');
include('dbconnect.php');
include('function.php');

// Get user id from url
if (isset($_GET['id'])) {
    $fid = $_GET['id'];

    // Validate and sanitize the user ID to prevent SQL injection
    $fid = mysqli_real_escape_string($con, $fid);
    $fid = htmlspecialchars($fid); // Additional input sanitization
}

if(isset($_POST['saveuser'])){
    $fid = validate($_POST['fid']);
    $fic = validate($_POST['fic']);
    $ffname = validate($_POST['ffname']);
    $flname = validate($_POST['flname']);
    $fpwd = validate($_POST['fpwd']);
    $fphone = validate($_POST['fphone']);
    $femail = validate($_POST['femail']);
    $ftype = validate($_POST['ftype']);


    if($fid != '' && $fic != '' && $ffname != '' && $flname != '' && $fpwd != '' && $fphone != '' && $femail != '' && $ftype != ''){
        $hashedPassword = password_hash($fpwd, PASSWORD_BCRYPT);
        
        $sql = "UPDATE tb_user SET
        user_ic = ?,
        user_pwd = ?,
        u_fName = ?,
        u_lName = ?,
        user_phone = ?,
        user_email = ?,
        type_id = ?
        WHERE user_id = ?";

        $stmt = mysqli_prepare($con, $sql);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "issssssis", $fic, $hashedPassword, $ffname, $flname, $fphone, $femail, $ftype, $fid);
            mysqli_stmt_execute($stmt);

            $affectedRows = mysqli_stmt_affected_rows($stmt);

            if ($affectedRows > 0) {
                // Update successful
                redirect('user.php', 'User updated successfully');
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
