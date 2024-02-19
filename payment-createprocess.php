<?php
include('mysession.php');

if (!session_id()) {
    session_start();
}

// Include database connection
include('dbconnect.php');
include('function.php'); // Assuming your redirect function is in 'function.php'

if (isset($_POST['save_payment'])) {
    // Retrieve and validate form data
    $order_id = validate($_POST['order_id']);
    $payment_date = validate($_POST['payment_date']);
    $client_name = validate($_POST['client_name']);
    $payment_amount = validate($_POST['payment_amount']);
    $payment_type = validate($_POST['payment_type']);

    // Handle file upload for payment proof
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
        redirect('payment.php', 'You can only upload pdf files!');
    }

    // Check file size
    if ($fileSize > 5000000) {
        redirect('payment.php', 'Error: The uploaded file is too large.');
    }

    // Proceed with file handling if upload is successful
    if ($uploadOk == 1) {
        if (move_uploaded_file($fileTmpName, $targetFile)) {
            // File uploaded successfully, proceed with database insertion

            // Insert payment data into the database
            $sql = "INSERT INTO tb_payment (order_id, payment_date, client_name, payment_amount, payment_type_id, payment_proof, payment_status) VALUES (?, ?, ?, ?, ?, ?, 1)";
            $stmt = mysqli_prepare($con, $sql);

            // Bind the parameters
            mysqli_stmt_bind_param($stmt, "issdss", $order_id, $payment_date, $client_name, $payment_amount, $payment_type, $targetFile);

            // Execute the statement
            $result = mysqli_stmt_execute($stmt);

            if ($result) {
                // Payment added successfully
                redirect('payment.php', 'Payment added successfully!');
            } else {
                // Error in database insertion
                redirect('payment.php', 'Error adding payment: ' . mysqli_error($con));
            }

            // Close the statement
            mysqli_stmt_close($stmt);
        } else {
            redirect('payment.php', 'Error: There was an error uploading your file.');
        }
    } else {
        redirect('payment.php', 'Error: File upload failed.');
    }

    // Continue with the rest of your code...
}

// Close the database connection
mysqli_close($con);
?>
