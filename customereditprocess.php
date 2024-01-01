<?php
// Include neccessary files

include('dbconnect.php');
include('function.php');



if(isset($_POST['saveuser'])){
    $fcustid = validate($_POST['fcustid']);
    
    $fname = validate($_POST['fname']);
    
    $fphone = validate($_POST['fphone']);
    $femail = validate($_POST['femail']);
    $fadd = validate($_POST['fadd']);


    if($fcustid != '' && $fname != '' && $fphone != '' && $femail != '' && $fadd != ''){
        
        
        $sql = "UPDATE tb_customer SET
        
        
        cust_name = ?,
        
        cust_phone = ?,
        cust_email = ?,
        cust_address = ?
        WHERE cust_id = ?";

        $stmt = mysqli_prepare($con, $sql);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "sssss", $fname, $fphone, $femail, $fadd, $fcustid);
            mysqli_stmt_execute($stmt);

            $affectedRows = mysqli_stmt_affected_rows($stmt);

            if ($affectedRows > 0) {
                // Update successful
                redirect('customer1.php', 'Customer updated successfully');
            } else {
                // Update failed
                redirect('customer1.php', 'No changes or error updating customer');
            }

            mysqli_stmt_close($stmt);
        } else {
            // Prepare statement failed
            redirect('customer1.php', 'Error updating customer');
        }
    }
}

// Close DB Connection
mysqli_close($con);

// Redirect to the next page
header('Location:customer1.php');
?>
