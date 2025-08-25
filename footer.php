<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Footer | Aunty Co's Kitchen</title>
  
  <!-- Bootstrap CSS -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet" />
  
  <!-- Font Awesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet" />
  
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
  
  <style>
    :root {
      --primary-color: #d4a574;
      --secondary-color: #8b4513;
      --accent-color: #ff6b35;
      --dark-color: #2c1810;
      --darker-color: #1a0f0a;
      --light-color: #f8f5f2;
      --text-dark: #333;
      --text-light: #e8ddd4;
    }

    * {
      box-sizing: border-box;
    }

    body {
      font-family: 'Inter', sans-serif;
      margin: 0;
      padding: 0;
    }

    .font-heading {
      font-family: 'Playfair Display', serif;
    }

    .footer {
      background: linear-gradient(135deg, var(--dark-color) 0%, var(--darker-color) 100%);
      color: var(--text-light);
      position: relative;
      overflow: hidden;
    }

    .footer::before {
      content: '';
      position: absolute;
      top: -50%;
      left: -20%;
      width: 600px;
      height: 600px;
      background: radial-gradient(circle, rgba(212, 165, 116, 0.05) 0%, transparent 70%);
      border-radius: 50%;
    }

    .footer::after {
      content: '';
      position: absolute;
      bottom: -30%;
      right: -15%;
      width: 500px;
      height: 500px;
      background: radial-gradient(circle, rgba(255, 107, 53, 0.03) 0%, transparent 70%);
      border-radius: 50%;
    }

    .footer-main {
      padding: 60px 0 30px;
      position: relative;
      z-index: 2;
    }

    .footer-bottom {
      background: var(--darker-color);
      padding: 20px 0;
      position: relative;
      z-index: 2;
      border-top: 1px solid rgba(212, 165, 116, 0.2);
    }

    .footer-brand {
      margin-bottom: 2rem;
    }

    .footer-brand h4 {
      font-size: 2rem;
      font-weight: 700;
      color: var(--primary-color);
      margin-bottom: 1rem;
      text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
    }

    .footer-tagline {
      color: var(--text-light);
      font-style: italic;
      font-size: 1.1rem;
      margin-bottom: 1.5rem;
      opacity: 0.9;
    }

    .footer-section h5 {
      color: var(--primary-color);
      font-weight: 600;
      margin-bottom: 1.5rem;
      font-size: 1.3rem;
      position: relative;
      padding-bottom: 0.5rem;
    }

    .footer-section h5::after {
      content: '';
      position: absolute;
      bottom: 0;
      left: 0;
      width: 30px;
      height: 2px;
      background: linear-gradient(90deg, var(--accent-color), var(--primary-color));
      border-radius: 1px;
    }

    .footer-info {
      margin-bottom: 1rem;
      font-size: 1rem;
      color: var(--text-light);
      display: flex;
      align-items: center;
      transition: all 0.3s ease;
      padding: 8px 0;
    }

    .footer-info:hover {
      color: var(--primary-color);
      transform: translateX(5px);
    }

    .footer-info i {
      color: var(--accent-color);
      margin-right: 15px;
      width: 20px;
      font-size: 1.1rem;
      transition: all 0.3s ease;
    }

    .footer-info:hover i {
      color: var(--primary-color);
      transform: scale(1.1);
    }

    .quick-links {
      list-style: none;
      padding: 0;
      margin: 0;
    }

    .quick-links li {
      margin-bottom: 0.8rem;
    }

    .quick-links a {
      color: var(--text-light);
      text-decoration: none;
      font-weight: 400;
      transition: all 0.3s ease;
      display: inline-block;
      position: relative;
      padding: 5px 0;
    }

    .quick-links a::before {
      content: '';
      position: absolute;
      bottom: 0;
      left: 0;
      width: 0;
      height: 2px;
      background: var(--accent-color);
      transition: width 0.3s ease;
    }

    .quick-links a:hover {
      color: var(--primary-color);
      transform: translateX(8px);
    }

    .quick-links a:hover::before {
      width: 100%;
    }

    .social-links {
      display: flex;
      gap: 1rem;
      margin-top: 1.5rem;
    }

    .social-links a {
      display: flex;
      align-items: center;
      justify-content: center;
      width: 45px;
      height: 45px;
      background: rgba(212, 165, 116, 0.1);
      color: var(--text-light);
      font-size: 1.3rem;
      border-radius: 50%;
      transition: all 0.4s ease;
      border: 2px solid transparent;
    }

    .social-links a:hover {
      background: var(--accent-color);
      color: white;
      transform: translateY(-3px) scale(1.1);
      box-shadow: 0 5px 15px rgba(255, 107, 53, 0.4);
      border-color: var(--primary-color);
    }

    .footer-divider {
      border: none;
      height: 1px;
      background: linear-gradient(90deg, transparent, rgba(212, 165, 116, 0.3), transparent);
      margin: 2rem 0 1rem;
    }

    .footer-bottom p {
      color: var(--text-light);
      font-size: 0.95rem;
      margin: 0;
      opacity: 0.8;
    }

    .admin-link {
      color: rgba(232, 221, 212, 0.6);
      text-decoration: none;
      font-size: 0.85rem;
      transition: all 0.3s ease;
      margin-left: 1rem;
    }

    .admin-link:hover {
      color: var(--primary-color);
    }

    .footer-logo-section {
      text-align: center;
      margin-bottom: 2rem;
    }

    .footer-decoration {
      width: 60px;
      height: 3px;
      background: linear-gradient(90deg, var(--accent-color), var(--primary-color));
      margin: 1rem auto;
      border-radius: 2px;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
      .footer-main {
        padding: 40px 0 20px;
      }

      .footer-brand h4 {
        font-size: 1.5rem;
        text-align: center;
      }

      .footer-tagline {
        text-align: center;
        font-size: 1rem;
      }

      .social-links {
        justify-content: center;
      }

      .footer-section {
        margin-bottom: 2rem;
        text-align: center;
      }

      .footer-section h5::after {
        left: 50%;
        transform: translateX(-50%);
      }

      .quick-links a:hover {
        transform: translateX(0);
      }
    }

    /* Animation */
    @keyframes fadeInUp {
      from {
        opacity: 0;
        transform: translateY(20px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .footer-section {
      animation: fadeInUp 0.8s ease-out;
    }
  </style>
</head>

<body>
  <!-- Footer -->
  <footer class="footer">
    <!-- Main Footer Content -->
    <div class="footer-main">
      <div class="container">
        <div class="row">
          <!-- Brand Section -->
          <div class="col-lg-4 col-md-6 mb-4">
            <div class="footer-brand">
              <h4 class="font-heading">AUNTY CO'S KITCHEN</h4>
              <p class="footer-tagline">"Where every meal is made with love"</p>
              <div class="footer-decoration"></div>
            </div>
            
            <div class="footer-info">
              <i class="fas fa-map-marker-alt"></i>
              <span>Micah Hotel, Yaoundé<br>Montée Chapel Obili, Cameroon</span>
            </div>
            <div class="footer-info">
              <i class="fas fa-phone"></i>
              <span>+237 654 091 559</span>
            </div>
            <div class="footer-info">
              <i class="fas fa-envelope"></i>
              <span>info@auntycoskitchen.com</span>
            </div>

            <div class="social-links">
              <a href="https://wa.me/237654091559" title="WhatsApp"><i class="fab fa-whatsapp"></i></a>
              <a href="#" title="Facebook"><i class="fab fa-facebook"></i></a>
              <a href="#" title="Instagram"><i class="fab fa-instagram"></i></a>
              <a href="#" title="TikTok"><i class="fab fa-tiktok"></i></a>
            </div>
          </div>

          <!-- Operating Hours -->
          <div class="col-lg-3 col-md-6 mb-4">
            <div class="footer-section">
              <h5 class="font-heading">Operating Hours</h5>
              <div class="footer-info">
                <i class="fas fa-clock"></i>
                <span>Monday - Sunday<br>10:00 AM - 8:00 PM</span>
              </div>
              <div class="footer-info">
                <i class="fas fa-calendar-check"></i>
                <span>Open 7 Days a Week</span>
              </div>
              <div class="footer-info">
                <i class="fas fa-motorcycle"></i>
                <span>Delivery Available<br>Throughout Yaoundé</span>
              </div>
            </div>
          </div>

          <!-- Quick Links -->
          <div class="col-lg-2 col-md-6 mb-4">
            <div class="footer-section">
              <h5 class="font-heading">Quick Links</h5>
              <ul class="quick-links">
                <li><a href="index.php">Home</a></li>
                <li><a href="menu.php">Menu</a></li> 
                <li><a href="gallery.php">Gallery</a></li>
                <li><a href="contact.php">Contact</a></li>
              </ul>
            </div>
          </div>

          <!-- Additional Info -->
          <div class="col-lg-3 col-md-6 mb-4">
            <div class="footer-section">
              <h5 class="font-heading">Special Services</h5>
              <div class="footer-info">
                <i class="fas fa-birthday-cake"></i>
                <span>Party Catering<br>Available on Request</span>
              </div>
              <div class="footer-info">
                <i class="fas fa-utensils"></i>
                <span>Custom Meal Prep<br>Made to Order</span>
              </div>
              <div class="footer-info">
                <i class="fas fa-users"></i>
                <span>Group Events<br>& Special Occasions</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Footer Bottom -->
    <div class="footer-bottom">
      <div class="container">
        <hr class="footer-divider">
        <div class="row align-items-center">
          <div class="col-md-8 text-center text-md-start">
            <p>&copy; 2025 Aunty Co's Kitchen. All rights reserved. | Made with ❤️ in Cameroon</p>
          </div>
          <div class="col-md-4 text-center text-md-end">
            <a href="admin/login.php" class="admin-link">
              <i class="fas fa-user-shield me-1"></i>Admin Portal
            </a>
          </div>
        </div>
      </div>
    </div>
  </footer>

  <!-- Bootstrap JS -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
  
  <script>
    // Newsletter form submission
    document.querySelector('.newsletter-form').addEventListener('submit', function(e) {
      e.preventDefault();
      const email = this.querySelector('input[type="email"]').value;
      if (email) {
        // Here you would typically send the email to your server
        alert('Thank you for subscribing to our newsletter!');
        this.querySelector('input[type="email"]').value = '';
      }
    });

    // Smooth scroll for footer links
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
  </script>
</body>
</html>