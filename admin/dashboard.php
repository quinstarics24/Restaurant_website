<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}

require_once '../includes/db.php';

// Use admin_username from session
$adminName = $_SESSION['admin_username'] ?? 'Admin';

// Get dashboard statistics
try {
    $mealCountStmt = $pdo->prepare("SELECT COUNT(*) as count FROM daily_meals WHERE meal_date = CURDATE() AND is_active = TRUE");
    $mealCountStmt->execute();
    $todayMealsCount = $mealCountStmt->fetch()['count'];

    $reservationCountStmt = $pdo->prepare("SELECT COUNT(*) as count FROM reservations WHERE reservation_date >= CURDATE()");
    $reservationCountStmt->execute();
    $upcomingReservations = $reservationCountStmt->fetch()['count'];

    $galleryCountStmt = $pdo->prepare("SELECT COUNT(*) as count FROM gallery_images");
    $galleryCountStmt->execute();
    $galleryImagesCount = $galleryCountStmt->fetch()['count'];

    $recentReservationsStmt = $pdo->prepare("SELECT reservation_id, name, phone, guests, reservation_date, reservation_time, status FROM reservations WHERE reservation_date >= CURDATE() ORDER BY created_at DESC LIMIT 5");
    $recentReservationsStmt->execute();
    $recentReservations = $recentReservationsStmt->fetchAll();

    $todayMealsStmt = $pdo->prepare("SELECT meal_name, meal_price, meal_order FROM daily_meals WHERE meal_date = CURDATE() AND is_active = TRUE ORDER BY meal_order");
    $todayMealsStmt->execute();
    $todayMeals = $todayMealsStmt->fetchAll();

} catch (PDOException $e) {
    error_log("Dashboard query error: " . $e->getMessage());
    $todayMealsCount = 0;
    $upcomingReservations = 0;
    $galleryImagesCount = 0;
    $recentReservations = [];
    $todayMeals = [];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - AUNTY CO'S KITCHEN</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #d4a574;
            --primary-dark: #b8956a;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --info: #3b82f6;
            --gray-50: #f9fafb;
            --gray-100: #f3f4f6;
            --gray-200: #e5e7eb;
            --gray-300: #d1d5db;
            --gray-400: #9ca3af;
            --gray-500: #6b7280;
            --gray-600: #4b5563;
            --gray-700: #374151;
            --gray-800: #1f2937;
            --gray-900: #111827;
            --white: #ffffff;
            --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
            --shadow: 0 1px 3px 0 rgb(0 0 0 / 0.1), 0 1px 2px -1px rgb(0 0 0 / 0.1);
            --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
            --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
            --shadow-xl: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background-color: var(--gray-50);
            color: var(--gray-900);
            line-height: 1.6;
            font-weight: 400;
        }

        /* Main Content */
        .main {
            max-width: 1280px;
            margin: 0 auto;
            padding: 2rem;
        }

        .welcome {
            margin-bottom: 2rem;
        }

        .welcome h1 {
            font-size: 1.875rem;
            font-weight: 700;
            color: var(--gray-900);
            margin-bottom: 0.5rem;
        }

        .welcome p {
            color: var(--gray-600);
            font-size: 1rem;
        }

        /* Stats Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: var(--white);
            border: 1px solid var(--gray-200);
            border-radius: 0.75rem;
            padding: 1.5rem;
            box-shadow: var(--shadow-sm);
            transition: all 0.2s ease;
        }

        .stat-card:hover {
            box-shadow: var(--shadow-md);
            transform: translateY(-1px);
        }

        .stat-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 0.75rem;
        }

        .stat-title {
            font-size: 0.875rem;
            font-weight: 500;
            color: var(--gray-600);
        }

        .stat-icon {
            width: 2rem;
            height: 2rem;
            border-radius: 0.375rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.875rem;
        }

        .stat-icon.meals {
            background: #fef3c7;
            color: #d97706;
        }

        .stat-icon.reservations {
            background: #dbeafe;
            color: #2563eb;
        }

        .stat-icon.gallery {
            background: #ecfdf5;
            color: #059669;
        }

        .stat-value {
            font-size: 2rem;
            font-weight: 700;
            color: var(--gray-900);
            margin-bottom: 0.25rem;
        }

        .stat-change {
            font-size: 0.75rem;
            font-weight: 500;
            color: var(--gray-500);
        }

        /* Content Grid */
        .content-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
            gap: 2rem;
        }

        .content-card {
            background: var(--white);
            border: 1px solid var(--gray-200);
            border-radius: 0.75rem;
            box-shadow: var(--shadow-sm);
            overflow: hidden;
        }

        .card-header {
            padding: 1.5rem;
            border-bottom: 1px solid var(--gray-200);
            display: flex;
            align-items: center;
            justify-content: between;
        }

        .card-title {
            font-size: 1.125rem;
            font-weight: 600;
            color: var(--gray-900);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .card-content {
            padding: 1.5rem;
        }

        /* Meals */
        .meal-list {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        .meal-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.75rem;
            background: var(--gray-50);
            border-radius: 0.5rem;
            border-left: 3px solid var(--primary);
        }

        .meal-info h4 {
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--gray-900);
            margin-bottom: 0.25rem;
        }

        .meal-order {
            font-size: 0.75rem;
            color: var(--gray-500);
        }

        .meal-price {
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--primary);
        }

        /* Reservations */
        .reservation-list {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        .reservation-item {
            padding: 0.75rem;
            background: var(--gray-50);
            border-radius: 0.5rem;
            border-left: 3px solid var(--info);
        }

        .reservation-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 0.5rem;
        }

        .reservation-name {
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--gray-900);
        }

        .status-badge {
            padding: 0.25rem 0.5rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.025em;
        }

        .status-pending {
            background: #fef3c7;
            color: #92400e;
        }

        .status-confirmed {
            background: #d1fae5;
            color: #065f46;
        }

        .reservation-details {
            font-size: 0.75rem;
            color: var(--gray-600);
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .reservation-details span {
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 2rem 1rem;
            color: var(--gray-500);
        }

        .empty-state i {
            font-size: 2rem;
            color: var(--gray-300);
            margin-bottom: 0.75rem;
        }

        .empty-state p {
            font-size: 0.875rem;
        }

        /* Quick Actions */
        .quick-actions {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .action-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            padding: 0.75rem 1rem;
            background: var(--white);
            border: 1px solid var(--gray-200);
            border-radius: 0.5rem;
            color: var(--gray-700);
            text-decoration: none;
            font-weight: 500;
            font-size: 0.875rem;
            transition: all 0.2s ease;
            box-shadow: var(--shadow-sm);
        }

        .action-btn:hover {
            background: var(--gray-50);
            border-color: var(--primary);
            color: var(--primary);
            box-shadow: var(--shadow);
            transform: translateY(-1px);
        }

        .action-btn.primary {
            background: var(--primary);
            border-color: var(--primary);
            color: var(--white);
        }

        .action-btn.primary:hover {
            background: var(--primary-dark);
            border-color: var(--primary-dark);
            color: var(--white);
        }

        /* Responsive */
        @media (max-width: 768px) {
    
            .main {
                padding: 1rem;
            }

            .welcome h1 {
                font-size: 1.5rem;
            }

            .stats-grid {
                grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
                gap: 1rem;
            }

            .content-grid {
                grid-template-columns: 1fr;
                gap: 1.5rem;
            }

            .quick-actions {
                grid-template-columns: 1fr;
            }
        }

        /* Animation */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .stat-card, .content-card, .action-btn {
            animation: fadeIn 0.3s ease-out;
        }

        .stat-card:nth-child(1) { animation-delay: 0.1s; }
        .stat-card:nth-child(2) { animation-delay: 0.2s; }
        .stat-card:nth-child(3) { animation-delay: 0.3s; }
    </style>
</head>
<body>
     <?php include 'header.php'; ?>
     
    <main class="main">
        <div class="welcome">
            <h1>Welcome back, <?php echo htmlspecialchars($adminName); ?></h1>
            <p>Here's what's happening at your restaurant today</p>
        </div>

        <div class="quick-actions">
            <a href="update_menu.php" class="action-btn primary">
                <i class="fas fa-plus"></i>
                <span>Update Menu</span>
            </a>
            <a href="update_gallery.php" class="action-btn">
                <i class="fas fa-upload"></i>
                <span>Upload Photos</span>
            </a>
            <a href="view_reservations.php" class="action-btn">
                <i class="fas fa-eye"></i>
                <span>View Reservations</span>
            </a>
        </div>

        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-header">
                    <div class="stat-title">Today's Meals</div>
                    <div class="stat-icon meals">
                        <i class="fas fa-utensils"></i>
                    </div>
                </div>
                <div class="stat-value"><?php echo $todayMealsCount; ?><span style="font-size: 1rem; color: var(--gray-500);">/3</span></div>
                <div class="stat-change"><?php echo $todayMealsCount == 3 ? 'All meals set' : (3 - $todayMealsCount) . ' meals remaining'; ?></div>
            </div>

            <div class="stat-card">
                <div class="stat-header">
                    <div class="stat-title">Upcoming Reservations</div>
                    <div class="stat-icon reservations">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                </div>
                <div class="stat-value"><?php echo $upcomingReservations; ?></div>
                <div class="stat-change">Active bookings</div>
            </div>

            <div class="stat-card">
                <div class="stat-header">
                    <div class="stat-title">Gallery Images</div>
                    <div class="stat-icon gallery">
                        <i class="fas fa-images"></i>
                    </div>
                </div>
                <div class="stat-value"><?php echo $galleryImagesCount; ?></div>
                <div class="stat-change">Total photos</div>
            </div>
        </div>

        <div class="content-grid">
            <div class="content-card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-utensils"></i>
                        Today's Menu
                    </h3>
                </div>
                <div class="card-content">
                    <?php if (!empty($todayMeals)): ?>
                        <div class="meal-list">
                            <?php foreach ($todayMeals as $meal): ?>
                                <div class="meal-item">
                                    <div class="meal-info">
                                        <h4><?php echo htmlspecialchars($meal['meal_name']); ?></h4>
                                        <div class="meal-order">Special Meal <?php echo $meal['meal_order']; ?></div>
                                    </div>
                                    <div class="meal-price"><?php echo number_format($meal['meal_price'], 0); ?> FCFA</div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <?php if ($todayMealsCount < 3): ?>
                            <div style="margin-top: 1rem; padding: 0.75rem; background: #fef3c7; border-radius: 0.5rem; border-left: 3px solid #f59e0b;">
                                <p style="font-size: 0.875rem; color: #92400e; margin: 0;">
                                    <i class="fas fa-exclamation-triangle"></i>
                                    <?php echo (3 - $todayMealsCount); ?> more meal(s) needed for today
                                </p>
                            </div>
                        <?php endif; ?>
                    <?php else: ?>
                        <div class="empty-state">
                            <i class="fas fa-utensils"></i>
                            <p>No meals set for today</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="content-card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-calendar-check"></i>
                        Recent Reservations
                    </h3>
                </div>
                <div class="card-content">
                    <?php if (!empty($recentReservations)): ?>
                        <div class="reservation-list">
                            <?php foreach (array_slice($recentReservations, 0, 5) as $res): ?>
                                <div class="reservation-item">
                                    <div class="reservation-header">
                                        <div class="reservation-name"><?php echo htmlspecialchars($res['name']); ?></div>
                                        <div class="status-badge status-<?php echo strtolower($res['status']); ?>">
                                            <?php echo htmlspecialchars(ucfirst($res['status'])); ?>
                                        </div>
                                    </div>
                                    <div class="reservation-details">
                                        <span><i class="fas fa-users"></i> <?php echo (int)$res['guests']; ?> guests</span>
                                        <span><i class="fas fa-calendar"></i> <?php echo date('M j', strtotime($res['reservation_date'])); ?></span>
                                        <span><i class="fas fa-clock"></i> <?php echo date('g:i A', strtotime($res['reservation_time'])); ?></span>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div class="empty-state">
                            <i class="fas fa-calendar"></i>
                            <p>No recent reservations</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </main>

    <script>
        // Auto-refresh dashboard every 5 minutes
        setTimeout(() => location.reload(), 300000);

        // Add smooth transitions
        document.addEventListener('DOMContentLoaded', () => {
            const cards = document.querySelectorAll('.stat-card, .content-card');
            cards.forEach((card, index) => {
                card.style.animationDelay = `${index * 0.1}s`;
            });
        });

        // Update time display
        function updateTime() {
            const now = new Date();
            const timeString = now.toLocaleString('en-US', {
                month: 'long',
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            });
            
            const welcomeP = document.querySelector('.welcome p');
            if (welcomeP && !welcomeP.dataset.timeAdded) {
                welcomeP.innerHTML += ` • ${timeString}`;
                welcomeP.dataset.timeAdded = true;
            }
        }

        updateTime();
        setInterval(updateTime, 60000);
    </script>
</body>
</html>