<?php
// admin/dashboard.php
require_once '../includes/db.php';
requireLogin();

// Get dashboard statistics
try {
    // Today's meals count
    $mealCountStmt = $pdo->prepare("SELECT COUNT(*) as count FROM daily_meals WHERE meal_date = CURDATE() AND is_active = TRUE");
    $mealCountStmt->execute();
    $todayMealsCount = $mealCountStmt->fetch()['count'];
    
    // Recent reservations count
    $reservationCountStmt = $pdo->prepare("SELECT COUNT(*) as count FROM reservations WHERE reservation_date >= CURDATE()");
    $reservationCountStmt->execute();
    $upcomingReservations = $reservationCountStmt->fetch()['count'];
    
    // Gallery images count
    $galleryCountStmt = $pdo->prepare("SELECT COUNT(*) as count FROM gallery_images");
    $galleryCountStmt->execute();
    $galleryImagesCount = $galleryCountStmt->fetch()['count'];
    
    // Recent reservations for display
    $recentReservationsStmt = $pdo->prepare("SELECT reservation_id, name, phone, guests, reservation_date, reservation_time, status FROM reservations WHERE reservation_date >= CURDATE() ORDER BY created_at DESC LIMIT 5");
    $recentReservationsStmt->execute();
    $recentReservations = $recentReservationsStmt->fetchAll();
    
    // Today's meals
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
    <title>Admin Dashboard - AUNTY CO'S KITCHEN</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600&family=Open+Sans:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Open Sans', sans-serif;
            background-color: #f8f9fa;
            color: #333;
            line-height: 1.6;
        }

        .admin-header {
            background: linear-gradient(135deg, #d4a574, #b8956a);
            color: white;
            padding: 1rem 0;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .header-content {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 20px;
        }

        .logo {
            font-family: 'Playfair Display', serif;
            font-size: 1.5rem;
            font-weight: 600;
        }

        .admin-nav {
            display: flex;
            gap: 20px;
            align-items: center;
        }

        .admin-nav a {
            color: white;
            text-decoration: none;
            padding: 8px 15px;
            border-radius: 5px;
            transition: background 0.3s ease;
        }

        .admin-nav a:hover {
            background: rgba(255,255,255,0.1);
        }

        .logout-btn {
            background: rgba(255,255,255,0.2);
            border: 1px solid rgba(255,255,255,0.3);
        }

        .logout-btn:hover {
            background: rgba(255,255,255,0.3);
        }

        .main-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 30px 20px;
        }

        .welcome-section {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            margin-bottom: 30px;
        }

        .welcome-section h1 {
            font-family: 'Playfair Display', serif;
            color: #d4a574;
            font-size: 2rem;
            margin-bottom: 10px;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            text-align: center;
            transition: transform 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .stat-card .icon {
            font-size: 3rem;
            color: #d4a574;
            margin-bottom: 15px;
        }

        .stat-card .number {
            font-size: 2.5rem;
            font-weight: 700;
            color: #333;
            margin-bottom: 5px;
        }

        .stat-card .label {
            color: #666;
            font-size: 1rem;
        }

        .action-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .action-card {
            background: white;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        }

        .action-card h3 {
            font-family: 'Playfair Display', serif;
            color: #d4a574;
            font-size: 1.3rem;
            margin-bottom: 15px;
        }

        .action-btn {
            display: inline-block;
            background: linear-gradient(135deg, #d4a574, #b8956a);
            color: white;
            padding: 12px 25px;
            text-decoration: none;
            border-radius: 8px;
            transition: all 0.3s ease;
            font-weight: 600;
            margin-right: 10px;
            margin-bottom: 10px;
        }

        .action-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(212, 165, 116, 0.3);
        }

        .secondary-btn {
            background: linear-gradient(135deg, #6c757d, #5a6268);
        }

        .recent-section {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
            gap: 20px;
        }

        .recent-card {
            background: white;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        }

        .recent-card h3 {
            font-family: 'Playfair Display', serif;
            color: #d4a574;
            margin-bottom: 20px;
            font-size: 1.3rem;
        }

        .meal-item, .reservation-item {
            padding: 15px;
            background: #f8f9fa;
            border-radius: 8px;
            margin-bottom: 10px;
            border-left: 4px solid #d4a574;
        }

        .meal-item:last-child, .reservation-item:last-child {
            margin-bottom: 0;
        }

        .meal-name {
            font-weight: 600;
            color: #333;
            margin-bottom: 5px;
        }

        .meal-price {
            color: #d4a574;
            font-weight: 600;
        }

        .reservation-name {
            font-weight: 600;
            color: #333;
        }

        .reservation-details {
            color: #666;
            font-size: 0.9rem;
            margin-top: 5px;
        }

        .status-badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
        }

        .status-pending {
            background: #fff3cd;
            color: #856404;
        }

        .status-confirmed {
            background: #d4edda;
            color: #155724;
        }

        .empty-state {
            text-align: center;
            color: #666;
            font-style: italic;
            padding: 20px;
        }

        @media (max-width: 768px) {
            .header-content {
                flex-direction: column;
                gap: 15px;
            }

            .admin-nav {
                flex-wrap: wrap;
                justify-content: center;
            }

            .stats-grid {
                grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            }

            .action-grid, .recent-section {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <header class="admin-header">
        <div class="header-content">
            <div class="logo">
                <i class="fas fa-utensils"></i> AUNTY CO'S KITCHEN Admin
            </div>
            <nav class="admin-nav">
                <a href="dashboard.php"><i class="fas fa-home"></i> Dashboard</a>
                <a href="update_menu.php"><i class="fas fa-utensils"></i> Update Menu</a>
                <a href="update_gallery.php"><i class="fas fa-images"></i> Gallery</a>
                <a href="view_reservations.php"><i class="fas fa-calendar"></i> Reservations</a>
                <a href="logout.php" class="logout-btn"><i class="fas fa-sign-out-alt"></i> Logout</a>
            </nav>
        </div>
    </header>

    <main class="main-content">
        <div class="welcome-section">
            <h1>Welcome back, <?php echo htmlspecialchars($_SESSION['admin_username']); ?>!</h1>
            <p>Manage your restaurant's daily meals, gallery, and reservations from this dashboard.</p>
        </div>

        <div class="stats-grid">
            <div class="stat-card">
                <div class="icon"><i class="fas fa-utensils"></i></div>
                <div class="number