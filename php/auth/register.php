<?php
/**
 * Registration Processing
 */
require_once dirname(__DIR__) . '/functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = sanitize($_POST['name'] ?? '');
    $email = sanitize($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';
    $role = sanitize($_POST['role'] ?? 'donor');
    $phone = sanitize($_POST['phone'] ?? '');
    $securityQuestion = sanitize($_POST['security_question'] ?? '');
    $securityAnswer = sanitize($_POST['security_answer'] ?? '');

    // Validation
    $errors = [];
    if (empty($name) || strlen($name) < 2) $errors[] = 'Name must be at least 2 characters.';
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Valid email is required.';
    if (strlen($password) < 8) $errors[] = 'Password must be at least 8 characters.';
    if ($password !== $confirmPassword) $errors[] = 'Passwords do not match.';
    if (!in_array($role, ['donor', 'volunteer'])) $errors[] = 'Invalid role selected.';
    if ($role === 'volunteer' && empty($phone)) $errors[] = 'Phone number is required for volunteers.';

    // Check if email exists
    $existing = dbFetchOne("SELECT id FROM users WHERE email = ?", [$email], 's');
    if ($existing) $errors[] = 'Email address is already registered.';

    if (!empty($errors)) {
        redirect(SITE_URL . '/register.php', implode(' ', $errors), 'error');
    }

    // Hash password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insert user
    dbExecute(
        "INSERT INTO users (name, email, password, role, security_question, security_answer) VALUES (?, ?, ?, ?, ?, ?)",
        [$name, $email, $hashedPassword, $role, $securityQuestion, password_hash($securityAnswer, PASSWORD_DEFAULT)],
        'ssssss'
    );

    $userId = dbLastId();

    // If volunteer, create volunteer record
    if ($role === 'volunteer') {
        dbExecute(
            "INSERT INTO volunteers (user_id, phone) VALUES (?, ?)",
            [$userId, $phone],
            'is'
        );
    }

    redirect(SITE_URL . '/login.php', 'Registration successful! Please login.');
} else {
    redirect(SITE_URL . '/register.php');
}
