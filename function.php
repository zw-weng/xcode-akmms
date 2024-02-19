<?php
ob_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

// Include database connection
include('dbconnect.php');

function validate($inputData)
{
	global $con;

	return mysqli_real_escape_string($con, trim($inputData));
}

function redirect($url, $status)
{
	$_SESSION['status'] = $status;
	header('Location: ' . $url);
	exit(0);
}

function alertMessage()
{
	if (isset($_SESSION['status'])) {
		echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-info-circle me-1"></i>
                ' . $_SESSION['status'] . '
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>';
		unset($_SESSION['status']);
	}
}

function send_password_reset($get_name, $get_email, $token)
{
	//Create an instance; passing `true` enables exceptions
	try {
		$mail = new PHPMailer(true);

		//Server settings
		$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
		$mail->isSMTP();                                            //Send using SMTP
		$mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
		$mail->SMTPAuth   = true;                                   //Enable SMTP authentication
		$mail->Username   = 'akmajuresource@gmail.com';                     //SMTP username
		$mail->Password   = 'asvf tbse mtnn azbe';                               //SMTP password
		$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption
		$mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

		//Recipients
		$mail->setFrom('akmajuresource@gmail.com', 'AK Maju Resources Management System');
		$mail->addAddress($get_email);               //Name is optional

		//Content
		$mail->isHTML(true);                                  //Set email format to HTML
		$mail->Subject = 'Reset Password Notification';

		$email_template = "<h3>Hi, $get_name</h3><h4>You are receiving this email because we received a password reset request for your AKMMS account.</h4><br/><br/><a href='https://akmajuresources.000webhostapp.com/password-change.php?token=$token&email=$get_email'> Password Reset </a>";

		$mail->Body = $email_template;

		$mail->send();
	} catch (Exception $e) {
		echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
	}
}

function getLastInsertedId()
{
	global $con;

	$query = "SELECT MAX(quotation_id) as last_id FROM tb_quotation";
	$result = mysqli_query($con, $query);
	$row = mysqli_fetch_assoc($result);

	// Increment the last ID to get the next available ID
	$nextId = $row['last_id'] + 1;

	return $nextId;
}

function popCustomersList()
{
	global $con;

	$query = "SELECT * FROM tb_customer ORDER BY cust_id ASC";
	$result = mysqli_query($con, $query);

	if ($result) {
		print '<div class="table-responsive mt-4"><table class="table table-hover datatable"><thead><tr>
				<th>Customer ID</th>
				<th>Name</th>
				<th>Email</th>
				<th>Phone</th>
				<th>Action</th>

			  </tr></thead><tbody>';

		while ($row = mysqli_fetch_assoc($result)) {
			if($row["cust_status"] == 1){
			$country = $row['cust_country'];
			$state = $row['cust_state'];
			print '
                <tr>
                    <td>' . $row["cust_id"] . '</td>
                    <td>' . $row["cust_name"] . '</td>
                    <td>' . $row["cust_email"] . '</td>
                    <td>' . $row["cust_phone"] . '</td>
                    <td>
                        <a href="#" class="btn btn-outline-primary customer-select"
                            data-customer-name="' . $row['cust_name'] . '"
                            data-customer-email="' . $row['cust_email'] . '"
                            data-customer-phone="' . $row['cust_phone'] . '"
                            data-customer-street="' . $row['cust_street'] . '"
                            data-customer-postcode="' . $row['cust_postcode'] . '"
                            data-customer-city="' . $row['cust_city'] . '"
                            data-customer-state="' . $state . '"
                            data-customer-country="' . $country . '"
                        >
                            <i class="bi bi-check-square"></i> Select
                        </a>
                    </td>
                </tr>
            ';
		}
	}
		print '</tbody></table></div>';
	} else {
		echo "<p>There are no customers to display.</p>";
	}
	$result->free();
}

