<?php
// admin/view_reservations.php
require_once '../includes/db.php'; // include PDO & utility functions



$message = '';
$messageType = '';
$filter = $_GET['filter'] ?? 'all';

// Handle status update
if (isset($_POST['update_status'])) {
    try {
        $reservationId = (int)$_POST['reservation_id'];
        $newStatus = $_POST['new_status'];

        $stmt = $pdo->prepare("UPDATE reservations SET status = ?, updated_at = NOW() WHERE id = ?");
        $stmt->execute([$newStatus, $reservationId]);

        $message = "Reservation status updated successfully!";
        $messageType = 'success';
    } catch (Exception $e) {
        $message = "Error updating status: " . $e->getMessage();
        $messageType = 'error';
    }
}

// Handle delete
if (isset($_GET['delete'])) {
    try {
        $reservationId = (int)$_GET['delete'];
        $stmt = $pdo->prepare("DELETE FROM reservations WHERE id = ?");
        $stmt->execute([$reservationId]);

        $message = "Reservation deleted successfully!";
        $messageType = 'success';
    } catch (Exception $e) {
        $message = "Error deleting reservation: " . $e->getMessage();
        $messageType = 'error';
    }
}

// Build filter query
$whereClause = '';
$params = [];
switch ($filter) {
    case 'today':
        $whereClause = "WHERE DATE(reservation_date) = CURDATE()";
        break;
    case 'upcoming':
        $whereClause = "WHERE DATE(reservation_date) >= CURDATE()";
        break;
    case 'pending':
        $whereClause = "WHERE status = ?";
        $params[] = 'pending';
        break;
    case 'confirmed':
        $whereClause = "WHERE status = ?";
        $params[] = 'confirmed';
        break;
    case 'past':
        $whereClause = "WHERE DATE(reservation_date) < CURDATE()";
        break;
    default:
        $whereClause = "";
}

