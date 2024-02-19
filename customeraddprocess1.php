<?php
// Include neccessary files
include('mysession.php');
include('dbconnect.php');
include('function.php');

if(isset($_POST['saveuser'])){
    
    $fname = validate($_POST['fname']);
    $fphone = validate($_POST['fphone']);
    $femail = validate($_POST['femail']);
    $fstreet = validate($_POST['fstreet']);
    $fpostcode = validate($_POST['fpostcode']);
    $fcity = validate($_POST['fcity']);
    $fstate = validate($_POST['fstate']);
    $fcountry = validate($_POST['fcountry']);

    if($fname != '' || $fphone != '' || $femail != '' || $fstreet != '' || $fpostcode != '' || $fcity != '' || $fstate != '' || $fcountry != ''){
        // Validate email
        if (!filter_var($femail, FILTER_VALIDATE_EMAIL)) {
            redirect('customeradd1.php', 'Invalid email format');
        }

        // Use prepared statement to prevent SQL injection
        $sql = "INSERT INTO tb_customer(cust_name, cust_phone, cust_email, cust_street, cust_postcode, cust_city, cust_state, cust_country, cust_status)
                VALUES(?, ?, ?, ?, ?, ?, ?, ?, 1)";

        $stmt = mysqli_prepare($con, $sql);

        if ($stmt) {
            // Bind parameters
            mysqli_stmt_bind_param($stmt, "ssssisss", $fname, $fphone, $femail, $fstreet, $fpostcode, $fcity, $fstate, $fcountry);

            // Execute the statement
            $result = mysqli_stmt_execute($stmt);

            if($result){
                redirect('customer1.php', 'New customer added successfully');
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
header('Location:customer1.php');

?>
