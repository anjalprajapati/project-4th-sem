<?php
require_once dirname(__DIR__) . '/functions.php';
$action=$_POST['action']??$_GET['action']??'';

if ($action==='apply'&&$_SERVER['REQUEST_METHOD']==='POST') {
    $dogId=(int)$_POST['dog_id']; $name=sanitize($_POST['adopter_name']); $phone=sanitize($_POST['phone']);
    $email=sanitize($_POST['email']); $address=sanitize($_POST['address']); $reason=sanitize($_POST['reason']);
    dbExecute("INSERT INTO adoptions (dog_id,adopter_name,phone,email,address,reason) VALUES (?,?,?,?,?,?)",[$dogId,$name,$phone,$email,$address,$reason],'isssss');
    redirect(SITE_URL.'/dog-detail.php?id='.$dogId,'Adoption application submitted successfully! We will review it soon.');
} elseif ($action==='approve') {
    requireRole('admin');
    $id=(int)$_GET['id'];
    $adoption = dbFetchOne("SELECT dog_id FROM adoptions WHERE id=?",[$id],'i');
    dbExecute("UPDATE adoptions SET status='approved' WHERE id=?",[$id],'i');
    if($adoption) {
        dbExecute("UPDATE rescues SET status='adopted' WHERE dog_id=?",[$adoption['dog_id']],'i');
    }
    redirect(SITE_URL.'/php/admin/adoptions.php','Adoption approved!');
} elseif ($action==='reject') {
    requireRole('admin');
    dbExecute("UPDATE adoptions SET status='rejected' WHERE id=?",[(int)$_GET['id']],'i');
    redirect(SITE_URL.'/php/admin/adoptions.php','Adoption rejected.');
} else { redirect(SITE_URL.'/php/admin/adoptions.php'); }
