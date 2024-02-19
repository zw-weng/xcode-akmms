<?php

include 'headeradmin.php';
include 'dbconnect.php';
?>
<main id="main" class="main">
    <div class="pagetitle">
        <h1>Order</h1>
        <div class="d-flex justify-content-between align-items-center">
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="adminmain.php">Home</a></li>
                    <li class="breadcrumb-item active">Order</li>
                </ol>
            </nav>
        </div>
        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                <?= alertMessage(); ?>
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Order List</h5>
                            <div class="table-responsive">
                                <table class="table datatable table-hover">
                                    <thead>
                                        <tr>
                                            <th>Order ID</th>
                                            <th>Quotation ID</th>
                                            <th>Staff Incharge</th>
                                            <th>Remark</th>
                                            <th>Payment Status</th>
                                            <th>Order Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $query = "SELECT 
                    tb_salesorder.order_id,
                    tb_quotation.quotation_id,
                    tb_salesorder.staff_incharge,
                    tb_salesorder.remark,
                    tb_paymentstatus.payment_status_id,
                    tb_paymentstatus.payment_status_desc,
                    tb_orderstatus.order_status_id,
                    tb_orderstatus.order_status_desc
                FROM tb_salesorder
                INNER JOIN tb_paymentstatus ON tb_salesorder.payment_status_id = tb_paymentstatus.payment_status_id
                INNER JOIN tb_orderstatus ON tb_salesorder.order_status_id = tb_orderstatus.order_status_id
                INNER JOIN tb_quotation ON tb_salesorder.quotation_id = tb_quotation.quotation_id";
                                        $result = mysqli_query($con, $query);
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            echo "<tr>";
                                            echo "<td>{$row['order_id']}</td>";
                                            echo "<td>{$row['quotation_id']}</td>";
                                            echo "<td>{$row['staff_incharge']}</td>";
                                            echo "<td>{$row['remark']}</td>";
                                            echo "<td>{$row['payment_status_desc']}</td>";
                                            echo "<td>{$row['order_status_desc']}</td>";
                                            echo "<td class='btn-group' role='group'>";
                                            echo "<a href='orderupdate.php?order_id={$row['order_id']}' class='btn btn-warning btn-sm' title='Edit'><i class='bi bi-pencil'></i></a>";
                                            echo "&nbsp;";
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

<?php
include 'footer.php';
?>