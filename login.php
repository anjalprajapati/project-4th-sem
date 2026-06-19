<?php
$pageTitle = 'Login';
require_once 'php/functions.php';
if (isLoggedIn()) {
    header('Location: php/' . $_SESSION['role'] . '/dashboard.php');
    exit();
}
require_once 'includes/header.php';
?>
<div class="auth-page">
    <div class="auth-card">
        <div class="logo" style="justify-content:center; margin-bottom:12px;"><span>🐕</span> Street Dog Fundraising</div>
        <h2>Welcome Back</h2>
        <p class="subtitle">Login to your account</p>
        <form id="loginForm" method="POST" action="php/auth/login.php">
            <div class="form-group" data-validate="required|email">
                <label>Email Address <span class="required">*</span></label>
                <input type="email" name="email" placeholder="you@example.com" required>
                <div class="form-error"></div>
            </div>
            <div class="form-group" data-validate="required">
                <label>Password <span class="required">*</span></label>
                <input type="password" name="password" placeholder="Enter your password" required>
                <div class="form-error"></div>
            </div>
            <div style="text-align:right; margin-bottom:16px;">
                <a href="forgot-password.php" style="font-size:0.88rem;">Forgot Password?</a>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Login</button>
        </form>
        <div class="auth-links">
            Don't have an account? <a href="register.php">Register here</a>
        </div>
    </div>
</div>
<script>setupLiveValidation('loginForm');</script>
<?php require_once 'includes/footer.php'; ?>
