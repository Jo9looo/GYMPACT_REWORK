<?php
session_start();
require_once 'config/db.php';

// Check if user is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'user') {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$message = '';

// Handle Booking (After Payment)
if (isset($_POST['confirm_payment'])) {
    $class_id = $_POST['class_id'];

    // Check if already booked
    $check_sql = "SELECT id FROM bookings WHERE user_id = $user_id AND class_id = $class_id";
    if ($conn->query($check_sql)->num_rows > 0) {
        $message = "You have already booked this class.";
    } else {
        // Insert with 'paid' status
        $book_sql = "INSERT INTO bookings (user_id, class_id, status) VALUES ($user_id, $class_id, 'paid')";
        if ($conn->query($book_sql) === TRUE) {
            $message = "Payment successful! Class booked.";
        } else {
            $message = "Error booking class.";
        }
    }
}

// Handle Cancellation
if (isset($_POST['cancel_booking'])) {
    $booking_id = $_POST['booking_id'];
    $cancel_sql = "DELETE FROM bookings WHERE id = $booking_id AND user_id = $user_id";
    if ($conn->query($cancel_sql) === TRUE) {
        $message = "Booking cancelled.";
    } else {
        $message = "Error cancelling booking.";
    }
}

// Fetch User's Booked Classes
$my_bookings_sql = "SELECT b.id as booking_id, c.name, c.instructor, c.schedule, c.image, b.status 
                    FROM bookings b 
                    JOIN classes c ON b.class_id = c.id 
                    WHERE b.user_id = $user_id 
                    ORDER BY c.schedule";
$my_bookings = $conn->query($my_bookings_sql);

