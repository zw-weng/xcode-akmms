<?php
include('mysession.php');
if (!session_id()) {
  session_start();
}
// Include header
include 'headeradmin.php';
// Include database connection
include('dbconnect.php');



// Get user id from url
if (isset($_GET['id'])) {
  $fcustid = $_GET['id'];
}

// Retrieve current user data using prepared statement
$sql = "SELECT * FROM tb_customer WHERE cust_id = '$fcustid'";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_array($result);
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
                  echo '<input type="text" name="fcustid" class="form-control" value="' . $row['cust_id'] . '" id="fcustid" placeholder="" required disabled>';
                  echo '<input type="hidden" name="fcustid" class="form-control" value="' . $row['cust_id'] . '" id="fcustid" placeholder="" required>';
                  ?>
                  <small id="emailHelp" class="form-text text-muted">Eg. Klinik Kesihatan Daerah Pontian</small>
                </div>
                <div class="col-md-6">
                  <label for="fic" class="form-label mt-4">Customer Name</label>
                  <?php
                  echo '<input type="text" name="fname" class="form-control" value="' . $row['cust_name'] . '" id="fic" placeholder="" required>';
                  ?>
                </div>
              </div>

              <div class="form-group row">
                <div class="col-md-6">
                  <label for="exampleInputEmail1" class="form-label mt-4">Email address</label>
                  <?php
                  echo '<input type="email" name="femail" class="form-control" value="' . $row['cust_email'] . '" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="" required>';
                  ?>
                </div>

                <div class="col-md-6">
                  <label for="fphone" class="form-label mt-4">Contact No.</label>
                  <?php
                  echo '<input type="text" name="fphone" class="form-control" value="' . $row['cust_phone'] . '" id="fphone" placeholder="" required>';
                  ?>
                </div>
              </div>

              <div class="form-group row">

                <div class="col-md-6">
                  <label for="fcustid" class="form-label mt-4">Street</label>
                  <?php
                  echo '<input type="text" name="fstreet" class="form-control" value="' . $row['cust_street'] . '" id="fcustid" placeholder="" required>';
                  ?>
                </div>
                <div class="col-md-6">
                  <label for="fcustid" class="form-label mt-4">Postcode</label>
                  <?php
                  echo '<input type="number" name="fpostcode" class="form-control" value="' . $row['cust_postcode'] . '" id="fcustid" placeholder="" required>';
                  ?>
                </div>
              </div>

              <div class="form-group row">

                <div class="col-md-6">
                  <label for="fcustid" class="form-label mt-4">City</label>
                  <?php
                  echo '<input type="text" name="fcity" class="form-control" value="' . $row['cust_city'] . '" id="fcustid" placeholder="" required>';
                  ?>
                </div>

                <div class="col-md-6">
                  <label for="fcustid" class="form-label mt-4">State</label>
                  <select name="fstate" class="form-control" id="fstate" required>
                    <option value="" disabled>Select State</option>
                    <?php
                    // Fetch and display the list of states from your database
                    $states = array("Johor", "Kedah", "Kelantan", "Melaka", "Selangor", "Negeri Sembilan", "Pahang", "Terengganu", "Perlis", "Penang", "Perak", "Sabah", "Sarawak", "Kuala Lumpur", "Labuan", "Putrajaya", "Others"); // Replace with your actual data
                    foreach ($states as $state) {
                      echo '<option value="' . $state . '" ' . ($row['cust_state'] == $state ? 'selected' : '') . '>' . $state . '</option>';
                    }
                    ?>
                  </select>
                </div>
                <div class="col-md-6">
                  <label for="fcustid" class="form-label mt-4">Country</label>
                  <select name="fcountry" class="form-control" id="fcountry" required>
                    <option value="" disabled>Select Country</option>
                    <?php
                    // Fetch and display the list of states from your database
                    $country = array("Malaysia", "Singapore", "Brunei", "Others"); // Replace with your actual data
                    foreach ($country as $country1) {
                      echo '<option value="' . $country1 . '" ' . ($row['cust_country'] == $country1 ? 'selected' : '') . '>' . $country1 . '</option>';
                    }
                    ?>
                  </select>
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