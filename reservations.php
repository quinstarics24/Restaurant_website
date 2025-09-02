<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservations - AUNTY CO'S KITCHEN</title>
    <link rel="icon" type="image/x-icon" href="favicon.ico">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600&family=Open+Sans:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/reserves.css">
       
</head>
<body>
        <?php include 'header.php'; ?>

    <main>
        <div class="reservation-header">
            <h1>Make a Reservation</h1>
            <p>Book your table at AUNTY CO'S KITCHEN for an unforgettable dining experience</p>
            
            <div class="info-banner">
                <i class="fas fa-info-circle"></i>
                <strong>Please note:</strong> Reservations are confirmed within 2 hours. For immediate bookings, please call us at +237 654091559
            </div>
        </div>

        <?php
        // PHP code for handling reservation form submission
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
                $guests = (int)$_POST['guests'];
                $date = $_POST['date'];
                $time = $_POST['time'];
                $special_requests = trim($_POST['special_requests']);
                
                // Handle special requirements (checkboxes)
                $special_requirements = [];
                if (isset($_POST['birthday'])) $special_requirements[] = 'Birthday Celebration';
                if (isset($_POST['anniversary'])) $special_requirements[] = 'Anniversary';
                if (isset($_POST['wheelchair'])) $special_requirements[] = 'Wheelchair Access';
                if (isset($_POST['highchair'])) $special_requirements[] = 'High Chair';
                if (isset($_POST['quiet'])) $special_requirements[] = 'Quiet Table';
                $special_requirements_str = implode(', ', $special_requirements);

                // Validate required fields
                if (empty($name) || empty($email) || empty($phone) || empty($date) || empty($time) || $guests < 1) {
                    throw new Exception("Please fill in all required fields.");
                }

                // Validate email
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    throw new Exception("Please enter a valid email address.");
                }

                // Validate date (must be today or future)
                $reservation_date = new DateTime($date);
                $today = new DateTime();
                $today->setTime(0, 0, 0);
                
                if ($reservation_date < $today) {
                    throw new Exception("Reservation date must be today or in the future.");
                }

                // Validate guest count
                if ($guests > 12) {
                    throw new Exception("For parties larger than 12 guests, please call us directly.");
                }

                // Generate reservation ID
                $reservation_id = 'RES-' . date('Y') . '-' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);

                // Insert into database
                $sql = "INSERT INTO reservations (reservation_id, name, email, phone, guests, reservation_date, reservation_time, special_requirements, special_requests, status, created_at) 
                        VALUES (:reservation_id, :name, :email, :phone, :guests, :reservation_date, :reservation_time, :special_requirements, :special_requests, 'pending', NOW())";
                
                $stmt = $pdo->prepare($sql);
                $stmt->execute([
                    ':reservation_id' => $reservation_id,
                    ':name' => $name,
                    ':email' => $email,
                    ':phone' => $phone,
                    ':guests' => $guests,
                    ':reservation_date' => $date,
                    ':reservation_time' => $time,
                    ':special_requirements' => $special_requirements_str,
                    ':special_requests' => $special_requests
                ]);

                $message = "Reservation successful! Your reservation ID is: <strong>$reservation_id</strong><br>
                          We'll confirm your booking within 2 hours via email or phone.";
                $messageType = 'success';

                // Clear form data after successful submission
                $_POST = array();

            } catch (Exception $e) {
                $message = "Error: " . $e->getMessage();
                $messageType = 'error';
            }
        }

        // Set minimum date to today
        $today = date('Y-m-d');
        $maxDate = date('Y-m-d', strtotime('+3 months'));
        ?>

        <?php if ($message): ?>
            <div class="message <?php echo $messageType; ?>">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <form class="reservation-form" method="POST" action="">
            <!-- Personal Information -->
            <div class="form-section">
                <h2><i class="fas fa-user"></i> Personal Information</h2>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="name">Full Name *</label>
                        <input type="text" id="name" name="name" required 
                               value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?>">
                    </div>
                    <div class="form-group">
                        <label for="email">Email Address *</label>
                        <input type="email" id="email" name="email" required
                               value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label for="phone">Phone Number *</label>
                    <input type="tel" id="phone" name="phone" required
                           value="<?php echo isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : ''; ?>">
                    <small>We'll use this to confirm your reservation</small>
                </div>
            </div>

            <!-- Reservation Details -->
            <div class="form-section">
                <h2><i class="fas fa-calendar-alt"></i> Reservation Details</h2>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="date">Date *</label>
                        <input type="date" id="date" name="date" required 
                               min="<?php echo $today; ?>" max="<?php echo $maxDate; ?>"
                               value="<?php echo isset($_POST['date']) ? $_POST['date'] : ''; ?>">
                    </div>
                    <div class="form-group">
                        <label for="guests">Number of Guests *</label>
                        <select id="guests" name="guests" required>
                            <option value="">Select guests</option>
                            <?php for($i = 1; $i <= 12; $i++): ?>
                                <option value="<?php echo $i; ?>" 
                                    <?php echo (isset($_POST['guests']) && $_POST['guests'] == $i) ? 'selected' : ''; ?>>
                                    <?php echo $i; ?> <?php echo $i == 1 ? 'Guest' : 'Guests'; ?>
                                </option>
                            <?php endfor; ?>
                        </select>
                        <small>For parties larger than 12, please call us</small>
                    </div>
                </div>

                <div class="form-group">
                    <label>Preferred Time *</label>
                    <div class="time-slots">
                        <?php 
                        $time_slots = ['11:30', '12:00', '12:30', '13:00', '13:30', '14:00', '18:00', '18:30', '19:00', '19:30', '20:00', '20:30'];
                        foreach($time_slots as $slot): 
                        ?>
                            <div class="time-slot">
                                <input type="radio" id="time_<?php echo str_replace(':', '', $slot); ?>" name="time" value="<?php echo $slot; ?>" required
                                       <?php echo (isset($_POST['time']) && $_POST['time'] == $slot) ? 'checked' : ''; ?>>
                                <label for="time_<?php echo str_replace(':', '', $slot); ?>"><?php echo $slot; ?></label>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <!-- Special Requirements -->
            <div class="form-section">
                <h2><i class="fas fa-star"></i> Special Requirements</h2>
                
                <div class="special-options">
                    <div class="checkbox-group">
                        <input type="checkbox" id="birthday" name="birthday" 
                               <?php echo isset($_POST['birthday']) ? 'checked' : ''; ?>>
                        <label for="birthday">Birthday Celebration</label>
                    </div>
                    <div class="checkbox-group">
                        <input type="checkbox" id="anniversary" name="anniversary"
                               <?php echo isset($_POST['anniversary']) ? 'checked' : ''; ?>>
                        <label for="anniversary">Anniversary</label>
                    </div>
                    <div class="checkbox-group">
                        <input type="checkbox" id="wheelchair" name="wheelchair"
                               <?php echo isset($_POST['wheelchair']) ? 'checked' : ''; ?>>
                        <label for="wheelchair">Wheelchair Access</label>
                    </div>
                    <div class="checkbox-group">
                        <input type="checkbox" id="highchair" name="highchair"
                               <?php echo isset($_POST['highchair']) ? 'checked' : ''; ?>>
                        <label for="highchair">High Chair Needed</label>
                    </div>
                    <div class="checkbox-group">
                        <input type="checkbox" id="quiet" name="quiet"
                               <?php echo isset($_POST['quiet']) ? 'checked' : ''; ?>>
                        <label for="quiet">Quiet Table</label>
                    </div>
                </div>

                <div class="form-group" style="margin-top: 20px;">
                    <label for="special_requests">Additional Requests</label>
                    <textarea id="special_requests" name="special_requests" 
                              placeholder="Any dietary restrictions, allergies, or special requests..."><?php echo isset($_POST['special_requests']) ? htmlspecialchars($_POST['special_requests']) : ''; ?></textarea>
                </div>
            </div>

            <button type="submit" class="submit-btn">
                <i class="fas fa-check-circle"></i> Make Reservation
            </button>
        </form>
    </main>

        <?php include 'footer.php'; ?>

    <script>
        // Auto-update minimum date
        document.addEventListener('DOMContentLoaded', function() {
            const dateInput = document.getElementById('date');
            const today = new Date().toISOString().split('T')[0];
            dateInput.setAttribute('min', today);
        });

        // Form validation
        document.querySelector('.reservation-form').addEventListener('submit', function(e) {
            const date = document.getElementById('date').value;
            const time = document.querySelector('input[name="time"]:checked');
            const guests = document.getElementById('guests').value;

            if (!date || !time || !guests) {
                e.preventDefault();
                alert('Please fill in all required fields.');
                return;
            }

            // Check if date is not in the past
            const selectedDate = new Date(date);
            const today = new Date();
            today.setHours(0, 0, 0, 0);

            if (selectedDate < today) {
                e.preventDefault();
                alert('Please select a current or future date.');
                return;
            }
        });
    </script>
</body>
</html>