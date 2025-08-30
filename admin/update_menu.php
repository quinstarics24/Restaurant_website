<?php
require_once '../includes/db_connect.php'; // defines $conn

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Admin login check
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}

$message = '';
$messageType = '';

function uploadImage($file, $uploadDir) {
    $allowed = ['jpg','jpeg','png','gif'];
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    if (!in_array($ext, $allowed)) return ['success'=>false,'message'=>'Invalid file type'];
    
    $filename = time() . '_' . rand(1000,9999) . '.' . $ext;
    if (move_uploaded_file($file['tmp_name'], "$uploadDir/$filename")) {
        return ['success'=>true,'filename'=>$filename];
    }
    return ['success'=>false,'message'=>'Upload failed'];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $uploadDir = '../uploads/meals';
        if (!is_dir($uploadDir)) mkdir($uploadDir,0755,true);

        // Deactivate all existing meals
        $conn->query("UPDATE menu_items SET is_available = 0");

        $mealCount = 0;

        for ($i=1;$i<=3;$i++) {
            $name = trim($_POST["meal_name_$i"] ?? '');
            $desc = trim($_POST["meal_description_$i"] ?? '');
            $price = floatval($_POST["meal_price_$i"] ?? 0);

            if (empty($name) || empty($desc) || $price <= 0) continue;

            if (!isset($_FILES["meal_image_$i"]) || $_FILES["meal_image_$i"]['error'] !== UPLOAD_ERR_OK) {
                throw new Exception("Please upload an image for Meal $i");
            }

            $uploadResult = uploadImage($_FILES["meal_image_$i"], $uploadDir);
            if (!$uploadResult['success']) throw new Exception($uploadResult['message']);
            $image = $uploadResult['filename'];

            $stmt = $conn->prepare("INSERT INTO menu_items (name, description, price, image, is_available, created_at) VALUES (?, ?, ?, ?, 1, NOW())");
            $stmt->bind_param("ssds", $name, $desc, $price, $image);
            $stmt->execute();

            $mealCount++;
        }

        if ($mealCount === 0) throw new Exception("Add at least one meal");

        $message = "Today's menu updated with $mealCount meal(s)!";
        $messageType = 'success';

    } catch(Exception $e) {
        $message = "Error: ".$e->getMessage();
        $messageType = 'error';
    }
}

// Fetch current available meals
$result = $conn->query("SELECT * FROM menu_items WHERE is_available = 1 ORDER BY id ASC");
$existingMeals = $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Update Menu - Admin Dashboard</title>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
<style>
    /* Admin Menu Update - Professional Styling */

/* Reset and Base Styles */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: #f8f9fa;
    color: #2c3e50;
    line-height: 1.6;
    min-height: 100vh;
}

/* Main Content */
.main-content {
    max-width: 1000px;
    margin: 0 auto;
    padding: 40px 20px;
    background: white;
    min-height: calc(100vh - 80px);
    box-shadow: 0 0 20px rgba(0,0,0,0.1);
}

/* Page Title */
.main-content h1 {
    font-size: 2.5rem;
    color: #2c3e50;
    margin-bottom: 30px;
    padding-bottom: 15px;
    border-bottom: 3px solid #3498db;
    font-weight: 600;
    position: relative;
}

.main-content h1::after {
    content: '';
    position: absolute;
    bottom: -3px;
    left: 0;
    width: 80px;
    height: 3px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 2px;
}

/* Messages */
.message {
    padding: 16px 20px;
    border-radius: 8px;
    margin-bottom: 25px;
    font-weight: 500;
    display: flex;
    align-items: center;
    gap: 12px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.message::before {
    font-family: "Font Awesome 6 Free";
    font-weight: 900;
    font-size: 1.2rem;
}

.message.success {
    background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
    color: #155724;
    border-left: 4px solid #28a745;
}

.message.success::before {
    content: "\f058"; /* check-circle */
    color: #28a745;
}

.message.error {
    background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%);
    color: #721c24;
    border-left: 4px solid #dc3545;
}

