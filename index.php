<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AUNTY CO'S KITCHEN - Home Cooked Meals with Love</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    
   
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