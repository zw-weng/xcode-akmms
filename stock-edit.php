<?php
include('mysession.php');

if (!session_id()) {
    session_start();
}
// Include header
include 'headeradmin.php';

// Include database connection
include('dbconnect.php');

// Get stock item id from URL
if (isset($_GET['id'])) {
    $stockItemId = $_GET['id'];

    // Validate and sanitize the stock item ID to prevent SQL injection
    $stockItemId = mysqli_real_escape_string($con, $stockItemId);
    $stockItemId = htmlspecialchars($stockItemId); // Additional input sanitization
}

// Fetch item categories for dropdown
$sqlItemCategories = "SELECT * FROM tb_itemcategory";
$resultItemCategories = mysqli_query($con, $sqlItemCategories);

if (!$resultItemCategories) {
    die("Query failed: " . mysqli_error($con));
}

// Retrieve current stock item data using prepared statement
$sql = "SELECT * FROM tb_advertising WHERE item_id = ?";
$stmt = mysqli_prepare($con, $sql);

if ($stmt) {
    mysqli_stmt_bind_param($stmt, "s", $stockItemId);
    mysqli_stmt_execute($stmt);

    // Get result
    $result = mysqli_stmt_get_result($stmt);

    if (!$result) {
        die("Query failed: " . mysqli_error($con));
    }

    $row = mysqli_fetch_array($result);

    // Close statement
    mysqli_stmt_close($stmt);
} else {
    // Handle prepare statement error
    die("Prepare statement failed: " . mysqli_error($con));
}
?>

<main id="main" class="main">

    <div class="pagetitle">
        <h1>Edit Stock Item</h1>
        <div class="d-flex justify-content-between align-items-center">
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="adminmain.php">Home</a></li>
                    <li class="breadcrumb-item"><a href="#">Inventory</a></li>
                    <li class="breadcrumb-item"><a href="stock.php">Stock</a></li>
                    <li class="breadcrumb-item active">Edit Stock Item</li>
                </ol>
            </nav>

            <div class="btn-group me-2">
                <a href="stock.php" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Back</a>
            </div>
        </div>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Edit Stock Item</h5>

                        <?= alertMessage(); ?>

                        <form method="POST" action="stock-editprocess.php?id=<?= $row['item_id'] ?>">
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label for="item_name" class="form-label mt-4">Item Name</label>
                                    <input type="text" name="item_name" class="form-control" value="<?= $row['item_name'] ?>" id="item_name" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="item_desc" class="form-label mt-4">Item Description</label>
                                    <input type="text" name="item_desc" class="form-control" value="<?= $row['item_desc'] ?>" id="item_desc" required>
                                </div>
                            </div>

                            <!-- Add more fields as needed -->

                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label for="item_cost" class="form-label mt-4">Item Cost (RM)</label>
                                    <input type="number" name="item_cost" class="form-control" value="<?= $row['item_cost'] ?>" id="item_cost" required step="0.01">
                                    <small class="text-muted">Please enter a valid numeric value with up to two decimal places.</small>
                                </div>
                                <div class="col-md-6">
                                    <label for="item_qty" class="form-label mt-4">Item Quantity</label>
                                    <input type="number" name="item_qty" class="form-control" value="<?= $row['item_qty'] ?>" id="item_qty" required pattern="\d*">
                                </div>
                            </div>

                            <div class="form-group row">
                                <!-- Markup Input -->
                                <div class="col-md-6">
                                    <label for="item_markup" class="form-label mt-4">Markup (%)</label>
                                    <?php
                                    // Fetch the current item_markup value from the database
                                    $itemId = $row['item_id']; // Use the item_id from the form

                                    $sqlFetchMarkup = "SELECT markup_rate FROM tb_advertising WHERE item_id = $itemId";
                                    $resultFetchMarkup = mysqli_query($con, $sqlFetchMarkup);

                                    if ($resultFetchMarkup && mysqli_num_rows($resultFetchMarkup) > 0) {
                                        $rowMarkup = mysqli_fetch_assoc($resultFetchMarkup);
                                        $currentMarkup = $rowMarkup['markup_rate'];
                                    } else {
                                        // Handle the case where the markup is not found
                                        $currentMarkup = 0; // Set a default value or handle the error accordingly
                                    }
                                    ?>
                                    <div class="input-group">
                                        <input type="number" name="item_markup" class="form-control" value="<?= $currentMarkup ?>" id="item_markup" required step="0.01">
                                        <button type="button" class="btn btn-primary shadow" id="calculatePriceButtonEdit">
                                            <i class="bi bi-calculator"></i> Calculate
                                        </button>
                                    </div>
                                </div>

                                <!-- Current Price Display -->
                                <div class="col-md-6">
                                    <label for="current_price" class="form-label mt-4">Current Price (RM)</label>
                                    <?php
                                    // Fetch actual item cost from the database based on the selected item
                                    $selected_item_id = $row['item_id']; // Use the item_id from the form

                                    $sqlActualItem = "SELECT item_cost FROM tb_advertising WHERE item_id = $selected_item_id";
                                    $resultActualItem = mysqli_query($con, $sqlActualItem);

                                    if ($resultActualItem && mysqli_num_rows($resultActualItem) > 0) {
                                        $rowActualItem = mysqli_fetch_assoc($resultActualItem);
                                        $actual_item_cost = $rowActualItem['item_cost'];
                                    } else {
                                        // Handle the case where the selected item is not found
                                        $actual_item_cost = 0; // Set a default value or handle the error accordingly
                                    }

                                    // Initialize markup to 0 if not set
                                    $markup = $currentMarkup / 100; // Convert percentage to decimal

                                    // Calculate the current price based on the markup (divide by 100 to convert to decimal)
                                    $current_price = $actual_item_cost * (1 + $markup);
                                    ?>

                                    <input type="text" class="form-control" id="current_price" value="<?= number_format($current_price, 2) ?>" readonly>
                                </div>

                                <script>
                                    document.getElementById('calculatePriceButtonEdit').addEventListener('click', function() {
                                        // Get values from the form
                                        var actualItemCost = parseFloat(document.getElementById('item_cost').value);
                                        var markup = parseFloat(document.getElementById('item_markup').value);

                                        // Check if values are valid numbers
                                        if (!isNaN(actualItemCost) && !isNaN(markup)) {
                                            // Calculate the current price based on the markup (divide by 100 to convert to decimal)
                                            var currentPrice = actualItemCost * (1 + markup / 100);

                                            // Update the current price input field
                                            document.getElementById('current_price').value = currentPrice.toFixed(2); // Display up to two decimal places
                                        } else {
                                            alert('Please enter valid numeric values for Item Cost and Markup.');
                                        }
                                    });
                                </script>

                            </div>

                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label for="item_category" class="form-label mt-4">Item Category</label>
                                    <select name="item_category" class="form-control" id="item_category" required>
                                        <?php
                                        while ($rowCategory = mysqli_fetch_array($resultItemCategories)) {
                                            $selected = ($rowCategory['item_category_id'] == $row['item_category_id']) ? 'selected' : '';
                                            echo "<option value='" . $rowCategory['item_category_id'] . "' $selected>" . $rowCategory['item_category_desc'] . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <br>
                            <div class="d-flex justify-content-end">
                                <button type="submit" name="save_stock" class="btn btn-outline-primary"><i class="bi bi-arrow-up-square"></i> Save</button>
                                &nbsp;
                                <button type="reset" class="btn btn-outline-danger"><i class="bi bi-x-square"></i> Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <?php mysqli_close($con); ?>
</main><!-- End #main -->

<?php include 'footer.php'; ?>