.message.error::before {
    content: "\f06a"; /* exclamation-triangle */
    color: #dc3545;
}

/* Current Menu Section */
.main-content h3 {
    font-size: 1.5rem;
    color: #495057;
    margin: 30px 0 20px;
    padding: 12px 0;
    border-bottom: 2px solid #e9ecef;
    font-weight: 600;
}

/* Current Menu Items */
.main-content > div {
    background: #f8f9fa;
    border: 1px solid #dee2e6;
    border-radius: 12px;
    padding: 20px;
    margin-bottom: 15px;
    display: flex;
    align-items: center;
    gap: 20px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.06);
    transition: all 0.3s ease;
}

.main-content > div:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}

.main-content > div img {
    border-radius: 8px;
    object-fit: cover;
    height: 80px;
    width: 120px;
    border: 2px solid #dee2e6;
    transition: transform 0.3s ease;
}

.main-content > div img:hover {
    transform: scale(1.05);
}

.main-content > div strong {
    color: #2c3e50;
    font-size: 1.1rem;
    font-weight: 600;
}

.main-content > div p {
    margin-top: 8px;
    color: #6c757d;
    font-size: 0.95rem;
    line-height: 1.5;
}

/* Horizontal Rule */
hr {
    border: none;
    height: 2px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    margin: 40px 0;
    border-radius: 1px;
}

/* Form Styling */
form {
    margin-top: 30px;
}

/* Fieldsets */
fieldset {
    border: 2px solid #e9ecef;
    border-radius: 12px;
    padding: 25px;
    margin-bottom: 25px;
    background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    transition: all 0.3s ease;
}

fieldset:hover {
    border-color: #3498db;
    box-shadow: 0 4px 15px rgba(52, 152, 219, 0.1);
}

fieldset legend {
    font-weight: 600;
    color: #2c3e50;
    padding: 8px 16px;
    background: linear-gradient(135deg, #3498db 0%, #2980b9 100%);
    color: white;
    border-radius: 20px;
    font-size: 1rem;
    margin-left: 20px;
    box-shadow: 0 2px 8px rgba(52, 152, 219, 0.3);
}

/* Labels */
label {
    display: block;
    font-weight: 600;
    margin-bottom: 8px;
    margin-top: 20px;
    color: #495057;
    font-size: 0.95rem;
}

label:first-of-type {
    margin-top: 0;
}

/* Input Fields */
input[type="text"],
input[type="number"],
textarea,
input[type="file"] {
    width: 100%;
    padding: 12px 16px;
    border: 2px solid #e9ecef;
    border-radius: 8px;
    font-size: 1rem;
    transition: all 0.3s ease;
    background: #ffffff;
    font-family: inherit;
}

input[type="text"]:focus,
input[type="number"]:focus,
textarea:focus {
    outline: none;
    border-color: #3498db;
    box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.1);
    background: #ffffff;
}

/* Textarea */
textarea {
    resize: vertical;
    min-height: 100px;
    line-height: 1.5;
}

/* File Input */
input[type="file"] {
    padding: 10px;
    background: #f8f9fa;
    border-style: dashed;
    cursor: pointer;
    position: relative;
}

input[type="file"]:hover {
    background: #e9ecef;
    border-color: #3498db;
}

input[type="file"]:focus {
    border-color: #3498db;
    box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.1);
}

/* Required Field Indicators */
input[required] {
    border-left: 4px solid #28a745;
}

input[required]:invalid {
    border-left-color: #dc3545;
}

/* Submit Button */
button[type="submit"] {
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
    color: white;
    border: none;
    padding: 16px 32px;
    font-size: 1.1rem;
    font-weight: 600;
    border-radius: 8px;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 12px;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);
    margin-top: 20px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

button[type="submit"]:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(40, 167, 69, 0.4);
    background: linear-gradient(135deg, #218838 0%, #1e7e34 100%);
}

button[type="submit"]:active {
    transform: translateY(0);
}

button[type="submit"] i {
    font-size: 1rem;
}

