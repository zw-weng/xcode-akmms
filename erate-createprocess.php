<?php
// Include necessary files
include('mysession.php');
if (!session_id()) {
    session_start();
}
include('dbconnect.php');
include('function.php');

if(isset($_POST['save_e'])){
    $state = validate($_POST['state']);
    $district = validate($_POST['district']);
    $group_range = validate($_POST['group_range']);
    $erate = $_POST['erate'];

    if($state != '' || $district != '' || $group_range != '' || $erate != ''){
        // Use prepared statement to prevent SQL injection
        $sql = "INSERT INTO tb_electric (e_state, e_district, e_group, e_rate, e_status)
                VALUES(?, ?, ?, ?, 1)";

        $stmt = mysqli_prepare($con, $sql);

        if ($stmt) {
            // Bind parameters
            mysqli_stmt_bind_param($stmt, "sssd", $state, $district, $group_range, $erate);

            // Execute the statement
            $result = mysqli_stmt_execute($stmt);

            if($result){
                redirect('jkr.php', 'New electric rate charged added successfully');
            } else {
                redirect('erate-create.php', 'Something went wrong');
            }

            // Close the statement
            mysqli_stmt_close($stmt);
        } else {
            // Prepare statement failed
            redirect('erate-create.php', 'Error preparing statement');
        }
    } else {
        redirect('erate-create.php', 'Please fill all the input fields');
    }
}

// Close DB Connection
mysqli_close($con);
?>