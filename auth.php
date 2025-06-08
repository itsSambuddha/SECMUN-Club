<?php
session_start();

// Redirect to login if user not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login_signup.php?mode=login");
    exit();
}

// Role hierarchy based on database ENUM values
$role_hierarchy = [
    'User' => 1,
    'MidAdmin' => 2,     // Assistant Secretary General, Teacher
    'TopAdmin' => 3      // President, Secretary General
];

// Use this variable in any protected page before including auth.php
// Example: $min_required_role = 'MidAdmin';
if (isset($min_required_role)) {
    $user_role = $_SESSION['role'] ?? 'User';
    if ($role_hierarchy[$user_role] < $role_hierarchy[$min_required_role]) {
        echo "Access denied. Insufficient permissions.";
        exit();
    }
}
?>
