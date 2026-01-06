<?php
require_once 'config/db.php';

echo "Files included: " . implode(', ', get_included_files()) . "<br>";
var_dump($pdo);
if (!isset($pdo)) {
    echo "PDO is NOT set!";
}

try {
    // Trainers Table
    $sql = "CREATE TABLE IF NOT EXISTS trainers (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL,
        specialty VARCHAR(100),
        bio TEXT,
        rate DECIMAL(10,2),
        image VARCHAR(255),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    $pdo->exec($sql);
    echo "Trainers table created successfully.<br>";

    // Trainer Bookings Table
    $sql = "CREATE TABLE IF NOT EXISTS trainer_bookings (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT,
        trainer_id INT,
        booking_date DATETIME,
        status ENUM('pending', 'confirmed', 'completed', 'cancelled') DEFAULT 'pending',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
        FOREIGN KEY (trainer_id) REFERENCES trainers(id) ON DELETE CASCADE
    )";
    $pdo->exec($sql);
    echo "Trainer Bookings table created successfully.<br>";

    // Check if trainers check exists
    $stmt = $pdo->query("SELECT COUNT(*) FROM trainers");
    if ($stmt->fetchColumn() == 0) {
        $sql = "INSERT INTO trainers (name, specialty, bio, rate, image) VALUES 
        ('Alex Cormier', 'Strength & Conditioning', 'Certified strength coach with 10 years experience.', 50.00, 'trainer1.jpg'),
        ('Mia Wong', 'Yoga & Pilates', 'Helping you find balance and flexibility.', 45.00, 'trainer2.jpg'),
        ('Marcus Johnson', 'HIIT & Cardio', 'High energy trainer to push your limits.', 40.00, 'trainer3.jpg')";
        $pdo->exec($sql);
        echo "Dummy trainers inserted.<br>";
    }

} catch (PDOException $e) {
    echo "Error creating tables: " . $e->getMessage();
}
?>