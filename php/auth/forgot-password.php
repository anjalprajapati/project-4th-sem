<?php
/**
 * Forgot Password Processing
 */
require_once dirname(__DIR__) . '/functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $step = $_POST['step'] ?? '1';

    if ($step === '1') {
        // Step 1: verify email and show security question
        $email = sanitize($_POST['email'] ?? '');
        $user = dbFetchOne("SELECT id, security_question FROM users WHERE email = ? AND status = 'active'", [$email], 's');

        if ($user && !empty($user['security_question'])) {
            $_SESSION['reset_user_id'] = $user['id'];
            $_SESSION['reset_question'] = $user['security_question'];
            redirect(SITE_URL . '/forgot-password.php?step=2');
        } else {
            redirect(SITE_URL . '/forgot-password.php', 'No account found with that email or no security question set.', 'error');
        }

    } elseif ($step === '2') {
        // Step 2: verify answer and reset password
        $answer = $_POST['security_answer'] ?? '';
        $newPassword = $_POST['new_password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';
        $userId = $_SESSION['reset_user_id'] ?? 0;

        if (!$userId) {
            redirect(SITE_URL . '/forgot-password.php', 'Session expired. Please start over.', 'error');
        }

        $user = dbFetchOne("SELECT security_answer FROM users WHERE id = ?", [$userId], 'i');

        if (!$user || $answer !== $user['security_answer']) {
            redirect(SITE_URL . '/forgot-password.php?step=2', 'Incorrect security answer.', 'error');
        }

        if (strlen($newPassword) < 8) {
            redirect(SITE_URL . '/forgot-password.php?step=2', 'Password must be at least 8 characters.', 'error');
        }

        if ($newPassword !== $confirmPassword) {
            redirect(SITE_URL . '/forgot-password.php?step=2', 'Passwords do not match.', 'error');
        }

        dbExecute("UPDATE users SET password = ? WHERE id = ?", [$newPassword, $userId], 'si');

        unset($_SESSION['reset_user_id']);
        unset($_SESSION['reset_question']);

        redirect(SITE_URL . '/login.php', 'Password reset successful! Please login with your new password.');
    }
} else {
    redirect(SITE_URL . '/forgot-password.php');
}
