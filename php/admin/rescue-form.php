<?php
$pageTitle='Rescue Form'; $requiredRole='admin';
require_once '../../includes/admin-header.php';
$id=(int)($_GET['id']??0); $rescue=$id?dbFetchOne("SELECT * FROM rescues WHERE id=?",[$id],'i'):null; $isEdit=$rescue?true:false;
$dogs=dbFetchAll("SELECT id,name FROM dogs ORDER BY name");
?>
<div class="admin-page-header"><h1><?php echo $isEdit?'✏️ Edit':'➕ Add'; ?> Rescue</h1><a href="rescues.php" class="btn btn-outline">← Back</a></div>
<div class="form-container wide">
    <form method="POST" action="rescue-process.php" id="rescueForm">
        <input type="hidden" name="action" value="<?php echo $isEdit?'update':'create'; ?>">
        <?php if($isEdit): ?><input type="hidden" name="id" value="<?php echo $id; ?>"><?php endif; ?>
        <div class="form-group" data-validate="required"><label>Dog <span class="required">*</span></label>
            <select name="dog_id" required><?php foreach($dogs as $d): ?><option value="<?php echo $d['id']; ?>" <?php echo ($isEdit&&$rescue['dog_id']==$d['id'])?'selected':''; ?>><?php echo htmlspecialchars($d['name']); ?></option><?php endforeach; ?></select><div class="form-error"></div></div>
        <div class="form-row">
            <div class="form-group" data-validate="required"><label>Location <span class="required">*</span></label><input type="text" name="location" value="<?php echo $isEdit?htmlspecialchars($rescue['location']):''; ?>" required><div class="form-error"></div></div>
            <div class="form-group" data-validate="required"><label>Rescue Date <span class="required">*</span></label><input type="date" name="rescue_date" value="<?php echo $isEdit?$rescue['rescue_date']:''; ?>" required><div class="form-error"></div></div>
        </div>
        <div class="form-group"><label>Status</label><select name="status">
            <?php foreach(['rescued','under_treatment','recovered','adopted'] as $s): ?><option value="<?php echo $s; ?>" <?php echo ($isEdit&&$rescue['status']===$s)?'selected':''; ?>><?php echo formatStatus($s); ?></option><?php endforeach; ?>
        </select></div>
        <div class="form-group"><label>Notes</label><textarea name="notes"><?php echo $isEdit?htmlspecialchars($rescue['notes']):''; ?></textarea></div>
        <div class="form-actions"><a href="rescues.php" class="btn btn-outline">Cancel</a><button type="submit" class="btn btn-primary"><?php echo $isEdit?'Update':'Add'; ?> Rescue</button></div>
    </form><script>setupLiveValidation('rescueForm');</script>
</div>
<?php require_once '../../includes/admin-footer.php'; ?>
