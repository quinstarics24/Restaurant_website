<?php
// admin/view_reservations.php
require_once 'db.php';
requireLogin();

$message = '';
$messageType = '';
$filter = $_GET['filter'] ?? 'all';

// Handle status update
if (isset($_POST['update_status'])) {
    try {
        $reservationId = (int)$_POST['reservation_id'];
        $newStatus = $_POST['new_status'];
        
        $updateStmt = $pdo->prepare("UPDATE reservations SET status = ?, updated_at = NOW() WHERE id = ?");
        $updateStmt->execute([$newStatus, $reservationId]);
        
        $message = "Reservation status updated successfully!";
        $messageType = 'success';
    } catch (Exception $e) {
        $message = "Error updating status: " . $e->getMessage();
        $messageType = 'error';
    }
}

// Handle delete reservation
if (isset($_GET['delete'])) {
    try {
        $reservationId = (int)$_GET['delete'];
        
        $deleteStmt = $pdo->prepare("DELETE FROM reservations WHERE id = ?");
        $deleteStmt->execute([$reservationId]);
        
        $message = "Reservation deleted successfully!";
        $messageType = 'success';
    } catch (Exception $e) {
        $message = "Error deleting reservation: " . $e->getMessage();
        $messageType = 'error';
    }
}

// Build query based on filter
$whereClause = '';
$params = [];

switch ($filter) {
    case 'today':
        $whereClause = 'WHERE reservation_date = CURDATE()';
        break;
    case 'upcoming':
        $whereClause = 'WHERE reservation_date >= CURDATE()';
        break;
    case 'pending':
        $whereClause = 'WHERE status = ?';
        $params[] = 'pending';
        break;
    case 'confirmed':
        $whereClause = 'WHERE status = ?';
        $params[] = 'confirmed';
        break;
    case 'past':
        $whereClause = 'WHERE reservation_date < CURDATE()';
        break;
    default:
        $whereClause = '';
}

