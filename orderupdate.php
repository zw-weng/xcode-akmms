<?php
include 'headeradmin.php';
include 'dbconnect.php';

$order_id = $_GET['order_id']; // Get the order_id from the URL

// Fetch the order details from the database
$query = "SELECT tb_salesorder.order_id, tb_salesorder.quotation_id, tb_salesorder.staff_incharge, tb_salesorder.remark, tb_orderstatus.order_status_desc, tb_paymentstatus.payment_status_desc 
          FROM tb_salesorder 
          INNER JOIN tb_orderstatus ON tb_salesorder.order_status_id = tb_orderstatus.order_status_id 
          INNER JOIN tb_paymentstatus ON tb_salesorder.payment_status_id = tb_paymentstatus.payment_status_id 
          WHERE tb_salesorder.order_id = $order_id";

$result = mysqli_query($con, $query);
$order = mysqli_fetch_assoc($result);

// Now $order contains the details of the order
?>

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Update Order</h1>
        <div class="d-flex justify-content-between align-items-center">
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="adminmain.php">Home</a></li>
                    <li class="breadcrumb-item"><a href="order.php">Order</a></li>
                    <li class="breadcrumb-item active">Update Order</li>
                </ol>
            </nav>
            <div class="btn-group me-2">
                <a href="order.php" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Back</a>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Update Order</h5>

                        <form action="orderupdateprocess.php" method="post">

                            <input type="hidden" name="order_id" value="<?php echo $order['order_id']; ?>">
                            <div class="row mb-3">
                                <label for="order_id" class="col-sm-2 col-form-label">Order ID</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="order_id" value="<?php echo $order['order_id']; ?>" disabled>
                                </div>
                            </div>

                            <input type="hidden" name="quotation_id" value="<?php echo $quotation['quotation_id']; ?>">
                            <div class="row mb-3">
                                <label for="quotation_id" class="col-sm-2 col-form-label">Quotation ID</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="quotation_id" value="<?php echo $order['quotation_id']; ?>" disabled>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="staff_incharge" class="col-sm-2 col-form-label">Staff Incharge</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="staff_incharge" name="staff_incharge" value="<?php echo $order['staff_incharge']; ?>">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="remark" class="col-sm-2 col-form-label">Remark</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="remark" name="remark" value="<?php echo $order['remark']; ?>">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="payment_status_id" class="col-sm-2 col-form-label">Payment Status</label>
                                <div class="col-sm-10">
                                    <select class="form-control" id="payment_status_id" name="payment_status_id">
                                        <?php
                                        $query = "SELECT * FROM tb_paymentstatus";
                                        $result = mysqli_query($con, $query);
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            echo '<option value="' . $row['payment_status_id'] . '"' . ($order['payment_status_desc'] == $row['payment_status_desc'] ? ' selected' : '') . '>' . $row['payment_status_desc'] . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="order_status_id" class="col-sm-2 col-form-label">Order Status</label>
                                <div class="col-sm-10">
                                    <select class="form-control" id="order_status_id" name="order_status_id">
                                        <?php
                                        $query = "SELECT * FROM tb_orderstatus";
                                        $result = mysqli_query($con, $query);
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            echo '<option value="' . $row['order_status_id'] . '"' . ($order['order_status_desc'] == $row['order_status_desc'] ? ' selected' : '') . '>' . $row['order_status_desc'] . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="d-flex justify-content-center">
                                <button type="submit" class="btn btn-outline-primary"><i class="bi bi-arrow-up-square"></i> Save</button>
                                &nbsp;
                                <button type="reset" class="btn btn-outline-danger"><i class="bi bi-x-square"></i> Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>


<?php
include 'footer.php';
?>