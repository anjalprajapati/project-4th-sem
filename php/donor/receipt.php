<?php
/**
 * Donor Receipt Page
 */
$pageTitle = 'Donation Receipt';
require_once dirname(__DIR__) . '/functions.php';
requireRole('donor');

$id = (int)($_GET['id'] ?? 0);
$userId = $_SESSION['user_id'];

$d = dbFetchOne(
    "SELECT d.*, u.name AS donor_name, u.email AS donor_email, c.title AS campaign_title FROM donations d JOIN users u ON d.user_id=u.id JOIN campaigns c ON d.campaign_id=c.id WHERE d.id=? AND d.user_id=?",
    [$id, $userId], 'ii'
);

if (!$d) { redirect(SITE_URL . '/php/donor/donations.php', 'Receipt not found.', 'error'); }
$rootPath = '../../';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"><title>Receipt - <?php echo $d['transaction_id']; ?></title>
    <link rel="stylesheet" href="<?php echo $rootPath; ?>css/style.css">
    <link rel="stylesheet" href="<?php echo $rootPath; ?>css/forms.css">
</head>
<body style="background:var(--bg-light); padding:20px;">
    <div class="receipt">
        <div class="receipt-header">
            <h2>🐕 Street Dog Fundraising</h2>
            <p>Donation Receipt</p>
        </div>
        <div class="receipt-body">
            <div class="receipt-row"><span class="label">Receipt No.</span><span class="value"><?php echo htmlspecialchars($d['transaction_id']); ?></span></div>
            <div class="receipt-row"><span class="label">Donor Name</span><span class="value"><?php echo $d['is_anonymous'] ? 'Anonymous' : htmlspecialchars($d['donor_name']); ?></span></div>
            <div class="receipt-row"><span class="label">Email</span><span class="value"><?php echo htmlspecialchars($d['donor_email']); ?></span></div>
            <div class="receipt-row"><span class="label">Campaign</span><span class="value"><?php echo htmlspecialchars($d['campaign_title']); ?></span></div>
            <div class="receipt-row"><span class="label">Amount</span><span class="value" style="font-size:1.2rem; font-weight:700; color:var(--primary);"><?php echo formatCurrency($d['amount']); ?></span></div>
            <div class="receipt-row"><span class="label">Date</span><span class="value"><?php echo formatDateTime($d['date']); ?></span></div>
        </div>
        <div class="receipt-footer">
            <p>Thank you for your generous contribution!<br>Street Dog Fundraising and Support Management System</p>
        </div>
    </div>
    <div class="text-center mt-2" style="max-width:600px; margin:20px auto;">
        <button onclick="window.print()" class="btn btn-primary">🖨 Print Receipt</button>
        <a href="donations.php" class="btn btn-outline">← Back to History</a>
    </div>
</body>
</html>
