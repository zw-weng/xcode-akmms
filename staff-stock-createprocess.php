<?php

// Include necessary files

include('mysession.php');

if (!session_id()) {

    session_start();

}

include('dbconnect.php');

include('function.php');



if(isset($_POST['save_stock'])){

    $item_name = validate($_POST['item_name']);

    $item_desc = validate($_POST['item_desc']);

    $item_cost = validate($_POST['item_cost']);

    $item_qty = validate($_POST['item_qty']);

    $item_markup = validate($_POST['item_markup']);

    $item_category = validate($_POST['item_category']);



    if($item_name != '' || $item_desc != '' || $item_cost != '' || $item_qty != '' || $item_markup != '' || $item_category != ''){

        // Calculate the current price based on the markup

        $current_price = $item_cost * (1 + $item_markup / 100);



        // Use prepared statement to prevent SQL injection

        $sql = "INSERT INTO tb_advertising(item_name, item_desc, item_cost, item_qty, markup_rate, item_price, item_category_id)

                VALUES(?, ?, ?, ?, ?, ?, ?)";



        $stmt = mysqli_prepare($con, $sql);



        if ($stmt) {

            // Bind parameters

            mysqli_stmt_bind_param($stmt, "sssssss", $item_name, $item_desc, $item_cost, $item_qty, $item_markup, $current_price, $item_category);



            // Execute the statement

            $result = mysqli_stmt_execute($stmt);



            if($result){

                redirect('staff-stock.php', 'Stock item added successfully');

            } else {

                redirect('staff-stock-create.php', 'Something went wrong');

            }



            // Close the statement

            mysqli_stmt_close($stmt);

        } else {

            // Prepare statement failed

            redirect('staff-stock-create.php', 'Error preparing statement');

        }

    } else {

        redirect('staff-stock-create.php', 'Please fill all the input fields');

    }

}



// Close DB Connection

mysqli_close($con);

?>