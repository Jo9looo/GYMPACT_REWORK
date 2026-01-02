<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GYMPACT - Build Your Legacy</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700;900&display=swap" rel="stylesheet">
    <!-- Placeholder for generic icons or FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body>

    <!-- Header -->
    <header class="main-header">
        <div class="container header-content">
            <div class="logo">
                <i class="fas fa-bullseye"></i> GYM<span>PACT</span>
            </div>
            <nav class="main-nav">
                <ul>
                    <li><a href="#home">Home</a></li>
                    <li><a href="#membership">Membership</a></li>
                    <li><a href="#stories">Success Stories</a></li>
                    <li><a href="#about">About</a></li>
                    <li><a href="#blog">Blog</a></li>
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
                    <a href="login.php" class="btn btn-outline">Login</a>
                    <a href="register.php" class="btn">Join Now</a>
                <?php endif; ?>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section id="home" class="hero">
        <div class="container hero-content">
            <h4>Build Your Body & Fitness</h4>
            <h1>FLEXIBLE MEMBERSHIP PLANS TO SUIT YOUR LIFESTYLE</h1>
            <p>GymPact is the best place to build your body and fitness.</p>
            <div class="hero-buttons">
                <a href="register.php" class="btn">Get Started</a>
                <a href="#membership" class="btn btn-outline">View Plans</a>
            </div>
        </div>
    </section>

    <!-- Membership Plans -->
    <section id="membership" class="membership-section">
        <div class="container">
            <div class="section-header">
                <h2>Flexible Membership Plans<br>To Suit Your Lifestyle</h2>
            </div>

            <div class="plans-grid">
                <!-- Premium Plan -->
                <div class="plan-card premium">
                    <div class="plan-header">
                        <h3>Premium</h3>
                        <div class="price">$320<span>/month</span></div>
                        <a href="register.php" class="btn">Order now <i class="fas fa-arrow-right"></i></a>
                    </div>
                    <ul class="plan-features">
                        <li><i class="fas fa-check-circle"></i> Professional Trainers</li>
                        <li><i class="fas fa-check-circle"></i> All Facilities</li>
                        <li><i class="fas fa-check-circle"></i> Free Drinks and Supplement</li>
                        <li><i class="fas fa-check-circle"></i> Diet Program</li>
                    </ul>
                </div>

                <!-- Advanced Plan -->
                <div class="plan-card dark">
                    <h3>Advanced</h3>
                    <div class="price">$120<span>/month</span></div>
                    <p class="plan-desc">Includes all basic benefits plus unlimited classes and access to premium
                        amenities like the sauna and pool.</p>
                    <a href="register.php" class="btn">Order now <i class="fas fa-arrow-right"></i></a>
                </div>

                <!-- Basic Plan -->
                <div class="plan-card dark">
                    <h3>Basic</h3>
                    <div class="price">$70<span>/month</span></div>
                    <p class="plan-desc">Start your fitness journey today with GymPact and discover the benefits of our
                        Basic Membership.</p>
                    <a href="register.php" class="btn">Order now <i class="fas fa-arrow-right"></i></a>
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
                    <p>Hear from our satisfied members who have transformed their lives at GymPact.</p>

                    <div class="stats-row">
                        <div class="stat-box">
                            <h3>6,154</h3>
                            <p>Gym Members Since January 2024 - Up Until Now</p>
                        </div>
                        <div class="stat-box">
                            <h3>350</h3>
                            <p>Born a New Body Builder Champion Every Year</p>
                        </div>
                        <div class="stat-box">
                            <h3>90%</h3>
                            <p>Member get they fat burned in 3 - 6 months</p>
                        </div>
                        <div class="stat-box">
                            <h3>20%</h3>
                            <p>Mass Muscle is Increase in 6 - 12 Months Training</p>
                        </div>
                    </div>
                </div>

                <div class="stories-images">
                    <div class="story-img-card">
                        <!-- Placeholder image -->
                        <div class="img-placeholder" style="background-image: url('assets/images/story1.jpg');"></div>
                        <div class="play-btn"><i class="fas fa-play"></i></div>
                        <span class="badgex">David R.</span>
                    </div>
                    <div class="story-img-card">
                        <div class="img-placeholder" style="background-image: url('assets/images/story2.jpg');"></div>
                        <div class="play-btn"><i class="fas fa-play"></i></div>
                        <span class="badgex">Alex P.</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Newsletter -->
    <section class="newsletter-section">
        <div class="container newsletter-content">
            <div class="newsletter-text">
                <h2>SIGNUP OUR NEWSLETTER TO GET UPDATE INFORMATION, INSIGHT OR NEWS.</h2>
                <form class="newsletter-form">
                    <input type="email" placeholder="Email ...">
                    <button type="submit" class="btn">Subscribe</button>
                </form>
                <p class="privacy-text">We respect your privacy. Your information is safe and will never be shared.</p>
            </div>
            <div class="map-placeholder">
                <!-- Map image placeholder -->
                <img src="assets/images/map.png" alt="Gym Location Map" style="width: 100%; opacity: 0.5;">
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="main-footer">
        <div class="container footer-grid">
            <div class="footer-brand">
                <div class="logo">
                    <i class="fas fa-bullseye"></i> GYM<span>PACT</span>
                </div>
                <address>
                    9464 Columbia Ave.<br>
                    New York, NY 10029<br>
                    info@gympact.com
                </address>
                <div class="social-links">
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                </div>
            </div>

            <div class="footer-links">
                <h4>Menu</h4>
                <ul>
                    <li><a href="#">Home</a></li>
                    <li><a href="#">Membership</a></li>
                    <li><a href="#">About</a></li>
                    <li><a href="#">Blog</a></li>
                </ul>
            </div>
            <div class="footer-links">
                <h4>Quick Links</h4>
                <ul>
                    <li><a href="login.php">Login</a></li>
                    <li><a href="register.php">Register</a></li>
                    <li><a href="#">Contact Us</a></li>
                    <li><a href="#">Privacy Policy</a></li>
                </ul>
            </div>
            <div class="footer-info">
                <h4>Operational</h4>
                <p>Every day: 9:00 - 22:00</p>
                <p>Sat - Sun: 8:00 - 21:00</p>
                <h4>Now Schedule?</h4>
                <p>+ (123) 1800-567-8990</p>
            </div>
        </div>
        <div class="container copyright">
            <p>Copyright © GYMPACT. All Rights Reserved.</p>
            <a href="#" class="scroll-top"><i class="fas fa-arrow-up"></i></a>
        </div>
    </footer>

    <script src="assets/js/script.js"></script>
</body>

</html>