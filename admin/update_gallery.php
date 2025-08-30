<?php
// admin/update_gallery.php
require_once '../includes/db_connect.php'; // Your mysqli connection

$message = '';
$messageType = '';
$view = $_GET['view'] ?? 'upload';

// Sanitize input
function sanitize($input) {
    return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
}

// Format date
function formatDate($date) {
    return date('F j, Y', strtotime($date));
}

// Handle deletion
if (isset($_GET['delete'])) {
    $imageId = (int)$_GET['delete'];

    $stmt = $conn->prepare("SELECT image_filename FROM gallery_images WHERE id=?");
    $stmt->bind_param("i", $imageId);
    $stmt->execute();
    $stmt->bind_result($fileName);
    $stmt->fetch();
    $stmt->close();

    if ($fileName) {
        $filePath = '../uploads/gallery/' . $fileName;
        if (file_exists($filePath)) unlink($filePath);

        $stmt = $conn->prepare("DELETE FROM gallery_images WHERE id=?");
        $stmt->bind_param("i", $imageId);
        $stmt->execute();
        $stmt->close();

        $message = "Image deleted successfully!";
        $messageType = 'success';
    }
}

// Handle upload
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['upload_images'])) {
    $uploadDir = '../uploads/gallery/';
    if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);

    $uploadedCount = 0;
    $errors = [];

    if (isset($_FILES['gallery_images'])) {
        $fileCount = count($_FILES['gallery_images']['name']);

        for ($i = 0; $i < $fileCount; $i++) {
            if ($_FILES['gallery_images']['error'][$i] === UPLOAD_ERR_OK) {
                $tmpName = $_FILES['gallery_images']['tmp_name'][$i];
                $originalName = $_FILES['gallery_images']['name'][$i];
                $ext = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));

                if (!in_array($ext, ['jpg','jpeg','png','gif'])) {
                    $errors[] = "$originalName: Invalid file type";
                    continue;
                }

                if ($_FILES['gallery_images']['size'][$i] > 5*1024*1024) {
                    $errors[] = "$originalName: File too large";
                    continue;
                }

                $fileName = uniqid().'_'.time().'.'.$ext;
                $destination = $uploadDir . $fileName;

                if (move_uploaded_file($tmpName, $destination)) {
                    $imageName = sanitize($_POST['image_names'][$i] ?? pathinfo($originalName, PATHINFO_FILENAME));
                    $imageDescription = sanitize($_POST['image_descriptions'][$i] ?? '');

                    $stmt = $conn->prepare("INSERT INTO gallery_images (image_name, image_filename, image_description, upload_date) VALUES (?, ?, ?, CURDATE())");
                    $stmt->bind_param("sss", $imageName, $fileName, $imageDescription);
                    $stmt->execute();
                    $stmt->close();

                    $uploadedCount++;
                } else {
                    $errors[] = "$originalName: Upload failed";
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
}

// Get all images
$galleryImages = [];
$result = $conn->query("SELECT * FROM gallery_images ORDER BY created_at DESC");
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $galleryImages[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Gallery Management</title>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
<style>
/* Gallery Management Specific Styles */
.gallery-management-container {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: linear-gradient(135deg, #f8f5f2 0%, #ede4d3 100%);
    min-height: calc(100vh - 80px);
    padding: 20px;
    color: #333;
    margin-top: 0;
}

.gallery-management-container h1 {
    text-align: center;
    color: white;
    font-size: 2.5em;
    margin-bottom: 30px;
    text-shadow: 0 2px 4px rgba(0,0,0,0.3);
}

/* Navigation */
.nav-container {
    text-align: center;
    margin-bottom: 30px;
}

.nav-container a {
    display: inline-block;
    padding: 12px 25px;
    margin: 0 10px;
    background: rgba(255,255,255,0.9);
    color: #333;
    text-decoration: none;
    border-radius: 25px;
    font-weight: 600;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}

.nav-container a:hover {
    background: white;
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(0,0,0,0.15);
}

/* Messages */
.success, .error {
    max-width: 800px;
    margin: 0 auto 30px;
    padding: 15px 20px;
    border-radius: 8px;
    font-weight: 500;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}

.success {
    background: linear-gradient(45deg, #4CAF50, #45a049);
    color: white;
    border-left: 5px solid #2E7D32;
}

.error {
    background: linear-gradient(45deg, #f44336, #d32f2f);
    color: white;
    border-left: 5px solid #c62828;
}

/* Upload Form */
.gallery-management-container form {
    max-width: 800px;
    margin: 0 auto;
    background: rgba(255,255,255,0.95);
    padding: 30px;
    border-radius: 15px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.2);
    backdrop-filter: blur(10px);
}

.gallery-management-container input[type="file"] {
    width: 100%;
    padding: 15px;
    border: 2px dashed #667eea;
    border-radius: 10px;
    background: #f8f9ff;
    cursor: pointer;
    transition: all 0.3s ease;
    margin-bottom: 20px;
}

.gallery-management-container input[type="file"]:hover {
    border-color: #764ba2;
    background: #f0f2ff;
}

#imagePreview {
    margin: 20px 0;
}

#imagePreview > div {
    background: #f8f9ff;
    padding: 20px;
    margin-bottom: 15px;
    border-radius: 10px;
    border-left: 4px solid #667eea;
}

#imagePreview strong {
    color: #667eea;
    font-size: 1.1em;
    display: block;
    margin-bottom: 10px;
}

#imagePreview input[type="text"] {
    width: 100%;
    padding: 12px;
    border: 1px solid #ddd;
    border-radius: 6px;
    margin-bottom: 10px;
    font-size: 14px;
    transition: border-color 0.3s ease;
}

