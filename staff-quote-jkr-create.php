<?php
include('mysession.php');

if (!session_id()) {
    session_start();
}
include('headerstaff.php');
// Include reuqired files
include('dbconnect.php');

$sql = "SELECT * FROM tb_quotation INNER JOIN tb_paymentterm ON tb_quotation.payment_term_id = tb_paymentterm.payment_term_id";
$result = mysqli_query($con, $sql);

$paymentTermsQuery = "SELECT * FROM tb_paymentterm";
$paymentTermsResult = mysqli_query($con, $paymentTermsQuery);

// CRUD: Retrieve electric rate data
$sqle = "SELECT * FROM tb_electric";
$resulte = mysqli_query($con, $sqle);

$sqlel = "SELECT * FROM tb_electric";
$resultel = mysqli_query($con, $sqlel);

$sqleli = "SELECT * FROM tb_electric";
$resulteli = mysqli_query($con, $sqleli);

$sqlele = "SELECT * FROM tb_electric";
$resultele = mysqli_query($con, $sqlele);

// CRUD: Retrieve civil rate data
$sqlc = "SELECT * FROM tb_civil";
$resultc = mysqli_query($con, $sqlc);

$sqlci = "SELECT * FROM tb_civil";
$resultci = mysqli_query($con, $sqlci);

$sqlciv = "SELECT * FROM tb_civil";
$resultciv = mysqli_query($con, $sqlciv);

