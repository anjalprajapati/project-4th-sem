<?php
$pageTitle='Task Form'; $requiredRole='admin';
require_once '../../includes/admin-header.php';
$id=(int)($_GET['id']??0); $task=$id?dbFetchOne("SELECT * FROM tasks WHERE id=?",[$id],'i'):null; $isEdit=$task?true:false;
$volunteers=dbFetchAll("SELECT v.id, u.name FROM volunteers v JOIN users u ON v.user_id=u.id ORDER BY u.name");
?>
<div class="admin-page-header"><h1><?php echo $isEdit?'✏️ Edit':'➕ Assign'; ?> Task</h1><a href="tasks.php" class="btn btn-outline">← Back</a></div>
<div class="form-container wide">
    <form method="POST" action="task-process.php" id="taskForm">
        <input type="hidden" name="action" value="<?php echo $isEdit?'update':'create'; ?>">
        <?php if($isEdit): ?><input type="hidden" name="id" value="<?php echo $id; ?>"><?php endif; ?>
        <div class="form-group" data-validate="required"><label>Title <span class="required">*</span></label><input type="text" name="title" value="<?php echo $isEdit?htmlspecialchars($task['title']):''; ?>" required><div class="form-error"></div></div>
        <div class="form-group"><label>Description</label><textarea name="description"><?php echo $isEdit?htmlspecialchars($task['description']):''; ?></textarea></div>
        <div class="form-row">
            <div class="form-group" data-validate="required"><label>Volunteer <span class="required">*</span></label>
                <select name="volunteer_id" required><?php foreach($volunteers as $v): ?><option value="<?php echo $v['id']; ?>" <?php echo ($isEdit&&$task['volunteer_id']==$v['id'])?'selected':''; ?>><?php echo htmlspecialchars($v['name']); ?></option><?php endforeach; ?></select><div class="form-error"></div></div>
            <div class="form-group" data-validate="required"><label>Category <span class="required">*</span></label>
                <select name="category" required><?php foreach(['feeding','rescue','transportation','medical_support'] as $c): ?><option value="<?php echo $c; ?>" <?php echo ($isEdit&&$task['category']===$c)?'selected':''; ?>><?php echo formatStatus($c); ?></option><?php endforeach; ?></select><div class="form-error"></div></div>
        </div>
        <div class="form-row">
            <div class="form-group"><label>Status</label><select name="status">
                <?php foreach(['pending','in_progress','completed','cancelled'] as $s): ?><option value="<?php echo $s; ?>" <?php echo ($isEdit&&$task['status']===$s)?'selected':''; ?>><?php echo formatStatus($s); ?></option><?php endforeach; ?>
            </select></div>
            <div class="form-group"><label>Deadline</label><input type="date" name="deadline" value="<?php echo $isEdit?$task['deadline']:''; ?>"></div>
        </div>
        <div class="form-actions"><a href="tasks.php" class="btn btn-outline">Cancel</a><button type="submit" class="btn btn-primary"><?php echo $isEdit?'Update':'Assign'; ?> Task</button></div>
    </form><script>setupLiveValidation('taskForm');</script>
</div>
<?php require_once '../../includes/admin-footer.php'; ?>
