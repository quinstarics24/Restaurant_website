<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AUNTY CO'S KITCHEN - Home Cooked Meals with Love</title>
    
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
            overflow-x: hidden;
        }

        .font-heading {
            font-family: 'Playfair Display', serif;
        }

        /* Hero Section */
        .hero {
            background: linear-gradient(135deg, var(--light-color) 0%, #e8ddd4 100%);
            padding: 120px 0 80px;
            position: relative;
            overflow: hidden;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -20%;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(212, 165, 116, 0.1) 0%, transparent 70%);
            border-radius: 50%;
        }

        .hero-content h1 {
            font-size: 3.5rem;
            font-weight: 700;
            color: var(--secondary-color);
            margin-bottom: 1.5rem;
            line-height: 1.2;
        }

        .hero-subtitle {
            font-size: 1.3rem;
            color: var(--text-dark);
            margin-bottom: 2rem;
            opacity: 0.9;
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
            box-shadow: 0 5px 15px rgba(255, 107, 53, 0.3);
        }

        .btn-outline-primary {
            color: var(--secondary-color);
            border-color: var(--secondary-color);
            padding: 12px 30px;
            font-weight: 600;
            border-radius: 50px;
            transition: all 0.3s ease;
        }

        .btn-outline-primary:hover {
            background: var(--secondary-color);
            transform: translateY(-2px);
        }

        /* Hero Image */
        .hero-image-container {
            position: relative;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 20px 40px rgba(0,0,0,0.15);
            transform: rotate(-2deg);
            transition: all 0.3s ease;
        }

        .hero-image-container:hover {
            transform: rotate(0deg) scale(1.02);
            box-shadow: 0 25px 50px rgba(0,0,0,0.2);
        }

        .hero-image {
            width: 100%;
            height: 400px;
            object-fit: cover;
            border-radius: 20px;
        }
        .features {
            padding: 80px 0;
            background: white;
        }

        .feature-card {
            text-align: center;
            padding: 2rem;
            border-radius: 20px;
            transition: all 0.3s ease;
            height: 100%;
            background: white;
            border: 1px solid rgba(212, 165, 116, 0.2);
        }

        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            border-color: var(--primary-color);
        }

        .feature-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            color: white;
            font-size: 2rem;
        }

        /* Services Section */
        .services {
            padding: 80px 0;
            background: linear-gradient(135deg, #f8f5f2 0%, #ede4d3 100%);
            position: relative;
            overflow: hidden;
        }

        .services::before {
            content: '';
            position: absolute;
            top: 20%;
            left: -10%;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(212, 165, 116, 0.08) 0%, transparent 70%);
            border-radius: 50%;
        }

        .services::after {
            content: '';
            position: absolute;
            bottom: 10%;
            right: -15%;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(255, 107, 53, 0.06) 0%, transparent 70%);
            border-radius: 50%;
        }

        .service-card {
            background: white;
            border-radius: 25px;
            padding: 3rem 2rem;
            text-align: center;
            height: 100%;
            transition: all 0.4s ease;
            border: 1px solid rgba(212, 165, 116, 0.1);
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
            position: relative;
            overflow: hidden;
        }

        .service-card::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(45deg, transparent 30%, rgba(212, 165, 116, 0.03) 50%, transparent 70%);
            transform: rotate(45deg);
            transition: all 0.6s ease;
            opacity: 0;
        }

        .service-card:hover::before {
            opacity: 1;
            transform: rotate(45deg) translate(20%, 20%);
        }

        .service-card:hover {
            transform: translateY(-15px) scale(1.02);
            box-shadow: 0 25px 50px rgba(0,0,0,0.15);
            border-color: var(--primary-color);
        }

        .service-icon {
            width: 100px;
            height: 100px;
            background: linear-gradient(135deg, var(--accent-color), #ff8c42);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 2rem;
            color: white;
            font-size: 2.5rem;
            transition: all 0.4s ease;
            position: relative;
            z-index: 2;
        }

        .service-card:hover .service-icon {
            transform: scale(1.1);
            background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
            box-shadow: 0 10px 30px rgba(255, 107, 53, 0.3);
        }

        .service-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--secondary-color);
            margin-bottom: 1rem;
            position: relative;
            z-index: 2;
        }

        .service-description {
            color: var(--text-dark);
            font-size: 1rem;
            line-height: 1.7;
            margin-bottom: 1.5rem;
            position: relative;
            z-index: 2;
        }

        .service-highlight {
            background: linear-gradient(90deg, var(--accent-color), #ff8c42);
            color: white;
            padding: 8px 20px;
            border-radius: 25px;
            font-size: 0.85rem;
            font-weight: 600;
            display: inline-block;
            margin-top: auto;
            position: relative;
            z-index: 2;
        }

        .delivery-badge {
            position: absolute;
            top: 20px;
            right: 20px;
            background: var(--primary-color);
            color: white;
            padding: 5px 12px;
            border-radius: 15px;
            font-size: 0.75rem;
            font-weight: 600;
            z-index: 3;
        }

        /* About Section */
        .about {
            padding: 80px 0;
            background: var(--light-color);
        }

        .about-image-container {
            position: relative;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 15px 30px rgba(0,0,0,0.1);
            height: 400px;
        }

        .about-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: all 0.3s ease;
        }

        .about-image-container:hover .about-image {
            transform: scale(1.05);
        }

        .about-image-overlay {
            position: absolute;
            top: 20px;
            left: 20px;
            right: 20px;
            bottom: 20px;
            display: flex;
            align-items: flex-end;
            pointer-events: none;
        }

        .about-badge {
            background: rgba(255, 255, 255, 0.95);
            padding: 12px 20px;
            border-radius: 50px;
            color: var(--secondary-color);
            font-weight: 600;
            font-size: 0.9rem;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .about-badge i {
            color: var(--accent-color);
            margin-right: 8px;
        }

        .about-text {
            font-size: 1.1rem;
            line-height: 1.8;
            color: var(--text-dark);
        }

        /* Gallery Preview */
        .gallery-preview {
            padding: 80px 0;
            background: white;
        }

        .gallery-item {
            border-radius: 15px;
            overflow: hidden;
            position: relative;
            height: 280px;
            margin-bottom: 2rem;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }

        .gallery-item:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.2);
        }

        .gallery-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: all 0.3s ease;
        }

        .gallery-item:hover .gallery-image {
            transform: scale(1.1);
        }

        .gallery-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(to bottom, transparent 40%, rgba(0,0,0,0.8));
            opacity: 0;
            transition: all 0.3s ease;
            display: flex;
            align-items: flex-end;
            padding: 2rem;
        }

        .gallery-item:hover .gallery-overlay {
            opacity: 1;
        }

        .gallery-text {
            color: white;
        }

        .gallery-text h5 {
            margin-bottom: 0.5rem;
            font-weight: 700;
        }

        .gallery-text p {
            margin: 0;
            opacity: 0.9;
            font-size: 0.9rem;
        }

        /* CTA Section */
        .cta {
            position: relative;
            padding: 80px 0;
            color: white;
            text-align: center;
            overflow: hidden;
        }

        .cta-background {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: 1;
        }

        .cta-bg-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .cta-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(44, 24, 16, 0.85), rgba(139, 69, 19, 0.85));
        }

        .cta .container {
            position: relative;
            z-index: 2;
        }

        .cta h2 {
            font-size: 2.5rem;
            margin-bottom: 1rem;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .hero-content h1 {
                font-size: 2.5rem;
            }
            
            .hero-subtitle {
                font-size: 1.1rem;
            }
            
            .hero {
                padding: 100px 0 60px;
            }
            
            .features, .services, .about, .gallery-preview {
                padding: 60px 0;
            }

            .service-card {
                padding: 2rem 1.5rem;
                margin-bottom: 2rem;
            }

            .service-icon {
                width: 80px;
                height: 80px;
                font-size: 2rem;
            }
        }

        /* Animation */
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

        .animate-fadeInUp {
            animation: fadeInUp 0.8s ease-out;
        }
    </style>
