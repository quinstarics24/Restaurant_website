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

  <style>
    :root {
      --primary-color: #d4a574;
      --secondary-color: #8b4513;
      --accent-color: #ff6b35;
      --dark-color: #2c1810;
      --light-color: #f8f5f2;
      --text-dark: #333;
    }

    .footer {
      background-color: var(--dark-color);
      color: var(--light-color);
      padding: 40px 0 20px;
    }

    .footer-info {
      margin-bottom: 1rem;
      font-size: 1rem;
      color: var(--light-color);
    }

    .footer-info i {
      color: var(--primary-color);
      margin-right: 10px;
      width: 20px;
    }

    .social-links a {
      color: var(--light-color);
      font-size: 1.5rem;
      margin-right: 1rem;
      transition: color 0.3s ease;
    }

    .social-links a:hover {
      color: var(--accent-color);
    }

    .font-heading {
      font-weight: bold;
      color: var(--primary-color);
    }

    .footer hr {
      border-color: var(--secondary-color);
    }

    .footer p {
      color: var(--primary-color);
      font-size: 0.95rem;
    }
  </style>
</head>

<body>

  <!-- Footer -->
  <footer class="footer">
    <div class="container">
      <div class="row">
        <!-- Left Column -->
        <div class="col-md-6 mb-4">
          <h5 class="font-heading mb-3">AUNTY CO'S KITCHEN</h5>
          <div class="footer-info">
            <i class="fas fa-map-marker-alt"></i>
            Micah Hotel, Yaoundé, montée chapel Obili, Cameroon
          </div>
          <div class="footer-info">
            <i class="fas fa-phone"></i>
            +237 654 091 559
          </div>
          <div class="footer-info">
            <i class="fas fa-envelope"></i>
            info@auntycoskitchen.com
          </div>
        </div>

        <!-- Right Column -->
        <div class="col-md-6 mb-4">
          <h5 class="font-heading mb-3">Operating Hours</h5>
          <div class="footer-info">
            <i class="fas fa-clock"></i>
            Monday - Sunday: 8:00 AM - 8:00 PM
          </div>
          <div class="footer-info">
            <i class="fas fa-calendar"></i>
            Open 7 Days a Week
          </div>
          <div class="social-links mt-3">
            <a href="#"><i class="fab fa-whatsapp"></i></a>
            <a href="#"><i class="fab fa-facebook"></i></a>
            <a href="#"><i class="fab fa-instagram"></i></a>
          </div>
        </div>
      </div>

      <hr class="my-4" />
      <div class="row">
        <div class="col-12 text-center">
          <p>&copy; 2025 Aunty Co's Kitchen. All rights reserved. | Made with ❤️</p>
         <a href="admin/login.php" style="text-decoration: none; color: #aaa; font-size: 0.9rem;">Admin Login</a>

        </div>
      </div>
    </div>
  </footer>

  <!-- Bootstrap JS -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>
