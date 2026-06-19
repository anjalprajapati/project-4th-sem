<?php
/**
 * Donation Processing
 */
require_once dirname(__DIR__) . '/functions.php';
requireRole('donor');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_SESSION['user_id'];
    $campaignId = (int)$_POST['campaign_id'];
    $amount = (float)$_POST['amount'];
    $isAnonymous = isset($_POST['is_anonymous']) ? 1 : 0;

    // Validate
    if (!$campaignId || $amount <= 0) {
        redirect(SITE_URL . '/php/donor/donate.php', 'Please select a campaign and enter a valid amount.', 'error');
    }

    // Check campaign exists and is active
    $campaign = dbFetchOne("SELECT * FROM campaigns WHERE id=? AND status='active'", [$campaignId], 'i');
    if (!$campaign) {
        redirect(SITE_URL . '/php/donor/donate.php', 'Campaign not found or not active.', 'error');
    }

    // Generate transaction ID
    $transactionId = generateTransactionId();

    // Insert donation
    dbExecute(
        "INSERT INTO donations (user_id, campaign_id, amount, transaction_id, is_anonymous) VALUES (?, ?, ?, ?, ?)",
        [$userId, $campaignId, $amount, $transactionId, $isAnonymous],
        'iidsi'
    );

    // Update campaign current_amount
    dbExecute(
        "UPDATE campaigns SET current_amount = current_amount + ? WHERE id = ?",
        [$amount, $campaignId],
        'di'
    );

    // Check if campaign goal reached
    $updated = dbFetchOne("SELECT current_amount, goal_amount FROM campaigns WHERE id=?", [$campaignId], 'i');
    if ($updated && $updated['current_amount'] >= $updated['goal_amount']) {
        dbExecute("UPDATE campaigns SET status='completed' WHERE id=?", [$campaignId], 'i');
    }

    $donationId = dbLastId();
    redirect(SITE_URL . '/php/donor/receipt.php?id=' . $donationId, 'Thank you for your generous donation of ' . formatCurrency($amount) . '!');
} else {
    redirect(SITE_URL . '/php/donor/donate.php');
}
