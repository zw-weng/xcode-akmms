<?php
// Parameters
$servername = "localhost";
$username = "id21798437_akmaju";
$password = "Akmaju@123";
$dbname = "id21798437_db_akmms";

// Connection
$con = mysqli_connect($servername, $username, $password, $dbname);

// Verify connection
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}
?>