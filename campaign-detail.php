<?php
require_once 'php/functions.php';
$id = (int)($_GET['id'] ?? 0);
if (!$id) { header('Location: campaigns.php'); exit(); }

$campaign = dbFetchOne("SELECT * FROM campaigns WHERE id = ? AND status != 'deleted'", [$id], 'i');
if (!$campaign) { header('Location: campaigns.php'); exit(); }

$pageTitle = $campaign['title'];
$recentDonations = dbFetchAll(
    "SELECT d.*, u.name AS donor_name FROM donations d JOIN users u ON d.user_id = u.id WHERE d.campaign_id = ? ORDER BY d.date DESC LIMIT 10",
    [$id], 'i'
);
require_once 'includes/header.php';
?>
<div class="page-header">
    <div class="container">
        <h1><?php echo htmlspecialchars($campaign['title']); ?></h1>
        <div class="breadcrumb"><a href="index.php">Home</a> <span>/</span> <a href="campaigns.php">Campaigns</a> <span>/</span> <span><?php echo htmlspecialchars($campaign['title']); ?></span></div>
    </div>
</div>

<section class="section">
    <div class="container">
        <div class="campaign-detail-grid">
            <div>
                <?php if ($campaign['image']): ?>
                    <img src="uploads/campaigns/<?php echo htmlspecialchars($campaign['image']); ?>" alt="<?php echo htmlspecialchars($campaign['title']); ?>" style="width:100%; border-radius:var(--radius); margin-bottom:24px;">
                <?php endif; ?>

                <div class="card" style="transform:none;">
                    <div class="card-body">
                        <h3>About This Campaign</h3>
                        <p><?php echo nl2br(htmlspecialchars($campaign['description'])); ?></p>
                    </div>
                </div>

                <?php if (!empty($recentDonations)): ?>
                <div class="card mt-3" style="transform:none;">
                    <div class="card-body">
                        <h3>Recent Supporters</h3>
                        <div class="table-wrapper" style="box-shadow:none;">
                            <table>
                                <thead><tr><th>Donor</th><th>Amount</th><th>Date</th></tr></thead>
                                <tbody>
                                <?php foreach ($recentDonations as $d): ?>
                                <tr>
                                    <td><?php echo $d['is_anonymous'] ? 'Anonymous' : htmlspecialchars($d['donor_name']); ?></td>
                                    <td><?php echo formatCurrency($d['amount']); ?></td>
                                    <td><?php echo formatDate($d['date']); ?></td>
                                </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            </div>

            <div class="campaign-sidebar">
                <div class="card" style="transform:none;">
                    <div class="card-body">
                        <h3 style="text-align:center; margin-bottom:20px;">Campaign Progress</h3>
                        <div style="text-align:center; margin-bottom:16px;">
                            <span style="font-size:2rem; font-weight:800; color:var(--primary);"><?php echo formatCurrency($campaign['current_amount']); ?></span>
                            <p style="margin:0; font-size:0.9rem;">raised of <?php echo formatCurrency($campaign['goal_amount']); ?> goal</p>
                        </div>
                        <div class="progress-bar" style="height:14px;">
                            <div class="progress-fill" data-width="<?php echo progressPercent($campaign['current_amount'], $campaign['goal_amount']); ?>" style="width:0%"></div>
                        </div>
                        <p class="text-center" style="font-size:0.9rem; margin-top:8px; font-weight:600;"><?php echo progressPercent($campaign['current_amount'], $campaign['goal_amount']); ?>% Complete</p>

                        <ul class="detail-list mt-2">
                            <li><span class="label">Status</span> <span class="badge <?php echo getStatusBadge($campaign['status']); ?>"><?php echo formatStatus($campaign['status']); ?></span></li>
                            <li><span class="label">Deadline</span> <span class="value"><?php echo formatDate($campaign['deadline']); ?></span></li>
                            <li><span class="label">Created</span> <span class="value"><?php echo formatDate($campaign['created_at']); ?></span></li>
                        </ul>

                        <?php if ($campaign['status'] === 'active'): ?>
                            <?php if (isLoggedIn() && getUserRole() === 'donor'): ?>
                                <a href="php/donor/donate.php?campaign_id=<?php echo $campaign['id']; ?>" class="btn btn-primary btn-block mt-3">💝 Donate Now</a>
                            <?php else: ?>
                                <a href="login.php" class="btn btn-primary btn-block mt-3">💝 Login to Donate</a>
                            <?php endif; ?>
                        <?php else: ?>
                            <button class="btn btn-secondary btn-block mt-3" disabled>Campaign <?php echo formatStatus($campaign['status']); ?></button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>
