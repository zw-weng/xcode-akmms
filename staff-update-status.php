<?php

include('mysession.php');

if (!session_id()) {

    session_start();

}

include('dbconnect.php');

include('function.php');



$quotation_id = $_GET['quotation_id'];

$status_id = $_GET['status_id'];







// Prepare an SQL statement to update status_id in tb_quotation

$update_sql = "UPDATE tb_quotation SET quotation_status_id = 1 WHERE quotation_id = $quotation_id";



// Execute the SQL query

if(mysqli_query($con, $update_sql)){

    redirect( 'staff-quote.php',"Quotation status updated successfully.");

} else{

    echo "ERROR: Could not able to execute $update_sql. " . mysqli_error($con);

}



// Retrieve the quotation_type_id from tb_quotation

$sql = "SELECT quotation_type_id FROM tb_quotation WHERE quotation_id=$quotation_id";

$result = $con->query($sql);



if ($result->num_rows > 0) {

  // output data of each row

  while($row = $result->fetch_assoc()) {

    $quotation_type_id = $row["quotation_type_id"];

  }

} else {

  echo "No results";

}





if ($quotation_type_id == 1 && $status_id == 1) {

// Prepare an SQL statement to insert default values into tb_salesorder

$sql = "INSERT INTO tb_salesorder (staff_incharge, remark, payment_status_id, payment_id, order_status_id, quotation_id, inventory_updated) VALUES ('', NULL, 1, '1', 0, $quotation_id, 1)";



// Execute the SQL query

if(mysqli_query($con, $sql)){

    redirect( "staff-quote.php","Records inserted successfully.");

} else{

    echo "ERROR: Could not able to execute $sql. " . mysqli_error($con);

}

}

$con->close();



exit();

?>

