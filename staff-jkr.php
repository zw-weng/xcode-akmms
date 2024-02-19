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
$sql = "SELECT * FROM tb_construction
          INNER JOIN tb_materialcategory ON tb_construction.material_category_id = tb_materialcategory.material_category_id";
$result = mysqli_query($con, $sql);

// CRUD: Retrieve electric rate data
$sqle = "SELECT * FROM tb_electric";
$resulte = mysqli_query($con, $sqle);

// CRUD: Retrieve civil rate data
$sqlc = "SELECT * FROM tb_civil";
$resultc = mysqli_query($con, $sqlc);

?>

<main id="main" class="main">

  <div class="pagetitle">
    <h1>JKR Material</h1>
    <div class="d-flex justify-content-between align-items-center">
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="staffmain.php">Home</a></li>
          <li class="breadcrumb-item"><a href="#">Inventory</a></li>
          <li class="breadcrumb-item active">JKR List</li>
        </ol>
      </nav>
    </div>
  </div><!-- End Page Title -->

  <section class="section">
    <div class="row">
      <div class="col-lg-12">
        <?= alertMessage(); ?>
        <div class="card">
          <div class="card-body">
            <h5 class="card-title d-flex justify-content-between align-items-center">
              JKR Material List
              <div class="btn-group me-2">
                <a href="staff-jkr-create.php" class="btn btn-primary shadow"><i class="bi bi-plus-circle"></i> Add</a>
                <a href="staff-jkr-bin.php" class="btn btn-secondary shadow"><i class="bi bi-recycle"></i> Bin</a>
              </div>
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
                    if ($row['material_status'] == 1) {
                      echo "<tr>";
                      echo "<td>" . $row['material_id'] . "</td>";
                      echo "<td>" . $row['material_name'] . "</td>";
                      echo "<td>" . $row['material_desc'] . "</td>";
                      echo "<td>" . $row['material_cost'] . "</td>";
                      echo "<td>" . $row['material_unit'] . "</td>";
                      echo "<td>" . $row['material_category_desc'] . "</td>";
                      echo "<td>";
                      echo "<div class='btn-group' role='group'>";
                      echo "<a href='staff-jkr-edit.php?id=" . $row['material_id'] . "' class='btn btn-warning btn-sm'><i class='bi bi-pencil'></i></a>";
                      echo "&nbsp;";
                      echo "<a class='btn btn-danger btn-sm' href='staff-jkr-deactivate.php?id=" . $row['material_id'] . "&action=deactivate' onclick='return confirm(\"Are you sure you want to delete this material?\")'><i class='bi bi-trash'></i></a>";
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

    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title d-flex justify-content-between align-items-center">Electric Rate Charged List
              <div class="btn-group me-2">
                <a href="staff-erate-create.php" class="btn btn-primary shadow"><i class="bi bi-plus-circle"></i> Add</a>
                <a href="staff-erate-bin.php" class="btn btn-secondary shadow"><i class="bi bi-recycle"></i> Bin</a>
              </div>
            </h5>
            <!-- Wrap the table with a div and apply the table-responsive class -->
            <div class="table-responsive">
              <!-- Table with stripped rows -->
              <table class="table datatable table-hover">
                <thead>
                  <tr>
                    <th>State</th>
                    <th>District</th>
                    <th>Group Distance (KM)</th>
                    <th>Rate Charged (%)</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  while ($rowe = mysqli_fetch_array($resulte)) {
                    if ($rowe['e_status'] == 1) {
                      echo "<tr>";
                      echo "<td>" . $rowe['e_state'] . "</td>";
                      echo "<td>" . $rowe['e_district'] . "</td>";
                      echo "<td>" . $rowe['e_group'] . "</td>";
                      echo "<td>" . $rowe['e_rate'] . "</td>";
                      echo "<td>";
                      echo "<div class='btn-group' role='group'>";
                      echo "<a href='staff-erate-edit.php?id=" . $rowe['e_id'] . "' class='btn btn-warning btn-sm'><i class='bi bi-pencil'></i></a>";
                      echo "&nbsp;";
                      echo "<a class='btn btn-danger btn-sm' href='staff-erate-deactivate.php?id=" . $rowe['e_id'] . "&action=deactivate' onclick='return confirm(\"Are you sure you want to delete this data?\")'><i class='bi bi-trash'></i></a>";
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

    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title d-flex justify-content-between align-items-center">Civil Rate Charged List
              <div class="btn-group me-2">
                <a href="staff-crate-create.php" class="btn btn-primary shadow"><i class="bi bi-plus-circle"></i> Add</a>
                <a href="staff-crate-bin.php" class="btn btn-secondary shadow"><i class="bi bi-recycle"></i> Bin</a>
              </div>
            </h5>
            <!-- Wrap the table with a div and apply the table-responsive class -->
            <div class="table-responsive">
              <!-- Table with stripped rows -->
              <table class="table datatable table-hover">
                <thead>
                  <tr>
                    <th>State</th>
                    <th>District</th>
                    <th>Group Distance (KM)</th>
                    <th>Rate Charged (%)</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  while ($rowc = mysqli_fetch_array($resultc)) {
                    if ($rowc['c_status'] == 1) {
                      echo "<tr>";
                      echo "<td>" . $rowc['c_state'] . "</td>";
                      echo "<td>" . $rowc['c_district'] . "</td>";
                      echo "<td>" . $rowc['c_group'] . "</td>";
                      echo "<td>" . $rowc['c_rate'] . "</td>";
                      echo "<td>";
                      echo "<div class='btn-group' role='group'>";
                      echo "<a href='staff-crate-edit.php?id=" . $rowc['c_id'] . "' class='btn btn-warning btn-sm'><i class='bi bi-pencil'></i></a>";
                      echo "&nbsp;";
                      echo "<a class='btn btn-danger btn-sm' href='staff-crate-deactivate.php?id=" . $rowc['c_id'] . "&action=deactivate' onclick='return confirm(\"Are you sure you want to delete this data?\")'><i class='bi bi-trash'></i></a>";
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