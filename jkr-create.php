<?php
include('mysession.php');

if (!session_id()) {
    session_start();
}
// Display result
include('headeradmin.php');

// Include database connection
include('dbconnect.php');

// CRUD: Retrieve material categories for dropdown
$sqlCategories = "SELECT * FROM tb_materialcategory";
$resultCategories = mysqli_query($con, $sqlCategories);

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
                    <li class="breadcrumb-item active">Add Material</li>
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
                        <h5 class="card-title">Add Material</h5>

                        <form method="POST" action="jkr-createprocess.php">
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label for="material_name" class="form-label mt-4">Material Name</label>
                                    <input type="text" name="material_name" class="form-control" id="material_name" placeholder="Enter material name" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="material_desc" class="form-label mt-4">Material Description</label>
                                    <input type="text" name="material_desc" class="form-control" id="material_desc" placeholder="Enter material description" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label for="material_cost" class="form-label mt-4">Material Cost (RM)</label>
                                    <input type="number" name="material_cost" class="form-control" id="material_cost" placeholder="Enter material cost with up to 2 decimal values" required step="0.01">
                                    <small class="text-muted">Eg. RM185.40</small>
                                </div>
                                <div class="col-md-6">
                                    <label for="material_unit" class="form-label mt-4">Material Unit</label>
                                    <input type="text" name="material_unit" class="form-control" id="material_unit" placeholder="Enter material unit" required>
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
                                            echo "<option value='" . $rowCategory['material_category_id'] . "'>" . $rowCategory['material_category_desc'] . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

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