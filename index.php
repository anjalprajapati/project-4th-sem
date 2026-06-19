<?php
/**
 * Home Page
 */
$pageTitle = 'Home';
require_once 'php/functions.php';
require_once 'includes/header.php';

// Get stats
$totalDonations = getTotalDonations();
$totalDogs = getTotalDogs();
$totalVolunteers = getTotalVolunteers();
$totalAdoptions = getTotalAdoptions();

// Get active campaigns (latest 3)
$campaigns = dbFetchAll("SELECT * FROM campaigns WHERE status = 'active' ORDER BY created_at DESC LIMIT 3");

// Get recent rescues (latest 3)
$recentDogs = dbFetchAll("SELECT * FROM dogs ORDER BY created_at DESC LIMIT 3");

// Get latest updates
$latestUpdates = dbFetchAll("SELECT * FROM updates ORDER BY date DESC LIMIT 3");
?>

<!-- Hero Section -->
<section class="hero">
    <div class="container">
        <h1>Give Street Dogs a <span>Second Chance</span> at Life</h1>
        <p>Join our mission to rescue, treat, and rehome street dogs. Every donation, every volunteer hour, every adoption changes a life forever.</p>
        <div class="hero-buttons">
            <a href="campaigns.php" class="btn btn-lg btn-primary">Donate Now</a>
            <a href="register.php" class="btn btn-lg btn-outline" style="color:#fff; border-color:#fff;">Become a Volunteer</a>
        </div>
        <div class="hero-stats">
            <div class="hero-stat">
                <h3 data-count="<?php echo (int)$totalDonations; ?>" data-prefix="₹"><?php echo formatCurrency($totalDonations); ?></h3>
                <p>Total Raised</p>
            </div>
            <div class="hero-stat">
                <h3 data-count="<?php echo $totalDogs; ?>">0</h3>
                <p>Dogs Rescued</p>
            </div>
            <div class="hero-stat">
                <h3 data-count="<?php echo $totalVolunteers; ?>">0</h3>
                <p>Volunteers</p>
            </div>
            <div class="hero-stat">
                <h3 data-count="<?php echo $totalAdoptions; ?>">0</h3>
                <p>Adopted</p>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="section">
    <div class="container">
        <div class="section-title">
            <h2>How We Help Street Dogs</h2>
            <p>Our comprehensive approach covers every aspect of street dog welfare</p>
            <div class="line"></div>
        </div>
        <div class="grid grid-4">
            <div class="feature-card">
                <div class="icon" style="background:var(--primary-light); color:var(--primary);">🚑</div>
                <h4>Rescue Operations</h4>
                <p>Swift response to rescue injured and distressed street dogs from dangerous situations.</p>
            </div>
            <div class="feature-card">
                <div class="icon" style="background:#D5F5E3; color:var(--success);">💊</div>
                <h4>Medical Treatment</h4>
                <p>Complete veterinary care including surgery, vaccination, and rehabilitation.</p>
            </div>
            <div class="feature-card">
                <div class="icon" style="background:#D6EAF8; color:var(--info);">🍖</div>
                <h4>Feeding Programs</h4>
                <p>Daily feeding drives at multiple locations ensuring no dog goes hungry.</p>
            </div>
            <div class="feature-card">
                <div class="icon" style="background:#E8DAEF; color:#8E44AD;">🏠</div>
                <h4>Adoption Services</h4>
                <p>Finding loving forever homes for recovered and rehabilitated dogs.</p>
            </div>
        </div>
    </div>
</section>

<!-- Active Campaigns -->
<?php if (!empty($campaigns)): ?>
<section class="section" style="background: var(--white);">
    <div class="container">
        <div class="section-title">
            <h2>Active Campaigns</h2>
            <p>Support our ongoing fundraising campaigns and make a real difference</p>
            <div class="line"></div>
        </div>
        <div class="grid grid-3">
            <?php foreach ($campaigns as $campaign): ?>
            <div class="card">
                <?php if ($campaign['image']): ?>
                    <img src="uploads/campaigns/<?php echo htmlspecialchars($campaign['image']); ?>" alt="<?php echo htmlspecialchars($campaign['title']); ?>" class="card-img">
                <?php else: ?>
                    <div class="card-img" style="background:linear-gradient(135deg, var(--primary-light), var(--primary)); display:flex; align-items:center; justify-content:center; font-size:3rem;">📢</div>
                <?php endif; ?>
                <div class="card-body">
                    <h3 class="card-title"><?php echo htmlspecialchars($campaign['title']); ?></h3>
                    <p class="card-text"><?php echo truncateText(htmlspecialchars($campaign['description']), 100); ?></p>
                    <div class="progress-bar">
                        <div class="progress-fill" data-width="<?php echo progressPercent($campaign['current_amount'], $campaign['goal_amount']); ?>" style="width:0%"></div>
                    </div>
                    <div class="progress-text">
                        <span><?php echo formatCurrency($campaign['current_amount']); ?> raised</span>
                        <span><?php echo progressPercent($campaign['current_amount'], $campaign['goal_amount']); ?>%</span>
                    </div>
                </div>
                <div class="card-footer">
                    <span style="font-size:0.85rem; color:var(--text-secondary);">Goal: <?php echo formatCurrency($campaign['goal_amount']); ?></span>
                    <a href="campaign-detail.php?id=<?php echo $campaign['id']; ?>" class="btn btn-sm btn-primary">Donate</a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <div class="text-center mt-4">
            <a href="campaigns.php" class="btn btn-outline">View All Campaigns →</a>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Recent Dogs -->
