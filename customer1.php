<?php
  

  // Include database connection
  include ('dbconnect.php');

  

  // CRUD: Retrieve current user using prepared statement
  $sqlc = "SELECT * FROM tb_customer ";
  $stmt = mysqli_prepare($con, $sqlc);

if ($stmt) {
  
    // Execute the statement
    mysqli_stmt_execute($stmt);

    // Get result set
    $result = mysqli_stmt_get_result($stmt);

    // Display result
    include 'headeradmin.php';

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
          <a href="customeradd1.php" class="btn btn-primary"><i class="bi bi-plus-circle"></i> Add</a>
          <a href="#" class="btn btn-secondary"><i class="bi bi-filetype-pdf"></i> Export</a>
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
              <table class="table datatable">
                <thead>
                  <tr>
                    <th>
                      <b>C</b>ustomer ID
                    </th>
                    <th>Customer Name</th>
                    <th>Phone No.</th>
                    <th>Email</th>
                    <th>Customer Address</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    // Fetch results as an associative array
                      while ($row = mysqli_fetch_assoc($result)) {
                      echo"<tr>";
                      echo"<td>". $row['cust_id'] ."</td>";
  
                      echo"<td>".$row['cust_name']."</td>";
                      
                      echo"<td>".$row['cust_phone']."</td>";
                      echo"<td>".$row['cust_email']."</td>";
                      echo"<td>".$row['cust_address']."</td>";
                      echo"<td>";
                        echo '<div class="dropdown">
                          <button class="btn btn-light" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                              <i class="bi bi-three-dots-vertical"></i>
                          </button>
                          <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                              <li><a class="dropdown-item" href="customeredit.php">Edit</a></li>
                              <li><a class="dropdown-item" href="customerdelete.php" onclick="return confirm(\'Are you sure you want to delete this data?\')">Delete</a></li>
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
