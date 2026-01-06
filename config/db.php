<?php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); // Enable error reporting
$host = 'localhost';
$user = 'root';
$pass = ''; // Default XAMPP password is empty
$db_name = 'gym_db';

try {
    // MySQLi Connection (Legacy Support)
    $conn = new mysqli($host, $user, $pass, $db_name);
    $conn->set_charset("utf8mb4");

    // PDO Connection (Modern Support)
    $dsn = "mysql:host=$host;dbname=$db_name;charset=utf8mb4";
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ];
    $pdo = new PDO($dsn, $user, $pass, $options);

} catch (Exception $e) {
    die("Connection failed: " . $e->getMessage());
} catch (PDOException $e) {
    die("PDO Connection failed: " . $e->getMessage());
}
?>