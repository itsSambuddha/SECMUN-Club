<?php
// functions.php – Authentication and registration logic based on new schema

require_once 'db_connect.php';

// Generate unique username
function generateUniqueUsername($pdo) {
    do {
        $username = 'user_' . bin2hex(random_bytes(3)); // e.g., user_a3f21c
        $stmt = $pdo->prepare("SELECT user_id FROM Users WHERE username = ?");
        $stmt->execute([$username]);
        $exists = $stmt->fetch();
    } while ($exists);
    return $username;
}

// Register a user (admin or normal based on office ENUM)
function registerUser($email, $password, $office, $name, $phone_number, $department, $class_roll_no, $pdo) {
    $stmt = $pdo->prepare("SELECT user_id FROM Users WHERE email = ?");
    $stmt->execute([$email]);
    if ($stmt->fetch()) {
        return ['success' => false, 'message' => 'Email already registered'];
    }

    $validOffices = [
        'President',
        'Secretary General',
        'Assistant Secretary General',
        'Teacher',
        'USG',
        'Junior Secretariat'
    ];

    if (!in_array($office, $validOffices)) {
        return ['success' => false, 'message' => 'Invalid office'];
    }

    $username = generateUniqueUsername($pdo);
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $pdo->prepare("
        INSERT INTO Users (username, email, password_hash, office, name, phone_number, department, class_roll_no)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)
    ");
    $stmt->execute([$username, $email, $hashedPassword, $office, $name, $phone_number, $department, $class_roll_no]);

    return ['success' => true, 'username' => $username];
}

// Login authentication
function loginUser($email, $password, $pdo) {
    $stmt = $pdo->prepare("SELECT * FROM Users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password_hash'])) {
        // Skip approval check for TopAdmin roles
        if ($user['role'] !== 'TopAdmin' && !$user['approved']) {
            return ['success' => false, 'message' => 'Account pending admin approval'];
        }

        session_regenerate_id(true);
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role']; // Auto-computed by SQL
        $_SESSION['user_role'] = $user['role']; // Added for dashboard_topadmin.php compatibility
        $_SESSION['office'] = $user['office'];
        $_SESSION['is_admin'] = in_array($user['role'], ['TopAdmin', 'MidAdmin']);
        return ['success' => true];
    }

    return ['success' => false, 'message' => 'Invalid credentials'];
}

// Role Check Helpers

function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function isTopAdmin() {
    return isset($_SESSION['role']) && $_SESSION['role'] === 'TopAdmin';
}

function isMidAdmin() {
    return isset($_SESSION['role']) && $_SESSION['role'] === 'MidAdmin';
}

function isUser() {
    return isset($_SESSION['role']) && $_SESSION['role'] === 'User';
}

function isAdmin() {
    return isTopAdmin() || isMidAdmin();
}

// Logout
function logout() {
    session_start();
    session_unset();
    session_destroy();
}
?>
