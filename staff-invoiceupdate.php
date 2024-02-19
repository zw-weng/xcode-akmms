<?php
include('mysession.php');
if (!session_id()) {
    session_start();
}
include 'headerstaff.php';

include 'dbconnect.php';

if (isset($_GET['quotation_id'])) {
    $quotation_id = $_GET['quotation_id'];
} else {
    // Handle the case where no quotation_id is provided
    echo "No quotation_id provided";
    exit();
}
?>

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Invoice</h1>
        <div class="d-flex justify-content-between align-items-center">
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="staffmain.php">Home</a></li>
                    <li class="breadcrumb-item"><a href="staff-invoicelist.php">Invoice</a></li>
                    <li class="breadcrumb-item active">Update Invoice</li>
                </ol>
            </nav>
            <div class="btn-group me-2">
                <a href="staff-invoicelist.php" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Back</a>
            </div>
        </div>
    </div><!-- End Page Title -->
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Update Invoice</h5>
                        <div class="table-responsive">
                            <form method="post" action="staff-invoiceupdateprocess.php">
                                <?php
                                $query = "SELECT tb_deliveryorder.delivery_id, tb_quotation.cust_id, tb_quotation.quotation_id, tb_customer.cust_name, CONCAT(tb_customer.cust_street, ', ', tb_customer.cust_postcode, ', ', tb_customer.cust_city, ', ', tb_customer.cust_state, ', ', tb_customer.cust_country) AS customer_address, tb_paymentterm.payment_term_id, tb_paymentterm.payment_term_desc, tb_product.product_id, tb_product.product_name, tb_product.product_qty, tb_product.disc, tb_invoice.invoice_id, tb_invoice.invoice_amount_payable, tb_invoice.invoice_balance, tb_invoice.invoice_upfront
FROM tb_deliveryorder 
JOIN tb_quotation ON tb_deliveryorder.quotation_id = tb_quotation.quotation_id
JOIN tb_customer ON tb_quotation.cust_id = tb_customer.cust_id
JOIN tb_product ON tb_quotation.quotation_id = tb_product.quotation_id
JOIN tb_paymentterm ON tb_quotation.payment_term_id = tb_paymentterm.payment_term_id
JOIN tb_invoice ON tb_quotation.quotation_id = tb_invoice.quotation_id
WHERE tb_deliveryorder.quotation_id = $quotation_id";
                                $result = mysqli_query($con, $query);
                                $row = mysqli_fetch_assoc($result); // Assuming there's only one matching record
                                echo "<input type='hidden' name='quotation_id' value='{$row['quotation_id']}'>"; // Add this line
                                echo "<label for='delivery_id' class='form-label'>Delivery Order ID</label>";
                                echo "<input type='text' class='form-control' id='delivery_id' value='{$row['delivery_id']}' disabled><br>";
                                echo "<label for='cust_id' class='form-label'>Customer Name</label>";
                                echo "<input type='text' class='form-control' id='cust_id' value='{$row['cust_name']}' disabled><br>";
                                echo "<label for='customer_address' class='form-label'>Customer Address</label>";
                                echo "<input type='text' class='form-control' id='customer_address' value='{$row['customer_address']}' disabled><br>";
                                echo "<label for='invoice_amount_payable' class='form-label'>Invoice Amount Payable</label>";
                                echo "<input type='text' class='form-control' id='invoice_amount_payable' name='invoice_amount_payable' value='{$row['invoice_amount_payable']}' disabled><br>";
                                echo "<label for='invoice_balance' class='form-label'>Invoice Balance</label>";
                                echo "<input type='text' class='form-control' id='invoice_balance' name='invoice_balance' value='{$row['invoice_balance']}' disabled><br>";
                                echo "<label for='invoice_upfront' class='form-label'>Invoice Upfront</label>";
                                echo "<input type='number' class='form-control' id='invoice_upfront' name='invoice_upfront' max='{$row['invoice_amount_payable']}' value='{$row['invoice_upfront']}' required step=0.01><br>";
                                echo "<label for='payment_term_desc' class='form-label'>Payment Term</label>";
                                echo "<select class='form-control' id='payment_term' name='payment_term_id' disabled><br>"; // Add disabled attribute
                                // Fetch and display payment term options from tb_paymentterm
                                $paymentTermQuery = "SELECT payment_term_id, payment_term_desc FROM tb_paymentterm";
                                $paymentTermResult = mysqli_query($con, $paymentTermQuery);
                                while ($termRow = mysqli_fetch_assoc($paymentTermResult)) {
                                    $selected = ($termRow['payment_term_id'] == $row['payment_term_id']) ? 'selected' : '';
                                    echo "<option value='{$termRow['payment_term_id']}' $selected>{$termRow['payment_term_desc']}</option>";
                                }
                                echo "</select>";
                                echo "<table class='table'>";
                                echo "<thead>";
                                echo "<tr>";
                                echo "<th>Product ID</th>";
                                echo "<th>Product Description</th>";
                                echo "<th>Product Quantity</th>";
                                echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";

                                $query = "SELECT tb_product.product_id, tb_product.product_name, tb_product.product_qty
FROM tb_product
WHERE tb_product.quotation_id = $quotation_id";

                                $result = mysqli_query($con, $query);

                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<tr>";
                                    echo "<td>{$row['product_id']}</td>";
                                    echo "<td>{$row['product_name']}</td>";
                                    echo "<td>{$row['product_qty']}</td>";
                                    echo "</tr>";
                                }
                                echo "</tbody>";
                                echo "</table>";
                                echo "<div class='d-flex justify-content-center'>";
                                echo "<button type='submit' class='btn btn-primary' name='update_invoice'><i class='bi bi-arrow-up-square'></i> Update</button>";
                                echo "</div>";
                                echo "</form>";
                                ?>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

</main><!-- End #main -->
<?php include 'footer.php'; ?>