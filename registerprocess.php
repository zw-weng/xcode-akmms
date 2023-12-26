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

//CRUD Operations
//CREATE-SQL Insert statement
$sql="INSERT INTO tb_user(user_id, user_ic, user_pwd, u_fName, u_lName, user_phone,user_email, user_address, user_position, type_id)
		VALUES('$fid', '$fic', '$fpwd', '$ffname', '$flname', '$fphone', '$femail', '$fadd', '$fposition', '$ftype')";

//echo var_dump();

//Execute SQL
mysqli_query($con,$sql);

//Close DB Conncetion
mysqli_close($con);

//Redirect to next page
header('Location:userlist.php');

?>