<?php
$pageTitle='Rescue Management'; $requiredRole='admin';
require_once '../../includes/admin-header.php';
$rescues = dbFetchAll("SELECT r.*, d.name AS dog_name FROM rescues r JOIN dogs d ON r.dog_id=d.id ORDER BY r.rescue_date DESC");
?>
<div class="admin-page-header"><h1>🚑 Rescue Management</h1><a href="rescue-form.php" class="btn btn-primary">+ Add Rescue</a></div>
<div class="search-bar"><input type="text" id="tableSearch" placeholder="Search rescues..."></div>
<div class="table-wrapper">
    <table>
        <thead><tr><th>#</th><th>Dog</th><th>Location</th><th>Date</th><th>Status</th><th>Actions</th></tr></thead>
        <tbody>
        <?php foreach($rescues as $i=>$r): ?>
        <tr>
            <td><?php echo $i+1; ?></td>
            <td><strong><?php echo htmlspecialchars($r['dog_name']); ?></strong></td>
            <td><?php echo htmlspecialchars($r['location']); ?></td>
            <td><?php echo formatDate($r['rescue_date']); ?></td>
            <td data-status="<?php echo $r['status']; ?>"><span class="badge <?php echo getStatusBadge($r['status']); ?>"><?php echo formatStatus($r['status']); ?></span></td>
            <td><div class="table-actions"><a href="rescue-form.php?id=<?php echo $r['id']; ?>" class="action-edit">✏️</a><a href="rescue-process.php?action=delete&id=<?php echo $r['id']; ?>" class="action-delete" data-confirm="Delete this rescue record?">🗑️</a></div></td>
        </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php require_once '../../includes/admin-footer.php'; ?>
