<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact - AUNTY CO'S KITCHEN</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="favicon.ico">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600&family=Open+Sans:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/contacts.css">
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