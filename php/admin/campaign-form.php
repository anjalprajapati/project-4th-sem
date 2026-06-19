<?php
$pageTitle = 'Campaign Form';
$requiredRole = 'admin';
require_once '../../includes/admin-header.php';
$id = (int)($_GET['id'] ?? 0);
$campaign = $id ? dbFetchOne("SELECT * FROM campaigns WHERE id=?", [$id], 'i') : null;
$isEdit = $campaign ? true : false;
?>
<div class="admin-page-header"><h1><?php echo $isEdit ? '✏️ Edit' : '➕ Add'; ?> Campaign</h1><a href="campaigns.php" class="btn btn-outline">← Back</a></div>
<div class="form-container wide">
    <form method="POST" action="campaign-process.php" enctype="multipart/form-data" id="campaignForm">
        <input type="hidden" name="action" value="<?php echo $isEdit ? 'update' : 'create'; ?>">
        <?php if ($isEdit): ?><input type="hidden" name="id" value="<?php echo $id; ?>"><?php endif; ?>
        <div class="form-group" data-validate="required|min:3">
            <label>Title <span class="required">*</span></label>
            <input type="text" name="title" value="<?php echo $isEdit ? htmlspecialchars($campaign['title']) : ''; ?>" required>
            <div class="form-error"></div>
        </div>
        <div class="form-group" data-validate="required|min:10">
            <label>Description <span class="required">*</span></label>
            <textarea name="description" required><?php echo $isEdit ? htmlspecialchars($campaign['description']) : ''; ?></textarea>
            <div class="form-error"></div>
        </div>
        <div class="form-row">
            <div class="form-group" data-validate="required|number|min_value:1">
                <label>Goal Amount (₹) <span class="required">*</span></label>
                <input type="number" name="goal_amount" step="0.01" min="1" value="<?php echo $isEdit ? $campaign['goal_amount'] : ''; ?>" required>
                <div class="form-error"></div>
            </div>
            <div class="form-group" data-validate="required">
                <label>Deadline <span class="required">*</span></label>
                <input type="date" name="deadline" value="<?php echo $isEdit ? $campaign['deadline'] : ''; ?>" required>
                <div class="form-error"></div>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label>Status</label>
                <select name="status">
                    <?php foreach(['active','completed','closed'] as $s): ?>
                    <option value="<?php echo $s; ?>" <?php echo ($isEdit && $campaign['status']===$s)?'selected':''; ?>><?php echo ucfirst($s); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <?php if ($isEdit): ?>
            <div class="form-group">
                <label>Current Amount (₹)</label>
                <input type="number" name="current_amount" step="0.01" value="<?php echo $campaign['current_amount']; ?>">
            </div>
            <?php endif; ?>
        </div>
        <div class="form-group">
            <label>Campaign Image</label>
            <input type="file" name="image" accept="image/*" data-preview="imgPreview">
            <div class="img-preview" id="imgPreview">
                <?php if ($isEdit && $campaign['image']): ?>
                    <img src="../../uploads/campaigns/<?php echo htmlspecialchars($campaign['image']); ?>" alt="Current">
                <?php else: ?>
                    <span style="color:var(--text-secondary);">Image preview</span>
                <?php endif; ?>
            </div>
        </div>
        <div class="form-actions">
            <a href="campaigns.php" class="btn btn-outline">Cancel</a>
            <button type="submit" class="btn btn-primary"><?php echo $isEdit ? 'Update' : 'Create'; ?> Campaign</button>
        </div>
    </form>
    <script>setupLiveValidation('campaignForm');</script>
</div>
<?php require_once '../../includes/admin-footer.php'; ?>
