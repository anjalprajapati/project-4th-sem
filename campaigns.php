<?php
$pageTitle = 'Campaigns';
require_once 'php/functions.php';
require_once 'includes/header.php';

$status = sanitize($_GET['status'] ?? 'active');
$campaigns = dbFetchAll("SELECT * FROM campaigns WHERE status = ? ORDER BY created_at DESC", [$status], 's');
?>
<div class="page-header">
    <div class="container">
        <h1>Fundraising Campaigns</h1>
        <p>Support our campaigns and help us save more lives</p>
        <div class="breadcrumb"><a href="index.php">Home</a> <span>/</span> <span>Campaigns</span></div>
    </div>
</div>

<section class="section">
    <div class="container">
        <div class="filter-bar mb-3">
            <a href="?status=active" class="btn btn-sm <?php echo $status==='active'?'btn-primary':'btn-outline'; ?>">Active</a>
            <a href="?status=completed" class="btn btn-sm <?php echo $status==='completed'?'btn-primary':'btn-outline'; ?>">Completed</a>
            <a href="?status=closed" class="btn btn-sm <?php echo $status==='closed'?'btn-primary':'btn-outline'; ?>">Closed</a>
        </div>

        <?php if (empty($campaigns)): ?>
            <div class="empty-state">
                <div class="icon">📢</div>
                <h3>No campaigns found</h3>
                <p>There are no <?php echo htmlspecialchars($status); ?> campaigns at the moment. Check back soon!</p>
            </div>
        <?php else: ?>
            <div class="grid grid-3">
                <?php foreach ($campaigns as $c): ?>
                <div class="card">
                    <?php if ($c['image']): ?>
                        <img src="uploads/campaigns/<?php echo htmlspecialchars($c['image']); ?>" alt="<?php echo htmlspecialchars($c['title']); ?>" class="card-img">
                    <?php else: ?>
                        <div class="card-img" style="background:linear-gradient(135deg, var(--primary-light), var(--primary)); display:flex; align-items:center; justify-content:center; font-size:3rem;">📢</div>
                    <?php endif; ?>
                    <div class="card-body">
                        <span class="badge <?php echo getStatusBadge($c['status']); ?>"><?php echo formatStatus($c['status']); ?></span>
                        <h3 class="card-title mt-1"><?php echo htmlspecialchars($c['title']); ?></h3>
                        <p class="card-text"><?php echo truncateText(htmlspecialchars($c['description']), 120); ?></p>
                        <div class="progress-bar">
                            <div class="progress-fill" data-width="<?php echo progressPercent($c['current_amount'], $c['goal_amount']); ?>" style="width:0%"></div>
                        </div>
                        <div class="progress-text">
                            <span><?php echo formatCurrency($c['current_amount']); ?></span>
                            <span>of <?php echo formatCurrency($c['goal_amount']); ?></span>
                        </div>
                        <p style="font-size:0.82rem; color:var(--text-secondary); margin-top:8px;">⏰ Deadline: <?php echo formatDate($c['deadline']); ?></p>
                    </div>
                    <div class="card-footer">
                        <span style="font-size:0.9rem; font-weight:700; color:var(--primary);"><?php echo progressPercent($c['current_amount'], $c['goal_amount']); ?>% funded</span>
                        <a href="campaign-detail.php?id=<?php echo $c['id']; ?>" class="btn btn-sm btn-primary">View & Donate</a>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>
