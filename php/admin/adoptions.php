<?php
$pageTitle='Adoption Management'; $requiredRole='admin';
require_once '../../includes/admin-header.php';
$adoptions = dbFetchAll("SELECT a.*, d.name AS dog_name FROM adoptions a JOIN dogs d ON a.dog_id=d.id ORDER BY a.created_at DESC");
?>
<div class="admin-page-header"><h1>🏠 Adoption Management</h1></div>
<div class="search-bar"><input type="text" id="tableSearch" placeholder="Search adoptions..."></div>
<div class="table-wrapper">
    <table>
        <thead><tr><th>#</th><th>Dog</th><th>Adopter</th><th>Phone</th><th>Email</th><th>Status</th><th>Date</th><th>Actions</th></tr></thead>
        <tbody>
        <?php foreach($adoptions as $i=>$a): ?>
        <tr>
            <td><?php echo $i+1; ?></td>
            <td><strong><?php echo htmlspecialchars($a['dog_name']); ?></strong></td>
            <td><?php echo htmlspecialchars($a['adopter_name']); ?></td>
            <td><?php echo htmlspecialchars($a['phone']); ?></td>
            <td><?php echo htmlspecialchars($a['email']); ?></td>
            <td data-status="<?php echo $a['status']; ?>"><span class="badge <?php echo getStatusBadge($a['status']); ?>"><?php echo formatStatus($a['status']); ?></span></td>
            <td><?php echo formatDate($a['created_at']); ?></td>
            <td>
                <div class="table-actions">
                    <?php if($a['status']==='pending'): ?>
                    <a href="adoption-process.php?action=approve&id=<?php echo $a['id']; ?>" class="action-view" title="Approve" data-confirm="Approve this adoption?">✅</a>
                    <a href="adoption-process.php?action=reject&id=<?php echo $a['id']; ?>" class="action-delete" title="Reject" data-confirm="Reject this adoption?">❌</a>
                    <?php endif; ?>
                </div>
            </td>
        </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php require_once '../../includes/admin-footer.php'; ?>
