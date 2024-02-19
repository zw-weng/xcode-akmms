<?php
include('mysession.php');

if (!session_id()) {
    session_start();
}

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

    // Display result
    include 'headeradmin.php';
} else {
    die("Prepare statement failed: " . mysqli_error($con));
}
?>

  <main id="main" class="main">



    <div class="pagetitle">
      <h1>Quotation (Advertising)</h1>
      <div class="d-flex justify-content-between align-items-center">
      <nav>
          <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="adminmain.php">Home</a></li>
              <li class="breadcrumb-item active">Quotation</li>
              <li class="breadcrumb-item"><a href="quotation-advertising.php">Advertising</a></li>
              <li class="breadcrumb-item active">Add Quotation</li>
          </ol>
      </nav>

      <div class="btn-group me-2">
          <a href="quotation-advertising.php" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Back</a>
      </div>
      </div>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Add Quotation</h5>

              <?= alertMessage(); ?>

                <div class="row">



        <div class="col-xs-6">
          <div class="panel panel-default">
            <div class="panel-heading">
              <h4 class="float-left">Customer Information</h4>
              <a href="#" class="float-right select-customer"><b>OR</b> Select Existing Customer</a>
              <div class="clear"></div>
            </div>

            <div class="panel-body form-group form-group-sm">
              <div class="row">
                <div class="col-xs-6">
                  <div class="form-group">
                    <input type="text" class="form-control margin-bottom copy-input required" name="customer_name" id="customer_name" placeholder="Enter Name" tabindex="1">
                  </div>
                  <div class="form-group">
                    <input type="text" class="form-control margin-bottom copy-input required" name="customer_address_1" id="customer_address_1" placeholder="Address 1" tabindex="3"> 
                  </div>
                  <div class="form-group">
                    <input type="text" class="form-control margin-bottom copy-input required" name="customer_town" id="customer_town" placeholder="Town" tabindex="5">    
                  </div>
                  <div class="form-group no-margin-bottom">
                    <input type="text" class="form-control copy-input required" name="customer_postcode" id="customer_postcode" placeholder="Postcode" tabindex="7">          
                  </div>
                </div>
                <div class="col-xs-6">
                  <div class="input-group float-right margin-bottom">
                    <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                    <input type="email" class="form-control copy-input required" name="customer_email" id="customer_email" placeholder="E-mail Address" aria-describedby="sizing-addon1" tabindex="2">
                  </div>
                    <div class="form-group">
                      <input type="text" class="form-control margin-bottom copy-input required" name="customer_county" id="customer_county" placeholder="Country" tabindex="6">
                    </div>
                    <div class="form-group no-margin-bottom">
                      <input type="text" class="form-control required" name="customer_phone" id="customer_phone" placeholder="Phone Number" tabindex="8">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-xs-6 text-right">
          <div class="panel panel-default">
            <div class="panel-heading">
             <br> <h4>Shipping Information</h4>
            </div>
            <div class="panel-body form-group form-group-sm">
              <div class="row">
                <div class="col-xs-6">
                  <div class="form-group">
                    <input type="text" class="form-control margin-bottom required" name="customer_name_ship" id="customer_name_ship" placeholder="Enter Name" tabindex="9">
                  </div>
                  <div class="form-group no-margin-bottom">
                    <input type="text" class="form-control required" name="customer_county_ship" id="customer_county_ship" placeholder="Country" tabindex="13">
                  </div>
                </div>
                <div class="col-xs-6">
                  <div class="form-group">
                      <input type="text" class="form-control margin-bottom required" name="customer_address_1_ship" id="customer_address_1_ship" placeholder="Address 1" tabindex="10">
                  </div>
                  <div class="form-group">
                    <input type="text" class="form-control margin-bottom required" name="customer_town_ship" id="customer_town_ship" placeholder="Town" tabindex="12">              
                    </div>
                    <div class="form-group no-margin-bottom">
                      <input type="text" class="form-control required" name="customer_postcode_ship" id="customer_postcode_ship" placeholder="Postcode" tabindex="14">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- / end client details section -->


      <div class="form-group">
      <label for="exampleInputPassword1" class="form-label mt-4">Select Date</label>
      <input type="date" name="fpdate" class="form-control" id="exampleInputPassword1" placeholder="Password" autocomplete="off">
    </div>


              <form method="POST" action="quotation-advertising-create-process.php">
                  <div class="form-group row">
                      <div class="col-md-6">
                          <label for="fid" class="form-label mt-4">Product</label>
                          <input type="text" name="fid" class="form-control" id="fid" placeholder="" required>
                      </div>
                      <div class="col-md-6">
                          <label for="fic" class="form-label mt-4">Quantity</label>
                          <input type="text" name="fic" class="form-control" id="fic" placeholder="" required>
                      </div>
                  </div>

                  <div class="form-group row">
                      <div class="col-md-6">
                          <label for="ffname" class="form-label mt-4">Price</label>
                          <input type="text" name="ffname" class="form-control" id="ffname" placeholder="" required>
                      </div>
                      <div class="col-md-6">
                          <label for="flname" class="form-label mt-4">Sub Total</label>
                          <input type="text" name="flname" class="form-control" id="flname" placeholder="" required>
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
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <script>
$(document).ready(function() {
    // Event listener for customer name
    $('#customer_name').on('input', function() {
        $('#customer_name_ship').val($(this).val());
    });

    // Event listener for customer address 1
    $('#customer_address_1').on('input', function() {
        $('#customer_address_1_ship').val($(this).val());
    });

    // Event listener for customer address 2
    $('#customer_address_2').on('input', function() {
        $('#customer_address_2_ship').val($(this).val());
    });

    // Event listener for customer town
    $('#customer_town').on('input', function() {
        $('#customer_town_ship').val($(this).val());
    });

    // Event listener for customer county
    $('#customer_county').on('input', function() {
        $('#customer_county_ship').val($(this).val());
    });

    // Event listener for customer postcode
    $('#customer_postcode').on('input', function() {
        $('#customer_postcode_ship').val($(this).val());
    });
});
</script>







    <?php mysqli_close($con); ?>
  </main><!-- End #main -->

<?php include 'footer.php'; ?>