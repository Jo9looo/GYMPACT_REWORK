<?php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); // Enable error reporting
$host = 'localhost';
$user = 'root';
$pass = ''; // Default XAMPP password is empty
$db_name = 'gym_db';

try {
    $conn = new mysqli($host, $user, $pass, $db_name);
    $conn->set_charset("utf8mb4");
} catch (Exception $e) {
    die("Connection failed: " . $e->getMessage());
}
?>