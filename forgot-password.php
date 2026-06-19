<?php
$pageTitle = 'Forgot Password';
require_once 'php/functions.php';
require_once 'includes/header.php';
$step = $_GET['step'] ?? '1';
?>
<div class="auth-page">
    <div class="auth-card">
        <div class="logo" style="justify-content:center; margin-bottom:12px;"><span>🔒</span></div>
        <h2>Reset Password</h2>

        <?php if ($step === '1'): ?>
        <p class="subtitle">Enter your email address to get started</p>
        <form method="POST" action="php/auth/forgot-password.php">
            <input type="hidden" name="step" value="1">
            <div class="form-group">
                <label>Email Address <span class="required">*</span></label>
                <input type="email" name="email" placeholder="you@example.com" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Continue</button>
        </form>

        <?php elseif ($step === '2' && isset($_SESSION['reset_question'])): ?>
        <p class="subtitle">Answer your security question</p>
        <form method="POST" action="php/auth/forgot-password.php" id="resetForm">
            <input type="hidden" name="step" value="2">
            <div class="form-group">
                <label>Security Question</label>
                <input type="text" value="<?php echo htmlspecialchars($_SESSION['reset_question']); ?>" disabled style="background:#f0f0f0;">
            </div>
            <div class="form-group" data-validate="required">
                <label>Your Answer <span class="required">*</span></label>
                <input type="text" name="security_answer" placeholder="Enter your answer" required>
                <div class="form-error"></div>
            </div>
            <div class="form-group" data-validate="required|min:8">
                <label>New Password <span class="required">*</span></label>
                <input type="password" name="new_password" id="newPass" placeholder="Min 8 characters" required>
                <div class="form-error"></div>
            </div>
            <div class="form-group" data-validate="required|match:newPass">
                <label>Confirm New Password <span class="required">*</span></label>
                <input type="password" name="confirm_password" placeholder="Re-enter password" required>
                <div class="form-error"></div>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Reset Password</button>
        </form>
        <script>setupLiveValidation('resetForm');</script>
        <?php else: ?>
        <p class="subtitle">Please start over.</p>
        <a href="forgot-password.php" class="btn btn-primary btn-block">Try Again</a>
        <?php endif; ?>

        <div class="auth-links mt-2">
            <a href="login.php">← Back to Login</a>
        </div>
    </div>
</div>
<?php require_once 'includes/footer.php'; ?>
