<?php
include('mysession.php');

if (!session_id()) {
    session_start();
}

// Include database connection
include('dbconnect.php');
include('function.php'); // Assuming your redirect function is in 'function.php'


if (isset($_POST['update_payment'])) {
    // Retrieve and validate form data
    $payment_id = validate($_POST['payment_id']);
    $payment_date = validate($_POST['payment_date']);
    $client_name = validate($_POST['client_name']);
    $payment_amount = validate($_POST['payment_amount']);
    $payment_type = validate($_POST['payment_type']);

    // Check if a file is uploaded
    if (!empty($_FILES['payment_proof']['name'])) {
        $targetDir = __DIR__ . "/uploads/";
        $targetFile = $targetDir . basename($_FILES["payment_proof"]["name"]);
        $uploadOk = 1;

        $file = $_FILES['payment_proof'];

        $fileName = $file['name'];
        $fileTmpName = $file['tmp_name'];
        $fileSize = $file['size'];
        $fileError = $file['error'];

        $allowedExtensions = array('pdf');
        $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);

        // Check file extension
        if (!in_array(strtolower($fileExtension), $allowedExtensions)) {
            redirect('staff-payment.php', 'You can only upload pdf files!');
        }

        // Check file size
        if ($fileSize > 5000000) {
            redirect('staff-payment.php', 'Error: The uploaded file is too large.');
        }

        // Proceed with file handling if upload is successful
        if ($uploadOk == 1) {
            if (move_uploaded_file($fileTmpName, $targetFile)) {
                // File uploaded successfully, proceed with database update
                updateDatabase($con, $payment_id, $payment_date, $client_name, $payment_amount, $payment_type, $targetFile);
            } else {
                redirect('staff-payment.php', 'Error: There was an error uploading your file.');
            }
        } else {
            redirect('staff-payment.php', 'Error: File upload failed.');
        }
    } else {
        // No file uploaded, keep the existing proof of payment
        updateDatabase($con, $payment_id, $payment_date, $client_name, $payment_amount, $payment_type, null);
    }

    // Continue with the rest of your code...
}

// Close the database connection
mysqli_close($con);

// Function to update database and redirect
function updateDatabase($con, $payment_id, $payment_date, $client_name, $payment_amount, $payment_type, $payment_proof)
{
    // Update payment data in the database
    $sql = "UPDATE tb_payment SET
            payment_date = ?,
            client_name = ?,
            payment_amount = ?,
            payment_type_id = ?,
            payment_proof = IFNULL(?, payment_proof) -- Use IFNULL to keep existing value if null is provided
            WHERE payment_id = ?";

    $stmt = mysqli_prepare($con, $sql);

    // Bind the parameters
    mysqli_stmt_bind_param($stmt, "ssdssi", $payment_date, $client_name, $payment_amount, $payment_type, $payment_proof, $payment_id);

    // Execute the statement
    $result = mysqli_stmt_execute($stmt);

    if ($result) {
        // Payment updated successfully
        redirect('staff-payment.php', 'Payment updated successfully!');
    } else {
        // Error in database update
        redirect('staff-payment.php', 'Error updating payment: ' . mysqli_error($con));
    }

    // Close the statement
    mysqli_stmt_close($stmt);
}
?>
