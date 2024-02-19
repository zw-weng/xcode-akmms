<?php
include('mysession.php');
if (!session_id()) {
  session_start();
}
include 'headerstaff.php'; ?>
<?php
// Include database connection
include('dbconnect.php');

// SQL query to sum the values in your_column
$sql = "SELECT COUNT(*) AS rowCount FROM tb_customer";
$sqlc = "SELECT COUNT(*) AS rowCount1 FROM tb_salesorder";
$sqld = "SELECT SUM(item_qty) AS total FROM tb_advertising WHERE item_status=1";
$sqle = "SELECT * FROM tb_quotation";
$sqlf = "SELECT COUNT(*) AS rowCount2 FROM tb_customer WHERE cust_status=1";
$sqlg = "SELECT COUNT(*) AS rowCount3 FROM tb_customer WHERE cust_status=0";
$sqlh = "SELECT COUNT(*) AS rowCount4 FROM tb_payment WHERE payment_status=1";
$sqli = "SELECT COUNT(*) AS rowCount5 FROM tb_user WHERE acc_status=1";
$sqlj = "SELECT COUNT(*) AS rowCount6 FROM tb_user WHERE acc_status=0";

$result1 = mysqli_query($con, $sqli);
$result2 = mysqli_query($con, $sqlj);

$rowh = mysqli_fetch_assoc($result1);
$rowi = mysqli_fetch_assoc($result2);

// Execute the query
$result = mysqli_query($con, $sql);
$resultr = mysqli_query($con, $sqlc);
$resultc = mysqli_query($con, $sqld);
$resultd = mysqli_query($con, $sqle);
$resulte = mysqli_query($con, $sqlf);
$resultf = mysqli_query($con, $sqlg);
$resultg = mysqli_query($con, $sqlh);
// Check for errors
if (!$result) {
  die("Query failed: " . mysqli_error($con));
}

// Fetch the result
$row = mysqli_fetch_assoc($result);
$rowr = mysqli_fetch_assoc($resultr);
$rowc = mysqli_fetch_assoc($resultc);
$rowd = mysqli_fetch_assoc($resultd);
$rowe = mysqli_fetch_assoc($resulte);
$rowf = mysqli_fetch_assoc($resultf);
$rowg = mysqli_fetch_assoc($resultg);
// Get the total sum
$totalSum = $row['rowCount'];
$totalorder = $rowr['rowCount1'];
$totalstock = $rowc['total'];
$quotationid = $rowd['quotation_id'];
$activecustomer = $rowe['rowCount2'];
$deactivecustomer = $rowf['rowCount3'];
$transaction = $rowg['rowCount4'];

$sql = "SELECT SUM(item_cost) AS total1 FROM tb_advertising";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_assoc($result);

$sqla = "SELECT SUM(payment_amount) AS total2 FROM tb_payment";
$resulta = mysqli_query($con, $sqla);
$rowa = mysqli_fetch_assoc($resulta);

$sales = $rowa['total2'];
$yearsales = $rowa['total2'];
$cost = $row['total1'];
$profit = $sales - $cost;
$other = 0.00;
$netprofit = $profit - $other;
$formattedNetProfit = number_format($netprofit, 2);

$a = "SELECT COUNT(order_status_id) AS num1
FROM tb_salesorder WHERE order_status_id=1";
$b = "SELECT COUNT(order_status_id) AS num2
FROM tb_salesorder WHERE order_status_id=2";
$c = "SELECT COUNT(order_status_id) AS num3
FROM tb_salesorder WHERE order_status_id=3";
$d = "SELECT COUNT(order_status_id) AS num4
FROM tb_salesorder WHERE order_status_id=4";

$aa = mysqli_query($con, $a);
$bb = mysqli_query($con, $b);
$cc = mysqli_query($con, $c);
$dd = mysqli_query($con, $d);

$aaa = mysqli_fetch_assoc($aa);
$bbb = mysqli_fetch_assoc($bb);
$ccc = mysqli_fetch_assoc($cc);
$ddd = mysqli_fetch_assoc($dd);

$order1 = $aaa['num1'];
$order2 = $bbb['num2'];
$order3 = $ccc['num3'];
$order4 = $ddd['num4'];

$e = "SELECT COUNT(quotation_status_id) AS num5
FROM tb_quotation WHERE quotation_status_id=1";
$f = "SELECT COUNT(quotation_status_id) AS num6
FROM tb_quotation WHERE quotation_status_id=2";

$ee = mysqli_query($con, $e);
$ff = mysqli_query($con, $f);

$eee = mysqli_fetch_assoc($ee);
$fff = mysqli_fetch_assoc($ff);

$quote5 = $eee['num5'];
$quote6 = $fff['num6'];

// Display the result
//echo "Total Sum: " . $totalSum;

// Close the database connection
mysqli_close($con);
?>

