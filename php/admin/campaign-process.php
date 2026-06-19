<?php
require_once dirname(__DIR__) . '/functions.php';
requireRole('admin');

$action = $_POST['action'] ?? $_GET['action'] ?? '';

if ($action === 'create' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = sanitize($_POST['title']);
    $description = sanitize($_POST['description']);
    $goal = (float)$_POST['goal_amount'];
    $deadline = sanitize($_POST['deadline']);
    $status = sanitize($_POST['status'] ?? 'active');
    $image = null;
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $result = uploadFile($_FILES['image'], 'campaigns');
        if ($result['success']) $image = $result['filename'];
    }
    dbExecute("INSERT INTO campaigns (title,description,goal_amount,deadline,image,status) VALUES (?,?,?,?,?,?)", [$title,$description,$goal,$deadline,$image,$status], 'ssdsss');
    redirect(SITE_URL . '/php/admin/campaigns.php', 'Campaign created successfully!');

} elseif ($action === 'update' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = (int)$_POST['id'];
    $title = sanitize($_POST['title']);
    $description = sanitize($_POST['description']);
    $goal = (float)$_POST['goal_amount'];
    $current = (float)($_POST['current_amount'] ?? 0);
    $deadline = sanitize($_POST['deadline']);
    $status = sanitize($_POST['status'] ?? 'active');
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $result = uploadFile($_FILES['image'], 'campaigns');
        if ($result['success']) {
            dbExecute("UPDATE campaigns SET title=?,description=?,goal_amount=?,current_amount=?,deadline=?,image=?,status=? WHERE id=?", [$title,$description,$goal,$current,$deadline,$result['filename'],$status,$id], 'ssddsssi');
        }
    } else {
        dbExecute("UPDATE campaigns SET title=?,description=?,goal_amount=?,current_amount=?,deadline=?,status=? WHERE id=?", [$title,$description,$goal,$current,$deadline,$status,$id], 'ssddssi');
    }
    redirect(SITE_URL . '/php/admin/campaigns.php', 'Campaign updated successfully!');

} elseif ($action === 'delete') {
    $id = (int)$_GET['id'];
    dbExecute("UPDATE campaigns SET status='deleted' WHERE id=?", [$id], 'i');
    redirect(SITE_URL . '/php/admin/campaigns.php', 'Campaign deleted.');
} else {
    redirect(SITE_URL . '/php/admin/campaigns.php');
}
