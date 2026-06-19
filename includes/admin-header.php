<?php
/**
 * Admin Header Include (with Sidebar)
 */
require_once dirname(__DIR__) . '/php/functions.php';
requireRole($requiredRole ?? 'admin');

$rootPath = '../../';
$currentPage = basename($_SERVER['SCRIPT_NAME'], '.php');
$userName = $_SESSION['name'] ?? 'User';
$userRole = $_SESSION['role'] ?? 'admin';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($pageTitle) ? htmlspecialchars($pageTitle) . ' | ' : ''; ?>Admin Panel</title>
    <link rel="stylesheet" href="<?php echo $rootPath; ?>css/style.css">
    <link rel="stylesheet" href="<?php echo $rootPath; ?>css/admin.css">
    <link rel="stylesheet" href="<?php echo $rootPath; ?>css/forms.css">
    <link rel="stylesheet" href="<?php echo $rootPath; ?>css/responsive.css">
</head>
<body>
    <header class="header">
        <div class="container">
            <div class="flex gap-2" style="align-items:center;">
                <button class="sidebar-toggle" id="sidebarToggle">☰</button>
                <a href="<?php echo $rootPath; ?>index.php" class="logo">
                    <span>🐕</span> Street Dog Fundraising
                </a>
            </div>
            <div class="nav-auth">
                <span style="font-size:0.9rem; color:var(--text-secondary);">Welcome, <strong><?php echo htmlspecialchars($userName); ?></strong></span>
                <a href="<?php echo $rootPath; ?>php/auth/logout.php" class="btn btn-sm btn-outline">Logout</a>
            </div>
        </div>
    </header>

    <div class="admin-layout">
        <!-- Sidebar Overlay -->
        <div class="sidebar-overlay" id="sidebarOverlay"></div>

        <!-- Sidebar -->
        <aside class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <h3><?php echo htmlspecialchars($userName); ?></h3>
                <p><?php echo formatStatus($userRole); ?> Panel</p>
            </div>
            <nav class="sidebar-nav">
                <?php if ($userRole === 'admin'): ?>
                <a href="dashboard.php" class="<?php echo $currentPage==='dashboard'?'active':''; ?>"><span class="icon">📊</span> Dashboard</a>
                <a href="campaigns.php" class="<?php echo $currentPage==='campaigns'||$currentPage==='campaign-form'?'active':''; ?>"><span class="icon">📢</span> Campaigns</a>
                <a href="donations.php" class="<?php echo $currentPage==='donations'?'active':''; ?>"><span class="icon">💰</span> Donations</a>
                <a href="dogs.php" class="<?php echo $currentPage==='dogs'||$currentPage==='dog-form'?'active':''; ?>"><span class="icon">🐕</span> Dogs</a>
                <a href="rescues.php" class="<?php echo $currentPage==='rescues'||$currentPage==='rescue-form'?'active':''; ?>"><span class="icon">🚑</span> Rescues</a>
                <a href="volunteers.php" class="<?php echo $currentPage==='volunteers'?'active':''; ?>"><span class="icon">🤝</span> Volunteers</a>
                <a href="tasks.php" class="<?php echo $currentPage==='tasks'||$currentPage==='task-form'?'active':''; ?>"><span class="icon">📋</span> Tasks</a>
                <a href="adoptions.php" class="<?php echo $currentPage==='adoptions'?'active':''; ?>"><span class="icon">🏠</span> Adoptions</a>
                <a href="updates.php" class="<?php echo $currentPage==='updates'||$currentPage==='update-form'?'active':''; ?>"><span class="icon">📰</span> News & Updates</a>
                <a href="users.php" class="<?php echo $currentPage==='users'?'active':''; ?>"><span class="icon">👥</span> Users</a>
                <a href="reports.php" class="<?php echo $currentPage==='reports'?'active':''; ?>"><span class="icon">📈</span> Reports</a>
                <?php elseif ($userRole === 'donor'): ?>
                <a href="dashboard.php" class="<?php echo $currentPage==='dashboard'?'active':''; ?>"><span class="icon">📊</span> Dashboard</a>
                <a href="donations.php" class="<?php echo $currentPage==='donations'?'active':''; ?>"><span class="icon">💰</span> My Donations</a>
                <a href="profile.php" class="<?php echo $currentPage==='profile'?'active':''; ?>"><span class="icon">👤</span> Profile</a>
                <a href="change-password.php" class="<?php echo $currentPage==='change-password'?'active':''; ?>"><span class="icon">🔒</span> Change Password</a>
                <?php elseif ($userRole === 'volunteer'): ?>
                <a href="dashboard.php" class="<?php echo $currentPage==='dashboard'?'active':''; ?>"><span class="icon">📊</span> Dashboard</a>
                <a href="tasks.php" class="<?php echo $currentPage==='tasks'?'active':''; ?>"><span class="icon">📋</span> My Tasks</a>
                <a href="rescues.php" class="<?php echo $currentPage==='rescues'?'active':''; ?>"><span class="icon">🚑</span> Rescues</a>
                <a href="profile.php" class="<?php echo $currentPage==='profile'?'active':''; ?>"><span class="icon">👤</span> Profile</a>
                <a href="change-password.php" class="<?php echo $currentPage==='change-password'?'active':''; ?>"><span class="icon">🔒</span> Change Password</a>
                <?php endif; ?>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="admin-content">
        <?php
        $successMsg = isset($_SESSION['success']) ? $_SESSION['success'] : '';
        $errorMsg = isset($_SESSION['error']) ? $_SESSION['error'] : '';
        if ($successMsg) unset($_SESSION['success']);
        if ($errorMsg) unset($_SESSION['error']);
        ?>
        <?php if ($successMsg): ?>
            <div class="alert alert-success">✓ <?php echo htmlspecialchars($successMsg); ?></div>
        <?php endif; ?>
        <?php if ($errorMsg): ?>
            <div class="alert alert-error">✕ <?php echo htmlspecialchars($errorMsg); ?></div>
        <?php endif; ?>
