<?php
$pageTitle = 'My Profile';
$requiredRole = 'donor';
require_once '../../includes/admin-header.php';

$userId = $_SESSION['user_id'];

// Handle profile update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = sanitize($_POST['name']);
    $email = sanitize($_POST['email']);
    // Check email uniqueness
    $existing = dbFetchOne("SELECT id FROM users WHERE email=? AND id!=?", [$email, $userId], 'si');
    if ($existing) {
        $_SESSION['error'] = 'Email is already used by another account.';
    } else {
        dbExecute("UPDATE users SET name=?, email=? WHERE id=?", [$name, $email, $userId], 'ssi');
        $_SESSION['name'] = $name;
        $_SESSION['email'] = $email;
        $_SESSION['success'] = 'Profile updated successfully!';
    }
    header('Location: profile.php'); exit();
}

$user = dbFetchOne("SELECT * FROM users WHERE id=?", [$userId], 'i');
?>

<div class="admin-page-header"><h1>👤 My Profile</h1></div>

<div class="form-container">
    <form method="POST" id="profileForm">
        <div class="form-group" data-validate="required|min:2">
            <label>Full Name <span class="required">*</span></label>
            <input type="text" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required>
            <div class="form-error"></div>
        </div>
        <div class="form-group" data-validate="required|email">
            <label>Email Address <span class="required">*</span></label>
            <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
            <div class="form-error"></div>
        </div>
        <div class="form-group">
            <label>Role</label>
            <input type="text" value="<?php echo formatStatus($user['role']); ?>" disabled style="background:#f0f0f0;">
        </div>
        <div class="form-group">
            <label>Member Since</label>
            <input type="text" value="<?php echo formatDate($user['created_at']); ?>" disabled style="background:#f0f0f0;">
        </div>
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Update Profile</button>
        </div>
    </form>
    <script>setupLiveValidation('profileForm');</script>
</div>

<?php require_once '../../includes/admin-footer.php'; ?>
