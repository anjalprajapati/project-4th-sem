<?php
$pageTitle = 'Admin Dashboard';
$requiredRole = 'admin';
require_once '../../includes/admin-header.php';

$totalDonations = getTotalDonations();
$totalDonors = getTotalDonors();
$totalDogs = getTotalDogs();
$activeCampaigns = getActiveCampaigns();
$totalVolunteers = getTotalVolunteers();
$totalAdoptions = getTotalAdoptions();
$totalRescues = getTotalRescues();
$pendingAdoptions = dbFetchOne("SELECT COUNT(*) AS c FROM adoptions WHERE status='pending'")['c'];

$recentDonations = dbFetchAll("SELECT d.*, u.name AS donor_name, c.title AS campaign_title FROM donations d JOIN users u ON d.user_id=u.id JOIN campaigns c ON d.campaign_id=c.id ORDER BY d.date DESC LIMIT 8");
$activeCampaignsList = dbFetchAll("SELECT * FROM campaigns WHERE status='active' ORDER BY created_at DESC LIMIT 5");
?>

<div class="admin-page-header">
    <h1>📊 Dashboard</h1>
    <p style="color:var(--text-secondary);">Welcome back, <?php echo htmlspecialchars($userName); ?>!</p>
</div>

<!-- Stats Grid -->
<div class="stat-grid">
    <div class="stat-card">
        <div class="stat-icon orange">💰</div>
        <div class="stat-info"><h3><?php echo formatCurrency($totalDonations); ?></h3><p>Total Donations</p></div>
    </div>
    <div class="stat-card">
        <div class="stat-icon green">👥</div>
        <div class="stat-info"><h3><?php echo $totalDonors; ?></h3><p>Total Donors</p></div>
    </div>
    <div class="stat-card">
        <div class="stat-icon blue">🐕</div>
        <div class="stat-info"><h3><?php echo $totalDogs; ?></h3><p>Total Dogs</p></div>
    </div>
    <div class="stat-card">
        <div class="stat-icon teal">📢</div>
        <div class="stat-info"><h3><?php echo $activeCampaigns; ?></h3><p>Active Campaigns</p></div>
    </div>
    <div class="stat-card">
        <div class="stat-icon purple">🤝</div>
        <div class="stat-info"><h3><?php echo $totalVolunteers; ?></h3><p>Volunteers</p></div>
    </div>
    <div class="stat-card">
        <div class="stat-icon green">🏠</div>
        <div class="stat-info"><h3><?php echo $totalAdoptions; ?></h3><p>Adoptions</p></div>
    </div>
    <div class="stat-card">
        <div class="stat-icon red">🚑</div>
        <div class="stat-info"><h3><?php echo $totalRescues; ?></h3><p>Rescues</p></div>
    </div>
    <div class="stat-card">
        <div class="stat-icon orange">⏳</div>
        <div class="stat-info"><h3><?php echo $pendingAdoptions; ?></h3><p>Pending Adoptions</p></div>
    </div>
</div>

<!-- Active Campaigns -->
<?php if (!empty($activeCampaignsList)): ?>
<div class="recent-activity">
    <div class="card-header">📢 Active Campaigns</div>
    <div style="padding:20px;">
        <?php foreach ($activeCampaignsList as $c): ?>
        <div style="margin-bottom:16px;">
            <div class="flex-between mb-1">
                <strong><?php echo htmlspecialchars($c['title']); ?></strong>
                <span style="font-size:0.85rem;"><?php echo formatCurrency($c['current_amount']); ?> / <?php echo formatCurrency($c['goal_amount']); ?></span>
            </div>
            <div class="progress-bar">
                <div class="progress-fill" data-width="<?php echo progressPercent($c['current_amount'], $c['goal_amount']); ?>" style="width:0%"></div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>
<?php endif; ?>

<!-- Recent Donations -->
<?php if (!empty($recentDonations)): ?>
<div class="recent-activity mt-3">
    <div class="card-header">💰 Recent Donations</div>
    <div class="table-wrapper" style="box-shadow:none;">
        <table>
            <thead><tr><th>Donor</th><th>Campaign</th><th>Amount</th><th>Date</th></tr></thead>
            <tbody>
            <?php foreach ($recentDonations as $d): ?>
            <tr>
                <td><?php echo $d['is_anonymous'] ? 'Anonymous' : htmlspecialchars($d['donor_name']); ?></td>
                <td><?php echo htmlspecialchars($d['campaign_title']); ?></td>
                <td><strong><?php echo formatCurrency($d['amount']); ?></strong></td>
                <td><?php echo formatDate($d['date']); ?></td>
            </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php endif; ?>

<?php require_once '../../includes/admin-footer.php'; ?>
