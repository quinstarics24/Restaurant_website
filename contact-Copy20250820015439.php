<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact - AUNTY CO'S KITCHEN</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600&family=Open+Sans:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Open Sans', sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #fafafa;
        }

        /* Main Content */
        main {
            max-width: 1200px;
            margin: 0 auto;
            padding: 90px 30px;
        }

        .contact-header {
            text-align: center;
            margin-bottom: 50px;
        }

        .contact-header h1 {
            font-family: 'Playfair Display', serif;
            font-size: 2.5rem;
            color: #d4a574;
            margin-bottom: 15px;
        }

        .contact-header p {
            font-size: 1.1rem;
            color: #666;
            max-width: 600px;
            margin: 0 auto;
        }

        /* Contact Container */
        .contact-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
            margin-bottom: 40px;
        }

        /* Contact Info */
        .contact-info {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .contact-info h2 {
            font-family: 'Playfair Display', serif;
            color: #d4a574;
            margin-bottom: 20px;
            font-size: 1.8rem;
        }

        .info-item {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
            padding: 15px;
            background: #f9f9f9;
            border-radius: 8px;
            transition: transform 0.3s ease;
        }

        .info-item:hover {
            transform: translateX(5px);
        }

        .info-item i {
            font-size: 1.5rem;
            color: #d4a574;
            margin-right: 15px;
            width: 30px;
            text-align: center;
        }

        .info-item div {
            flex: 1;
        }

        .info-item h3 {
            font-size: 1.1rem;
            margin-bottom: 5px;
            color: #333;
        }

        .info-item p {
            color: #666;
            font-size: 0.95rem;
        }

        .whatsapp-btn {
            display: inline-block;
            background: #25D366;
            color: white;
            padding: 12px 25px;
            text-decoration: none;
            border-radius: 25px;
            margin-top: 20px;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .whatsapp-btn:hover {
            background: #128C7E;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(37, 211, 102, 0.3);
        }

        .whatsapp-btn i {
            margin-right: 8px;
        }

        /* Contact Form */
        .contact-form {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .contact-form h2 {
            font-family: 'Playfair Display', serif;
            color: #d4a574;
            margin-bottom: 20px;
            font-size: 1.8rem;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: 500;
        }

        .form-group input,
        .form-group textarea,
        .form-group select {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 1rem;
            transition: border-color 0.3s ease;
            font-family: 'Open Sans', sans-serif;
        }

        .form-group input:focus,
        .form-group textarea:focus,
        .form-group select:focus {
            outline: none;
            border-color: #d4a574;
            box-shadow: 0 0 0 3px rgba(212, 165, 116, 0.1);
        }

        .form-group textarea {
            resize: vertical;
            min-height: 120px;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .submit-btn {
            background: #d4a574;
            color: white;
            padding: 15px 30px;
            border: none;
            border-radius: 8px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            width: 100%;
        }

        .submit-btn:hover {
            background: #b8956a;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(212, 165, 116, 0.3);
        }

        /* Map Section */
        .map-section {
            margin-top: 50px;
            text-align: center;
        }

        .map-section h2 {
            font-family: 'Playfair Display', serif;
            color: #d4a574;
            margin-bottom: 20px;
            font-size: 1.8rem;
        }

        .map-container {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .map-placeholder {
            width: 100%;
            height: 300px;
            background: #f0f0f0;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #666;
            font-size: 1.1rem;
        }

        /* Success/Error Messages */
        .message {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 8px;
            font-weight: 500;
        }

        .success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

    
        /* Mobile Responsiveness */
        @media (max-width: 768px) {
            .nav-links {
                flex-direction: column;
                gap: 15px;
            }

            .logo {
                font-size: 1.5rem;
            }

            .contact-container {
                grid-template-columns: 1fr;
                gap: 30px;
            }

            .form-row {
                grid-template-columns: 1fr;
                gap: 15px;
            }

            .contact-header h1 {
                font-size: 2rem;
            }

            main {
                padding: 20px 15px;
            }
        }

        @media (max-width: 480px) {
            nav {
                flex-direction: column;
                padding: 20px;
            }
        }
    </style>
</head>
<body>
   <?php include 'header.php'; ?>

    <main>
        <div class="contact-header">
            <h1>Get In Touch</h1>
            <p>We'd love to hear from you! Reach out for reservations, catering, or any questions about AUNTY CO'S KITCHEN</p>
        </div>

        <?php
        // PHP code for handling form submission
        $message = '';
        $messageType = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Database connection
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "aunty_cos_kitchen";

            try {
                $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                // Get form data
                $name = trim($_POST['name']);
                $email = trim($_POST['email']);
                $phone = trim($_POST['phone']);
                $subject = trim($_POST['subject']);
                $inquiry_message = trim($_POST['message']);

                // Validate required fields
                if (empty($name) || empty($email) || empty($inquiry_message)) {
                    throw new Exception("Please fill in all required fields.");
                }

                // Validate email
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    throw new Exception("Please enter a valid email address.");
                }

                // Insert into database
                $sql = "INSERT INTO contact_inquiries (name, email, phone, subject, message, created_at) 
                        VALUES (:name, :email, :phone, :subject, :message, NOW())";
                
                $stmt = $pdo->prepare($sql);
                $stmt->execute([
                    ':name' => $name,
                    ':email' => $email,
                    ':phone' => $phone,
                    ':subject' => $subject,
                    ':message' => $inquiry_message
                ]);

                $message = "Thank you for contacting us! We'll get back to you soon.";
                $messageType = 'success';

            } catch (Exception $e) {
                $message = "Error: " . $e->getMessage();
                $messageType = 'error';
            }
        }
        ?>

        <div class="contact-container">
            <!-- Contact Information -->
            <div class="contact-info">
                <h2>Visit Us</h2>
                
                <div class="info-item">
                    <i class="fas fa-map-marker-alt"></i>
                    <div>
                        <h3>Location</h3>
                        <p>Inside Micah Hotel<br>Yaoundé, Cameroon</p>
                    </div>
                </div>

                <div class="info-item">
                    <i class="fas fa-phone"></i>
                    <div>
                        <h3>Phone</h3>
                        <p>+237 654091559</p>
                    </div>
                </div>

                <div class="info-item">
                    <i class="fas fa-envelope"></i>
                    <div>
                        <h3>Email</h3>
                        <p>info@auntycoskitchen.com</p>
                    </div>
                </div>

                <div class="info-item">
                    <i class="fas fa-clock"></i>
                    <div>
                        <h3>Opening Hours</h3>
                        <p>Monday - Sunday<br>10:00 AM - 8:00 PM</p>
                    </div>
                </div>

                <a href="https://wa.me/237654091559" class="whatsapp-btn" target="_blank">
                    <i class="fab fa-whatsapp"></i>
                    Order via WhatsApp
                </a>
            </div>

            <!-- Contact Form -->
            <div class="contact-form">
                <h2>Send Us a Message</h2>
                
                <?php if ($message): ?>
                    <div class="message <?php echo $messageType; ?>">
                        <?php echo htmlspecialchars($message); ?>
                    </div>
                <?php endif; ?>

                <form method="POST" action="">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="name">Full Name *</label>
                            <input type="text" id="name" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email *</label>
                            <input type="email" id="email" name="email" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="phone">Phone Number</label>
                            <input type="tel" id="phone" name="phone">
                        </div>
                        <div class="form-group">
                            <label for="subject">Subject</label>
                            <select id="subject" name="subject">
                                <option value="">Select a subject</option>
                                <option value="reservation">Reservation Inquiry</option>
                                <option value="catering">Catering Services</option>
                                <option value="general">General Question</option>
                                <option value="feedback">Feedback</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="message">Message *</label>
                        <textarea id="message" name="message" placeholder="Tell us how we can help you..." required></textarea>
                    </div>

                    <button type="submit" class="submit-btn">Send Message</button>
                </form>
            </div>
        </div>

        <!-- Map Section -->
        <div class="map-section">
    <h2>Find Us</h2>
    <div class="map-container">
        <iframe
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d995.2050385329268!2d11.494893693252033!3d3.848750256322768!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x108bcfb8b073e995%3A0x84d5bf18fb6a3a71!2sMicah%20Hotel!5e0!3m2!1sen!2scm!4v1753957647503!5m2!1sen!2scm"
            width="100%"
            height="400"
            style="border:0;"
            allowfullscreen=""
            loading="lazy"
            referrerpolicy="no-referrer-when-downgrade">
        </iframe>
    </div>
</div>

    </main>

          <?php include 'footer.php'; ?>
</body>
</html>