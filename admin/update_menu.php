<?php
// admin/update_menu.php
require_once 'db.php';
requireLogin();

$message = '';
$messageType = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Create upload directory if it doesn't exist
        $uploadDir = '../uploads/meals';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $pdo->beginTransaction();

        // Clear today's existing meals
        $clearStmt = $pdo->prepare("UPDATE daily_meals SET is_active = FALSE WHERE meal_date = CURDATE()");
        $clearStmt->execute();

        $allMealsAdded = true;
        $mealCount = 0;

        // Process each meal (1, 2, 3)
        for ($i = 1; $i <= 3; $i++) {
            $mealName = trim($_POST["meal_name_$i"] ?? '');
            $mealDesc = trim($_POST["meal_description_$i"] ?? '');
            $mealPrice = floatval($_POST["meal_price_$i"] ?? 0);

            // Skip if meal data is empty
            if (empty($mealName) || empty($mealDesc) || $mealPrice <= 0) {
                continue;
            }

            $mealImage = '';

            // Handle image upload
            if (isset($_FILES["meal_image_$i"]) && $_FILES["meal_image_$i"]['error'] === UPLOAD_ERR_OK) {
                $uploadResult = uploadImage($_FILES["meal_image_$i"], $uploadDir);
                if ($uploadResult['success']) {
                    $mealImage = $uploadResult['filename'];
                } else {
                    throw new Exception("Error uploading image for Meal $i: " . $uploadResult['message']);
                }
            } else {
                throw new Exception("Please upload an image for Meal $i");
            }

            // Insert meal into database
            $insertStmt = $pdo->prepare("
                INSERT INTO daily_meals (meal_name, meal_description, meal_price, meal_image, meal_date, meal_order, is_active) 
                VALUES (?, ?, ?, ?, CURDATE(), ?, TRUE)
            ");
            $insertStmt->execute([$mealName, $mealDesc, $mealPrice, $mealImage, $i]);
            $mealCount++;
        }

        if ($mealCount === 0) {
            throw new Exception("Please add at least one meal");
        }

        $pdo->commit();
        $message = "Successfully updated today's menu with $mealCount meal(s)!";
        $messageType = 'success';

    } catch (Exception $e) {
        $pdo->rollBack();
        $message = "Error: " . $e->getMessage();
        $messageType = 'error';
    }
}

