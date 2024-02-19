<?php
include('mysession.php');
if (!session_id()) {
  session_start();
}
// Display result
include 'headeradmin.php';

// Include database connection
include('dbconnect.php');

// Get id for current user
$suid = intval($_SESSION['suid']);  // Convert to integer

// CRUD: Retrieve current user using prepared statement
$sqlc = "SELECT * FROM tb_user INNER JOIN tb_usertype ON tb_user.type_id = tb_usertype.type_id WHERE tb_user.user_id = ?";
$stmt = mysqli_prepare($con, $sqlc);

if ($stmt) {
  mysqli_stmt_bind_param($stmt, "i", $suid);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);

  if (!$result) {
    die("Query failed: " . mysqli_error($con));
  }

  // Fetch user types
  $sqlUserTypes = "SELECT * FROM tb_usertype";
  $resultUserTypes = mysqli_query($con, $sqlUserTypes);

  if (!$resultUserTypes) {
    die("Query failed: " . mysqli_error($con));
  }

} else {
  die("Prepare statement failed: " . mysqli_error($con));
}
?>

<main id="main" class="main">

  <div class="pagetitle">
    <h1>User Management</h1>
    <div class="d-flex justify-content-between align-items-center">
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="adminmain.php">Home</a></li>
          <li class="breadcrumb-item active">User Management</li>
        </ol>
      </nav>

      <div class="btn-group me-2">
        <a href="user-create.php" class="btn btn-primary shadow"><i class="bi bi-plus-circle"></i> Add</a>
        <a href="user-export-excel.php" class="btn btn-success shadow"><i class="bi bi-file-excel"></i> Export</a>
      </div>
    </div>
  </div><!-- End Page Title -->

  <section class="section">
    <div class="row">
      <div class="col-lg-12">

        <?= alertMessage(); ?>

        <div class="card">
          <div class="card-body">
            <h5 class="card-title">User List</h5>
            <!-- Wrap the table with a div and apply the table-responsive class -->
            <div class="table-responsive">
              <!-- Table with stripped rows -->
              <table class="table datatable table-hover">
                <thead>
                  <tr>
                    <th>
                      <b>U</b>ser ID
                    </th>
                    <th>IC</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Phone No.</th>
                    <th>Email</th>
                    <th>User Type</th>
                    <th>Account Status</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  while ($row = mysqli_fetch_array($result)) {
                    echo "<tr>";
                    echo "<td>" . $row['user_id'] . "</td>";
                    echo "<td>" . $row['user_ic'] . "</td>";
                    echo "<td>" . $row['u_fName'] . "</td>";
                    echo "<td>" . $row['u_lName'] . "</td>";
                    echo "<td>" . $row['user_phone'] . "</td>";
                    echo "<td>" . $row['user_email'] . "</td>";
                    echo "<td>" . $row['type_desc'] . "</td>";
                    echo "<td>";
                    if ($row['acc_status'] == 1) {
                      echo "<span class='badge bg-success'>Active</span>";
                    } else {
                      echo "<span class='badge bg-danger'>Disabled</span>";
                    }
                    echo "</td>";
                    echo "<td>";
                    echo "<div class='btn-group' role='group'>";
                    echo "<a href='user-edit.php?id=" . $row['user_id'] . "' class='btn btn-warning btn-sm' title='Edit'><i class='bi bi-pencil'></i></a>";
                    echo "&nbsp;";
                    echo "<div class='btn-group' role='group'>";
                    echo "<button type='button' class='btn btn-secondary btn-sm dropdown-toggle' data-bs-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>";
                    echo "Status";
                    echo "</button>";
                    echo "<div class='dropdown-menu'>";
                    echo "<a class='dropdown-item text-success' href='user-activate.php?id=" . $row['user_id'] . "&action=activate' onclick='return confirm(\"Are you sure you want to activate this account?\")'><i class='bi bi-check-circle'></i> Activate</a>";
                    echo "<a class='dropdown-item text-danger' href='user-deactivate.php?id=" . $row['user_id'] . "&action=deactivate' onclick='return confirm(\"Are you sure you want to deactivate this account?\")'><i class='bi bi-x-circle'></i> Deactivate</a>";
                    echo "</div>";
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

  <?php mysqli_close($con); ?>
</main><!-- End #main -->

<?php include 'footer.php'; ?>