<?php
session_start();

//Connect to DB
include('dbconnect.php');

//Retrieve data from login form
$fid = $_POST['fid'];
$fpwd = $_POST['fpwd'];

//CRUD Operations
//RETRIEVE - SQL retrieve statement
$sql = "SELECT * FROM tb_user WHERE user_id=?";

// Use prepared statements to prevent SQL injection
$stmt = mysqli_prepare($con, $sql);
mysqli_stmt_bind_param($stmt, "s", $fid);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($result);

// Check if user exists and password is correct
if ($row && password_verify($fpwd, $row['user_pwd'])) {
    $_SESSION['user_id'] = session_id();
    $_SESSION['suid'] = $fid;

    // User available
    if ($row['type_id'] == '1') //Staff
    {
        $_SESSION['notification'] = 'Welcome, staff member!';
        header('Location: staffmain.php');
    } else {
        $_SESSION['notification'] = 'Welcome, administrator!';
        header('Location: adminmain.php');
    }
} else {
    // Data not available/exist
    // Add script to let the user know either username or pwd wrong
    $_SESSION['error'] = 'Username or password is incorrect. Please try again.';
    header('Location: login.php');
}

// Close the statement
mysqli_stmt_close($stmt);

// Close DB Connection
mysqli_close($con);
?>