// Get existing meals for today
try {
    $existingMealsStmt = $pdo->prepare("SELECT * FROM daily_meals WHERE meal_date = CURDATE() AND is_active = TRUE ORDER BY meal_order");
    $existingMealsStmt->execute();
    $existingMeals = $existingMealsStmt->fetchAll();
} catch (PDOException $e) {
    $existingMeals = [];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Menu - Admin Dashboard</title>
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
            background-color: #f8f9fa;
            color: #333;
            line-height: 1.6;
        }

        .admin-header {
            background: linear-gradient(135deg, #d4a574, #b8956a);
            color: white;
            padding: 1rem 0;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .header-content {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 20px;
        }

        .logo {
            font-family: 'Playfair Display', serif;
            font-size: 1.5rem;
            font-weight: 600;
        }

        .admin-nav {
            display: flex;
            gap: 20px;
            align-items: center;
        }

        .admin-nav a {
            color: white;
            text-decoration: none;
            padding: 8px 15px;
            border-radius: 5px;
            transition: background 0.3s ease;
        }

        .admin-nav a:hover, .admin-nav a.active {
            background: rgba(255,255,255,0.2);
        }

        .main-content {
            max-width: 1000px;
            margin: 0 auto;
            padding: 30px 20px;
        }

        .page-header {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            margin-bottom: 30px;
            text-align: center;
        }

        .page-header h1 {
            font-family: 'Playfair Display', serif;
            color: #d4a574;
            font-size: 2.2rem;
            margin-bottom: 10px;
        }

        .page-header p {
            color: #666;
            font-size: 1.1rem;
        }

        .current-date {
            background: #fff3e0;
            border-left: 4px solid #d4a574;
            padding: 15px 20px;
            margin-bottom: 30px;
            border-radius: 0 10px 10px 0;
        }

        .current-date h3 {
            color: #d4a574;
            margin-bottom: 5px;
        }

        .menu-form {
            background: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            margin-bottom: 30px;
        }

        .meal-section {
            border: 2px solid #f0f0f0;
            border-radius: 15px;
            padding: 30px;
            margin-bottom: 30px;
            transition: all 0.3s ease;
        }

        .meal-section:hover {
            border-color: #d4a574;
            box-shadow: 0 5px 15px rgba(212, 165, 116, 0.1);
        }

        .meal-section h3 {
            font-family: 'Playfair Display', serif;
            color: #d4a574;
            font-size: 1.5rem;
            margin-bottom: 20px;
            text-align: center;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: 600;
        }

        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 1rem;
            transition: all 0.3s ease;
            font-family: 'Open Sans', sans-serif;
        }

        .form-group input:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #d4a574;
            box-shadow: 0 0 0 3px rgba(212, 165, 116, 0.1);
        }

        .form-group textarea {
            resize: vertical;
            min-height: 100px;
        }

        .image-upload {
            position: relative;
            border: 2px dashed #d4a574;
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            background: #fafafa;
            transition: all 0.3s ease;
        }

        .image-upload:hover {
            background: #f5f5f5;
            border-color: #b8956a;
        }

        .image-upload input[type="file"] {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            cursor: pointer;
        }

        .upload-text {
            color: #d4a574;
            font-weight: 600;
        }

        .upload-hint {
            color: #666;
            font-size: 0.9rem;
            margin-top: 5px;
        }

        .submit-btn {
            background: linear-gradient(135deg, #d4a574, #b8956a);
            color: white;
            padding: 18px 40px;
            border: none;
            border-radius: 10px;
            font-size: 1.2rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            width: 100%;
            margin-top: 20px;
        }

        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(212, 165, 116, 0.3);
        }

        .message {
            padding: 15px 20px;
            border-radius: 10px;
            margin-bottom: 20px;
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

        .existing-meals {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            margin-bottom: 30px;
        }

        .existing-meals h3 {
            font-family: 'Playfair Display', serif;
            color: #d4a574;
            margin-bottom: 20px;
        }

        .existing-meal {
            display: flex;
            align-items: center;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 10px;
            margin-bottom: 15px;
            border-left: 4px solid #d4a574;
        }

        .existing-meal img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 8px;
            margin-right: 15px;
        }

        .meal-details h4 {
            color: #333;
            margin-bottom: 5px;
        }

        .meal-details p {
            color: #666;
            font-size: 0.9rem;
            margin-bottom: 3px;
        }

        .meal-price {
            color: #d4a574;
            font-weight: 600;
            margin-left: auto;
            font-size: 1.1rem;
        }

        @media (max-width: 768px) {
            .header-content {
                flex-direction: column;
                gap: 15px;
            }

            .admin-nav {
                flex-wrap: wrap;
                justify-content: center;
            }

            .form-row {
                grid-template-columns: 1fr;
            }

            .menu-form {
                padding: 25px;
            }

            .meal-section {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <header class="admin-header">
        <div class="header-content">
            <div class="logo">
                <i class="fas fa-utensils"></i> AUNTY CO'S KITCHEN Admin
            </div>
            <nav class="admin-nav">
                <a href="dashboard.php"><i class="fas fa-home"></i> Dashboard</a>
                <a href="update_menu.php" class="active"><i class="fas fa-utensils"></i> Update Menu</a>
                <a href="update_gallery.php"><i class="fas fa-images"></i> Gallery</a>
                <a href="view_reservations.php"><i class="fas fa-calendar"></i> Reservations</a>
                <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
            </nav>
        </div>
    </header>

    <main class="main-content">
        <div class="page-header">
            <h1><i class="fas fa-utensils"></i> Update Daily Menu</h1>
            <p>Set today's 3 special meals with images, descriptions, and prices</p>
        </div>

        <div class="current-date">
            <h3><i class="fas fa-calendar-day"></i> Today's Date</h3>
            <p><?php echo date('l, F j, Y'); ?></p>
        </div>

        <?php if ($message): ?>
            <div class="message <?php echo $messageType; ?>">
                <i class="fas fa-<?php echo $messageType === 'success' ? 'check-circle' : 'exclamation-circle'; ?>"></i>
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($existingMeals)): ?>
            <div class="existing-meals">
                <h3><i class="fas fa-clock"></i> Current Menu (<?php echo count($existingMeals); ?>/3 meals)</h3>
                <?php foreach ($existingMeals as $meal): ?>
                    <div class="existing-meal">
                        <img src="../uploads/meals/<?php echo htmlspecialchars($meal['meal_image']); ?>" 
                             alt="<?php echo htmlspecialchars($meal['meal_name']); ?>">
                        <div class="meal-details">
                            <h4>Meal <?php echo $meal['meal_order']; ?>: <?php echo htmlspecialchars($meal['meal_name']); ?></h4>
                            <p><?php echo htmlspecialchars($meal['meal_description']); ?></p>
                            <p><small>Added: <?php echo formatDateTime($meal['created_at']); ?></small></p>
                        </div>
                        <div class="meal-price">
                            <?php echo formatPrice($meal['meal_price']); ?>
                        </div>
                    </div>
                <?php endforeach; ?>
                <p style="color: #666; margin-top: 15px;">
                    <i class="fas fa-info-circle"></i> 
                    Updating the menu will replace all current meals for today.
                </p>
            </div>
        <?php endif; ?>

        <form class="menu-form" method="POST" enctype="multipart/form-data">
            <!-- Meal 1 -->
            <div class="meal-section">
                <h3><i class="fas fa-star"></i> Special Meal 1</h3>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="meal_name_1">Meal Name *</label>
                        <input type="text" id="meal_name_1" name="meal_name_1" required 
                               placeholder="e.g., Grilled Salmon Special">
                    </div>
                    <div class="form-group">
                        <label for="meal_price_1">Price (FCFA) *</label>
                        <input type="number" id="meal_price_1" name="meal_price_1" required 
                               min="0" step="100" placeholder="e.g., 8500">
                    </div>
                </div>

                <div class="form-group">
                    <label for="meal_description_1">Description *</label>
                    <textarea id="meal_description_1" name="meal_description_1" required 
                              placeholder="Describe the meal, ingredients, and what makes it special..."></textarea>
                </div>

                <div class="form-group">
                    <label for="meal_image_1">Meal Image *</label>
                    <div class="image-upload">
                        <input type="file" id="meal_image_1" name="meal_image_1" 
                               accept="image/jpeg,image/jpg,image/png,image/gif" required>
                        <div class="upload-text">
                            <i class="fas fa-cloud-upload-alt"></i> Click to upload image
                        </div>
                        <div class="upload-hint">JPG, PNG, GIF (Max 5MB)</div>
                    </div>
                </div>
            </div>

            <!-- Meal 2 -->
            <div class="meal-section">
                <h3><i class="fas fa-star"></i> Special Meal 2</h3>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="meal_name_2">Meal Name *</label>
                        <input type="text" id="meal_name_2" name="meal_name_2" required 
                               placeholder="e.g., Cameroon Beef Stew">
                    </div>
                    <div class="form-group">
                        <label for="meal_price_2">Price (FCFA) *</label>
                        <input type="number" id="meal_price_2" name="meal_price_2" required 
                               min="0" step="100" placeholder="e.g., 6500">
                    </div>
                </div>

                <div class="form-group">
                    <label for="meal_description_2">Description *</label>
                    <textarea id="meal_description_2" name="meal_description_2" required 
                              placeholder="Describe the meal, ingredients, and what makes it special..."></textarea>
                </div>

                <div class="form-group">
                    <label for="meal_image_2">Meal Image *</label>
                    <div class="image-upload">
                        <input type="file" id="meal_image_2" name="meal_image_2" 
                               accept="image/jpeg,image/jpg,image/png,image/gif" required>
                        <div class="upload-text">
                            <i class="fas fa-cloud-upload-alt"></i> Click to upload image
                        </div>
                        <div class="upload-hint">JPG, PNG, GIF (Max 5MB)</div>
                    </div>
                </div>
            </div>

            <!-- Meal 3 -->
            <div class="meal-section">
                <h3><i class="fas fa-star"></i> Special Meal 3</h3>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="meal_name_3">Meal Name *</label>
                        <input type="text" id="meal_name_3" name="meal_name_3" required 
                               placeholder="e.g., Signature Jollof Rice">
                    </div>
                    <div class="form-group">
                        <label for="meal_price_3">Price (FCFA) *</label>
                        <input type="number" id="meal_price_3" name="meal_price_3" required 
                               min="0" step="100" placeholder="e.g., 5500">
                    </div>
                </div>

                <div class="form-group">
                    <label for="meal_description_3">Description *</label>
                    <textarea id="meal_description_3" name="meal_description_3" required 
                              placeholder="Describe the meal, ingredients, and what makes it special..."></textarea>
                </div>

                <div class="form-group">
                    <label for="meal_image_3">Meal Image *</label>
                    <div class="image-upload">
                        <input type="file" id="meal_image_3" name="meal_image_3" 
                               accept="image/jpeg,image/jpg,image/png,image/gif" required>
                        <div class="upload-text">
                            <i class="fas fa-cloud-upload-alt"></i> Click to upload image
                        </div>
                        <div class="upload-hint">JPG, PNG, GIF (Max 5MB)</div>
                    </div>
                </div>
            </div>

            <button type="submit" class="submit-btn">
                <i class="fas fa-save"></i> Update Today's Menu
            </button>
        </form>
    </main>

    <script>
        // Image upload preview
        document.querySelectorAll('input[type="file"]').forEach(input => {
            input.addEventListener('change', function(e) {
                const file = e.target.files[0];
                const uploadDiv = e.target.parentElement;
                
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        uploadDiv.style.backgroundImage = `url(${e.target.result})`;
                        uploadDiv.style.backgroundSize = 'cover';
                        uploadDiv.style.backgroundPosition = 'center';
                        uploadDiv.querySelector('.upload-text').innerHTML = '<i class="fas fa-check-circle"></i> Image selected';
                        uploadDiv.querySelector('.upload-hint').innerHTML = file.name;
                    };
                    reader.readAsDataURL(file);
                }
            });
        });

        // Form validation
        document.querySelector('.menu-form').addEventListener('submit', function(e) {
            const requiredFields = document.querySelectorAll('input[required], textarea[required]');
            let allValid = true;

            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    allValid = false;
                    field.style.borderColor = '#dc3545';
                }
            });

            if (!allValid) {
                e.preventDefault();
                alert('Please fill in all required fields and upload images for all meals.');
                return false;
            }

            // Show loading state
            const submitBtn = document.querySelector('.submit-btn');
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Updating Menu...';
            submitBtn.disabled = true;
        });

        // Reset border color on input
        document.querySelectorAll('input, textarea').forEach(field => {
            field.addEventListener('input', function() {
                this.style.borderColor = '#e0e0e0';
            });
        });
    </script>
</body>
</html>