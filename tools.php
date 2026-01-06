<?php
session_start();
require_once 'config/db.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tools - GYMPACT</title>
    <!-- CSS -->
    <link rel="stylesheet" href="assets/css/style.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="assets/css/dropdown.css?v=<?php echo time(); ?>">
    <!-- Fonts & Icons -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .tools-hero {
            padding: 120px 0 60px;
            text-align: center;
            background: linear-gradient(rgba(0, 0, 0, 0.8), rgba(0, 0, 0, 0.8)), url('assets/images/hero-bg.jpg') center/cover;
        }

        .tools-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 40px;
            padding: 60px 0;
        }

        .tool-card {
            background: rgba(255, 255, 255, 0.05);
            /* Glass */
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            padding: 30px;
            border-radius: 15px;
            text-align: center;
        }

        .tool-card h3 {
            color: var(--primary-color);
            margin-bottom: 20px;
        }

        .bmi-result {
            margin-top: 20px;
            padding: 15px;
            border-radius: 8px;
            display: none;
            font-weight: bold;
        }

        .bmi-result.show {
            display: block;
            animation: fadeIn 0.5s;
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
    <section class="tools-hero">
        <div class="container" data-aos="fade-up">
            <h1 style="font-size: 3rem; margin-bottom: 20px;">Fitness <span
                    style="color:var(--primary-color)">Tools</span></h1>
            <p style="color: #ccc; max-width: 600px; margin: 0 auto;">Track your progress and calculate your metrics
                with our pro tools.</p>
        </div>
    </section>

    <!-- Tools Content -->
    <section class="container tools-grid">

        <!-- BMI Calculator -->
        <div class="tool-card" data-aos="fade-up">
            <i class="fas fa-weight" style="font-size: 3rem; color: #fff; margin-bottom: 20px;"></i>
            <h3>BMI Calculator</h3>
            <p style="margin-bottom: 20px; color: #aaa;">Calculate your Body Mass Index to understand your health
                status.</p>

            <form id="bmiForm" onsubmit="calculateBMI(event)">
                <div style="margin-bottom: 15px;">
                    <input type="number" id="weight" placeholder="Weight (kg)" required>
                </div>
                <div style="margin-bottom: 15px;">
                    <input type="number" id="height" placeholder="Height (cm)" required>
                </div>
                <button type="submit" class="btn" style="width: 100%;">Calculate BMI</button>
            </form>

            <div id="bmiResult" class="bmi-result"></div>
        </div>

        <!-- Calorie Calculator (Placeholder) -->
        <div class="tool-card" data-aos="fade-up" data-aos-delay="100">
            <i class="fas fa-fire" style="font-size: 3rem; color: #fff; margin-bottom: 20px;"></i>
            <h3>Calorie Calculator</h3>
            <p style="margin-bottom: 20px; color: #aaa;">Estimate your daily calorie needs based on activity.</p>
            <p style="color: var(--primary-color); font-weight: bold;">Coming Soon</p>
        </div>

    </section>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="assets/js/script.js"></script>
    <script>
        // Inline BMI Logic
        function calculateBMI(e) {
            e.preventDefault();
            const weight = parseFloat(document.getElementById('weight').value);
            const height = parseFloat(document.getElementById('height').value) / 100; // convert to meters

            if (weight > 0 && height > 0) {
                const bmi = (weight / (height * height)).toFixed(1);
                let message = '';
                let color = '';

                if (bmi < 18.5) {
                    message = 'Underweight';
                    color = '#3498db';
                } else if (bmi >= 18.5 && bmi < 25) {
                    message = 'Normal weight';
                    color = '#2ecc71';
                } else if (bmi >= 25 && bmi < 30) {
                    message = 'Overweight';
                    color = '#f1c40f';
                } else {
                    message = 'Obese';
                    color = '#e74c3c';
                }

                const resultDiv = document.getElementById('bmiResult');
                resultDiv.style.background = color;
                resultDiv.style.color = '#fff';
                resultDiv.innerHTML = `Your BMI: ${bmi} (${message})`;
                resultDiv.classList.add('show');
            }
        }
    </script>
</body>

</html>