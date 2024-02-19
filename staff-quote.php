<?php
include('mysession.php');
if (!session_id()) {
  session_start();
}

// Include database connection
include('dbconnect.php');

include 'headerstaff.php';
?>

<main id="main" class="main">

  <div class="pagetitle">
    <h1>Quotation</h1>
    <div class="d-flex justify-content-between align-items-center">
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="staffmain.php">Home</a></li>
          <li class="breadcrumb-item active">Quotation</li>
        </ol>
      </nav>

      <div class="btn-group">
        <button type="button" class="btn btn-primary shadow dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="bi bi-plus-circle"></i> New
        </button>
        <div class="dropdown-menu">
          <a class="dropdown-item" href="staff-quote-ads-create.php"><i class="bi bi-play-fill"></i> Advertising</a>
          <a class="dropdown-item" href="staff-quote-jkr-create.php"><i class="bi bi-cone-striped"></i> Construction</a>
        </div>
      </div>
    </div>
  </div><!-- End Page Title -->

  <section class="section">
    <div class="row">
      <div class="col-lg-12">
      <?= alertMessage(); ?>
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Quotation List</h5>

            <!-- Wrap the table with a div and apply the table-responsive class -->
            <div class="table-responsive mt-4">
              <form method="post" action="staff-update-status.php">
                <!-- Table with stripped rows -->
                <table class="table table-hover datatable">
                  <thead>
                    <tr>
                      <th><b>Quotation ID</b></th>
                      <th>Customer Name</th>
                      <th>Address</th>
                      <th>Email</th>
                      <th>Contact No.</th>
                      <th>Grand Total</th>
                      <th>Date</th>
                      <th>Category</th>
                      <th>Status</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    include('dbconnect.php');
                    // Modified SQL statement to retrieve data from tb_quotation with specific customer name
                    $sqlQuotations = "SELECT 
    tb_quotation.quotation_id, 
    tb_customer.cust_name, 
    tb_customer.cust_street, 
    tb_customer.cust_postcode, 
    tb_customer.cust_city, 
    tb_customer.cust_state, 
    tb_customer.cust_country, 
    tb_customer.cust_email, 
    tb_customer.cust_phone, 
    tb_quotation.grand_total, 
    tb_quotation.quotation_date,
    tb_quotationtype.quotation_type_id,
    tb_quotationtype.quotation_type_desc,
    tb_quotationstatus.quotation_status_id,
    tb_quotationstatus.quotation_status_desc
FROM 
    tb_quotation 
INNER JOIN 
    tb_customer ON tb_quotation.cust_id = tb_customer.cust_id
INNER JOIN 
    tb_quotationtype ON tb_quotation.quotation_type_id = tb_quotationtype.quotation_type_id
INNER JOIN 
    tb_quotationstatus ON tb_quotation.quotation_status_id = tb_quotationstatus.quotation_status_id";
                    $resultQuotations = mysqli_query($con, $sqlQuotations);
                    if ($resultQuotations) {
                      while ($row = mysqli_fetch_assoc($resultQuotations)) {
                        echo "<tr>";
                        echo "<td>{$row['quotation_id']}</td>";
                        echo "<td>{$row['cust_name']}</td>";
                        echo "<td>{$row['cust_street']}, {$row['cust_postcode']}, {$row['cust_city']}, {$row['cust_state']}, {$row['cust_country']}</td>";
                        echo "<td>{$row['cust_email']}</td>";
                        echo "<td>{$row['cust_phone']}</td>";
                        echo "<td>{$row['grand_total']}</td>";
                        echo "<td>{$row['quotation_date']}</td>";
                        echo "<td>{$row['quotation_type_desc']}</td>";
                        echo "<td>";
                        if ($row['quotation_status_id'] == 1) {
                          echo "<span class='badge bg-success'>Approved</span>";
                        } else {
                          echo "<span class='badge bg-danger'>Pending</span>";
                        }
                        echo "</td>";
                        echo "<td>";
                        echo "<div class='btn-group' role='group'>";
                        //echo "<a href='.php?quotation_id={$row['quotation_id']}' class='btn btn-warning btn-sm' title='Edit'><i class='bi bi-pencil'></i></a>";
                        echo "&nbsp;";
                        echo "<a href='quote-ads-preview.php?quotation_id={$row['quotation_id']}' class='btn btn-danger btn-sm' title='Generate PDF'><i class='bi bi-filetype-pdf'></i></a>";
                        echo "&nbsp;";
                        //echo "<a href='.php?quotation_id={$row['quotation_id']}' class='btn btn-secondary btn-sm' title='Send Email'><i class='bi bi-envelope'></i></a>";
                        echo "&nbsp;";
                        if ($row['quotation_status_id'] != 1) {
    $status_id = 1; // Approved
    echo "<a href='staff-update-status.php?quotation_id={$row['quotation_id']}&status_id={$status_id}' class='btn btn-primary btn-sm' title='Approve'><div class='icon'><i class='bi bi-check2-square'></i></div></a>";
}
                        echo "</div>";
                        echo "</td>";
                        echo "</tr>";
                      }
                    } else {
                      echo "Query failed: " . mysqli_error($con);
                    }
                    ?>
                  </tbody>
                </table>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>


  </section>

  <?php mysqli_close($con); ?>
</main><!-- End #main -->

<?php include 'footer.php';?>