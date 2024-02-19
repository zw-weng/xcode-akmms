<?php
// Include necessary files
include('mysession.php');
if (!session_id()) {
    session_start();
}
include('dbconnect.php');
include('function.php');

if(isset($_POST['save_jkr'])){
    $material_name = validate($_POST['material_name']);
    $material_desc = validate($_POST['material_desc']);
    $material_cost = validate($_POST['material_cost']);
    $material_unit = validate($_POST['material_unit']);
    $material_category = validate($_POST['ftype']);

    if($material_name != '' || $material_desc != '' || $material_cost != '' || $material_unit != '' || $material_category != ''){
        // Use prepared statement to prevent SQL injection
        $sql = "INSERT INTO tb_construction (material_name, material_desc, material_cost, material_unit, material_category_id, material_status)
                VALUES(?, ?, ?, ?, ?, 1)";

        $stmt = mysqli_prepare($con, $sql);

        if ($stmt) {
            // Bind parameters
            mysqli_stmt_bind_param($stmt, "sssss", $material_name, $material_desc, $material_cost, $material_unit, $material_category);

            // Execute the statement
            $result = mysqli_stmt_execute($stmt);

            if($result){
                redirect('staff-jkr.php', 'New material added successfully');
            } else {
                redirect('staff-jkr-create.php', 'Something went wrong');
            }

            // Close the statement
            mysqli_stmt_close($stmt);
        } else {
            // Prepare statement failed
            redirect('staff-jkr-create.php', 'Error preparing statement');
        }
    } else {
        redirect('staff-jkr-create.php', 'Please fill all the input fields');
    }
}

// Close DB Connection
mysqli_close($con);
?>