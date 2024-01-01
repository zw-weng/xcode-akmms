<?php


// Include database connection
include('dbconnect.php');



// CRUD: Retrieve current user using prepared statement
$sqlc = "SELECT * FROM tb_customer ";
$stmt = mysqli_prepare($con, $sqlc);

if ($stmt) {
    
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (!$result) {
        die("Query failed: " . mysqli_error($con));
    }

    // Fetch user types
    
    // Display result
    include ('headeradmin.php');
    // Close the prepared statement
    mysqli_stmt_close($stmt);
} else {
    die("Prepare statement failed: " . mysqli_error($con));
}
?>

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Customer Management</h1>
      <div class="d-flex justify-content-between align-items-center">
      <nav>
          <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="adminmain.php">Home</a></li>
              <li class="breadcrumb-item"><a href="customer1.php">Customer Management</a></li>
              <li class="breadcrumb-item active">Add Customer</li>
          </ol>
      </nav>

      <div class="btn-group me-2">
          <a href="customer1.php" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Back</a>
      </div>
      </div>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Add Customer</h5>

              <?= alertMessage(); ?>

              <form method="POST" action="customeraddprocess1.php">
                  <div class="form-group row">
                      <div class="col-md-6">
                          <label for="fid" class="form-label mt-4">Customer ID</label>
                          <input type="text" name="fcustid" class="form-control" id="fid" placeholder="" required>
                      </div>
                      <div class="col-md-6">
                          <label for="fic" class="form-label mt-4">Customer Name</label>
                          <input type="text" name="fname" class="form-control" id="fic" placeholder="" required>
                      </div>
                  </div>

                  <div class="form-group row">
                      <div class="col-md-6">
                          <label for="ffname" class="form-label mt-4">Customer Phone</label>
                          <input type="text" name="fphone" class="form-control" id="ffname" placeholder="" required>
                      </div>
                      <div class="col-md-6">
                          <label for="exampleInputEmail1" class="form-label mt-4">Customer Email</label>
                          <input type="email" name="femail" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="" required>
                      </div>
                  </div>

                  

                  <div class="form-group row">
                     <div class="form-group">
                    <label for="exampleTextarea" class="form-label mt-4">Customer Address</label>
                    <textarea class="form-control" name="fadd" id="exampleTextarea" rows="3"placeholder="Customer Address here" required></textarea>
                  </div>

                      
                  </div>

                  <br><br>
                  <div class="d-flex justify-content-end">
                      <button type="submit" name="saveuser" class="btn btn-primary">Save</button>
                  </div>
              </form>
            </div>
          </div>
          </div>

        </div>
      </div>
    </section>

    <?php mysqli_close($con); ?>
  </main><!-- End #main -->

<?php include 'footer.php'; ?>
