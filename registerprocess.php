<?php
//Connect to DB
include('dbconnect.php');

//retrieve data from registration form
$fid=$_POST['fid'];
$fic=$_POST['fic'];
$ffname=$_POST['ffname'];
$flname=$_POST['flname'];
$fpwd=$_POST['fpwd'];
$fphone=$_POST['fphone'];
$femail=$_POST['femail'];
$fadd=$_POST['fadd'];
$fposition=$_POST['fposition'];
$ftype=$_POST['ftype'];

//Secure password hash
$hash = password_hash($fpwd, PASSWORD_DEFAULT);

//CRUD Operations
//CREATE-SQL Insert statement
$sql="INSERT INTO tb_user(user_id, user_ic, user_pwd, u_fName, u_lName, user_phone,user_email, user_address, user_position, type_id)
		VALUES('$fid', '$fic', '$ffname', '$flname', '$fpwd', '$fphone', '$femail', '$fadd', '$fposition', '$ftype')";

$stmt = mysqli_prepare($con, $sql);

// Bind parameters to the prepared statement
mysqli_stmt_bind_param($stmt, "ssssssssss", $fid, $fic, $hash, $ffname, $flname, $fphone, $femail, $fadd, $fposition, $ftype);

// Execute the prepared statement
mysqli_stmt_execute($stmt);

// Close the prepared statement
mysqli_stmt_close($stmt);

// Close DB Connection
mysqli_close($con);

// Redirect to the next page
header('Location: user-management.php');

?>