<?php
require_once dirname(__DIR__) . '/functions.php'; requireRole('admin');
$action=$_POST['action']??$_GET['action']??'';
if ($action==='create'&&$_SERVER['REQUEST_METHOD']==='POST') {
    $title=sanitize($_POST['title']); $desc=sanitize($_POST['description']); $cat=sanitize($_POST['category']); $image=null;
    if(isset($_FILES['image'])&&$_FILES['image']['error']===UPLOAD_ERR_OK){$r=uploadFile($_FILES['image'],'updates');if($r['success'])$image=$r['filename'];}
    dbExecute("INSERT INTO updates (title,description,category,image) VALUES (?,?,?,?)",[$title,$desc,$cat,$image],'ssss');
    redirect(SITE_URL.'/php/admin/updates.php','Update published!');
} elseif ($action==='update'&&$_SERVER['REQUEST_METHOD']==='POST') {
    $id=(int)$_POST['id']; $title=sanitize($_POST['title']); $desc=sanitize($_POST['description']); $cat=sanitize($_POST['category']);
    if(isset($_FILES['image'])&&$_FILES['image']['error']===UPLOAD_ERR_OK){$r=uploadFile($_FILES['image'],'updates');if($r['success'])dbExecute("UPDATE updates SET title=?,description=?,category=?,image=? WHERE id=?",[$title,$desc,$cat,$r['filename'],$id],'ssssi');}
    else{dbExecute("UPDATE updates SET title=?,description=?,category=? WHERE id=?",[$title,$desc,$cat,$id],'sssi');}
    redirect(SITE_URL.'/php/admin/updates.php','Update modified!');
} elseif ($action==='delete') {
    dbExecute("DELETE FROM updates WHERE id=?",[(int)$_GET['id']],'i');
    redirect(SITE_URL.'/php/admin/updates.php','Update deleted.');
} else { redirect(SITE_URL.'/php/admin/updates.php'); }
