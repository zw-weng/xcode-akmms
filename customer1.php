<?php
include('mysession.php');
if (!session_id()) {
  session_start();
}
// Include database connection
include 'headeradmin.php';
include('dbconnect.php');

// Get user id from url
if (isset($_GET['id'])) {
  $fcustid = $_GET['id'];
}

// CRUD: Retrieve current user using prepared statement
$sqlc = "SELECT * FROM tb_customer ";
$stmt = mysqli_prepare($con, $sqlc);

if ($stmt) {

  // Execute the statement
  mysqli_stmt_execute($stmt);

  // Get result set
  $result = mysqli_stmt_get_result($stmt);

  // Display result
?>

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Customer Management</h1>
      <div class="d-flex justify-content-between align-items-center">
        <nav>
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="adminmain.php">Home</a></li>
            <li class="breadcrumb-item active">Customer Management</li>
          </ol>
        </nav>

        <div class="btn-group me-2">
          <a href="customeradd1.php" class="btn btn-primary shadow"><i class="bi bi-plus-circle"></i> Add</a>
          <a href="customer-export-excel.php" class="btn btn-success shadow"><i class="bi bi-file-excel"></i> Export</a>
        </div>
      </div>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Customer List</h5>

              <?= alertMessage(); ?>

              <!-- Wrap the table with a div and apply the table-responsive class -->
              <div class="table-responsive">
                <!-- Table with stripped rows -->
                <table class="table datatable table-hover">
                  <thead>
                    <tr>
                      <th>
                        <b>C</b>ustomer ID
                      </th>
                      <th>Customer Name</th>
                      <th>Phone No.</th>
                      <th>Email</th>
                      <th>Street</th>
                      <th>Postcode</th>
                      <th>City</th>
                      <th>State</th>
                      <th>Country</th>
                      <th>Status</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    // Fetch results as an associative array
                    while ($row = mysqli_fetch_assoc($result)) {
                      echo "<tr>";
                      echo "<td>" . $row['cust_id'] . "</td>";
                      echo "<td>" . $row['cust_name'] . "</td>";
                      echo "<td>" . $row['cust_phone'] . "</td>";
                      echo "<td>" . $row['cust_email'] . "</td>";
                      echo "<td>" . $row['cust_street'] . "</td>";
                      echo "<td>" . $row['cust_postcode'] . "</td>";
                      echo "<td>" . $row['cust_city'] . "</td>";
                      echo "<td>" . $row['cust_state'] . "</td>";
                      echo "<td>" . $row['cust_country'] . "</td>";
                      echo "<td>";
                      if ($row['cust_status'] == 1) {
                        echo "<span class='badge bg-success'>Active</span>";
                      } else {
                        echo "<span class='badge bg-danger'>Disabled</span>";
                      }
                      echo "</td>";
                      echo "<td>";
                      echo "<div class='btn-group' role='group'>";
                      echo "<a href='customeredit1.php?id=" . $row['cust_id'] . "' class='btn btn-warning btn-sm' title='Edit'><i class='bi bi-pencil'></i></a>";
                      echo "&nbsp;";
                      echo "<button type='button' class='btn btn-secondary btn-sm dropdown-toggle' data-bs-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>";
                      echo "Status";
                      echo "</button>";
                      echo "<div class='dropdown-menu'>";
                      echo "<a class='dropdown-item text-success' href='customeractivate.php?id=" . $row['cust_id'] . "&action=activate' onclick='return confirm(\"Are you sure you want to activate this customer?\")'><i class='bi bi-check-circle'></i> Activate</a>";
                      echo "<a class='dropdown-item text-danger' href='customerdeactivate.php?id=" . $row['cust_id'] . "&action=deactivate' onclick='return confirm(\"Are you sure you want to deactivate this customer?\")'><i class='bi bi-x-circle'></i> Deactivate</a>";
                      echo "</div>";
                      echo "</div>";
                      echo "</td>";
                      echo "</tr>";
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

  <?php
  // Close prepared statement
  mysqli_stmt_close($stmt);
} else {
  // Handle the case where the statement preparation failed
  // You might want to log the error or display an appropriate message
  echo "Error preparing statement.";
}

// Close database connection
mysqli_close($con);
  ?>
  </main><!-- End #main -->

  <?php include 'footer.php'; ?>