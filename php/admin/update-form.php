<?php
$pageTitle='Update Form'; $requiredRole='admin';
require_once '../../includes/admin-header.php';
$id=(int)($_GET['id']??0); $update=$id?dbFetchOne("SELECT * FROM updates WHERE id=?",[$id],'i'):null; $isEdit=$update?true:false;
?>
<div class="admin-page-header"><h1><?php echo $isEdit?'✏️ Edit':'➕ Add'; ?> Update</h1><a href="updates.php" class="btn btn-outline">← Back</a></div>
<div class="form-container wide">
    <form method="POST" action="update-process.php" enctype="multipart/form-data" id="updateForm">
        <input type="hidden" name="action" value="<?php echo $isEdit?'update':'create'; ?>">
        <?php if($isEdit): ?><input type="hidden" name="id" value="<?php echo $id; ?>"><?php endif; ?>
        <div class="form-group" data-validate="required|min:3"><label>Title <span class="required">*</span></label><input type="text" name="title" value="<?php echo $isEdit?htmlspecialchars($update['title']):''; ?>" required><div class="form-error"></div></div>
        <div class="form-group" data-validate="required|min:10"><label>Description <span class="required">*</span></label><textarea name="description" required><?php echo $isEdit?htmlspecialchars($update['description']):''; ?></textarea><div class="form-error"></div></div>
        <div class="form-group"><label>Category</label><select name="category">
            <?php foreach(['success_story','event','awareness'] as $c): ?><option value="<?php echo $c; ?>" <?php echo ($isEdit&&$update['category']===$c)?'selected':''; ?>><?php echo formatStatus($c); ?></option><?php endforeach; ?>
        </select></div>
        <div class="form-group"><label>Image</label><input type="file" name="image" accept="image/*" data-preview="imgPreview">
            <div class="img-preview" id="imgPreview"><?php if($isEdit&&$update['image']): ?><img src="../../uploads/updates/<?php echo htmlspecialchars($update['image']); ?>"><?php else: ?><span style="color:var(--text-secondary);">Image preview</span><?php endif; ?></div>
        </div>
        <div class="form-actions"><a href="updates.php" class="btn btn-outline">Cancel</a><button type="submit" class="btn btn-primary"><?php echo $isEdit?'Update':'Publish'; ?></button></div>
    </form><script>setupLiveValidation('updateForm');</script>
</div>
<?php require_once '../../includes/admin-footer.php'; ?>
