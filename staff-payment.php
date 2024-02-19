<?php
include('mysession.php');
if (!session_id()) {
    session_start();
}
// Display result
include 'headerstaff.php';

// Include database connection
include('dbconnect.php');

// Get id for the current user
$suid = intval($_SESSION['suid']);  // Convert to integer

// CRUD: Retrieve current user using a prepared statement
$sqlc = "SELECT * FROM tb_payment INNER JOIN tb_paymenttype ON tb_payment.payment_type_id = tb_paymenttype.payment_type_id";
$stmt = mysqli_prepare($con, $sqlc);

// Check for SQL preparation error
if (!$stmt) {
    die('Error in preparing statement: ' . mysqli_error($con));
}

// Execute the statement
if (!mysqli_stmt_execute($stmt)) {
    die('Error in executing statement: ' . mysqli_error($con));
}

// Get the result
$result = mysqli_stmt_get_result($stmt);
?>

<main id="main" class="main">

    <div class="pagetitle">
        <h1>Payment</h1>
        <div class="d-flex justify-content-between align-items-center">
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="staffmain.php">Home</a></li>
                    <li class="breadcrumb-item active">Payment</li>
                </ol>
            </nav>

            <div class="btn-group me-2">
                <a href="staff-payment-create.php" class="btn btn-primary shadow"><i class="bi bi-plus-circle"></i> Add</a>
                <a href="payment-export-excel.php" class="btn btn-success shadow"><i class="bi bi-file-excel"></i> Export</a>
        <a href="staff-payment-bin.php" class="btn btn-secondary shadow">
          <i class="bi bi-recycle"></i> Bin
        </a>
            </div>
        </div>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <?= alertMessage(); ?>

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Payment List</h5>
                        <!-- Wrap the table with a div and apply the table-responsive class -->
                        <div class="table-responsive">
                            <!-- Table with stripped rows -->
                            <table class="table datatable table-hover">
                                <thead>
                                    <tr>
                                        <th>
                                            <b>P</b>ayment ID
                                        </th>
                                        <th>Order ID</th>
                                        <th>Payment Date</th>
                                        <th>Customer Name</th>
                                        <th>Payment Amount</th>
                                        <th>Payment Type</th>
                                        <th>Proof of Payment</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    while ($row = mysqli_fetch_array($result)) {
                                        if ($row['payment_status'] == 1) {
                                            echo "<tr>";
                                            echo "<td>" . $row['payment_id'] . "</td>";
                                            echo "<td>" . $row['order_id'] . "</td>";
                                            echo "<td>" . date('Y-m-d', strtotime($row['payment_date'])) . "</td>";
                                            echo "<td>" . $row['client_name'] . "</td>";
                                            echo "<td>" . $row['payment_amount'] . "</td>";
                                            echo "<td>" . $row['payment_type_desc'] . "</td>";
                                            echo "<td>" . $row['payment_proof'] . "</td>";
                                            echo "<td>";
                                            echo "<div class='btn-group' role='group'>";
                                            echo "<a href='download.php?payment_id=" . $row['payment_id'] . "' class='btn btn-primary btn-sm'><i class='bi bi-download'></i></a>";
                                            echo "&nbsp;";
                                            echo "<a href='staff-payment-edit.php?id=" . $row['payment_id'] . "' class='btn btn-warning btn-sm'><i class='bi bi-pencil'></i></a>";
                                            echo "&nbsp;";
                                            echo "<a class='btn btn-danger btn-sm' href='staff-payment-deactivate.php?id=" . $row['payment_id'] . "&action=deactivate' onclick='return confirm(\"Are you sure you want to delete this payment?\")'><i class='bi bi-trash'></i></a>";
                                            echo "</div>";
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
