-- ============================================================
-- Street Dog Fundraising and Support Management System
-- Database Schema
-- ============================================================

CREATE DATABASE IF NOT EXISTS street_dog_db;
USE street_dog_db;

-- ============================================================
-- Table: users
-- ============================================================
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'donor', 'volunteer') NOT NULL DEFAULT 'donor',
    status ENUM('active', 'inactive') NOT NULL DEFAULT 'active',
    security_question VARCHAR(255) DEFAULT NULL,
    security_answer VARCHAR(255) DEFAULT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_email (email),
    INDEX idx_role (role)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================================
-- Table: campaigns
-- ============================================================
CREATE TABLE campaigns (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(200) NOT NULL,
    description TEXT NOT NULL,
    goal_amount DECIMAL(12, 2) NOT NULL,
    current_amount DECIMAL(12, 2) NOT NULL DEFAULT 0.00,
    deadline DATE NOT NULL,
    image VARCHAR(255) DEFAULT NULL,
    status ENUM('active', 'completed', 'closed', 'deleted') NOT NULL DEFAULT 'active',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_status (status),
    INDEX idx_deadline (deadline)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================================
-- Table: donations
-- ============================================================
CREATE TABLE donations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    campaign_id INT NOT NULL,
    amount DECIMAL(12, 2) NOT NULL,
    transaction_id VARCHAR(50) NOT NULL UNIQUE,
    is_anonymous TINYINT(1) NOT NULL DEFAULT 0,
    date DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (campaign_id) REFERENCES campaigns(id) ON DELETE CASCADE,
    INDEX idx_user (user_id),
    INDEX idx_campaign (campaign_id),
    INDEX idx_date (date)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================================
-- Table: dogs
-- ============================================================
CREATE TABLE dogs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    age VARCHAR(30) NOT NULL,
    gender ENUM('male', 'female') NOT NULL,
    breed VARCHAR(100) NOT NULL,
    health_status ENUM('healthy', 'injured', 'under_treatment', 'critical') NOT NULL DEFAULT 'healthy',
    vaccinated ENUM('vaccinated', 'not_vaccinated', 'partially_vaccinated') NOT NULL DEFAULT 'not_vaccinated',
    image VARCHAR(255) DEFAULT NULL,
    description TEXT DEFAULT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_health (health_status),
    INDEX idx_vaccinated (vaccinated)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================================
-- Table: rescues
-- ============================================================
CREATE TABLE rescues (
    id INT AUTO_INCREMENT PRIMARY KEY,
    dog_id INT NOT NULL,
    location VARCHAR(200) NOT NULL,
    rescue_date DATE NOT NULL,
    status ENUM('rescued', 'under_treatment', 'recovered', 'adopted') NOT NULL DEFAULT 'rescued',
    notes TEXT DEFAULT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (dog_id) REFERENCES dogs(id) ON DELETE CASCADE,
    INDEX idx_dog (dog_id),
    INDEX idx_status (status),
    INDEX idx_date (rescue_date)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================================
-- Table: volunteers
-- ============================================================
CREATE TABLE volunteers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL UNIQUE,
    phone VARCHAR(15) NOT NULL,
    availability ENUM('available', 'busy', 'on_leave') NOT NULL DEFAULT 'available',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_user (user_id),
    INDEX idx_availability (availability)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================================
-- Table: tasks
-- ============================================================
CREATE TABLE tasks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    volunteer_id INT NOT NULL,
    title VARCHAR(200) NOT NULL,
    description TEXT DEFAULT NULL,
    category ENUM('feeding', 'rescue', 'transportation', 'medical_support') NOT NULL,
    status ENUM('pending', 'in_progress', 'completed', 'cancelled') NOT NULL DEFAULT 'pending',
    deadline DATE DEFAULT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (volunteer_id) REFERENCES volunteers(id) ON DELETE CASCADE,
    INDEX idx_volunteer (volunteer_id),
    INDEX idx_status (status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================================
-- Table: adoptions
-- ============================================================
CREATE TABLE adoptions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    dog_id INT NOT NULL,
    adopter_name VARCHAR(100) NOT NULL,
    phone VARCHAR(15) NOT NULL,
    email VARCHAR(150) DEFAULT NULL,
    address TEXT DEFAULT NULL,
    reason TEXT DEFAULT NULL,
    status ENUM('pending', 'approved', 'rejected') NOT NULL DEFAULT 'pending',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (dog_id) REFERENCES dogs(id) ON DELETE CASCADE,
    INDEX idx_dog (dog_id),
    INDEX idx_status (status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================================
-- Table: updates (news/stories)
-- ============================================================
CREATE TABLE updates (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(200) NOT NULL,
    description TEXT NOT NULL,
    image VARCHAR(255) DEFAULT NULL,
    category ENUM('success_story', 'event', 'awareness') NOT NULL DEFAULT 'awareness',
    date DATETIME DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_category (category),
    INDEX idx_date (date)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================================
-- Table: contact_messages
-- ============================================================
CREATE TABLE contact_messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL,
    subject VARCHAR(200) NOT NULL,
    message TEXT NOT NULL,
    is_read TINYINT(1) DEFAULT 0,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
