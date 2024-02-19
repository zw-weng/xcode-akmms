<?php
session_start();
if (!session_id()) {
  session_start();
}
include('function.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Reset Password - AKMMS</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link rel="icon" href="assets/img/akmaju.png" sizes="16x16" type="image/png">
  <link rel="icon" href="assets/img/akmaju.png" sizes="32x32" type="image/png">
  <link rel="icon" href="assets/img/akmaju.png" sizes="48x48" type="image/png">
  <link rel="icon" href="assets/img/akmaju.png" sizes="64x64" type="image/png">
  <link rel="apple-touch-icon" href="assets/img/akmaju.png" sizes="180x180">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">

  <!-- =======================================================
  * Template Name: NiceAdmin
  * Updated: Nov 17 2023 with Bootstrap v5.3.2
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>
  <style>
    .body {
      background-image: url('https://wallpapers.com/images/hd/website-background-sdki780prxb1nfs5.jpg');
      background-repeat: no-repeat;
      background-attachment: fixed;
      background-size: cover;
    }

    .container::before {
      content: "";
      background-image: url('https://wallpapers.com/images/hd/website-background-sdki780prxb1nfs5.jpg');
      background-repeat: no-repeat;
      background-attachment: fixed;
      background-size: cover;
      position: fixed;
      top: 0;
      right: 0;
      bottom: 0;
      left: 0;
      opacity: 0.1;
      /* Adjust the opacity as needed */
      z-index: -1;
    }
  </style>

  <main>
    <div class="container">

      <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

              <div class="d-flex justify-content-center py-4">
                <a href="index.php" class="logo d-flex align-items-center w-auto">
                  <img src="assets/img/akmaju.png" alt="AK Maju logo" style="max-width: 150px; max-height: 50px;">
                  <span class="d-none d-lg-block">AK Maju Resources</span>
                </a>
              </div><!-- End Logo -->

              <div class="card mb-3">

                <div class="card-body">

                  <div class="pt-4 pb-2">
                    <h5 class="card-title text-center pb-0 fs-4">Reset Password</h5>
                    <p class="text-center small">Enter your user ID & new password</p>
                  </div>

                  <?= alertMessage(); ?>

                  <form class="row g-3 needs-validation" method="POST" action="password-resetprocess.php">

                    <input type="hidden" name="password_token" value="<?php if (isset($_GET['token'])) {
                                                                        echo $_GET['token'];
                                                                      } ?>">

                    <div class="col-12">
                      <label for="yourUsername" class="form-label">Email</label>
                      <div class="input-group has-validation">
                        <input type="email" name="email" value="<?php if (isset($_GET['email'])) {
                                                                  echo $_GET['email'];
                                                                } ?>" class="form-control" id="yourEmail" placeholder="example@gmail.com" required disabled>
                        <input type="hidden" name="email" value="<?php if (isset($_GET['email'])) {
                                                                    echo $_GET['email'];
                                                                  } ?>" class="form-control" id="yourEmail" placeholder="example@gmail.com" required>
                      </div>
                    </div>

                    <div class="col-12">
                      <label for="newPassword" class="form-label">New Password</label>
                      <div class="input-group">
                        <input type="password" name="newpwd" class="form-control" id="newPassword" placeholder="Password" required>
                        <button type="button" class="btn btn-outline-secondary toggle-password" data-target="newPassword">
                          <i class="bi bi-eye"></i>
                        </button>
                      </div>
                      <div class="invalid-feedback">Please enter a new password.</div>
                      <small id="emailHelp" class="form-text text-muted">Password must has at least 12 characters with combination of uppercase, lowercase, number, and symbol.</small>
                    </div>

                    <div class="col-12">
                      <label for="confirmPassword" class="form-label">Confirm Password</label>
                      <div class="input-group">
                        <input type="password" name="confirmpwd" class="form-control" id="confirmPassword" placeholder="Password" required>
                        <button type="button" class="btn btn-outline-secondary toggle-password" data-target="confirmPassword">
                          <i class="bi bi-eye"></i>
                        </button>
                      </div>
                      <div class="invalid-feedback">Please confirm your password.</div>
                    </div>

                    <script>
                      document.querySelectorAll('.toggle-password').forEach(function(button) {
                        button.addEventListener('click', function() {
                          const targetId = button.getAttribute('data-target');
                          const passwordInput = document.getElementById(targetId);

                          const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                          passwordInput.setAttribute('type', type);

                          // Toggle eye icon
                          const eyeIcon = button.querySelector('i');
                          eyeIcon.classList.toggle('bi-eye');
                          eyeIcon.classList.toggle('bi-eye-slash');
                        });
                      });
                    </script>

                    <div class="col-12">
                      <button class="btn btn-primary w-100" name="resetBtn" type="submit">Save</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>

      </section>

    </div>
  </main><!-- End #main -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/chart.js/chart.umd.js"></script>
  <script src="assets/vendor/echarts/echarts.min.js"></script>
  <script src="assets/vendor/quill/quill.min.js"></script>
  <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>