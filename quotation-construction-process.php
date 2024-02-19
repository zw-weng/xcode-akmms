<?php
// Connect to DB
include('dbconnect.php');

// Retrieve data from quotation form
$quotation_id = $_POST['quotation_id'];
$cust_id = $_POST['cust_id'];
$client_name = $_POST['client_name'];
$client_street = $_POST['client_street'];
$client_postcode = $_POST['client_postcode'];
$client_city = $_POST['client_city'];
$client_state = $_POST['client_state'];
$client_country = $_POST['client_country'];
$item_id = $_POST['item_id'];
$material_id = $_POST['material_id'];
$product_price = $_POST['product_price'];
$product_desc = $_POST['product_desc'];
$quantity = $_POST['quantity'];
$disc = $_POST['disc'];
$disc_amount = $_POST['disc_amount'];
$tax_code = $_POST['tax_code'];
$tax_amount = $_POST['tax_amount'];
$total = $_POST['total'];
$grand_total = $_POST['grand_total'];
$quotation_type_id = $_POST['quotation_type_id'];
$quotation_status_id = $_POST['quotation_status_id'];
$payment_term_id = $_POST['payment_term_id'];
$quotation_date = $_POST['quotation_date'];

// CRUD Operations
// CREATE - SQL Insert statement
$sql = "INSERT INTO tb_quotation (
        quotation_id, cust_id, client_name, client_street, client_postcode, client_city, client_state, client_country,
        item_id, material_id, product_price, product_desc, quantity, dic, disc_amount, tax_code, tax_amount,
        total, grand_total, quotation_type_id, quotation_status_id, payment_term_id, quotation_date
    ) VALUES (
        $quotation_id, $cust_id, $client_name, $client_street, $client_postcode, $client_city, $client_state, $client_country, $item_id, $material_id, $product_price, $product_desc, $quantity, $disc, $disc_amount, $tax_code, $tax_amount, $total, $grand_total, $quotation_type_id, $quotation_status_id, $payment_term_id, $quotation_date
    )";

$stmt = mysqli_prepare($con, $sql);

// Bind parameters to the prepared statement
mysqli_stmt_bind_param(
    $stmt,
    "ssssssssssssssssssssss",
    $quotation_id, $cust_id, $client_name, $client_street, $client_postcode, $client_city, $client_state, $client_country,
    $item_id, $material_id, $product_price, $product_desc, $quantity, $disc, $disc_amount, $tax_code, $tax_amount,
    $total, $grand_total, $quotation_type_id, $quotation_status_id, $payment_term_id, $quotation_date
);

// Execute the prepared statement
mysqli_stmt_execute($stmt);

// Close the prepared statement
mysqli_stmt_close($stmt);

// Close DB Connection
mysqli_close($con);

// Redirect to the next page
header('Location: quotation-construction.php');
?>
