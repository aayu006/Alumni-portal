<?php
// Database connection (MySQL + mysqli)
$host = "localhost";
$user = "root";
$password = "";
$database = "alumni_portal";

$conn = mysqli_connect($host, $user, $password, $database);
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}
mysqli_set_charset($conn, "utf8mb4");
?>