function popProductList()
{
	global $con;

	$query = "SELECT * FROM tb_advertising ORDER BY item_id ASC";
	$result = mysqli_query($con, $query);

	if ($result) {
		print '<div class="table-responsive mt-4"><table class="table table-hover datatable"><thead><tr>
                <th>Item ID</th>
                <th>Name</th>
				<th>Description</th>
                <th>Stock Level</th>
                <th>Item Price</th>
                <th>Action</th>
              </tr></thead><tbody>';

		while ($row = mysqli_fetch_assoc($result)) {
			if($row["item_status"] == 1){
			print '
                <tr>
                    <td>' . $row["item_id"] . '</td>
                    <td>' . $row["item_name"] . '</td>
                    <td>' . $row["item_desc"] . '</td>
                    <td>' . $row["item_qty"] . '</td>
                    <td>' . $row["item_price"] . '</td>
                    <td>
                        <a href="#" class="btn btn-outline-primary product-select"
                            data-item-id="' . $row['item_id'] . '"
                            data-item-name="' . $row['item_name'] . '"
                            data-item-price="' . $row['item_price'] . '"
                            data-item-qty="' . $row['item_qty'] . '"
                            data-item-desc="' . $row['item_desc'] . '"
                        >
                            <i class="bi bi-check-square"></i> Select
                        </a>
                    </td>
                </tr>
            ';
		}
	}
		print '</tbody></table></div>';
	} else {
		echo "<p>There are no product to display.</p>";
	}
	$result->free();
}

function popMaterialList()
{
	global $con;

	$query = "SELECT * FROM tb_construction JOIN tb_materialcategory ON tb_construction.material_category_id = tb_materialcategory.material_category_id
	ORDER BY tb_construction.material_id ASC";
	$result = mysqli_query($con, $query);

	if ($result) {
		print '<div class="table-responsive mt-4"><table class="table table-hover datatable"><thead><tr>
                <th>Material ID</th>
				<th>Category</th>
                <th>Name</th>
                <th>Description</th>
                <th>Action</th>
              </tr></thead><tbody>';

		while ($row = mysqli_fetch_assoc($result)) {
			if($row["material_status"] == 1){
			print '
                <tr>
                    <td>' . $row["material_id"] . '</td>
					<td>' . $row["material_category_desc"] . '</td>
                    <td>' . $row["material_name"] . '</td>
                    <td>' . $row["material_desc"] . '</td>
                    <td>
                        <a href="#" class="btn btn-outline-primary material-select"
                            data-material-name="' . $row['material_name'] . '"
                            data-material-desc="' . $row['material_desc'] . '"
							data-material-cost="' . $row['material_cost'] . '"
                        >
                            <i class="bi bi-check-square"></i> Select
                        </a>
                    </td>
                </tr>
            ';
		}
	}
		print '</tbody></table></div>';
	} else {
		echo "<p>There are no material to display.</p>";
	}
	$result->free();
}

function isValidPassword($password) {
    $pattern = '/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[\W_]).{12,}$/';
    return preg_match($pattern, $password);
}

function getUserName($con, $suid) {
    $userName = '';

    $sqlUser = "SELECT u_fName, u_lName FROM tb_user WHERE user_id = '$suid'";
    $resultUser = mysqli_query($con, $sqlUser);

    if ($resultUser) {
        $rowUser = mysqli_fetch_assoc($resultUser);
        $userName = $rowUser['u_fName'] . ' ' . $rowUser['u_lName'];
    } else {
        echo "Error fetching user information: " . mysqli_error($con);
    }

    return $userName;
}

function getAlertCount($con, $alert) {
    $getstock = mysqli_query($con, "SELECT * FROM tb_advertising WHERE item_qty <= $alert");
    $alertCount = mysqli_num_rows($getstock);

    return $alertCount;
}

function getUserType($con, $suid) {
    $userType = '';

    $sqlUser = "SELECT type_id FROM tb_user WHERE user_id = '$suid'";
    $resultUser = mysqli_query($con, $sqlUser);

    if ($resultUser) {
        $userTypeInfo = mysqli_fetch_assoc($resultUser);
        $userType = $userTypeInfo['type_id'];

        if ($userType == 1) {
            return 'Staff';
        } else {
            return 'Admin';
        }
    } else {
        echo "Error fetching user information: " . mysqli_error($con);
    }
}
ob_end_flush();
?>