<?php
// Include database connection
include ('dbconnect.php');

function validate($inputData){
	global $con;

	return mysqli_real_escape_string($con, trim($inputData));
}

function redirect($url, $status){
	$_SESSION['status'] = $status;
	header('Location: '.$url);
	exit(0);
}

function alertMessage(){
	if(isset($_SESSION['status'])){
		echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-1"></i>
                '.$_SESSION['status'].'
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>';
		unset($_SESSION['status']);
	}
}

?>