// Get reservations
try {
    $sql = "SELECT * FROM reservations $whereClause ORDER BY reservation_date DESC, reservation_time DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $reservations = $stmt->fetchAll();
    
    // Get statistics
    $statsStmt = $pdo->prepare("
        SELECT 
            COUNT(*) as total,
            SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) as pending,
            SUM(CASE WHEN status = 'confirmed' THEN 1 ELSE 0 END) as confirmed,
            SUM(CASE WHEN reservation_date = CURDATE() THEN 1 ELSE 0 END) as today,
            SUM(CASE WHEN reservation_date >= CURDATE() THEN 1 ELSE 0 END) as upcoming
        FROM reservations
    ");
    $statsStmt->execute();
    $stats = $statsStmt->fetch();
    
} catch (PDOException $e) {
    $reservations = [];
    $stats = ['total' => 0, 'pending' => 0, 'confirmed' => 0, 'today' => 0, 'upcoming' => 0];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Reservations - Admin Dashboard</title>
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

        .stats-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 15px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
            text-align: center;
        }

        .stat-number {
            font-size: 2rem;
            font-weight: 700;
            color: #d4a574;
            margin-bottom: 5px;
        }

        .stat-label {
            color: #666;
            font-size: 0.9rem;
        }

        .filter-tabs {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            justify-content: center;
            margin-bottom: 30px;
        }

        .filter-btn {
            background: white;
            border: 2px solid #d4a574;
            color: #d4a574;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
            font-size: 0.9rem;
        }

        .filter-btn.active, .filter-btn:hover {
            background: #d4a574;
            color: white;
        }

        .reservations-table {
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            overflow: hidden;
        }

        .table-header {
            background: #d4a574;
            color: white;
            padding: 20px;
            font-weight: 600;
        }

        .reservations-list {
            max-height: 600px;
            overflow-y: auto;
        }

        .reservation-item {
            border-bottom: 1px solid #f0f0f0;
            padding: 20px;
            transition: background 0.3s ease;
        }

        .reservation-item:hover {
            background: #f8f9fa;
        }

        .reservation-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .reservation-id {
            font-family: 'Playfair Display', serif;
            font-size: 1.2rem;
            color: #d4a574;
            font-weight: 600;
        }

        .status-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
        }

        .status-pending {
            background: #fff3cd;
            color: #856404;
        }

        .status-confirmed {
            background: #d4edda;
            color: #155724;
        }

        .status-cancelled {
            background: #f8d7da;
            color: #721c24;
        }

        .status-completed {
            background: #e2e3e5;
            color: #383d41;
        }

        .reservation-details {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-bottom: 15px;
        }

        .detail-item {
            display: flex;
            align-items: center;
            color: #666;
        }

        .detail-item i {
            color: #d4a574;
            width: 20px;
            margin-right: 10px;
        }

        .reservation-requests {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 15px;
        }

        .reservation-requests h5 {
            color: #d4a574;
            margin-bottom: 8px;
        }

        .reservation-actions {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .action-btn {
            padding: 8px 15px;
            border: none;
            border-radius: 5px;
            font-size: 0.85rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-confirm {
            background: #28a745;
            color: white;
        }

        .btn-confirm:hover {
            background: #218838;
        }

        .btn-cancel {
            background: #dc3545;
            color: white;
        }

        .btn-cancel:hover {
            background: #c82333;
        }

        .btn-complete {
            background: #6c757d;
            color: white;
        }

        .btn-complete:hover {
            background: #5a6268;
        }

        .btn-delete {
            background: #fd7e14;
            color: white;
        }

        .btn-delete:hover {
            background: #e66a00;
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #666;
        }

        .empty-state i {
            font-size: 4rem;
            color: #ddd;
            margin-bottom: 20px;
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

        @media (max-width: 768px) {
            .header-content {
                flex-direction: column;
                gap: 15px;
            }

            .admin-nav {
                flex-wrap: wrap;
                justify-content: center;
            }

            .reservation-details {
                grid-template-columns: 1fr;
            }

            .reservation-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }

            .reservation-actions {
                justify-content: center;
            }

            .stats-row {
                grid-template-columns: repeat(2, 1fr);
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
                <a href="update_gallery.php"><i class="fas fa-images"></i> Gallery</a>
                <a href="view_reservations.php" class="active"><i class="fas fa-calendar"></i> Reservations</a>
                <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
            </nav>
        </div>
    </header>

    <main class="main-content">
        <div class="page-header">
            <h1><i class="fas fa-calendar-check"></i> Reservation Management</h1>
            <p>View and manage all customer reservations</p>
        </div>

        <div class="stats-row">
            <div class="stat-card">
                <div class="stat-number"><?php echo $stats['total']; ?></div>
                <div class="stat-label">Total Reservations</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?php echo $stats['pending']; ?></div>
                <div class="stat-label">Pending</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?php echo $stats['confirmed']; ?></div>
                <div class="stat-label">Confirmed</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?php echo $stats['today']; ?></div>
                <div class="stat-label">Today</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?php echo $stats['upcoming']; ?></div>
                <div class="stat-label">Upcoming</div>
            </div>
        </div>

        <div class="filter-tabs">
            <a href="?filter=all" class="filter-btn <?php echo $filter === 'all' ? 'active' : ''; ?>">
                <i class="fas fa-list"></i> All Reservations
            </a>
            <a href="?filter=today" class="filter-btn <?php echo $filter === 'today' ? 'active' : ''; ?>">
                <i class="fas fa-calendar-day"></i> Today
            </a>
            <a href="?filter=upcoming" class="filter-btn <?php echo $filter === 'upcoming' ? 'active' : ''; ?>">
                <i class="fas fa-calendar-alt"></i> Upcoming
            </a>
            <a href="?filter=pending" class="filter-btn <?php echo $filter === 'pending' ? 'active' : ''; ?>">
                <i class="fas fa-clock"></i> Pending
            </a>
            <a href="?filter=confirmed" class="filter-btn <?php echo $filter === 'confirmed' ? 'active' : ''; ?>">
                <i class="fas fa-check"></i> Confirmed
            </a>
            <a href="?filter=past" class="filter-btn <?php echo $filter === 'past' ? 'active' : ''; ?>">
                <i class="fas fa-history"></i> Past
            </a>
        </div>

        <?php if ($message): ?>
            <div class="message <?php echo $messageType; ?>">
                <i class="fas fa-<?php echo $messageType === 'success' ? 'check-circle' : 'exclamation-circle'; ?>"></i>
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>

        <div class="reservations-table">
            <div class="table-header">
                <h3><i class="fas fa-calendar-check"></i> 
                    <?php 
                    switch($filter) {
                        case 'today': echo "Today's Reservations"; break;
                        case 'upcoming': echo "Upcoming Reservations"; break;
                        case 'pending': echo "Pending Reservations"; break;
                        case 'confirmed': echo "Confirmed Reservations"; break;
                        case 'past': echo "Past Reservations"; break;
                        default: echo "All Reservations";
                    }
                    ?>
                    (<?php echo count($reservations); ?>)
                </h3>
            </div>

            <div class="reservations-list">
                <?php if (empty($reservations)): ?>
                    <div class="empty-state">
                        <i class="fas fa-calendar-times"></i>
                        <p>No reservations found for the selected filter.</p>
                    </div>
                <?php else: ?>
                    <?php foreach ($reservations as $reservation): ?>
                        <div class="reservation-item">
                            <div class="reservation-header">
                                <div class="reservation-id">
                                    <?php echo htmlspecialchars($reservation['reservation_id']); ?>
                                </div>
                                <div class="status-badge status-<?php echo $reservation['status']; ?>">
                                    <?php echo ucfirst($reservation['status']); ?>
                                </div>
                            </div>

                            <div class="reservation-details">
                                <div class="detail-item">
                                    <i class="fas fa-user"></i>
                                    <span><?php echo htmlspecialchars($reservation['name']); ?></span>
                                </div>
                                <div class="detail-item">
                                    <i class="fas fa-phone"></i>
                                    <span><?php echo htmlspecialchars($reservation['phone']); ?></span>
                                </div>
                                <div class="detail-item">
                                    <i class="fas fa-envelope"></i>
                                    <span><?php echo htmlspecialchars($reservation['email']); ?></span>
                                </div>
                                <div class="detail-item">
                                    <i class="fas fa-users"></i>
                                    <span><?php echo $reservation['guests']; ?> guests</span>
                                </div>
                                <div class="detail-item">
                                    <i class="fas fa-calendar"></i>
                                    <span><?php echo formatDate($reservation['reservation_date']); ?></span>
                                </div>
                                <div class="detail-item">
                                    <i class="fas fa-clock"></i>
                                    <span><?php echo date('g:i A', strtotime($reservation['reservation_time'])); ?></span>
                                </div>
                            </div>

                            <?php if ($reservation['special_requirements'] || $reservation['special_requests']): ?>
                                <div class="reservation-requests">
                                    <?php if ($reservation['special_requirements']): ?>
                                        <h5>Special Requirements:</h5>
                                        <p><?php echo htmlspecialchars($reservation['special_requirements']); ?></p>
                                    <?php endif; ?>
                                    <?php if ($reservation['special_requests']): ?>
                                        <h5>Additional Requests:</h5>
                                        <p><?php echo htmlspecialchars($reservation['special_requests']); ?></p>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>

                            <div class="reservation-actions">
                                <?php if ($reservation['status'] === 'pending'): ?>
                                    <form method="POST" style="display: inline;">
                                        <input type="hidden" name="reservation_id" value="<?php echo $reservation['id']; ?>">
                                        <input type="hidden" name="new_status" value="confirmed">
                                        <button type="submit" name="update_status" class="action-btn btn-confirm">
                                            <i class="fas fa-check"></i> Confirm
                                        </button>
                                    </form>
                                    <form method="POST" style="display: inline;">
                                        <input type="hidden" name="reservation_id" value="<?php echo $reservation['id']; ?>">
                                        <input type="hidden" name="new_status" value="cancelled">
                                        <button type="submit" name="update_status" class="action-btn btn-cancel">
                                            <i class="fas fa-times"></i> Cancel
                                        </button>
                                    </form>
                                <?php elseif ($reservation['status'] === 'confirmed'): ?>
                                    <form method="POST" style="display: inline;">
                                        <input type="hidden" name="reservation_id" value="<?php echo $reservation['id']; ?>">
                                        <input type="hidden" name="new_status" value="completed">
                                        <button type="submit" name="update_status" class="action-btn btn-complete">
                                            <i class="fas fa-check-double"></i> Mark Complete
                                        </button>
                                    </form>
                                    <form method="POST" style="display: inline;">
                                        <input type="hidden" name="reservation_id" value="<?php echo $reservation['id']; ?>">
                                        <input type="hidden" name="new_status" value="cancelled">
                                        <button type="submit" name="update_status" class="action-btn btn-cancel">
                                            <i class="fas fa-times"></i> Cancel
                                        </button>
                                    </form>
                                <?php endif; ?>
                                
                                <button onclick="deleteReservation(<?php echo $reservation['id']; ?>, '<?php echo htmlspecialchars($reservation['reservation_id']); ?>')" 
                                        class="action-btn btn-delete">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </main>

    <script>
        function deleteReservation(id, reservationId) {
            if (confirm(`Are you sure you want to delete reservation ${reservationId}? This action cannot be undone.`)) {
                window.location.href = `?filter=<?php echo $filter; ?>&delete=${id}`;
            }
        }

        // Auto-refresh page every 5 minutes for real-time updates
        setTimeout(function() {
            window.location.reload();
        }, 300000);

        // Show confirmation for status updates
        document.querySelectorAll('form[method="POST"]').forEach(form => {
            form.addEventListener('submit', function(e) {
                const button = e.target.querySelector('button[type="submit"]');
                const action = button.textContent.trim();
                
                if (!confirm(`Are you sure you want to ${action.toLowerCase()} this reservation?`)) {
                    e.preventDefault();
                    return false;
                }
                
                // Show loading state
                button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';
                button.disabled = true;
            });
        });
    </script>
</body>
</html>