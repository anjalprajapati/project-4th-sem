<?php
$pageTitle='Dog Form'; $requiredRole='admin';
require_once '../../includes/admin-header.php';
$id=(int)($_GET['id']??0);
$dog=$id?dbFetchOne("SELECT * FROM dogs WHERE id=?",[$id],'i'):null;
$isEdit=$dog?true:false;
?>
<div class="admin-page-header"><h1><?php echo $isEdit?'✏️ Edit':'➕ Add'; ?> Dog</h1><a href="dogs.php" class="btn btn-outline">← Back</a></div>
<div class="form-container wide">
    <form method="POST" action="dog-process.php" enctype="multipart/form-data" id="dogForm">
        <input type="hidden" name="action" value="<?php echo $isEdit?'update':'create'; ?>">
        <?php if($isEdit): ?><input type="hidden" name="id" value="<?php echo $id; ?>"><?php endif; ?>
        <div class="form-row">
            <div class="form-group" data-validate="required"><label>Name <span class="required">*</span></label><input type="text" name="name" value="<?php echo $isEdit?htmlspecialchars($dog['name']):''; ?>" required><div class="form-error"></div></div>
            <div class="form-group" data-validate="required"><label>Age <span class="required">*</span></label><input type="text" name="age" placeholder="e.g. 2 years" value="<?php echo $isEdit?htmlspecialchars($dog['age']):''; ?>" required><div class="form-error"></div></div>
        </div>
        <div class="form-row">
            <div class="form-group" data-validate="required"><label>Gender <span class="required">*</span></label><select name="gender" required><option value="male" <?php echo ($isEdit&&$dog['gender']==='male')?'selected':''; ?>>Male</option><option value="female" <?php echo ($isEdit&&$dog['gender']==='female')?'selected':''; ?>>Female</option></select><div class="form-error"></div></div>
            <div class="form-group" data-validate="required"><label>Breed <span class="required">*</span></label><input type="text" name="breed" value="<?php echo $isEdit?htmlspecialchars($dog['breed']):''; ?>" required><div class="form-error"></div></div>
        </div>
        <div class="form-row">
            <div class="form-group"><label>Health Status</label><select name="health_status">
                <?php foreach(['healthy','injured','under_treatment','critical'] as $s): ?><option value="<?php echo $s; ?>" <?php echo ($isEdit&&$dog['health_status']===$s)?'selected':''; ?>><?php echo formatStatus($s); ?></option><?php endforeach; ?>
            </select></div>
            <div class="form-group"><label>Vaccination Status</label><select name="vaccinated">
                <?php foreach(['vaccinated','not_vaccinated','partially_vaccinated'] as $s): ?><option value="<?php echo $s; ?>" <?php echo ($isEdit&&$dog['vaccinated']===$s)?'selected':''; ?>><?php echo formatStatus($s); ?></option><?php endforeach; ?>
            </select></div>
        </div>
        <div class="form-group"><label>Description</label><textarea name="description"><?php echo $isEdit?htmlspecialchars($dog['description']):''; ?></textarea></div>
        <div class="form-group"><label>Photo</label><input type="file" name="image" accept="image/*" data-preview="imgPreview">
            <div class="img-preview" id="imgPreview"><?php if($isEdit&&$dog['image']): ?><img src="../../uploads/dogs/<?php echo htmlspecialchars($dog['image']); ?>"><?php else: ?><span style="color:var(--text-secondary);">Image preview</span><?php endif; ?></div>
        </div>
        <div class="form-actions"><a href="dogs.php" class="btn btn-outline">Cancel</a><button type="submit" class="btn btn-primary"><?php echo $isEdit?'Update':'Add'; ?> Dog</button></div>
    </form><script>setupLiveValidation('dogForm');</script>
</div>
<?php require_once '../../includes/admin-footer.php'; ?>
