<?php
// admin/includes/db.php
// Database connection and helper functions

// Database configuration
$db_host = 'localhost';
$db_username = 'root';
$db_password = '';
$db_name = 'aunty_cos_kitchen';

try {
    $pdo = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8mb4", $db_username, $db_password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
} catch (PDOException $e) {
    error_log("Database connection failed: " . $e->getMessage());
    die("Connection failed. Please contact the administrator.");
}

// Start session safely
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Admin authentication
function isLoggedIn() {
    return isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true;
}

function requireLogin() {
    if (!isLoggedIn()) {
        header('Location: login.php');
        exit();
    }
}

function loginAdmin($username, $password, $pdo) {
    try {
        $stmt = $pdo->prepare("SELECT id, username, password FROM admin_users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch();
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_id'] = $user['id'];
            $_SESSION['admin_username'] = $user['username'];
            return true;
        }
        return false;
    } catch (PDOException $e) {
        error_log("Login error: " . $e->getMessage());
        return false;
    }
}

function logoutAdmin() {
    session_destroy();
    header('Location: login.php');
    exit();
}

// File upload
function uploadImage($file, $uploadDir, $allowedTypes = ['jpg','jpeg','png','gif']) {
    if (!isset($file) || $file['error'] !== UPLOAD_ERR_OK) {
        return ['success'=>false,'message'=>'No file uploaded or upload error'];
    }

    if ($file['size'] > 5*1024*1024) {
        return ['success'=>false,'message'=>'File size too large (max 5MB)'];
    }

    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    if (!in_array($ext, $allowedTypes)) {
        return ['success'=>false,'message'=>'Invalid file type. Allowed: '.implode(', ',$allowedTypes)];
    }

    if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);

    $fileName = uniqid().'_'.time().'.'.$ext;
    $filePath = $uploadDir.'/'.$fileName;

    if (move_uploaded_file($file['tmp_name'],$filePath)) {
        return ['success'=>true,'filename'=>$fileName,'filepath'=>$filePath];
    } else {
        return ['success'=>false,'message'=>'Failed to move uploaded file'];
    }
}

// Utilities
function sanitizeInput($input) {
    return htmlspecialchars(trim($input), ENT_QUOTES,'UTF-8');
}

function formatPrice($price) {
    return number_format($price,0).' FCFA';
}

function formatDate($date) {
    return date('F j, Y', strtotime($date));
}

function formatDateTime($datetime) {
    return date('M j, Y g:i A', strtotime($datetime));
}
?>
