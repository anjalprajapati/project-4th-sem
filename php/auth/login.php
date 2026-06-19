<?php
/**
 * Login Processing
 */
require_once dirname(__DIR__) . '/functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = sanitize($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($email) || empty($password)) {
        redirect(SITE_URL . '/login.php', 'Please fill in all fields.', 'error');
    }

    $user = dbFetchOne("SELECT * FROM users WHERE email = ? AND status = 'active'", [$email], 's');

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['name'] = $user['name'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['role'] = $user['role'];
        session_regenerate_id(true);

        switch ($user['role']) {
            case 'admin':
                redirect(SITE_URL . '/php/admin/dashboard.php', 'Welcome back, ' . $user['name'] . '!');
                break;
            case 'donor':
                redirect(SITE_URL . '/php/donor/dashboard.php', 'Welcome back, ' . $user['name'] . '!');
                break;
            case 'volunteer':
                redirect(SITE_URL . '/php/volunteer/dashboard.php', 'Welcome back, ' . $user['name'] . '!');
                break;
            default:
                redirect(SITE_URL . '/login.php', 'Invalid role.', 'error');
        }
    } else {
        redirect(SITE_URL . '/login.php', 'Invalid email or password.', 'error');
    }
} else {
    redirect(SITE_URL . '/login.php');
}
