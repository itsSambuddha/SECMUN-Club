-- Create the target database if it does not exist and use it
CREATE DATABASE IF NOT EXISTS SEC_MUN_DB;
USE SEC_MUN_DB;

-- Table for storing all user and admin information
CREATE TABLE IF NOT EXISTS Users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    phone_number VARCHAR(20) NOT NULL,
    department VARCHAR(100),
    class_roll_no VARCHAR(20),
    office ENUM('President', 'Secretary General', 'Assistant Secretary General', 'Teacher', 'USG', 'Junior Secretariat') NOT NULL,
    username VARCHAR(50) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    role ENUM('TopAdmin', 'MidAdmin', 'User') GENERATED ALWAYS AS (
        CASE 
            WHEN office IN ('President', 'Secretary General') THEN 'TopAdmin'
            WHEN office IN ('Assistant Secretary General', 'Teacher') THEN 'MidAdmin'
            ELSE 'User'
        END
    ) STORED,
    approved BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    expiry_date TIMESTAMP GENERATED ALWAYS AS (created_at + INTERVAL 1 YEAR) STORED,
    INDEX idx_office (office)
);

-- Table to track login history
CREATE TABLE IF NOT EXISTS LoginHistory (
    login_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    login_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES Users(user_id) ON DELETE CASCADE,
    INDEX idx_user_id (user_id)
);

-- Table for events
CREATE TABLE IF NOT EXISTS Events (
    event_id INT AUTO_INCREMENT PRIMARY KEY,
    event_name VARCHAR(100) NOT NULL,
    description TEXT,
    event_date DATE,
    created_by INT,
    FOREIGN KEY (created_by) REFERENCES Users(user_id) ON DELETE SET NULL,
    INDEX idx_created_by (created_by)
);

-- Table for budgeting per event
CREATE TABLE IF NOT EXISTS MonetaryDepartments (
    budget_id INT AUTO_INCREMENT PRIMARY KEY,
    event_id INT,
    department_name VARCHAR(100) NOT NULL,
    item_name VARCHAR(100),
    estimated_cost DECIMAL(10, 2),
    actual_cost DECIMAL(10, 2),
    added_by INT,
    FOREIGN KEY (event_id) REFERENCES Events(event_id) ON DELETE CASCADE,
    FOREIGN KEY (added_by) REFERENCES Users(user_id) ON DELETE SET NULL,
    INDEX idx_event_id (event_id),
    INDEX idx_added_by (added_by)
);

-- Table for delegate allotments
CREATE TABLE IF NOT EXISTS DelegateAllotments (
    allotment_id INT AUTO_INCREMENT PRIMARY KEY,
    delegate_name VARCHAR(100),
    country_allotted VARCHAR(100),
    committee VARCHAR(100),
    criteria_matched TEXT,
    uploaded_by INT,
    spreadsheet_url VARCHAR(255),
    view_otp VARCHAR(6),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (uploaded_by) REFERENCES Users(user_id) ON DELETE SET NULL,
    INDEX idx_uploaded_by (uploaded_by)
);

-- Table for internal messages
CREATE TABLE IF NOT EXISTS Messages (
    message_id INT AUTO_INCREMENT PRIMARY KEY,
    sender_id INT,
    receiver_id INT,
    subject VARCHAR(255),
    body TEXT,
    sent_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (sender_id) REFERENCES Users(user_id) ON DELETE CASCADE,
    FOREIGN KEY (receiver_id) REFERENCES Users(user_id) ON DELETE CASCADE,
    INDEX idx_sender_id (sender_id),
    INDEX idx_receiver_id (receiver_id)
);

-- Table for meeting summaries
CREATE TABLE IF NOT EXISTS MeetingSummaries (
    summary_id INT AUTO_INCREMENT PRIMARY KEY,
    meeting_title VARCHAR(255),
    summary TEXT,
    meeting_date DATE,
    uploaded_by INT,
    FOREIGN KEY (uploaded_by) REFERENCES Users(user_id) ON DELETE SET NULL,
    INDEX idx_uploaded_by (uploaded_by)
);

-- Table for learning resources
CREATE TABLE IF NOT EXISTS LearningResources (
    resource_id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255),
    description TEXT,
    file_url VARCHAR(255),
    uploaded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Admin approval workflow
CREATE TABLE IF NOT EXISTS AdminApprovals (
    approval_id INT AUTO_INCREMENT PRIMARY KEY,
    requester_id INT,
    approver_id INT,
    status ENUM('Pending', 'Approved', 'Rejected') DEFAULT 'Pending',
    requested_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (requester_id) REFERENCES Users(user_id),
    FOREIGN KEY (approver_id) REFERENCES Users(user_id),
    INDEX idx_requester_id (requester_id),
    INDEX idx_approver_id (approver_id)
);