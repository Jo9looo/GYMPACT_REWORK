<?php
session_start();
require_once 'config/db.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$sql = "SELECT username, email, role, created_at FROM users WHERE id = $user_id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    echo "User not found.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile - GYM IMPACT</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700;900&display=swap" rel="stylesheet">
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/dropdown.css">
    <style>
        body {
            background-color: #121212;
            background-image: radial-gradient(circle at top right, rgba(255, 229, 0, 0.05), transparent 40%);
        }

        .profile-section {
            padding: 80px 0;
            min-height: 85vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .profile-card {
            background: rgba(44, 44, 44, 0.6);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            padding: 0;
            width: 100%;
            max-width: 800px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.5);
            overflow: hidden;
            position: relative;
        }

        .profile-cover {
            height: 150px;
            background: linear-gradient(90deg, #FFE500, #FFA500);
            position: relative;
            z-index: 1;
            /* Lower z-index */
        }

        .profile-content {
            padding: 0 40px 40px;
            margin-top: -60px;
            position: relative;
            /* Ensure it stays on top */
            z-index: 2;
            /* Higher z-index */
        }

        .profile-header-flex {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            margin-bottom: 30px;
        }

        .profile-avatar {
            width: 120px;
            height: 120px;
            background: #1A1A1A;
            border-radius: 50%;
            border: 5px solid #2C2C2C;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3.5rem;
            color: var(--primary-color);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
            position: relative;
            /* Fix for some browsers */
            z-index: 3;
        }

        .edit-btn {
            background: rgba(255, 255, 255, 0.1);
            color: #fff;
            border: 1px solid rgba(255, 255, 255, 0.2);
            padding: 8px 15px;
            border-radius: 20px;
            font-size: 0.9rem;
            cursor: pointer;
            transition: all 0.3s;
        }

        .edit-btn:hover {
            background: var(--primary-color);
            color: #000;
            border-color: var(--primary-color);
        }

        .user-identity h1 {
            font-size: 2.2rem;
            margin: 15px 0 5px;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .role-badge {
            background: var(--primary-color);
            color: #000;
            font-size: 0.7rem;
            padding: 3px 8px;
            border-radius: 4px;
            font-weight: 800;
            vertical-align: middle;
            letter-spacing: 1px;
        }

        .user-identity p {
            color: #B0B0B0;
            font-size: 1rem;
        }

        .stats-row {
            display: flex;
            gap: 40px;
            margin: 30px 0;
            padding: 20px 0;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .stat-item h3 {
            font-size: 1.5rem;
            color: #fff;
            margin-bottom: 5px;
        }

        .stat-item span {
            color: #777;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
        }

        .info-group label {
            display: block;
            color: #777;
            font-size: 0.85rem;
            margin-bottom: 8px;
            text-transform: uppercase;
            font-weight: 600;
        }

        .info-group .value {
            font-size: 1.1rem;
            color: #fff;
            background: rgba(0, 0, 0, 0.2);
            padding: 12px 15px;
            border-radius: 8px;
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .action-buttons {
            margin-top: 40px;
            display: flex;
            gap: 15px;
        }
    </style>
</head>

<body>

    <!-- Header -->
    <header class="main-header">
        <div class="container header-content">
            <a href="index.php" class="logo" style="text-decoration:none;"><i class="fas fa-bullseye"></i>
                GYM<span>PACT</span></a>
            <nav class="main-nav">
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="catalog.php">Catalog</a></li>
                    <li><a href="index.php#membership">Membership</a></li>
                    <li><a href="index.php#stories">Success Stories</a></li>
                    <li><a href="index.php#about">About</a></li>
                    <li><a href="index.php#blog">Blog</a></li>
                </ul>
            </nav>
            <div class="header-actions">
                <div class="user-dropdown">
                    <button class="profile-btn"
                        style="border-color: var(--primary-color); color: var(--primary-color);">
                        <i class="fas fa-user-circle"></i>
                        <span><?php echo htmlspecialchars($user['username']); ?></span>
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="dropdown-content">
                        <a href="dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
                        <a href="logout.php" class="logout-link"><i class="fas fa-sign-out-alt"></i> Logout</a>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div class="profile-section">
        <div class="profile-card">
            <div class="profile-cover"></div>

            <div class="profile-content">
                <div class="profile-header-flex">
                    <div class="profile-avatar">
                        <span style="font-weight:900;"><?php echo strtoupper(substr($user['username'], 0, 1)); ?></span>
                    </div>
                    <button class="edit-btn"><i class="fas fa-pen"></i> Edit Profile</button>
                </div>

                <div class="user-identity">
                    <h1>
                        <?php echo htmlspecialchars($user['username']); ?>
                        <span class="role-badge"><?php echo strtoupper($user['role']); ?></span>
                    </h1>
                    <p><i class="fas fa-envelope"></i> <?php echo htmlspecialchars($user['email']); ?></p>
                </div>

                <div class="stats-row">
                    <div class="stat-item">
                        <h3>Active</h3>
                        <span>Status</span>
                    </div>
                    <div class="stat-item">
                        <h3><?php echo date('Y'); ?></h3>
                        <span>Member Since</span>
                    </div>
                    <div class="stat-item">
                        <h3>0</h3>
                        <span>Bookings</span>
                    </div>
                </div>

                <div class="info-grid">
                    <div class="info-group">
                        <label>Member ID</label>
                        <div class="value">#<?php echo str_pad($user_id, 6, '0', STR_PAD_LEFT); ?></div>
                    </div>
                    <div class="info-group">
                        <label>Join Date</label>
                        <div class="value"><?php echo date('F j, Y', strtotime($user['created_at'])); ?></div>
                    </div>
                    <div class="info-group">
                        <label>Membership Plan</label>
                        <div class="value" style="color: var(--primary-color);">Premium Access</div>
                    </div>
                    <div class="info-group">
                        <label>Next Billing</label>
                        <div class="value">Automatic</div>
                    </div>
                </div>

                <div class="action-buttons">
                    <a href="dashboard.php" class="btn"><i class="fas fa-arrow-left"></i> Back to Dashboard</a>
                    <a href="logout.php" class="btn-outline"><i class="fas fa-sign-out-alt"></i> Logout</a>
                </div>
            </div>
        </div>
    </div>

</body>

</html>