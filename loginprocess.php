<?php
session_start();

// Connect to DB
include('dbconnect.php');
include('function.php');

if (isset($_POST['loginBtn'])) {
    $fid = validate($_POST['fid']);
    $fpwd = validate($_POST['fpwd']);

    $fid = filter_var($fid, FILTER_SANITIZE_STRING);
    $fpwd = filter_var($fpwd, FILTER_SANITIZE_STRING);

    if ($fid != '' && $fpwd != '') {
        // Use prepared statement to prevent SQL injection
        $sql = "SELECT * FROM tb_user WHERE user_id=? LIMIT 1";
        $stmt = mysqli_prepare($con, $sql);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "s", $fid);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if ($result) {
                if (mysqli_num_rows($result) == 1) {
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                    $hashedPassword = $row['user_pwd'];

                    // Use password_verify to check the hashed password
                    if (!password_verify($fpwd, $hashedPassword)) {
                        redirect('index.php', 'Authentication failed. If you continue to experience issues, contact support.');
                    }

                    // Check acc_status
                    if ($row['acc_status'] == 1) {
                        $_SESSION['user_id'] = session_id();
                        $_SESSION['suid'] = $fid;

                        // User available
                        if ($row['type_id'] == '1') {
                            // Staff
                            header('Location:staffmain.php');
                        } else {
                            // Admin
                            header('Location:adminmain.php');
                        }
                    } else {
                        // Account is not active
                        redirect('index.php', 'Your account is not active. Please contact the administrator.');
                    }
                } else {
                    redirect('index.php', 'Authentication failed. If you continue to experience issues, contact support.');
                }
            } else {
                redirect('index.php', 'Something went wrong.');
            }

            mysqli_stmt_close($stmt);
        } else {
            redirect('index.php', 'Something went wrong.');
        }
    } else {
        redirect('index.php', 'All fields are mandatory.');
    }

    // Close DB Connection
    mysqli_close($con);
}
?>