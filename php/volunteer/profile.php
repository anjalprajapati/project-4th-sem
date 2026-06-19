<?php
$pageTitle = 'My Profile';
$requiredRole = 'volunteer';
require_once '../../includes/admin-header.php';

$userId = $_SESSION['user_id'];
$volunteer = dbFetchOne("SELECT * FROM volunteers WHERE user_id=?", [$userId], 'i');

// Handle profile update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = sanitize($_POST['name']);
    $email = sanitize($_POST['email']);
    $phone = sanitize($_POST['phone']);
    $availability = sanitize($_POST['availability']);

    $existing = dbFetchOne("SELECT id FROM users WHERE email=? AND id!=?", [$email, $userId], 'si');
    if ($existing) {
        $_SESSION['error'] = 'Email is already used by another account.';
    } else {
        dbExecute("UPDATE users SET name=?, email=? WHERE id=?", [$name, $email, $userId], 'ssi');
        if ($volunteer) {
            dbExecute("UPDATE volunteers SET phone=?, availability=? WHERE user_id=?", [$phone, $availability, $userId], 'ssi');
        }
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
        <div class="form-group" data-validate="required|phone">
            <label>Phone Number <span class="required">*</span></label>
            <input type="text" name="phone" value="<?php echo $volunteer ? htmlspecialchars($volunteer['phone']) : ''; ?>" required>
            <div class="form-error"></div>
        </div>
        <div class="form-group">
            <label>Availability</label>
            <select name="availability">
                <?php foreach (['available', 'busy', 'on_leave'] as $s): ?>
                <option value="<?php echo $s; ?>" <?php echo ($volunteer && $volunteer['availability'] === $s) ? 'selected' : ''; ?>><?php echo formatStatus($s); ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label>Role</label>
            <input type="text" value="Volunteer" disabled style="background:#f0f0f0;">
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
