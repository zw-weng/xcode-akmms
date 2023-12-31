<?php
session_start();

//Connect to DB
include('dbconnect.php');
include('function.php');

if(isset($_POST['loginBtn'])){
	$fid = validate($_POST['fid']);
	$fpwd = validate($_POST['fpwd']);

	$fid = filter_var($fid, FILTER_SANITIZE_STRING);
	$fpwd = filter_var($fpwd, FILTER_SANITIZE_STRING);

	if($fid != '' && $fpwd != ''){
		$sql = "SELECT * FROM tb_user WHERE user_id='$fid' AND user_pwd='$fpwd' LIMIT 1";
		$result = mysqli_query($con,$sql);

		if($result){
			if(mysqli_num_rows($result) == 1){
				$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
				$_SESSION['user_id']=session_id();
				$_SESSION['suid']=$fid;

				//User available
				if($row['type_id'] == '1') //Staff
				{
					redirect('staffmain.php', 'Logged In Successfully');
				}
				else
				{
					redirect('adminmain.php', 'Logged In Successfully');
				}	
			}
			else{
				redirect('login.php', 'Invalid User ID or Password');
			}
		}
		else{
			redirect('login.php', 'Something went wrong');
		}
	}
	else{
		redirect('login.php', 'All fields are mandatory');
	}
}

//Close DB Conncetion
mysqli_close($con);

?>
