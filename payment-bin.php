<?php
include('mysession.php');
if (!session_id()) {
    session_start();
}
// Display result
include 'headeradmin.php';

// Include database connection
include('dbconnect.php');

// CRUD: Retrieve payment data using a JOIN statement
$sql = "SELECT * FROM tb_payment
          INNER JOIN tb_paymenttype ON tb_payment.payment_type_id = tb_paymenttype.payment_type_id";
$result = mysqli_query($con, $sql);

?>

<main id="main" class="main">

    <div class="pagetitle">
        <h1>Payment Management</h1>
        <div class="d-flex justify-content-between align-items-center">
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="adminmain.php">Home</a></li>
                    <li class="breadcrumb-item"><a href="payment.php">Payment</a></li>
                    <li class="breadcrumb-item active">Recycle Bin</li>
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
                <?= alertMessage(); ?>
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title d-flex justify-content-between align-items-center">
                            Payment Recycle Bin
                        </h5>
                        <!-- Wrap the table with a div and apply the table-responsive class -->
                        <div class="table-responsive mt-4">
                            <!-- Table with stripped rows -->
                            <table class="table table-hover datatable">
                                <thead>
                                    <tr>
                                        <th>Payment ID</th>
                                        <th>Order ID</th>
                                        <th>Payment Date</th>
                                        <th>Customer Name</th>
                                        <th>Payment Type</th>
                                        <th>Proof of Payment</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    while ($row = mysqli_fetch_array($result)) {
                                        if ($row['payment_status'] == 0) {
                                            echo "<tr>";
                                            echo "<td>" . $row['payment_id'] . "</td>";
                                            echo "<td>" . $row['order_id'] . "</td>";
                                            echo "<td>" . $row['payment_date'] . "</td>";
                                            echo "<td>" . $row['client_name'] . "</td>";
                                            echo "<td>" . $row['payment_type_desc'] . "</td>";
                                            echo "<td>" . $row['payment_proof'] . "</td>";
                                            echo "<td>";
                                            echo "<div class='btn-group' role='group'>";
                                            echo "<a class='btn btn-success btn-sm' href='payment-activate.php?id=" . $row['payment_id'] . "&action=activate' onclick='return confirm(\"Are you sure you want to restore this item?\")'><i class='bi bi-arrow-counterclockwise'></i> Restore</a>";
                                            echo "</td>";
                                            echo "</tr>";
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                            <!-- End Table with stripped rows -->

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php mysqli_close($con); ?>
</main><!-- End #main -->

<?php include 'footer.php'; ?>
