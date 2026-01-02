<?php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$host = 'localhost';
$user = 'root';
$pass = ''; // Default XAMPP password is empty

try {
    // Connect WITHOUT database first
    $conn = new mysqli($host, $user, $pass);

    // Create Database
    $conn->query("CREATE DATABASE IF NOT EXISTS gym_db");
    echo "Database 'gym_db' created or already exists.<br>";

    // Select Database
    $conn->select_db("gym_db");

    // Create Tables
    $sql_users = "CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(50) NOT NULL,
        email VARCHAR(100) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        role ENUM('admin', 'user') DEFAULT 'user',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    $conn->query($sql_users);
    echo "Table 'users' checked/created.<br>";

    $sql_classes = "CREATE TABLE IF NOT EXISTS classes (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL,
        description TEXT,
        instructor VARCHAR(100),
        schedule DATETIME,
        capacity INT DEFAULT 20,
        image VARCHAR(255) DEFAULT 'default.jpg',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    $conn->query($sql_classes);
    echo "Table 'classes' checked/created.<br>";

    $sql_bookings = "CREATE TABLE IF NOT EXISTS bookings (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT,
        class_id INT,
        booking_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
        FOREIGN KEY (class_id) REFERENCES classes(id) ON DELETE CASCADE
    )";
    $conn->query($sql_bookings);
    echo "Table 'bookings' checked/created.<br>";

    // Insert Admin if not exists
    $check_admin = $conn->query("SELECT * FROM users WHERE email='admin@gympact.com'");
    if ($check_admin->num_rows == 0) {
        $pass = password_hash('admin123', PASSWORD_DEFAULT);
        $conn->query("INSERT INTO users (username, email, password, role) VALUES ('Admin', 'admin@gympact.com', '$pass', 'admin')");
        echo "Default Admin account created (Email: admin@gympact.com, Pass: admin123).<br>";
    }

    echo "<h3>Setup Completed Successfully! <a href='index.php'>Go to Home</a> | <a href='login.php'>Login</a></h3>";

} catch (Exception $e) {
    die("Setup failed: " . $e->getMessage());
}
?>