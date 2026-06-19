<?php
$pageTitle = 'Contact Us';
require_once 'php/functions.php';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = sanitize($_POST['name'] ?? '');
    $email = sanitize($_POST['email'] ?? '');
    $subject = sanitize($_POST['subject'] ?? '');
    $message = sanitize($_POST['message'] ?? '');

    if ($name && $email && $subject && $message) {
        dbExecute("INSERT INTO contact_messages (name, email, subject, message) VALUES (?, ?, ?, ?)", [$name, $email, $subject, $message], 'ssss');
        $_SESSION['success'] = 'Thank you for your message! We will get back to you soon.';
    } else {
        $_SESSION['error'] = 'Please fill in all required fields.';
    }
    header('Location: contact.php');
    exit();
}

require_once 'includes/header.php';
?>
<div class="page-header">
    <div class="container">
        <h1>Contact Us</h1>
        <p>We'd love to hear from you. Reach out with questions, suggestions, or support.</p>
        <div class="breadcrumb"><a href="index.php">Home</a> <span>/</span> <span>Contact</span></div>
    </div>
</div>

<section class="section">
    <div class="container">
        <div class="contact-grid">
            <div>
                <h2>Get in Touch</h2>
                <p>Have questions about our work, want to volunteer, or need help? Fill out the form and we'll respond as soon as possible.</p>
                <div class="contact-info-card">
                    <div class="icon">📍</div>
                    <div><h4>Address</h4><p>123 Animal Welfare Road, City, State 560001</p></div>
                </div>
                <div class="contact-info-card">
                    <div class="icon">📧</div>
                    <div><h4>Email</h4><p>info@streetdogs.org</p></div>
                </div>
                <div class="contact-info-card">
                    <div class="icon">📞</div>
                    <div><h4>Phone</h4><p>+91 98765 43210</p></div>
                </div>
                <div class="contact-info-card">
                    <div class="icon">🕐</div>
                    <div><h4>Hours</h4><p>Mon - Sat: 9:00 AM - 6:00 PM</p></div>
                </div>
            </div>
            <div>
                <div class="form-container" style="max-width:100%;">
                    <h2>Send a Message</h2>
                    <form method="POST" id="contactForm">
                        <div class="form-group" data-validate="required|min:2">
                            <label>Your Name <span class="required">*</span></label>
                            <input type="text" name="name" placeholder="Enter your name" required>
                            <div class="form-error"></div>
                        </div>
                        <div class="form-group" data-validate="required|email">
                            <label>Email Address <span class="required">*</span></label>
                            <input type="email" name="email" placeholder="you@example.com" required>
                            <div class="form-error"></div>
                        </div>
                        <div class="form-group" data-validate="required|min:3">
                            <label>Subject <span class="required">*</span></label>
                            <input type="text" name="subject" placeholder="What's this about?" required>
                            <div class="form-error"></div>
                        </div>
                        <div class="form-group" data-validate="required|min:10">
                            <label>Message <span class="required">*</span></label>
                            <textarea name="message" placeholder="Tell us more..." required></textarea>
                            <div class="form-error"></div>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Send Message</button>
                    </form>
                    <script>setupLiveValidation('contactForm');</script>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>
