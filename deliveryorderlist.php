<?php
include 'headeradmin.php';
include 'dbconnect.php';

// Assuming you have a modal for adding new records, you can include the modal code here

?>

<main id="main" class="main">

    <div class="pagetitle">
        <h1>Invoicing</h1>
        <div class="d-flex justify-content-between align-items-center">
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="adminmain.php">Home</a></li>
                    <li class="breadcrumb-item active">Delivery Order</li>
                </ol>
            </nav>

            <div class="btn-group me-2">
                <!-- Link to the page where you generate invoices -->
                <a href="invoicegenerate.php" class="btn btn-primary"><i class="bi bi-plus-circle"></i> Add</a>
            </div>
        </div>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Delivery Order List</h5>

                        <div class="table-responsive">
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
                                    $result = mysqli_query($con, $query);

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