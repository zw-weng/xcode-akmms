<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

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

function send_password_reset($get_name, $get_email, $token){
	//Create an instance; passing `true` enables exceptions
	$mail = new PHPMailer(true);

	//Server settings
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = '';                     //SMTP username
    $mail->Password   = '';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('', $get_name);
    $mail->addAddress($get_email);               //Name is optional

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Reset Password Notification';

    $email_template = "<h2>AK Maju Resources</h2><h3>You are receiving this email because we received a password reset request for your AKMMS account.</h3><br/><br/><a href='http://localhost/akmms/password-change.php?token=$token&email=$get_email'> Click Me </a>";

    $mail->Body = $email_template;

    $mail->send();
}

?>