/* Placeholder Styling */
::placeholder {
    color: #adb5bd;
    font-style: italic;
}

/* Current Menu Item Layout for Mobile */
@media (max-width: 768px) {
    .main-content {
        padding: 20px 15px;
        margin: 0;
        box-shadow: none;
    }

    .main-content h1 {
        font-size: 2rem;
        margin-bottom: 25px;
    }

    .main-content > div {
        flex-direction: column;
        text-align: center;
        padding: 15px;
    }

    .main-content > div img {
        width: 100%;
        max-width: 200px;
        height: auto;
        margin-bottom: 15px;
    }

    fieldset {
        padding: 20px 15px;
        margin-bottom: 20px;
    }

    fieldset legend {
        font-size: 0.9rem;
        padding: 6px 12px;
        margin-left: 10px;
    }

    button[type="submit"] {
        width: 100%;
        justify-content: center;
        padding: 18px;
        font-size: 1rem;
    }
}

@media (max-width: 480px) {
    .main-content h1 {
        font-size: 1.75rem;
    }

    fieldset {
        padding: 15px 10px;
    }

    input[type="text"],
    input[type="number"],
    textarea,
    input[type="file"] {
        padding: 10px 12px;
        font-size: 0.95rem;
    }

    label {
        font-size: 0.9rem;
    }
}

/* Loading Animation for Form Submission */
button[type="submit"]:disabled {
    opacity: 0.7;
    cursor: not-allowed;
    transform: none;
}

button[type="submit"]:disabled::after {
    content: '';
    width: 16px;
    height: 16px;
    border: 2px solid #ffffff;
    border-top-color: transparent;
    border-radius: 50%;
    animation: spin 0.8s linear infinite;
    margin-left: 8px;
}

@keyframes spin {
    to {
        transform: rotate(360deg);
    }
}

/* Form Validation Feedback */
input:valid {
    border-left-color: #28a745;
}

input:invalid:not(:placeholder-shown) {
    border-left-color: #dc3545;
}

/* Smooth Transitions */
* {
    transition: border-color 0.3s ease, box-shadow 0.3s ease;
}

/* Focus Indicators for Accessibility */
*:focus {
    outline: 2px solid #3498db;
    outline-offset: 2px;
}
</style>
</head>

<body>
<?php include 'header.php'; ?>

<main class="main-content">
    <h1>Update Today's Menu</h1>

    <?php if ($message): ?>
        <div class="message <?php echo $messageType; ?>">
            <?php echo htmlspecialchars($message); ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($existingMeals)): ?>
        <h3>Current Menu (<?php echo count($existingMeals); ?>/3)</h3>
        <?php foreach ($existingMeals as $meal): ?>
            <div>
                <img src="../uploads/meals/<?php echo htmlspecialchars($meal['image']); ?>" alt="<?php echo htmlspecialchars($meal['name']); ?>" width="120">
                <strong><?php echo htmlspecialchars($meal['name']); ?></strong> - <?php echo number_format($meal['price']); ?> FCFA
                <p><?php echo htmlspecialchars($meal['description']); ?></p>
            </div>
        <?php endforeach; ?>
        <hr>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data">
        <?php for($i=1;$i<=3;$i++): ?>
        <fieldset>
            <legend>Special Meal <?php echo $i; ?></legend>
            <label>Name *</label>
            <input type="text" name="meal_name_<?php echo $i; ?>" required placeholder="Meal name">

            <label>Price (FCFA) *</label>
            <input type="number" name="meal_price_<?php echo $i; ?>" required min="0" step="100" placeholder="Price">

            <label>Description *</label>
            <textarea name="meal_description_<?php echo $i; ?>" required placeholder="Description"></textarea>

            <label>Image *</label>
            <input type="file" name="meal_image_<?php echo $i; ?>" accept="image/*" required>
        </fieldset>
        <br>
        <?php endfor; ?>

        <button type="submit"><i class="fas fa-save"></i> Update Menu</button>
    </form>
</main>
</body>
</html>
