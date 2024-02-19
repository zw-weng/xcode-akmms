<?php
session_start();
// Connect to DB
include('dbconnect.php');
include('function.php');

if (isset($_POST['forgotBtn'])) {
    $femail = filter_var($_POST['femail'], FILTER_SANITIZE_EMAIL);
    $token = md5(rand()) . "funda";

    // Check if the account is activated
    $check_activation = "SELECT user_email, u_fName, u_lName FROM tb_user WHERE user_email = ? AND acc_status = 1";
    $stmt_activation = mysqli_prepare($con, $check_activation);

    if ($stmt_activation) {
        mysqli_stmt_bind_param($stmt_activation, "s", $femail);
        mysqli_stmt_execute($stmt_activation);
        mysqli_stmt_store_result($stmt_activation);

        if (mysqli_stmt_num_rows($stmt_activation) > 0) {
            // Account is activated, proceed with sending the reset link
            mysqli_stmt_close($stmt_activation);

            $check_email = "SELECT user_email, u_fName, u_lName FROM tb_user WHERE user_email = ?";
            $stmt = mysqli_prepare($con, $check_email);

            if ($stmt) {
                mysqli_stmt_bind_param($stmt, "s", $femail);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_store_result($stmt);

                if (mysqli_stmt_num_rows($stmt) > 0) {
                    mysqli_stmt_bind_result($stmt, $get_email, $get_fname, $get_lname);
                    mysqli_stmt_fetch($stmt);

                    $get_name = $get_fname . ' ' . $get_lname;

                    $update_token = "UPDATE tb_user SET verify_token = ? WHERE user_email = ?";
                    $update_token_stmt = mysqli_prepare($con, $update_token);

                    if ($update_token_stmt) {
                        mysqli_stmt_bind_param($update_token_stmt, "ss", $token, $get_email);
                        mysqli_stmt_execute($update_token_stmt);

                        if (mysqli_stmt_affected_rows($update_token_stmt) > 0) {
                            send_password_reset($get_name, $get_email, $token);
                            redirect('password-reset.php', 'We have sent a password reset link to your email.');
                        } else {
                            redirect('password-reset.php', 'Something went wrong');
                        }

                        mysqli_stmt_close($update_token_stmt);
                    } else {
                        redirect('password-reset.php', 'Something went wrong');
                    }
                } else {
                    redirect('password-reset.php', 'Invalid email');
                }

                mysqli_stmt_close($stmt);
            } else {
                redirect('password-reset.php', 'Something went wrong');
            }
        } else {
            redirect('password-reset.php', 'Your account is not active. Please contact the administrator.');
        }
    } else {
        redirect('password-reset.php', 'Something went wrong');
    }
}

if (isset($_POST['resetBtn'])) {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $newpwd = mysqli_real_escape_string($con, $_POST['newpwd']);
    $confirmpwd = mysqli_real_escape_string($con, $_POST['confirmpwd']);

    $token = mysqli_real_escape_string($con, $_POST['password_token']);

    if (!empty($token)) {
        // Trim any extra whitespace from the token
        $token = trim($token);

        if (!empty($email) && !empty($newpwd) && !empty($confirmpwd)) {
            // Validate token
            $check_token = "SELECT verify_token FROM tb_user WHERE verify_token = ?";
            $check_token_stmt = mysqli_prepare($con, $check_token);

            if ($check_token_stmt) {
                mysqli_stmt_bind_param($check_token_stmt, "s", $token);
                mysqli_stmt_execute($check_token_stmt);
                mysqli_stmt_store_result($check_token_stmt);

                if (mysqli_stmt_num_rows($check_token_stmt) > 0) {
                    if ($newpwd == $confirmpwd) {
                        // Validate password
                        if (!isValidPassword($newpwd)) {
                            redirect('password-change.php?token='.$token.'&email='.$email.'', 'Invalid password format');
                        }
                        // Hash the new password
                        $hashedPassword = password_hash($newpwd, PASSWORD_BCRYPT);

                        $update_password = "UPDATE tb_user SET user_pwd = ? WHERE verify_token = ?";
                        $update_password_stmt = mysqli_prepare($con, $update_password);

                        if ($update_password_stmt) {
                            mysqli_stmt_bind_param($update_password_stmt, "ss", $hashedPassword, $token);
                            mysqli_stmt_execute($update_password_stmt);

                            if (mysqli_stmt_affected_rows($update_password_stmt) > 0) {
                                $newtoken = md5(rand()) . "funda";
                                $update_new_token = "UPDATE tb_user SET verify_token = ? WHERE verify_token = ?";
                                $update_new_token_stmt = mysqli_prepare($con, $update_new_token);

                                if ($update_new_token_stmt) {
                                    mysqli_stmt_bind_param($update_new_token_stmt, "ss", $newtoken, $token);
                                    mysqli_stmt_execute($update_new_token_stmt);
                                    redirect("index.php", 'New password is updated successfully.');
                                } else {
                                    redirect('password-change.php?token='.$token.'&email='.$email.'', 'Something went wrong');
                                }

                                mysqli_stmt_close($update_new_token_stmt);
                            } else {
                                redirect('password-change.php?token='.$token.'&email='.$email.'', 'Something went wrong');
                            }

                            mysqli_stmt_close($update_password_stmt);
                        } else {
                            redirect('password-change.php?token='.$token.'&email='.$email.'', 'Something went wrong');
                        }
                    } else {
                        redirect('password-change.php?token='.$token.'&email='.$email.'', 'Password and confirm password do not match');
                    }
                } else {
                    redirect('password-change.php?token='.$token.'&email='.$email.'', 'Invalid token');
                }

                mysqli_stmt_close($check_token_stmt);
            } else {
                redirect('password-change.php?token='.$token.'&email='.$email.'', 'Something went wrong');
            }
        } else {
            redirect('password-change.php?token='.$token.'&email='.$email.'', 'All fields are mandatory');
        }
    } else {
        redirect('password-reset.php', 'No token available');
    }
}

// Close DB Connection
mysqli_close($con);
?>