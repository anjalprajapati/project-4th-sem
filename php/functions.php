<?php
/**
 * Utility Functions
 * Street Dog Fundraising and Support Management System
 */

require_once __DIR__ . '/config.php';

/* ============================================================
 * SECURITY FUNCTIONS
 * ============================================================ */

/**
 * Sanitize user input
 */
function sanitize($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    return $data;
}

/**
 * Validate CSRF token
 */
function validateCSRF($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

/**
 * Get CSRF token field for forms
 */
function csrfField() {
    return '<input type="hidden" name="csrf_token" value="' . $_SESSION['csrf_token'] . '">';
}

/**
 * Check if user is logged in
 */
function isLoggedIn() {
    return isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
}

/**
 * Get current user role
 */
function getUserRole() {
    return $_SESSION['role'] ?? '';
}

/**
 * Require login - redirect to login page if not logged in
 */
function requireLogin() {
    if (!isLoggedIn()) {
        $_SESSION['error'] = 'Please login to access this page.';
        header('Location: ' . SITE_URL . '/login.php');
        exit();
    }
}

/**
 * Require specific role
 */
function requireRole($role) {
    requireLogin();
    if (getUserRole() !== $role) {
        $_SESSION['error'] = 'You do not have permission to access this page.';
        header('Location: ' . SITE_URL . '/login.php');
        exit();
    }
}

/**
 * Redirect with message
 */
function redirect($url, $message = '', $type = 'success') {
    if (!empty($message)) {
        $_SESSION[$type] = $message;
    }
    header('Location: ' . $url);
    exit();
}

/* ============================================================
 * DATABASE HELPER FUNCTIONS
 * ============================================================ */

/**
 * Execute a query and return result
 */
function dbQuery($sql, $params = [], $types = '') {
    global $conn;
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
    }
    if (!empty($params)) {
        $stmt->bind_param($types, ...$params);
    }
    $stmt->execute();
    return $stmt;
}

/**
 * Fetch all rows from a query
 */
function dbFetchAll($sql, $params = [], $types = '') {
    $stmt = dbQuery($sql, $params, $types);
    $result = $stmt->get_result();
    $rows = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
    return $rows;
}

/**
 * Fetch single row
 */
function dbFetchOne($sql, $params = [], $types = '') {
    $stmt = dbQuery($sql, $params, $types);
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $stmt->close();
    return $row;
}

/**
 * Execute insert/update/delete and return affected rows
 */
function dbExecute($sql, $params = [], $types = '') {
    $stmt = dbQuery($sql, $params, $types);
    $affected = $stmt->affected_rows;
    $stmt->close();
    return $affected;
}

/**
 * Get last insert ID
 */
function dbLastId() {
    global $conn;
    return $conn->insert_id;
}

/* ============================================================
 * DASHBOARD STATISTICS
 * ============================================================ */

function getTotalDonations() {
    $row = dbFetchOne("SELECT COALESCE(SUM(amount), 0) AS total FROM donations");
    return $row['total'];
}

function getTotalDonors() {
    $row = dbFetchOne("SELECT COUNT(DISTINCT user_id) AS total FROM donations");
    return $row['total'];
}

function getTotalDogs() {
    $row = dbFetchOne("SELECT COUNT(*) AS total FROM dogs");
    return $row['total'];
}

function getActiveCampaigns() {
    $row = dbFetchOne("SELECT COUNT(*) AS total FROM campaigns WHERE status = 'active'");
    return $row['total'];
}

function getTotalVolunteers() {
    $row = dbFetchOne("SELECT COUNT(*) AS total FROM volunteers");
    return $row['total'];
}

function getTotalAdoptions() {
    $row = dbFetchOne("SELECT COUNT(*) AS total FROM adoptions WHERE status = 'approved'");
    return $row['total'];
}

function getTotalRescues() {
    $row = dbFetchOne("SELECT COUNT(*) AS total FROM rescues");
    return $row['total'];
}

