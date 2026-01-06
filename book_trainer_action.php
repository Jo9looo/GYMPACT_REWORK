<?php
session_start();
require_once 'config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $trainer_id = $_POST['trainer_id'];
    $booking_date = $_POST['booking_date'];

    try {
        $stmt = $pdo->prepare("INSERT INTO trainer_bookings (user_id, trainer_id, booking_date, status) VALUES (?, ?, ?, 'confirmed')");
        $stmt->execute([$user_id, $trainer_id, $booking_date]);

        // Redirect to dashboard with success
        header("Location: dashboard.php?booking=success");
        exit();
    } catch (PDOException $e) {
        // Redirect with error
        header("Location: trainers.php?error=" . urlencode($e->getMessage()));
        exit();
    }
} else {
    header("Location: login.php");
    exit();
}
?>