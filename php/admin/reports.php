<?php
$pageTitle='Reports'; $requiredRole='admin';
require_once '../../includes/admin-header.php';

$reportType = $_GET['type'] ?? 'daily';
$dateFrom = $_GET['from'] ?? date('Y-m-d');
$dateTo = $_GET['to'] ?? date('Y-m-d');

// Determine date range
switch($reportType){
    case 'daily': $dateFrom=$dateTo=date('Y-m-d'); break;
    case 'weekly': $dateFrom=date('Y-m-d',strtotime('-7 days')); $dateTo=date('Y-m-d'); break;
    case 'monthly': $dateFrom=date('Y-m-01'); $dateTo=date('Y-m-t'); break;
    case 'annual': $dateFrom=date('Y-01-01'); $dateTo=date('Y-12-31'); break;
    case 'custom': break; // use provided dates
}

$donations = dbFetchAll("SELECT d.*, u.name AS donor_name, c.title AS campaign_title FROM donations d JOIN users u ON d.user_id=u.id JOIN campaigns c ON d.campaign_id=c.id WHERE DATE(d.date) BETWEEN ? AND ? ORDER BY d.date DESC",[$dateFrom,$dateTo],'ss');
$totalAmount = array_sum(array_column($donations,'amount'));
$rescueCount = dbFetchOne("SELECT COUNT(*) AS c FROM rescues WHERE rescue_date BETWEEN ? AND ?",[$dateFrom,$dateTo],'ss')['c'];
$adoptionCount = dbFetchOne("SELECT COUNT(*) AS c FROM adoptions WHERE DATE(created_at) BETWEEN ? AND ? AND status='approved'",[$dateFrom,$dateTo],'ss')['c'];
$taskCount = dbFetchOne("SELECT COUNT(*) AS c FROM tasks WHERE DATE(created_at) BETWEEN ? AND ? AND status='completed'",[$dateFrom,$dateTo],'ss')['c'];
?>

<div class="admin-page-header"><h1>📈 Reports</h1><button id="printReport" class="btn btn-outline">🖨 Print</button></div>

<div class="filter-bar">
    <a href="?type=daily" class="btn btn-sm <?php echo $reportType==='daily'?'btn-primary':'btn-outline'; ?>">Daily</a>
    <a href="?type=weekly" class="btn btn-sm <?php echo $reportType==='weekly'?'btn-primary':'btn-outline'; ?>">Weekly</a>
    <a href="?type=monthly" class="btn btn-sm <?php echo $reportType==='monthly'?'btn-primary':'btn-outline'; ?>">Monthly</a>
    <a href="?type=annual" class="btn btn-sm <?php echo $reportType==='annual'?'btn-primary':'btn-outline'; ?>">Annual</a>
    <form style="display:flex; gap:8px; align-items:center;" method="GET">
        <input type="hidden" name="type" value="custom">
        <input type="date" name="from" value="<?php echo $dateFrom; ?>">
        <span>to</span>
        <input type="date" name="to" value="<?php echo $dateTo; ?>">
        <button type="submit" class="btn btn-sm btn-primary">Filter</button>
    </form>
</div>

<p style="color:var(--text-secondary); margin-bottom:20px;">📅 Report Period: <strong><?php echo formatDate($dateFrom); ?></strong> to <strong><?php echo formatDate($dateTo); ?></strong></p>

<div class="stat-grid" style="grid-template-columns:repeat(4,1fr);">
    <div class="stat-card"><div class="stat-icon orange">💰</div><div class="stat-info"><h3><?php echo formatCurrency($totalAmount); ?></h3><p>Donations</p></div></div>
    <div class="stat-card"><div class="stat-icon red">🚑</div><div class="stat-info"><h3><?php echo $rescueCount; ?></h3><p>Rescues</p></div></div>
    <div class="stat-card"><div class="stat-icon green">🏠</div><div class="stat-info"><h3><?php echo $adoptionCount; ?></h3><p>Adoptions</p></div></div>
    <div class="stat-card"><div class="stat-icon blue">✅</div><div class="stat-info"><h3><?php echo $taskCount; ?></h3><p>Tasks Completed</p></div></div>
</div>

<div class="report-section">
    <h3>💰 Donation Details</h3>
    <?php if(empty($donations)): ?>
        <p style="color:var(--text-secondary);">No donations in this period.</p>
    <?php else: ?>
    <div class="table-wrapper" style="box-shadow:none;">
        <table>
            <thead><tr><th>Donor</th><th>Campaign</th><th>Amount</th><th>Date</th></tr></thead>
            <tbody>
            <?php foreach($donations as $d): ?>
            <tr>
                <td><?php echo $d['is_anonymous']?'Anonymous':htmlspecialchars($d['donor_name']); ?></td>
                <td><?php echo htmlspecialchars($d['campaign_title']); ?></td>
                <td><strong><?php echo formatCurrency($d['amount']); ?></strong></td>
                <td><?php echo formatDateTime($d['date']); ?></td>
            </tr>
            <?php endforeach; ?>
            <tr style="background:#f0f0f0; font-weight:700;"><td colspan="2">Total</td><td><?php echo formatCurrency($totalAmount); ?></td><td></td></tr>
            </tbody>
        </table>
    </div>
    <?php endif; ?>
</div>

<?php require_once '../../includes/admin-footer.php'; ?>
