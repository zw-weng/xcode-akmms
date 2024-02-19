<?php
include('mysession.php');

if (!session_id()) {
    session_start();
}

include('headeradmin.php');
include('dbconnect.php');

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $quotationId = $_GET['id'];

    $existingQuotationQuery = "SELECT * FROM tb_quotation WHERE quotation_id = $quotationId";
    $existingQuotationResult = mysqli_query($con, $existingQuotationQuery);

    if ($existingQuotationResult) {
        $existingQuotationData = mysqli_fetch_assoc($existingQuotationResult);
    } else {
        die("Error fetching existing quotation data: " . mysqli_error($con));
    }
} else {
    die("Quotation ID is missing.");
}
?>

<main id="main" class="main">

    <div class="pagetitle">
        <h1>Edit Quotation</h1>
        <div class="d-flex justify-content-between align-items-center">
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="adminmain.php">Home</a></li>
                    <li class="breadcrumb-item"><a href="#">Quotation</a></li>
                    <li class="breadcrumb-item"><a href="quote-jkr.php">Construction</a></li>
                    <li class="breadcrumb-item active">New</li>
                </ol>
            </nav>
            <div class="btn-group me-2">
                <a href="quote.php" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Back</a>
            </div>
        </div>
    </div><!-- End Page Title -->

    <section class="section">
        <form method="POST" action="quote-jkr-createprocess.php">
            <div class="row">
                <?= alertMessage(); ?>
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Quotation Details</h5>
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label for="quotationId" class="form-label mt-4">Quotation No</label>
                                    <input type="text" name="quotationId" class="form-control" id="quotationId" value="<?php echo $existingQuotationData['quotation_id']; ?>" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label for="quotationDate" class="form-label mt-4">Quotation Date</label>
                                    <input type="text" name="quotationDate" class="form-control" id="quotationDate" value="<?php echo $existingQuotationData['quotation_date']; ?>" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label for="paymentTerm" class="form-label mt-4">Payment Term</label>
                                    <?php
                                    echo '<select name="paymentTerm" class="form-control" id="paymentTerm" required>';
                                    while ($row = mysqli_fetch_assoc($paymentTermsResult)) {
                                        $selected = ($row['payment_term_id'] == $existingQuotationData['payment_term_id']) ? 'selected' : '';
                                        echo '<option value="' . $row['payment_term_id'] . '" ' . $selected . '>' . $row['payment_term_desc'] . '</option>';
                                    }
                                    echo '</select>';
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Customer Info</h5>
                            <a href="#" class="btn-link" data-bs-toggle="modal" data-bs-target="#custModal">
                                Select Existing Customer
                            </a>
                            <div class="modal fade" id="custModal" tabindex="-1">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Select Existing Customer</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <?= popCustomersList(); ?>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal"><i class="bi bi-x-square"></i> Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label for="fname" class="form-label mt-4">Name</label>
                                    <input type="text" name="fname" class="form-control" id="fname" placeholder="" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="exampleInputEmail1" class="form-label mt-4">Email</label>
                                    <input type="email" name="femail" class="form-control" id="femail" aria-describedby="emailHelp" placeholder="" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label for="fphone" class="form-label mt-4">Phone</label>
                                    <input type="text" name="fphone" class="form-control" id="fphone" placeholder="" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="fstreet" class="form-label mt-4">Street</label>
                                    <input type="text" name="fstreet" class="form-control" id="fstreet" placeholder="" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label for="fpostcode" class="form-label mt-4">Postcode</label>
                                    <input type="text" name="fpostcode" class="form-control" id="fpostcode" placeholder="" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="fcity" class="form-label mt-4">City</label>
                                    <input type="text" name="fcity" class="form-control" id="fcity" placeholder="" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label for="fstate" class="form-label mt-4">State</label>
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
                                        <option value="Putrajaya">Putrajaya</option>
                                        <option value="Labuan">Labuan</option>
                                        <option value="Other">Other</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="fcount" class="form-label mt-4">Country</label>
                                    <select name="fcount" class="form-control" id="fcount" required>
                                        <option value="" selected disabled>Select Country</option>
                                        <option value="Malaysia">Malaysia</option>
                                        <option value="Singapore">Singapore</option>
                                        <option value="Brunei">Brunei</option>
                                        <option value="Other">Other</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Order List</h5>
                        <a href="quote-jkr-add.php" class="btn btn-primary shadow" data-bs-toggle="modal" data-bs-target="#jkrModal">
                            <i class="bi bi-plus me-1"></i>Add Item
                        </a>
                        <div class="modal fade" id="jkrModal" tabindex="-1">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Select Material</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <?= popMaterialList(); ?>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal"><i class="bi bi-x-square"></i> Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive mt-4">
                            <table class="table table-hover datatable table1">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Item Description</th>
                                        <th>Qty</th>
                                        <th>Unit Price(RM)</th>
                                        <th>Disc(%)</th>
                                        <th>Disc Amount(RM)</th>
                                        <th>Tax Code</th>
                                        <th>Tax Amount(RM)</th>
                                        <th>Sub Total(RM)</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-end mt-4">
                            <strong>Grand Total:</strong>RM <span id="grandTotalDisplay" class="text-primary">0.00</span>
                        </div>
                        <br>
                        <br>
                        <div class="d-flex justify-content-end">
                            <button type="submit" name="save_info" class="btn btn-outline-primary"><i class="bi bi-arrow-up-square"></i> Save</button>
                            &nbsp;
                            <button type="reset" class="btn btn-outline-danger"><i class="bi bi-x-square"></i> Cancel</button>
                        </div>
        </form>
        </div>
        </div>
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var customerRows = document.querySelectorAll('.customer-select');

            customerRows.forEach(function(row) {
                row.addEventListener('click', function(event) {
                    event.preventDefault();

                    // Get data attributes from the selected customer row
                    var customerName = row.getAttribute('data-customer-name');
                    var customerEmail = row.getAttribute('data-customer-email');
                    var customerPhone = row.getAttribute('data-customer-phone');
                    var customerStreet = row.getAttribute('data-customer-street');
                    var customerPostcode = row.getAttribute('data-customer-postcode');
                    var customerCity = row.getAttribute('data-customer-city');
                    var customerState = row.getAttribute('data-customer-state');
                    var customerCountry = row.getAttribute('data-customer-country');

                    // Update form fields with selected customer data
                    document.getElementById('fname').value = customerName;
                    document.getElementById('femail').value = customerEmail;
                    document.getElementById('fphone').value = customerPhone;
                    document.getElementById('fstreet').value = customerStreet;
                    document.getElementById('fpostcode').value = customerPostcode;
                    document.getElementById('fcity').value = customerCity;
                    document.getElementById('fstate').value = customerState;
                    document.getElementById('fcount').value = customerCountry;
                });
            });

            var materialRows = document.querySelectorAll('.material-select');

            materialRows.forEach(function(row) {
                row.addEventListener('click', function(event) {
                    event.preventDefault();

                    // Check if the clicked element is inside the material modal
                    var isMaterialModal = event.target.closest('#jkrModal');

                    if (isMaterialModal) {
                        // Get data attributes from the selected material row
                        var materialName = row.getAttribute('data-material-name');
                        var materialDesc = row.getAttribute('data-material-desc');
                        var materialCost = row.getAttribute('data-material-cost');

                        // Create a new row in the order list table and populate it with the selected material data
                        var table = document.querySelector('.table1 tbody');
                        var newRow = table.insertRow(table.rows.length);

                        // Add cells to the new row
                        var cellNo = newRow.insertCell(0);
                        var cellDesc = newRow.insertCell(1);
                        var cellQty = newRow.insertCell(2);
                        var cellUnitPrice = newRow.insertCell(3);
                        var cellDisc = newRow.insertCell(4);
                        var cellDiscAmount = newRow.insertCell(5);
                        var cellTaxCode = newRow.insertCell(6);
                        var cellTaxAmount = newRow.insertCell(7);
                        var cellSubTotal = newRow.insertCell(8);
                        var cellAction = newRow.insertCell(9);

                        // Define subtotalValue variable
                        var materialCostValue = parseFloat(materialCost);
                        var subtotalValue = materialCostValue;

                        // Populate cells with data
                        cellNo.innerHTML = table.rows.length - 1;
                        cellDesc.innerHTML = materialName + ' - ' + materialDesc;
                        cellQty.innerHTML = '<input type="text" name="qty[]" class="form-control" value="1" />';
                        cellUnitPrice.innerHTML = '<input type="text" name="unit_price[]" class="form-control" value="' + materialCost + '" />';
                        cellDisc.innerHTML = '<input type="text" name="disc[]" class="form-control" value="0" />';
                        cellDiscAmount.innerHTML = '<input type="text" name="disc_amount[]" class="form-control" value="0" readonly />';
                        cellTaxCode.innerHTML = '<input type="text" name="tax_code[]" class="form-control" value="" />';
                        cellTaxAmount.innerHTML = '<input type="text" name="tax_amount[]" class="form-control" value="0"/>';
                        // Calculate subtotal based on the formula
                        var updateSubtotal = function() {
                            var quantity = parseFloat(cellQty.querySelector('input').value) || 0;
                            var discountPercent = parseFloat(cellDisc.querySelector('input').value) || 0;
                            var materialCostValue = parseFloat(materialCost);
                            var discountAmount = (quantity * materialCostValue * (discountPercent / 100));
                            var taxAmount = parseFloat(cellTaxAmount.querySelector('input').value) || 0;
                            subtotalValue = (quantity * materialCostValue) - discountAmount + taxAmount;
                            cellDiscAmount.querySelector('input').value = discountAmount.toFixed(2);
                            cellSubTotal.querySelector('input').value = subtotalValue.toFixed(2);
                            calculateGrandTotal();
                        };
                        // Add event listeners for relevant input fields
                        cellQty.querySelector('input').addEventListener('input', updateSubtotal);
                        cellDisc.querySelector('input').addEventListener('input', updateSubtotal);
                        cellTaxAmount.querySelector('input').addEventListener('input', updateSubtotal);
                        cellSubTotal.innerHTML = '<input type="text" name="sub_total[]" class="form-control" value="' + subtotalValue.toFixed(2) + '" readonly />';
                        cellAction.innerHTML = '<button type="button" class="btn btn-outline-danger" onclick="removeRow(this)"><i class="bi bi-trash"></i></button>';
                    }
                });
            });
        });

        function removeRow(button) {
            // Function to remove the row when the delete button is clicked
            var row = button.parentNode.parentNode;
            row.parentNode.removeChild(row);
            calculateGrandTotal();
        }

        function calculateGrandTotal() {
            // Calculate grand total
            var grandTotalValue = 0;
            var subTotalInputs = document.querySelectorAll('input[name="sub_total[]"]');
            subTotalInputs.forEach(function (input) {
                grandTotalValue += parseFloat(input.value) || 0;
            });
            // Update grand total display
            document.getElementById('grandTotalDisplay').textContent = grandTotalValue.toFixed(2);
        }
    </script>

    <?php mysqli_close($con); ?>
</main><!-- End #main -->

<?php include 'footer.php'; ?>