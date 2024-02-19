<?php
include('mysession.php');

if (!session_id()) {
    session_start();
}

// Include header
include 'headeradmin.php';

// Include database connection
include('dbconnect.php');


// Include function.php (if not included previously)
if (!function_exists('validate')) {
    include('function.php');
}

// Get payment ID from URL
if (isset($_GET['id'])) {
    $payment_id = validate($_GET['id']);

    // Fetch payment data from the database based on payment ID
    $sql = "SELECT * FROM tb_payment WHERE payment_id = ?";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "i", $payment_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    // Check if the payment record exists
    if ($row = mysqli_fetch_assoc($result)) {
        // Payment record found, you can use $row['column_name'] to access values

        // Fetch payment types for dropdown
        $sqlPaymentTypes = "SELECT * FROM tb_paymenttype";
        $resultPaymentTypes = mysqli_query($con, $sqlPaymentTypes);

        if (!$resultPaymentTypes) {
            die("Query failed: " . mysqli_error($con));
        }

        // Display result
?>

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Edit Payment</h1>
        <div class="d-flex justify-content-between align-items-center">
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="adminmain.php">Home</a></li>
                    <li class="breadcrumb-item"><a href="#">Payment</a></li>
                    <li class="breadcrumb-item"><a href="payment.php">Payment</a></li>
                    <li class="breadcrumb-item active">Edit Payment</li>
                </ol>
            </nav>
            <div class="btn-group me-2">
                <a href="payment.php" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Back</a>
            </div>
        </div>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Edit Payment</h5>

                        <?= alertMessage(); ?>

                        <form method="POST" action="payment-editprocess.php?id=<?= $row['payment_id'] ?>"enctype="multipart/form-data">
                            <!-- Payment Information -->
                            <div class="form-group row">
                            <div class="col-md-6">
                                <label for="order_id" class="form-label mt-4">Order ID</label>
                                <input type="text" name="order_id" class="form-control" value="<?= $row['order_id'] ?>" id="order_id" readonly>
                            </div>
                            <div class="col-md-6">
                                <label for="payment_date" class="form-label mt-4">Payment Date</label>
                                <input type="date" name="payment_date" class="form-control" value="<?= date('Y-m-d', strtotime($row['payment_date'])) ?>" id="payment_date" required>
                            </div>
                        </div>


                            <!-- Customer Information -->
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label for="client_name" class="form-label mt-4">Customer Name</label>
                                    <input type="text" name="client_name" class="form-control" value="<?= $row['client_name'] ?>" id="client_name" required>
                                </div>
                            </div>

                            <!-- Payment Details -->
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label for="payment_amount" class="form-label mt-4">Payment Amount</label>
                                    <input type="number" name="payment_amount" class="form-control" value="<?= $row['payment_amount'] ?>" id="payment_amount" placeholder="Enter payment amount with up to 2 decimal places" required step="0.01">
                                </div>
                                <div class="col-md-6">
                                    <label for="payment_type" class="form-label mt-4">Payment Type</label>
                                    <select name="payment_type" class="form-control" id="payment_type" required>
                                        <?php
                                        while ($rowPaymentType = mysqli_fetch_array($resultPaymentTypes)) {
                                            $selected = ($rowPaymentType['payment_type_id'] == $row['payment_type_id']) ? 'selected' : '';
                                            echo "<option value='" . $rowPaymentType['payment_type_id'] . "' $selected>" . $rowPaymentType['payment_type_desc'] . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <!-- Proof of Payment -->
<!-- Proof of Payment -->
<div class="form-group row">
    <div class="col-md-6">
        <label for="payment_proof" class="form-label mt-4">Proof of Payment</label>
        <input type="hidden" name="MAX_FILE_SIZE" value="67108864"/> <!-- 64 MB's worth in bytes -->
        <input type="file" name="payment_proof" accept=".pdf"/>
        
        <?php if (!empty($row['payment_proof'])) : ?>
            <?php 
            // Assuming 'uploads' is the directory where your payment_proof files are stored
            $file_path = 'uploads/' . $row['payment_proof']; 
            ?>
        <?php endif; ?>
    </div>
</div>



<!-- Hidden input for payment_id -->
    <input type="hidden" name="payment_id" value="<?= $row['payment_id'] ?>">

                            <!-- Form Actions -->
                            <div class="d-flex justify-content-end">
                                <button type="submit" name="update_payment" class="btn btn-outline-primary"><i class="bi bi-arrow-up-square"></i> Update</button>
                                &nbsp;
                                <button type="reset" class="btn btn-outline-danger"><i class="bi bi-x-square"></i> Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main><!-- End #main -->

<?php
        include 'footer.php';
    } else {
        // Payment record not found
        echo "Payment record not found.";
    }

    // Close the statement
    mysqli_stmt_close($stmt);
} else {
    // No payment ID provided
    echo "No payment ID provided.";
}

// Close the database connection
mysqli_close($con);
?>
