<?php
$pageTitle = 'About Us';
require_once 'php/functions.php';
require_once 'includes/header.php';
?>
<div class="page-header">
    <div class="container">
        <h1>About Us</h1>
        <p>Learn about our mission, vision, and the team behind Street Dog Fundraising</p>
        <div class="breadcrumb"><a href="index.php">Home</a> <span>/</span> <span>About</span></div>
    </div>
</div>

<section class="section">
    <div class="container">
        <div class="grid grid-2" style="align-items:center; gap:50px;">
            <div>
                <h2>Our Mission</h2>
                <p>The Street Dog Fundraising and Support Management System is a centralized platform dedicated to improving the lives of street dogs through organized rescue operations, medical treatment, feeding programs, and adoption services.</p>
                <p>We believe every street dog deserves a chance at a safe, healthy, and happy life. By connecting donors, volunteers, and animal welfare workers through technology, we create a transparent and efficient ecosystem for street dog welfare.</p>
                <h3 class="mt-3">Our Vision</h3>
                <p>A world where no street dog suffers from hunger, disease, or neglect — where every stray has access to food, medical care, and the opportunity to find a loving home.</p>
            </div>
            <div style="background:linear-gradient(135deg, var(--primary-light), #D5F5E3); border-radius:var(--radius-lg); padding:60px; text-align:center; font-size:6rem;">
                🐕‍🦺
            </div>
        </div>
    </div>
</section>

<section class="section" style="background:var(--white);">
    <div class="container">
        <div class="section-title">
            <h2>What We Do</h2>
            <p>Our comprehensive approach to street dog welfare</p>
            <div class="line"></div>
        </div>
        <div class="grid grid-3">
            <div class="feature-card">
                <div class="icon" style="background:#FADBD8; color:var(--accent);">🚑</div>
                <h4>Rescue & Rehabilitation</h4>
                <p>We respond to rescue calls and provide immediate medical attention to injured and distressed street dogs, rehabilitating them for adoption.</p>
            </div>
            <div class="feature-card">
                <div class="icon" style="background:#D5F5E3; color:var(--success);">💉</div>
                <h4>Vaccination Drives</h4>
                <p>Regular vaccination campaigns to protect street dogs from rabies and other diseases, keeping both animals and communities safe.</p>
            </div>
            <div class="feature-card">
                <div class="icon" style="background:#D6EAF8; color:var(--info);">🍖</div>
                <h4>Feeding Programs</h4>
                <p>Daily feeding rounds across multiple locations ensuring hundreds of street dogs receive nutritious meals every day.</p>
            </div>
            <div class="feature-card">
                <div class="icon" style="background:#FEF5E7; color:var(--warning);">💰</div>
                <h4>Fundraising</h4>
                <p>Transparent fundraising campaigns with clear goals and real-time progress tracking so donors see exactly how their money helps.</p>
            </div>
            <div class="feature-card">
                <div class="icon" style="background:#E8DAEF; color:#8E44AD;">🤝</div>
                <h4>Volunteer Coordination</h4>
                <p>Organized volunteer management with task assignment, tracking, and recognition to maximize community impact.</p>
            </div>
            <div class="feature-card">
                <div class="icon" style="background:var(--primary-light); color:var(--primary);">🏠</div>
                <h4>Adoption Services</h4>
                <p>Careful adoption process ensuring recovered dogs find responsible, loving forever homes with thorough screening.</p>
            </div>
        </div>
    </div>
</section>

<section class="section" style="background:linear-gradient(135deg, var(--bg-dark), #34495E); color:var(--white); text-align:center;">
    <div class="container">
        <h2 style="color:var(--white);">Join Our Cause</h2>
        <p style="color:rgba(255,255,255,0.8); max-width:600px; margin:0 auto 30px; font-size:1.1rem;">Whether you donate, volunteer, or adopt — every action makes a difference in a street dog's life.</p>
        <div style="display:flex; gap:16px; justify-content:center; flex-wrap:wrap;">
            <a href="register.php" class="btn btn-lg btn-primary">Get Involved</a>
            <a href="contact.php" class="btn btn-lg btn-outline" style="color:var(--white); border-color:var(--white);">Contact Us</a>
        </div>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>
