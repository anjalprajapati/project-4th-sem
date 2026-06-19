<?php
$pageTitle = 'Volunteer Dashboard';
$requiredRole = 'volunteer';
require_once '../../includes/admin-header.php';

$userId = $_SESSION['user_id'];
$volunteer = dbFetchOne("SELECT * FROM volunteers WHERE user_id=?", [$userId], 'i');
$volId = $volunteer ? $volunteer['id'] : 0;

$totalTasks = dbFetchOne("SELECT COUNT(*) AS c FROM tasks WHERE volunteer_id=?", [$volId], 'i')['c'];
$completedTasks = dbFetchOne("SELECT COUNT(*) AS c FROM tasks WHERE volunteer_id=? AND status='completed'", [$volId], 'i')['c'];
$pendingTasks = dbFetchOne("SELECT COUNT(*) AS c FROM tasks WHERE volunteer_id=? AND status IN ('pending','in_progress')", [$volId], 'i')['c'];
$totalRescues = dbFetchOne("SELECT COUNT(*) AS c FROM rescues")['c'];

$recentTasks = dbFetchAll("SELECT * FROM tasks WHERE volunteer_id=? ORDER BY created_at DESC LIMIT 5", [$volId], 'i');
$recentRescues = dbFetchAll("SELECT r.*, d.name AS dog_name FROM rescues r JOIN dogs d ON r.dog_id=d.id ORDER BY r.rescue_date DESC LIMIT 5");
?>

<div class="admin-page-header">
    <h1>📊 Volunteer Dashboard</h1>
    <div>
        <span class="badge <?php echo $volunteer ? getStatusBadge($volunteer['availability']) : 'badge-secondary'; ?>"><?php echo $volunteer ? formatStatus($volunteer['availability']) : 'N/A'; ?></span>
    </div>
</div>

<div class="stat-grid">
    <div class="stat-card"><div class="stat-icon blue">📋</div><div class="stat-info"><h3><?php echo $totalTasks; ?></h3><p>Total Tasks</p></div></div>
    <div class="stat-card"><div class="stat-icon green">✅</div><div class="stat-info"><h3><?php echo $completedTasks; ?></h3><p>Completed</p></div></div>
    <div class="stat-card"><div class="stat-icon orange">⏳</div><div class="stat-info"><h3><?php echo $pendingTasks; ?></h3><p>Pending / In Progress</p></div></div>
    <div class="stat-card"><div class="stat-icon red">🚑</div><div class="stat-info"><h3><?php echo $totalRescues; ?></h3><p>Total Rescues</p></div></div>
</div>

<!-- Recent Tasks -->
<?php if (!empty($recentTasks)): ?>
<div class="recent-activity">
    <div class="card-header">📋 My Recent Tasks</div>
    <div class="table-wrapper" style="box-shadow:none;">
        <table>
            <thead><tr><th>Title</th><th>Category</th><th>Status</th><th>Deadline</th><th>Action</th></tr></thead>
            <tbody>
            <?php foreach ($recentTasks as $t): ?>
            <tr>
                <td><strong><?php echo htmlspecialchars($t['title']); ?></strong></td>
                <td><span class="badge badge-info"><?php echo formatStatus($t['category']); ?></span></td>
                <td><span class="badge <?php echo getStatusBadge($t['status']); ?>"><?php echo formatStatus($t['status']); ?></span></td>
                <td><?php echo $t['deadline'] ? formatDate($t['deadline']) : '-'; ?></td>
                <td>
                    <?php if ($t['status'] !== 'completed' && $t['status'] !== 'cancelled'): ?>
                    <a href="update-task.php?id=<?php echo $t['id']; ?>" class="btn btn-sm btn-primary">Update</a>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php endif; ?>

<!-- Recent Rescues -->
<?php if (!empty($recentRescues)): ?>
<div class="recent-activity mt-3">
    <div class="card-header">🚑 Recent Rescue Activities</div>
    <div class="table-wrapper" style="box-shadow:none;">
        <table>
            <thead><tr><th>Dog</th><th>Location</th><th>Date</th><th>Status</th></tr></thead>
            <tbody>
            <?php foreach ($recentRescues as $r): ?>
            <tr>
                <td><strong><?php echo htmlspecialchars($r['dog_name']); ?></strong></td>
                <td><?php echo htmlspecialchars($r['location']); ?></td>
                <td><?php echo formatDate($r['rescue_date']); ?></td>
                <td><span class="badge <?php echo getStatusBadge($r['status']); ?>"><?php echo formatStatus($r['status']); ?></span></td>
            </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php endif; ?>

<?php require_once '../../includes/admin-footer.php'; ?>
