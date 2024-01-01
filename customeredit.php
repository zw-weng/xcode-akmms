<?php


// Include database connection
include('dbconnect.php');

// Get user id from url


// Retrieve current user data using prepared statement
$sql = "SELECT * FROM tb_customer WHERE cust_id = ?";
$stmt = mysqli_prepare($con, $sql);

if ($stmt) {
    
    mysqli_stmt_execute($stmt);

    // Get result
    $result = mysqli_stmt_get_result($stmt);

    if (!$result) {
        die("Query failed: " . mysqli_error($con));
    }

    $row = mysqli_fetch_array($result);

    // Include header
    include 'headeradmin.php';

    // Close statement
    mysqli_stmt_close($stmt);
} else {
    // Handle prepare statement error
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
              <li class="breadcrumb-item active">Edit Customer</li>
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
              <h5 class="card-title">Edit Customer</h5>

              <?= alertMessage(); ?>

              <form method="POST" action="customereditprocess.php">
                  <div class="form-group row">
                      <div class="col-md-6">
                          <label for="fcustid" class="form-label mt-4">Customer ID</label>
                          <?php
                          echo '<input type="text" name="fcustid" class="form-control" value="'.$row['cust_id'].'" id="fcustid" placeholder="" required>';
                          ?>
                      </div>
                      <div class="col-md-6">
                          <label for="fic" class="form-label mt-4">Customer Name</label>
                          <?php
                          echo '<input type="text" name="fname" class="form-control" value="'.$row['cust_name'].'" id="fic" placeholder="" required>';
                          ?>
                      </div>
                  </div>

                  

                  <div class="form-group row">
                      <div class="col-md-6">
                        <label for="exampleInputEmail1" class="form-label mt-4">Email address</label>
                        <?php 
                        echo '<input type="email" name="femail" class="form-control" value="'.$row['cust_email'].'" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="" required>';
                        ?>
                      </div>

                      <div class="col-md-6">
                          <label for="fphone" class="form-label mt-4">Phone No</label>
                          <?php
                          echo '<input type="text" name="fphone" class="form-control" value="'.$row['cust_phone'].'" id="fphone" placeholder="" required>';
                          ?>
                      </div>
                  </div>

                  <div class="form-group row">
                      

                      <div class="col-md-6">
                        <div class="form-group">
                    <label for="exampleTextarea" class="form-label mt-4">Customer Address</label>
                    <?php
                    echo'<textarea class="form-control" name="fadd" id="exampleTextarea" rows="3"placeholder="" required>'.$row['cust_address'].'</textarea>';
                    ?>
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


