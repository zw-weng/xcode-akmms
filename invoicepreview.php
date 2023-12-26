<?php
include 'headeradmin.php'; // Include your header file
include 'dbconnect.php'; // Include your database connection file

// Assuming you have received the values via POST or GET
// Replace these with the actual input methods you are using
$order_id = $_POST['order_id'];
$quotation_id = $_POST['quotation_id'];

// Fetch details from the database based on the provided IDs
$query = "SELECT * FROM tb_salesorder so JOIN tb_quotation q ON so.quotation_id = q.quotation_id WHERE so.order_id = $order_id";
$result = mysqli_query($con, $query);
$row = mysqli_fetch_assoc($result);

// Close the database connection
mysqli_close($con);
?>

<main id="main" class="main">
    <!-- Your HTML template for the invoice preview -->
    <div class="invoice-preview">
        <div style="text-align: center;">
            <h1>Invoice</h1>
            <p>Date: <?php echo date('Y-m-d'); ?></p>
        </div>

        <hr>

        <div style="margin-bottom: 20px;">
            <h3>Order Details</h3>
            <p><strong>Order ID:</strong> <?php echo $row['order_id']; ?></p>
            <p><strong>Quotation ID:</strong> <?php echo $row['quotation_id']; ?></p>
            <!-- Add more order details as needed -->
        </div>

        <hr>

        <div>
            <h3>Customer Information</h3>
            <p><strong>Customer Name:</strong> <?php echo $row['client_name']; ?></p>
            <p><strong>Address:</strong> <?php echo $row['client_street'] . ', ' . $row['client_city'] . ', ' . $row['client_state'] . ', ' . $row['client_country']; ?></p>
            <!-- Add more customer details as needed -->
        </div>

        <hr>

        <div>
            <h3>Product Information</h3>
            <p><strong>Product Description:</strong> <?php echo $row['product_desc']; ?></p>
            <p><strong>Quantity:</strong> <?php echo $row['quantity']; ?></p>
            <p><strong>Total:</strong> <?php echo $row['total']; ?></p>
            <!-- Add more product details as needed -->
        </div>

        <!-- Add styling and additional HTML for a well-designed preview -->

        <!-- Add a back button or link to return to the previous page -->
        <a href="previous_page.php">Back</a>
    </div>
</main>

<?php include 'footer.php'; // Include your footer file ?>
