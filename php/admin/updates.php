<?php
$pageTitle='News & Updates'; $requiredRole='admin';
require_once '../../includes/admin-header.php';
$updates = dbFetchAll("SELECT * FROM updates ORDER BY date DESC");
?>
<div class="admin-page-header"><h1>📰 News & Updates</h1><a href="update-form.php" class="btn btn-primary">+ Add Update</a></div>
<div class="search-bar"><input type="text" id="tableSearch" placeholder="Search updates..."></div>
<div class="table-wrapper">
    <table>
        <thead><tr><th>#</th><th>Title</th><th>Category</th><th>Date</th><th>Actions</th></tr></thead>
        <tbody>
        <?php foreach($updates as $i=>$u): ?>
        <tr>
            <td><?php echo $i+1; ?></td>
            <td><strong><?php echo htmlspecialchars($u['title']); ?></strong></td>
            <td><span class="badge <?php echo $u['category']==='success_story'?'badge-success':($u['category']==='event'?'badge-info':'badge-warning'); ?>"><?php echo formatStatus($u['category']); ?></span></td>
            <td><?php echo formatDate($u['date']); ?></td>
            <td><div class="table-actions"><a href="update-form.php?id=<?php echo $u['id']; ?>" class="action-edit">✏️</a><a href="update-process.php?action=delete&id=<?php echo $u['id']; ?>" class="action-delete" data-confirm="Delete this update?">🗑️</a></div></td>
        </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php require_once '../../includes/admin-footer.php'; ?>