$sqlcivi = "SELECT * FROM tb_civil";
$resultcivi = mysqli_query($con, $sqlcivi);
?>

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Generate New Quotation</h1>
        <div class="d-flex justify-content-between align-items-center">
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="staffmain.php">Home</a></li>
                    <li class="breadcrumb-item"><a href="#">Quotation</a></li>
                    <li class="breadcrumb-item"><a href="staff-quote-jkr.php">Construction</a></li>
                    <li class="breadcrumb-item active">New</li>
                </ol>
            </nav>
            <div class="btn-group me-2">
                <a href="staff-quote.php" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Back</a>
            </div>
        </div>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <?= alertMessage(); ?>
            <div class="card">
                <div class="card-body pt-3">
                    <!-- Bordered Tabs -->
                    <ul class="nav nav-tabs nav-tabs-bordered">
                        <!-- Step 1: Customer Info -->
                        <li class="nav-item">
                            <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#cust-info">
                                <span class="step-number">1</span> Customer Info
                            </button>
                        </li>
                        <!-- Step 2: Quotation Info -->
                        <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#quote-info">
                                <span class="step-number">2</span> Quotation Info
                            </button>
                        </li>
                        <!-- Step 3: Order List -->
                        <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#order-info">
                                <span class="step-number">3</span> Order List
                            </button>
                        </li>
                    </ul>
                    <form method="POST" action="staff-quote-jkr-createprocess.php">
                        <div class="tab-content pt-2">
                            <div class="tab-pane fade quote-info" id="quote-info">
                                <h5 class="card-title">Quotation Details</h5>
                                <div class="form-group row">
                                    <div class="col-md-6">
                                        <label for="quotationId" class="form-label mt-2">Quotation No</label>
                                        <input type="text" name="quotationId" class="form-control" id="quotationId" value="<?php echo getLastInsertedId(); ?>" readonly>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="quotationDate" class="form-label mt-2">Quotation Date</label>
                                        <input type="text" name="quotationDate" class="form-control" id="quotationDate" placeholder="Automatically generated" value="<?php echo date('Y-m-d'); ?>" readonly>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-6">
                                        <label for="paymentTerm" class="form-label mt-4">Payment Term</label>
                                        <?php
                                        echo '<select name="paymentTerm" class="form-control" id="paymentTerm" required>';
                                        echo '<option value="" selected disabled>Select Payment Term</option>';

                                        while ($row = mysqli_fetch_assoc($paymentTermsResult)) {
                                            echo '<option value="' . $row['payment_term_id'] . '">' . $row['payment_term_desc'] . '</option>';
                                        }

                                        echo '</select>';
                                        ?>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="category" class="form-label mt-4">Category</label>
                                        <div class="form-check">
                                            <div class="form-check-inline">
                                                <input class="form-check-input" type="radio" name="category" id="civilCategory" value="Civil" checked onchange="toggleFields()">
                                                <label class="form-check-label" for="civilCategory">Civil</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="category" id="electricalCategory" value="Electrical" onchange="toggleFields()">
                                                <label class="form-check-label" for="electricalCategory">Electrical</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div id="civilFields">
                                    <div class="form-group row">
                                        <div class="col-md-6">
                                            <label for="state" class="form-label mt-4">State</label>
                                            <select name="state" class="form-control" id="state" onchange="updateDistrictOptions()">
                                                <option value="" selected disabled>Select State</option>
                                                <?php
                                                // Fetch states from the tb_civil table and populate the dropdown
                                                while ($rowc = mysqli_fetch_assoc($resultc)) {
                                                    echo '<option value="' . $rowc['c_state'] . '">' . $rowc['c_state'] . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="district" class="form-label mt-4">District</label>
                                            <select name="district" class="form-control" id="district" onchange="updateGroupOptions()">
                                                <option value="" selected disabled>Select District</option>
                                                <?php
                                                // Fetch districts from the tb_civil table and populate the dropdown
                                                while ($rowci = mysqli_fetch_assoc($resultci)) {
                                                    echo '<option data-state="' . $rowci['c_state'] . '" value="' . $rowci['c_district'] . '">' . $rowci['c_district'] . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-md-6">
                                            <label for="groupDistance" class="form-label mt-4">Distance(KM)</label>
                                            <select name="groupDistance" class="form-control" id="groupDistance" onchange="updateRate()">
                                                <option value="" selected disabled>Select Distance</option>
                                                <?php
                                                while ($rowciv = mysqli_fetch_assoc($resultciv)) {
                                                    echo '<option data-state="' . $rowciv['c_state'] . '" data-district="' . $rowciv['c_district'] . '" value="' . $rowciv['c_group'] . '">' . $rowciv['c_group'] . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>

                                        <div class="col-md-6">
                                            <label for="rateCharged" class="form-label mt-4">Extra Rate by Area(%)</label>
                                            <select name="rateCharged" class="form-control" id="rateCharged"">
                                            <option value="" selected disabled>Select Rate</option>
                                                <?php
                                                while ($rowcivi = mysqli_fetch_assoc($resultcivi)) {
                                                    echo '<option data-state="' . $rowcivi['c_state'] . '" data-district="' . $rowcivi['c_district'] . '" data-group="' . $rowcivi['c_group'] . '" value="' . $rowcivi['c_rate'] . '">' . $rowcivi['c_rate'] . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div id="electricalFields" style="display:none;">
                                                <div class="form-group row">
                                                    <div class="col-md-6">
                                                        <label for="state" class="form-label mt-4">State</label>
                                                        <select name="state" class="form-control" id="state" onchange="updateDistrictOptions()">
                                                            <option value="" selected disabled>Select State</option>
                                                            <?php
                                                            // Fetch states from the tb_civil table and populate the dropdown
                                                            while ($rowe = mysqli_fetch_assoc($resulte)) {
                                                                echo '<option value="' . $rowe['e_state'] . '">' . $rowe['e_state'] . '</option>';
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="district" class="form-label mt-4">District</label>
                                                        <select name="district" class="form-control" id="district" onchange="updateGroupOptions()">
                                                            <option value="" selected disabled>Select District</option>
                                                            <?php
                                                            // Fetch districts from the tb_civil table and populate the dropdown
                                                            while ($rowel = mysqli_fetch_assoc($resultel)) {
                                                                echo '<option data-state="' . $rowel['e_state'] . '" value="' . $rowel['e_district'] . '">' . $rowel['e_district'] . '</option>';
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <div class="col-md-6">
                                                        <label for="groupDistance" class="form-label mt-4">Distance(KM)</label>
                                                        <select name="groupDistance" class="form-control" id="groupDistance" onchange="updateRate()">
                                                            <option value="" selected disabled>Select Distance</option>
                                                            <?php
                                                            while ($roweli = mysqli_fetch_assoc($resulteli)) {
                                                                echo '<option data-state="' . $roweli['e_state'] . '" data-district="' . $roweli['e_district'] . '" value="' . $roweli['e_group'] . '">' . $roweli['e_group'] . '</option>';
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <label for="rateCharged" class="form-label mt-4">Extra Rate by Area(%)</label>
                                                        <select name="rateCharged" class="form-control" id="rateCharged"">
                                            <option value="" selected disabled>Select Rate</option>
                                                <?php
                                                while ($rowele = mysqli_fetch_assoc($resultele)) {
                                                    echo '<option data-state="' . $rowele['e_state'] . '" data-district="' . $rowele['e_district'] . '" data-group="' . $rowele['e_group'] . '" value="' . $rowele['e_rate'] . '">' . $rowele['e_rate'] . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>   
                                </div>

                                        <script>
                                            var selectedState = ''; // Variable to store the selected state
                                            var selectedDistrict = ''; // Variable to store the selected district
                                            var selectedGroup = ''; // Variable to store the selected group

                                            function updateDistrictOptions() {
                                                var stateSelect = document.getElementById('state');
                                                selectedState = stateSelect.options[stateSelect.selectedIndex].value;

                                                var districtSelect = document.getElementById('district');
                                                var options = districtSelect.options;

                                                // Show only districts that match the selected state
                                                for (var i = 0; i < options.length; i++) {
                                                    options[i].style.display = (options[i].getAttribute('data-state') === selectedState) ? 'block' : 'none';
                                                }

                                                // Reset selected district and group options
                                                selectedDistrict = '';
                                                selectedGroup = '';
                                                updateGroupOptions();
                                            }

                                            function updateGroupOptions() {
                                                var districtSelect = document.getElementById('district');
                                                selectedDistrict = districtSelect.options[districtSelect.selectedIndex].value;

                                                var groupSelect = document.getElementById('groupDistance');
                                                var options = groupSelect.options;

                                                // Show only groups that match the selected state and district
                                                for (var i = 0; i < options.length; i++) {
                                                    var dataState = options[i].getAttribute('data-state');
                                                    var dataDistrict = options[i].getAttribute('data-district');
                                                    options[i].style.display = (dataState === selectedState && dataDistrict === selectedDistrict) ? 'block' : 'none';
                                                }

                                                selectedGroup = '';
                                                updateRate();
                                            }

                                            function updateRate() {
                                                var groupSelect = document.getElementById('groupDistance');
                                                selectedGroup = groupSelect.options[groupSelect.selectedIndex].value;

                                                var rateCharged = document.getElementById('rateCharged');
                                                var options = rateCharged.options;

                                                for (var i = 0; i < options.length; i++) {
                                                    var dataState = options[i].getAttribute('data-state');
                                                    var dataDistrict = options[i].getAttribute('data-district');
                                                    var dataGroup = options[i].getAttribute('data-group');
                                                    options[i].style.display = (dataState === selectedState && dataDistrict === selectedDistrict && dataGroup === selectedGroup) ? 'block' : 'none';
                                                }
                                            }

                                            // Initial update based on the default selected state
                                            updateDistrictOptions();
                                            updateGroupOptions();

                                            function toggleFields() {
                                                var civilRadio = document.getElementById('civilCategory');
                                                var electricalRadio = document.getElementById('electricalCategory');

                                                var civilFields = document.getElementById('civilFields');
                                                var electricalFields = document.getElementById('electricalFields');

                                                if (civilRadio.checked) {
                                                    civilFields.style.display = 'block';
                                                    electricalFields.style.display = 'none';
                                                    // Reset selected options and update fields if needed
                                                    selectedState = '';
                                                    selectedDistrict = '';
                                                    selectedGroup = '';
                                                    updateDistrictOptions();
                                                    updateGroupOptions();
                                                } else if (electricalRadio.checked) {
                                                    civilFields.style.display = 'none';
                                                    electricalFields.style.display = 'block';
                                                    // Reset selected options and update fields if needed
                                                    selectedState = '';
                                                    selectedDistrict = '';
                                                    selectedGroup = '';
                                                    // Add any additional logic or updates specific to electrical fields
                                                }
                                            }
                                        </script>
                                        <br><br>
                                        <div class=" d-flex justify-content-center">
                                                            <a class="btn btn-outline-primary" onclick="goToOrderInfo()"><i class="bi bi-arrow-right-square"></i> Next</a>
                                                            &nbsp;
                                                            <button type="reset" class="btn btn-outline-danger"><i class="bi bi-x-square"></i> Cancel</button>
                                                    </div>
                                                </div>

                                                <div class="tab-pane fade show active cust-info" id="cust-info">
                                                    <h5 class="card-title">Customer Details</h5>
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
                                                    <br><br>
                                                    <div class="d-flex justify-content-center">
                                                        <a class="btn btn-outline-primary" onclick="showQuotationInfoTab()"><i class="bi bi-arrow-right-square"></i> Next</a>
                                                        &nbsp;
                                                        <button type="reset" class="btn btn-outline-danger"><i class="bi bi-x-square"></i> Cancel</button>
                                                    </div>
                                                </div>

                                                <div class="tab-pane fade order-info" id="order-info">
                                                    <h5 class="card-title">Order List</h5>
                                                    <a href="staff-quote-jkr-add.php" class="btn btn-primary shadow" data-bs-toggle="modal" data-bs-target="#jkrModal">
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
                                                    <div class="justify-content-end mt-4">
                                                        <strong>Total: </strong>RM <span id="grandTotalDisplay" class="text-secondary"></span><br>
                                                        <strong>Extra Charge (Area): </strong>RM <span id="extraChargeDisplay" class="text-secondary"></span><br>
                                                        <div class="col-md-6 d-flex">
                                                            <strong>Extra Charge (Other): </strong>RM <span id="otherChargeDisplay" class="text-secondary"></span>
                                                            <input type="number" name="extraChargeOther" class="form-control ml-2" step="0.01" placeholder="Other charge" style="width: 140px; height:25px;" />
                                                        </div>
                                                        <strong>Grand Total: </strong>RM <span id="finalGrandTotalDisplay" class="text-primary"></span>
                                                        <input type="hidden" name="finalGrandTotalDisplay" id="finalGrandTotalInput" value="">
                                                    </div>
                                                    <br>
                                                    <div class="d-flex justify-content-center">
                                                        <button type="submit" name="save_info" class="btn btn-outline-primary"><i class="bi bi-arrow-up-square"></i> Save</button>
                                                        &nbsp;
                                                        <button type="reset" class="btn btn-outline-danger"><i class="bi bi-x-square"></i> Cancel</button>
                                                    </div>
                                                </div>
                                        </div>
                    </form>
                </div>
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
                        
                        var materialNameInput = document.createElement('input');
                        materialNameInput.type = 'hidden';
                        materialNameInput.name = 'material_name[]';
                        materialNameInput.value = materialName;
                        newRow.appendChild(materialNameInput);

                        var materialDescInput = document.createElement('input');
                        materialDescInput.type = 'hidden';
                        materialDescInput.name = 'material_desc[]';
                        materialDescInput.value = materialDesc;
                        newRow.appendChild(materialDescInput);

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
            var extraChargeOtherInput = document.querySelector('input[name="extraChargeOther"]');
    extraChargeOtherInput.addEventListener('input', function() {
        updateOtherChargeDisplay(); // Update otherChargeDisplay and finalGrandTotalDisplay
    });
        });

        function showQuotationInfoTab() {
            // Hide the current active tab
            document.querySelector('.nav-link.active').classList.remove('active');
            document.querySelector('.tab-pane.fade.show.active').classList.remove('show', 'active');

            // Show the Quotation Info tab
            document.querySelector('[data-bs-target="#quote-info"]').classList.add('active');
            document.querySelector('#quote-info').classList.add('show', 'active');
        }

        function goToOrderInfo() {
            // Hide the current active tab
            document.querySelector('.nav-link.active').classList.remove('active');
            document.querySelector('.tab-pane.fade.show.active').classList.remove('show', 'active');

            // Show the Order Info tab
            document.querySelector('[data-bs-target="#order-info"]').classList.add('active');
            document.querySelector('#order-info').classList.add('show', 'active');
        }

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
    subTotalInputs.forEach(function(input) {
        grandTotalValue += parseFloat(input.value) || 0;
    });
    // Update grand total display
    document.getElementById('grandTotalDisplay').textContent = grandTotalValue.toFixed(2);

    // Get the selected rateCharged value
    var rateChargedSelect = document.getElementById('rateCharged');
    var rateCharged = rateChargedSelect.value || 0;

    // Get the value of Extra Charge (Other)
    var extraChargeOther = parseFloat(document.getElementsByName('extraChargeOther')[0].value) || 0;

    // Call the functions to calculate charge total and final grand total
    calculateChargeTotal(grandTotalValue, rateCharged);
    calculateFinalGrandTotal(grandTotalValue, rateCharged, extraChargeOther);
}

function calculateChargeTotal(grandTotalValue, rateCharged) {
    // Calculate extra charge
    var extraChargeValue = (1 + (rateCharged / 100)) * grandTotalValue;

    // Update extra charge display
    document.getElementById('extraChargeDisplay').textContent = extraChargeValue.toFixed(2);
}

function updateOtherChargeDisplay() {
    // Get the value of Extra Charge (Other)
    var extraChargeOtherValue = parseFloat(document.getElementsByName('extraChargeOther')[0].value) || 0;

    // Update the display for Extra Charge (Other)
    document.getElementById('otherChargeDisplay').textContent = extraChargeOtherValue.toFixed(2);

    calculateGrandTotal();
}

function calculateFinalGrandTotal(grandTotalValue, rateCharged, extraChargeOther) {
    // Get extra charge value
    var extraChargeValue = parseFloat(document.getElementById('extraChargeDisplay').textContent) || 0;

    // Ensure extraChargeOther is a valid number or set it to 0
    extraChargeOther = parseFloat(extraChargeOther) || 0;

    // Calculate final grand total including Extra Charge (Other)
    var finalGrandTotalValue = grandTotalValue + extraChargeValue + extraChargeOther;

    // Update final grand total display
    document.getElementById('finalGrandTotalDisplay').textContent = finalGrandTotalValue.toFixed(2);

    // Update the hidden input field value
    document.getElementById('finalGrandTotalInput').value = finalGrandTotalValue.toFixed(2);
}
    </script>

    <?php mysqli_close($con); ?>
</main><!-- End #main -->

<?php include 'footer.php'; ?>