<?php
include('mysession.php');
if (!session_id()) {
  session_start();
}
include('headerstaff.php');
// Include database connection
include('dbconnect.php');


// Get user id from url
if (isset($_GET['id'])) {
  $fcustid = $_GET['id'];
}
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
          <li class="breadcrumb-item"><a href="staffmain.php">Home</a></li>
          <li class="breadcrumb-item"><a href="staff-customer1.php">Customer Management</a></li>
          <li class="breadcrumb-item active">Add Customer</li>
        </ol>
      </nav>

      <div class="btn-group me-2">
        <a href="staff-customer1.php" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Back</a>
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

            <form method="POST" action="staff-customeraddprocess1.php">
              <div class="form-group row">
                <div class="col-md-6">
                  <label for="fic" class="form-label mt-4">Customer Name</label>
                  <input type="text" name="fname" class="form-control" id="fic" placeholder="Enter customer name" required>
                  <small id="emailHelp" class="form-text text-muted">Eg. Klinik Kesihatan Daerah Pontian</small>
                </div>
                <div class="col-md-6">
                  <label for="exampleInputEmail1" class="form-label mt-4">Email Address</label>
                  <input type="email" name="femail" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter customer email" required>
                </div>
              </div>

              <div class="form-group row">
                <div class="col-md-6">
                  <label for="ffname" class="form-label mt-4">Contact No.</label>
                  <input type="text" name="fphone" class="form-control" id="ffname" placeholder="Enter customer contact number" required>
                </div>
              </div>

              <div class="form-group row">

                <div class="col-md-6">
                  <label for="fid" class="form-label mt-4">Street</label>
                  <input type="text" name="fstreet" class="form-control" id="fid" placeholder="Enter street" required>
                </div>
                <div class="col-md-6">
                  <label for="fid" class="form-label mt-4">Postcode</label>
                  <input type="number" name="fpostcode" class="form-control" id="fid" placeholder="Enter postcode" required>
                </div>
              </div>

              <div class="form-group row">

                <div class="col-md-6">
                  <label for="fid" class="form-label mt-4">City</label>
                  <input type="text" name="fcity" class="form-control" id="fid" placeholder="Enter city" required>
                </div>
                <div class="col-md-6">
                  <label for="fid" class="form-label mt-4">State</label>
                  <select name="fstate" class="form-control" id="fstate" required>
                    <option value="" selected disabled>Select State</option>
                    <option value="Johor">Johor</option>
                    <option value="Kedah">Kedah</option>
                    <option value="Kelantan">Kelantan</option>
                    <option value="Melaka">Melaka</option>
                    <option value="Selangor">Selangor</option>
                    <option value="Negeri Sembilan">Negeri Sembilan</option>
                    <option value="Pahang">Pahang</option>
                    <option value="Terengganu">Terengganu</option>
                    <option value="Perlis">Perlis</option>
                    <option value="Penang">Penang</option>
                    <option value="Perak">Perak</option>
                    <option value="Sabah">Sabah</option>
                    <option value="Sarawak">Sarawak</option>
                    <option value="Kuala Lumpur">Kuala Lumpur</option>
                    <option value="Labuan">Labuan</option>
                    <option value="Putrajaya">Putrajaya</option>
                    <option value="Others">Others</option>
                  </select>
                </div>
                <div class="col-md-6">
                  <label for="fid" class="form-label mt-4">Customer Country</label>
                  <select name="fcountry" class="form-control" id="fcountry" required>
                    <option value="" selected disabled>Select Country</option>
                    <option value="Malaysia">Malaysia</option>
                    <option value="Singapore">Singapore</option>
                    <option value="Brunei">Brunei</option>
                    <option value="Others">Others</option>
                  </select>
                </div>
              </div>
              <br><br>
              <div class="d-flex justify-content-end">
                <button type="submit" name="saveuser" class="btn btn-outline-primary"><i class="bi bi-arrow-up-square"></i> Save</button>
                &nbsp;
                <button type="reset" class="btn btn-outline-danger"><i class="bi bi-x-square"></i> Cancel</button>
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