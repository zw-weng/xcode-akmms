<?php
// Include necessary files
include('mysession.php');
if (!session_id()) {
    session_start();
}
include('dbconnect.php');
include('function.php');

// Get material id from URL
if (isset($_GET['id'])) {
    $materialId = $_GET['id'];

    // Validate and sanitize the material ID to prevent SQL injection
    $materialId = mysqli_real_escape_string($con, $materialId);
    $materialId = htmlspecialchars($materialId); // Additional input sanitization
}

if (isset($_POST['save_jkr'])) {
    $material_name = validate($_POST['material_name']);
    $material_desc = validate($_POST['material_desc']);
    $material_cost = validate($_POST['material_cost']);
    $material_unit = validate($_POST['material_unit']);
    $ftype = validate($_POST['ftype']);

    if ($material_name != '' && $material_desc != '' && $material_cost != '' && $material_unit != '' && $ftype != '') {

        $sql = "UPDATE tb_construction SET
            material_name = ?,
            material_desc = ?,
            material_cost = ?,
            material_unit = ?,
            material_category_id = ?
            WHERE material_id = ?";

        $stmt = mysqli_prepare($con, $sql);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "ssdssi", $material_name, $material_desc, $material_cost, $material_unit, $ftype, $materialId);
            mysqli_stmt_execute($stmt);

            $affectedRows = mysqli_stmt_affected_rows($stmt);

            if ($affectedRows > 0) {
                // Update successful
                redirect('staff-jkr.php', 'Material updated successfully');
            } else {
                // Update failed
                redirect('staff-jkr-edit.php', 'No changes or error updating material');
            }

            mysqli_stmt_close($stmt);
        } else {
            // Prepare statement failed
            redirect('staff-jkr-edit.php', 'Error preparing the update statement');
        }
    } else {
        // Invalid or missing data
        redirect('staff-jkr-edit.php', 'Please fill in all required fields');
    }
}

// Close DB Connection (no need to close here if you are redirecting)
mysqli_close($con);

// Redirect to the next page
header('Location: staff-jkr.php');
?>