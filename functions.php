<?php
// functions.php – Authentication and registration logic based on new schema

require_once 'db_connect.php';

// Generate unique username
function generateUniqueUsername($pdo) {
    do {
        $username = 'user_' . bin2hex(random_bytes(3)); // e.g., user_a3f21c
        $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $exists = $stmt->fetch();
    } while ($exists);
    return $username;
}

function registerUser($email, $password, $office, $name, $phone_number, $department, $class_roll_no, $pdo) {
    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
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
        INSERT INTO users (username, email, password_hash, office, name, phone_number, department, class_roll_no)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)
    ");
    $stmt->execute([$username, $email, $hashedPassword, $office, $name, $phone_number, $department, $class_roll_no]);

    return ['success' => true, 'username' => $username];
}

// Login authentication
function loginUser($email, $password, $pdo) {
    if (empty($password)) {
        return ['success' => false, 'message' => 'Password is required'];
    }

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && isset($user['password_hash']) && $user['password_hash'] !== null && password_verify($password, $user['password_hash'])) {
        // Skip approval check for TopAdmin roles (case-insensitive)
        $topAdminRoles = ['president', 'secretary general', 'topadmin'];
        $userRoleLower = strtolower(trim($user['role'] ?? ''));

        if (!in_array($userRoleLower, $topAdminRoles) && (!isset($user['fee_structure_access']) || $user['fee_structure_access'] == 0)) {
            return ['success' => false, 'message' => 'Account pending admin approval'];
        }

        session_regenerate_id(true);
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role']; // Using 'role' as role
        $_SESSION['user_role'] = $user['role']; // For dashboard compatibility
        $_SESSION['office'] = $user['office']; // Using 'office' column
        $_SESSION['is_admin'] = ($user['is_admin'] == 1);

        // Debug output for session variables
        echo '<pre>Session variables after login: ';
        print_r($_SESSION);
        echo '</pre>';

        return ['success' => true];
    }

    return ['success' => false, 'message' => 'Invalid credentials'];
}

// Role Check Helpers

function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function isTopAdmin() {
    return isset($_SESSION['role']) && $_SESSION['role'] === 'President';
}

function isMidAdmin() {
    return isset($_SESSION['role']) && in_array($_SESSION['role'], ['Assistant Secretary General', 'Teacher']);
}

function isUser() {
    return isset($_SESSION['role']) && !isAdmin();
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
