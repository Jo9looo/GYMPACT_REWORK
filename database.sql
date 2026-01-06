-- Database Creation
CREATE DATABASE IF NOT EXISTS gym_db;
USE gym_db;

-- Users Table
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'user') DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Classes Table
CREATE TABLE IF NOT EXISTS classes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    instructor VARCHAR(100),
    schedule DATETIME,
    capacity INT DEFAULT 20,
    image VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Bookings Table
CREATE TABLE IF NOT EXISTS bookings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    class_id INT,
    booking_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (class_id) REFERENCES classes(id) ON DELETE CASCADE
);

-- Insert a default Admin user (password: admin123)
-- Note: 'admin123' should be hashed in a real application, but for initial setup we might need to handle this in PHP or insert a pre-hashed value. 
-- For this script, I'll insert a placeholder and we can update it or register via the app.
-- Let's use a simple hash for 'admin123' if possible or just raw for testing if logic allows, but better to use the app to register.
-- I'll insert a sample class.
INSERT INTO classes (name, description, instructor, schedule, capacity, image) VALUES 
('Yoga Flow', 'Relaxing yoga session for all levels.', 'Sarah Jenkins', '2023-11-20 10:00:00', 15, 'yoga.jpg'),
('HIIT Blast', 'High intensity interval training.', 'Mike Tyson', '2023-11-21 18:00:00', 20, 'hiit.jpg');

-- Trainers Table
CREATE TABLE IF NOT EXISTS trainers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    specialty VARCHAR(100),
    bio TEXT,
    rate DECIMAL(10,2),
    image VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Trainer Bookings Table
CREATE TABLE IF NOT EXISTS trainer_bookings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    trainer_id INT,
    booking_date DATETIME,
    status ENUM('pending', 'confirmed', 'completed', 'cancelled') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (trainer_id) REFERENCES trainers(id) ON DELETE CASCADE
);

-- Insert Dummy Trainers
INSERT INTO trainers (name, specialty, bio, rate, image) VALUES 
('Alex Cormier', 'Strength & Conditioning', 'Certified strength coach with 10 years experience.', 50.00, 'trainer1.jpg'),
('Mia Wong', 'Yoga & Pilates', 'Helping you find balance and flexibility.', 45.00, 'trainer2.jpg'),
('Marcus Johnson', 'HIIT & Cardio', 'High energy trainer to push your limits.', 40.00, 'trainer3.jpg');
