<?php
include('mysession.php');
if (!session_id()) {
    session_start();
}
// Display result
include 'headeradmin.php';

// Include database connection
include('dbconnect.php');

// CRUD: Retrieve electric rate data
$sqle = "SELECT * FROM tb_electric";
$resulte = mysqli_query($con, $sqle);

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
                    <li class="breadcrumb-item"><a href="#">Electric</a></li>
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
            <h5 class="card-title d-flex justify-content-between align-items-center">Electric Rate Charged Recycle Bin
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
                    if ($rowe['e_status'] == 0) {
                      echo "<tr>";
                      echo "<td>" . $rowe['e_state'] . "</td>";
                      echo "<td>" . $rowe['e_district'] . "</td>";
                      echo "<td>" . $rowe['e_group'] . "</td>";
                      echo "<td>" . $rowe['e_rate'] . "</td>";
                      echo "<td>";
                      echo "<div class='btn-group' role='group'>";
                      echo "<a class='btn btn-success btn-sm' href='erate-activate.php?id=" . $rowe['e_id'] . "&action=activate' onclick='return confirm(\"Are you sure you want to restore this data?\")'><i class='bi bi-arrow-counterclockwise'></i> Restore</a>";
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