<?php if (!empty($recentDogs)): ?>
<section class="section">
    <div class="container">
        <div class="section-title">
            <h2>Recently Rescued Dogs</h2>
            <p>Meet the dogs who need your love and support</p>
            <div class="line"></div>
        </div>
        <div class="grid grid-3">
            <?php foreach ($recentDogs as $dog): ?>
            <div class="card">
                <?php if ($dog['image']): ?>
                    <img src="uploads/dogs/<?php echo htmlspecialchars($dog['image']); ?>" alt="<?php echo htmlspecialchars($dog['name']); ?>" class="card-img">
                <?php else: ?>
                    <div class="card-img" style="background:linear-gradient(135deg, #D5F5E3, var(--secondary)); display:flex; align-items:center; justify-content:center; font-size:3rem;">🐕</div>
                <?php endif; ?>
                <div class="card-body">
                    <h3 class="card-title">🐕 <?php echo htmlspecialchars($dog['name']); ?></h3>
                    <p class="card-text"><?php echo htmlspecialchars($dog['breed']); ?> · <?php echo htmlspecialchars($dog['age']); ?> · <?php echo formatStatus($dog['gender']); ?></p>
                    <div>
                        <span class="badge <?php echo getStatusBadge($dog['health_status']); ?>"><?php echo formatStatus($dog['health_status']); ?></span>
                        <span class="badge <?php echo getStatusBadge($dog['vaccinated']); ?>"><?php echo formatStatus($dog['vaccinated']); ?></span>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="dog-detail.php?id=<?php echo $dog['id']; ?>" class="btn btn-sm btn-outline">View Profile</a>
                    <a href="dog-detail.php?id=<?php echo $dog['id']; ?>#adopt" class="btn btn-sm btn-secondary">Adopt</a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <div class="text-center mt-4">
            <a href="dogs.php" class="btn btn-outline">Meet All Dogs →</a>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Latest News -->
<?php if (!empty($latestUpdates)): ?>
<section class="section" style="background: var(--white);">
    <div class="container">
        <div class="section-title">
            <h2>Latest Updates</h2>
            <p>Stories of hope, events, and awareness from our community</p>
            <div class="line"></div>
        </div>
        <div class="grid grid-3">
            <?php foreach ($latestUpdates as $update): ?>
            <div class="card">
                <?php if ($update['image']): ?>
                    <img src="uploads/updates/<?php echo htmlspecialchars($update['image']); ?>" alt="<?php echo htmlspecialchars($update['title']); ?>" class="card-img">
                <?php else: ?>
                    <div class="card-img" style="background:linear-gradient(135deg, #FEF5E7, var(--warning)); display:flex; align-items:center; justify-content:center; font-size:3rem;">📰</div>
                <?php endif; ?>
                <div class="card-body">
                    <span class="badge <?php echo $update['category']==='success_story'?'badge-success':($update['category']==='event'?'badge-info':'badge-warning'); ?>"><?php echo formatStatus($update['category']); ?></span>
                    <h3 class="card-title mt-1"><?php echo htmlspecialchars($update['title']); ?></h3>
                    <p class="card-text"><?php echo truncateText(htmlspecialchars($update['description']), 120); ?></p>
                    <p style="font-size:0.82rem; color:var(--text-secondary); margin:0;"><?php echo formatDate($update['date']); ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <div class="text-center mt-4">
            <a href="news.php" class="btn btn-outline">Read More →</a>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- CTA Section -->
<section class="section" style="background: linear-gradient(135deg, var(--primary), var(--primary-dark)); text-align:center; color:var(--white);">
    <div class="container">
        <h2 style="color:var(--white); font-size:2rem;">Ready to Make a Difference?</h2>
        <p style="color:rgba(255,255,255,0.85); max-width:600px; margin:0 auto 30px; font-size:1.1rem;">Whether you donate, volunteer, or adopt — every action saves a life. Join our community today.</p>
        <div style="display:flex; gap:16px; justify-content:center; flex-wrap:wrap;">
            <a href="register.php" class="btn btn-lg" style="background:var(--white); color:var(--primary);">Get Started</a>
            <a href="about.php" class="btn btn-lg btn-outline" style="color:var(--white); border-color:var(--white);">Learn More</a>
        </div>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>
