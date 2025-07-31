<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu - AUNTY CO'S KITCHEN</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Open+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
               font-family: 'Inter', sans-serif;
            line-height: 2.6;
            color: #333;
            background: linear-gradient(135deg, #f8f4e6 0%, #fff8dc 100%);
            min-height: 300vh;
             overflow-x: hidden;
        }

        /* Hero Section */
        .hero {
            background: linear-gradient(rgba(44, 24, 16, 0.7), rgba(74, 44, 23, 0.7)), url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 600" fill="%23f4a261"><rect width="1200" height="600" fill="%23264653"/><path d="M0,200 Q300,150 600,200 T1200,200 L1200,600 L0,600 Z" fill="%23f4a261" opacity="0.1"/></svg>');
            color: white;
            text-align: center;
            padding: 4rem 0;
            background-size: cover;
            background-position: center;
        }

        .hero h1 {
            padding:20px;
            font-family: 'Playfair Display', serif;
            font-size: 3.5rem;
            margin-bottom: 2rem;
            text-shadow: 3px 3px 6px rgba(0,0,0,0.5);
            animation: fadeInUp 1s ease-out;
        }

        .hero p {
            font-size: 1.2rem;
            margin-bottom: 2rem;
            opacity: 0.9;
            animation: fadeInUp 1s ease-out 0.3s both;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Main Content */
        .container {
            max-width: 1300px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .menu-section {
            padding: 4rem 0;
        }

        .section-title {
            text-align: center;
            margin-bottom: 3rem;
        }

        .section-title h2 {
            font-family: 'Playfair Display', serif;
            font-size: 2.5rem;
            color: #2c1810;
            margin-bottom: 1rem;
            position: relative;
            display: inline-block;
        }

        .section-title h2::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 3px;
            background: linear-gradient(to right, #f4a261, #e76f51);
            border-radius: 2px;
        }

        .section-title p {
            color: #666;
            font-size: 1.1rem;
            max-width: 600px;
            margin: 0 auto;
        }

        /* Menu Grid */
        .menu-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(330px, 1fr));
            gap: 2.5rem;
            margin-top: 1rem;
        }

        .menu-item {
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            overflow: hidden;
            transition: all 0.4s ease;
            position: relative;
            animation: slideInUp 0.8s ease-out;
        }

        .menu-item:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.15);
        }

        
       .menu-item-image {
         height: 250px;
         background: #fff; 
         position: relative;
         overflow: hidden;
        }

       .menu-item-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
            border-top-left-radius: 20px;
            border-top-right-radius: 20px;
        }

        .menu-item-image i {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 4rem;
            color: white;
            opacity: 0.8;
        }

        .price-badge {
            position: absolute;
            top: 15px;
            right: 15px;
            background: linear-gradient(45deg, #e76f51, #f4a261);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 25px;
            font-weight: 600;
            font-size: 1.1rem;
            box-shadow: 0 4px 15px rgba(231, 111, 81, 0.3);
            z-index: 10;
        }

        .menu-item-content {
            padding: 1.6rem;
        }

        .menu-item h3 {
            font-family: 'Playfair Display', serif;
            font-size: 1.5rem;
            color: #2c1810;
            margin-bottom: 1rem;
            font-weight: 600;
        }

        .menu-item-description {
            color: #666;
            margin-bottom: 1.5rem;
            line-height: 1.6;
        }

        .menu-item-features {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            margin-bottom: 1.5rem;
        }

        .feature-tag {
            background: linear-gradient(45deg, #f8f4e6, #fff8dc);
            color: #2c1810;
            padding: 0.3rem 0.8rem;
            border-radius: 15px;
            font-size: 0.9rem;
            border: 1px solid #f4a261;
            font-weight: 500;
        }

        .order-button {
            background: linear-gradient(45deg, #e76f51, #f4a261);
            color: white;
            border: none;
            padding: 0.8rem 2rem;
            border-radius: 25px;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .order-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(231, 111, 81, 0.3);
            background: linear-gradient(45deg, #f4a261, #e76f51);
        }

        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(50px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Call to Action */
        .cta-section {
            background: linear-gradient(135deg, #2c1810 0%, #4a2c17 100%);
            color: white;
            padding: 4rem 0;
            text-align: center;
            margin-top: 4rem;
        }

        .cta-section h2 {
            font-family: 'Playfair Display', serif;
            font-size: 2.5rem;
            margin-bottom: 1rem;
        }

        .cta-section p {
            font-size: 1.2rem;
            margin-bottom: 2rem;
            opacity: 0.9;
        }

        .cta-buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
        }

        .cta-button {
            background: linear-gradient(45deg, #e76f51, #f4a261);
            color: white;
            text-decoration: none;
            padding: 1rem 2rem;
            border-radius: 25px;
            font-weight: 600;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .cta-button:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(231, 111, 81, 0.3);
        }

       
        /* Mobile Responsiveness */
        @media (max-width: 768px) {
            .header-container {
                flex-direction: column;
                gap: 1rem;
            }

            .logo {
                font-size: 1.8rem;
            }

            nav {
                display: none;
            }

            .mobile-menu {
                display: block;
            }

            .hero h1 {
                font-size: 2.5rem;
            }

            .hero p {
                font-size: 1rem;
            }

            .menu-grid {
                grid-template-columns: 1fr;
                gap: 2rem;
            }

            .menu-item {
                margin: 0 10px;
            }

            .section-title h2 {
                font-size: 2rem;
            }

            .cta-buttons {
                flex-direction: column;
                align-items: center;
            }
        }

        @media (max-width: 480px) {
            .container {
                padding: 0 15px;
            }

            .hero {
                padding: 2rem 0;
            }

            .menu-section {
                padding: 2rem 0;
            }

            .menu-item-content {
                padding: 1.5rem;
            }
        }
    </style>
</head>
<body>
     <?php include 'header.php'; ?>
        
    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <h1>Our Daily Menu</h1>
            <p>Three specially crafted meals available all day at Micah Hotel</p>
        </div>
    </section>

   <!-- Menu Section -->
    <section class="menu-section">
        <div class="container">
            <div class="section-title">
                <h2>Today's Special Meals</h2>
                <p>Each meal is carefully prepared with fresh ingredients and traditional recipes that have been perfected over time. Available throughout the day for your convenience.</p>
            </div>

            <div class="menu-grid">
                <!-- Meal 1: Eru & Waterfufu -->
<div class="menu-item" style="animation-delay: 0.1s;">
    <div class="menu-item-image">
        <img src="images/eru.jpg" alt="Eru & Waterfufu">
        <div class="price-badge">1,500 FCFA</div>
    </div>
    <div class="menu-item-content">
        <h3>Eru & Waterfufu</h3>
        <p class="menu-item-description">
            A beloved dish from the Southwest of Cameroon made with finely shredded eru leaves, waterleaf, crayfish, smoked meat, and palm oil. Served with soft waterfufu for a bold and earthy taste.
        </p>
        <div class="menu-item-features">
            <span class="feature-tag"><i class="fas fa-seedling"></i> Traditional Taste</span>
            <span class="feature-tag"><i class="fas fa-drumstick-bite"></i> Rich Protein</span>
            <span class="feature-tag"><i class="fas fa-clock"></i> Available Today</span>
        </div>
        <button class="order-button" onclick="orderMeal('Eru & Waterfufu', 1500)">
            <i class="fas fa-shopping-cart"></i>
            Order Now
        </button>
    </div>
</div>

<!-- Meal 2: Achu & Yellow Soup -->
<div class="menu-item" style="animation-delay: 0.3s;">
    <div class="menu-item-image">
        <img src="images/achu.png" alt="Achu and Yellow Soup">
        <div class="price-badge">2,500 FCFA</div>
    </div>
    <div class="menu-item-content">
        <h3>Achu & Yellow Soup</h3>
        <p class="menu-item-description">
            A traditional dish from the Northwest region, featuring smooth pounded cocoyam served with spicy yellow soup made from palm oil, limestone, and assorted meats. A flavorful cultural experience!
        </p>
        <div class="menu-item-features">
            <span class="feature-tag"><i class="fas fa-star"></i> Cultural Favorite</span>
            <span class="feature-tag"><i class="fas fa-utensils"></i> Full Meal</span>
            <span class="feature-tag"><i class="fas fa-fire"></i> Spicy Option</span>
        </div>
        <button class="order-button" onclick="orderMeal('Achu & Yellow Soup', 2500)">
            <i class="fas fa-shopping-cart"></i>
            Order Now
        </button>
    </div>
</div>

<!-- Meal 3: Okra & Garri -->
<div class="menu-item" style="animation-delay: 0.5s;">
    <div class="menu-item-image">
        <img src="images/okru.jpg" alt="Okra and Garri">
        <div class="price-badge">1,500 FCFA</div>
    </div>
    <div class="menu-item-content">
        <h3>Okra & Garri</h3>
        <p class="menu-item-description">
            Slimy and satisfying okra soup cooked with palm oil, assorted meats, and native spices — served with hot garri. A favorite across Cameroon for both its texture and flavor.
        </p>
        <div class="menu-item-features">
            <span class="feature-tag"><i class="fas fa-leaf"></i> Local Flavor</span>
            <span class="feature-tag"><i class="fas fa-heart"></i> Customer Favorite</span>
            <span class="feature-tag"><i class="fas fa-clock"></i> Fresh Daily</span>
        </div>
        <button class="order-button" onclick="orderMeal('Okra & Garri', 1500)">
            <i class="fas fa-shopping-cart"></i>
            Order Now
        </button>
    </div>
</div>

        </div>
    </section>

    <!-- Call to Action -->
    <section class="cta-section">
        <div class="container">
            <h2>Ready to Experience Our Delicious Meals?</h2>
            <p>Visit us at Micah Hotel or make a reservation to secure your table</p>
            <div class="cta-buttons">
                <a href="reservations.php" class="cta-button">
                    <i class="fas fa-calendar-check"></i>
                    Make Reservation
                </a>
                <a href="contact.php" class="cta-button">
                    <i class="fas fa-phone"></i>
                    Call to Order
                </a>
                <a href="https://wa.me/237654091559" class="cta-button" target="_blank">
                    <i class="fab fa-whatsapp"></i>
                    WhatsApp Order
                </a>
            </div>
        </div>
    </section>

    <?php include 'footer.php'; ?>
    
    <script>
        // Order meal function
        function orderMeal(mealName, price) {
            // Create order confirmation popup
            const confirmation = confirm(`Order ${mealName} for ${price} FCFA?\n\nThis will redirect you to our WhatsApp for order confirmation.`);
            
            if (confirmation) {
                // Replace with your actual WhatsApp number
                const whatsappNumber = "237654091559";
                const message = `Hello! I would like to order: ${mealName} (${price} FCFA) from AUNTY CO'S KITCHEN menu.`;
                const whatsappUrl = `https://wa.me/${whatsappNumber}?text=${encodeURIComponent(message)}`;
                
                window.open(whatsappUrl, '_blank');
            }
        }

        // Mobile menu toggle (placeholder for future implementation)
        document.querySelector('.mobile-menu').addEventListener('click', function() {
            // This would toggle mobile navigation
            alert('Mobile menu functionality to be implemented');
        });

        // Add scroll animations
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        // Observe all menu items
        document.querySelectorAll('.menu-item').forEach(item => {
            item.style.opacity = '0';
            item.style.transform = 'translateY(30px)';
            item.style.transition = 'opacity 0.8s ease, transform 0.8s ease';
            observer.observe(item);
        });

        // Add smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Add loading animation
        window.addEventListener('load', function() {
            document.body.style.opacity = '1';
        });

        document.body.style.opacity = '0';
        document.body.style.transition = 'opacity 0.5s ease';
    </script>
</body>
</html>