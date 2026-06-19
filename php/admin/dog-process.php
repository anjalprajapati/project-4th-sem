<?php
require_once dirname(__DIR__) . '/functions.php';
requireRole('admin');
$action = $_POST['action'] ?? $_GET['action'] ?? '';

if ($action === 'create' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $name=sanitize($_POST['name']); $age=sanitize($_POST['age']); $gender=sanitize($_POST['gender']);
    $breed=sanitize($_POST['breed']); $health=sanitize($_POST['health_status']); $vacc=sanitize($_POST['vaccinated']);
    $desc=sanitize($_POST['description']); $image=null;
    if (isset($_FILES['image']) && $_FILES['image']['error']===UPLOAD_ERR_OK) { $r=uploadFile($_FILES['image'],'dogs'); if($r['success']) $image=$r['filename']; }
    dbExecute("INSERT INTO dogs (name,age,gender,breed,health_status,vaccinated,image,description) VALUES (?,?,?,?,?,?,?,?)",[$name,$age,$gender,$breed,$health,$vacc,$image,$desc],'ssssssss');
    redirect(SITE_URL.'/php/admin/dogs.php','Dog profile added!');
} elseif ($action === 'update' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $id=(int)$_POST['id']; $name=sanitize($_POST['name']); $age=sanitize($_POST['age']); $gender=sanitize($_POST['gender']);
    $breed=sanitize($_POST['breed']); $health=sanitize($_POST['health_status']); $vacc=sanitize($_POST['vaccinated']);
    $desc=sanitize($_POST['description']);
    if (isset($_FILES['image']) && $_FILES['image']['error']===UPLOAD_ERR_OK) { $r=uploadFile($_FILES['image'],'dogs'); if($r['success']) dbExecute("UPDATE dogs SET name=?,age=?,gender=?,breed=?,health_status=?,vaccinated=?,image=?,description=? WHERE id=?",[$name,$age,$gender,$breed,$health,$vacc,$r['filename'],$desc,$id],'ssssssssi'); }
    else { dbExecute("UPDATE dogs SET name=?,age=?,gender=?,breed=?,health_status=?,vaccinated=?,description=? WHERE id=?",[$name,$age,$gender,$breed,$health,$vacc,$desc,$id],'sssssssi'); }
    redirect(SITE_URL.'/php/admin/dogs.php','Dog profile updated!');
} elseif ($action === 'delete') {
    dbExecute("DELETE FROM dogs WHERE id=?",[(int)$_GET['id']],'i');
    redirect(SITE_URL.'/php/admin/dogs.php','Dog profile deleted.');
} else { redirect(SITE_URL.'/php/admin/dogs.php'); }