<main id="main" class="main">

  <div class="pagetitle">
    <h1>Dashboard</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="staffmain.php">Home</a></li>
        <li class="breadcrumb-item active">Dashboard</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

  <section class="section dashboard">

    <div class="row">
      <div class="col-lg-8">
        <div class="row">
          <!-- Sales Card -->
          <div class="col-md-6">
            <div class="card info-card sales-card">
              <div class="card-body">
                <h5 class="card-title">Orders <span>| All</span></h5>
                <div class="d-flex align-items-center">
                  <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-cart"></i>
                  </div>
                  <div class="ps-3">
                    <h6><?php echo "Total Order: " . $totalorder; ?></h6>
                  </div>
                </div>
              </div>
            </div>
          </div><!-- End Sales Card -->

          <!-- Revenue Card -->

          <div class="col-md-6">
            <div class="card info-card sales-card">
              <div class="card-body">
                <h5 class="card-title">Stock <span>| Balance</span></h5>
                <div class="d-flex align-items-center">
                  <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-bag-check"></i>
                  </div>
                  <div class="ps-3">
                    <h6><?php echo "Total Stock: " . $totalstock; ?></h6>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Revenue Card -->
          <div class="col-md-6">
            <div class="card info-card revenue-card">
              <div class="card-body">
                <h5 class="card-title">Transaction <span>| All </span></h5>
                <div class="d-flex align-items-center">
                  <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-arrow-left-right"></i>
                  </div>
                  <div class="ps-3">
                    <h6><?php echo "Total Transaction: " . $transaction; ?></h6>
                  </div>
                </div>
              </div>
            </div>
          </div><!-- End Revenue Card -->

          <!-- Customers Card -->
          <div class="col-md-6">
            <div class="card info-card customers-card">
              <div class="filter">
                <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                  <li class="dropdown-header text-start">
                    <h6>Customer Info Management</h6>
                  </li>
                  <li><a class="dropdown-item" href="customer-export-excel.php">Export Data</a></li>
                </ul>
              </div>

              <div class="card-body">
                <h5 class="card-title">Customers <span>| Entered</span></h5>
                <div class="d-flex align-items-center">
                  <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-people"></i>
                  </div>
                  <div class="ps-3">
                    <h6><?php echo "Total Customer: " . $totalSum; ?></h6>
                  </div>
                </div>
              </div>
            </div>
          </div><!-- End Customers Card -->
        </div> <!-- Divide two -->
      </div>

      <div class="col-lg-4">
        <div class="card">
          <div class="card-body pb-0">
            <h5 class="card-title">Customer Status Chart <span>| All </span></h5>
            <div id="trafficChart" style="min-height: 300px;" class="echart"></div>
            <script>
              document.addEventListener("DOMContentLoaded", () => {
                echarts.init(document.querySelector("#trafficChart")).setOption({
                  tooltip: {
                    trigger: 'item'
                  },
                  legend: {
                    top: '5%',
                    left: 'center'
                  },
                  series: [{
                    name: 'Access From',
                    type: 'pie',
                    radius: ['40%', '70%'],
                    avoidLabelOverlap: false,
                    label: {
                      show: false,
                      position: 'center'
                    },
                    emphasis: {
                      label: {
                        show: true,
                        fontSize: '18',
                        fontWeight: 'bold'
                      }
                    },
                    labelLine: {
                      show: false
                    },
                    data: [{
                        value: <?php echo $rowf['rowCount3']; ?>,
                        name: 'Previous Customer'
                      },
                      {
                        value: <?php echo $rowe['rowCount2']; ?>,
                        name: 'Current Customer'
                      }
                    ]
                  }]
                });
              });
            </script>
          </div>
        </div><!-- End Website Traffic -->
      </div>
    </div>

    <div class="row">
      <div class="col-lg-6">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Printing & Advertising Order Status</h5>

            <!-- Bar Chart -->
            <canvas id="barChart" style="max-height: 800px;"></canvas>
            <script>
              document.addEventListener("DOMContentLoaded", () => {
                new Chart(document.querySelector('#barChart'), {
                  type: 'bar',
                  data: {
                    labels: ['Cancelled', 'DO Generated', 'Invoice Issued', 'Completed'],
                    datasets: [{
                      label: 'Bar Chart',
                      data: [<?php echo " $order1, $order2, $order3, $order4" ?>],
                      backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(255, 159, 64, 0.2)',
                        'rgba(255, 205, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(201, 203, 207, 0.2)'
                      ],
                      borderColor: [
                        'rgb(255, 99, 132)',
                        'rgb(255, 159, 64)',
                        'rgb(255, 205, 86)',
                        'rgb(75, 192, 192)',
                        'rgb(54, 162, 235)',
                        'rgb(153, 102, 255)',
                        'rgb(201, 203, 207)'
                      ],
                      borderWidth: 1
                    }]
                  },
                  options: {
                    scales: {
                      y: {
                        beginAtZero: true
                      }
                    }
                  }
                });
              });
            </script>
            <!-- End Bar CHart -->

          </div>
        </div>
      </div>

      <div class="col-lg-6">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Quotation Status</h5>

            <!-- Bar Chart -->
            <canvas id="barChart1" style="max-height: 800px;"></canvas>
            <script>
              document.addEventListener("DOMContentLoaded", () => {
                new Chart(document.querySelector('#barChart1'), {
                  type: 'bar',
                  data: {
                    labels: ['Approved', 'Pending'],
                    datasets: [{
                      label: 'Bar Chart',
                      data: [<?php echo " $quote5, $quote6 " ?>],
                      backgroundColor: [
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(201, 203, 207, 0.2)'
                      ],
                      borderColor: [
                        'rgb(153, 102, 255)',
                        'rgb(201, 203, 207)'
                      ],
                      borderWidth: 1
                    }]
                  },
                  options: {
                    scales: {
                      y: {
                        beginAtZero: true
                      }
                    }
                  }
                });
              });
            </script>
            <!-- End Bar CHart -->

          </div>
        </div>
      </div>
    </div>

  </section>
</main><!-- End #main -->

<?php include 'footer.php'; ?>