</head>
<body>
    <?php include 'header.php'; ?>
   

    <!-- Hero Section -->
    <section id="home" class="hero">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="hero-content animate-fadeInUp">
                        <h1 class="font-heading">Welcome to<br>AUNTY CO'S KITCHEN</h1>
                        <p class="hero-subtitle">Experience authentic home-cooked meals made with love and served with warmth. Located in the heart of Micah Hotel, we bring you the finest flavors and family recipes passed down through generations.</p>
                        <div class="d-flex flex-wrap gap-3">
                            <a href="reservations.php" class="btn btn-primary">
                                <i class="fas fa-calendar-alt me-2"></i>Make Reservation
                            </a>
                            <a href="menu.php" class="btn btn-outline-primary">
                                <i class="fas fa-utensils me-2"></i>View Menu
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="text-center">
                        <div class="hero-image-container">
                            <img src="images/achu.png" alt="Delicious home-cooked meal at Aunty Co's Kitchen" class="img-fluid hero-image">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features">
        <div class="container">
            <div class="row text-center mb-5">
                <div class="col-12">
                    <h2 class="font-heading mb-3">Why Choose Aunty Co's Kitchen?</h2>
                    <p class="lead">Experience the difference that comes with genuine care and quality ingredients</p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-heart"></i>
                        </div>
                        <h4 class="font-heading mb-3">Made with Love</h4>
                        <p>Every dish is prepared with genuine care and attention, just like home-cooked meals from your family.</p>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-leaf"></i>
                        </div>
                        <h4 class="font-heading mb-3">Fresh Ingredients</h4>
                        <p>We source the finest, freshest ingredients daily to ensure every meal exceeds your expectations.</p>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <h4 class="font-heading mb-3">Quick Service</h4>
                        <p>Fast, friendly service without compromising on quality. Perfect for busy schedules and special occasions.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section id="services" class="services">
        <div class="container">
            <div class="row text-center mb-5">
                <div class="col-12">
                    <h2 class="font-heading mb-3">Our Services</h2>
                    <p class="lead">Bringing authentic flavors to you, wherever you are in Yaoundé</p>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="service-card">
                        <div class="delivery-badge">Available</div>
                        <div class="service-icon">
                            <i class="fas fa-utensils"></i>
                        </div>
                        <h4 class="service-title font-heading">Custom Catering</h4>
                        <p class="service-description">
                            We cook on command for all your special needs — parties, occasions, events, and more.
                            Freshly prepared meals tailored to your taste and theme.
                        </p>
                        <div class="service-highlight">
                            <i class="fas fa-clock me-1"></i>On Demand
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="service-card">
                        <div class="delivery-badge">Hot & Fresh</div>
                        <div class="service-icon">
                            <i class="fas fa-motorcycle"></i>
                        </div>
                        <h4 class="service-title font-heading">Home Delivery</h4>
                        <p class="service-description">We deliver fresh, hot meals throughout Yaoundé! Order your favorite dishes and enjoy them in the comfort of your home or office.</p>
                        <div class="service-highlight">
                            <i class="fas fa-map-marker-alt me-1"></i>All Yaoundé Areas
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="service-card">
                        <div class="delivery-badge">Quick Service</div>
                        <div class="service-icon">
                            <i class="fas fa-shopping-bag"></i>
                        </div>
                        <h4 class="service-title font-heading">Takeaway Orders</h4>
                        <p class="service-description">Perfect for busy schedules! Call ahead to place your order and pick up fresh, ready-to-eat meals without the wait.</p>
                        <div class="service-highlight">
                            <i class="fas fa-phone me-1"></i>Call & Collect
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="about">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-5 mb-lg-0">
                    <div class="about-image-container">
                        <img src="images/mom.jpg" alt="Warm and welcoming interior of Aunty Co's Kitchen" class="img-fluid about-image">
                        <div class="about-image-overlay">
                            <div class="about-badge">
                                <i class="fas fa-award"></i>
                                <span>Family Recipes Since 2020</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <h2 class="font-heading mb-4">Our Story</h2>
                    <div class="about-text">
                        <p>Nestled within the welcoming walls of Micah Hotel, Aunty Co's Kitchen represents more than just a restaurant – it's a celebration of family traditions and authentic flavors that have been lovingly preserved for generations.</p>
                        
                        <p>Founded with a passion for bringing people together over delicious, home-style cooking, we pride ourselves on creating an atmosphere where every guest feels like family. Our menu features time-honored recipes that tell the story of our heritage, prepared with the same care and attention you'd find in a family kitchen.</p>
                        
                        <p>Whether you're stopping by for a hearty breakfast to start your day, a satisfying lunch break, or a memorable dinner with loved ones, we're committed to serving meals that nourish both body and soul.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Gallery Preview -->
    <section id="gallery" class="gallery-preview">
        <div class="container">
            <div class="row text-center mb-5">
                <div class="col-12">
                    <h2 class="font-heading mb-3">A Taste of Our Kitchen</h2>
                    <p class="lead">Get a glimpse of our delicious offerings and warm atmosphere</p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="gallery-item">
                        <img src="images/ndole.png" class="gallery-image">
                        <div class="gallery-overlay">
                            <div class="gallery-text">
                                <h5>Ndolé with Plantains</h5>
                                <p>A classic Cameroonian delicacy made with bitterleaf, groundnuts, and spices – served with ripe plantains.</p>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="gallery-item">
                        <img src="images/Egusi.png" alt="egusi-soup and fufu" class="gallery-image">
                        <div class="gallery-overlay">
                            <div class="gallery-text">
                               <h5>Okra & Egusi Mix</h5>
                                <p>A rich combination of finely chopped okra and ground melon seeds, cooked with palm oil, spices, and assorted meats — served with garri or fufu of your choice.</p>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="gallery-item">
                        <img src="images/coco.png" alt="Cocoyam Porridge" class="gallery-image">
                        <div class="gallery-overlay">
                            <div class="gallery-text">
                               <h5>Cocoyam Porridge</h5>
                               <p>Chunks of cocoyam slow-cooked in palm oil with bitterleaf, smoked fish, and local spices — a flavorful traditional delicacy.</p>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="cta">
        <div class="cta-background">
            <img src="images/restaurant-atmosphere.jpg" alt="Cozy dining atmosphere at Aunty Co's Kitchen" class="cta-bg-image">
            <div class="cta-overlay"></div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <h2 class="font-heading mb-3">Ready to Experience Aunty Co's Kitchen?</h2>
                    <p class="lead mb-4">Join us for an unforgettable dining experience where every meal is prepared with love and served with a smile.</p>
                    <div class="d-flex justify-content-center flex-wrap gap-3">
                        <a href="reservations.php" class="btn btn-primary btn-lg">
                            <i class="fas fa-calendar-alt me-2"></i>Book Your Table
                        </a>
                        <a href="tel:+237 654091559" class="btn btn-outline-light btn-lg">
                            <i class="fas fa-phone me-2"></i>Call Now
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
  
   
 <?php include 'footer.php'; ?>
    <!-- Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
    
    <script>
       
        // Animation on scroll
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

        // Observe elements for animation
        document.querySelectorAll('.feature-card, .service-card, .about-text, .gallery-item').forEach(el => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(30px)';
            el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
            observer.observe(el);
        });
    </script>
</body>
</html>