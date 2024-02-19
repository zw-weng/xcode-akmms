<?php
include('mysession.php');
if (!session_id()) {
  session_start();
}
include('headerstaff.php');
// Include database connection
include('dbconnect.php');

if (isset($_SESSION['suid'])) {
  $userId = $_SESSION['suid'];

  // Fetch user details from the database
  $query = "SELECT u.u_fName, u.u_lName, u.user_ic, u.user_email, u.user_phone, t.type_desc
          FROM tb_user u
          JOIN tb_usertype t ON u.type_id = t.type_id
          WHERE u.user_id = ?";

  $stmt = mysqli_prepare($con, $query);

  if ($stmt) {
    mysqli_stmt_bind_param($stmt, "s", $userId);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $firstName, $lastName, $ic, $email, $phone, $userType);

    // Fetch the first (and only) row
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);
  }
}

?>

<main id="main" class="main">

  <div class="pagetitle">
    <h1>Profile</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="staffmain.php">Home</a></li>
        <li class="breadcrumb-item">Setting</li>
        <li class="breadcrumb-item active">Profile</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

  <section class="section profile">
    <div class="row">
      <?= alertMessage(); ?>
      <div class="card">
        <div class="card-body pt-3">
          <!-- Bordered Tabs -->
          <ul class="nav nav-tabs nav-tabs-bordered">

            <li class="nav-item">
              <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Overview</button>
            </li>

            <li class="nav-item">
              <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Edit Profile</button>
            </li>

            <li class="nav-item">
              <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-change-password">Change Password</button>
            </li>

          </ul>
          <div class="tab-content pt-2">

            <div class="tab-pane fade show active profile-overview" id="profile-overview">

              <h5 class="card-title">Profile Details</h5>

              <div class="row">
                <div class="col-lg-3 col-md-4 label ">Full Name</div>
                <div class="col-lg-9 col-md-8"><?= $firstName . ' ' . $lastName ?></div>
              </div>

              <div class="row">
                <div class="col-lg-3 col-md-4 label">Identity Card No.</div>
                <div class="col-lg-9 col-md-8"><?= $ic ?></div>
              </div>

              <div class="row">
                <div class="col-lg-3 col-md-4 label">Phone No.</div>
                <div class="col-lg-9 col-md-8"><?= $phone ?></div>
              </div>

              <div class="row">
                <div class="col-lg-3 col-md-4 label">Email</div>
                <div class="col-lg-9 col-md-8"><?= $email ?></div>
              </div>

              <div class="row">
                <div class="col-lg-3 col-md-4 label">Account Type</div>
                <div class="col-lg-9 col-md-8"><?= $userType ?></div>
              </div>

            </div>

            <div class="tab-pane fade profile-edit pt-3" id="profile-edit">

              <!-- Profile Edit Form -->
              <form method="POST" action="staff-user-profileprocess.php">
                <div class="row mb-3">
                  <label for="fName" class="col-md-4 col-lg-3 col-form-label">First Name</label>
                  <div class="col-md-8 col-lg-9">
                    <input name="fName" type="text" class="form-control" id="fName" value="<?= $firstName ?>">
                  </div>
                </div>

                <div class="row mb-3">
                  <label for="lName" class="col-md-4 col-lg-3 col-form-label">Last Name</label>
                  <div class="col-md-8 col-lg-9">
                    <input name="lName" type="text" class="form-control" id="lName" value="<?= $lastName ?>">
                  </div>
                </div>

                <div class="row mb-3">
                  <label for="fic" class="col-md-4 col-lg-3 col-form-label">Identity Card No.</label>
                  <div class="col-md-8 col-lg-9">
                    <input name="fic" type="text" class="form-control" id="fic" value="<?= $ic ?>">
                  </div>
                </div>

                <div class="row mb-3">
                  <label for="Phone" class="col-md-4 col-lg-3 col-form-label">Phone No.</label>
                  <div class="col-md-8 col-lg-9">
                    <input name="phone" type="text" class="form-control" id="Phone" value="<?= $phone ?>">
                  </div>
                </div>

                <div class="row mb-3">
                  <label for="Email" class="col-md-4 col-lg-3 col-form-label">Email</label>
                  <div class="col-md-8 col-lg-9">
                    <input name="email" type="email" class="form-control" id="Email" value="<?= $email ?>">
                  </div>
                </div>

                <div class="d-flex justify-content-center">
                  <button type="submit" name="saveprofile" class="btn btn-outline-primary"><i class="bi bi-arrow-up-square"></i> Save</button>
                  &nbsp;
                  <button type="reset" class="btn btn-outline-danger"><i class="bi bi-x-square"></i> Cancel</button>
                </div>
              </form><!-- End Profile Edit Form -->
            </div>

            <div class="tab-pane fade pt-3" id="profile-change-password">
              <!-- Change Password Form -->
              <form method="POST" action="staff-user-profileprocess.php">

                <div class="row mb-3">
                  <label for="newPassword" class="col-md-4 col-lg-3 col-form-label">New Password</label>
                  <div class="col-md-8 col-lg-6">
                    <div class="input-group">
                      <input name="newpassword" type="password" class="form-control" id="newPassword" placeholder="Enter new password" autocomplete="off" required>
                      <button type="button" class="btn btn-outline-secondary toggle-password" data-target="newPassword">
                        <i class="bi bi-eye"></i>
                      </button>
                    </div>
                    <small id="emailHelp" class="form-text text-muted">Password must have at least 12 characters with a combination of uppercase, lowercase, number, and symbol.</small>
                  </div>
                </div>

                <div class="row mb-3">
                  <label for="renewPassword" class="col-md-4 col-lg-3 col-form-label">Confirm Password</label>
                  <div class="col-md-8 col-lg-6">
                    <div class="input-group">
                      <input name="renewpassword" type="password" class="form-control" id="renewPassword" placeholder="Re-enter new password" autocomplete="off" required>
                      <button type="button" class="btn btn-outline-secondary toggle-password" data-target="renewPassword">
                        <i class="bi bi-eye"></i>
                      </button>
                    </div>
                  </div>
                </div>

                <script>
                  document.querySelectorAll('.toggle-password').forEach(function(toggleBtn) {
                    toggleBtn.addEventListener('click', function() {
                      const targetId = this.getAttribute('data-target');
                      const passwordInput = document.getElementById(targetId);

                      const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                      passwordInput.setAttribute('type', type);

                      // Toggle eye icon
                      const eyeIcon = this.querySelector('i');
                      eyeIcon.classList.toggle('bi-eye');
                      eyeIcon.classList.toggle('bi-eye-slash');
                    });
                  });
                </script>

                <div class="d-flex justify-content-center">
                  <button type="submit" name="savepwd" class="btn btn-outline-primary"><i class="bi bi-arrow-up-square"></i> Save</button>
                  &nbsp;
                  <button type="reset" class="btn btn-outline-danger"><i class="bi bi-x-square"></i> Cancel</button>
                </div>
              </form><!-- End Change Password Form -->

            </div>

          </div><!-- End Bordered Tabs -->

        </div>
      </div>

    </div>
  </section>

</main><!-- End #main -->

<?php include('footer.php'); ?>