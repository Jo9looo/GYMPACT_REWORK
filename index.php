<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GYMPACT - Build Your Legacy</title>
    <!-- CSS -->
    <link rel="stylesheet" href="assets/css/style.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="assets/css/dropdown.css?v=<?php echo time(); ?>">
    <!-- Fonts & Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Removed AOS to prevent loading issues causing blank screens -->
</head>

<body>

    <!-- Header -->
    <header class="main-header">
        <div class="container header-content">
            <a href="index.php" class="logo">
                <i class="fas fa-bullseye"></i> GYM<span>PACT</span>
            </a>
            <nav class="main-nav">
                <ul>
                    <li><a href="#home" class="active">Home</a></li>
                    <li><a href="catalog.php">Catalog</a></li>
                    <li><a href="trainers.php">Trainers</a></li>
                    <li><a href="#membership">Membership</a></li>
                    <li><a href="#stories">Stories</a></li>
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

    <!-- Hero Section -->
    <section id="home" class="hero">
        <div class="container hero-content">
            <h4>Build Your Body & Fitness</h4>
            <h1>Flexible Membership Plans to Suit Your Lifestyle</h1>
            <p>GymPact is the best place to build your body and fitness with professional guidance.</p>
            <div class="hero-buttons">
                <a href="register.php" class="btn">Get Started</a>
                <a href="#membership" class="btn-outline">View Plans</a>
            </div>
        </div>
    </section>

    <!-- Membership Plans -->
    <section id="membership" class="membership-section">
        <div class="container">
            <div class="section-header">
                <span class="section-tag">Pricing</span>
                <h2>Choose Your Legacy</h2>
                <p style="color: #888; margin-top: 10px;">Transparent pricing. No hidden fees.</p>
            </div>

            <div class="plans-grid">
                <!-- Basic Plan -->
                <div class="plan-card glass-card">
                    <div class="plan-header">
                        <h3>Basic</h3>
                        <div class="price">$70<span>/month</span></div>
                        <p>Start your fitness journey today with GymPact and discover the benefits of our Basic
                            Membership.</p>
                    </div>
                    <ul class="plan-features">
                        <li><i class="fas fa-check-circle"></i> Access to Gym Floor</li>
                        <li><i class="fas fa-check-circle"></i> Locker Room Access</li>
                        <li><i class="fas fa-check-circle"></i> Free Wifi</li>
                        <li style="color: #444;"><i class="fas fa-times-circle" style="color:#444"></i> Personal Trainer
                        </li>
                    </ul>
                    <a href="catalog.php" class="btn-outline" style="margin-top: 30px;">Choose Basic</a>
                </div>

                <!-- Premium Plan -->
                <div class="plan-card glass-card premium">
                    <div class="plan-header">
                        <div style="text-align:right; margin-bottom:10px;"><span
                                style="background:var(--primary-color); color:#000; padding:4px 10px; border-radius:15px; font-weight:bold; font-size:0.8rem;">BEST
                                VALUE</span></div>
                        <h3 style="color:var(--primary-color)">Premium</h3>
                        <div class="price">$320<span>/month</span></div>
                        <p>Includes all benefits with a personal trainer to guide your diet and training program.</p>
                    </div>
                    <ul class="plan-features">
                        <li><i class="fas fa-check-circle"></i> <strong>Everything in Basic</strong></li>
                        <li><i class="fas fa-check-circle"></i> 5 Personal Training Sessions</li>
                        <li><i class="fas fa-check-circle"></i> Diet Program</li>
                        <li><i class="fas fa-check-circle"></i> Free Supplements</li>
                        <li><i class="fas fa-check-circle"></i> Sauna & Pool Access</li>
                    </ul>
                    <a href="catalog.php" class="btn" style="margin-top: 30px; width:100%;">Choose Premium</a>
                </div>

                <!-- Advanced Plan -->
                <div class="plan-card glass-card">
                    <div class="plan-header">
                        <h3>Advanced</h3>
                        <div class="price">$120<span>/month</span></div>
                        <p>Unlimited classes and access to premium amenities like the sauna and pool.</p>
                    </div>
                    <ul class="plan-features">
                        <li><i class="fas fa-check-circle"></i> <strong>Everything in Basic</strong></li>
                        <li><i class="fas fa-check-circle"></i> Unlimited Classes</li>
                        <li><i class="fas fa-check-circle"></i> Sauna Access</li>
                        <li><i class="fas fa-check-circle"></i> Guest Pass (1/month)</li>
                    </ul>
                    <a href="catalog.php" class="btn-outline" style="margin-top: 30px;">Choose Advanced</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Success Stories -->
    <section id="stories" class="stories-section">
        <div class="container">
            <div class="stories-grid">
                <div class="stories-content">
                    <div class="section-tag"><i class="fas fa-angle-double-right"></i> SUCCESS STORIES</div>
                    <h2>Don't just take our word for it.</h2>
                    <p style="color:#ccc; font-size:1.1rem; margin-bottom: 30px;">
                        Hear from our satisfied members who have transformed their lives at GymPact. We are dedicated to
                        results.
                    </p>

                    <div class="stats-row">
                        <div class="stat-box">
                            <h3>6k+</h3>
                            <p>Happy Members</p>
                        </div>
                        <div class="stat-box">
                            <h3>350</h3>
                            <p>Champions Made</p>
                        </div>
                        <div class="stat-box">
                            <h3>90%</h3>
                            <p>Success Rate</p>
                        </div>
                        <div class="stat-box">
                            <h3>20%</h3>
                            <p>Muscle Gain Avg</p>
                        </div>
                    </div>
                </div>

                <div class="stories-images">
                    <!-- USING CHESTPRESS AS PLACEHOLDER since story images are missing -->
                    <div class="story-img-card">
                        <div class="img-placeholder"
                            style="background-image: url('assets/images/chestpress.webp'); background-position: top center;">
                        </div>
                        <div class="play-btn"><i class="fas fa-play"></i></div>
                        <span class="badgex">David R. - Lost 30kg</span>
                    </div>
                    <div class="story-img-card">
                        <div class="img-placeholder"
                            style="background-image: url('assets/images/chestpress.webp'); background-position: center bottom;">
                        </div>
                        <div class="play-btn"><i class="fas fa-play"></i></div>
                        <span class="badgex">Alex P. - Bodybuilder</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" style="padding: 100px 0; background: #0f0f0f; text-align: center;">
        <div class="container">
            <div class="section-header">
                <span class="section-tag">About Us</span>
                <h2>Who We Are</h2>
            </div>

            <div class="glass-card" style="max-width: 800px; margin: 0 auto; padding: 40px;">
                <p style="font-size: 1.2rem; color: #ccc; margin-bottom: 30px;">
                    GymPact is more than just a gym. We are a community of dedicated individuals striving for greatness.
                    Founded in 2024, our mission is to provide the best equipment, expert guidance, and a supportive
                    environment.
                </p>
                <div style="display: flex; justify-content: center; gap: 20px;">
                    <a href="trainers.php" class="btn">Meet Trainers</a>
                    <a href="index.php" class="btn-outline">Contact Us</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Newsletter -->
    <section class="newsletter-section" style="padding: 80px 0; background: #050505;">
        <div class="container newsletter-content"
            style="display: flex; flex-wrap: wrap; gap: 50px; align-items: center;">
            <div class="newsletter-text" style="flex: 1; min-width: 300px;">
                <h2 style="font-size: 2.5rem; margin-bottom: 20px;">Join Our Newsletter</h2>
                <p style="color: #888; margin-bottom: 30px;">Get the latest updates, fitness tips, and exclusive offers
                    delivered straight to your inbox.</p>
                <form class="newsletter-form" style="display: flex; gap: 10px;">
                    <input type="email" placeholder="Enter your email..."
                        style="flex: 1; padding: 15px; border-radius: 5px; border: 1px solid #333; background: #1a1a1a; color: #fff;">
                    <button type="submit" class="btn">Subscribe</button>
                </form>
            </div>
            <!-- USING CHESTPRESS AS PLACEHOLDER for map to avoid iframe issues -->
            <div class="map-placeholder"
                style="flex: 1; min-width: 300px; height: 300px; background: url('assets/images/chestpress.webp') center/cover; border-radius: 15px; position: relative;">
                <div
                    style="position:absolute; inset:0; background:rgba(0,0,0,0.6); display:flex; align-items:center; justify-content:center;">
                    <span style="color: #fff; font-weight: bold; font-size: 1.2rem;"><i class="fas fa-map-marker-alt"
                            style="color:var(--primary-color)"></i> Visit Our Gym</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="main-footer">
        <div class="container footer-grid">
            <div class="footer-brand">
                <a href="index.php" class="logo" style="display:inline-flex;">
                    <i class="fas fa-bullseye"></i> GYM<span>PACT</span>
                </a>
                <address>
                    9464 Columbia Ave.<br>
                    New York, NY 10029<br>
                    <a href="mailto:info@gympact.com" style="color:var(--primary-color)">info@gympact.com</a>
                </address>
                <div class="social-links">
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-youtube"></i></a>
                </div>
            </div>

            <div class="footer-links">
                <h4>Menu</h4>
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="catalog.php">Catalog</a></li>
                    <li><a href="trainers.php">Trainers</a></li>
                    <li><a href="social.php">Community</a></li>
                </ul>
            </div>

            <div class="footer-links">
                <h4>Support</h4>
                <ul>
                    <li><a href="login.php">Login</a></li>
                    <li><a href="register.php">Register</a></li>
                    <li><a href="#">Contact Us</a></li>
                    <li><a href="#">Privacy Policy</a></li>
                </ul>
            </div>

            <div class="footer-info">
                <h4>Opening Hours</h4>
                <p>Weekdays: 9:00 - 22:00</p>
                <p>Weekends: 8:00 - 21:00</p>
                <h4 style="margin-top: 15px;">Call Us</h4>
                <p style="color: var(--primary-color); font-weight: bold;">(123) 1800-567-8990</p>
            </div>
        </div>
        <div class="container copyright">
            <p>Copyright © 2024 GYMPACT. All Rights Reserved.</p>
            <a href="#" class="scroll-top"><i class="fas fa-arrow-up"></i></a>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="assets/js/script.js"></script>
</body>

</html>