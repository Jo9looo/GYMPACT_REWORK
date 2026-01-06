<?php
session_start();
require_once 'config/db.php';

// Fetch Posts
$stmt = $pdo->query("SELECT posts.*, users.username FROM posts JOIN users ON posts.user_id = users.id ORDER BY posts.created_at DESC");
$posts = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Community - GYMPACT</title>
    <!-- CSS -->
    <link rel="stylesheet" href="assets/css/style.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="assets/css/dropdown.css?v=<?php echo time(); ?>">
    <!-- Fonts & Icons -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .social-hero {
            padding: 100px 0 40px;
            text-align: center;
            background: rgba(26, 26, 26, 0.95);
        }

        .feed-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        .create-post-card {
            background: rgba(44, 44, 44, 0.4);
            backdrop-filter: blur(5px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            padding: 20px;
            border-radius: 12px;
            margin-bottom: 40px;
        }

        .post-card {
            background: #252525;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 20px;
            border: 1px solid #333;
            animation: fadeIn 0.5s;
        }

        .post-header {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
            gap: 10px;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            background: var(--primary-color);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #000;
            font-weight: bold;
        }

        .post-actions {
            margin-top: 15px;
            padding-top: 15px;
            border-top: 1px solid #333;
            display: flex;
            gap: 20px;
            color: #aaa;
        }

        .action-btn {
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 5px;
            transition: color 0.3s;
        }

        .action-btn:hover {
            color: var(--primary-color);
        }
    </style>
</head>

<body>

    <!-- Header -->
    <header class="main-header">
        <div class="container header-content">
            <a href="index.php" class="logo" style="text-decoration:none;">
                <i class="fas fa-bullseye"></i> GYM<span>PACT</span>
            </a>
            <nav class="main-nav">
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="catalog.php">Catalog</a></li>
                    <li><a href="trainers.php">Trainers</a></li>
                    <li><a href="index.php#membership">Membership</a></li>
                    <li><a href="index.php#stories">Stories</a></li>
                </ul>
            </nav>
            <div class="header-actions">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <div class="user-dropdown">
                        <button class="profile-btn">
                            <i class="fas fa-user-circle"></i>
                            <span><?php echo htmlspecialchars($_SESSION['username']); ?></span>
                            <i class="fas fa-chevron-down"></i>
                        </button>
                        <div class="dropdown-content">
                            <a href="dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
                            <a href="profile.php"><i class="fas fa-user"></i> My Profile</a>
                            <div class="divider"></div>
                            <a href="logout.php" class="logout-link"><i class="fas fa-sign-out-alt"></i> Logout</a>
                        </div>
                    </div>
                <?php else: ?>
                    <a href="login.php" class="btn-outline">Login</a>
                    <a href="register.php" class="btn">Join Now</a>
                <?php endif; ?>
            </div>
        </div>
    </header>

    <!-- Hero -->
    <section class="social-hero">
        <div class="container" data-aos="fade-down">
            <h1>GymPact <span style="color:var(--primary-color)">Community</span></h1>
            <p>Share your progress, motivate others.</p>
        </div>
    </section>

    <div class="container feed-container">

        <!-- Create Post -->
        <?php if (isset($_SESSION['user_id'])): ?>
            <div class="create-post-card" data-aos="fade-up">
                <form action="post_action.php" method="POST">
                    <textarea name="content" rows="3" placeholder="What's on your mind? Share your workout..."
                        required></textarea>
                    <div style="text-align: right; margin-top: 10px;">
                        <button type="submit" class="btn">Post</button>
                    </div>
                </form>
            </div>
        <?php else: ?>
            <div class="alert"
                style="text-align:center; margin-bottom: 30px; background: rgba(255,229,0,0.1); padding: 15px; border-radius: 8px;">
                <a href="login.php" style="color:var(--primary-color); font-weight:bold;">Login</a> to share your stories!
            </div>
        <?php endif; ?>

        <!-- Feed -->
        <?php foreach ($posts as $post): ?>
            <div class="post-card">
                <div class="post-header">
                    <div class="user-avatar">
                        <?php echo strtoupper(substr($post['username'], 0, 1)); ?>
                    </div>
                    <div>
                        <div style="font-weight: bold; color: #fff;">
                            <?php echo htmlspecialchars($post['username']); ?>
                        </div>
                        <div style="font-size: 0.8rem; color: #666;">
                            <?php echo date('M d, Y h:i A', strtotime($post['created_at'])); ?>
                        </div>
                    </div>
                </div>
                <div class="post-content">
                    <?php echo nl2br(htmlspecialchars($post['content'])); ?>
                </div>
                <div class="post-actions">
                    <div class="action-btn"><i class="far fa-heart"></i>
                        <?php echo $post['likes']; ?> Likes
                    </div>
                    <div class="action-btn"><i class="far fa-comment"></i> Comment</div>
                </div>
            </div>
        <?php endforeach; ?>

    </div>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="assets/js/script.js"></script>
</body>

</html>