<?php
include('mysession.php');
if (!session_id()) {
    session_start();
}
include 'headerstaff.php';
include 'dbconnect.php';
?>
<main id="main" class="main">
    <div class="pagetitle">
        <h1>Invoicing</h1>
        <div class="d-flex justify-content-between align-items-center">
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="staffmain.php">Home</a></li>
                    <li class="breadcrumb-item active">Invoice</li>
                </ol>
            </nav>
        </div>
        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Invoice List</h5>
                            <div class="table-responsive"> <!-- Add this container for responsiveness -->
                                <table class="table datatable table-hover">
                                    <thead>
                                        <tr>
                                            <th>Invoice ID</th>
                                            <th>Order ID</th>
                                            <th>Quotation ID</th>
                                            <th>Delivery Order ID</th>
                                            <th>Customer</th>
                                            <th>Payment Status</th>
                                            <th>Invoice Upfront</th>
                                            <th>Invoice Balance</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $query = "
SELECT 
    tb_invoice.invoice_id, tb_invoice.invoice_balance,tb_invoice.invoice_upfront,tb_invoice.order_id,tb_invoice.quotation_id,tb_invoice.delivery_id,
    tb_customer.cust_name,
    tb_paymentstatus.payment_status_desc
FROM 
    tb_invoice
INNER JOIN 
    tb_quotation ON tb_invoice.quotation_id = tb_quotation.quotation_id
INNER JOIN 
    tb_customer ON tb_quotation.cust_id = tb_customer.cust_id
INNER JOIN 
    tb_salesorder ON tb_invoice.order_id = tb_salesorder.order_id
INNER JOIN 
    tb_paymentstatus ON tb_salesorder.payment_status_id = tb_paymentstatus.payment_status_id
";

                                        $result = mysqli_query($con, $query);
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            echo "<tr>";
                                            echo "<td>{$row['invoice_id']}</td>"; // from tb_invoice
                                            echo "<td>{$row['order_id']}</td>";
                                            echo "<td>{$row['quotation_id']}</td>";
                                            echo "<td>{$row['delivery_id']}</td>";
                                            echo "<td>{$row['cust_name']}</td>"; // from tb_customer
                                            echo "<td>{$row['payment_status_desc']}</td>";
                                            echo "<td>{$row['invoice_upfront']}</td>"; // from tb_invoice
                                            echo "<td>{$row['invoice_balance']}</td>";
                                            echo "<td class='btn-group' role='group'>";
                                            echo "<a href='staff-invoiceupdate.php?quotation_id={$row['quotation_id']}' class='btn btn-warning btn-sm' title='Edit'><i class='bi bi-pencil'></i></a>";
                                            echo "&nbsp;";
                                            echo "<a href='staff-invoicegenerate.php?quotation_id={$row['quotation_id']}' class='btn btn-danger btn-sm' title='Generate PDF'><i class='bi bi-file-pdf'></i></a>";
                                            echo "&nbsp;";

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