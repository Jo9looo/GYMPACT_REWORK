<?php
session_start();
require_once 'config/db.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch all classes
$classes = $conn->query("SELECT * FROM classes ORDER BY schedule");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Class Catalog - GYMPACT</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        :root {
            --glass-bg: rgba(255, 255, 255, 0.05);
            --glass-border: rgba(255, 255, 255, 0.1);
            --card-hover-bg: rgba(255, 255, 255, 0.08);
        }

        body {
            background-color: #0F0F0F;
            /* Ultra dark background */
            background-image:
                radial-gradient(circle at 15% 50%, rgba(255, 229, 0, 0.03) 0%, transparent 25%),
                radial-gradient(circle at 85% 30%, rgba(255, 229, 0, 0.02) 0%, transparent 25%);
            color: #fff;
        }

        /* Hero Section */
        .catalog-hero {
            height: 400px;
            background: linear-gradient(to bottom, rgba(0, 0, 0, 0.3), #0F0F0F), url('assets/images/chestpress.webp');
            background-size: cover;
            background-position: center;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            position: relative;
        }

        .catalog-hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.6);
        }

        .hero-content {
            position: relative;
            z-index: 1;
            max-width: 800px;
            padding: 0 20px;
        }

        .hero-title {
            font-size: 3.5rem;
            font-weight: 900;
            text-transform: uppercase;
            margin-bottom: 15px;
            background: linear-gradient(45deg, #fff, #ccc);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .hero-subtitle {
            font-size: 1.2rem;
            color: #B0B0B0;
        }

        /* Filter Section */
        .filter-section {
            position: sticky;
            top: 70px;
            /* Below header */
            background: rgba(15, 15, 15, 0.95);
            backdrop-filter: blur(10px);
            padding: 20px 0;
            border-bottom: 1px solid #222;
            z-index: 100;
            margin-bottom: 40px;
        }

        .filter-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 20px;
        }

        .category-tabs {
            display: flex;
            gap: 10px;
            overflow-x: auto;
            padding-bottom: 5px;
            /* For scrollbar if needed */
        }

        .category-tabs::-webkit-scrollbar {
            height: 4px;
        }

        .cat-tab {
            padding: 8px 16px;
            border-radius: 30px;
            background: #1A1A1A;
            border: 1px solid #333;
            color: #888;
            cursor: pointer;
            font-size: 0.9rem;
            font-weight: 600;
            transition: all 0.3s;
            white-space: nowrap;
        }

        .cat-tab.active,
        .cat-tab:hover {
            background: var(--primary-color);
            color: #000;
            border-color: var(--primary-color);
        }

        .search-box {
            position: relative;
            width: 100%;
            max-width: 300px;
        }

        .search-box input {
            width: 100%;
            background: #1A1A1A;
            border: 1px solid #333;
            padding: 10px 15px 10px 40px;
            border-radius: 8px;
            color: #fff;
            font-family: 'Inter', sans-serif;
        }

        .search-box input:focus {
            outline: none;
            border-color: var(--primary-color);
        }

        .search-box i {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #666;
        }

        /* Grid Layout */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px 60px;
        }

        .classes-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 30px;
        }

        /* Class Card Modern */
        .class-card {
            background: var(--glass-bg);
            border: 1px solid var(--glass-border);
            border-radius: 16px;
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            position: relative;
            display: flex;
            flex-direction: column;
            backdrop-filter: blur(5px);
        }

        .class-card:hover {
            transform: translateY(-10px);
            border-color: rgba(255, 229, 0, 0.3);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
        }

        .card-image-wrapper {
            height: 200px;
            position: relative;
            overflow: hidden;
        }

        .card-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .class-card:hover .card-image {
            transform: scale(1.1);
        }

        .category-badge {
            position: absolute;
            top: 15px;
            right: 15px;
            background: rgba(0, 0, 0, 0.7);
            backdrop-filter: blur(4px);
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 700;
            color: var(--primary-color);
            border: 1px solid rgba(255, 229, 0, 0.3);
        }

        .card-content {
            padding: 25px;
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .card-title {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 15px;
            color: #fff;
        }

        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-bottom: 25px;
        }

        .info-item {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #B0B0B0;
            font-size: 0.85rem;
        }

        .info-item i {
            color: var(--primary-color);
        }

        .card-footer {
            margin-top: auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        .price {
            font-size: 1.5rem;
            font-weight: 800;
            color: #fff;
        }

        .price span {
            font-size: 0.8rem;
            font-weight: 400;
            color: #777;
        }

        .book-btn {
            padding: 10px 24px;
            background: var(--primary-color);
            color: #000;
            border-radius: 8px;
            font-weight: 700;
            border: none;
            cursor: pointer;
            transition: all 0.3s;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
        }

        .book-btn:hover {
            transform: scale(1.05);
            box-shadow: 0 0 15px rgba(255, 229, 0, 0.4);
        }

        /* Empty State */
        .no-results {
            grid-column: 1 / -1;
            text-align: center;
            padding: 60px;
            color: #666;
            background: rgba(255, 255, 255, 0.02);
            border-radius: 12px;
            border: 1px dashed #333;
        }

        /* Hero Adjustment for Fixed Header */
        .catalog-hero {
            margin-top: 70px;
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
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="catalog-hero">
        <div class="hero-content">
            <h1 class="hero-title">Browse Available Classes</h1>
            <p class="hero-subtitle">Find the perfect session to crush your fitness goals today.</p>
        </div>
    </section>

    <!-- Filters -->
    <section class="filter-section">
        <div class="filter-container">
            <div class="category-tabs" id="categoryFilters">
                <button class="cat-tab active" data-filter="all">All Classes</button>
                <button class="cat-tab" data-filter="strength">Strength</button>
                <button class="cat-tab" data-filter="cardio">Cardio</button>
                <button class="cat-tab" data-filter="yoga">Yoga</button>
                <button class="cat-tab" data-filter="pilates">Pilates</button>
                <button class="cat-tab" data-filter="hiit">HIIT</button>
            </div>
            <div class="search-box">
                <i class="fas fa-search"></i>
                <input type="text" id="searchInput" placeholder="Search by instructor or class...">
            </div>
        </div>
    </section>

    <!-- Grid -->
    <div class="container">
        <div class="classes-grid" id="classesGrid">
            <?php if ($classes->num_rows > 0): ?>
                <?php while ($class = $classes->fetch_assoc()): ?>
                    <!-- Class Card -->
                    <div class="class-card" data-category="<?php echo strtolower($class['category'] ?? 'general'); ?>"
                        data-name="<?php echo strtolower($class['name']); ?>"
                        data-instructor="<?php echo strtolower($class['instructor']); ?>">

                        <div class="card-image-wrapper">
                            <span class="category-badge"><?php echo htmlspecialchars($class['category'] ?? 'General'); ?></span>
                            <?php
                            $bgImage = 'assets/images/' . ($class['image'] && $class['image'] != 'default.jpg' ? $class['image'] : 'chestpress.webp');
                            // Fallback if no specific image, using the one we know exists or similar
                            ?>
                            <img src="<?php echo $bgImage; ?>" alt="<?php echo htmlspecialchars($class['name']); ?>"
                                class="card-image">
                        </div>

                        <div class="card-content">
                            <h3 class="card-title"><?php echo htmlspecialchars($class['name']); ?></h3>

                            <div class="info-grid">
                                <div class="info-item">
                                    <i class="fas fa-user-tie"></i>
                                    <span><?php echo htmlspecialchars($class['instructor']); ?></span>
                                </div>
                                <div class="info-item">
                                    <i class="far fa-clock"></i>
                                    <span><?php echo date('M d, H:i', strtotime($class['schedule'])); ?></span>
                                </div>
                                <div class="info-item">
                                    <i class="fas fa-users"></i>
                                    <span><?php echo $class['capacity']; ?> Spots</span>
                                </div>
                                <div class="info-item">
                                    <i class="fas fa-bolt"></i>
                                    <span>Intense</span>
                                </div>
                            </div>

                            <div class="card-footer">
                                <div class="price">$<?php echo number_format($class['price'], 0); ?><span>/session</span></div>
                                <button class="book-btn" onclick="window.location.href='dashboard.php'">Book Now</button>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="no-results">
                    <h3>No classes available at the moment.</h3>
                    <p>Please check back later for new schedules.</p>
                </div>
            <?php endif; ?>
        </div>
        <div id="noResultsMsg" class="no-results" style="display:none;">
            <h3>No matching classes found.</h3>
            <p>Try adjusting your search or filters.</p>
        </div>
    </div>

    <script>
        // Simple Filter Logic
        const tabs = document.querySelectorAll('.cat-tab');
        const searchInput = document.getElementById('searchInput');
        const cards = document.querySelectorAll('.class-card');
        const noResultsMsg = document.getElementById('noResultsMsg');

        let currentCategory = 'all';
        let currentSearch = '';

        function filterClasses() {
            let visibleCount = 0;

            cards.forEach(card => {
                const category = card.dataset.category;
                const name = card.dataset.name;
                const instructor = card.dataset.instructor;

                const matchesCategory = currentCategory === 'all' || category === currentCategory;
                const matchesSearch = name.includes(currentSearch) || instructor.includes(currentSearch);

                if (matchesCategory && matchesSearch) {
                    card.style.display = 'flex';
                    visibleCount++;
                } else {
                    card.style.display = 'none';
                }
            });

            noResultsMsg.style.display = visibleCount === 0 ? 'block' : 'none';
        }

        // Category Click
        tabs.forEach(tab => {
            tab.addEventListener('click', () => {
                // Remove active class from all
                tabs.forEach(t => t.classList.remove('active'));
                tab.classList.add('active');

                currentCategory = tab.dataset.filter.toLowerCase();
                filterClasses();
            });
        });

        // Search Input
        searchInput.addEventListener('input', (e) => {
            currentSearch = e.target.value.toLowerCase();
            filterClasses();
        });
    </script>
</body>

</html>