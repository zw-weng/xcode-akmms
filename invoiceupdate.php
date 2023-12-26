<?php include 'headeradmin.php'; ?>
<?php include 'dbconnect.php'; ?>

<main id="main" class="main">

    <div class="pagetitle">
        <h1>Invoice</h1>
        <div class="d-flex justify-content-between align-items-center">
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="adminmain.php">Home</a></li>
                    <li class="breadcrumb-item active">Invoice</li>
                </ol>
            </nav>

            <div class="btn-group me-2">
                <button type="button" class="btn btn-secondary"><i class="bi bi-filetype-pdf"></i> Export</button>
            </div>
        </div>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Invoice Details</h5>

                        <div class="table-responsive">
                            <form method="post" action="invoiceupdate.php"> <!-- Assuming you have a separate PHP file for updating -->

                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Order ID</th>
                                            <th>Quotation ID</th>
                                            <th>Customer ID</th>
                                            <th>Client Name</th>
                                            <th>Client Street</th>
                                            <th>Client Postcode</th>
                                            <th>Client City</th>
                                            <th>Client State</th>
                                            <th>Client Country</th>
                                            <th>Product Price</th>
                                            <th>Product Description</th>
                                            <th>Quantity</th>
                                            <th>Total</th>
                                            <th>Grand Total</th>
                                            <th>Quotation Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $query = "
                                            SELECT
                                                so.order_id,
                                                q.quotation_id,
                                                q.cust_id,
                                                q.client_name,
                                                q.client_street,
                                                q.client_postcode,
                                                q.client_city,
                                                q.client_state,
                                                q.client_country,
                                                q.product_price,
                                                q.product_desc,
                                                q.quantity,
                                                q.total,
                                                q.grand_total,
                                                q.quotation_date
                                            FROM
                                                tb_salesorder so
                                            JOIN
                                                tb_quotation q ON so.quotation_id = q.quotation_id
                                        ";

                                        $result = mysqli_query($con, $query);

                                        while ($row = mysqli_fetch_assoc($result)) {
                                            echo "<tr>";
                                            echo "<td>{$row['order_id']}</td>";
                                            echo "<td>{$row['quotation_id']}</td>";
                                            echo "<td>{$row['cust_id']}</td>";
                                            echo "<td><input type='text' name='client_name' value='{$row['client_name']}'></td>";
                                            echo "<td><input type='text' name='client_street' value='{$row['client_street']}'></td>";
                                            echo "<td><input type='text' name='client_postcode' value='{$row['client_postcode']}'></td>";
                                            echo "<td><input type='text' name='client_city' value='{$row['client_city']}'></td>";
                                            echo "<td><input type='text' name='client_state' value='{$row['client_state']}'></td>";
                                            echo "<td><input type='text' name='client_country' value='{$row['client_country']}'></td>";
                                            echo "<td><input type='text' name='product_price' value='{$row['product_price']}'></td>";
                                            echo "<td><input type='text' name='product_desc' value='{$row['product_desc']}'></td>";
                                            echo "<td><input type='text' name='quantity' value='{$row['quantity']}'></td>";
                                            echo "<td>{$row['total']}</td>";
                                            echo "<td>{$row['grand_total']}</td>";
                                            echo "<td>{$row['quotation_date']}</td>";
                                            echo "<td><button type='submit' name='update_btn'>Update</button></td>";
                                            echo "</tr>";
                                        }
                                        mysqli_close($con);
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

</main><!-- End #main -->

<?php include 'footer.php'; ?>
