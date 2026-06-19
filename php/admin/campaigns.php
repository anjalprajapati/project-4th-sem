<?php
$pageTitle = 'Campaign Management';
$requiredRole = 'admin';
require_once '../../includes/admin-header.php';
$campaigns = dbFetchAll("SELECT * FROM campaigns WHERE status != 'deleted' ORDER BY created_at DESC");
?>
<div class="admin-page-header">
    <h1>📢 Campaign Management</h1>
    <a href="campaign-form.php" class="btn btn-primary">+ Add Campaign</a>
</div>
<div class="search-bar"><input type="text" id="tableSearch" placeholder="Search campaigns..."></div>
<div class="table-wrapper">
    <table>
        <thead><tr><th>#</th><th>Title</th><th>Goal</th><th>Raised</th><th>Progress</th><th>Deadline</th><th>Status</th><th>Actions</th></tr></thead>
        <tbody>
        <?php foreach ($campaigns as $i => $c): ?>
        <tr>
            <td><?php echo $i+1; ?></td>
            <td><strong><?php echo htmlspecialchars($c['title']); ?></strong></td>
            <td><?php echo formatCurrency($c['goal_amount']); ?></td>
            <td><?php echo formatCurrency($c['current_amount']); ?></td>
            <td><div class="progress-bar" style="width:100px;height:8px;"><div class="progress-fill" style="width:<?php echo progressPercent($c['current_amount'],$c['goal_amount']); ?>%"></div></div></td>
            <td><?php echo formatDate($c['deadline']); ?></td>
            <td data-status="<?php echo $c['status']; ?>"><span class="badge <?php echo getStatusBadge($c['status']); ?>"><?php echo formatStatus($c['status']); ?></span></td>
            <td>
                <div class="table-actions">
                    <a href="campaign-form.php?id=<?php echo $c['id']; ?>" class="action-edit" title="Edit">✏️</a>
                    <a href="campaign-process.php?action=delete&id=<?php echo $c['id']; ?>" class="action-delete" data-confirm="Are you sure you want to delete this campaign?" title="Delete">🗑️</a>
                </div>
            </td>
        </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php require_once '../../includes/admin-footer.php'; ?>
