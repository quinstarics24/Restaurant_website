<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}

require_once '../includes/db_connect.php';

// Use admin_username from session
$adminName = $_SESSION['admin_username'] ?? 'Admin';

// Initialize variables
$todayMealsCount = 0;
$upcomingReservations = 0;
$galleryImagesCount = 0;
$recentReservations = [];
$todayMeals = [];

// Get today's meals count (available menu items)
$mealCountQuery = "SELECT COUNT(*) as count FROM menu_items WHERE is_available = 1";
if ($mealResult = mysqli_query($conn, $mealCountQuery)) {
    $todayMealsCount = mysqli_fetch_assoc($mealResult)['count'];
}

// Get upcoming reservations count
$reservationCountQuery = "SELECT COUNT(*) as count FROM reservations WHERE reservation_date >= CURDATE()";
if ($resResult = mysqli_query($conn, $reservationCountQuery)) {
    $upcomingReservations = mysqli_fetch_assoc($resResult)['count'];
}

// Get gallery images count
$galleryCountQuery = "SELECT COUNT(*) as count FROM gallery_images";
if ($galleryResult = mysqli_query($conn, $galleryCountQuery)) {
    $galleryImagesCount = mysqli_fetch_assoc($galleryResult)['count'];
}

// Get recent reservations (last 5)
$recentReservationsQuery = "
    SELECT id, name, phone, guests, reservation_date, reservation_time, status
    FROM reservations
    WHERE reservation_date >= CURDATE()
    ORDER BY created_at DESC
    LIMIT 5
";
if ($recentResResult = mysqli_query($conn, $recentReservationsQuery)) {
    while ($row = mysqli_fetch_assoc($recentResResult)) {
        $recentReservations[] = $row;
    }
}

// Get available menu items (today's meals)
$todayMealsQuery = "SELECT name, price, description FROM menu_items WHERE is_available = 1 ORDER BY created_at DESC LIMIT 3";
if ($todayMealsResult = mysqli_query($conn, $todayMealsQuery)) {
    while ($row = mysqli_fetch_assoc($todayMealsResult)) {
        $todayMeals[] = $row;
    }
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
    <link rel="stylesheet" href="dashboard.css">
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
                <div class="stat-icon meals"><i class="fas fa-utensils"></i></div>
            </div>
            <div class="stat-value"><?php echo $todayMealsCount; ?><span style="font-size:1rem; color:var(--gray-500);">/3</span></div>
            <div class="stat-change"><?php echo $todayMealsCount >= 3 ? 'All meals set' : (3 - $todayMealsCount).' meals remaining'; ?></div>
        </div>

        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-title">Upcoming Reservations</div>
                <div class="stat-icon reservations"><i class="fas fa-calendar-check"></i></div>
            </div>
            <div class="stat-value"><?php echo $upcomingReservations; ?></div>
            <div class="stat-change">Active bookings</div>
        </div>

        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-title">Gallery Images</div>
                <div class="stat-icon gallery"><i class="fas fa-images"></i></div>
            </div>
            <div class="stat-value"><?php echo $galleryImagesCount; ?></div>
            <div class="stat-change">Total photos</div>
        </div>
    </div>

    <div class="content-grid">
        <div class="content-card">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-utensils"></i> Today's Menu</h3>
            </div>
            <div class="card-content">
                <?php if (!empty($todayMeals)): ?>
                    <div class="meal-list">
                        <?php foreach ($todayMeals as $index => $meal): ?>
                            <div class="meal-item">
                                <div class="meal-info">
                                    <h4><?php echo htmlspecialchars($meal['name']); ?></h4>
                                    <div class="meal-order">Special Meal <?php echo $index + 1; ?></div>
                                </div>
                                <div class="meal-price"><?php echo number_format($meal['price'], 0); ?> FCFA</div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="empty-state">
                        <i class="fas fa-utensils"></i>
                        <p>No meals available</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="content-card">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-calendar-check"></i> Recent Reservations</h3>
            </div>
            <div class="card-content">
                <?php if (!empty($recentReservations)): ?>
                    <div class="reservation-list">
                        <?php foreach ($recentReservations as $res): ?>
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
    // Auto-refresh every 5 minutes
    setTimeout(() => location.reload(), 300000);
</script>
</body>
</html>
