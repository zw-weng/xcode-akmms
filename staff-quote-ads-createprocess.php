<?php

// Include necessary files

include('mysession.php');

if (!session_id()) {

    session_start();

}

include('dbconnect.php');

include('function.php');



if (isset($_POST['save_info'])) {

    $quotationId = validate($_POST['quotationId']);

    $quotationDate = validate($_POST['quotationDate']);

    $paymentTerm = validate($_POST['paymentTerm']);

    $fname = validate($_POST['fname']);

    $femail = validate($_POST['femail']);

    $fphone = validate($_POST['fphone']);

    $fstreet = validate($_POST['fstreet']);

    $fpostcode = validate($_POST['fpostcode']);

    $fcity = validate($_POST['fcity']);

    $fstate = validate($_POST['fstate']);

    $fcount = validate($_POST['fcount']);

    $qty = $_POST['quantity'];

    $unit_price = $_POST['unit_price'];

    $disc = $_POST['disc'];

    $disc_amount = $_POST['disc_amount'];

    $tax_code = $_POST['tax_code'];

    $tax_amount = $_POST['tax_amount'];

    $sub_total = $_POST['sub_total'];

    $item_id = $_POST['item_id'];

    $item_name = $_POST['item_name'];

    $item_desc = $_POST['item_desc'];



    if ($quotationId != '' || $quotationDate != '' || $paymentTerm != '' || $fname != '' || $femail != '' || $fphone != '' || $fstreet != '' || $fpostcode != '' || $fcity != '' || $fstate != '' || $fcount != '') {

        // Check if the customer with the same name already exists

        $checkCustomerSql = "SELECT cust_id FROM tb_customer WHERE cust_name = ?";

        $checkCustomerStmt = mysqli_prepare($con, $checkCustomerSql);



        if ($checkCustomerStmt) {

            mysqli_stmt_bind_param($checkCustomerStmt, "s", $fname);

            mysqli_stmt_execute($checkCustomerStmt);

            mysqli_stmt_store_result($checkCustomerStmt);



            if (mysqli_stmt_num_rows($checkCustomerStmt) > 0) {

                // Customer with the same name already exists, get the existing customer ID

                mysqli_stmt_bind_result($checkCustomerStmt, $existingCustomerId);

                mysqli_stmt_fetch($checkCustomerStmt);



                // Use existing customer ID

                $customerId = $existingCustomerId;

            } else {

                // Customer with the same name doesn't exist, insert a new customer

                $customerSql = "INSERT INTO tb_customer(cust_name, cust_email, cust_phone, cust_street, cust_postcode, cust_city, cust_state, cust_country, cust_status)

                                VALUES(?, ?, ?, ?, ?, ?, ?, ?, 1)";



                $customerStmt = mysqli_prepare($con, $customerSql);



                if ($customerStmt) {

                    // Bind parameters

                    mysqli_stmt_bind_param($customerStmt, "ssssssss", $fname, $femail, $fphone, $fstreet, $fpostcode, $fcity, $fstate, $fcount);



                    // Execute the statement

                    $customerResult = mysqli_stmt_execute($customerStmt);



                    if ($customerResult) {

                        // Get the last inserted customer ID

                        $customerId = mysqli_insert_id($con);

                    } else {

                        redirect('staff-quote-jkr-create.php', 'Something went wrong with tb_customer insertion');

                    }



                    // Close the statement

                    mysqli_stmt_close($customerStmt);

                } else {

                    // Prepare statement failed

                    redirect('staff-quote-jkr-create.php', 'Error preparing tb_customer statement');

                }

            }



            // Close the statement

            mysqli_stmt_close($checkCustomerStmt);

        } else {

            // Prepare statement failed

            redirect('staff-quote-jkr-create.php', 'Error preparing checkCustomer statement');

        }



        // Calculate grand total

        $grandTotal = 0;

        foreach ($sub_total as $subtotal) {

            $grandTotal += floatval($subtotal);

        }



        // Insert into tb_quotation

        $quotationTypeId = 1;

        $quotationStatusId = 2;

        $quotationSql = "INSERT INTO tb_quotation(quotation_id, cust_id, quotation_date, payment_term_id, grand_total, quotation_status_id, quotation_type_id, product_id)

                        VALUES(?, ?, ?, ?, ?, ?, ?, 0)";



        $quotationStmt = mysqli_prepare($con, $quotationSql);



        if ($quotationStmt) {

            // Bind parameters

            mysqli_stmt_bind_param($quotationStmt, "sssssdd", $quotationId, $customerId, $quotationDate, $paymentTerm, $grandTotal, $quotationStatusId, $quotationTypeId);



            // Execute the statement

            $quotationResult = mysqli_stmt_execute($quotationStmt);



            if ($quotationResult) {

                // Get the last inserted quotation ID

                $quotationId = mysqli_insert_id($con);



                for ($i = 0; $i < count($qty); $i++) {

                    // Combine item name and item description

                    $productName[$i] = "{$item_name[$i]} - {$item_desc[$i]}";

                    $productSql = "INSERT INTO tb_product(item_id, product_name, product_price, product_qty, disc, disc_amount, tax_code, tax_amount, product_subtotal, quotation_id)

                    VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

                    $productStmt = mysqli_prepare($con, $productSql);



                    if ($productStmt) {

                        // Define new variables

                        $itemId = $item_id[$i];

                        $productNameValue = $productName[$i]; // Changed variable name to avoid conflict

                        $unitPrice = $unit_price[$i];

                        $quantity = $qty[$i];

                        $discount = $disc[$i];

                        $discountAmount = $disc_amount[$i];

                        $taxCode = $tax_code[$i];

                        $taxAmount = $tax_amount[$i];

                        $subtotal = $sub_total[$i];



                        // Bind parameters

                        mysqli_stmt_bind_param($productStmt, "isdiididdi", $itemId, $productNameValue, $unitPrice, $quantity, $discount, $discountAmount, $taxCode, $taxAmount, $subtotal, $quotationId);

                    } else {

                        // Prepare statement failed

                        redirect('staff-quote-jkr-create.php', 'Error preparing tb_product statement');

                    }



                    // Execute the statement

                    $productResult = mysqli_stmt_execute($productStmt);



                    if (!$productResult) {

                        redirect('staff-quote-jkr-create.php', 'Something went wrong with tb_product insertion');

                    }



                    // Close the statement

                    mysqli_stmt_close($productStmt);

                }

            } else {

                // Prepare statement failed

                redirect('staff-quote-jkr-create.php', 'Error preparing tb_product statement');

            }

        }





        // Redirect to the next step or perform other actions

        redirect('staff-quote.php', 'Quotation created successfully');

    } else {

        redirect('staff-quote-jkr-create.php', 'Something went wrong with tb_quotation insertion');

    }



    // Close the statement

    mysqli_stmt_close($quotationStmt);

} else {

    // Prepare statement failed

    redirect('staff-quote-jkr-create.php', 'Error preparing tb_quotation statement');

}





// Close DB Connection

mysqli_close($con);

