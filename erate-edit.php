<?php
include('mysession.php');
if (!session_id()) {
    session_start();
}
include('headeradmin.php');
include('dbconnect.php');

// Fetch data from URL
if (isset($_GET['id'])) {
    $erateId = $_GET['id'];

    // Validate and sanitize the ID to prevent SQL injection
    $erateId = mysqli_real_escape_string($con, $erateId);
    $erateId = htmlspecialchars($erateId); // Additional input sanitization

    // Retrieve current data using prepared statement
    $sql = "SELECT * FROM tb_electric WHERE e_id = ?";
    $stmt = mysqli_prepare($con, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "s", $erateId);
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
} else {
    // Redirect if ID is not provided
    header('Location: pages-error-404.php');
    exit();
}
?>

<main id="main" class="main">

    <div class="pagetitle">
        <h1>Edit Rate</h1>
        <div class="d-flex justify-content-between align-items-center">
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="adminmain.php">Home</a></li>
                    <li class="breadcrumb-item"><a href="#">Inventory</a></li>
                    <li class="breadcrumb-item"><a href="jkr.php">JKR List</a></li>
                    <li class="breadcrumb-item"><a href="#">Electric</a></li>
                    <li class="breadcrumb-item active">Edit Rate Charged</li>
                </ol>
            </nav>

            <div class="btn-group me-2">
                <a href="jkr.php" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Back</a>
            </div>
        </div>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <?= alertMessage(); ?>
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Edit Rate</h5>

                        <form method="POST" action="erate-editprocess.php?id=<?= $row['e_id'] ?>" enctype="multipart/form-data">
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label for="state" class="form-label mt-4">State</label>
                                    <select name="state" class="form-control" id="state" required>
                                        <option value="" selected disabled>Select State</option>
                                        <?php
                                        $states = ['Johor', 'Kedah', 'Kelantan', 'Melaka', 'Selangor', 'Negeri Sembilan', 'Pahang', 'Terengganu', 'Perlis', 'Penang', 'Perak', 'Sabah', 'Sarawak', 'Kuala Lumpur', 'Putrajaya', 'Labuan'];

                                        // Loop through states to generate options
                                        foreach ($states as $state) {
                                            $selected = ($state == $row['e_state']) ? 'selected' : '';
                                            echo "<option value='" . $state . "' $selected>" . $state . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="district" class="form-label mt-4">District</label>
                                    <select name="district" class="form-control" id="district" required>
                                        <option value="" selected disabled>Select District</option>
                                        <?php
                                        $districts = [
                                            'Johor' => ['Johor Bahru', 'Muar', 'Kluang', 'Pontian', 'Batu Pahat', 'Segamat', 'Tangkak', 'Mersing', 'Kulai', 'Kota Tinggi', 'Pulau Sibu', 'Pulau Tinggi', 'Pulau Alur', 'Pulau Pemanggil'],
                                            'Kedah' => ['Kota Setar', 'Sungai Petani', 'Kulim', 'Padang Terap', 'Langkawi', 'Yan', 'Sik', 'Baling', 'Bandar Baharu', 'Pendang', 'Kuala Muda', 'Pokok Sena', 'Kubang Pasu'],
                                            'Kelantan' => ['Kota Bharu', 'Pasir Puteh', 'Kuala Krai', 'Pasir Mas', 'Tanah Merah', 'Tumpat', 'Bachok', 'Machang', 'Jeli', 'Gua Musang'],
                                            'Melaka' => ['Bandar Melaka', 'Jasin', 'Alor Gajah', 'Masjid Tanah', 'Melaka Tengah'],
                                            'Negeri Sembilan' => ['Seremban', 'Port Dickson', 'Tampin', 'Jempol', 'Kuala Pilah', 'Rembau', 'Jelebu'],
                                            'Selangor' => ['Sabak Bernam', 'Kuala Selangor', 'Klang', 'Petaling', 'Hulu Selangor', 'Gombak', 'Hulu Langat', 'Kuala Langat', 'Sepang', 'Pulau Ketam'],
                                            'Pahang' => ['Kuantan', 'Temerloh', 'Jerantut', 'Bentong', 'Raub', 'Bera', 'Maran', 'Cameron Highlands', 'Kuala Lipis', 'Pekan', 'Rompin', 'Ulu Tembeling', 'Pulau Tioman'],
                                            'Terengganu' => ['Kuala Terengganu', 'Besut', 'Dungun', 'Kemaman', 'Marang', 'Hulu Terrenganu', 'Setiu', 'Pulau-pulau'],
                                            'Perlis' => ['Kangar', 'Arau', 'Padang Besar'],
                                            'Penang' => ['Pulau Pinang', 'Butterworth', 'Bukit Mertajam', 'Nibong Tebal', 'Kepala Batas', 'Bukit Bendera', 'Georgetown'],
                                            'Perak' => ['Ipoh', 'Taiping', 'Kuala Kangsar', 'Manjung', 'Lumut', 'Kinta', 'Larut & Matang', 'Kerian', 'Batang Padang', 'Hilir Perak', 'Perak Tengah', 'Hulu Perak', 'Pos Orang Asli', 'Pulau-pulau(Pulau Pangkor)'],
                                            'Sabah' => ['Kota Kinabalu', 'Sandakan', 'Tawau', 'Lahad Datu', 'Keningau'],
                                            'Sarawak' => ['Kuching', 'Miri', 'Sibu', 'Bintulu', 'Limbang'],
                                            'Kuala Lumpur' => ['Titiwangsa', 'Bukit Bintang', 'Cheras', 'Kepong', 'Bandar Tun Razak', 'Seputeh', 'Lembah Pantai', 'Segambut', 'Setiawangsa', 'Batu', 'Wangsa Maju'],
                                            'Putrajaya' => ['Presint 1', 'Presint 2', 'Presint 3', 'Presint 4', 'Presint 5'],
                                            'Labuan' => ['Labuan City', 'Victoria', 'Durian Tunjung', 'Rancha-Rancha']
                                        ];

                                        // Get districts based on the selected state
                                        $selectedState = $row['e_state'];
                                        $selectedDistrict = $row['e_district'];

                                        // Loop through districts to generate options
                                        if (isset($districts[$selectedState])) {
                                            foreach ($districts[$selectedState] as $district) {
                                                $selected = ($district == $selectedDistrict) ? 'selected' : '';
                                                echo "<option value='" . $district . "' $selected>" . $district . "</option>";
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label for="group_range" class="form-label mt-4">Group Distance (KM)</label>
                                    <input type="text" name="group_range" class="form-control" id="group_range" value="<?= $row['e_group'] ?>" required>
                                    <small class="text-muted">Eg. kurang dari 16km</small>
                                </div>
                                <div class="col-md-6">
                                    <label for="erate" class="form-label mt-4">Rate (%)</label>
                                    <input type="number" name="erate" class="form-control" id="erate" value="<?= $row['e_rate'] ?>" step="0.01" required>
                                    <small class="text-muted">Eg. 4%</small>
                                </div>
                            </div>

                            <!-- Add more fields as needed -->

                            <br><br>
                            <div class="d-flex justify-content-end">
                            <button type="submit" name="update_e" class="btn btn-outline-primary"><i class="bi bi-arrow-up-square"></i> Save</button>
                                &nbsp;
                                <button type="reset" class="btn btn-outline-danger" data-bs-dismiss="modal"><i class="bi bi-x-square"></i> Cancel</button>
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