<?php
include('mysession.php');

if (!session_id()) {
    session_start();
}
// Display result
include('headeradmin.php');

// Include database connection
include('dbconnect.php');

// Fetch item categories for dropdown
$sqlItemCategories = "SELECT * FROM tb_itemcategory";
$resultItemCategories = mysqli_query($con, $sqlItemCategories);
?>

<main id="main" class="main">

    <div class="pagetitle">
        <h1>Add Item</h1>
        <div class="d-flex justify-content-between align-items-center">
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="adminmain.php">Home</a></li>
                    <li class="breadcrumb-item"><a href="#">Inventory</a></li>
                    <li class="breadcrumb-item"><a href="stock.php">Stock</a></li>
                    <li class="breadcrumb-item active">Add Item</li>
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
                        <h5 class="card-title">Add Item</h5>

                        <?= alertMessage(); ?>

                        <form method="POST" action="stock-createprocess.php">
                            <!-- Add form fields for item -->
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label for="item_name" class="form-label mt-4">Item Name</label>
                                    <input type="text" name="item_name" class="form-control" id="item_name" placeholder="Enter item name" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="item_desc" class="form-label mt-4">Item Description</label>
                                    <input type="text" name="item_desc" class="form-control" id="item_desc" placeholder="Enter item description" required>
                                </div>
                            </div>

                            <!-- Add more fields as needed -->

                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label for="item_cost" class="form-label mt-4">Item Cost (RM)</label>
                                    <input type="number" name="item_cost" class="form-control" id="item_cost" placeholder="Enter item cost" required step="0.01">
                                    <small class="text-muted">Please enter a valid numeric value with up to two decimal places.</small>
                                </div>
                                <div class="col-md-6">
                                    <label for="item_qty" class="form-label mt-4">Item Quantity</label>
                                    <input type="number" name="item_qty" class="form-control" id="item_qty" placeholder="Enter item quantity" required pattern="\d*">
                                </div>
                            </div>

                            <div class="form-group row">
                                <!-- Markup Input -->
                                <div class="col-md-6">
                                    <label for="item_markup" class="form-label mt-4">Markup (%)</label>
                                    <div class="input-group">
                                        <input type="number" name="item_markup" class="form-control" id="item_markup" placeholder="Enter markup rate" required>
                                        <button type="button" class="btn btn-primary shadow" id="calculatePriceButton">
                                            <i class="bi bi-calculator"></i> Calculate
                                        </button>
                                    </div>
                                </div>

                                <!-- Current Price Display -->
                                <div class="col-md-6">
                                    <label for="current_price" class="form-label mt-4">Current Price (RM)</label>
                                    <input type="text" class="form-control" id="current_price" readonly>
                                </div>

                                <script>
                                    document.getElementById('calculatePriceButton').addEventListener('click', function() {
                                        // Get values from the form
                                        var actualItemCost = parseFloat(document.getElementById('item_cost').value);
                                        var markup = parseFloat(document.getElementById('item_markup').value);

                                        // Check if values are valid numbers
                                        if (!isNaN(actualItemCost) && !isNaN(markup)) {
                                            // Calculate the current price based on the markup
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
                                            echo "<option value='" . $rowCategory['item_category_id'] . "'>" . $rowCategory['item_category_desc'] . "</option>";
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