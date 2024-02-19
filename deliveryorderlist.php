<?php
include('mysession.php');
if (!session_id()) {
    session_start();
}
include 'headeradmin.php';
include 'dbconnect.php';
?>

<main id="main" class="main">

    <div class="pagetitle">
        <h1>Delivery Order</h1>
        <div class="d-flex justify-content-between align-items-center">
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="adminmain.php">Home</a></li>
                    <li class="breadcrumb-item active">Delivery Order</li>
                </ol>
            </nav>
        </div>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Delivery Order List</h5>
                        <div class="table-responsive">
                            <table class="table datatable table-hover">
                                <thead>
                                    <tr>
                                        <th>Delivery Order ID</th>
                                        <th>Order ID</th>
                                        <th>Quotation ID</th>
                                        <th>Customer Name</th>
                                        <th>Items</th>
                                        <th>Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $query = "SELECT tb_deliveryorder.delivery_id, tb_deliveryorder.order_id, tb_deliveryorder.quotation_id, tb_customer.cust_name, GROUP_CONCAT(tb_product.product_name SEPARATOR ', ') as product_names, tb_deliveryorder.do_date
FROM tb_deliveryorder 
JOIN tb_quotation ON tb_deliveryorder.quotation_id = tb_quotation.quotation_id
JOIN tb_customer ON tb_quotation.cust_id = tb_customer.cust_id
JOIN tb_product ON tb_quotation.quotation_id = tb_product.quotation_id
GROUP BY tb_deliveryorder.quotation_id";
                                    $result = mysqli_query($con, $query);
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        echo "<tr>";
                                        echo "<td>{$row['delivery_id']}</td>";
                                        echo "<td>{$row['order_id']}</td>";
                                        echo "<td>{$row['quotation_id']}</td>";
                                        echo "<td>{$row['cust_name']}</td>"; // from tb_customer
                                        echo "<td>{$row['product_names']}</td>"; // from tb_product
                                        echo "<td>{$row['do_date']}</td>";
                                        echo "<td class='btn-group' role='group'>";
                                        echo "<a href='DOpdf.php?quotation_id={$row['quotation_id']}' class='btn btn-danger btn-sm' title='Generate PDF'><i class='bi bi-file-pdf'></i></a>";
                                        echo "</td>";
                                        echo "</tr>";
                                    }
                                    mysqli_close($con); // Use $con instead of $connection
                                    ?>

                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </section>

</main><!-- End #main -->

<?php include 'footer.php'; ?>