// Fetch All Available Classes
$classes_sql = "SELECT * FROM classes WHERE schedule > NOW() ORDER BY schedule";
$classes = $conn->query($classes_sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - GYM IMPACT</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/dropdown.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .dashboard-container {
            padding: 50px 0;
            min-height: 80vh;
        }

        .dashboard-header {
            margin-bottom: 40px;
        }

        .dashboard-header h1 {
            font-size: 2.5rem;
            color: var(--primary-color);
        }

        .dashboard-section {
            background: #2C2C2C;
            padding: 30px;
            border-radius: 15px;
            margin-bottom: 40px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        }

        .dashboard-section h2 {
            border-bottom: 2px solid #444;
            padding-bottom: 15px;
            margin-bottom: 25px;
            font-size: 1.8rem;
        }

        .class-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 25px;
        }

        .class-card {
            background: #1A1A1A;
            border-radius: 10px;
            overflow: hidden;
            transition: transform 0.3s;
            display: flex;
            flex-direction: column;
        }

        .class-card:hover {
            transform: translateY(-5px);
        }

        .class-img {
            height: 180px;
            background-color: #333;
            background-size: cover;
            background-position: center;
        }

        .class-info {
            padding: 20px;
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .class-info h3 {
            color: var(--primary-color);
            margin-bottom: 10px;
        }

        .class-meta {
            color: #ccc;
            font-size: 0.9rem;
            margin-bottom: 15px;
            flex: 1;
        }

        .class-meta i {
            width: 20px;
            color: var(--primary-color);
        }

        .alert-msg {
            background: rgba(255, 229, 0, 0.1);
            color: var(--primary-color);
            border: 1px solid var(--primary-color);
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
            font-weight: bold;
            text-align: center;
        }

        /* Payment Modal */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.8);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 2000;
            backdrop-filter: blur(5px);
        }

        .payment-modal {
            background: #222;
            width: 100%;
            max-width: 450px;
            padding: 30px;
            border-radius: 15px;
            border: 1px solid #444;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.5);
            animation: slideUp 0.3s ease;
        }

        .payment-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            border-bottom: 1px solid #333;
            padding-bottom: 15px;
        }

        .payment-details {
            background: #1A1A1A;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .pay-form input {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            background: #111;
            border: 1px solid #333;
            color: #fff;
            border-radius: 6px;
        }

        .card-icons {
            margin-bottom: 15px;
            font-size: 1.5rem;
            color: #666;
            display: gap;
            gap: 10px;
        }

        .status-badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 4px;
            font-size: 0.8rem;
            font-weight: bold;
            margin-top: 5px;
        }

        @keyframes slideUp {
            from {
                transform: translateY(50px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
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
                    <li><a href="index.php#membership">Membership</a></li>
                    <li><a href="index.php#stories">Success Stories</a></li>
                    <li><a href="index.php#about">About</a></li>
                    <li><a href="index.php#blog">Blog</a></li>
                </ul>
            </nav>
            <div class="header-actions">
                <div class="user-dropdown">
                    <button class="profile-btn">
                        <i class="fas fa-user-circle"></i>
                        <span>
                            <?php echo htmlspecialchars($_SESSION['username']); ?>
                        </span>
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="dropdown-content">
                        <a href="dashboard.php" style="color: var(--primary-color);"><i
                                class="fas fa-tachometer-alt"></i> Dashboard</a>
                        <a href="profile.php"><i class="fas fa-user"></i> My Profile</a>
                        <div class="divider"></div>
                        <a href="logout.php" class="logout-link"><i class="fas fa-sign-out-alt"></i> Logout</a>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div class="container dashboard-container">
        <div class="dashboard-header">
            <h1>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
            <p>Manage your fitness journey here.</p>
        </div>

        <?php if ($message): ?>
            <div class="alert-msg">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <!-- My Bookings -->
        <div class="dashboard-section">
            <h2><i class="fas fa-calendar-check"></i> My Booked Classes</h2>
            <?php if ($my_bookings->num_rows > 0): ?>
                <div class="class-grid">
                    <?php while ($booking = $my_bookings->fetch_assoc()): ?>
                        <div class="class-card">
                            <div class="class-img"
                                style="background-image: url('assets/images/<?php echo $booking['image']; ?>');"></div>
                            <div class="class-info">
                                <h3><?php echo htmlspecialchars($booking['name']); ?></h3>
                                <div class="class-meta">
                                    <p><i class="fas fa-user-tie"></i> <?php echo htmlspecialchars($booking['instructor']); ?>
                                    </p>
                                    <p><i class="far fa-clock"></i>
                                        <?php echo date('M d, H:i', strtotime($booking['schedule'])); ?></p>
                                    <span class="status-badge" style="background: rgba(0, 255, 100, 0.1); color: #00ff64;">
                                        <i class="fas fa-check"></i> <?php echo strtoupper($booking['status'] ?? 'PAID'); ?>
                                    </span>
                                </div>
                                <form method="POST">
                                    <input type="hidden" name="booking_id" value="<?php echo $booking['booking_id']; ?>">
                                    <button type="submit" name="cancel_booking" class="btn"
                                        style="background-color: transparent; border: 1px solid #ff4d4d; color: #ff4d4d; width: 100%;">Cancel
                                        Booking</button>
                                </form>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            <?php else: ?>
                <p style="color: #888;">You haven't booked any classes yet.</p>
            <?php endif; ?>
        </div>

        <!-- Available Classes -->
        <div class="dashboard-section">
            <h2><i class="fas fa-dumbbell"></i> Available Classes</h2>
            <?php if ($classes->num_rows > 0): ?>
                <div class="class-grid">
                    <?php while ($class = $classes->fetch_assoc()): ?>
                        <div class="class-card">
                            <div class="class-img"
                                style="background-image: url('assets/images/<?php echo $class['image']; ?>');"></div>
                            <div class="class-info">
                                <div style="display:flex; justify-content:space-between; align-items:flex-start;">
                                    <h3><?php echo htmlspecialchars($class['name']); ?></h3>
                                    <span
                                        style="background: var(--primary-color); color: #000; padding: 2px 6px; border-radius: 4px; font-weight: bold;">
                                        $<?php echo number_format($class['price'], 0); ?>
                                    </span>
                                </div>
                                <div class="class-meta">
                                    <p><i class="fas fa-user-tie"></i> <?php echo htmlspecialchars($class['instructor']); ?></p>
                                    <p><i class="far fa-clock"></i>
                                        <?php echo date('M d, H:i', strtotime($class['schedule'])); ?></p>
                                    <p><i class="fas fa-users"></i> Capacity: <?php echo $class['capacity']; ?></p>
                                </div>
                                <button
                                    onclick="openPaymentModal(<?php echo $class['id']; ?>, '<?php echo htmlspecialchars($class['name']); ?>', '<?php echo $class['price']; ?>')"
                                    class="btn" style="width: 100%;">
                                    Book This Class
                                </button>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            <?php else: ?>
                <p>No classes available at the moment.</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- Payment Modal -->
    <div class="modal-overlay" id="paymentModal">
        <div class="payment-modal">
            <div class="payment-header">
                <h3 style="margin:0;"><i class="fas fa-credit-card"></i> Payment</h3>
                <button onclick="closePaymentModal()"
                    style="background:none; border:none; color:#777; font-size:1.5rem; cursor:pointer;">&times;</button>
            </div>

            <div class="payment-details">
                <div>
                    <span style="display:block; font-size:0.8rem; color:#888;">Class</span>
                    <strong style="color:var(--primary-color);" id="payClassName">Yoga Class</strong>
                </div>
                <div style="text-align:right;">
                    <span style="display:block; font-size:0.8rem; color:#888;">Total</span>
                    <strong style="font-size:1.2rem;" id="payAmount">$15.00</strong>
                </div>
            </div>

            <form method="POST" class="pay-form" id="paymentForm" onsubmit="processPayment(event)">
                <input type="hidden" name="class_id" id="payClassId">
                <input type="hidden" name="confirm_payment" value="1">

                <div class="card-icons">
                    <i class="fab fa-cc-visa" style="color: #fff;"></i>
                    <i class="fab fa-cc-mastercard" style="color: #fff;"></i>
                    <i class="fab fa-cc-amex" style="color: #fff;"></i>
                </div>

                <input type="text" placeholder="Card Number" value="4242 4242 4242 4242" required>
                <div style="display:flex; gap:10px;">
                    <input type="text" placeholder="MM/YY" value="12/28" required>
                    <input type="text" placeholder="CVC" value="123" required>
                </div>

                <button type="submit" id="payBtn" class="btn" style="width:100%;">Pay & Book</button>
            </form>

            <p style="text-align:center; font-size:0.8rem; color:#555; margin-top:15px;">
                <i class="fas fa-lock"></i> Secure Payment Processing
            </p>
        </div>
    </div>

    <script src="assets/js/payment.js"></script>

</body>

</html>