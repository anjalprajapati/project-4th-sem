<?php
$pageTitle = 'News & Updates';
require_once 'php/functions.php';
require_once 'includes/header.php';
$category = sanitize($_GET['category'] ?? '');
if ($category) {
    $updates = dbFetchAll("SELECT * FROM updates WHERE category = ? ORDER BY date DESC", [$category], 's');
} else {
    $updates = dbFetchAll("SELECT * FROM updates ORDER BY date DESC");
}
?>
<div class="page-header">
    <div class="container">
        <h1>News & Updates</h1>
        <p>Success stories, events, and awareness posts from our community</p>
        <div class="breadcrumb"><a href="index.php">Home</a> <span>/</span> <span>News</span></div>
    </div>
</div>

<section class="section">
    <div class="container">
        <div class="filter-bar mb-3">
            <a href="news.php" class="btn btn-sm <?php echo !$category?'btn-primary':'btn-outline'; ?>">All</a>
            <a href="?category=success_story" class="btn btn-sm <?php echo $category==='success_story'?'btn-primary':'btn-outline'; ?>">Success Stories</a>
            <a href="?category=event" class="btn btn-sm <?php echo $category==='event'?'btn-primary':'btn-outline'; ?>">Events</a>
            <a href="?category=awareness" class="btn btn-sm <?php echo $category==='awareness'?'btn-primary':'btn-outline'; ?>">Awareness</a>
        </div>

        <?php if (empty($updates)): ?>
            <div class="empty-state"><div class="icon">📰</div><h3>No updates found</h3><p>No news or updates have been posted yet.</p></div>
        <?php else: ?>
            <div class="grid grid-3">
                <?php foreach ($updates as $u): ?>
                <div class="card">
                    <?php if ($u['image']): ?>
                        <img src="uploads/updates/<?php echo htmlspecialchars($u['image']); ?>" alt="<?php echo htmlspecialchars($u['title']); ?>" class="card-img">
                    <?php else: ?>
                        <div class="card-img" style="background:linear-gradient(135deg, #FEF5E7, var(--warning)); display:flex; align-items:center; justify-content:center; font-size:3rem;">📰</div>
                    <?php endif; ?>
                    <div class="card-body">
                        <span class="badge <?php echo $u['category']==='success_story'?'badge-success':($u['category']==='event'?'badge-info':'badge-warning'); ?>"><?php echo formatStatus($u['category']); ?></span>
                        <h3 class="card-title mt-1"><?php echo htmlspecialchars($u['title']); ?></h3>
                        <p class="card-text"><?php echo nl2br(htmlspecialchars($u['description'])); ?></p>
                        <p style="font-size:0.82rem; color:var(--text-secondary); margin:0;">📅 <?php echo formatDate($u['date']); ?></p>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>
