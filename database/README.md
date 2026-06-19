# Street Dog Fundraising — Database Setup

## Prerequisites
- MySQL 8.x (or MariaDB 10.x)
- PHP 8.x with MySQLi extension
- Apache web server (XAMPP/WAMP recommended)

## Setup Instructions

### Step 1: Create the Database and Tables
Open phpMyAdmin or MySQL command line and run:

```sql
source schema.sql
```

Or import `schema.sql` through phpMyAdmin:
1. Open phpMyAdmin (http://localhost/phpmyadmin)
2. Click "Import" tab
3. Choose `schema.sql` file
4. Click "Go"

### Step 2: Load Sample Data (Optional)
```sql
source seed.sql
```

Or import `seed.sql` through phpMyAdmin the same way.

### Step 3: Update Configuration
Edit `php/config.php` and update these values if needed:
- `DB_HOST` — Default: `localhost`
- `DB_USER` — Default: `root`
- `DB_PASS` — Default: `''` (empty)
- `DB_NAME` — Default: `street_dog_db`
- `SITE_URL` — Update to match your local setup

## Test Accounts (from seed data)

| Role       | Email                  | Password   |
|-----------|------------------------|------------|
| Admin     | admin@streetdogs.org   | Admin@123  |
| Donor     | rahul@example.com      | Admin@123  |
| Donor     | priya@example.com      | Admin@123  |
| Volunteer | sneha@example.com      | Admin@123  |
| Volunteer | vikram@example.com     | Admin@123  |

> **Note:** The seed file uses a placeholder hash. For the login to work, you need to
> generate the actual hash. Run this PHP script once to create a proper admin:
>
> ```php
> // Run in browser: http://localhost/project%204th%20sem/setup.php
> <?php
> require_once 'php/config.php';
> $hash = password_hash('Admin@123', PASSWORD_DEFAULT);
> $conn->query("UPDATE users SET password = '$hash'");
> echo "All passwords updated to: Admin@123";
> ?>
> ```
