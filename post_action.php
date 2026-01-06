<?php
session_start();
require_once 'config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $content = trim($_POST['content']);

    if (!empty($content)) {
        try {
            $stmt = $pdo->prepare("INSERT INTO posts (user_id, content) VALUES (?, ?)");
            $stmt->execute([$user_id, $content]);
            header("Location: social.php?success=posted");
            exit();
        } catch (PDOException $e) {
            header("Location: social.php?error=db");
            exit();
        }
    }
    header("Location: social.php");
    exit();
} else {
    header("Location: login.php");
    exit();
}
?>