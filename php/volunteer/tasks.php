<?php
$pageTitle = 'My Tasks';
$requiredRole = 'volunteer';
require_once '../../includes/admin-header.php';

$userId = $_SESSION['user_id'];
$volunteer = dbFetchOne("SELECT * FROM volunteers WHERE user_id=?", [$userId], 'i');
$volId = $volunteer ? $volunteer['id'] : 0;

$tasks = dbFetchAll("SELECT * FROM tasks WHERE volunteer_id=? ORDER BY FIELD(status,'pending','in_progress','completed','cancelled'), created_at DESC", [$volId], 'i');
?>

<div class="admin-page-header"><h1>📋 My Assigned Tasks</h1></div>

<?php if (empty($tasks)): ?>
    <div class="empty-state"><div class="icon">📋</div><h3>No tasks assigned</h3><p>You don't have any tasks assigned yet. Check back soon!</p></div>
<?php else: ?>
<div class="search-bar"><input type="text" id="tableSearch" placeholder="Search tasks..."></div>
<div class="table-wrapper">
    <table>
        <thead><tr><th>#</th><th>Title</th><th>Description</th><th>Category</th><th>Status</th><th>Deadline</th><th>Action</th></tr></thead>
        <tbody>
        <?php foreach ($tasks as $i => $t): ?>
        <tr>
            <td><?php echo $i+1; ?></td>
            <td><strong><?php echo htmlspecialchars($t['title']); ?></strong></td>
            <td><?php echo truncateText(htmlspecialchars($t['description']), 60); ?></td>
            <td><span class="badge badge-info"><?php echo formatStatus($t['category']); ?></span></td>
            <td data-status="<?php echo $t['status']; ?>"><span class="badge <?php echo getStatusBadge($t['status']); ?>"><?php echo formatStatus($t['status']); ?></span></td>
            <td><?php echo $t['deadline'] ? formatDate($t['deadline']) : '-'; ?></td>
            <td>
                <?php if ($t['status'] !== 'completed' && $t['status'] !== 'cancelled'): ?>
                <a href="update-task.php?id=<?php echo $t['id']; ?>" class="btn btn-sm btn-primary">Update</a>
                <?php else: ?>
                <span style="color:var(--text-secondary); font-size:0.85rem;">—</span>
                <?php endif; ?>
            </td>
        </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php endif; ?>

<?php require_once '../../includes/admin-footer.php'; ?>
