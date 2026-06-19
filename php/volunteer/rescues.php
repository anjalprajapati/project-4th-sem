<?php
$pageTitle = 'Rescue Activities';
$requiredRole = 'volunteer';
require_once '../../includes/admin-header.php';

$rescues = dbFetchAll("SELECT r.*, d.name AS dog_name, d.breed FROM rescues r JOIN dogs d ON r.dog_id=d.id ORDER BY r.rescue_date DESC");
?>

<div class="admin-page-header"><h1>🚑 Rescue Activities</h1></div>

<div class="search-bar"><input type="text" id="tableSearch" placeholder="Search rescues..."></div>

<?php if (empty($rescues)): ?>
    <div class="empty-state"><div class="icon">🚑</div><h3>No rescue records</h3><p>No rescue activities have been recorded yet.</p></div>
<?php else: ?>
<div class="table-wrapper">
    <table>
        <thead><tr><th>#</th><th>Dog</th><th>Breed</th><th>Location</th><th>Date</th><th>Status</th></tr></thead>
        <tbody>
        <?php foreach ($rescues as $i => $r): ?>
        <tr>
            <td><?php echo $i+1; ?></td>
            <td><strong><?php echo htmlspecialchars($r['dog_name']); ?></strong></td>
            <td><?php echo htmlspecialchars($r['breed']); ?></td>
            <td><?php echo htmlspecialchars($r['location']); ?></td>
            <td><?php echo formatDate($r['rescue_date']); ?></td>
            <td><span class="badge <?php echo getStatusBadge($r['status']); ?>"><?php echo formatStatus($r['status']); ?></span></td>
        </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php endif; ?>

<?php require_once '../../includes/admin-footer.php'; ?>
