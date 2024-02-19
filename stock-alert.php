<?php
// Include necessary files
include('mysession.php');
if (!session_id()) {
    session_start();
}
include('dbconnect.php');
include('function.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['set_minimum_level'])) {
    // Get the new minimum level from the form
    $newMinimumLevel = validate($_POST['minimum_level']);

    // Update the minimum level in the database using prepared statement
    $updateSql = "UPDATE tb_alert SET min_value = ?";

    $stmt = mysqli_prepare($con, $updateSql);
    mysqli_stmt_bind_param($stmt, "i", $newMinimumLevel);

    if (mysqli_stmt_execute($stmt)) {
        // Update successful

        // Fetch the updated minimum value
        $result = mysqli_query($con, "SELECT min_value FROM tb_alert");
        if ($result) {
            $row = mysqli_fetch_assoc($result);
            $actualMinimumLevel = $row['min_value'];

            // Redirect back to the stock.php page
            redirect('stock.php', 'Alert level is set to <strong>' . $actualMinimumLevel . '</strong> stocks');
            exit();
        } else {
            // Handle the error
            echo "Error fetching minimum value: " . mysqli_error($con);
        }
    } else {
        // Handle the error
        echo "Error updating minimum value: " . mysqli_error($con);
    }

    // Close the prepared statement
    mysqli_stmt_close($stmt);
}

// Close the database connection
mysqli_close($con);
?>