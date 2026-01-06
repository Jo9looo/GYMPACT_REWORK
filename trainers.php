<?php
session_start();
require_once 'config/db.php';

// Fetch Trainers
$stmt = $pdo->query("SELECT * FROM trainers");
$trainers = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trainers - GYMPACT</title>
    <!-- CSS -->
    <link rel="stylesheet" href="assets/css/style.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="assets/css/dropdown.css?v=<?php echo time(); ?>">
    <!-- Fonts & Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .trainers-hero {
            padding: 120px 0 60px;
            text-align: center;
            background: linear-gradient(rgba(0, 0, 0, 0.8), rgba(0, 0, 0, 0.8)), url('assets/images/chestpress.webp') center/cover;
        }

        .trainer-card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 15px;
            overflow: hidden;
            transition: transform 0.3s;
            text-align: center;
            padding-bottom: 20px;
        }

        .trainer-card:hover {
            transform: translateY(-10px);
            border-color: var(--primary-color);
        }

        .trainer-img {
            width: 100%;
            height: 250px;
            object-fit: cover;
            background: #333;
        }

        .trainer-info {
            padding: 20px;
        }

        .trainer-name {
            color: var(--primary-color);
            font-size: 1.5rem;
            margin-bottom: 5px;
        }

        .trainer-specialty {
            color: #aaa;
            font-size: 0.9rem;
            margin-bottom: 20px;
        }

        .trainer-rate {
            font-size: 1.2rem;
            font-weight: bold;
            margin-bottom: 20px;
        }

        /* Modal */
        .modal {
            display: none;
            position: fixed;
            z-index: 2000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.8);
            backdrop-filter: blur(5px);
        }

        .modal-content {
            background: #1a1a1a;
            border: 1px solid #333;
            margin: 10% auto;
            padding: 30px;
            width: 90%;
            max-width: 500px;
            border-radius: 10px;
            position: relative;
        }

        .close-modal {
            position: absolute;
            top: 15px;
            right: 20px;
            color: #aaa;
            font-size: 28px;
            cursor: pointer;
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
                    <li><a href="trainers.php" class="active">Trainers</a></li>
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
    <section class="trainers-hero">
        <div class="container" data-aos="fade-up">
            <h1>Meet Our <span style="color:var(--primary-color)">Expert Trainers</span></h1>
            <p style="color: #ccc; max-width: 600px; margin: 0 auto;">Personalized coaching to help you smash your
                goals.</p>
        </div>
    </section>

    <!-- Trainers Grid -->
    <section class="container" style="padding: 50px 20px;">
        <div class="plans-grid">
            <?php foreach ($trainers as $trainer): ?>
                <div class="trainer-card" data-aos="fade-up">
                    <div class="trainer-img" style="background-image: url('assets/images/chestpress.webp');"></div>
                    <!-- Using placeholder -->
                    <div class="trainer-info">
                        <h3 class="trainer-name">
                            <?php echo htmlspecialchars($trainer['name']); ?>
                        </h3>
                        <div class="trainer-specialty">
                            <?php echo htmlspecialchars($trainer['specialty']); ?>
                        </div>
                        <p style="color: #aaa; margin-bottom: 15px;">
                            <?php echo htmlspecialchars($trainer['bio']); ?>
                        </p>
                        <div class="trainer-rate">$
                            <?php echo htmlspecialchars($trainer['rate']); ?> / hr
                        </div>

                        <button class="btn"
                            onclick="openBookingModal(<?php echo $trainer['id']; ?>, '<?php echo htmlspecialchars($trainer['name']); ?>', '<?php echo htmlspecialchars($trainer['rate']); ?>')">Book
                            Now</button>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- Booking Modal -->
    <div id="bookingModal" class="modal">
        <div class="modal-content">
            <span class="close-modal" onclick="closeModal()">&times;</span>
            <h2 style="margin-bottom: 20px;">Book Session</h2>
            <p>Trainer: <span id="modalTrainerName" style="color:var(--primary-color)"></span></p>
            <p>Rate: $<span id="modalTrainerRate"></span>/hr</p>

            <form action="book_trainer_action.php" method="POST" style="margin-top: 20px;">
                <input type="hidden" name="trainer_id" id="modalTrainerId">

                <div style="margin-bottom: 15px;">
                    <label>Select Date & Time</label>
                    <input type="datetime-local" name="booking_date" required min="<?php echo date('Y-m-d\TH:i'); ?>">
                </div>

                <?php if (isset($_SESSION['user_id'])): ?>
                    <button type="submit" class="btn" style="width: 100%;">Confirm Booking</button>
                <?php else: ?>
                    <div class="alert" style="background:#333; padding:10px; color:#fff; text-align:center;">
                        Please <a href="login.php" style="color:var(--primary-color)">login</a> to book.
                    </div>
                <?php endif; ?>
            </form>
        </div>
    </div>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="assets/js/script.js"></script>
    <script>
        const modal = document.getElementById('bookingModal');

        function openBookingModal(id, name, rate) {
            document.getElementById('modalTrainerId').value = id;
            document.getElementById('modalTrainerName').innerText = name;
            document.getElementById('modalTrainerRate').innerText = rate;
            modal.style.display = 'block';
        }

        function closeModal() {
            modal.style.display = 'none';
        }

        window.onclick = function (event) {
            if (event.target == modal) {
                closeModal();
            }
        }
    </script>
</body>

</html>