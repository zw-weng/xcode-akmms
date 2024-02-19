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
      <h1>Revenue Report</h1>
      <div class="d-flex justify-content-between align-items-center">
      <nav>
          <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="adminmain.php">Home</a></li>
              <li class="breadcrumb-item active">Revenue Report</li>
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
    
        <form method="GET" action="profitpdf.php">
            <label for="start_date">Month Start Date:</label>
            <input type="datetime-local" id="startdate" name="startdate" required>

            <label for="end_date">Month End Date:</label>
            <input type="datetime-local" id="enddate" name="enddate" required>

            <br><br><br>

            <label for="start_date">Year Start Date:</label>
            <input type="datetime-local" id="startyeardate" name="startyeardate" required>

            <label for="end_date">Year End Date:</label>
            <input type="datetime-local" id="endyeardate" name="endyeardate" required>
            

            <button type="submit">Generate Report</button>
        </form>
    
</div>
</div>
</div>
</div>



</section>
</main>

<?php include('footer.php'); ?>