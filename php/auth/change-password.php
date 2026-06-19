<?php
/**
 * Change Password Processing
 */
require_once dirname(__DIR__) . '/functions.php';
requireLogin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $currentPassword = $_POST['current_password'] ?? '';
    $newPassword = $_POST['new_password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';
    $userId = $_SESSION['user_id'];

    $user = dbFetchOne("SELECT password FROM users WHERE id = ?", [$userId], 'i');

    if (!$user || !password_verify($currentPassword, $user['password'])) {
        $role = $_SESSION['role'];
        redirect(SITE_URL . "/php/$role/change-password.php", 'Current password is incorrect.', 'error');
    }

    if (strlen($newPassword) < 8) {
        $role = $_SESSION['role'];
        redirect(SITE_URL . "/php/$role/change-password.php", 'New password must be at least 8 characters.', 'error');
    }

    if ($newPassword !== $confirmPassword) {
        $role = $_SESSION['role'];
        redirect(SITE_URL . "/php/$role/change-password.php", 'New passwords do not match.', 'error');
    }

    $hashed = password_hash($newPassword, PASSWORD_DEFAULT);
    dbExecute("UPDATE users SET password = ? WHERE id = ?", [$hashed, $userId], 'si');

    $role = $_SESSION['role'];
    redirect(SITE_URL . "/php/$role/change-password.php", 'Password changed successfully!');
} else {
    header('Location: ../../login.php');
    exit();
}
