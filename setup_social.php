<?php
require_once 'config/db.php';

try {
    // Posts Table
    $sql = "CREATE TABLE IF NOT EXISTS posts (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT,
        content TEXT NOT NULL,
        image VARCHAR(255),
        likes INT DEFAULT 0,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
    )";
    $pdo->exec($sql);
    echo "Posts table created successfully.<br>";

    // Insert dummy posts if empty
    $stmt = $pdo->query("SELECT COUNT(*) FROM posts");
    if ($stmt->fetchColumn() == 0) {
        $sql = "INSERT INTO posts (user_id, content, likes) VALUES 
        (1, 'Just crushed my leg day! 🦵 #GymPact #LegDay', 12),
        (1, 'Loving the new yoga class. Thanks Sarah!', 8)";
        $pdo->exec($sql); // Assuming user ID 1 exists (admin)
        echo "Dummy posts inserted.<br>";
    }

} catch (PDOException $e) {
    echo "Error creating table: " . $e->getMessage();
}
?>