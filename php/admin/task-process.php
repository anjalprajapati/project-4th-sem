<?php
require_once dirname(__DIR__) . '/functions.php'; requireRole('admin');
$action=$_POST['action']??$_GET['action']??'';
if ($action==='create'&&$_SERVER['REQUEST_METHOD']==='POST') {
    dbExecute("INSERT INTO tasks (volunteer_id,title,description,category,status,deadline) VALUES (?,?,?,?,?,?)",[(int)$_POST['volunteer_id'],sanitize($_POST['title']),sanitize($_POST['description']),sanitize($_POST['category']),sanitize($_POST['status']),sanitize($_POST['deadline'])],'isssss');
    redirect(SITE_URL.'/php/admin/tasks.php','Task assigned!');
} elseif ($action==='update'&&$_SERVER['REQUEST_METHOD']==='POST') {
    dbExecute("UPDATE tasks SET volunteer_id=?,title=?,description=?,category=?,status=?,deadline=? WHERE id=?",[(int)$_POST['volunteer_id'],sanitize($_POST['title']),sanitize($_POST['description']),sanitize($_POST['category']),sanitize($_POST['status']),sanitize($_POST['deadline']),(int)$_POST['id']],'isssssi');
    redirect(SITE_URL.'/php/admin/tasks.php','Task updated!');
} elseif ($action==='delete') {
    dbExecute("DELETE FROM tasks WHERE id=?",[(int)$_GET['id']],'i');
    redirect(SITE_URL.'/php/admin/tasks.php','Task deleted.');
} else { redirect(SITE_URL.'/php/admin/tasks.php'); }
