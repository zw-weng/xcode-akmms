<?php
  include('mysession.php');
  if(!session_id())
  {
    session_start();
  }

  // Include database connection
  include ('dbconnect.php');

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

    // Display result
    include 'headeradmin.php';
  } else {
    die("Prepare statement failed: " . mysqli_error($con));
  }
?>

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Quotation (Construction)</h1>
      <div class="d-flex justify-content-between align-items-center">
      <nav>
          <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="adminmain.php">Home</a></li>
              <li class="breadcrumb-item active">Quotation</li>
              <li class="breadcrumb-item active">Construction</li>
          </ol>
      </nav>

      <div class="btn-group me-2">
          <a href="quotation-advertising-create.php" class="btn btn-primary"><i class="bi bi-plus-circle"></i> Add</a>
          <a href="#" class="btn btn-secondary"><i class="bi bi-filetype-pdf"></i> Export</a>
      </div>
      </div>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">User List</h5>

              <?= alertMessage(); ?>

              <!-- Wrap the table with a div and apply the table-responsive class -->
          <div class="table-responsive">
              <!-- Table with stripped rows -->
              <table class="table datatable">
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
                    <th> </th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    while($row = mysqli_fetch_array($result))
                    {
                      echo"<tr>";
                      echo"<td>".$row['user_id']."</td>";
                      echo"<td>".$row['user_ic']."</td>";
                      echo"<td>".$row['u_fName']."</td>";
                      echo"<td>".$row['u_lName']."</td>";
                      echo"<td>".$row['user_phone']."</td>";
                      echo"<td>".$row['user_email']."</td>";
                      echo"<td>".$row['type_desc']."</td>";
                      echo"<td>";
                        echo '<div class="dropdown">
                          <button class="btn btn-light" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                              <i class="bi bi-three-dots-vertical"></i>
                          </button>
                          <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                              <li><a class="dropdown-item" href="user-edit.php?id='.$row['user_id'].'">Edit</a></li>
                              <li><a class="dropdown-item" href="user-delete.php?id='.$row['user_id'].'" onclick="return confirm(\'Are you sure you want to delete this data?\')">Delete</a></li>
                          </ul>
                        </div>';
                      echo"</td>";
                      echo"</tr>";
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
