<?php
session_start();

//Connect to DB
include('dbconnect.php');
include('function.php');

if(isset($_POST['forgotBtn'])){
    $femail = mysqli_real_escape_string($con, validate($_POST['femail']));
    $token = md5(rand());

    $check_email = "SELECT user_email, u_fName, u_lName FROM tb_user WHERE user_email = '$femail' LIMIT 1";
    $check_email_run = mysqli_query($con, $check_email);

    if(mysqli_num_rows($check_email_run) > 0){
        $row = mysqli_fetch_array($check_email_run);
        $get_fname = $row['u_fName'];
        $get_lname = $row['u_lName'];
        $get_name = $get_fname . ' ' . $get_lname;
        $get_email = $row['user_email'];

        $update_token = "UPDATE tb_user SET verify_token = '$token' WHERE user_email = '$get_email' LIMIT 1";
        $update_token_run = mysqli_query($con, $update_token);

        if($update_token_run){
            send_password_reset($get_name, $get_email, $token);
            redirect('password-reset.php', 'We have sent a password reset link to your email');

        }
        else{
            redirect('password-reset.php', 'Something went wrong');
        }
    }
    else{
        redirect('password-reset.php', 'Invalid email');
    }
}

if(isset($_POST['resetBtn'])){
    $email = mysqli_real_escape_string($con, validate($_POST['email']));
    $newpwd = mysqli_real_escape_string($con, validate($_POST['newpwd']));
    $confirmpwd = mysqli_real_escape_string($con, validate($_POST['confirmpwd']));

    $token = mysqli_real_escape_string($con, validate($_POST['password_token']));

    if(!empty($token)){
        if(!empty($email) && !empty($newpwd) && !empty($confirmpwd)){
            // validate token
            $check_token = "SELECT verify_token FROM tb_user WHERE verify_token = '$token' LIMIT 1";
            $check_token_run = mysql_query($con, $check_token);

            if(mysqli_num_rows($check_token_run) > 0){
                if($newpwd == $confirmpwd){
                    $update_password = "UPDATE tb_user SET user_pwd = '$newpwd' WHERE verify_token = '$token' LIMIT 1";
                    $update_password_run = mysqli_query($con, $update_password);

                    if($update_password_run){
                        $newtoken = md5(rand())."funda";
                        $update_new_token = "UPDATE tb_user SET verify_token = '$newtoken' WHERE verify_token = '$token' LIMIT 1";
                        $update_new_token_run = mysqli_query($con, $update_new_token);
                        redirect('login.php', 'New password is updated successfully');
                    }
                    else{
                        redirect('password-change.php?token=$token&email=$email', 'Something went wrong');
                    }
                }
                else{
                    redirect('password-change.php?token=$token&email=$email', 'Password and confirm password does not match');
                }
            }
            else{
                redirect('password-change.php?token=$token&email=$email', 'Invalid token');
            }
        }
        else{
            redirect('password-change.php?token=$token&email=$email', 'All fields are mandatory');
        }
    }
    else{
        redirect('password-reset.php', 'No token available');
    }
}
?>