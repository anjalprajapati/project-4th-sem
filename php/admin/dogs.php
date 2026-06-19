<?php
$pageTitle='Dog Management'; $requiredRole='admin';
require_once '../../includes/admin-header.php';
$dogs = dbFetchAll("SELECT * FROM dogs ORDER BY created_at DESC");
?>
<div class="admin-page-header"><h1>🐕 Dog Management</h1><a href="dog-form.php" class="btn btn-primary">+ Add Dog</a></div>
<div class="search-bar"><input type="text" id="tableSearch" placeholder="Search dogs..."></div>
<div class="table-wrapper">
    <table>
        <thead><tr><th>#</th><th>Name</th><th>Breed</th><th>Age</th><th>Gender</th><th>Health</th><th>Vaccination</th><th>Actions</th></tr></thead>
        <tbody>
        <?php foreach($dogs as $i=>$d): ?>
        <tr>
            <td><?php echo $i+1; ?></td>
            <td><strong><?php echo htmlspecialchars($d['name']); ?></strong></td>
            <td><?php echo htmlspecialchars($d['breed']); ?></td>
            <td><?php echo htmlspecialchars($d['age']); ?></td>
            <td><?php echo formatStatus($d['gender']); ?></td>
            <td><span class="badge <?php echo getStatusBadge($d['health_status']); ?>"><?php echo formatStatus($d['health_status']); ?></span></td>
            <td><span class="badge <?php echo getStatusBadge($d['vaccinated']); ?>"><?php echo formatStatus($d['vaccinated']); ?></span></td>
            <td><div class="table-actions">
                <a href="dog-form.php?id=<?php echo $d['id']; ?>" class="action-edit">✏️</a>
                <a href="dog-process.php?action=delete&id=<?php echo $d['id']; ?>" class="action-delete" data-confirm="Delete this dog profile?">🗑️</a>
            </div></td>
        </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php require_once '../../includes/admin-footer.php'; ?>
