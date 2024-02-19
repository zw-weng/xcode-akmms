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
include 'headeradmin.php';

// Include database connection
include('dbconnect.php');
?>

<main id="main" class="main">

    <div class="pagetitle">
        <h1>Notification</h1>
        <div class="d-flex justify-content-between align-items-center">
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="adminmain.php">Home</a></li>
                    <li class="breadcrumb-item active">Notification</li>
                </ol>
            </nav>
            <div class="btn-group me-2">
                <a href="stock.php" class="btn btn-primary shadow"><i class="bi bi-check"></i> Check Stock</a>
            </div>
        </div>
    </div><!-- End Page Title -->

    <section class="section">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Stock Alert</h5>

                    <?php
                    $getstock = mysqli_query($con, "SELECT * FROM tb_advertising WHERE item_qty <= $alert");
                    $hasNotifications = false;

                    while ($fetch = mysqli_fetch_array($getstock)) {
                        $item_desc = $fetch['item_desc'];
                        $item_name = $fetch['item_name'];
                        $hasNotifications = true;
                        ?>
                        <a href="stock.php">
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="bi bi-exclamation-triangle me-1"></i>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                <strong><?= $item_name . ' - ' . $item_desc; ?></strong> is almost finished.
                            </div>
                        </a>
                    <?php
                    }

                    if (!$hasNotifications) {
                        ?>
                        <p class="text-center text-muted">No notifications</p>
                    <?php
                    }
                    ?>
                </div>
                <div class="card-footer text-center">
                    <a href="stock.php" class="btn-link">
                        <i class="bi bi-arrow-right"></i> Go to stock
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

    <?php mysqli_close($con); ?>
</main><!-- End #main -->

<?php include 'footer.php'; ?>