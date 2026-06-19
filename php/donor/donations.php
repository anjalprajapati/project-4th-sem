<?php
$pageTitle = 'My Donations';
$requiredRole = 'donor';
require_once '../../includes/admin-header.php';

$userId = $_SESSION['user_id'];
$donations = dbFetchAll("SELECT d.*, c.title AS campaign_title FROM donations d JOIN campaigns c ON d.campaign_id=c.id WHERE d.user_id=? ORDER BY d.date DESC", [$userId], 'i');
$totalAmount = array_sum(array_column($donations, 'amount'));
?>

<div class="admin-page-header"><h1>💰 My Donation History</h1></div>

<div class="stat-grid" style="grid-template-columns:repeat(2,1fr);">
    <div class="stat-card"><div class="stat-icon orange">💰</div><div class="stat-info"><h3><?php echo formatCurrency($totalAmount); ?></h3><p>Total Donated</p></div></div>
    <div class="stat-card"><div class="stat-icon green">📋</div><div class="stat-info"><h3><?php echo count($donations); ?></h3><p>Total Transactions</p></div></div>
</div>

<div class="search-bar"><input type="text" id="tableSearch" placeholder="Search by campaign, amount, date..."></div>

<?php if (empty($donations)): ?>
    <div class="empty-state"><div class="icon">💰</div><h3>No donations yet</h3><p>You haven't made any donations yet. <a href="donate.php">Make your first donation!</a></p></div>
<?php else: ?>
<div class="table-wrapper">
    <table>
        <thead><tr><th>#</th><th>Transaction ID</th><th>Campaign</th><th>Amount</th><th>Anonymous</th><th>Date</th><th>Receipt</th></tr></thead>
        <tbody>
        <?php foreach ($donations as $i => $d): ?>
        <tr>
            <td><?php echo $i+1; ?></td>
            <td><code><?php echo htmlspecialchars($d['transaction_id']); ?></code></td>
            <td><?php echo htmlspecialchars($d['campaign_title']); ?></td>
            <td><strong><?php echo formatCurrency($d['amount']); ?></strong></td>
            <td><?php echo $d['is_anonymous'] ? 'Yes' : 'No'; ?></td>
            <td><?php echo formatDateTime($d['date']); ?></td>
            <td><a href="receipt.php?id=<?php echo $d['id']; ?>" class="btn btn-sm btn-outline">🧾 Receipt</a></td>
        </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php endif; ?>

<?php require_once '../../includes/admin-footer.php'; ?>
