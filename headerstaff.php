<?php
include('mysession.php');
if (!session_id()) {
  session_start();
}

// Include files
include('dbconnect.php');
include('function.php');

$suid = $_SESSION['suid'];
$userName = getUserName($con, $suid);
$userType = getUserType($con, $suid);

// Check if $_SESSION['alert'] is set
if (isset($_SESSION['alert'])) {
    $alert = $_SESSION['alert'];
    $alertCount = getAlertCount($con, $alert);
} else {
    // Retrieve the alert from the database if not set
    $sqlr = "SELECT min_value FROM tb_alert";
    $resultr = mysqli_query($con, $sqlr);

    if ($resultr) {
        $row = mysqli_fetch_assoc($resultr);
        $alert = $row['min_value'];

        // Store the value in a session variable
        $_SESSION['alert'] = $alert;
        $alertCount = getAlertCount($con, $alert);
    } else {
        // Handle the error or set a default value
        echo "Error: " . mysqli_error($con);
        $_SESSION['alert'] = 0; // Set a default value
        $alertCount = 0;
    }
}

// Close DB Connection
mysqli_close($con);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>AK Maju Resources</title>
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
  <style>
    body {
      background-color: #f6f6f6;
      /* A bit gray-light background color */
      color: #444444;
      /* Dark text color */
    }

    /* You can keep the existing styles for the header without modification */
  </style>
</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
      <a href="staffmain.php" class="logo d-flex align-items-center w-auto">
        <img src="assets/img/akmaju.png" alt="AK Maju logo" style="max-width: 140px; max-height: 40px;">
        <span class="d-none d-lg-block">AK Maju Resources</span>
      </a>
      <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->

    <div class="search-bar">
      <form class="search-form d-flex align-items-center" method="POST" action="#">
        <input type="text" name="query" placeholder="Search" title="Enter search keyword">
        <button type="submit" title="Search"><i class="bi bi-search"></i></button>
      </form>
    </div><!-- End Search Bar -->

    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">

        <li class="nav-item d-block d-lg-none">
          <a class="nav-link nav-icon search-bar-toggle " href="#">
            <i class="bi bi-search"></i>
          </a>
        </li><!-- End Search Icon-->

        <li>

          <a class="nav-link nav-icon" href="staff-alert.php">
            <i class="bi bi-bell"></i>
            <?php if ($alertCount > 0) : ?>
              <span class="badge bg-danger badge-number"><?= $alertCount; ?></span>
            <?php endif; ?>
          </a><!-- End Notification Icon -->

        </li><!-- End Notification Nav -->

        <li class="nav-item dropdown pe-3">
          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
          <img src="assets/img/staff.png" alt="Profile" class="rounded-circle">
            <span class="d-none d-md-block dropdown-toggle ps-2">Hi, <?= $userName; ?></span>
          </a><!-- End Profile Iamge Icon -->

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
          <li class="dropdown-header">
              <h6><?= $userType; ?></h6>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>  
          <li>
              <a class="dropdown-item d-flex align-items-center" href="staff-user-profile.php">
                <i class="bi bi-person"></i>
                <span>My Profile</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="logout.php">
                <i class="bi bi-box-arrow-right"></i>
                <span>Sign Out</span>
              </a>
            </li>

          </ul><!-- End Profile Dropdown Items -->
        </li><!-- End Profile Nav -->

      </ul>
    </nav><!-- End Icons Navigation -->

  </header><!-- End Header -->

  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

      <li class="nav-item">
        <a class="nav-link" href="staffmain.php">
          <i class="bi bi-grid"></i>
          <span>Dashboard</span>
        </a>
      </li><!-- End Dashboard Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="staff-quote.php">
          <i class="bi bi-chat-quote-fill"></i>
          <span>Quotation</span>
        </a>
      </li><!-- End Quotation Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="staff-order.php">
          <i class="bi bi-cart"></i>
          <span>Sales Order</span>
        </a>
      </li><!-- End Sales Order Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="staff-payment.php">
          <i class="bi bi-credit-card"></i>
          <span>Payment</span>
        </a>
      </li><!-- End Payment Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="staff-deliveryorderlist.php">
          <i class="bi bi-truck"></i>
          <span>Delivery Order</span>
        </a>
      </li><!-- End Delivery Order Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="staff-invoicelist.php">
          <i class="bi bi-file-text"></i>
          <span>Invoice</span>
        </a>
      </li><!-- End Invoice Nav -->


      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#inventory-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-box"></i><span>Inventory</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="inventory-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="staff-stock.php">
              <i class="bi bi-circle"></i><span>Stock</span>
            </a>
          </li>
          <li>
            <a href="staff-jkr.php">
              <i class="bi bi-circle"></i><span>JKR Material</span>
            </a>
          </li>
        </ul>
      </li><!-- End Inventory Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="staff-customer1.php">
          <i class="bi bi-person-badge"></i>
          <span>Customers Info</span>
        </a>
      </li><!-- End Customers Info Page Nav -->


      <li class="nav-heading">SETTING</li>

      <li class="nav-item">
        <a class="nav-link collapsed" href="staff-user-profile.php">
          <i class="bi bi-person"></i>
          <span>Profile</span>
        </a>
      </li><!-- End Profile Page Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="logout.php">
          <i class="bi bi-box-arrow-in-right"></i>
          <span>Logout</span>
        </a>
      </li><!-- End Logout Page Nav -->

    </ul>

  </aside><!-- End Sidebar-->