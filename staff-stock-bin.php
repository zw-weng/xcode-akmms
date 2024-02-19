<?php
include('mysession.php');
if (!session_id()) {
    session_start();
}
// Display result
include 'headerstaff.php';

// Include database connection
include('dbconnect.php');

// CRUD: Retrieve construction data using a JOIN statement with material category
$sql = "SELECT * FROM tb_advertising
          INNER JOIN tb_itemcategory ON tb_advertising.item_category_id = tb_itemcategory.item_category_id";
$result = mysqli_query($con, $sql);

?>

<main id="main" class="main">

    <div class="pagetitle">
        <h1>Stock Management</h1>
        <div class="d-flex justify-content-between align-items-center">
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="staffmain.php">Home</a></li>
                    <li class="breadcrumb-item"><a href="#">Inventory</a></li>
                    <li class="breadcrumb-item"><a href="staff-stock.php">Stock</a></li>
                    <li class="breadcrumb-item active">Recycle Bin</li>
                </ol>
            </nav>
            <div class="btn-group me-2">
                <a href="staff-stock.php" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Back</a>
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
                            Stock Recycle Bin
                        </h5>
                        <!-- Wrap the table with a div and apply the table-responsive class -->
                        <div class="table-responsive mt-4">
                            <!-- Table with stripped rows -->
                            <table class="table table-hover datatable">
                                <thead>
                                    <tr>
                                        <th>Item ID</th>
                                        <th>Item Name</th>
                                        <th>Description</th>
                                        <th>Cost</th>
                                        <th>Price</th>
                                        <th>Quantity</th>
                                        <th>Category</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    while ($row = mysqli_fetch_array($result)) {
                                        if ($row['item_status'] == 0) {
                                            echo "<tr>";
                                            echo "<td>" . $row['item_id'] . "</td>";
                                            echo "<td>" . $row['item_name'] . "</td>";
                                            echo "<td>" . $row['item_desc'] . "</td>";
                                            echo "<td>" . $row['item_cost'] . "</td>";
                                            echo "<td>" . $row['item_price'] . "</td>";
                                            echo "<td>" . $row['item_qty'] . "</td>";
                                            echo "<td>" . $row['item_category_desc'] . "</td>";
                                            echo "<td>";
                                            echo "<div class='btn-group' role='group'>";
                                            echo "<a class='btn btn-success btn-sm' href='staff-stock-activate.php?id=" . $row['item_id'] . "&action=activate' onclick='return confirm(\"Are you sure you want to restore this item?\")'><i class='bi bi-arrow-counterclockwise'></i> Restore</a>";
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