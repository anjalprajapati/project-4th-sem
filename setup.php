<?php
/**
 * One-time Setup Script
 * Run this in your browser after importing schema.sql and seed.sql
 * URL: http://localhost/project%204th%20sem/setup.php
 */
require_once 'php/config.php';

echo "<h2>Street Dog Fundraising - Setup Script</h2>";

// Set all passwords to plain text
$result = $conn->query("UPDATE users SET password = '" . $conn->real_escape_string('Admin@123') . "'");

if ($result) {
    echo "<p style='color:green;'>✅ All user passwords updated successfully!</p>";
    echo "<p>Default password for all accounts: <strong>Admin@123</strong></p>";
} else {
    echo "<p style='color:red;'>❌ Error updating passwords: " . $conn->error . "</p>";
}

// Create upload directories
$dirs = ['uploads/campaigns', 'uploads/dogs', 'uploads/updates'];
foreach ($dirs as $dir) {
    $path = __DIR__ . '/' . $dir;
    if (!is_dir($path)) {
        mkdir($path, 0755, true);
        echo "<p>📁 Created directory: $dir</p>";
    } else {
        echo "<p>📁 Directory exists: $dir</p>";
    }
}

echo "<hr>";
echo "<h3>Test Accounts:</h3>";
echo "<table border='1' cellpadding='8' cellspacing='0'>";
echo "<tr><th>Role</th><th>Email</th><th>Password</th></tr>";
echo "<tr><td>Admin</td><td>admin@streetdogs.org</td><td>Admin@123</td></tr>";
echo "<tr><td>Donor</td><td>rahul@example.com</td><td>Admin@123</td></tr>";
echo "<tr><td>Donor</td><td>priya@example.com</td><td>Admin@123</td></tr>";
echo "<tr><td>Volunteer</td><td>sneha@example.com</td><td>Admin@123</td></tr>";
echo "<tr><td>Volunteer</td><td>vikram@example.com</td><td>Admin@123</td></tr>";
echo "</table>";

echo "<br><p><a href='index.php'>→ Go to Homepage</a> | <a href='login.php'>→ Go to Login</a></p>";
echo "<br><p style='color:orange;'><strong>⚠️ Delete this file (setup.php) after running it!</strong></p>";
