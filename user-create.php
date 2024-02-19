<?php
include('mysession.php');

if (!session_id()) {
    session_start();
}
// Display result
include('headeradmin.php');

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

} else {
    die("Prepare statement failed: " . mysqli_error($con));
}
?>

<main id="main" class="main">

    <div class="pagetitle">
        <h1>User Management</h1>
        <div class="d-flex justify-content-between align-items-center">
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="adminmain.php">Home</a></li>
                    <li class="breadcrumb-item"><a href="user.php">User Management</a></li>
                    <li class="breadcrumb-item active">Add User</li>
                </ol>
            </nav>

            <div class="btn-group me-2">
                <a href="user.php" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Back</a>
            </div>
        </div>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Add User</h5>

                        <?= alertMessage(); ?>

                        <form method="POST" action="user-createprocess.php">
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label for="fid" class="form-label mt-4">User ID</label>
                                    <input type="text" name="fid" class="form-control" id="fid" placeholder="Enter company staff/admin ID" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="fic" class="form-label mt-4">Identity Card No.</label>
                                    <input type="text" name="fic" class="form-control" id="fic" placeholder="Enter identity card number" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label for="ffname" class="form-label mt-4">First Name</label>
                                    <input type="text" name="ffname" class="form-control" id="ffname" placeholder="Enter first name" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="flname" class="form-label mt-4">Last Name</label>
                                    <input type="text" name="flname" class="form-control" id="flname" placeholder="Enter last name" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label for="fpwd" class="form-label mt-4">Password</label>
                                    <div class="input-group">
                                        <input type="password" name="fpwd" class="form-control" id="fpwd" placeholder="Enter password" autocomplete="off" required>
                                        <button type="button" class="btn btn-outline-secondary toggle-password" data-target="fpwd">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </div>
                                    <small id="emailHelp" class="form-text text-muted">Password must has at least 12 characters with combination of uppercase, lowercase, number, and symbol.</small>
                                </div>

                                <script>
                                    document.querySelector('.toggle-password').addEventListener('click', function() {
                                        const targetId = this.getAttribute('data-target');
                                        const passwordInput = document.getElementById(targetId);

                                        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                                        passwordInput.setAttribute('type', type);

                                        // Toggle eye icon
                                        const eyeIcon = this.querySelector('i');
                                        eyeIcon.classList.toggle('bi-eye');
                                        eyeIcon.classList.toggle('bi-eye-slash');
                                    });
                                </script>

                                <div class="col-md-6">
                                    <label for="fphone" class="form-label mt-4">Phone No.</label>
                                    <input type="text" name="fphone" class="form-control" id="fphone" placeholder="Enter phone number" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label for="exampleInputEmail1" class="form-label mt-4">Email address</label>
                                    <input type="email" name="femail" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email address" required>
                                </div>

                                <div class="col-md-6">
                                    <label for="ftype" class="form-label mt-4">User Type</label>
                                    <select name="ftype" class="form-control" id="ftype" required>
                                        <?php
                                        while ($rowType = mysqli_fetch_array($resultUserTypes)) {
                                            echo "<option value='" . $rowType['type_id'] . "'>" . $rowType['type_desc'] . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
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