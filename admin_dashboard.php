<?php
session_start();
require_once 'config/db.php';

// Check if user is logged in and is ADMIN
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

$message = '';

// Add New Class
if (isset($_POST['add_class'])) {
    $name = $conn->real_escape_string($_POST['name']);
    $description = $conn->real_escape_string($_POST['description']);
    $instructor = $conn->real_escape_string($_POST['instructor']);
    $schedule = $_POST['schedule'];
    $capacity = $_POST['capacity'];
    $price = $_POST['price'];
    $category = $conn->real_escape_string($_POST['category']);

    // Simple image handling (placeholder for now)
    $image = 'default.jpg';

    // If description is empty, use default
    if (empty($description)) {
        $description = "Join our " . $name . " class to improve your fitness.";
    }

    $sql = "INSERT INTO classes (name, description, instructor, schedule, capacity, price, category, image) 
            VALUES ('$name', '$description', '$instructor', '$schedule', $capacity, '$price', '$category', '$image')";

    if ($conn->query($sql) === TRUE) {
        $message = "Class added successfully!";
        echo "<script>if ( window.history.replaceState ) { window.history.replaceState( null, null, window.location.href ); }</script>";
    } else {
        $message = "Error: " . $conn->error;
    }
}

// Delete Class
if (isset($_POST['delete_class'])) {
    $class_id = $_POST['class_id'];
    $conn->query("DELETE FROM classes WHERE id=$class_id");
    $message = "Class deleted.";
}

// Fetch Data
$classes = $conn->query("SELECT * FROM classes ORDER BY schedule");
$users = $conn->query("SELECT * FROM users ORDER BY created_at DESC");