// Fetch reservations
try {
    $sql = "SELECT * FROM reservations $whereClause ORDER BY reservation_date DESC, reservation_time DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $reservations = $stmt->fetchAll();

    // Stats
    $statsStmt = $pdo->query("
        SELECT 
            COUNT(*) as total,
            SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) as pending,
            SUM(CASE WHEN status = 'confirmed' THEN 1 ELSE 0 END) as confirmed,
            SUM(CASE WHEN DATE(reservation_date) = CURDATE() THEN 1 ELSE 0 END) as today,
            SUM(CASE WHEN DATE(reservation_date) >= CURDATE() THEN 1 ELSE 0 END) as upcoming
        FROM reservations
    ");
    $stats = $statsStmt->fetch();

} catch (PDOException $e) {
    $reservations = [];
    $stats = ['total'=>0,'pending'=>0,'confirmed'=>0,'today'=>0,'upcoming'=>0];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Reservations - Admin Dashboard</title>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
<link rel="stylesheet" href="reservation.css">
</head>
<body>
<?php include 'header.php'; ?>

<main class="main-content">
    <div class="page-header">
        <h1><i class="fas fa-calendar-check"></i> Reservation Management</h1>
        <p>View and manage customer reservations</p>
    </div>

    <!-- Stats -->
    <div class="stats-row">
        <div class="stat-card"><div class="stat-number"><?php echo $stats['total']; ?></div><div class="stat-label">Total</div></div>
        <div class="stat-card"><div class="stat-number"><?php echo $stats['pending']; ?></div><div class="stat-label">Pending</div></div>
        <div class="stat-card"><div class="stat-number"><?php echo $stats['confirmed']; ?></div><div class="stat-label">Confirmed</div></div>
        <div class="stat-card"><div class="stat-number"><?php echo $stats['today']; ?></div><div class="stat-label">Today</div></div>
        <div class="stat-card"><div class="stat-number"><?php echo $stats['upcoming']; ?></div><div class="stat-label">Upcoming</div></div>
    </div>

    <!-- Filter Tabs -->
    <div class="filter-tabs">
        <a href="?filter=all" class="filter-btn <?php echo $filter==='all'?'active':'';?>"><i class="fas fa-list"></i> All</a>
        <a href="?filter=today" class="filter-btn <?php echo $filter==='today'?'active':'';?>"><i class="fas fa-calendar-day"></i> Today</a>
        <a href="?filter=upcoming" class="filter-btn <?php echo $filter==='upcoming'?'active':'';?>"><i class="fas fa-calendar-alt"></i> Upcoming</a>
        <a href="?filter=pending" class="filter-btn <?php echo $filter==='pending'?'active':'';?>"><i class="fas fa-clock"></i> Pending</a>
        <a href="?filter=confirmed" class="filter-btn <?php echo $filter==='confirmed'?'active':'';?>"><i class="fas fa-check"></i> Confirmed</a>
        <a href="?filter=past" class="filter-btn <?php echo $filter==='past'?'active':'';?>"><i class="fas fa-history"></i> Past</a>
    </div>

    <?php if($message): ?>
    <div class="message <?php echo $messageType;?>">
        <i class="fas fa-<?php echo $messageType==='success'?'check-circle':'exclamation-circle'; ?>"></i>
        <?php echo htmlspecialchars($message);?>
    </div>
    <?php endif; ?>

    <!-- Reservations List -->
    <div class="reservations-list">
        <?php if(empty($reservations)): ?>
            <div class="empty-state"><i class="fas fa-calendar-times"></i><p>No reservations found.</p></div>
        <?php else: ?>
            <?php foreach($reservations as $res): ?>
            <div class="reservation-item">
                <div class="reservation-header">
                    <div class="reservation-id"><?php echo htmlspecialchars($res['reservation_id']);?></div>
                    <div class="status-badge status-<?php echo $res['status'];?>"><?php echo ucfirst($res['status']);?></div>
                </div>
                <div class="reservation-details">
                    <div class="detail-item"><i class="fas fa-user"></i> <?php echo htmlspecialchars($res['name']);?></div>
                    <div class="detail-item"><i class="fas fa-phone"></i> <?php echo htmlspecialchars($res['phone']);?></div>
                    <div class="detail-item"><i class="fas fa-envelope"></i> <?php echo htmlspecialchars($res['email']);?></div>
                    <div class="detail-item"><i class="fas fa-users"></i> <?php echo $res['guests'];?> guests</div>
                    <div class="detail-item"><i class="fas fa-calendar"></i> <?php echo formatDate($res['reservation_date']);?></div>
                    <div class="detail-item"><i class="fas fa-clock"></i> <?php echo date('g:i A', strtotime($res['reservation_time']));?></div>
                </div>
                <div class="reservation-actions">
                    <?php if($res['status']==='pending'): ?>
                        <form method="POST" style="display:inline">
                            <input type="hidden" name="reservation_id" value="<?php echo $res['id'];?>">
                            <input type="hidden" name="new_status" value="confirmed">
                            <button type="submit" name="update_status" class="action-btn btn-confirm"><i class="fas fa-check"></i> Confirm</button>
                        </form>
                        <form method="POST" style="display:inline">
                            <input type="hidden" name="reservation_id" value="<?php echo $res['id'];?>">
                            <input type="hidden" name="new_status" value="cancelled">
                            <button type="submit" name="update_status" class="action-btn btn-cancel"><i class="fas fa-times"></i> Cancel</button>
                        </form>
                    <?php elseif($res['status']==='confirmed'): ?>
                        <form method="POST" style="display:inline">
                            <input type="hidden" name="reservation_id" value="<?php echo $res['id'];?>">
                            <input type="hidden" name="new_status" value="completed">
                            <button type="submit" name="update_status" class="action-btn btn-complete"><i class="fas fa-check-double"></i> Complete</button>
                        </form>
                        <form method="POST" style="display:inline">
                            <input type="hidden" name="reservation_id" value="<?php echo $res['id'];?>">
                            <input type="hidden" name="new_status" value="cancelled">
                            <button type="submit" name="update_status" class="action-btn btn-cancel"><i class="fas fa-times"></i> Cancel</button>
                        </form>
                    <?php endif; ?>
                    <button onclick="deleteReservation(<?php echo $res['id'];?>,'<?php echo htmlspecialchars($res['reservation_id']);?>')" class="action-btn btn-delete"><i class="fas fa-trash"></i> Delete</button>
                </div>
            </div>
            <?php endforeach;?>
        <?php endif;?>
    </div>
</main>

<script>
function deleteReservation(id, reservationId){
    if(confirm(`Delete reservation ${reservationId}?`)){
        window.location.href = `?filter=<?php echo $filter;?>&delete=${id}`;
    }
}

// Auto refresh every 5 minutes
setTimeout(()=>location.reload(),300000);
</script>
</body>
</html>
