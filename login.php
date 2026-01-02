<?php
session_start();
require_once 'config/db.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $conn->real_escape_string($_POST['email']);
    $password = $_POST['password'];

    $sql = "SELECT id, username, password, role FROM users WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            // Password correct, start session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            
            // Redirect based on role
            if ($user['role'] == 'admin') {
                header("Location: admin_dashboard.php");
            } else {
                header("Location: dashboard.php");
            }
            exit();
        } else {
            $error = "Invalid password!";
        }
    } else {
        $error = "User not found!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - GYM IMPACT</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        .auth-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #1A1A1A url('assets/images/bg-gym.jpg') no-repeat center center/cover;
            position: relative;
        }
        .auth-container::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(0, 0, 0, 0.7);
        }
        .auth-box {
            position: relative;
            background: #2C2C2C;
            padding: 40px;
            border-radius: 10px;
            width: 100%;
            max-width: 400px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.5);
            border-top: 5px solid var(--primary-color);
        }
        .auth-box h2 {
            color: var(--primary-color);
            text-align: center;
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            color: var(--text-color);
        }
        .form-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #444;
            border-radius: 5px;
            background: #1A1A1A;
            color: #fff;
        }
        .form-group input:focus {
            border-color: var(--primary-color);
            outline: none;
        }
        .alert {
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
            text-align: center;
            background: #ff4d4d;
            color: white;
        }
        .auth-footer {
            text-align: center;
            margin-top: 15px;
            color: var(--text-muted);
        }
        .auth-footer a {
            color: var(--primary-color);
        }
    </style>
</head>
<body>

<div class="auth-container">
    <div class="auth-box">
        <h2>Welcome Back</h2>
        
        <?php if ($error): ?>
            <div class="alert"><?php echo $error; ?></div>
        <?php endif; ?>

        <form action="login.php" method="POST">
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" class="btn" style="width: 100%;">Login</button>
        </form>
        
        <div class="auth-footer">
            Don't have an account? <a href="register.php">Sign up</a>
            <br><br>
            <a href="index.php"><i class="fas fa-arrow-left"></i> Back to Home</a>
        </div>
    </div>
</div>

<script src="assets/js/script.js"></script>
</body>
</html>
