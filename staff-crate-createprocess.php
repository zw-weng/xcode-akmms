<?php
// Include necessary files
include('mysession.php');
if (!session_id()) {
    session_start();
}
include('dbconnect.php');
include('function.php');

if(isset($_POST['save_c'])){
    $state = validate($_POST['state']);
    $district = validate($_POST['district']);
    $group_range = validate($_POST['group_range']);
    $crate = $_POST['crate'];

    if($state != '' || $district != '' || $group_range != '' || $crate != ''){
        // Use prepared statement to prevent SQL injection
        $sql = "INSERT INTO tb_civil (c_state, c_district, c_group, c_rate, c_status)
                VALUES(?, ?, ?, ?, 1)";

        $stmt = mysqli_prepare($con, $sql);

        if ($stmt) {
            // Bind parameters
            mysqli_stmt_bind_param($stmt, "sssd", $state, $district, $group_range, $crate);

            // Execute the statement
            $result = mysqli_stmt_execute($stmt);

            if($result){
                redirect('staff-jkr.php', 'New civil rate charged added successfully');
            } else {
                redirect('staff-crate-create.php', 'Something went wrong');
            }

            // Close the statement
            mysqli_stmt_close($stmt);
        } else {
            // Prepare statement failed
            redirect('staff-crate-create.php', 'Error preparing statement');
        }
    } else {
        redirect('staff-crate-create.php', 'Please fill all the input fields');
    }
}

// Close DB Connection
mysqli_close($con);
?>