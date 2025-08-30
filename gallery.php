<?php
// gallery.php
require_once 'includes/db.php'; // adjust path if needed

try {
    // Try to fetch images uploaded in the last 7 days
    $stmt = $pdo->prepare("SELECT * FROM gallery_images WHERE upload_date >= DATE_SUB(CURDATE(), INTERVAL 1 WEEK) ORDER BY created_at DESC");
    $stmt->execute();
    $galleryImages = $stmt->fetchAll();

    // If no images uploaded in the last week, fetch the most recent ones
    if (empty($galleryImages)) {
        $stmt = $pdo->prepare("SELECT * FROM gallery_images ORDER BY created_at DESC LIMIT 9"); // show latest 9 images
        $stmt->execute();
        $galleryImages = $stmt->fetchAll();
    }
} catch (PDOException $e) {
    $galleryImages = [];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gallery - AUNTY CO'S KITCHEN</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
        
    <style>
        :root {
            --primary-color: #d4a574;
            --secondary-color: #8b4513;
            --accent-color: #ff6b35;
            --dark-color: #2c1810;
            --light-color: #f8f5f2;
            --text-dark: #333;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            line-height: 1.6;
            color: var(--text-dark);
            background: #fafafa;
        }

        .font-heading {
            font-family: 'Playfair Display', serif;
        }

        /* Page Header */
        .page-header {
            background: linear-gradient(135deg, var(--light-color) 0%, #d19d69ff 100%);
            padding: 120px 0 60px;
            text-align: center;
        }

        .page-header h1 {
            font-size: 3rem;
            font-weight: 700;
            color: var(--secondary-color);
            margin-bottom: 1rem;
        }

        .page-header p {
            font-size: 1.1rem;
            color: var(--text-dark);
            opacity: 0.8;
            max-width: 500px;
            margin: 0 auto;
        }

        /* Gallery Section */
        .gallery-section {
            padding: 80px 0;
        }

        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            margin-bottom: 3rem;
        }

        .gallery-item {
            position: relative;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            transition: all 0.4s ease;
            cursor: pointer;
            background: white;
        }

        .gallery-item:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 50px rgba(0,0,0,0.2);
        }

        .gallery-image {
            width: 100%;
            height: 280px;
            object-fit: cover;
            transition: all 0.4s ease;
        }

        .gallery-item:hover .gallery-image {
            transform: scale(1.1);
        }

        .gallery-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: linear-gradient(transparent, rgba(0,0,0,0.8));
            color: white;
            padding: 2rem 1.5rem 1.5rem;
            transform: translateY(100%);
            transition: all 0.4s ease;
        }

        .gallery-item:hover .gallery-overlay {
            transform: translateY(0);
        }

        .dish-name {
            font-family: 'Playfair Display', serif;
            font-size: 1.3rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .dish-description {
            font-size: 0.9rem;
            opacity: 0.9;
            margin: 0;
        }

        /* Featured Section */
        .featured-section {
            background: white;
            padding: 60px 0;
            margin-top: 40px;
            border-radius: 30px 30px 0 0;
            box-shadow: 0 -10px 30px rgba(0,0,0,0.05);
        }

        .featured-title {
            text-align: center;
            margin-bottom: 3rem;
        }

        .featured-title h3 {
            font-size: 2.2rem;
            color: var(--secondary-color);
            margin-bottom: 0.5rem;
        }

        .featured-title p {
            color: var(--text-dark);
            opacity: 0.7;
        }

        .featured-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
        }

        .featured-item {
            position: relative;
            border-radius: 15px;
            overflow: hidden;
            height: 200px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
        }

        .featured-item:hover {
            transform: scale(1.02);
            box-shadow: 0 15px 35px rgba(0,0,0,0.15);
        }

        .featured-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .featured-badge {
            position: absolute;
            top: 15px;
            right: 15px;
            background: var(--accent-color);
            color: white;
            padding: 8px 15px;
            border-radius: 25px;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
        }

        /* CTA Section */
        .gallery-cta {
            background: var(--secondary-color);
            color: white;
            padding: 50px 0;
            text-align: center;
            margin-top: 60px;
        }

        .btn-primary {
            background: var(--accent-color);
            border: none;
            padding: 12px 30px;
            font-weight: 600;
            border-radius: 50px;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background: #e55a2b;
            transform: translateY(-2px);
        }

        .btn-outline-light {
            padding: 12px 30px;
            font-weight: 600;
            border-radius: 50px;
            transition: all 0.3s ease;
        }

        .btn-outline-light:hover {
            transform: translateY(-2px);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .page-header h1 {
                font-size: 2.2rem;
            }
            
            .gallery-grid {
                grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
                gap: 1.5rem;
            }
            
            .gallery-section {
                padding: 60px 0;
            }
        }
    </style>
</head>
<body>
     <?php include 'header.php'; ?>

    <!-- Page Header -->
    <section class="page-header">
        <div class="container">
            <h1 class="font-heading">Food Gallery</h1>
            <p>A visual feast of our delicious homemade dishes crafted with love and authentic flavors</p>
        </div>
    </section>

    <!-- Main Gallery Section -->
    <section class="gallery-section">
        <div class="container">
            <div class="gallery-grid">
                <?php if (!empty($galleryImages)): ?>
                    <?php foreach ($galleryImages as $image): ?>
                        <div class="gallery-item">
                            <img src="uploads/gallery/<?php echo htmlspecialchars($image['image_filename']); ?>" 
                                 alt="<?php echo htmlspecialchars($image['image_name']); ?>" class="gallery-image">
                            <div class="gallery-overlay">
                                <h4 class="dish-name"><?php echo htmlspecialchars($image['image_name']); ?></h4>
                                <?php if ($image['image_description']): ?>
                                    <p class="dish-description"><?php echo htmlspecialchars($image['image_description']); ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-center">No images available. Please check back later.</p>
                <?php endif; ?>
            </div>

            <!-- Featured Dishes Section (unchanged) -->
            <div class="featured-section">
                <div class="featured-title">
                    <h3 class="font-heading">Chef's Favorites</h3>
                    <p>Our most popular dishes that keep customers coming back</p>
                </div>
                <div class="featured-grid">
                    <div class="featured-item">
                        <img src="images/beans.jpg" alt="Aunty Co's Signature Dish" class="featured-image">
                        <div class="featured-badge">Signature</div>
                    </div>
                    <div class="featured-item">
                        <img src="images/ero.jpg" alt="Most Popular Combo" class="featured-image">
                        <div class="featured-badge">Popular</div>
                    </div>
                    <div class="featured-item">
                        <img src="images/Egusi.png" alt="Daily Special" class="featured-image">
                        <div class="featured-badge">Special</div>
                    </div>
                    <div class="featured-item">
                        <img src="images/achu.png" alt="Weekend Special" class="featured-image">
                        <div class="featured-badge">Weekend</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="gallery-cta">
        <div class="container">
            <h3 class="font-heading mb-3">Hungry for More?</h3>
            <p class="mb-4">Come taste these amazing dishes for yourself!</p>
            <div class="d-flex justify-content-center gap-3 flex-wrap">
                <a href="menu.php" class="btn btn-primary btn-lg">
                    <i class="fas fa-utensils me-2"></i>View Full Menu
                </a>
                <a href="reservations.php" class="btn btn-outline-light btn-lg">
                    <i class="fas fa-calendar-alt me-2"></i>Make Reservation
                </a>
            </div>
        </div>
    </section>

     <?php include 'footer.php'; ?>
    <!-- Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>
