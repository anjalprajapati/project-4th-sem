<?php
$pageTitle = 'Register';
require_once 'php/functions.php';
if (isLoggedIn()) {
    header('Location: php/' . $_SESSION['role'] . '/dashboard.php');
    exit();
}
require_once 'includes/header.php';
?>
<div class="auth-page">
    <div class="auth-card" style="max-width:520px;">
        <div class="logo" style="justify-content:center; margin-bottom:12px;"><span>🐕</span> Street Dog Fundraising</div>
        <h2>Create an Account</h2>
        <p class="subtitle">Join us in making a difference</p>
        <form id="registerForm" method="POST" action="php/auth/register.php">
            <div class="form-group" data-validate="required|min:2|alpha">
                <label>Full Name <span class="required">*</span></label>
                <input type="text" name="name" placeholder="Enter your full name" required>
                <div class="form-error"></div>
            </div>
            <div class="form-group" data-validate="required|email">
                <label>Email Address <span class="required">*</span></label>
                <input type="email" name="email" placeholder="you@example.com" required>
                <div class="form-error"></div>
            </div>
            <div class="form-group" data-validate="required">
                <label>I want to join as <span class="required">*</span></label>
                <select name="role" id="roleSelect" required>
                    <option value="donor">Donor</option>
                    <option value="volunteer">Volunteer</option>
                </select>
            </div>
            <div class="form-group" id="phoneGroup" style="display:none;" data-validate="phone">
                <label>Phone Number <span class="required">*</span></label>
                <input type="text" name="phone" placeholder="10-digit phone number">
                <div class="form-error"></div>
            </div>
            <div class="form-row">
                <div class="form-group" data-validate="required|min:8|password">
                    <label>Password <span class="required">*</span></label>
                    <input type="password" name="password" id="regPassword" placeholder="Min 8 characters" required>
                    <div class="form-error"></div>
                </div>
                <div class="form-group" data-validate="required|match:regPassword">
                    <label>Confirm Password <span class="required">*</span></label>
                    <input type="password" name="confirm_password" placeholder="Re-enter password" required>
                    <div class="form-error"></div>
                </div>
            </div>
            <div class="form-group">
                <label>Security Question</label>
                <select name="security_question">
                    <option value="">-- Select (optional) --</option>
                    <option value="What is your pet's name?">What is your pet's name?</option>
                    <option value="What city were you born in?">What city were you born in?</option>
                    <option value="What is your mother's maiden name?">What is your mother's maiden name?</option>
                    <option value="What was your first school?">What was your first school?</option>
                </select>
            </div>
            <div class="form-group">
                <label>Security Answer</label>
                <input type="text" name="security_answer" placeholder="Your answer">
            </div>
            <button type="submit" class="btn btn-primary btn-block">Create Account</button>
        </form>
        <div class="auth-links">
            Already have an account? <a href="login.php">Login here</a>
        </div>
    </div>
</div>
<script>
setupLiveValidation('registerForm');
document.getElementById('roleSelect').addEventListener('change', function(){
    document.getElementById('phoneGroup').style.display = this.value === 'volunteer' ? 'block' : 'none';
});
</script>
<?php require_once 'includes/footer.php'; ?>
