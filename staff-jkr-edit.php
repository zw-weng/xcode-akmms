<?php
include('mysession.php');

if (!session_id()) {
    session_start();
}
// Include header
include 'headerstaff.php';

// Include database connection
include('dbconnect.php');

// CRUD: Retrieve material categories for dropdown
$sqlCategories = "SELECT * FROM tb_materialcategory";
$resultCategories = mysqli_query($con, $sqlCategories);

// Fetch material id from URL
if (isset($_GET['id'])) {
    $materialId = $_GET['id'];

    // Validate and sanitize the material ID to prevent SQL injection
    $materialId = mysqli_real_escape_string($con, $materialId);
    $materialId = htmlspecialchars($materialId); // Additional input sanitization

    // Retrieve current material data using prepared statement
    $sql = "SELECT * FROM tb_construction WHERE material_id = ?";
    $stmt = mysqli_prepare($con, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "s", $materialId);
        mysqli_stmt_execute($stmt);

        // Get result
        $result = mysqli_stmt_get_result($stmt);

        if (!$result) {
            die("Query failed: " . mysqli_error($con));
        }

        $row = mysqli_fetch_array($result);

        // Close statement
        mysqli_stmt_close($stmt);
    } else {
        // Handle prepare statement error
        die("Prepare statement failed: " . mysqli_error($con));
    }
} else {
    // Redirect if material ID is not provided
    header('Location: staff-jkr.php');
    exit();
}
?>

<main id="main" class="main">

    <div class="pagetitle">
        <h1>Edit Material</h1>
        <div class="d-flex justify-content-between align-items-center">
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="staffmain.php">Home</a></li>
                    <li class="breadcrumb-item"><a href="#">Inventory</a></li>
                    <li class="breadcrumb-item"><a href="staff-jkr.php">JKR List</a></li>
                    <li class="breadcrumb-item active">Edit Material</li>
                </ol>
            </nav>

            <div class="btn-group me-2">
                <a href="staff-jkr.php" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Back</a>
            </div>
        </div>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
            <?= alertMessage(); ?>
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Edit Material</h5>

                        <form method="POST" action="staff-jkr-editprocess.php?id=<?= $row['material_id'] ?>" enctype="multipart/form-data">
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label for="material_name" class="form-label mt-4">Material Name</label>
                                    <input type="text" name="material_name" class="form-control" id="material_name" value="<?= $row['material_name'] ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="material_desc" class="form-label mt-4">Material Description</label>
                                    <input type="text" name="material_desc" class="form-control" id="material_desc" value="<?= $row['material_desc'] ?>" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label for="material_cost" class="form-label mt-4">Material Cost (RM)</label>
                                    <input type="number" name="material_cost" class="form-control" id="material_cost" value="<?= $row['material_cost'] ?>" required step="0.01">
                                    <small class="text-muted">Eg. RM 143.20</small>
                                </div>
                                <div class="col-md-6">
                                    <label for="material_unit" class="form-label mt-4">Material Unit</label>
                                    <input type="text" name="material_unit" class="form-control" id="material_unit" value="<?= $row['material_unit'] ?>" required>
                                    <small class="text-muted">Eg. Meter</small>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label for="ftype" class="form-label mt-4">Category</label>
                                    <select name="ftype" class="form-control" id="ftype" required>
                                    <option value="" selected disabled>Select Category</option>
                                        <?php
                                        while ($rowCategory = mysqli_fetch_array($resultCategories)) {
                                            $selected = ($rowCategory['material_category_id'] == $row['material_category_id']) ? 'selected' : '';
                                            echo "<option value='" . $rowCategory['material_category_id'] . "' $selected>" . $rowCategory['material_category_desc'] . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <!-- Add more fields as needed -->

                            <br><br>
                            <div class="d-flex justify-content-end">
                            <button type="submit" name="save_jkr" class="btn btn-outline-primary"><i class="bi bi-arrow-up-square"></i> Save</button>
                                &nbsp;
                                <button type="reset" class="btn btn-outline-danger" data-bs-dismiss="modal"><i class="bi bi-x-square"></i> Cancel</button>
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