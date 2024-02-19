<?php
include('mysession.php');

if (!session_id()) {
    session_start();
}

// Display result
include('headeradmin.php');

// Include database connection
include('dbconnect.php');

// Fetch payment types for dropdown
$sqlPaymentTypes = "SELECT * FROM tb_paymenttype";
$resultPaymentTypes = mysqli_query($con, $sqlPaymentTypes);

// Fetch sales orders for dropdown
$sqlSalesOrders = "SELECT * FROM tb_salesorder";
$resultSalesOrders = mysqli_query($con, $sqlSalesOrders);
?>

<main id="main" class="main">

    <div class="pagetitle">
        <h1>Create Payment</h1>
        <div class="d-flex justify-content-between align-items-center">
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="adminmain.php">Home</a></li>
                    <li class="breadcrumb-item"><a href="#">Payment</a></li>
                    <li class="breadcrumb-item active">Create Payment</li>
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
                        <h5 class="card-title">Create Payment</h5>

                        <?= alertMessage(); ?>

                        <form method="POST" action="payment-createprocess.php" enctype="multipart/form-data">
                            <!-- Add form fields for payment -->
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label for="order_id" class="form-label mt-4">Order ID</label>
                                    <select name="order_id" class="form-control" id="order_id" required>
                                        <?php
                                        while ($rowOrder = mysqli_fetch_array($resultSalesOrders)) {
                                            echo "<option value='" . $rowOrder['order_id'] . "'>" . $rowOrder['order_id'] . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="payment_date" class="form-label mt-4">Payment Date</label>
                                    <input type="date" name="payment_date" class="form-control" id="payment_date" required>
                                </div>
                            </div>

                            <!-- Add more fields as needed -->

                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label for="client_name" class="form-label mt-4">Customer Name</label>
                                    <input type="text" name="client_name" class="form-control" id="client_name" placeholder="Enter customer name" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="payment_amount" class="form-label mt-4">Payment Amount</label>
                                    <input type="number" name="payment_amount" class="form-control" id="payment_amount" placeholder="Enter payment amount with up to 2 decimal places" required step="0.01">
                                </div>
                            </div>

                            <div class="form-group row">
                            <div class="col-md-6">
                                    <label for="payment_type" class="form-label mt-4">Payment Type</label>
                                    <select name="payment_type" class="form-control" id="payment_type" required>
                                        <?php
                                        while ($rowPaymentType = mysqli_fetch_array($resultPaymentTypes)) {
                                            echo "<option value='" . $rowPaymentType['payment_type_id'] . "'>" . $rowPaymentType['payment_type_desc'] . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                 <label for="payment_proof" class="form-label mt-4">Proof of Payment</label>
                                 <input type="file" name="payment_proof" accept=".pdf"/>
                                 <input type="hidden" name="MAX_FILE_SIZE" value="67108864"/> <! - 64 MB's worth in bytes →
                                 </div>
                            </div>

                            <br>
                            <div class="d-flex justify-content-end">
                                <button type="submit" name="save_payment" class="btn btn-outline-primary"><i class="bi bi-arrow-up-square"></i> Save</button>
                                &nbsp;
                                <button type="reset" class="btn btn-outline-danger"><i class="bi bi-x-square"></i> Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <?php mysqli_close($con); ?>
</main><!-- End #main -->

<?php include 'footer.php'; ?>
