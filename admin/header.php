<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Header - AUNTY CO'S KITCHEN</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600&family=Open+Sans:wght@300;400;600&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Open Sans', sans-serif;
            background-color: #f8f9fa;
            color: #333;
        }

        .admin-header {
            background: linear-gradient(135deg, #d4a574, #b8956a);
            color: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .navbar-brand {
            font-family: 'Playfair Display', serif;
            font-size: 1.5rem;
            font-weight: 600;
            color: white !important;
        }

        .nav-link {
            color: white !important;
            font-size: 1rem;
            transition: background 0.3s ease;
            border-radius: 5px;
        }

        .nav-link:hover, .nav-link.active {
            background: rgba(255, 255, 255, 0.2);
        }

        .navbar-toggler {
            border: none;
        }

        .navbar-toggler:focus {
            outline: none;
            box-shadow: none;
        }

        .navbar-toggler-icon {
            color: white;
            font-size: 1.5rem;
        }
    </style>
</head>
<body>

<header class="admin-header">
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid px-3">
            <a class="navbar-brand" href="#">
                <i class="fas fa-utensils"></i> AUNTY CO'S KITCHEN Admin
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#adminNavbar">
                <span class="navbar-toggler-icon">
                    <i class="fas fa-bars"></i>
                </span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="adminNavbar">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a href="dashboard.php" class="nav-link"><i class="fas fa-home"></i> Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a href="update_menu.php" class="nav-link active"><i class="fas fa-utensils"></i> Update Menu</a>
                    </li>
                    <li class="nav-item">
                        <a href="update_gallery.php" class="nav-link"><i class="fas fa-images"></i> Gallery</a>
                    </li>
                    <li class="nav-item">
                        <a href="view_reservations.php" class="nav-link"><i class="fas fa-calendar"></i> Reservations</a>
                    </li>
                    <li class="nav-item">
                        <a href="../index.php" class="nav-link"><i class="fas fa-sign-out-alt"></i> Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