#imagePreview input[type="text"]:focus {
    outline: none;
    border-color: #667eea;
    box-shadow: 0 0 5px rgba(102, 126, 234, 0.3);
}

#imagePreview textarea {
    width: 100%;
    padding: 12px;
    border: 1px solid #ddd;
    border-radius: 6px;
    min-height: 80px;
    resize: vertical;
    font-family: inherit;
    font-size: 14px;
    transition: border-color 0.3s ease;
}

#imagePreview textarea:focus {
    outline: none;
    border-color: #667eea;
    box-shadow: 0 0 5px rgba(102, 126, 234, 0.3);
}

#imagePreview hr {
    border: none;
    border-top: 1px solid #eee;
    margin: 15px 0 0;
}

#submitBtn {
    background: linear-gradient(45deg, #667eea, #764ba2);
    color: white;
    padding: 15px 40px;
    border: none;
    border-radius: 25px;
    cursor: pointer;
    font-size: 16px;
    font-weight: 600;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    display: block;
    margin: 20px auto 0;
}

#submitBtn:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(0,0,0,0.3);
}

/* Gallery Management */
.gallery-management-container h3 {
    text-align: center;
    color: white;
    font-size: 1.8em;
    margin-bottom: 30px;
    text-shadow: 0 2px 4px rgba(0,0,0,0.3);
}

.gallery-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 25px;
    max-width: 1200px;
    margin: 0 auto;
}

.gallery-item {
    background: rgba(255,255,255,0.95);
    border-radius: 15px;
    padding: 20px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
    backdrop-filter: blur(10px);
}

.gallery-item:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 40px rgba(0,0,0,0.2);
}

.gallery-item img {
    width: 100%;
    height: 200px;
    object-fit: cover;
    border-radius: 10px;
    margin-bottom: 15px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}

.gallery-item p {
    margin-bottom: 10px;
    line-height: 1.5;
}

.gallery-item p:first-of-type {
    font-weight: 700;
    font-size: 1.1em;
    color: #333;
}

.gallery-item p:nth-of-type(2) {
    color: #666;
    font-size: 0.95em;
}

.gallery-item p:last-of-type {
    color: #888;
    font-size: 0.9em;
    font-style: italic;
}

.gallery-item a {
    display: inline-block;
    background: linear-gradient(45deg, #ff6b6b, #ee5a24);
    color: white;
    padding: 8px 20px;
    text-decoration: none;
    border-radius: 20px;
    font-size: 0.9em;
    font-weight: 600;
    transition: all 0.3s ease;
    margin-top: 10px;
}

.gallery-item a:hover {
    background: linear-gradient(45deg, #ee5a24, #d63031);
    transform: translateY(-1px);
    box-shadow: 0 4px 10px rgba(238, 90, 36, 0.3);
}

/* Responsive Design */
@media (max-width: 768px) {
    .gallery-management-container {
        padding: 10px;
    }
    
    .gallery-management-container h1 {
        font-size: 2em;
    }
    
    .nav-container a {
        display: block;
        margin: 5px 0;
    }
    
    .gallery-management-container form {
        padding: 20px;
    }
    
    .gallery-grid {
        grid-template-columns: 1fr;
    }
}
</style>
</head>
<body>
<?php include 'header.php'; ?>

<div class="gallery-management-container">
<h1><i class="fas fa-images"></i> Gallery Management</h1>
<div class="nav-container">
    <a href="?view=upload"><i class="fas fa-upload"></i> Upload Images</a>
    <a href="?view=manage"><i class="fas fa-cog"></i> Manage Gallery</a>
</div>

<?php if($message): ?>
    <div class="<?php echo $messageType; ?>"><?php echo htmlspecialchars($message); ?></div>
<?php endif; ?>

<?php if($view === 'upload'): ?>
<form method="POST" enctype="multipart/form-data" id="uploadForm">
    <input type="file" id="gallery_images" name="gallery_images[]" multiple accept="image/*">
    <div id="imagePreview"></div>
    <button type="submit" name="upload_images" id="submitBtn"><i class="fas fa-cloud-upload-alt"></i> Upload Images</button>
</form>
<?php endif; ?>

<?php if($view === 'manage'): ?>
<h3><i class="fas fa-photo-video"></i> Current Gallery (<?php echo count($galleryImages); ?> images)</h3>
<div class="gallery-grid">
    <?php foreach($galleryImages as $image): ?>
        <div class="gallery-item">
            <img src="../uploads/gallery/<?php echo htmlspecialchars($image['image_filename']); ?>" width="200" alt="<?php echo htmlspecialchars($image['image_name']); ?>">
            <p><?php echo htmlspecialchars($image['image_name']); ?></p>
            <p><?php echo htmlspecialchars($image['image_description']); ?></p>
            <p>Uploaded: <?php echo formatDate($image['upload_date']); ?></p>
            <a href="?view=manage&delete=<?php echo $image['id']; ?>" onclick="return confirm('Delete this image?');"><i class="fas fa-trash-alt"></i> Delete</a>
        </div>
    <?php endforeach; ?>
</div>
<?php endif; ?>

</div> <!-- End gallery-management-container -->

<script>
document.getElementById('gallery_images')?.addEventListener('change', function(e){
    const preview = document.getElementById('imagePreview');
    preview.innerHTML = '';
    const files = e.target.files;
    if(files.length){
        Array.from(files).forEach((file,index) => {
            const div = document.createElement('div');
            div.innerHTML = `
                <strong>${file.name}</strong><br>
                <input type="text" name="image_names[]" placeholder="Meal Name" value="${file.name.split('.')[0]}"><br>
                <textarea name="image_descriptions[]" placeholder="Meal Description"></textarea>
                <hr>
            `;
            preview.appendChild(div);
        });
    }
});
</script>

</body>
</html>