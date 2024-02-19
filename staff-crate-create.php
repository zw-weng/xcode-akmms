<?php
include('mysession.php');

if (!session_id()) {
    session_start();
}
// Display result
include('headerstaff.php');

// Include database connection
include('dbconnect.php');

?>

<main id="main" class="main">

    <div class="pagetitle">
        <h1>JKR Material</h1>
        <div class="d-flex justify-content-between align-items-center">
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="staffmain.php">Home</a></li>
                    <li class="breadcrumb-item"><a href="#">Inventory</a></li>
                    <li class="breadcrumb-item"><a href="staff-jkr.php">JKR List</a></li>
                    <li class="breadcrumb-item"><a href="#">Civil</a></li>
                    <li class="breadcrumb-item active">Add Rate Charged</li>
                </ol>
            </nav>

            <div class="btn-group me-2">
                <a href="staff-jkr.php" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Back</a>
            </div>
        </div>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <?= alertMessage(); ?>
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Add Price Rate</h5>

                        <form method="POST" action="staff-crate-createprocess.php">
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label for="state" class="form-label mt-4">State</label>
                                    <select name="state" class="form-select" id="state" required onchange="populateDistricts()">
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
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="district" class="form-label mt-4">District</label>
                                    <select name="district" class="form-select" id="district" required>
                                        <option value="" selected disabled>Select District</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label for="group_range" class="form-label mt-4">Group Distance (KM)</label>
                                    <input type="text" name="group_range" class="form-control" id="group_range" placeholder="Enter range of distance in KM" required>
                                    <small class="text-muted">Eg. kurang dari 16km</small>
                                </div>
                                <div class="col-md-6">
                                    <label for="crate" class="form-label mt-4">Rate (%)</label>
                                    <input type="number" name="crate" class="form-control" id="crate" placeholder="Enter rate to be charged with up to 2 decimal places" step="0.01" required>
                                    <small class="text-muted">Eg. 4%</small>
                                </div>
                            </div>

                            <br><br>
                            <div class="d-flex justify-content-end">
                                <button type="submit" name="save_c" class="btn btn-outline-primary"><i class="bi bi-arrow-up-square"></i> Save</button>
                                &nbsp;
                                <button type="reset" class="btn btn-outline-danger" data-bs-dismiss="modal"><i class="bi bi-x-square"></i> Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        function populateDistricts() {
            var stateSelect = document.getElementById('state');
            var districtSelect = document.getElementById('district');

            // Clear existing options
            districtSelect.innerHTML = '<option value="" selected disabled>Select District</option>';

            // Define district options based on the selected state
            var districts = {
                'Johor': ['Johor Bahru', 'Muar', 'Kluang', 'Pontian', 'Batu Pahat', 'Segamat', 'Tangkak', 'Mersing', 'Kulai', 'Kota Tinggi', 'Pulau Sibu', 'Pulau Tinggi', 'Pulau Alur', 'Pulau Pemanggil'],
                'Kedah': ['Kota Setar', 'Sungai Petani', 'Kulim', 'Padang Terap', 'Langkawi', 'Yan', 'Sik', 'Baling', 'Bandar Baharu', 'Pendang', 'Kuala Muda', 'Pokok Sena', 'Kubang Pasu'],
                'Kelantan': ['Kota Bharu', 'Pasir Puteh', 'Kuala Krai', 'Pasir Mas', 'Tanah Merah', 'Tumpat', 'Bachok', 'Machang', 'Jeli', 'Gua Musang'],
                'Melaka': ['Bandar Melaka', 'Jasin', 'Alor Gajah', 'Masjid Tanah', 'Melaka Tengah'],
                'Negeri Sembilan': ['Seremban', 'Port Dickson', 'Tampin', 'Jempol', 'Kuala Pilah', 'Rembau', 'Jelebu'],
                'Selangor': ['Sabak Bernam', 'Kuala Selangor', 'Klang', 'Petaling', 'Hulu Selangor', 'Gombak', 'Hulu Langat', 'Kuala Langat', 'Sepang', 'Pulau Ketam'],
                'Pahang': ['Kuantan', 'Temerloh', 'Jerantut', 'Bentong', 'Raub', 'Bera', 'Maran', 'Cameron Highlands', 'Kuala Lipis', 'Pekan', 'Rompin', 'Ulu Tembeling', 'Pulau Tioman'],
                'Terengganu': ['Kuala Terengganu', 'Besut', 'Dungun', 'Kemaman', 'Marang', 'Hulu Terrenganu', 'Setiu', 'Pulau-pulau'],
                'Perlis': ['Kangar', 'Arau', 'Padang Besar'],
                'Penang': ['Pulau Pinang', 'Butterworth', 'Bukit Mertajam', 'Nibong Tebal', 'Kepala Batas', 'Bukit Bendera', 'Georgetown'],
                'Perak': ['Ipoh', 'Taiping', 'Kuala Kangsar', 'Manjung', 'Lumut', 'Kinta', 'Larut & Matang', 'Kerian', 'Batang Padang', 'Hilir Perak', 'Perak Tengah', 'Hulu Perak', 'Pos Orang Asli', 'Pulau-pulau(Pulau Pangkor)'],
                'Sabah': ['Kota Kinabalu', 'Sandakan', 'Tawau', 'Lahad Datu', 'Keningau'],
                'Sarawak': ['Kuching', 'Miri', 'Sibu', 'Bintulu', 'Limbang'],
                'Kuala Lumpur': ['Titiwangsa', 'Bukit Bintang', 'Cheras', 'Kepong', 'Bandar Tun Razak', 'Seputeh', 'Lembah Pantai', 'Segambut', 'Setiawangsa', 'Batu', 'Wangsa Maju'],
                'Putrajaya': ['Presint 1', 'Presint 2', 'Presint 3', 'Presint 4', 'Presint 5'],
                'Labuan': ['Labuan City', 'Victoria', 'Durian Tunjung', 'Rancha-Rancha']
            };

            // Populate the district options based on the selected state
            var selectedState = stateSelect.value;
            if (selectedState in districts) {
                districts[selectedState].forEach(function(district) {
                    var option = document.createElement('option');
                    option.value = district;
                    option.text = district;
                    districtSelect.add(option);
                });
            }
        }
    </script>

    <?php mysqli_close($con); ?>
</main><!-- End #main -->

<?php include 'footer.php'; ?>