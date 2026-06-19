<?php
$pageTitle = 'Donor Dashboard';
$requiredRole = 'donor';
require_once '../../includes/admin-header.php';

$userId = $_SESSION['user_id'];
$myTotalDonations = dbFetchOne("SELECT COALESCE(SUM(amount),0) AS total FROM donations WHERE user_id=?", [$userId], 'i')['total'];
$myDonationCount = dbFetchOne("SELECT COUNT(*) AS c FROM donations WHERE user_id=?", [$userId], 'i')['c'];
$campaignsSupported = dbFetchOne("SELECT COUNT(DISTINCT campaign_id) AS c FROM donations WHERE user_id=?", [$userId], 'i')['c'];
$activeCampaigns = getActiveCampaigns();

$recentDonations = dbFetchAll("SELECT d.*, c.title AS campaign_title FROM donations d JOIN campaigns c ON d.campaign_id=c.id WHERE d.user_id=? ORDER BY d.date DESC LIMIT 5", [$userId], 'i');
$campaigns = dbFetchAll("SELECT * FROM campaigns WHERE status='active' ORDER BY created_at DESC LIMIT 4");
?>

<div class="admin-page-header">
    <h1>📊 My Dashboard</h1>
    <p style="color:var(--text-secondary);">Welcome back, <?php echo htmlspecialchars($userName); ?>!</p>
</div>

<div class="stat-grid">
    <div class="stat-card"><div class="stat-icon orange">💰</div><div class="stat-info"><h3><?php echo formatCurrency($myTotalDonations); ?></h3><p>Total Donated</p></div></div>
    <div class="stat-card"><div class="stat-icon green">📋</div><div class="stat-info"><h3><?php echo $myDonationCount; ?></h3><p>Donations Made</p></div></div>
    <div class="stat-card"><div class="stat-icon blue">📢</div><div class="stat-info"><h3><?php echo $campaignsSupported; ?></h3><p>Campaigns Supported</p></div></div>
    <div class="stat-card"><div class="stat-icon teal">🎯</div><div class="stat-info"><h3><?php echo $activeCampaigns; ?></h3><p>Active Campaigns</p></div></div>
</div>

<!-- Active Campaigns to Donate -->
<?php if (!empty($campaigns)): ?>
<div class="recent-activity">
    <div class="card-header">📢 Active Campaigns — Support Now</div>
    <div style="padding:20px;">
        <div class="grid grid-2">
        <?php foreach ($campaigns as $c): ?>
            <div class="card" style="transform:none;">
                <div class="card-body">
                    <h4 class="card-title"><?php echo htmlspecialchars($c['title']); ?></h4>
                    <p class="card-text"><?php echo truncateText(htmlspecialchars($c['description']), 80); ?></p>
                    <div class="progress-bar"><div class="progress-fill" data-width="<?php echo progressPercent($c['current_amount'], $c['goal_amount']); ?>" style="width:0%"></div></div>
                    <div class="progress-text"><span><?php echo formatCurrency($c['current_amount']); ?></span><span>of <?php echo formatCurrency($c['goal_amount']); ?></span></div>
                    <a href="donate.php?campaign_id=<?php echo $c['id']; ?>" class="btn btn-sm btn-primary mt-2">💝 Donate</a>
                </div>
            </div>
        <?php endforeach; ?>
        </div>
    </div>
</div>
<?php endif; ?>

<!-- Recent Donations -->
<?php if (!empty($recentDonations)): ?>
<div class="recent-activity mt-3">
    <div class="card-header">💰 My Recent Donations</div>
    <div class="table-wrapper" style="box-shadow:none;">
        <table>
            <thead><tr><th>Campaign</th><th>Amount</th><th>Date</th><th>Receipt</th></tr></thead>
            <tbody>
            <?php foreach ($recentDonations as $d): ?>
            <tr>
                <td><?php echo htmlspecialchars($d['campaign_title']); ?></td>
                <td><strong><?php echo formatCurrency($d['amount']); ?></strong></td>
                <td><?php echo formatDate($d['date']); ?></td>
                <td><a href="receipt.php?id=<?php echo $d['id']; ?>" class="btn btn-sm btn-outline">🧾 View</a></td>
            </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php endif; ?>

<?php require_once '../../includes/admin-footer.php'; ?>