/* ============================================================
 * UTILITY FUNCTIONS
 * ============================================================ */

/**
 * Format currency
 */
function formatCurrency($amount) {
    return '₹' . number_format($amount, 2);
}

/**
 * Format date
 */
function formatDate($date) {
    return date('d M Y', strtotime($date));
}

/**
 * Format datetime
 */
function formatDateTime($date) {
    return date('d M Y, h:i A', strtotime($date));
}

/**
 * Generate unique transaction ID
 */
function generateTransactionId() {
    return 'TXN' . date('Ymd') . strtoupper(substr(md5(uniqid()), 0, 6));
}

/**
 * Handle file upload
 */
function uploadFile($file, $directory) {
    $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    $maxSize = 2 * 1024 * 1024; // 2MB

    if ($file['error'] !== UPLOAD_ERR_OK) {
        return ['success' => false, 'message' => 'File upload error.'];
    }

    if ($file['size'] > $maxSize) {
        return ['success' => false, 'message' => 'File size exceeds 2MB limit.'];
    }

    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    if (!in_array($ext, $allowed)) {
        return ['success' => false, 'message' => 'Invalid file type. Allowed: jpg, jpeg, png, gif, webp'];
    }

    $uploadDir = UPLOAD_PATH . $directory . '/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    $filename = uniqid() . '_' . time() . '.' . $ext;
    $filepath = $uploadDir . $filename;

    if (move_uploaded_file($file['tmp_name'], $filepath)) {
        return ['success' => true, 'filename' => $filename];
    }

    return ['success' => false, 'message' => 'Failed to save file.'];
}

/**
 * Get status badge class
 */
function getStatusBadge($status) {
    $badges = [
        'active' => 'badge-success',
        'completed' => 'badge-info',
        'closed' => 'badge-secondary',
        'deleted' => 'badge-danger',
        'rescued' => 'badge-warning',
        'under_treatment' => 'badge-warning',
        'recovered' => 'badge-success',
        'adopted' => 'badge-info',
        'pending' => 'badge-warning',
        'in_progress' => 'badge-info',
        'cancelled' => 'badge-danger',
        'approved' => 'badge-success',
        'rejected' => 'badge-danger',
        'available' => 'badge-success',
        'busy' => 'badge-warning',
        'on_leave' => 'badge-secondary',
        'healthy' => 'badge-success',
        'injured' => 'badge-danger',
        'critical' => 'badge-danger',
        'vaccinated' => 'badge-success',
        'not_vaccinated' => 'badge-danger',
        'partially_vaccinated' => 'badge-warning',
    ];
    return $badges[$status] ?? 'badge-secondary';
}

/**
 * Format status for display
 */
function formatStatus($status) {
    return ucwords(str_replace('_', ' ', $status));
}

/**
 * Get flash message and clear it
 */
function getFlashMessage($type) {
    if (isset($_SESSION[$type])) {
        $msg = $_SESSION[$type];
        unset($_SESSION[$type]);
        return $msg;
    }
    return '';
}

/**
 * Calculate progress percentage
 */
function progressPercent($current, $goal) {
    if ($goal <= 0) return 0;
    $pct = ($current / $goal) * 100;
    return min(100, round($pct));
}

/**
 * Truncate text
 */
function truncateText($text, $length = 100) {
    if (strlen($text) <= $length) return $text;
    return substr($text, 0, $length) . '...';
}

/**
 * Paginate results
 */
function paginate($totalItems, $perPage = 10, $currentPage = 1) {
    $totalPages = max(1, ceil($totalItems / $perPage));
    $currentPage = max(1, min($totalPages, (int)$currentPage));
    $offset = ($currentPage - 1) * $perPage;
    return [
        'total' => $totalItems,
        'per_page' => $perPage,
        'current' => $currentPage,
        'total_pages' => $totalPages,
        'offset' => $offset
    ];
}
