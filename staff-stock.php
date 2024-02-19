<?php
include('mysession.php');
if (!session_id()) {
  session_start();
}

// Include database connection
include('dbconnect.php');

// Retrieve advertising data using a JOIN statement
$sql = "SELECT * FROM tb_advertising
          INNER JOIN tb_itemcategory ON tb_advertising.item_category_id = tb_itemcategory.item_category_id";

$sqlr = "SELECT min_value FROM tb_alert";

$result = mysqli_query($con, $sql);

// Fetch the minimum value
$resultr = mysqli_query($con, $sqlr);

if ($resultr) {
  $row = mysqli_fetch_assoc($resultr);
  $alert = $row['min_value'];
  // Store the value in a session variable
  $_SESSION['alert'] = $alert;
} else {
  // Handle the error
  echo "Error: " . mysqli_error($con);
  $_SESSION['alert'] = 0; // Set a default value
}
//Close database connection
mysqli_close($con);

// Display result
include 'headerstaff.php';

// Include database connection
include('dbconnect.php');
?>

<main id="main" class="main">

  <div class="pagetitle">
    <h1>Stock Management</h1>
    <div class="d-flex justify-content-between align-items-center">
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="staffmain.php">Home</a></li>
          <li class="breadcrumb-item"><a href="#">Inventory</a></li>
          <li class="breadcrumb-item active">Stock</li>
        </ol>
      </nav>

      <div class="d-flex">
        <a href="staff-stock-create.php" class="btn btn-primary shadow">
          <i class="bi bi-plus-circle"></i> Add
        </a>
        &nbsp;
        <button type="button" class="btn btn-danger shadow">
          Alert <span class="badge bg-white text-danger"><?= getAlertCount($con, $alert); ?></span>
        </button>
        &nbsp;
        <a href="stock-export-excel.php" class="btn btn-success shadow">
          <i class="bi bi-file-excel"></i> Export
        </a>
        &nbsp;
        <a href="staff-stock-bin.php" class="btn btn-secondary shadow">
          <i class="bi bi-recycle"></i> Bin
        </a>
      </div>
    </div>
  </div><!-- End Page Title -->

  <section class="section">
    <div class="row">
      <div class="col-lg-12">
        <?php
        $getstock = mysqli_query($con, "SELECT * FROM tb_advertising WHERE item_qty <= $alert");
        while ($fetch = mysqli_fetch_array($getstock)) {
          $item_desc = $fetch['item_desc'];
          $item_name = $fetch['item_name'];
        ?>
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-octagon me-1"></i>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            <strong><?= $item_name . ' - ' . $item_desc; ?></strong> is almost finished.
          </div>
        <?php
        }
        ?>
        <?= alertMessage(); ?>
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Stock List</h5>

            <!-- Wrap the table with a div and apply the table-responsive class -->
            <div class="table-responsive mt-4">
              <!-- Table with stripped rows -->
              <table class="table table-hover datatable">
                <thead>
                  <tr>
                    <th>Item ID</th>
                    <th>Item Name</th>
                    <th>Description</th>
                    <th>Cost</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Category</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  while ($row = mysqli_fetch_array($result)) {
                    if ($row['item_status'] == 1) {
                      echo "<tr>";
                      echo "<td>" . $row['item_id'] . "</td>";
                      echo "<td>" . $row['item_name'] . "</td>";
                      echo "<td>" . $row['item_desc'] . "</td>";
                      echo "<td>" . $row['item_cost'] . "</td>";
                      echo "<td>" . $row['item_price'] . "</td>";
                      echo "<td>" . $row['item_qty'] . "</td>";
                      echo "<td>" . $row['item_category_desc'] . "</td>";
                      echo "<td>";
                      echo "<div class='btn-group' role='group'>";
                      echo "<a href='staff-stock-edit.php?id=" . $row['item_id'] . "' class='btn btn-warning btn-sm'><i class='bi bi-pencil'></i></a>";
                      echo "&nbsp;";
                      echo "<a class='btn btn-danger btn-sm' href='staff-stock-deactivate.php?id=" . $row['item_id'] . "&action=deactivate' onclick='return confirm(\"Are you sure you want to delete this item?\")'><i class='bi bi-trash'></i></a>";
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