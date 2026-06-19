<?php
$pageTitle = 'Donation Management';
$requiredRole = 'admin';
require_once '../../includes/admin-header.php';
$donations = dbFetchAll("SELECT d.*, u.name AS donor_name, c.title AS campaign_title FROM donations d JOIN users u ON d.user_id=u.id JOIN campaigns c ON d.campaign_id=c.id ORDER BY d.date DESC");
$totalAmount = array_sum(array_column($donations, 'amount'));
?>
<div class="admin-page-header"><h1>💰 Donation Management</h1></div>
<div class="stat-grid" style="grid-template-columns:repeat(3,1fr);">
    <div class="stat-card"><div class="stat-icon orange">💰</div><div class="stat-info"><h3><?php echo formatCurrency($totalAmount); ?></h3><p>Total Raised</p></div></div>
    <div class="stat-card"><div class="stat-icon green">📋</div><div class="stat-info"><h3><?php echo count($donations); ?></h3><p>Total Transactions</p></div></div>
    <div class="stat-card"><div class="stat-icon blue">👥</div><div class="stat-info"><h3><?php echo getTotalDonors(); ?></h3><p>Unique Donors</p></div></div>
</div>
<div class="search-bar"><input type="text" id="tableSearch" placeholder="Search donations by donor, campaign, amount..."></div>
<div class="table-wrapper">
    <table>
        <thead><tr><th>#</th><th>Transaction ID</th><th>Donor</th><th>Campaign</th><th>Amount</th><th>Date</th><th>Actions</th></tr></thead>
        <tbody>
        <?php foreach($donations as $i=>$d): ?>
        <tr>
            <td><?php echo $i+1; ?></td>
            <td><code><?php echo htmlspecialchars($d['transaction_id']); ?></code></td>
            <td><?php echo $d['is_anonymous'] ? '<em>Anonymous</em>' : htmlspecialchars($d['donor_name']); ?></td>
            <td><?php echo htmlspecialchars($d['campaign_title']); ?></td>
            <td><strong><?php echo formatCurrency($d['amount']); ?></strong></td>
            <td><?php echo formatDateTime($d['date']); ?></td>
            <td><a href="receipt.php?id=<?php echo $d['id']; ?>" class="action-view" title="Receipt">🧾</a></td>
        </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php require_once '../../includes/admin-footer.php'; ?>
