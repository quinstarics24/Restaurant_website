<?php
// menu.php
require 'includes/db_connect.php'; // $conn is set here

// Fetch all available meals
$sql = "SELECT * FROM menu_items WHERE is_available = 1 ORDER BY created_at DESC";
$result = mysqli_query($conn, $sql);
$meals = [];
if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $meals[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu - AUNTY CO'S KITCHEN</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Open+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="css/menu.css">
</head>
<body>
<?php include 'header.php'; ?>

<section class="hero">
    <div class="container">
        <h1>Today's Special Meals</h1>
        <p>Three specially crafted meals available all day at Micah Hotel</p>
        <p>Each meal is carefully prepared with fresh ingredients and traditional recipes that have been perfected over time. Available throughout the day for your convenience.</p>
    </div>
</section>

<section class="menu-section">
    <div class="container">
        
        <div class="menu-grid">
            <?php if (!empty($meals)): ?>
                <?php foreach ($meals as $meal): ?>
                    <div class="menu-item">
                        <div class="menu-item-image">
                            <!-- Corrected image path -->
                            <img src="uploads/meals/<?php echo htmlspecialchars($meal['image']); ?>" 
                                 alt="<?php echo htmlspecialchars($meal['name']); ?>" loading="lazy">
                            <div class="price-badge"><?php echo number_format($meal['price']); ?> FCFA</div>
                        </div>
                        <div class="menu-item-content">
                            <h3><?php echo htmlspecialchars($meal['name']); ?></h3>
                            <p class="menu-item-description"><?php echo htmlspecialchars($meal['description']); ?></p>
                            <div class="menu-item-features">
                                <span class="feature-tag"><i class="fas fa-clock"></i> Available Today</span>
                            </div>
                            <button class="order-button" onclick="orderMeal('<?php echo htmlspecialchars($meal['name']); ?>', <?php echo $meal['price']; ?>)">
                                <i class="fas fa-shopping-cart"></i> Order Now
                            </button>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No meals available today. Please check back later!</p>
            <?php endif; ?>
        </div>
    </div>
</section>

<section class="cta-section">
    <div class="container">
        <h2>Ready to Experience Our Delicious Meals?</h2>
        <p>Visit us at Micah Hotel or make a reservation to secure your table</p>
        <div class="cta-buttons">
            <a href="reservations.php" class="cta-button"><i class="fas fa-calendar-check"></i> Make Reservation</a>
            <a href="contact.php" class="cta-button"><i class="fas fa-phone"></i> Call to Order</a>
            <a href="https://wa.me/237654091559" class="cta-button" target="_blank" rel="noopener"><i class="fab fa-whatsapp"></i> WhatsApp Order</a>
        </div>
    </div>
</section>

<?php include 'footer.php'; ?>

<script>
function orderMeal(mealName, price) {
    const confirmation = confirm(`Order ${mealName} for ${price} FCFA?\n\nThis will redirect you to our WhatsApp for order confirmation.`);
    if (confirmation) {
        const whatsappNumber = "237654091559";
        const message = `Hello! I would like to order: ${mealName} (${price} FCFA) from AUNTY CO'S KITCHEN menu.`;
        const whatsappUrl = `https://wa.me/${whatsappNumber}?text=${encodeURIComponent(message)}`;
        window.open(whatsappUrl, '_blank');
    }
}
</script>
</body>
</html>
