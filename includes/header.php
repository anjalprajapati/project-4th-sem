<?php
/**
 * Public Header Include
 */
if (session_status() === PHP_SESSION_NONE) session_start();
$basePath = rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'])), '/');
// Detect if we are in a subfolder
$depth = substr_count(str_replace('\\','/', $_SERVER['SCRIPT_NAME']), '/') - 1;
$rootPath = '';
// Simple root path detection
if (strpos($_SERVER['SCRIPT_NAME'], '/php/') !== false || strpos($_SERVER['SCRIPT_NAME'], '/admin/') !== false || strpos($_SERVER['SCRIPT_NAME'], '/donor/') !== false || strpos($_SERVER['SCRIPT_NAME'], '/volunteer/') !== false) {
    // We're inside a php subfolder
    $scriptDir = dirname($_SERVER['SCRIPT_NAME']);
    $projectRoot = dirname(dirname($scriptDir));
    if (strpos($scriptDir, '/php/admin') !== false || strpos($scriptDir, '/php/donor') !== false || strpos($scriptDir, '/php/volunteer') !== false || strpos($scriptDir, '/php/auth') !== false) {
        $rootPath = '../../';
    } else {
        $rootPath = '../';
    }
} else {
    $rootPath = '';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Street Dog Fundraising and Support Management System - Help rescue, treat, and rehome street dogs.">
    <title><?php echo isset($pageTitle) ? htmlspecialchars($pageTitle) . ' | ' : ''; ?>Street Dog Fundraising</title>
    <link rel="stylesheet" href="<?php echo $rootPath; ?>css/style.css">
    <link rel="stylesheet" href="<?php echo $rootPath; ?>css/forms.css">
    <link rel="stylesheet" href="<?php echo $rootPath; ?>css/responsive.css">
</head>
<body>
    <header class="header">
        <div class="container">
            <a href="<?php echo $rootPath; ?>index.php" class="logo">
                <span>🐕</span> Street Dog Fundraising
            </a>
            <button class="hamburger" id="hamburger">☰</button>
            <nav class="nav" id="mainNav">
                <a href="<?php echo $rootPath; ?>index.php">Home</a>
                <a href="<?php echo $rootPath; ?>about.php">About</a>
                <a href="<?php echo $rootPath; ?>campaigns.php">Campaigns</a>
                <a href="<?php echo $rootPath; ?>dogs.php">Dogs</a>
                <a href="<?php echo $rootPath; ?>news.php">News</a>
                <a href="<?php echo $rootPath; ?>contact.php">Contact</a>
                <div class="nav-auth">
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <?php
                        $dashUrl = $rootPath . 'php/' . $_SESSION['role'] . '/dashboard.php';
                        if ($_SESSION['role'] === 'admin') $dashUrl = $rootPath . 'php/admin/dashboard.php';
                        ?>
                        <a href="<?php echo $dashUrl; ?>" class="btn btn-sm btn-primary">Dashboard</a>
                        <a href="<?php echo $rootPath; ?>php/auth/logout.php" class="btn btn-sm btn-outline">Logout</a>
                    <?php else: ?>
                        <a href="<?php echo $rootPath; ?>login.php" class="btn btn-sm btn-outline">Login</a>
                        <a href="<?php echo $rootPath; ?>register.php" class="btn btn-sm btn-primary">Register</a>
                    <?php endif; ?>
                </div>
            </nav>
        </div>
    </header>
    <main>
    <?php
    $successMsg = isset($_SESSION['success']) ? $_SESSION['success'] : '';
    $errorMsg = isset($_SESSION['error']) ? $_SESSION['error'] : '';
    if ($successMsg) { unset($_SESSION['success']); }
    if ($errorMsg) { unset($_SESSION['error']); }
    ?>
    <?php if ($successMsg): ?>
        <div class="container mt-2"><div class="alert alert-success">✓ <?php echo htmlspecialchars($successMsg); ?></div></div>
    <?php endif; ?>
    <?php if ($errorMsg): ?>
        <div class="container mt-2"><div class="alert alert-error">✕ <?php echo htmlspecialchars($errorMsg); ?></div></div>
    <?php endif; ?>
