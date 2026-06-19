<?php
$pageTitle='User Management'; $requiredRole='admin';
require_once '../../includes/admin-header.php';
// Handle status toggle
if(isset($_GET['toggle'])){
    $uid=(int)$_GET['toggle'];
    $u=dbFetchOne("SELECT status FROM users WHERE id=? AND role!='admin'",[$uid],'i');
    if($u){$newStatus=$u['status']==='active'?'inactive':'active';dbExecute("UPDATE users SET status=? WHERE id=?",[$newStatus,$uid],'si');$_SESSION['success']='User status updated.';}
    header('Location: users.php');exit();
}
$users = dbFetchAll("SELECT * FROM users ORDER BY created_at DESC");
?>
<div class="admin-page-header"><h1>👥 User Management</h1></div>
<div class="search-bar"><input type="text" id="tableSearch" placeholder="Search users..."></div>
<div class="table-wrapper">
    <table>
        <thead><tr><th>#</th><th>Name</th><th>Email</th><th>Role</th><th>Status</th><th>Joined</th><th>Actions</th></tr></thead>
        <tbody>
        <?php foreach($users as $i=>$u): ?>
        <tr>
            <td><?php echo $i+1; ?></td>
            <td><strong><?php echo htmlspecialchars($u['name']); ?></strong></td>
            <td><?php echo htmlspecialchars($u['email']); ?></td>
            <td><span class="badge badge-info"><?php echo formatStatus($u['role']); ?></span></td>
            <td><span class="badge <?php echo $u['status']==='active'?'badge-success':'badge-danger'; ?>"><?php echo formatStatus($u['status']); ?></span></td>
            <td><?php echo formatDate($u['created_at']); ?></td>
            <td><?php if($u['role']!=='admin'): ?><a href="?toggle=<?php echo $u['id']; ?>" class="btn btn-sm <?php echo $u['status']==='active'?'btn-danger':'btn-success'; ?>" data-confirm="Toggle user status?"><?php echo $u['status']==='active'?'Deactivate':'Activate'; ?></a><?php endif; ?></td>
        </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php require_once '../../includes/admin-footer.php'; ?>
