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
                <!-- Gallery Item 1 -->

                <div class="gallery-item">
                    <img src="images/achu.png" alt="Achu and Yellow Soup" class="gallery-image">
                    <div class="gallery-overlay">
                        <h4 class="dish-name">Achu and Yellow Soup</h4>
                        <p class="dish-description">A traditional dish featuring smooth achu served with a rich and flavorful yellow soup.</p>
                    </div>
                </div>
                
                <!-- Gallery Item 2 -->
                <div class="gallery-item">
                    <img src="images/sanga.jpg" alt="Sanga Traditional Meal" class="gallery-image">
                    <div class="gallery-overlay">
                        <h4 class="dish-name">Sanga Traditional Meal</h4>
                        <p class="dish-description">A delightful assortment of traditional Sanga dishes, showcasing rich flavors? and local ingredients.</p>
                    </div>
                </div>

                <!-- Gallery Item 3 -->
                <div class="gallery-item">
                    <img src="images/ko.jpg" alt="Okok" class="gallery-image">
                    <div class="gallery-overlay">
                        <h4 class="dish-name">Okok</h4>
                        <p class="dish-description">A flavorful dish made with leafy greens, spices, and served with a side of starchy accompaniments.</p>
                    </div>
                </div>

                <!-- Gallery Item 4 -->
                <div class="gallery-item">
                    <img src="images/Ekwang.jpg" alt="Ekwang" class="gallery-image">
                    <div class="gallery-overlay">
                        <h4 class="dish-name">Ekwang</h4>
                        <p class="dish-description">A delicious dish made from grated cocoyam, cooked with spices and served in a rich vegetable sauce.</p>
                    </div>
                </div>

                <!-- Gallery Item 5 -->
                <div class="gallery-item">
                    <img src="images/fufu.jpg" alt="Fufu Corn and Vegetable, Kati Kati" class="gallery-image">
                    <div class="gallery-overlay">
                        <h4 class="dish-name">Fufu Corn and Vegetable, Khati Khati</h4>
                        <p class="dish-description">A hearty meal featuring smooth fufu corn paired with vibrant vegetables and grilled kati kati chicken.</p>
                    </div>
                </div>

                <!-- Gallery Item 6 -->
                <div class="gallery-item">
                    <img src="images/egg.jpg" alt="Soup and Ripe Plantain" class="gallery-image">
                    <div class="gallery-overlay">
                        <h4 class="dish-name">Egg Soup and Ripe Plantain</h4>
                        <p class="dish-description">A comforting dish featuring rich egg soup served with sweet, ripe plantains.</p>
                    </div>
                </div>

                <!-- Gallery Item 7 -->
                <div class="gallery-item">
                    <img src="images/coco.png" alt="Porrished Cocoyams and Dry Meat" class="gallery-image">
                    <div class="gallery-overlay">
                        <h4 class="dish-name">Porrished Cocoyams and Dry Meat</h4>
                        <p class="dish-description">A savory dish of porridged cocoyams served with tender pieces of dry meat for a hearty meal.</p>
                    </div>
                </div>

                <!-- Gallery Item 8 -->
                <div class="gallery-item">
                    <img src="images/ndole.png" alt="Ndole" class="gallery-image">
                    <div class="gallery-overlay">
                        <h4 class="dish-name">Ndole</h4>
                        <p class="dish-description">A flavorful dish made with bitter leaves, groundnuts, and tender meat, offering a unique taste of tradition.</p>
                    </div>
                </div>

                <!-- Gallery Item 9 -->
                <div class="gallery-item">
                    <img src="images/rice.jpg" alt="Fried Rice and Chicken" class="gallery-image">
                    <div class="gallery-overlay">
                        <h4 class="dish-name">Fried Rice and Chicken</h4>
                        <p class="dish-description">Delicious fried rice served with tender, seasoned chicken</p>
                    </div>
                </div>

            </div>

            <!-- Featured Dishes Section -->
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
    
    <script>
        // Simple hover effects and smooth animations
        document.addEventListener('DOMContentLoaded', function() {
            const galleryItems = document.querySelectorAll('.gallery-item, .featured-item');
            
            galleryItems.forEach(item => {
                item.addEventListener('mouseenter', function() {
                    this.style.transition = 'all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94)';
                });
            });
        });

        // Add stagger animation on scroll
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver(function(entries) {
            entries.forEach((entry, index) => {
                if (entry.isIntersecting) {
                    setTimeout(() => {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }, index * 100);
                }
            });
        }, observerOptions);

        // Observe gallery items for stagger effect
        document.querySelectorAll('.gallery-item, .featured-item').forEach(el => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(30px)';
            el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
            observer.observe(el);
        });
    </script>
</body>
</html>