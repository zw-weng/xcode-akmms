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

    if($fcustid != '' ||  $fname != '' || $fphone != '' || $femail != '' || $fadd != ''){
        
        // Use prepared statement to prevent SQL injection
        $sql = "INSERT INTO tb_customer(cust_id, cust_name, cust_phone, cust_email, cust_address)
                VALUES(?, ?, ?, ?, ?)";

        $stmt = mysqli_prepare($con, $sql);

        if ($stmt) {
            // Bind parameters
            mysqli_stmt_bind_param($stmt, "sssss", $fcustid,  $fname, $fphone, $femail, $fadd);

            // Execute the statement
            $result = mysqli_stmt_execute($stmt);

            if($result){
                redirect('customer1.php', 'New Customer added successfully');
            } else {
                redirect('customer1.php', 'Something went wrong');
            }

            // Close the statement
            mysqli_stmt_close($stmt);
        } else {
            // Prepare statement failed
            redirect('customer1.php', 'Error preparing statement');
        }
    } else {
        redirect('customeradd1.php', 'Please fill all the input fields');
    }
}

// Close DB Connection
mysqli_close($con);

// Redirect to the next page
header('Location:user.php');

?>
