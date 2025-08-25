<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: auth/login.php');
    exit();
}

// Check user role
function checkRole($requiredRole) {
    if ($_SESSION['role'] !== $requiredRole) {
        header('Location: index.php');
        exit();
    }
}

// Check if user has any of the required roles
function checkRoles($allowedRoles) {
    if (!in_array($_SESSION['role'], $allowedRoles)) {
        header('Location: index.php');
        exit();
    }
}
?>
