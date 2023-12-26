<?php
include('mysession.php');
if (!session_id()) {
    session_start();
}

// Get user ID from URL
if (isset($_GET['id'])) {
    $userId = $_GET['id'];
}

include('dbconnect.php');

// CRUD: Delete
$sql = "DELETE FROM tb_user WHERE user_id='$userId'";
$result = mysqli_query($con, $sql);

if (!$result) {
    die("Query failed: " . mysqli_error($con));
}

mysqli_close($con);

header('Location:userlist.php');
?>