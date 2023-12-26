<?php include 'headeradmin.php'; ?>
<?php include 'dbconnect.php'; ?>

<main id="main" class="main">

    <div class="pagetitle">
        <h1>Invoicing</h1>
        <div class="d-flex justify-content-between align-items-center">
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="adminmain.php">Home</a></li>
                    <li class="breadcrumb-item active">Invoicing</li>
                </ol>
            </nav>

            <div class="btn-group me-2">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdropAdd"><i class="bi bi-plus-circle"></i><a href="invoicegenerate.php"> Add</a></button>
            </div>
        </div>
    </div><!-- End Page Title -->

    <!-- Add Modal -->
    <!-- Your existing modal code here -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">User List</h5>

                        <div class="table-responsive"> <!-- Add this container for responsiveness -->
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Order ID</th>
                                        <th>Staff Incharge</th>
                                        <th>Remark</th>
                                        <th>Payment Status ID</th>
                                        <th>Payment Type ID</th>
                                        <th>Payment ID</th>
                                        <th>Order Status ID</th>
                                        <th>Quotation ID</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $query = "SELECT * FROM tb_salesorder";
                                    $result = mysqli_query($con, $query); // Use $con instead of $connection

                                    while ($row = mysqli_fetch_assoc($result)) {
                                        echo "<tr>";
                                        echo "<td>{$row['order_id']}</td>";
                                        echo "<td>{$row['staff_incharge']}</td>";
                                        echo "<td>{$row['remark']}</td>";
                                        echo "<td>{$row['payment_status_id']}</td>";
                                        echo "<td>{$row['payment_type_id']}</td>";
                                        echo "<td>{$row['payment_id']}</td>";
                                        echo "<td>{$row['order_status_id']}</td>";
                                        echo "<td>{$row['quotation_id']}</td>";
                                        echo "</tr>";
                                    }
                                    mysqli_close($con); // Use $con instead of $connection
                                    ?>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </section>

</main><!-- End #main -->

<?php include 'footer.php'; ?>
