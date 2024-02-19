<?php
include('mysession.php');
  if(!session_id())
  {
    session_start();
  }
include('headeradmin.php');
include('dbconnect.php');


?>


<main id="main" class="main">
<div class="pagetitle">
      <h1>Transaction Report</h1>
      <div class="d-flex justify-content-between align-items-center">
      <nav>
          <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="adminmain.php">Home</a></li>
              <li class="breadcrumb-item active">Transaction Report</li>
          </ol>
      </nav>

      <div class="btn-group me-2">
          <a href="adminmain.php" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Back</a>
          
      </div>
      </div>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
        <div class="col-lg-12">
  
    <div class="card">
        <div class="card-body">
    <h5 class="card-title">Date Selection</h5>
    
        <form method="GET" action="transactionpdf.php">
            <label for="start_date">Start Date:</label>
            <input type="datetime-local" id="start_date" name="start_date" required>

            <label for="end_date">End Date:</label>
            <input type="datetime-local" id="end_date" name="end_date" required>

            

            <button type="submit">Generate Report</button>
        </form>
    
</div>
</div>
</div>
</div>
</section>
</main>

<?php include('footer.php'); ?>