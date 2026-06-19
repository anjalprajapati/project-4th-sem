<?php
$pageTitle='Volunteer Management'; $requiredRole='admin';
require_once '../../includes/admin-header.php';
$volunteers = dbFetchAll("SELECT v.*, u.name, u.email FROM volunteers v JOIN users u ON v.user_id=u.id ORDER BY v.created_at DESC");
?>
<div class="admin-page-header"><h1>🤝 Volunteer Management</h1></div>
<div class="search-bar"><input type="text" id="tableSearch" placeholder="Search volunteers..."></div>
<div class="table-wrapper">
    <table>
        <thead><tr><th>#</th><th>Name</th><th>Email</th><th>Phone</th><th>Availability</th><th>Joined</th></tr></thead>
        <tbody>
        <?php foreach($volunteers as $i=>$v): ?>
        <tr>
            <td><?php echo $i+1; ?></td>
            <td><strong><?php echo htmlspecialchars($v['name']); ?></strong></td>
            <td><?php echo htmlspecialchars($v['email']); ?></td>
            <td><?php echo htmlspecialchars($v['phone']); ?></td>
            <td data-status="<?php echo $v['availability']; ?>"><span class="badge <?php echo getStatusBadge($v['availability']); ?>"><?php echo formatStatus($v['availability']); ?></span></td>
            <td><?php echo formatDate($v['created_at']); ?></td>
        </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php require_once '../../includes/admin-footer.php'; ?>
