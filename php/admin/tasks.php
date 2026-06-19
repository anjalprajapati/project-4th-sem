<?php
$pageTitle='Task Management'; $requiredRole='admin';
require_once '../../includes/admin-header.php';
$tasks = dbFetchAll("SELECT t.*, u.name AS vol_name FROM tasks t JOIN volunteers v ON t.volunteer_id=v.id JOIN users u ON v.user_id=u.id ORDER BY t.created_at DESC");
?>
<div class="admin-page-header"><h1>📋 Task Management</h1><a href="task-form.php" class="btn btn-primary">+ Assign Task</a></div>
<div class="search-bar"><input type="text" id="tableSearch" placeholder="Search tasks..."></div>
<div class="table-wrapper">
    <table>
        <thead><tr><th>#</th><th>Title</th><th>Volunteer</th><th>Category</th><th>Status</th><th>Deadline</th><th>Actions</th></tr></thead>
        <tbody>
        <?php foreach($tasks as $i=>$t): ?>
        <tr>
            <td><?php echo $i+1; ?></td>
            <td><strong><?php echo htmlspecialchars($t['title']); ?></strong></td>
            <td><?php echo htmlspecialchars($t['vol_name']); ?></td>
            <td><span class="badge badge-info"><?php echo formatStatus($t['category']); ?></span></td>
            <td data-status="<?php echo $t['status']; ?>"><span class="badge <?php echo getStatusBadge($t['status']); ?>"><?php echo formatStatus($t['status']); ?></span></td>
            <td><?php echo $t['deadline']?formatDate($t['deadline']):'-'; ?></td>
            <td><div class="table-actions"><a href="task-form.php?id=<?php echo $t['id']; ?>" class="action-edit">✏️</a><a href="task-process.php?action=delete&id=<?php echo $t['id']; ?>" class="action-delete" data-confirm="Delete this task?">🗑️</a></div></td>
        </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php require_once '../../includes/admin-footer.php'; ?>
