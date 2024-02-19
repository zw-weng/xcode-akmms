<?php
include('mysession.php');
if (!session_id()) {
    session_start();
}
// Display result
include 'headeradmin.php';

// Include database connection
include('dbconnect.php');

// CRUD: Retrieve construction data using a JOIN statement with material category
$sql = "SELECT * FROM tb_construction
          INNER JOIN tb_materialcategory ON tb_construction.material_category_id = tb_materialcategory.material_category_id";
$result = mysqli_query($con, $sql);

?>

<main id="main" class="main">

    <div class="pagetitle">
        <h1>JKR Material</h1>
        <div class="d-flex justify-content-between align-items-center">
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="adminmain.php">Home</a></li>
                    <li class="breadcrumb-item"><a href="#">Inventory</a></li>
                    <li class="breadcrumb-item"><a href="jkr.php">JKR List</a></li>
                    <li class="breadcrumb-item active">Recycle Bin</li>
                </ol>
            </nav>
            <div class="btn-group me-2">
                <a href="jkr.php" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Back</a>
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
                            JKR Material Recycle Bin
                        </h5>
                        <!-- Wrap the table with a div and apply the table-responsive class -->
                        <div class="table-responsive">
                            <!-- Table with stripped rows -->
                            <table class="table datatable table-hover">
                                <thead>
                                    <tr>
                                        <th>Material ID</th>
                                        <th>Material Name</th>
                                        <th>Description</th>
                                        <th>Cost (RM)</th>
                                        <th>Unit</th>
                                        <th>Category</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    while ($row = mysqli_fetch_array($result)) {
                                        if ($row['material_status'] == 0) {
                                            echo "<tr>";
                                            echo "<td>" . $row['material_id'] . "</td>";
                                            echo "<td>" . $row['material_name'] . "</td>";
                                            echo "<td>" . $row['material_desc'] . "</td>";
                                            echo "<td>" . $row['material_cost'] . "</td>";
                                            echo "<td>" . $row['material_unit'] . "</td>";
                                            echo "<td>" . $row['material_category_desc'] . "</td>";
                                            echo "<td>";
                                            echo "<div class='btn-group' role='group'>";
                                            echo "<a class='btn btn-success btn-sm' href='jkr-activate.php?id=" . $row['material_id'] . "&action=activate' onclick='return confirm(\"Are you sure you want to restore this material?\")'><i class='bi bi-arrow-counterclockwise'></i> Restore</a>";
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