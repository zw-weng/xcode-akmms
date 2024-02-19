<?php
// Parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_akmms";

// Connection
$con = mysqli_connect($servername, $username, $password, $dbname);

// Verify connection
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}
?>