<?php
$pageTitle = 'Make a Donation';
$requiredRole = 'donor';
require_once '../../includes/admin-header.php';

$campaignId = (int)($_GET['campaign_id'] ?? 0);
$campaign = $campaignId ? dbFetchOne("SELECT * FROM campaigns WHERE id=? AND status='active'", [$campaignId], 'i') : null;
$campaigns = dbFetchAll("SELECT id, title FROM campaigns WHERE status='active' ORDER BY title");
?>

<div class="admin-page-header"><h1>💝 Make a Donation</h1><a href="dashboard.php" class="btn btn-outline">← Dashboard</a></div>

<div class="form-container wide">
    <?php if ($campaign): ?>
    <div class="card mb-3" style="transform:none; background:var(--primary-light);">
        <div class="card-body">
            <h3><?php echo htmlspecialchars($campaign['title']); ?></h3>
            <p class="card-text"><?php echo truncateText(htmlspecialchars($campaign['description']), 150); ?></p>
            <div class="progress-bar"><div class="progress-fill" data-width="<?php echo progressPercent($campaign['current_amount'], $campaign['goal_amount']); ?>" style="width:0%"></div></div>
            <div class="progress-text"><span><?php echo formatCurrency($campaign['current_amount']); ?> raised</span><span>Goal: <?php echo formatCurrency($campaign['goal_amount']); ?></span></div>
        </div>
    </div>
    <?php endif; ?>

    <form method="POST" action="donate-process.php" id="donateForm">
        <div class="form-group" data-validate="required">
            <label>Select Campaign <span class="required">*</span></label>
            <select name="campaign_id" required>
                <option value="">-- Choose a campaign --</option>
                <?php foreach ($campaigns as $c): ?>
                <option value="<?php echo $c['id']; ?>" <?php echo ($campaignId == $c['id']) ? 'selected' : ''; ?>><?php echo htmlspecialchars($c['title']); ?></option>
                <?php endforeach; ?>
            </select>
            <div class="form-error"></div>
        </div>

        <div class="form-group" data-validate="required|number|min_value:1">
            <label>Donation Amount (₹) <span class="required">*</span></label>
            <input type="number" name="amount" min="1" step="0.01" placeholder="Enter amount" required>
            <div class="form-error"></div>
            <p class="form-help">Minimum donation: ₹1.00</p>
        </div>

        <div class="form-check">
            <input type="checkbox" name="is_anonymous" id="isAnonymous" value="1">
            <label for="isAnonymous">Make this donation anonymous (your name won't appear publicly)</label>
        </div>

        <div class="form-actions">
            <a href="dashboard.php" class="btn btn-outline">Cancel</a>
            <button type="submit" class="btn btn-primary btn-lg">💝 Donate Now</button>
        </div>
    </form>
    <script>setupLiveValidation('donateForm');</script>
</div>

<?php require_once '../../includes/admin-footer.php'; ?>
