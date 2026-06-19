<?php
$pageTitle = 'Change Password';
$requiredRole = 'volunteer';
require_once '../../includes/admin-header.php';
?>
<div class="admin-page-header"><h1>🔒 Change Password</h1></div>
<div class="form-container">
    <form method="POST" action="../auth/change-password.php" id="cpForm">
        <div class="form-group" data-validate="required">
            <label>Current Password <span class="required">*</span></label>
            <input type="password" name="current_password" placeholder="Enter current password" required>
            <div class="form-error"></div>
        </div>
        <div class="form-group" data-validate="required|min:8|password">
            <label>New Password <span class="required">*</span></label>
            <input type="password" name="new_password" id="newPass" placeholder="Min 8 characters" required>
            <div class="form-error"></div>
        </div>
        <div class="form-group" data-validate="required|match:newPass">
            <label>Confirm New Password <span class="required">*</span></label>
            <input type="password" name="confirm_password" placeholder="Re-enter new password" required>
            <div class="form-error"></div>
        </div>
        <div class="form-actions"><button type="submit" class="btn btn-primary">Change Password</button></div>
    </form>
    <script>setupLiveValidation('cpForm');</script>
</div>
<?php require_once '../../includes/admin-footer.php'; ?>