// Stats Counts
$class_count = $conn->query("SELECT COUNT(*) as count FROM classes")->fetch_assoc()['count'];
$user_count = $conn->query("SELECT COUNT(*) as count FROM users")->fetch_assoc()['count'];
$admin_count = $conn->query("SELECT COUNT(*) as count FROM users WHERE role='admin'")->fetch_assoc()['count'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - GYMPACT</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;900&display=swap" rel="stylesheet">
    <!-- Icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/admin.css"> <!-- Admin Specific Styles -->
</head>

<body>

    <div class="admin-wrapper">
        <!-- Sidebar -->
        <nav class="sidebar">
            <div class="sidebar-header">
                <div class="logo"><i class="fas fa-bullseye"></i> GYM<span>PACT</span></div>
            </div>

            <div class="sidebar-nav">
                <a href="#" class="nav-item active">
                    <i class="fas fa-th-large"></i> Dashboard
                </a>
                <a href="#classes-section" class="nav-item">
                    <i class="fas fa-dumbbell"></i> Classes
                </a>
                <a href="#users-section" class="nav-item">
                    <i class="fas fa-users"></i> Users
                </a>
                <a href="#" class="nav-item">
                    <i class="fas fa-cog"></i> Settings
                </a>
            </div>

            <div class="sidebar-footer">
                <a href="logout.php" class="btn-outline"
                    style="display:block; text-align:center; padding: 10px; border-color: #444; color: #fff;">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="main-content">

                <!-- Header Mobile Toggle (Optional) -->
        <div style="margin-bottom: 30px;">
            <p style="color: #666;">Welcome back,</p>
            <h1 style="color: #fff;">Admin Dashboard</h1>
        </div>

        <?php if ($message): ?>
                <div style="background: rgba(255, 229, 0, 0.1); border: 1px solid var(--primary-color); color: var(--primary-color); padding: 15px; border-radius: 8px; margin-bottom: 30px;">
                    <i class="fas fa-info-circle"></i> <?php echo $message; ?>
                </div>
        <?php endif; ?>

        <!-- Stats Grid -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-dumbbell"></i>
                </div>
                <div class="stat-info">
                    <h3><?php echo $class_count; ?></h3>
                    <p>Active Classes</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-info">
                    <h3><?php echo $user_count; ?></h3>
                    <p>Total Members</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-user-shield"></i>
                </div>
                <div class="stat-info">
                    <h3><?php echo $admin_count; ?></h3>
                    <p>Admins</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-chart-line"></i>
                </div>
                <div class="stat-info">
                    <h3>+12%</h3>
                    <p>Growth</p>
                </div>
            </div>
        </div>

            <!-- Classes Section -->
            <section id="classes-section">
                <div class="section-header-flex">
                    <div class="section-title">
                        <h2>Manage Classes</h2>
                        <p>Schedule and organize gym sessions</p>
                    </div>
                    <button class="btn" onclick="openModal()">
                        <i class="fas fa-plus"></i> Add New Class
                    </button>
                </div>

                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Class Name</th>
                                <th>Category</th>
                                <th>Instructor</th>
                                <th>Schedule</th>
                                <th>Price</th>
                                <th>Capacity</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($class = $classes->fetch_assoc()): ?>
                                <tr>
                                    <td>#<?php echo $class['id']; ?></td>
                                    <td style="font-weight: 600; color: #fff;">
                                        <?php echo htmlspecialchars($class['name']); ?></td>
                                    <td><span class="status-badge"
                                            style="background:#333; color:#ccc;"><?php echo htmlspecialchars($class['category'] ?? 'General'); ?></span>
                                    </td>
                                    <td><?php echo htmlspecialchars($class['instructor']); ?></td>
                                    <td><?php echo date('M d, H:i', strtotime($class['schedule'])); ?></td>
                                    <td>$<?php echo number_format($class['price'], 2); ?></td>
                                    <td><?php echo $class['capacity']; ?></td>
                                    <td>
                                        <form method="POST" onsubmit="return confirm('Delete this class?');"
                                            style="display:inline;">
                                            <input type="hidden" name="class_id" value="<?php echo $class['id']; ?>">
                                            <button type="submit" name="delete_class"
                                                style="background:none; border:none; color: #ff4d4d; cursor:pointer;"
                                                title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endwhile; ?>

                            <?php if ($class_count == 0): ?>
                                <tr>
                                    <td colspan="8" style="text-align:center; padding: 40px; color: #666;">No classes
                                        scheduled yet.
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </section>

                <!-- Divider -->
        <div style="height: 50px;"></div>

        <!-- Users Section -->
        <section id="users-section">
            <div class="section-header-flex">
                <div class="section-title">
                    <h2>Recent Members</h2>
                    <p>Latest registered users</p>
                </div>
                <button class="btn-outline" style="border-color:#444; font-size:0.8rem;">View All</button>
            </div>

            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>User ID</th>
                            <th>Username</th>
                            <th>Email Address</th>
                            <th>Role</th>
                            <th>Join Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($u = $users->fetch_assoc()): ?>
                                <tr>
                                    <td>#<?php echo $u['id']; ?></td>
                                    <td>
                                        <div style="display:flex; align-items:center; gap:10px;">
                                            <div style="width:30px; height:30px; background:#333; border-radius:50%; display:flex; align-items:center; justify-content:center; color:var(--primary-color);">
                                                <?php echo strtoupper(substr($u['username'], 0, 1)); ?>
                                            </div>
                                            <?php echo htmlspecialchars($u['username']); ?>
                                        </div>
                                    </td>
                                    <td><?php echo htmlspecialchars($u['email']); ?></td>
                                    <td>
                                        <?php if ($u['role'] === 'admin'): ?>
                                                <span class="status-badge status-admin">ADMIN</span>
                                        <?php else: ?>
                                                <span class="status-badge status-user">MEMBER</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo date('M d, Y', strtotime($u['created_at'])); ?></td>
                                </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </section>

        </main>
    </div>

    <!-- Modal -->
    <div class="modal-overlay" id="addModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 style="margin:0;">Add New Class</h3>
                <button class="close-modal" onclick="closeModal()">&times;</button>
            </div>

            <form method="POST" class="admin-form">
                <div style="display:grid; grid-template-columns: 2fr 1fr; gap:15px;">
                    <div>
                        <label style="display:block; margin-bottom:5px; font-size:0.9rem; color:#B0B0B0;">Class
                            Name</label>
                        <input type="text" name="name" placeholder="e.g. Advanced Yoga" required>
                    </div>
                    <div>
                        <label
                            style="display:block; margin-bottom:5px; font-size:0.9rem; color:#B0B0B0;">Category</label>
                        <select name="category" required
                            style="width:100%; padding:10px; background:#1A1A1A; border:1px solid #333; color:#fff; border-radius:5px;">
                            <option value="Strength">Strength</option>
                            <option value="Cardio">Cardio</option>
                            <option value="Yoga">Yoga</option>
                            <option value="Pilates">Pilates</option>
                            <option value="HIIT">HIIT</option>
                            <option value="General">General</option>
                        </select>
                    </div>
                </div>

                <label style="display:block; margin-bottom:5px; font-size:0.9rem; color:#B0B0B0;">Instructor</label>
                <input type="text" name="instructor" placeholder="Instructor Name" required>

                <div style="display:grid; grid-template-columns: 1fr 1fr 1fr; gap:15px;">
                    <div>
                        <label
                            style="display:block; margin-bottom:5px; font-size:0.9rem; color:#B0B0B0;">Schedule</label>
                        <input type="datetime-local" name="schedule" required>
                    </div>
                    <div>
                        <label style="display:block; margin-bottom:5px; font-size:0.9rem; color:#B0B0B0;">Price
                            ($)</label>
                        <input type="number" step="0.01" name="price" value="15.00" required>
                    </div>
                    <div>
                        <label
                            style="display:block; margin-bottom:5px; font-size:0.9rem; color:#B0B0B0;">Capacity</label>
                        <input type="number" name="capacity" value="20" required>
                    </div>
                </div>

                <label style="display:block; margin-bottom:5px; font-size:0.9rem; color:#B0B0B0;">Description
                    (Optional)</label>
                <textarea name="description" rows="3" placeholder="Brief description of the class..."></textarea>

                <button type="submit" name="add_class" class="btn" style="width:100%;">Create Class</button>
            </form>
        </div>
    </div>

    <script>
        function openModal() {
            document.getElementById('addModal').style.display = 'flex';
        }

        function closeModal() {
            document.getElementById('addModal').style.display = 'none';
        }

        // Close on outside click
        window.onclick = function (event) {
            if (event.target == document.getElementById('addModal')) {
                closeModal();
            }
        }
    </script>

</body>

</html>