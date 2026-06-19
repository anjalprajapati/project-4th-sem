<?php
$pageTitle = 'Our Dogs';
require_once 'php/functions.php';
require_once 'includes/header.php';
$dogs = dbFetchAll("SELECT * FROM dogs ORDER BY created_at DESC");
?>
<div class="page-header">
    <div class="container">
        <h1>Our Rescued Dogs</h1>
        <p>Meet the dogs we've rescued and those looking for a forever home</p>
        <div class="breadcrumb"><a href="index.php">Home</a> <span>/</span> <span>Dogs</span></div>
    </div>
</div>

<section class="section">
    <div class="container">
        <div class="search-bar mb-3">
            <input type="text" id="tableSearch" placeholder="Search dogs by name, breed, status...">
        </div>

        <?php if (empty($dogs)): ?>
            <div class="empty-state"><div class="icon">🐕</div><h3>No dogs found</h3><p>No rescued dogs have been added yet.</p></div>
        <?php else: ?>
            <div class="grid grid-3" id="dogsGrid">
                <?php foreach ($dogs as $dog): ?>
                <div class="card dog-card" data-search="<?php echo strtolower($dog['name'] . ' ' . $dog['breed'] . ' ' . $dog['health_status'] . ' ' . $dog['vaccinated']); ?>">
                    <?php if ($dog['image']): ?>
                        <img src="uploads/dogs/<?php echo htmlspecialchars($dog['image']); ?>" alt="<?php echo htmlspecialchars($dog['name']); ?>" class="card-img">
                    <?php else: ?>
                        <div class="card-img" style="background:linear-gradient(135deg, #D5F5E3, var(--secondary)); display:flex; align-items:center; justify-content:center; font-size:3rem;">🐕</div>
                    <?php endif; ?>
                    <div class="card-body">
                        <h3 class="card-title">🐕 <?php echo htmlspecialchars($dog['name']); ?></h3>
                        <p class="card-text"><?php echo htmlspecialchars($dog['breed']); ?> · <?php echo htmlspecialchars($dog['age']); ?> · <?php echo formatStatus($dog['gender']); ?></p>
                        <div style="display:flex; gap:6px; flex-wrap:wrap;">
                            <span class="badge <?php echo getStatusBadge($dog['health_status']); ?>"><?php echo formatStatus($dog['health_status']); ?></span>
                            <span class="badge <?php echo getStatusBadge($dog['vaccinated']); ?>"><?php echo formatStatus($dog['vaccinated']); ?></span>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="dog-detail.php?id=<?php echo $dog['id']; ?>" class="btn btn-sm btn-outline">View Profile</a>
                        <a href="dog-detail.php?id=<?php echo $dog['id']; ?>#adopt" class="btn btn-sm btn-secondary">Adopt</a>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>

<script>
document.getElementById('tableSearch').addEventListener('input', function(){
    var q = this.value.toLowerCase();
    document.querySelectorAll('.dog-card').forEach(function(card){
        card.style.display = card.getAttribute('data-search').includes(q) ? '' : 'none';
    });
});
</script>

<?php require_once 'includes/footer.php'; ?>
