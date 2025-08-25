<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>header - Admin Dashboard</title>
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
                <a href="../index.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
            </nav>
        </div>
    </header>
</html>