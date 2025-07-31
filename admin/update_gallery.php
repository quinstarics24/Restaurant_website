<?php
// admin/update_gallery.php
require_once 'db.php';
requireLogin();

$message = '';
$messageType = '';
$view = $_GET['view'] ?? 'upload';

// Handle delete action
if (isset($_GET['delete'])) {
    try {
        $imageId = (int)$_GET['delete'];
        
        // Get image filename before deleting
        $stmt = $pdo->prepare("SELECT image_filename FROM gallery_images WHERE id = ?");
        $stmt->execute([$imageId]);
        $image = $stmt->fetch();
        
        if ($image) {
            // Delete from database
            $deleteStmt = $pdo->prepare("DELETE FROM gallery_images WHERE id = ?");
            $deleteStmt->execute([$imageId]);
            
            // Delete physical file
            $filePath = '../uploads/gallery/' . $image['image_filename'];
            if (file_exists($filePath)) {
                unlink($filePath);
            }
            
            $message = "Image deleted successfully!";
            $messageType = 'success';
        }
    } catch (Exception $e) {
        $message = "Error deleting image: " . $e->getMessage();
        $messageType = 'error';
    }
}

// Handle form submission for upload
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['upload_images'])) {
    try {
        $uploadDir = '../uploads/gallery';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $uploadedCount = 0;
        $errors = [];

        // Process each uploaded file
        if (isset($_FILES['gallery_images'])) {
            $fileCount = count($_FILES['gallery_images']['name']);
            
            for ($i = 0; $i < $fileCount; $i++) {
                if ($_FILES['gallery_images']['error'][$i] === UPLOAD_ERR_OK) {
                    $tempFile = [
                        'name' => $_FILES['gallery_images']['name'][$i],
                        'type' => $_FILES['gallery_images']['type'][$i],
                        'tmp_name' => $_FILES['gallery_images']['tmp_name'][$i],
                        'error' => $_FILES['gallery_images']['error'][$i],
                        'size' => $_FILES['gallery_images']['size'][$i]
                    ];
                    
                    $uploadResult = uploadImage($tempFile, $uploadDir);
                    
                    if ($uploadResult['success']) {
                        // Get form data for this image
                        $imageName = trim($_POST['image_names'][$i] ?? '');
                        $imageCategory = $_POST['image_categories'][$i] ?? 'daily-specials';
                        $imageDescription = trim($_POST['image_descriptions'][$i] ?? '');
                        
                        if (empty($imageName)) {
                            $imageName = pathinfo($_FILES['gallery_images']['name'][$i], PATHINFO_FILENAME);
                        }
                        
                        // Insert into database
                        $insertStmt = $pdo->prepare("
                            INSERT INTO gallery_images (image_name, image_filename, image_category, image_description, upload_date) 
                            VALUES (?, ?, ?, ?, CURDATE())
                        ");
                        $insertStmt->execute([$imageName, $uploadResult['filename'], $imageCategory, $imageDescription]);
                        $uploadedCount++;
                    } else {
                        $errors[] = "File " . $_FILES['gallery_images']['name'][$i] . ": " . $uploadResult['message'];
                    }
                }
            }
        }

        if ($uploadedCount > 0) {
            $message = "Successfully uploaded $uploadedCount image(s)!";
            $messageType = 'success';
        }
        
        if (!empty($errors)) {
            $message .= ($message ? ' ' : '') . "Errors: " . implode(', ', $errors);
            $messageType = $uploadedCount > 0 ? 'success' : 'error';
        }

    } catch (Exception $e) {
        $message = "Error: " . $e->getMessage();
        $messageType = 'error';
    }
}

// Get existing gallery images
try {
    $galleryStmt = $pdo->prepare("SELECT * FROM gallery_images ORDER BY created_at DESC");
    $galleryStmt->execute();
    $galleryImages = $galleryStmt->fetchAll();
} catch (PDOException $e) {
    $galleryImages = [];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gallery Management - Admin Dashboard</title>
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
            max-width: 1200px;
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

        .view-tabs {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-bottom: 30px;
        }

        .tab-btn {
            background: white;
            border: 2px solid #d4a574;
            color: #d4a574;
            padding: 12px 25px;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .tab-btn.active, .tab-btn:hover {
            background: #d4a574;
            color: white;
        }

        .upload-section {
            background: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            margin-bottom: 30px;
        }

        .upload-area {
            border: 3px dashed #d4a574;
            border-radius: 15px;
            padding: 40px;
            text-align: center;
            background: #fafafa;
            margin-bottom: 30px;
            transition: all 0.3s ease;
        }

        .upload-area:hover {
            background: #f5f5f5;
            border-color: #b8956a;
        }

        .upload-area input[type="file"] {
            display: none;
        }

        .upload-text {
            color: #d4a574;
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .upload-hint {
            color: #666;
            margin-bottom: 20px;
        }

        .upload-btn {
            background: linear-gradient(135deg, #d4a574, #b8956a);
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .upload-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(212, 165, 116, 0.3);
        }

        .image-preview {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .preview-item {
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .preview-item img {
            width: 100%;
            height: 150px;
            object-fit: cover;
        }

        .preview-details {
            padding: 15px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            color: #333;
            font-weight: 600;
            font-size: 0.9rem;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 8px 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 0.9rem;
        }

        .form-group textarea {
            height: 60px;
            resize: vertical;
        }

        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
        }

        .gallery-item {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }

        .gallery-item:hover {
            transform: translateY(-5px);
        }

        .gallery-item img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .gallery-info {
            padding: 20px;
        }

        .gallery-info h4 {
            color: #333;
            margin-bottom: 8px;
            font-size: 1.1rem;
        }

        .gallery-info p {
            color: #666;
            font-size: 0.9rem;
            margin-bottom: 10px;
        }

        .category-badge {
            display: inline-block;
            background: #d4a574;
            color: white;
            padding: 4px 10px;
            border-radius: 15px;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
            margin-bottom: 10px;
        }

        .delete-btn {
            background: #dc3545;
            color: white;
            padding: 8px 15px;
            border: none;
            border-radius: 5px;
            font-size: 0.9rem;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .delete-btn:hover {
            background: #c82333;
            transform: translateY(-1px);
        }

        .submit-btn {
            background: linear-gradient(135deg, #d4a574, #b8956a);
            color: white;
            padding: 15px 40px;
            border: none;
            border-radius: 10px;
            font-size: 1.1rem;
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

        .empty-state {
            text-align: center;
            color: #666;
            font-style: italic;
            padding: 40px;
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

            .view-tabs {
                flex-direction: column;
                align-items: center;
            }

            .image-preview {
                grid-template-columns: 1fr;
            }

            .gallery-grid {
                grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
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
                <a href="update_menu.php"><i class="fas fa-utensils"></i> Update Menu</a>
                <a href="update_gallery.php" class="active"><i class="fas fa-images"></i> Gallery</a>
                <a href="view_reservations.php"><i class="fas fa-calendar"></i> Reservations</a>
                <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
            </nav>
        </div>
    </header>

    <main class="main-content">
        <div class="page-header">
            <h1><i class="fas fa-images"></i> Gallery Management</h1>
            <p>Upload and manage images for your restaurant gallery</p>
        </div>

        <div class="view-tabs">
            <a href="?view=upload" class="tab-btn <?php echo $view === 'upload' ? 'active' : ''; ?>">
                <i class="fas fa-upload"></i> Upload Images
            </a>
            <a href="?view=manage" class="tab-btn <?php echo $view === 'manage' ? 'active' : ''; ?>">
                <i class="fas fa-cog"></i> Manage Gallery
            </a>
        </div>

        <?php if ($message): ?>
            <div class="message <?php echo $messageType; ?>">
                <i class="fas fa-<?php echo $messageType === 'success' ? 'check-circle' : 'exclamation-circle'; ?>"></i>
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>

        <?php if ($view === 'upload'): ?>
            <div class="upload-section">
                <h3 style="color: #d4a574; margin-bottom: 20px; font-family: 'Playfair Display', serif;">
                    <i class="fas fa-cloud-upload-alt"></i> Upload New Images
                </h3>
                
                <form method="POST" enctype="multipart/form-data" id="uploadForm">
                    <div class="upload-area" onclick="document.getElementById('gallery_images').click()">
                        <input type="file" id="gallery_images" name="gallery_images[]" multiple 
                               accept="image/jpeg,image/jpg,image/png,image/gif">
                        <div class="upload-text">
                            <i class="fas fa-cloud-upload-alt"></i> Click to select images
                        </div>
                        <div class="upload-hint">
                            Select multiple images (JPG, PNG, GIF - Max 5MB each)
                        </div>
                        <button type="button" class="upload-btn">
                            <i class="fas fa-folder-open"></i> Browse Files
                        </button>
                    </div>

                    <div id="imagePreview" class="image-preview"></div>

                    <button type="submit" name="upload_images" class="submit-btn" id="submitBtn" style="display: none;">
                        <i class="fas fa-upload"></i> Upload Images to Gallery
                    </button>
                </form>
            </div>
        <?php endif; ?>

        <?php if ($view === 'manage'): ?>
            <div class="upload-section">
                <h3 style="color: #d4a574; margin-bottom: 20px; font-family: 'Playfair Display', serif;">
                    <i class="fas fa-cog"></i> Current Gallery (<?php echo count($galleryImages); ?> images)
                </h3>
                
                <?php if (empty($galleryImages)): ?>
                    <div class="empty-state">
                        <i class="fas fa-images" style="font-size: 3rem; color: #ddd; margin-bottom: 20px;"></i>
                        <p>No images in gallery yet.</p>
                        <a href="?view=upload" class="upload-btn" style="display: inline-block; margin-top: 15px;">
                            <i class="fas fa-plus"></i> Upload First Images
                        </a>
                    </div>
                <?php else: ?>
                    <div class="gallery-grid">
                        <?php foreach ($galleryImages as $image): ?>
                            <div class="gallery-item">
                                <img src="../uploads/gallery/<?php echo htmlspecialchars($image['image_filename']); ?>" 
                                     alt="<?php echo htmlspecialchars($image['image_name']); ?>">
                                <div class="gallery-info">
                                    <div class="category-badge"><?php echo ucfirst(str_replace('-', ' ', $image['image_category'])); ?></div>
                                    <h4><?php echo htmlspecialchars($image['image_name']); ?></h4>
                                    <?php if ($image['image_description']): ?>
                                        <p><?php echo htmlspecialchars($image['image_description']); ?></p>
                                    <?php endif; ?>
                                    <p><small>Uploaded: <?php echo formatDate($image['upload_date']); ?></small></p>
                                    <button onclick="deleteImage(<?php echo $image['id']; ?>, '<?php echo htmlspecialchars($image['image_name']); ?>')" 
                                            class="delete-btn">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </main>

    <script>
        document.getElementById('gallery_images').addEventListener('change', function(e) {
            const files = e.target.files;
            const previewContainer = document.getElementById('imagePreview');
            const submitBtn = document.getElementById('submitBtn');
            
            previewContainer.innerHTML = '';
            
            if (files.length > 0) {
                submitBtn.style.display = 'block';
                
                Array.from(files).forEach((file, index) => {
                    const previewItem = document.createElement('div');
                    previewItem.className = 'preview-item';
                    
                    const img = document.createElement('img');
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        img.src = e.target.result;
                    };
                    reader.readAsDataURL(file);
                    
                    const details = document.createElement('div');
                    details.className = 'preview-details';
                    details.innerHTML = `
                        <div class="form-group">
                            <label>Image Name</label>
                            <input type="text" name="image_names[]" placeholder="${file.name.split('.')[0]}" value="${file.name.split('.')[0]}">
                        </div>
                        <div class="form-group">
                            <label>Category</label>
                            <select name="image_categories[]">
                                <option value="daily-specials">Daily Specials</option>
                                <option value="party-catering">Party Catering</option>
                                <option value="celebration">Celebrations</option>
                                <option value="drinks">Beverages</option>
                                <option value="restaurant">Our Space</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <textarea name="image_descriptions[]" placeholder="Optional description..."></textarea>
                        </div>
                    `;
                    
                    previewItem.appendChild(img);
                    previewItem.appendChild(details);
                    previewContainer.appendChild(previewItem);
                });
            } else {
                submitBtn.style.display = 'none';
            }
        });

        function deleteImage(id, name) {
            if (confirm(`Are you sure you want to delete "${name}"? This action cannot be undone.`)) {
                window.location.href = `?view=manage&delete=${id}`;
            }
        }

        // Form submission loading state
        document.getElementById('uploadForm').addEventListener('submit', function() {
            const submitBtn = document.getElementById('submitBtn');
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Uploading Images...';
            submitBtn.disabled = true;
        });
    </script>
</body>
</html>