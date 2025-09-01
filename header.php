<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            line-height: 1.6;
            color: #333;
            overflow-x: hidden;
        }

        /* Header & Navigation Styles */
        .header {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            padding: 0.5rem 0;
            transition: all 0.3s ease;
            box-shadow: 0 2px 15px rgba(0,0,0,0.08);
        }

        .header.scrolled {
            padding: 0.3rem 0;
            background: rgba(255, 255, 255, 0.98);
            box-shadow: 0 2px 20px rgba(0,0,0,0.12);
        }

        .nav-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-family: 'Playfair Display', serif;
            font-size: 1.4rem;
            font-weight: 700;
            color: #d4a574;
            text-decoration: none;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 0.4rem;
        }

        .logo:hover {
            color: #b8925f;
            transform: scale(1.03);
        }

        .logo i {
            font-size: 1.2rem;
        }

        .nav-menu {
            display: flex;
            list-style: none;
            gap: 1.2rem;
            align-items: center;
        }

        .nav-menu li {
            position: relative;
        }

        .nav-menu li a {
            text-decoration: none;
            color: #333;
            font-weight: 500;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            position: relative;
            padding: 0.4rem 0.8rem;
            border-radius: 20px;
            display: flex;
            align-items: center;
            gap: 0.3rem;
        }

        .nav-menu li a:hover {
            color: #d4a574;
            background: rgba(212, 165, 116, 0.1);
        }

        .nav-menu li a.active {
            color: #d4a574;
            background: rgba(212, 165, 116, 0.15);
        }

        .nav-menu li a.active::after {
            content: '';
            position: absolute;
            bottom: -3px;
            left: 50%;
            transform: translateX(-50%);
            width: 15px;
            height: 2px;
            background: #d4a574;
            border-radius: 1px;
        }

        .nav-menu li a i {
            font-size: 0.8rem;
        }

        /* Special CTA Button in Navigation */
        .nav-cta {
            background: #d4a574 !important;
            color: white !important;
            padding: 0.5rem 1rem !important;
            border-radius: 25px !important;
            font-weight: 600 !important;
            font-size: 0.85rem !important;
            transition: all 0.3s ease;
            border: 2px solid #d4a574;
            margin-left: 0.5rem;
        }

        .nav-cta:hover {
            background: transparent !important;
            color: #d4a574 !important;
            transform: translateY(-1px);
            box-shadow: 0 5px 15px rgba(212, 165, 116, 0.3);
        }

        .nav-cta::after {
            display: none !important;
        }

        /* Mobile Menu Toggle */
        .mobile-toggle {
            display: none;
            flex-direction: column;
            cursor: pointer;
            padding: 0.3rem;
            transition: all 0.3s ease;
        }

        .mobile-toggle:hover {
            background: rgba(212, 165, 116, 0.1);
            border-radius: 5px;
        }

        .mobile-toggle span {
            width: 22px;
            height: 2px;
            background: #333;
            margin: 2.5px 0;
            transition: all 0.3s ease;
            border-radius: 1px;
        }

        .mobile-toggle.active span:nth-child(1) {
            transform: rotate(-45deg) translate(-4px, 5px);
            background: #d4a574;
        }

        .mobile-toggle.active span:nth-child(2) {
            opacity: 0;
        }

        .mobile-toggle.active span:nth-child(3) {
            transform: rotate(45deg) translate(-4px, -5px);
            background: #d4a574;
        }

        /* Mobile Menu Overlay */
        .mobile-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100vh;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }

        .mobile-overlay.active {
            opacity: 1;
            visibility: visible;
        }
        /* Responsive Design */
        @media (max-width: 968px) {
            .nav-menu {
                gap: 0.8rem;
            }

            .logo {
                font-size: 1.3rem;
            }

            .nav-menu li a {
                font-size: 0.85rem;
                padding: 0.3rem 0.6rem;
            }

            .nav-cta {
                padding: 0.4rem 0.8rem !important;
            }
        }

        @media (max-width: 768px) {

            .mobile-toggle {
                display: flex;
            }

            .nav-menu {
                position: fixed;
                top: 60px;
                left: -100%;
                width: 100%;
                max-width: 320px;
                height: calc(100vh - 60px);
                background: white;
                flex-direction: column;
                justify-content: start;
                align-items: center;
                padding: 1.5rem 0;
                transition: left 0.3s ease;
                box-shadow: 5px 0 20px rgba(0,0,0,0.1);
                z-index: 1000;
                overflow-y: auto;
            }

            .nav-menu.active {
                left: 0;
            }

            .nav-menu li {
                margin: 0.3rem 0;
                width: 85%;
            }

            .nav-menu li a {
                padding: 0.8rem;
                border-radius: 8px;
                width: 100%;
                justify-content: center;
                font-size: 1rem;
            }

            .nav-cta {
                margin-top: 0.8rem !important;
                width: 75% !important;
                text-align: center !important;
                margin-left: 0 !important;
            }

            .logo {
                font-size: 1.2rem;
            }

            .nav-container {
                padding: 0 1rem;
            }

            .header {
                padding: 0.4rem 0;
            }

            .header.scrolled {
                padding: 0.25rem 0;
            }
        }

        @media (max-width: 480px) {
            .logo {
                font-size: 1.1rem;
            }

            .logo i {
                font-size: 1rem;
            }
        }

        /* Scroll Animation */
        @keyframes slideDown {
            from {
                transform: translateY(-100%);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .header {
            animation: slideDown 0.5s ease-out;
        }

        /* Active Page Indicator */
        .nav-menu li a[data-page="home"].active-page,
        .nav-menu li a[data-page="menu"].active-page,
        .nav-menu li a[data-page="reservations"].active-page,
        .nav-menu li a[data-page="gallery"].active-page,
        .nav-menu li a[data-page="contact"].active-page {
            color: #d4a574;
            background: rgba(212, 165, 116, 0.15);
        }

        /* Demo content to show header behavior */
        .demo-content {
            margin-top: 120px;
            padding: 2rem;
            text-align: center;
        }

        .demo-section {
            height: 80vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            margin: 1rem 0;
            border-radius: 10px;
            font-size: 1.5rem;
            color: #666;
        }
    </style>
</head>
<body>
    
    <!-- Main Header -->
    <header class="header" id="mainHeader">
        <nav class="nav-container">
            <a href="index.php" class="logo">
                <i class="fas fa-utensils"></i>
                AUNTY CO'S <br>KITCHEN
            </a>
            
            <ul class="nav-menu" id="navMenu">
                <li><a href="index.php" class="nav-link" data-page="home">
                    <i class="fas fa-home"></i>
                    Home
                </a></li>
                <li><a href="menu.php" class="nav-link" data-page="menu">
                    <i class="fas fa-utensils"></i>
                    Menu
                </a></li>
                <li><a href="reservations.php" class="nav-link" data-page="reservations">
                    <i class="fas fa-calendar-alt"></i>
                    Reservations
                </a></li>
                <li><a href="gallery.php" class="nav-link" data-page="gallery">
                    <i class="fas fa-images"></i>
                    Gallery
                </a></li>
                <li><a href="contact.php" class="nav-link" data-page="contact">
                    <i class="fas fa-map-marker-alt"></i>
                    Contact
                </a></li>
                <li><a href="reservations.php" class="nav-link nav-cta">
                    <i class="fas fa-calendar-check"></i>
                    Book Now
                </a></li>
            </ul>

            <div class="mobile-toggle" id="mobileToggle">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </nav>
    </header>

    <script>
        // Header functionality script
        document.addEventListener('DOMContentLoaded', function() {
            const header = document.getElementById('mainHeader');
            const mobileToggle = document.getElementById('mobileToggle');
            const navMenu = document.getElementById('navMenu');
            const mobileOverlay = document.getElementById('mobileOverlay');
            const navLinks = document.querySelectorAll('.nav-link');

            // Header scroll effect
            let lastScrollY = window.scrollY;
            
            function updateHeader() {
                const currentScrollY = window.scrollY;
                
                if (currentScrollY > 50) {
                    header.classList.add('scrolled');
                } else {
                    header.classList.remove('scrolled');
                }
                
                lastScrollY = currentScrollY;
            }

            window.addEventListener('scroll', updateHeader, { passive: true });

            // Mobile menu toggle
            function toggleMobileMenu() {
                mobileToggle.classList.toggle('active');
                navMenu.classList.toggle('active');
                mobileOverlay.classList.toggle('active');
                document.body.style.overflow = navMenu.classList.contains('active') ? 'hidden' : '';
            }

            function closeMobileMenu() {
                mobileToggle.classList.remove('active');
                navMenu.classList.remove('active');
                mobileOverlay.classList.remove('active');
                document.body.style.overflow = '';
            }

            mobileToggle.addEventListener('click', toggleMobileMenu);
            mobileOverlay.addEventListener('click', closeMobileMenu);

            // Close mobile menu when clicking nav links
            navLinks.forEach(link => {
                link.addEventListener('click', () => {
                    if (window.innerWidth <= 768) {
                        closeMobileMenu();
                    }
                });
            });

            // Set active page
            function setActivePage() {
                const currentPage = window.location.pathname.split('/').pop() || 'index.html';
                
                navLinks.forEach(link => {
                    link.classList.remove('active-page');
                    const linkPage = link.getAttribute('href');
                    
                    if (linkPage === currentPage || 
                        (currentPage === 'index.html' && linkPage === 'index.html') ||
                        (currentPage === '' && linkPage === 'index.html')) {
                        link.classList.add('active-page');
                    }
                });
            }

            setActivePage();

            // Smooth scroll for anchor links
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

            // Handle window resize
            window.addEventListener('resize', () => {
                if (window.innerWidth > 768) {
                    closeMobileMenu();
                }
            });

            // Add loading animation
            header.style.opacity = '0';
            header.style.transform = 'translateY(-100%)';
            
            setTimeout(() => {
                header.style.transition = 'all 0.5s ease';
                header.style.opacity = '1';
                header.style.transform = 'translateY(0)';
            }, 100);
        });

        // Global function to highlight current page 
        function highlightCurrentPage(pageName) {
            const navLinks = document.querySelectorAll('.nav-link');
            navLinks.forEach(link => {
                link.classList.remove('active-page');
                if (link.getAttribute('data-page') === pageName) {
                    link.classList.add('active-page');
                }
            });
        }

        // Export functions for use in other pages
        window.headerUtils = {
            highlightCurrentPage: highlightCurrentPage,
            closeMobileMenu: function() {
                const mobileToggle = document.getElementById('mobileToggle');
                const navMenu = document.getElementById('navMenu');
                const mobileOverlay = document.getElementById('mobileOverlay');
                
                mobileToggle.classList.remove('active');
                navMenu.classList.remove('active');
                mobileOverlay.classList.remove('active');
                document.body.style.overflow = '';
            }
        };
    </script>
</body>
</html>