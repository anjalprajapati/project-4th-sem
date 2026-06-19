<?php
require_once 'php/functions.php';
$id = (int)($_GET['id'] ?? 0);
if (!$id) { header('Location: dogs.php'); exit(); }
$dog = dbFetchOne("SELECT * FROM dogs WHERE id = ?", [$id], 'i');
if (!$dog) { header('Location: dogs.php'); exit(); }
$pageTitle = $dog['name'];
$rescue = dbFetchOne("SELECT * FROM rescues WHERE dog_id = ? ORDER BY rescue_date DESC LIMIT 1", [$id], 'i');
require_once 'includes/header.php';
?>
<div class="page-header">
    <div class="container">
        <h1>🐕 <?php echo htmlspecialchars($dog['name']); ?></h1>
        <div class="breadcrumb"><a href="index.php">Home</a> <span>/</span> <a href="dogs.php">Dogs</a> <span>/</span> <span><?php echo htmlspecialchars($dog['name']); ?></span></div>
    </div>
</div>

<section class="section">
    <div class="container">
        <div class="dog-detail-grid">
            <div class="dog-detail-img">
                <?php if ($dog['image']): ?>
                    <img src="uploads/dogs/<?php echo htmlspecialchars($dog['image']); ?>" alt="<?php echo htmlspecialchars($dog['name']); ?>">
                <?php else: ?>
                    <div style="width:100%; height:400px; background:linear-gradient(135deg, #D5F5E3, var(--secondary)); display:flex; align-items:center; justify-content:center; font-size:6rem; border-radius:var(--radius);">🐕</div>
                <?php endif; ?>
            </div>
            <div>
                <div class="card" style="transform:none;">
                    <div class="card-body">
                        <h2><?php echo htmlspecialchars($dog['name']); ?></h2>
                        <div style="display:flex; gap:8px; flex-wrap:wrap; margin-bottom:16px;">
                            <span class="badge <?php echo getStatusBadge($dog['health_status']); ?>"><?php echo formatStatus($dog['health_status']); ?></span>
                            <span class="badge <?php echo getStatusBadge($dog['vaccinated']); ?>"><?php echo formatStatus($dog['vaccinated']); ?></span>
                        </div>
                        <ul class="detail-list">
                            <li><span class="label">Breed</span> <span class="value"><?php echo htmlspecialchars($dog['breed']); ?></span></li>
                            <li><span class="label">Age</span> <span class="value"><?php echo htmlspecialchars($dog['age']); ?></span></li>
                            <li><span class="label">Gender</span> <span class="value"><?php echo formatStatus($dog['gender']); ?></span></li>
                            <li><span class="label">Health Status</span> <span class="value"><?php echo formatStatus($dog['health_status']); ?></span></li>
                            <li><span class="label">Vaccinated</span> <span class="value"><?php echo formatStatus($dog['vaccinated']); ?></span></li>
                            <?php if ($rescue): ?>
                            <li><span class="label">Rescue Date</span> <span class="value"><?php echo formatDate($rescue['rescue_date']); ?></span></li>
                            <li><span class="label">Rescue Location</span> <span class="value"><?php echo htmlspecialchars($rescue['location']); ?></span></li>
                            <li><span class="label">Rescue Status</span> <span class="badge <?php echo getStatusBadge($rescue['status']); ?>"><?php echo formatStatus($rescue['status']); ?></span></li>
                            <?php endif; ?>
                        </ul>
                        <?php if ($dog['description']): ?>
                            <h4 class="mt-3">About <?php echo htmlspecialchars($dog['name']); ?></h4>
                            <p><?php echo nl2br(htmlspecialchars($dog['description'])); ?></p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Adoption Form -->
        <div id="adopt" class="mt-4">
            <div class="form-container wide">
                <h2>🏠 Apply to Adopt <?php echo htmlspecialchars($dog['name']); ?></h2>
                <form method="POST" action="php/admin/adoption-process.php" id="adoptForm">
                    <input type="hidden" name="action" value="apply">
                    <input type="hidden" name="dog_id" value="<?php echo $dog['id']; ?>">
                    <div class="form-row">
                        <div class="form-group" data-validate="required|min:2|alpha">
                            <label>Your Full Name <span class="required">*</span></label>
                            <input type="text" name="adopter_name" placeholder="Enter your name" required>
                            <div class="form-error"></div>
                        </div>
                        <div class="form-group" data-validate="required|phone">
                            <label>Phone Number <span class="required">*</span></label>
                            <input type="text" name="phone" placeholder="10-digit phone number" required>
                            <div class="form-error"></div>
                        </div>
                    </div>
                    <div class="form-group" data-validate="required|email">
                        <label>Email <span class="required">*</span></label>
                        <input type="email" name="email" placeholder="you@example.com" required>
                        <div class="form-error"></div>
                    </div>
                    <div class="form-group" data-validate="required|min:10">
                        <label>Address <span class="required">*</span></label>
                        <textarea name="address" placeholder="Your complete address" required></textarea>
                        <div class="form-error"></div>
                    </div>
                    <div class="form-group" data-validate="required|min:10">
                        <label>Why do you want to adopt? <span class="required">*</span></label>
                        <textarea name="reason" placeholder="Tell us why you'd be a great pet parent" required></textarea>
                        <div class="form-error"></div>
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">Submit Application</button>
                    </div>
                </form>
                <script>setupLiveValidation('adoptForm');</script>
            </div>
        </div>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>
