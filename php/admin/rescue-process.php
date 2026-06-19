<?php
require_once dirname(__DIR__) . '/functions.php'; requireRole('admin');
$action=$_POST['action']??$_GET['action']??'';
if ($action==='create'&&$_SERVER['REQUEST_METHOD']==='POST') {
    dbExecute("INSERT INTO rescues (dog_id,location,rescue_date,status,notes) VALUES (?,?,?,?,?)",[(int)$_POST['dog_id'],sanitize($_POST['location']),sanitize($_POST['rescue_date']),sanitize($_POST['status']),sanitize($_POST['notes'])],'issss');
    redirect(SITE_URL.'/php/admin/rescues.php','Rescue record added!');
} elseif ($action==='update'&&$_SERVER['REQUEST_METHOD']==='POST') {
    dbExecute("UPDATE rescues SET dog_id=?,location=?,rescue_date=?,status=?,notes=? WHERE id=?",[(int)$_POST['dog_id'],sanitize($_POST['location']),sanitize($_POST['rescue_date']),sanitize($_POST['status']),sanitize($_POST['notes']),(int)$_POST['id']],'issssi');
    redirect(SITE_URL.'/php/admin/rescues.php','Rescue record updated!');
} elseif ($action==='delete') {
    dbExecute("DELETE FROM rescues WHERE id=?",[(int)$_GET['id']],'i');
    redirect(SITE_URL.'/php/admin/rescues.php','Rescue record deleted.');
} else { redirect(SITE_URL.'/php/admin/rescues.php'); }
