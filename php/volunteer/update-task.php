<?php
$pageTitle = 'Update Task';
$requiredRole = 'volunteer';
require_once '../../includes/admin-header.php';

$userId = $_SESSION['user_id'];
$volunteer = dbFetchOne("SELECT * FROM volunteers WHERE user_id=?", [$userId], 'i');
$volId = $volunteer ? $volunteer['id'] : 0;
$taskId = (int)($_GET['id'] ?? 0);

$task = dbFetchOne("SELECT * FROM tasks WHERE id=? AND volunteer_id=?", [$taskId, $volId], 'ii');
if (!$task) { redirect(SITE_URL . '/php/volunteer/tasks.php', 'Task not found.', 'error'); }

// Handle update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newStatus = sanitize($_POST['status']);
    if (in_array($newStatus, ['pending', 'in_progress', 'completed'])) {
        dbExecute("UPDATE tasks SET status=? WHERE id=? AND volunteer_id=?", [$newStatus, $taskId, $volId], 'sii');
        redirect(SITE_URL . '/php/volunteer/tasks.php', 'Task status updated to: ' . formatStatus($newStatus));
    }
}
?>

<div class="admin-page-header"><h1>📋 Update Task Status</h1><a href="tasks.php" class="btn btn-outline">← Back</a></div>

<div class="form-container">
    <div class="card mb-3" style="transform:none; background:var(--primary-light);">
        <div class="card-body">
            <h3><?php echo htmlspecialchars($task['title']); ?></h3>
            <p class="card-text"><?php echo htmlspecialchars($task['description']); ?></p>
            <div style="display:flex; gap:8px; flex-wrap:wrap;">
                <span class="badge badge-info"><?php echo formatStatus($task['category']); ?></span>
                <span class="badge <?php echo getStatusBadge($task['status']); ?>"><?php echo formatStatus($task['status']); ?></span>
                <?php if ($task['deadline']): ?>
                <span style="font-size:0.85rem; color:var(--text-secondary);">⏰ Deadline: <?php echo formatDate($task['deadline']); ?></span>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <form method="POST">
        <div class="form-group">
            <label>Update Status <span class="required">*</span></label>
            <select name="status" required>
                <option value="pending" <?php echo $task['status']==='pending'?'selected':''; ?>>Pending</option>
                <option value="in_progress" <?php echo $task['status']==='in_progress'?'selected':''; ?>>In Progress</option>
                <option value="completed" <?php echo $task['status']==='completed'?'selected':''; ?>>Completed</option>
            </select>
        </div>
        <div class="form-actions">
            <a href="tasks.php" class="btn btn-outline">Cancel</a>
            <button type="submit" class="btn btn-primary">Update Status</button>
        </div>
    </form>
</div>

<?php require_once '../../includes/admin-footer.php'; ?>
